<?php
session_start();
require('../fpdf/fpdf.php');
include "../modelo/conexion.php";

// Verificar que el ID del vehículo está en la URL
if (isset($_GET['id'])) {
    $vehiculo_id = $_GET['id'];

    // Obtener el historial de fallas para el vehículo
    $sql = $conexion->query("SELECT * FROM fallas_reportadas WHERE vehiculo_id = $vehiculo_id");

    // Obtener los datos del vehículo para mostrarlos
    $vehiculo_sql = $conexion->query("SELECT * FROM vehiculos WHERE id = $vehiculo_id");
    $vehiculo = $vehiculo_sql->fetch_object();
} else {
    echo "ID de vehículo no encontrado.";
    exit();
}

// Crear el PDF
header('Content-Type: application/pdf'); // Asegura que el contenido sea PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Agregar el logo
$pdf->Image('../images/logo1.png', 15, 15, 30); // Ruta, X, Y, Tamaño ancho (en mm)
$pdf->Ln(10); // Espacio debajo del logo

// Título
$pdf->Cell(0, 10, utf8_decode('Historial de Fallas - FIRE CAR CONTROL'), 0, 1, 'C');
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
$pdf->Cell(70, 10, utf8_decode('Descripción'), 1);
$pdf->Cell(50, 10, utf8_decode('Fecha de Reporte'), 1);
$pdf->Cell(40, 10, 'Estado', 1);
$pdf->Ln();

// Datos de fallas
$pdf->SetFont('Arial', '', 10);
if ($sql->num_rows > 0) {
    while ($datos = $sql->fetch_object()) {
        $pdf->Cell(70, 10, utf8_decode($datos->descripcion), 1);
        $pdf->Cell(50, 10, $datos->fecha_reporte, 1);
        $pdf->Cell(40, 10, $datos->estado_falla, 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('No se encontraron fallas reportadas para este vehículo.'), 1, 1, 'C');
}

// Generar PDF
ob_clean(); // Limpia cualquier salida previa
$pdf->Output('I', "Historial_Fallas_{$vehiculo->patente}.pdf");
exit();
?>