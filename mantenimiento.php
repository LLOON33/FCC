
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Mantención de Vehículo - FIRE CAR CONTROL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/icono.png" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <style>
        /* Cambiar el color del texto del navbar a negro */
        .navbar-custom .nav-link,
        .navbar-custom .navbar-brand {
            color: #000 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky sticky-dark">
        <div class="container">
            <a class="navbar-brand">Mantención de Vehículos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="ti-menu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="mecanico_dashboard.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido de la página -->
    <section class="d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-8">
                    <div class="bg-white p-4 rounded">
                        <h4 class="text-center fw-bold mb-3">Registro de Mantención</h4>

                        <?php
                        include "modelo/conexion.php";
                        include "controlador/procesar_mantenimiento.php";
                        $vehiculo_id = $_GET['vehiculo_id'] ?? null; // ID del vehículo

                        // Si es necesario, podrías obtener los datos del vehículo aquí
                        if ($vehiculo_id) {
                            $sql = "SELECT * FROM vehiculos WHERE id = ?";
                            if ($stmt = $conexion->prepare($sql)) {
                                $stmt->bind_param("i", $vehiculo_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $vehiculo = $result->fetch_assoc();
                            }
                        }
                        ?>

                        <form action="controlador/procesar_mantenimiento.php" method="POST">
                        <input type="hidden" name="vehiculo_id" value="<?= htmlspecialchars($vehiculo_id) ?>">


                            <!-- Tipo de mantención -->
                            <div class="mb-3">
                                <label for="tipo_mantenimiento" class="form-label">Tipo de Mantención</label>
                                <select id="tipo_mantenimiento" name="tipo_mantenimiento" class="form-select" required>
                                    <option value="">Selecciona el tipo de mantención</option>
                                    <option value="Preventiva">Preventiva</option>
                                    <option value="Correctiva">Correctiva</option>
                                </select>
                            </div>

                            <!-- Descripción -->
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción de la mantención realizada" required></textarea>
                            </div>

                            <!-- Fecha de mantención -->
                            <div class="mb-3">
                                <label for="fecha_mantenimiento" class="form-label">Fecha de Mantención</label>
                                <input type="date" class="form-control" id="fecha_mantenimiento" name="fecha_mantenimiento" required>
                            </div>

                            <!-- Costo -->
                            <div class="mb-3">
                                <label for="costo" class="form-label">Costo</label>
                                <input type="number" class="form-control" id="costo" name="costo" step="0.01" placeholder="Costo de la mantención" required>
                            </div>

                            <!-- Kilometraje al momento de la mantención -->
                            <div class="mb-3">
                                <label for="kilometraje_mantenimiento" class="form-label">Kilometraje en Mantención</label>
                                <input type="number" class="form-control" id="kilometraje_mantenimiento" name="kilometraje_mantenimiento" placeholder="Kilometraje actual del vehículo" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Registrar Mantención</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
