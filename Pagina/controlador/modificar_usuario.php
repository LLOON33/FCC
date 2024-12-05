<?php

include "../modelo/conexion.php";

if (isset($_POST["btnregistrar"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];
    $rol = $_POST["rol"];

    $sql = $conexion->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, rol = ? WHERE id = ?");
    $sql->bind_param("ssssi", $nombre, $apellido, $email, $rol, $id);

    if ($sql->execute()) {
        header("Location: ../usuario.php?mensaje=modificado"); // Redirige con mensaje de éxito
        exit();
    } else {
        echo "Error al modificar el usuario.";
    }
} else {
    echo "Solicitud no válida.";
}
?>