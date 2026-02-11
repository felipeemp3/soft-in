<?php 
include('conexion.php');

// NO usar header JSON, mantener HTML normal
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM personas 
            WHERE nombres LIKE '%$search%' 
            OR apellidos LIKE '%$search%' 
            OR documento LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM personas";
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $id_persona = $row["id_persona"];
        echo '<tr>
                <td>'.$row["nombres"]." ".$row["apellidos"].'</td>
                <td>'. $row["documento"].'</td>
                <td>'.$row["rol"].'</td>
                <td>'. $row["programa_formacion"].'</td>
                <td>'. $row["estado_formacion"].'</td>
                <td>'. $row["tip_aprendiz"].'</td>
                <td>
                    <div class="action-buttons">
                        <a href="user_edit_form.php?id_persona='.$id_persona.'" class="btn-action btn-edit"><i class="fas fa-edit"></i></a>
                        <button class="btn-action btn-delete" onclick="eliminarUsuario('.$row["id_persona"].')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>';
    }
} else {
    echo '<tr><td colspan="7">No se encontraron usuarios</td></tr>';
}
?>