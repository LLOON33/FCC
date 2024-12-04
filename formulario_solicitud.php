<?php 
require 'modelo/conexion.php';

session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-danger'>Error: No se ha iniciado sesión.</div>";
    exit;
}

$usuario_id = $_SESSION['user_id'];

// Obtener los datos del usuario desde la base de datos
$query_usuario = "SELECT id, email, rol FROM usuarios WHERE id = ?";
$stmt_usuario = $conexion->prepare($query_usuario);
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$resultado_usuario = $stmt_usuario->get_result();

if ($resultado_usuario->num_rows > 0) {
    $usuario = $resultado_usuario->fetch_assoc(); // Guardar los datos del usuario en la variable $usuario
} else {
    echo "<div class='alert alert-danger'>No se encontró el usuario.</div>";
    exit;
}

// Aseguramos que la variable de sesión sea consistente
$_SESSION['usuario_id'] = $usuario['id']; // Almacenar el ID del usuario en la sesión

?>

<?php 
if (isset($_GET['id'])) {
    // Sanitizar y validar el parámetro recibido
    $vehiculo_id = intval($_GET['id']);

    // Obtener los datos del vehículo
    $query_vehiculo = "SELECT * FROM vehiculos WHERE id = ?";
    $stmt_vehiculo = $conexion->prepare($query_vehiculo);
    $stmt_vehiculo->bind_param("i", $vehiculo_id);
    $stmt_vehiculo->execute();
    $resultado_vehiculo = $stmt_vehiculo->get_result();

    if ($resultado_vehiculo->num_rows > 0) {
        $vehiculo = $resultado_vehiculo->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>El vehículo no existe.</div>";
        exit;
    }

    // Procesar el formulario cuando se envíe
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $motivo_solicitud = htmlspecialchars($_POST['motivo_solicitud']);
        $ubicacion = htmlspecialchars($_POST['ubicacion']);

        // Asegúrate de que la sesión está iniciada
        if (!isset($_SESSION['usuario_id'])) {
            echo "<div class='alert alert-danger'>Error: No se ha iniciado sesión.</div>";
            exit;
        }

        $usuario_id = $_SESSION['usuario_id']; // ID del usuario autenticado

        // Consulta INSERT ajustada
        $query_solicitud = "INSERT INTO vehiculos_solicitados (vehiculo_id, fecha_solicitud, motivo_solicitud, ubicacion, usuario_id) 
                            VALUES (?, NOW(), ?, ?, ?)";
        $stmt_solicitud = $conexion->prepare($query_solicitud);
        $stmt_solicitud->bind_param("issi", $vehiculo_id, $motivo_solicitud, $ubicacion, $usuario_id);

        if ($stmt_solicitud->execute()) {
            // Actualizar el estado del vehículo
            $query_actualizar_estado = "UPDATE vehiculos SET estado = 'Solicitado' WHERE id = ?";
            $stmt_actualizar_estado = $conexion->prepare($query_actualizar_estado);
            $stmt_actualizar_estado->bind_param("i", $vehiculo_id);
            $stmt_actualizar_estado->execute();

            echo "<div class='alert alert-success'>Solicitud registrada con éxito.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al registrar la solicitud: " . $conexion->error . "</div>";
        }

        // Cerrar las consultas preparadas
        $stmt_solicitud->close();
        $stmt_actualizar_estado->close();
    }

    // Cerrar la consulta del vehículo
    $stmt_vehiculo->close();
} else {
    echo "<div class='alert alert-danger'>No se ha especificado un vehículo para solicitar.</div>";
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
                <h1 class="text-white">Solicitud de Vehículo</h1>
                <p class="text-white">Formulario para solicitar un vehículo</p>
            </div>

            <?php if (isset($vehiculo)) { ?>
            <div class="col-lg-6">
                <div class="bg-white price-box text-center mt-3">
                    <div class="plan-price fw-bold">
                        <h1 class="mb-0 fw-bold"><?= htmlspecialchars($vehiculo['modelo']) ?></h1>
                        <p class="mb-0">Marca: <?= htmlspecialchars($vehiculo['tipo']) ?></p>
                    </div>
                    <div class="plan-features text-muted mt-5 mb-5">
                        <p>Patente: <b class="text-primary"><?= htmlspecialchars($vehiculo['patente']) ?></b></p>
                        <p>Año: <?= htmlspecialchars($vehiculo['anno']) ?></p>
                        <p>Kilometraje Actual: <?= number_format($vehiculo['kilometraje_actual'], 0, ',', '.') ?> km</p>
                        <p>Tipo: <?= htmlspecialchars($vehiculo['tipo']) ?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Formulario de solicitud -->
                <form method="POST">
                    <div class="form-group mb-3">
                        <label for="motivo_solicitud" class="form-label text-white">Motivo de la Solicitud</label>
                        <textarea class="form-control" id="motivo_solicitud" name="motivo_solicitud" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="ubicacion" class="form-label text-white">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Solicitar Vehículo</button>
                </form>
            </div>
            <?php } ?>
        </div>

        <div class="text-center mt-3">
            <p><small class="text-white me-2"></small> <a href="visualizacion_vehiculos.php" class="text-white fw-bold">Regresar</a></p>
        </div>
    </div>
</section>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/smooth-scroll.polyfills.min.js"></script>
<script src="js/gumshoe.polyfills.min.js"></script>
<script src="js/app.js"></script>
</body>

</html>
