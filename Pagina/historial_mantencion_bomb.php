<?php
session_start();
include "modelo/conexion.php";

// Verificar que el ID del vehículo está en la URL y es válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $vehiculo_id = intval($_GET['id']);

    // Obtener los datos del vehículo
    $vehiculo_stmt = $conexion->prepare("SELECT * FROM vehiculos WHERE id = ?");
    $vehiculo_stmt->bind_param("i", $vehiculo_id);
    $vehiculo_stmt->execute();
    $vehiculo_result = $vehiculo_stmt->get_result();
    $vehiculo = $vehiculo_result->fetch_object();

    if (!$vehiculo) {
        echo "Vehículo no encontrado.";
        exit();
    }

    // Obtener el historial de mantenimientos
    $mantenimiento_stmt = $conexion->prepare("SELECT * FROM mantenimientos WHERE vehiculo_id = ?");
    $mantenimiento_stmt->bind_param("i", $vehiculo_id);
    $mantenimiento_stmt->execute();
    $mantenimientos = $mantenimiento_stmt->get_result();
} else {
    echo "ID de vehículo no encontrado o inválido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Historial de Mantenciones - FIRE CAR CONTROL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="images/icono.png" />

</head>

<body >
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark" id="navbar">
        <div class="container">
            <a class="navbar-brand">Historial de Mantenciones</a>
        </div>
    </nav>
    <!-- END NAVBAR -->

    <section class="bg-login d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-10">
                    <div class="text-center page-heading">
                        <h1 class="text-white">Historial de Mantenciones - Vehículo: <?= htmlspecialchars($vehiculo->patente) ?></h1>
                    </div>
                    <div class="bg-white p-4 rounded">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Tipo de Mantenimiento</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Fecha de Mantenimiento</th>
                                        <th scope="col">Costo</th>
                                        <th scope="col">Kilometraje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($mantenimientos->num_rows > 0): ?>
                                        <?php while ($datos = $mantenimientos->fetch_object()): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($datos->tipo_mantenimiento) ?></td>
                                                <td><?= htmlspecialchars($datos->descripcion) ?></td>
                                                <td><?= htmlspecialchars($datos->fecha_mantenimiento) ?></td>
                                                <td><?= htmlspecialchars($datos->costo) ?> CLP</td>
                                                <td><?= htmlspecialchars($datos->kilometraje_mantenimiento) ?> km</td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No se encontraron mantenimientos reportados para este vehículo.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <a href="controlador/pdf_mantencion.php?id=<?= $vehiculo_id ?>" target="_blank" class="btn btn-primary">Descargar Historial</a>
                            <a href="vehiculos_fallas_bomb.php" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
