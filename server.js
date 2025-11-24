const express = require('express');
const path = require('path');
const app = express();

// Servir archivos estáticos desde el directorio raíz
app.use(express.static(path.join(__dirname)));

// Ruta principal
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'splash-loading.html'));
});

// Ruta específica para el login
app.get('/index-inicio-sesion.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'index-inicio-sesion.html'));
});

// Usar puerto 3001
const PORT = 3001;
app.listen(PORT, () => {
    console.log(`Servidor corriendo en http://localhost:${PORT}`);
    console.log(`Accede al login: http://localhost:${PORT}/index-inicio-sesion.html`);
});

const QRCode = require('qrcode');
const fs = require('fs');

// Crear carpeta para QR codes si no existe
const qrCodesDir = path.join(__dirname, 'qr-codes');
if (!fs.existsSync(qrCodesDir)) {
    fs.mkdirSync(qrCodesDir);
}

// Ruta para generar QR de permiso
app.post('/generar-qr-permiso', async (req, res) => {
    try {
        const { aprendizId, nombre, motivo, fecha, horaSalida, horaRegreso, comentarios } = req.body;
        
        // Datos que contendrá el QR
        const qrData = JSON.stringify({
            tipo: 'permiso',
            aprendizId: aprendizId,
            nombre: nombre,
            motivo: motivo,
            fecha: fecha,
            horaSalida: horaSalida,
            horaRegreso: horaRegreso,
            comentarios: comentarios,
            timestamp: Date.now(),
            valido: true
        });

        // Generar nombre único para el archivo QR
        const qrFileName = `permiso_${aprendizId}_${Date.now()}.png`;
        const qrFilePath = path.join(qrCodesDir, qrFileName);

        // Generar QR como imagen
        await QRCode.toFile(qrFilePath, qrData, {
            color: {
                dark: '#2c3e50',
                light: '#ffffff'
            },
            width: 400,
            margin: 2,
            errorCorrectionLevel: 'H'
        });

        res.json({
            success: true,
            qrUrl: `/qr-codes/${qrFileName}`,
            qrData: qrData,
            mensaje: 'QR generado exitosamente'
        });

    } catch (error) {
        console.error('Error generando QR:', error);
        res.status(500).json({
            success: false,
            error: 'Error al generar el código QR'
        });
    }
});

// Servir archivos QR estáticos
app.use('/qr-codes', express.static(qrCodesDir));

// Ruta para verificar/validar QR
app.post('/validar-qr', (req, res) => {
    try {
        const { qrData } = req.body;
        const data = JSON.parse(qrData);
        
        // Verificar que el QR sea válido y no esté expirado
        const ahora = Date.now();
        const timestampQR = data.timestamp;
        const diferencia = ahora - timestampQR;
        const horasValidas = 24; // QR válido por 24 horas
        
        if (data.tipo === 'permiso' && diferencia < (horasValidas * 60 * 60 * 1000)) {
            res.json({
                success: true,
                valido: true,
                data: data,
                mensaje: '✅ QR válido - Permiso activo'
            });
        } else {
            res.json({
                success: false,
                valido: false,
                error: '❌ QR expirado o inválido'
            });
        }
    } catch (error) {
        res.status(400).json({
            success: false,
            error: 'QR inválido o corrupto'
        });
    }
});