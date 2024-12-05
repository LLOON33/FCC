<?php
require 'modelo/conexion.php';

$message = '';

// Verificar que los campos requeridos no estén vacíos
if (!empty($_POST['vehiculo_id']) && !empty($_POST['descripcion']) && !empty($_POST['fecha_reporte']) && 
    !empty($_POST['estado_falla']) && !empty($_POST['usuario_id'])) {

    // Preparar la consulta SQL para insertar la falla de los vehículos
    $sql = "INSERT INTO fallas_reportadas (vehiculo_id, descripcion, fecha_reporte, estado_falla, usuario_id) 
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("isssi", $_POST['vehiculo_id'], $_POST['descripcion'], $_POST['fecha_reporte'], 
                          $_POST['estado_falla'], $_POST['usuario_id']);

        if ($stmt->execute()) {
            // Actualizar el estado del vehículo a "Inactivo"
            $vehiculo_id = $_POST['vehiculo_id'];
            $update_sql = "UPDATE vehiculos SET estado = 'Inactivo' WHERE id = ?";
            if ($update_stmt = $conexion->prepare($update_sql)) {
                $update_stmt->bind_param("i", $vehiculo_id);
                $update_stmt->execute();
                $update_stmt->close();
            }

            $message = 'Falla reportada correctamente y vehículo marcado como Inactivo.';
        } else {
            $message = 'Error al registrar la falla.';
        }

        $stmt->close();
    } else {
        $message = 'Error al preparar la consulta.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Reporte de Fallas - Fire Car Control</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/icono.png" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <section class="bg-login d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-4">
                    <div class="bg-white p-4 mt-5 rounded">
                        <div class="text-center">
                            <h4 class="fw-bold mb-3">Reportar Falla de Vehículo</h4>
                            <?php if (!empty($message)): ?>
                                <div class="alert <?php echo ($message === 'Falla reportada correctamente y vehículo marcado como Inactivo.') ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                                    <?php echo $message; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <form class="login-form" action="reporte_fallas.php" method="POST">
                            <div class="row">
                                <!-- Campo de selección de vehículo -->
                                <div class="col-lg-12 mt-2">
                                    <label for="vehiculo_id">Vehículo:</label>
                                    <select id="vehiculo_id" name="vehiculo_id" class="form-control" required>
                                        <option value="">Selecciona un vehículo</option>
                                        <!-- Aquí debes cargar los vehículos desde la base de datos -->
                                        <?php
                                        $result = $conexion->query("SELECT id, patente FROM vehiculos WHERE estado = 'Activo'");
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['id']}'>{$row['patente']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <!-- Descripción de la falla -->
                                <div class="col-lg-12 mt-2">
                                    <input type="text" class="form-control" name="descripcion" placeholder="Descripción de la falla" required>
                                </div>
                                
                                <!-- Fecha de reporte -->
                                <div class="col-lg-12 mt-2">
                                    <label for="fecha_reporte">Fecha de reporte:</label>
                                    <input type="date" class="form-control" name="fecha_reporte" required>
                                </div>
                                
                                <!-- Estado de la falla -->
                                <div class="col-lg-12 mt-2">
                                    <label for="estado_falla">Estado de la Falla:</label>
                                    <select id="estado_falla" name="estado_falla" class="form-control" required>
                                        <option value="">Selecciona el estado</option>
                                        <option value="Pendiente">Pendiente</option>
                                    </select>
                                </div>

                                <!-- Selección de usuario (reportante) -->
                                <div class="col-lg-12 mt-2">
                                    <label for="usuario_id">Reportado por:</label>
                                    <select id="usuario_id" name="usuario_id" class="form-control" required>
                                        <option value="">Selecciona un usuario</option>
                                        <!-- Aquí debes cargar los usuarios desde la base de datos -->
                                        <?php
                                        $result = $conexion->query("SELECT id, nombre, apellido FROM usuarios WHERE rol = '2'");
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['id']}'>{$row['nombre']} {$row['apellido']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Botón para enviar -->
                                <div class="col-lg-12 mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Reportar Falla</button>
                                </div>
                            </div><!-- end row -->
                        </form><!-- end form -->
                    </div>
                    <div class="text-center mt-3">
                        <p><a href="bombero_dashboard.php" class="text-white fw-bold">Regresar</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
