<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>FIRE CAR CONTROL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
    <meta name="keywords" content="bootstrap 5, premium, marketing, multipurpose" />
    <meta content="Themesbrand" name="author" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/icono.png" />
    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/colors/green.css" id="color-opt">
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
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark" id="navbar">
        <div class="container">
            <a class="navbar-brand">Fallas de Vehículos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="ti-menu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="mecanico_dashboard.php">Inicio</a>
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

    <section class="bg-login d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-10">
                    <div class="text-center page-heading">
                        <h1 class="text-white">Lista de Fallas Reportadas (Pendientes)</h1>
                    </div> 
                    <div class="bg-white p-4 rounded">
                        <?php
                        include "modelo/conexion.php";
                        ?> 
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Fecha de Reporte</th>
                                        <th scope="col">Estado de la Falla</th>
                                        <th scope="col">Vehículo (Patente)</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Consulta para obtener fallas pendientes junto con la patente del vehículo
                                    $sql = "SELECT f.id AS falla_id, f.descripcion, f.fecha_reporte, f.estado_falla, v.id AS vehiculo_id, v.patente 
                                            FROM fallas_reportadas f 
                                            JOIN vehiculos v ON f.vehiculo_id = v.id
                                            WHERE f.estado_falla = 'Pendiente'";

                                    $result = $conexion->query($sql);

                                    while ($datos = $result->fetch_object()) { ?>
                                        <tr>
                                            <td><?= $datos->descripcion ?></td>
                                            <td><?= $datos->fecha_reporte ?></td>
                                            <td><?= $datos->estado_falla ?></td>
                                            <td><?= $datos->patente ?></td>
                                            <td>
                                                <!-- Botón para ir a la sección de mantenimiento -->
                                                <a href="mantenimiento.php?vehiculo_id=<?= $datos->vehiculo_id ?>" class="btn btn-primary w-100">
                                                    Ir a Mantenimiento
                                                </a>


                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/smooth-scroll.polyfills.min.js"></script>
    <script src="js/gumshoe.polyfills.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>



<!-- le genera dudas, el costo versus la implementacion 
     referencia a dudas sobre la metodologia del desarrollo del proyecto   
     -->