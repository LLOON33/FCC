<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>FIRE CAR CONTROL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
    <meta name="keywords" content="bootstrap 5, premium, marketing, multipurpose" />
    <meta content="Themesbrand" name="author" />
    <!-- favicon -->
    <link rel="shortcut icon" href="images/icono.png" />
    <!-- css -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- JavaScript de Bootstrap (con Popper.js incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!--Themify Icon -->
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css" />

    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/colors/green.css" id="color-opt">
    <!--Themify Icon -->
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/colors/green.css" id="color-opt">
</head>
<body>
<!-- STRAT NAVBAR -->
   <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark" id="navbar">
    <div class="container">
        <a class="navbar-brand">Datos de vehiculos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="ti-menu"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mx-auto" id="navbar-navlist">
                <li class="nav-item">
                    <a data-scroll class="nav-link" href="login.php" >Cerrar Sesion</a>
                </li>
            </ul>
            <ul class="navbar-nav mx-auto" id="navbar-navlist">
                <li class="nav-item">
                    <a data-scroll class="nav-link" href="mecanico_dashboard.php" >Inicio</a>
                </li>
            </ul>
            <div>
                <ul class="text-right list-unstyled list-inline mb-0 nav-social">
                    <li class="list-inline-item text-white nav-number"><i class="ti-mobile"></i> <span>+56 9 8435 7965</span></li>
                    <li class="list-inline-item"><a href="" class="facebook"><i class="ti-facebook"></i></a></li>
                </ul>
                <!-- end ul -->
            </div>
        </div>
    </div>
</nav>
<!-- END NAVBAR -->



<section class="bg-login d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-4">
                     <div class="text-center page-heading">
                                <h1 class="text-white">Registro vehiculos</h1>
                            </div> 
                    <div class="bg-white p-4 rounded">
                        <form class="login-form" method= "POST">
                            <?php
                            include "modelo/conexion.php";
                            include "controlador/car_registro.php";
                            ?>
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <input type="text" class="form-control" placeholder="ingrese patente" name="patente">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <input type="text" class="form-control" placeholder="ingrese tipo de vehiculo" name="tipo">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <input type="text" class="form-control" placeholder="ingrese modelo" name="modelo">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <input type="number" class="form-control" placeholder="ingrese año de vehiculo" name="anno">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <input type="number" class="form-control" placeholder="ingrese kilometraje" name="kilometraje_actual">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <input type="text" class="form-control" placeholder="ingrese estado del vehiculo" name="estado">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <input type="date" class="form-control" placeholder="ingrese estado del fecha de ingreso" name="fecha_ingreso">
                                </div>
                                <div class="col-lg-12 mt-3 mb-4">
                                    <button type= "submit" class="btn btn-primary w-100" name="btnregistrar" value="ok">Registrar</button>
                                </div>
                                <div class="txet-center">
                                    <p class="mb-0 mt-2 text-center">
                                        <a href="vehiculo.php" class="text-dark fw-bold">regresar</a>
                                    </p>
                                </div>
                            </div><!-- end row -->
                        </form><!-- end form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>