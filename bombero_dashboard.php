<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

require 'modelo/conexion.php';

if (isset($_SESSION['user_id'])) {
    $stmt = $conexion->prepare('SELECT id, email, contraseña FROM usuarios WHERE id = ?');
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $results = $stmt->get_result()->fetch_assoc();

    $user = null;
    if ($results && count($results) > 0) {
        $user = $results;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<style>
    .navbar-toggler .ti-menu {
        color: #000000 !important; /* Cambia el icono a negro */
    }

</style>

<head>
    <meta charset="utf-8" />
    <title>FIRE CAR CONTROL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
    <meta name="keywords" content="bootstrap 5, premium, marketing, multipurpose" />
    <meta content="Themesbrand" name="author" />
    <!-- favicon -->
    <link rel="shortcut icon" href="images/icono.png" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
   <!-- STRAT NAVBAR -->
   <nav class="navbar navbar-expand-lg fixed-top navbar-custom bg-white navbar-light sticky sticky-dark" id="navbar">
    <div class="container">
        <img src="images/logo1.png" alt="Logo Fire Car Control" class="img-fluid mb-3" style="width: 150px; height: auto;">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="ti-menu"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mx-auto" id="navbar-navlist">
                <li class="nav-item">
                    <a data-scroll class="nav-link" href="logout.php">Cerrar Sesion</a>
                </li>
            </ul>
            <div>
                <ul class="text-end list-unstyled list-inline mb-0 nav-social">
                    <li class="list-inline-item nav-number"><i class="ti-mobile"></i> <span>+56 9 6631 9792</span></li>
                    <li class="list-inline-item"><a href="" class="facebook"><i class="ti-facebook"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END NAVBAR -->

  
    <!-- START HOME -->
    <section class="section vh-100" id="home">
        <video autoplay muted loop id="myVideo">
            <source src="Video/7013-197962792_medium.mp4" type= "video/mp4">
        </video>
        <div class="bg-overlay"></div>
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div>
                                <h1 class="text-white home-title mb-0">Vehículos con alta disposición</h1>
                                <div class="mt-4">
                                    <a href="visualizacion_vehiculos.php" class="btn btn-outline-white">Solicitar Vehículos</a>
                                </div>
                                <div class="mt-4">
                                    <a href="vehiculos_fallas_bomb.php" class="btn btn-outline-white">Informacion de los vehiculos</a>
                                </div>
                                <div class="mt-4">
                                    <a href="Reporte_fallas.php" class="btn btn-outline-white">Reportar falla</a>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div>
            </div>
        </div>
    </section>
    <!-- END HOME -->

     <!-- START SERVICES -->
     <section class="section" id="services">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-10">
                    <div class="text-center">
                        <i class="ti-ruler-pencil title-icon text-muted"></i>
                        <h3 class="title"> ¿ QUE ES <span class="fw-bold">FCC ?</span></h3>
                        <p class="text-muted mt-3 title-subtitle mx-auto"> Fire Car Control es un sistema que permite a los usuarios
                            ver el estado de los vehiculos si se encuentran disponibles para su despliegue, permitiendo mayor seguridad y confianza
                            a los civiles y bomberos.</p>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="services-box">
                        <div class="services-icon">
                            <i class="ti-settings text-primary"></i>
                        </div>
                        <div class="mt-3">
                            <h5 class="services-title fw-bold mb-3">Modificación</h5>
                            <p class="services-subtitle text-muted"> Rapida modificacion de los datos de los vehiculares</p>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-4">
                    <div class="services-box">
                        <div class="services-icon">
                            <i class="ti-dashboard text-primary"></i>
                        </div>
                        <div class="mt-3">
                            <h5 class="services-title fw-bold mb-3">Rapidez</h5>
                            <p class="services-subtitle text-muted"> Entregar soluciones rapidas a problematicas que presentan los vehiculos
                                de emergencias</p>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-4">
                    <div class="services-box">
                        <div class="services-icon">
                            <i class="ti-stats-up text-primary"></i>
                        </div>
                        <div class="mt-3">
                            <h5 class="services-title fw-bold mb-3">Soluciones rapidas</h5>
                            <p class="services-subtitle text-muted"> Aumenta la seguridad de los civiles y su tasa de supervivencia en caso
                                 de accidentes
                            </p>
                        </div>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->

        </div>
    </section>
    <!-- END SERVICES -->
    <!-- STRT FOOTER -->
    <section class="section footer">
        <!-- <div class="bg-overlay"></div> -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <ul class="list-inline social mb-0">
                            <li class="list-inline-item"><a href="#" class="social-icon text-muted"><i
                                        class="ti-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-icon text-muted"><i
                                        class="ti-linkedin"></i></a></li>
                        </ul>
                    </div>
                    <div class="footer-terms">
                        <ul class="mb-0 list-inline text-center mt-4 pt-2">
                            <li class="list-inline-item"><a href="#" class="text-muted">Terms & Condition</a></li>
                            <li class="list-inline-item"><a href="#" class="text-muted">Privacy Policy</a></li>
                            <li class="list-inline-item"><a href="#" class="text-muted">Contact Us</a></li>
                        </ul>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div>
    </section>
    <!-- END FOOTER -->


    <!-- Back to top -->

    <a href="#home" data-scroll class="back-to-top" id="back-to-top"> <i class="ti-angle-up"> </i> </a>

    <!-- javascript -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/smooth-scroll.polyfills.min.js"></script>
    <script src="js/gumshoe.polyfills.min.js"></script>
    <script src="js/app.js"></script>
</body>

</html>