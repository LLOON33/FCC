<?php
require 'modelo/conexion.php';

$message = '';

if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['email']) &&
    !empty($_POST['contraseña']) && !empty($_POST['rol'])) {

    // Verificar si el correo ya está registrado y que la pagina no joda XD
    $checkEmail = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($checkEmail);
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = 'El correo ya está registrado. Usa uno diferente.';
    } else {
        // Preparar la consulta SQL de la tabla de los usuarios
        $sql = "INSERT INTO usuarios (nombre, apellido, email, contraseña, rol) VALUES(?, ?, ?, ?, ?)";

        if ($stmt = $conexion->prepare($sql)) {
            $password = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
            $stmt->bind_param("sssss", $_POST['nombre'], $_POST['apellido'], $_POST['email'], $password, $_POST['rol']);

            if ($stmt->execute()) {
                $message = 'Usuario registrado correctamente.';
            } else {
                $message = 'Error al crear el usuario.';
            }

            $stmt->close();
        } else {
            $message = 'Error al preparar la consulta.';
        }
    }
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
    <!-- favicon -->
    <link rel="shortcut icon" href="images/icono.png" />
    <!-- css -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css" />
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/colors/pink.css" id="color-opt">
</head>
<body>
    <section class="bg-login d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-4">
                    <div class="bg-white p-4 mt-5 rounded">
                        <div class="text-center">
                            <h4 class="fw-bold mb-3">Fire Car Control</h4>
                            <?php if (!empty($message)): ?>
                                <p><?php echo $message; ?></p> <!-- Mostrar el mensaje con echo -->
                            <?php endif; ?>
                        </div>
                        <form class="login-form" action="usuario_reg.php" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" required="">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <input type="text" class="form-control" name="apellido" placeholder="Apellido" required="">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required="">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <input type="password" class="form-control" name="contraseña" placeholder="Contraseña" required="">
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label for="rol">Rol de Usuario:</label>
                                    <select id="rol" name="rol" class="form-control" required>
                                        <option value="">Selecciona un rol</option>
                                        <option value="2">Bombero</option>
                                        <option value="3">Mecánico</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <button class="btn btn-primary w-100" type="submit">ingresar</button>
                                </div>
                            </div><!-- end row -->
                        </form><!-- end form -->
                    </div>
                    <div class="text-center mt-3">
                        <p><small class="text-white me-2"></small> <a href="usuario.php" class="text-white fw-bold">Regresar</a></p>
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