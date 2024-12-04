<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Sistema de Control de Vehículos de Emergencia" />
    <meta name="keywords" content="vehículos, control, gestión, emergencias" />
    <meta content="Themesbrand" name="author" />
    <title>FIRE CAR CONTROL</title>

    <!-- Favicon -->
    <link rel="icon" href="images/icono.png" type="image/png">

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/themify-icons.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link href="css/colors/green.css" rel="stylesheet" id="color-opt">
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- JavaScript de Bootstrap (con Popper.js incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!--Themify Icon -->
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css" />

    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/colors/green.css" id="color-opt">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top sticky-dark" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">Datos de Vehículos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="ti-menu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="bombero_dashboard.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="visualizacion_vehiculos.php">Solicitar Vehiculos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reporte_fallas.php">Reportar falla</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Cerrar Sesión</a>
                    </li>
                </ul>
                <ul class="text-right list-unstyled list-inline mb-0 nav-social">
                    <li class="list-inline-item text-white nav-number"><i class="ti-mobile"></i> <span>+56 9 8435 7965</span></li>
                    <li class="list-inline-item"><a href="#" class="facebook"><i class="ti-facebook"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->

    <!-- Main Section -->
    <section class="bg-login d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-10">
                    <div class="text-center page-heading ">
                        <h1 class="text-white">Lista de Vehículos</h1>
                    </div>
                    <div class="bg-white p-4 rounded shadow-sm">
                        <?php
                        include "modelo/conexion.php";
                        ?> 
                        <div class="row">
                            <?php
                            $sql = $conexion->query("SELECT * FROM vehiculos");
                            while ($datos = $sql->fetch_object()) { ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($datos->modelo) ?> (<?= htmlspecialchars($datos->anno) ?>)</h5>
                                            <p class="card-text">
                                                <strong>Patente:</strong> <?= htmlspecialchars($datos->patente) ?><br>
                                                <strong>Tipo:</strong> <?= htmlspecialchars($datos->tipo) ?><br>
                                            </p>
                                            <a href="historial_fallas_bomb.php?id=<?= $datos->id ?>" class="btn btn-primary w-100 mb-2" aria-label="Ver historial de fallas de vehículo <?= $datos->patente ?>">Historial Fallas</a>
                                            <a href="historial_mantencion_bomb.php?id=<?= $datos->id ?>" class="btn btn-primary w-100 mb-2" aria-label="Ver historial de mantención de vehículo <?= $datos->patente ?>">Historial Mantención</a>
                                            <a href="historial_solicitud_bomb.php?id=<?= $datos->id ?>" class="btn btn-primary w-100" aria-label="Ver historial de solicitudes de vehículo <?= $datos->patente ?>">Historial Solicitudes</a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Botón Volver
                        <div class="text-center mt-4">
                            <a href="mecanico_dashboard.php" class="btn btn-secondary">Volver</a>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Main Section -->

    <!-- JavaScript -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/smooth-scroll.polyfills.min.js"></script>
    <script src="js/gumshoe.polyfills.min.js"></script>
    <script src="js/app.js"></script>
</body>

</html>
