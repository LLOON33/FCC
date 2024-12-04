<?php
session_start();
include "modelo/conexion.php";

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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Historial de Fallas - FIRE CAR CONTROL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="images/icono.png" />
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark" id="navbar">
        <div class="container">
            <a class="navbar-brand">Historial de Fallas</a>
        </div>
    </nav>
    <!-- END NAVBAR -->

    <section class="bg-login d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-10">
                    <div class="text-center page-heading">
                        <h1 class="text-white">Historial de Fallas - Vehículo: <?= $vehiculo->patente ?></h1>
                    </div>
                    <div class="bg-white p-4 rounded">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Fecha de Reporte</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($sql->num_rows > 0) {
                                        // Mostrar historial de fallas
                                        while ($datos = $sql->fetch_object()) { ?>
                                            <tr>
                                                <td><?= $datos->descripcion ?></td>
                                                <td><?= $datos->fecha_reporte ?></td>
                                                <td><?= $datos->estado_falla ?></td>
                                            </tr>
                                        <?php }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>No se encontraron fallas reportadas para este vehículo.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <a href="controlador/pdf_falla.php?id=<?= $vehiculo_id ?>" target="_blank" class="btn btn-primary">Descargar Historial</a>
                            <a href="vehiculos_fallas.php" class="btn btn-secondary">Volver</a>
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