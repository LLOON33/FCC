<?php
include "C:/xampp/htdocs/FCC/modelo/conexion.php";

if (!empty($_GET["id"])) {
    $id = $_GET["id"];

    $sql = $conexion->query("DELETE FROM usuarios WHERE id=$id");

    if ($sql) {
        header("Location: ../usuario.php?mensaje=eliminado"); 
        exit();
    } else {
        echo 'Error al eliminar';
    }
} else {
    echo '';
}
?>