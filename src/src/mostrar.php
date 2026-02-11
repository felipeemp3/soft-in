<?php
include('conexion.php');
$sql = "SELECT * FROM personas";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        //echo "nombres: " . $row["nombres"]. " - documento: " . $row["documento"]. " - rol: " . $row["rol"];
        $id_persona = $row["id_persona"];
        echo '<tr>
                <th>' . $row["nombres"] . " " . $row["apellidos"] . '</th>
                <th>' . $row["documento"] . '</th>
                <th>' . $row["rol"] . '</th>
                <th>' . $row["programa_formacion"] . '</th>
                <th>' . $row["estado_formacion"] . '</th>
                <th>' . $row["tip_aprendiz"] . '</th>
                <th>
                    <div class="action-buttons">
                        <a href="user_edit_form.php?id_persona=' . $id_persona . '" class="btn-action btn-edit"><i class="fas fa-edit"></i></a>


                        <button class="btn-action btn-delete" onclick="eliminarUsuario(' . $row["id_persona"] . ')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </th>
            </tr>';
    }
}
