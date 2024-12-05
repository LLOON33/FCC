<?php
// Incluir archivo de conexión
include("C:/xampp/htdocs/FCC/modelo/conexion.php");

// Procesar el formulario solo si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $vehiculo_id = $_POST['vehiculo_id'] ?? '';
    $tipo_mantenimiento = $_POST['tipo_mantenimiento'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fecha_mantenimiento = $_POST['fecha_mantenimiento'] ?? '';
    $costo = $_POST['costo'] ?? '';
    $kilometraje_mantenimiento = $_POST['kilometraje_mantenimiento'] ?? '';

    // Verificar si todos los campos requeridos están completos
    if (empty($vehiculo_id) || empty($tipo_mantenimiento) || empty($descripcion) || empty($fecha_mantenimiento) || empty($costo) || empty($kilometraje_mantenimiento)) {
        echo "Error: Todos los campos son obligatorios.";
        exit();
    }

    // Si los campos están completos, inserta el mantenimiento en la base de datos
    $query = "INSERT INTO mantenimientos (vehiculo_id, tipo_mantenimiento, descripcion, fecha_mantenimiento, costo, kilometraje_mantenimiento) 
              VALUES ('$vehiculo_id', '$tipo_mantenimiento', '$descripcion', '$fecha_mantenimiento', '$costo', '$kilometraje_mantenimiento')";

    if ($conexion->query($query) === TRUE) {
        // Actualizar la falla a "Resuelta"
        $updateFallaQuery = "UPDATE fallas_reportadas SET estado_falla = 'Resuelta' WHERE vehiculo_id = '$vehiculo_id' AND estado_falla = 'Pendiente'";
        $conexion->query($updateFallaQuery);

        // Actualizar el estado del vehículo a "Activo"
        $updateVehiculoQuery = "UPDATE vehiculos SET estado = 'Activo' WHERE id = '$vehiculo_id' AND estado = 'Inactivo'";
        $conexion->query($updateVehiculoQuery);
        

        header("Location: ../lista_fallas.php?mensaje=modificado"); // Redirige con mensaje de éxito
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conexion->error;
    }
    
    $conexion->close();
} else {
    echo "";
}
?>
