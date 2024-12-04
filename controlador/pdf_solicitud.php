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

// Obtener el historial de solicitudes
$solicitudes_stmt = $conexion->prepare("SELECT vs.*, u.nombre, u.apellido 
                                        FROM vehiculos_solicitados vs
                                        JOIN usuarios u ON vs.usuario_id = u.id
                                        WHERE vs.vehiculo_id = ?");
$solicitudes_stmt->bind_param("i", $vehiculo_id);
$solicitudes_stmt->execute();
$solicitudes_result = $solicitudes_stmt->get_result();

// Crear el PDF
header('Content-Type: application/pdf'); // Asegura que el contenido sea PDF
$pdf = new FPDF();
$pdf->AddPage();

// Agregar el logo
$pdf->Image('../images/logo1.png', 15, 15, 30); // Ruta, X, Y, Tamaño ancho (en mm)
$pdf->Ln(10); // Espacio debajo del logo

// Título
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode('Historial de Solicitudes - FIRE CAR CONTROL'), 0, 1, 'C');
$pdf->Ln(10);

// Información del vehículo
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode("Vehículo: $vehiculo->patente"), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode("Tipo: $vehiculo->tipo"), 0, 1);
$pdf->Cell(0, 10, utf8_decode("Modelo: $vehiculo->modelo"), 0, 1);
$pdf->Ln(10);

// Encabezados de tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 10, 'Solicitante', 1);
$pdf->Cell(70, 10, utf8_decode('Motivo de Solicitud'), 1);
$pdf->Cell(50, 10, utf8_decode('Ubicación'), 1);
$pdf->Cell(30, 10, 'Fecha de Solicitud', 1);
$pdf->Ln();

// Datos de las solicitudes
$pdf->SetFont('Arial', '', 10);
if ($solicitudes_result->num_rows > 0) {
    while ($solicitud = $solicitudes_result->fetch_object()) {
        $pdf->Cell(50, 10, utf8_decode($solicitud->nombre . ' ' . $solicitud->apellido), 1);
        $pdf->Cell(70, 10, utf8_decode($solicitud->motivo_solicitud), 1);
        $pdf->Cell(50, 10, utf8_decode($solicitud->ubicacion), 1);
        $pdf->Cell(30, 10, $solicitud->fecha_solicitud, 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('No se encontraron solicitudes para este vehículo.'), 1, 1, 'C');
}

// Generar PDF
ob_clean(); // Limpia cualquier salida previa
$pdf->Output('I', "Historial_Solicitudes_{$vehiculo->patente}.pdf");
exit();
?>
