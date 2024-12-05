<?php

include "../modelo/conexion.php";

if (!empty($_POST["btnregistrar"])) {
    if (!empty($_POST["patente"]) && !empty($_POST["tipo"]) && !empty($_POST["modelo"]) && !empty($_POST["anno"]) && !empty($_POST["kilometraje_actual"]) && !empty($_POST["estado"]) && !empty($_POST["fecha_ingreso"])) {
        
        $id = (int)$_POST['id'];
        $patente = $_POST['patente'];
        $tipo = $_POST['tipo'];
        $modelo = $_POST['modelo'];
        $anno = (int) $_POST['anno'];
        $kilometraje_actual = (int) $_POST['kilometraje_actual'];
        $estado = $_POST['estado'];
        $fecha_ingreso = $_POST['fecha_ingreso'];

        $sql = $conexion->query("UPDATE vehiculos SET patente='$patente', tipo='$tipo', modelo='$modelo', anno=$anno, kilometraje_actual=$kilometraje_actual, estado='$estado', fecha_ingreso='$fecha_ingreso' WHERE id=$id");

        if ($sql == 1) {
            header("Location: ../vehiculo.php");
            exit;
        } else {
            echo "<div class='alert alert-warning'>Error al modificar el vehículo</div>";
        }
        
    } else {
        echo "<div class='alert alert-warning'>Por favor, completa todos los campos requeridos y asegúrate de que el ID esté presente.</div>";
    }
}
?>