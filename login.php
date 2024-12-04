<?php
session_start(); // Iniciar sesión
require 'modelo/conexion.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['contraseña'])) {

    // Preparar la consulta para obtener el usuario por su email y rol
    $record = $conexion->prepare('SELECT id, email, contraseña, rol FROM usuarios WHERE email = ?');
    $record->bind_param('s', $_POST['email']); // 's' indica que es un string
    $record->execute();
    $result = $record->get_result(); // Usamos get_result() para obtener los resultados de la consulta

    // Comprobamos si el usuario existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($_POST['contraseña'], $user['contraseña'])) {
            $_SESSION['user_id'] = $user['id']; // Almacenar el ID del usuario en la sesión
            $_SESSION['user_role'] = $user['rol']; // Almacenar el rol del usuario en la sesión
            
            // Redirigir según el rol
            switch ($user['rol']) {
                case '1':
                    header('Location: index.php');
                    break;
                case '2':
                    header('Location: bombero_dashboard.php');
                    break;
                case '3':
                    header('Location: mecanico_dashboard.php');
                    break;
                default:
                    header('Location: index.php'); // Página predeterminada
                    break;
            }
            exit(); // Asegurarse de que el código no continúe ejecutándose
        } else {
            $message = 'Contraseña incorrecta.';
        }
    } else {
        $message = 'El email no está registrado.';
    }
} else {
    $message = '';
}
?>

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

    <!--Themify Icon -->
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css" />

    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/colors/default.css" id="color-opt">
</head>

<body class= "bg-login">

    <section class="bg-login d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-4">
                    <div class="bg-white p-4 rounded">
                        <div class="text-center">
                        <img src="images/logo1.png" alt="Logo Fire Car Control" class="img-fluid mb-3" style="width: 150px; height: auto;">
                            <?php if (!empty($message)) : ?>
                                <p><?= $message ?></p>
                            <?php  endif ?>
                        </div>
                        <form class="login-form" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required="">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <input type="password" class="form-control" name="contraseña" placeholder="Contraseña" required="">
                                </div>
                                <div class="col-lg-12 mt-2">
                                </div>
                                <div class="col-lg-12 mt-3 mb-4">
                                    <button class="btn btn-primary w-100" type="submit">Inicia sesión</button>
                                </div>
                            </div><!-- end row -->
                        </form><!-- end form -->
                    </div>
                    <div class="text-center mt-3">
                        <p><small class="text-white me-2">¿No tienes cuenta?</small> <a href="singup.php" class="text-white fw-bold">Crea una cuenta</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- javascript -->

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/smooth-scroll.polyfills.min.js"></script>
    <script src="js/gumshoe.polyfills.min.js"></script>
    <!-- Main Js -->
    <script src="js/app.js"></script>
</body>

</html>