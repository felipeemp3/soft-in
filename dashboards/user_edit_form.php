<?php include '../src/seguridad.php'; ?>

<?php
$id_persona = $_GET["id_persona"];

include('../src/conexion.php');

$sql = "SELECT * FROM personas WHERE id_persona = $id_persona";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        //echo "nombres: " . $row["nombres"]. " - documento: " . $row["documento"]. " - rol: " . $row["rol"];

        $id_usuario = $row["id_persona"];
        $nombre =  $row["nombres"];
        $apellidos =  $row["apellidos"];
        $rol =  $row["rol"];
        $estado_f = $row["estado_formacion"];
        $tip_aprndiz = $row["tip_aprendiz"];
    }
} else {
}

?>
<div class="modal-container">

    <link rel="stylesheet" href="../public/css/edit_user.css">
    <div class="modal-header">
        <h2 class="modal-title">Editar Usuario</h2>
        <p class="modal-subtitle">Modifique los datos del usuario</p>

    </div>


    <form id="editUserForm" method="post" action="../src/edit.php" class="user-form">
        <input type="hidden" id="editUserId" name="userId" value="<?php echo $id_usuario; ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="editNombre">Nombre </label>
                <input type="text" id="editNombre" name="nombres" value="<?php echo $nombre; ?>" required>
            </div>
            <div class="form-group">
                <label for="editApellidos">Apellidos </label>
                <input type="text" id="editApellidos" name="apellidos" value="<?php echo $apellidos; ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="editRol">Rol </label>
                <select id="editRol" name="rol" required>
                    <option value="aprendiz">Aprendiz</option>
                    <option value="enfermera">Enfermera</option>
                    <option value="bienestar">Bienestar</option>
                    <option value="vigilante">Vigilante</option>
                    <option value="administrativo">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editEstado">Estado </label>
                <select id="editEstado" name="estado_formacion" required>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                    <option value="Suspension temporal">Suspensión Temporal</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="tipoAprendiz">Tipo de Aprendiz</label>
                <select id="tipoAprendiz" name="tip_aprendiz">
                    <option value="">Seleccionar</option>
                    <option value="interno">Interno</option>
                    <option value="externo">Externo</option>
                </select>
            </div>
            <div class="form-group">
                <!-- Espacio vacío para mantener el diseño -->
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="window.location.href='admin.php'">
                Cancelar
            </button>
            <button name="btnActualizar" type="submit" class="btn-submit">
                <i class="fas fa-save"></i>
                Actualizar
            </button>
        </div>

</div>
</form>
</div>