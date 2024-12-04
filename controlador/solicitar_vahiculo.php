<?php
 // conexion a la fucking base de datos
require 'C:/xampp/htdocs/FCC/modelo/conexion.php';

if (isset($_GET['id'])) {
    $vehiculo_id = $_GET['id'];

    // Actualizar el estado del vehículo a "Inactivo"
    $query = "UPDATE vehiculos SET estado = 'Inactivo' WHERE id = $vehiculo_id";
    if ($conexion->query($query)) {
        echo "Vehículo solicitado con éxito.";
    } else {
        echo "Error al solicitar el vehículo: " . $conexion->error;
    }
} else {
    echo "No se ha proporcionado un ID de vehículo.";
}


?>
