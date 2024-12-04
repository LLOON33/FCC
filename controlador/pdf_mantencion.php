<?php
session_start();
require('../fpdf/fpdf.php');
include "../modelo/conexion.php";

// Validar que el ID del vehículo está en la URL y es un número
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de vehículo no encontrado o inválido.");
}

$vehiculo_id = intval($_GET['id']);

// Obtener los datos del vehículo
$vehiculo_stmt = $conexion->prepare("SELECT patente, modelo, tipo FROM vehiculos WHERE id = ?");
$vehiculo_stmt->bind_param("i", $vehiculo_id);
$vehiculo_stmt->execute();
$vehiculo_result = $vehiculo_stmt->get_result();
$vehiculo = $vehiculo_result->fetch_object();

if (!$vehiculo) {
    die("El vehículo con ID $vehiculo_id no existe en la base de datos.");
}

// Obtener el historial de mantenimientos
$mantenimientos_stmt = $conexion->prepare("SELECT tipo_mantenimiento, descripcion, fecha_mantenimiento, costo, kilometraje_mantenimiento FROM mantenimientos WHERE vehiculo_id = ?");
$mantenimientos_stmt->bind_param("i", $vehiculo_id);
$mantenimientos_stmt->execute();
$mantenimientos_result = $mantenimientos_stmt->get_result();

// Crear el PDF



header('Content-Type: application/pdf'); // Asegura que el contenido sea PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Agregar el logo
$pdf->Image('../images/logo1.png', 15, 15, 30); // Ruta, X, Y, Tamaño ancho (en mm)
$pdf->Ln(10); // Espacio debajo del logo

// Título
$pdf->Cell(0, 10, utf8_decode('Historial de Mantenciones - FIRE CAR CONTROL'), 0, 1, 'C');
$pdf->Ln(10);

// Información del vehículo
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode("Vehículo: $vehiculo->patente"), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode("tipo: $vehiculo->tipo"), 0, 1);
$pdf->Cell(0, 10, utf8_decode("Modelo: $vehiculo->modelo"), 0, 1);
$pdf->Ln(10);

// Encabezados de tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Tipo', 1);
$pdf->Cell(70, 10, utf8_decode('Descripción'), 1);
$pdf->Cell(30, 10, utf8_decode('Fecha'), 1);
$pdf->Cell(25, 10, 'Costo', 1);
$pdf->Cell(25, 10, 'Km', 1);
$pdf->Ln();

// Datos de mantenimientos
$pdf->SetFont('Arial', '', 10);
if ($mantenimientos_result->num_rows > 0) {
    while ($mantenimiento = $mantenimientos_result->fetch_object()) {
        $pdf->Cell(40, 10, utf8_decode($mantenimiento->tipo_mantenimiento), 1);
        $pdf->Cell(70, 10, utf8_decode($mantenimiento->descripcion), 1);
        $pdf->Cell(30, 10, $mantenimiento->fecha_mantenimiento, 1);
        $pdf->Cell(25, 10, $mantenimiento->costo . " CLP", 1);
        $pdf->Cell(25, 10, $mantenimiento->kilometraje_mantenimiento . " km", 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('No se encontraron mantenimientos.'), 1, 1, 'C');
}

// Generar PDF
ob_clean(); // Limpia cualquier salida previa
$pdf->Output('I', "Historial_{$vehiculo->patente}.pdf");
exit();
?>
