
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>FIRE CAR CONTROL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
    <meta name="keywords" content="bootstrap 5, premium, marketing, multipurpose" />
    <meta content="Themesbrand" name="author" />
    <!-- icono -->
    <link rel="shortcut icon" href="images/icono.png" />
    <!-- css -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <!-- Themify Icon -->
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/colors/default.css" id="color-opt">
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- JavaScript de Bootstrap (con Popper.js incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!--Themify Icon -->
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css" />

    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/colors/green.css" id="color-opt">
</head>

<body class="bg-login">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark" id="navbar">
        <div class="container">
            <a class="navbar-brand">Datos de Usuarios</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="ti-menu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vehiculo_admin.php">Vehiculos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="graficos_mantencion.php">Gafico Mantencion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="graficos_solicitud.php">Grafico Solicitud</a>
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
                        <h1 class="text-white">Datos de Usuarios</h1>
                        <?php
                        if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado') {
                            echo "<div class='alert alert-success'>Usuario eliminado correctamente</div>";
                        }
                        ?>

                        <?php
                        if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'modificado') {
                            echo "<div class='alert alert-success'>Usuario modificado correctamente</div>";
                        }
                        ?>

                    </div> 
                    <div class="bg-white p-4 rounded">
                        <?php 
                        include "modelo/conexion.php"; 
                        include "controlador/eliminar_usuario.php";
                        ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellido</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Rol</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql = $conexion->query("SELECT * FROM usuarios");
                                    while ($datos = $sql->fetch_object()) {
                                        if ($datos->rol != 1) {  // Excluye el rol de admin
                                            // Traducción del rol
                                            $nombreRol = "";
                                            switch ($datos->rol) {;
                                                case '2':  // Bombero
                                                    $nombreRol = 'Bombero';
                                                    break;
                                                case '3':  // Mecánico
                                                    $nombreRol = 'Mecánico';
                                                    break;
                                                default:
                                                    $nombreRol = 'Rol Desconocido';
                                                    break;
                                            }
                                    ?>
                                            <tr>
                                                <td><?= $datos->nombre ?></td>
                                                <td><?= $datos->apellido ?></td>
                                                <td><?= $datos->email ?></td>
                                                <td><?= $nombreRol ?></td> <!-- Muestra el nombre del rol -->
                                                <td>
                                                    <a href="modifi_usuario.php?id=<?= $datos->id ?>" class="text-warning"><i class="bi bi-pencil-square"></i></a>
                                                    <a href="controlador/eliminar_usuario.php?id=<?= $datos->id ?>" class="text-danger" onclick="return confirm('¿Está seguro de eliminar este usuario?');"><i class="bi bi-trash-fill"></i></a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <a href="usuario_reg.php" class="btn btn-primary w-100">Agregar Usuario</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- javascript -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/smooth-scroll.polyfills.min.js"></script>
    <script src="js/gumshoe.polyfills.min.js"></script>
    <script src="js/app.js"></script>
</body>

</html>