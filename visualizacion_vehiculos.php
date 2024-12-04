<?php
// Conexión a la base de datos
require 'modelo/conexion.php';

if (isset($_GET['id'])) {
    // Sanitizar y validar el parámetro recibido
    $vehiculo_id = intval($_GET['id']);

    // Preparar la consulta para actualizar el estado
    $query = "UPDATE vehiculos SET estado = 'Solicitado' WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $vehiculo_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Vehículo solicitado con éxito.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al solicitar el vehículo: " . $conexion->error . "</div>";
    }
    $stmt->close();
} else {
    echo "";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>FIRE CAR CONTROL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Sistema de control de vehículos" />
    <meta name="keywords" content="vehículos, control, bomberos" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="images/icono.png" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css" />
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/colors/green.css" id="color-opt">
    <link rel="shortcut icon" href="images/icono.png" />
</head>

<body class="bg-login">

<section class="d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="text-center page-heading">
                <h1 class="text-white">Vehículos Activos</h1>
                <p class="text-white">Listado de vehículos disponibles para solicitud</p>
            </div>
            <div class="row mt-5">

                <?php
                // Obtener los vehículos
                $query = "SELECT * FROM vehiculos";
                $resultado = $conexion->query($query);

                while ($vehiculo = $resultado->fetch_assoc()) {
                    // Determinar el estado y clase de estilo según el estado del vehículo
                    $estadoClase = ($vehiculo['estado'] === 'Inactivo') ? 'text-danger' : ($vehiculo['estado'] === 'Solicitado' ? 'text-warning' : 'text-primary');
                    $estadoVehiculo = $vehiculo['estado'];
                ?>
                <div class="col-lg-4">
                    <div class="bg-white price-box text-center mt-3">
                        <div class="plan-price fw-bold">
                            <h1 class="mb-0 fw-bold"><?= htmlspecialchars($vehiculo['modelo']) ?></h1>
                            <p class="mb-0">Marca: <?= htmlspecialchars($vehiculo['tipo']) ?></p>
                        </div>
                        <div class="plan-features text-muted mt-5 mb-5">
                            <p>Patente: <b class="<?= $estadoClase ?>"><?= htmlspecialchars($vehiculo['patente']) ?></b></p>
                            <p>Año: <?= htmlspecialchars($vehiculo['anno']) ?></p>
                            <p>Kilometraje Actual: <?= number_format($vehiculo['kilometraje_actual'], 0, ',', '.') ?> km</p>
                            <p>Tipo: <?= htmlspecialchars($vehiculo['tipo']) ?></p>
                            <p>Fecha de Ingreso: <?= htmlspecialchars($vehiculo['fecha_ingreso']) ?></p>
                            <p class="mb-0 <?= $estadoClase ?>">Estado: <?= htmlspecialchars($vehiculo['estado']) ?></p>
                        </div>
                        <div>
                            <!-- Verificar si el vehículo está Inactivo o Solicitado para deshabilitar el botón -->
                            <?php if ($estadoVehiculo == 'Inactivo' || $estadoVehiculo == 'Solicitado') { ?>
                                <button class="btn btn-secondary btn-round" disabled>No Disponible</button>
                            <?php } else { ?>
                                <a href="formulario_solicitud.php?id=<?= $vehiculo['id'] ?>" class="btn btn-primary btn-round">Solicitar</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>

            </div>
            <div class="text-center mt-3">
                <p><small class="text-white me-2"></small> <a href="bombero_dashboard.php" class="text-white fw-bold">Regresar</a></p>
            </div>
        </div>
    </div>
</section>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/smooth-scroll.polyfills.min.js"></script>
<script src="js/gumshoe.polyfills.min.js"></script>
<script src="js/app.js"></script>
</body>

</html>

<!-- crear una funcion capaz de poder almacenar los datos de los vehiculos solicitados y estos esten en una -->