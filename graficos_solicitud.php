<?php  
require 'modelo/conexion.php'; // Conexión a la base de datos

// Consulta para obtener los nombres de los vehículos
$sqlVehiculos = "SELECT id, tipo FROM vehiculos"; // Asegúrate de que la tabla 'vehiculos' tenga los nombres
$resultVehiculos = $conexion->query($sqlVehiculos);
$vehiculos = [];
while ($row = $resultVehiculos->fetch_assoc()) {
    $vehiculos[$row['id']] = $row['tipo']; // Asignamos el id del vehículo a su nombre
}

// Consulta para solicitudes por mes y vehículo
$sqlSolicitudes = "SELECT vehiculo_id, MONTH(fecha_solicitud) AS mes, COUNT(*) AS total 
                   FROM vehiculos_solicitados 
                   GROUP BY vehiculo_id, MONTH(fecha_solicitud)";
$resultSolicitudes = $conexion->query($sqlSolicitudes);

$dataSolicitudes = [];
$totalSolicitudes = 0; // Variable para almacenar el total de solicitudes

while ($row = $resultSolicitudes->fetch_assoc()) {
    $dataSolicitudes[] = $row;
    $totalSolicitudes += (int)$row['total']; // Asegurarse de que el total sea numérico
}

// Convertir los datos a JSON para el frontend
$jsonSolicitudes = json_encode($dataSolicitudes);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>FIRE CAR CONTROL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/icono.png" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/colors/green.css" id="color-opt">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .text-center p {
            margin-bottom: 10px; /* Ajustar espaciado */
        }
    </style>
</head>

<body>
    <section class="bg-login d-flex align-items-center">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm">
                        <h4>Filtrar Datos</h4>
                        <form id="filtroForm">
                            <div class="form-group">
                                <label for="filtroMes">Mes</label>
                                <select id="filtroMes" class="form-control">
                                    <option value="">Todos</option>
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?= $i; ?>">Mes <?= $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <button type="button" id="filtrarButton" class="btn btn-primary mt-2">Filtrar</button>
                        </form>     
                    </div>
                    <div class="text-center">
                        <p class="mb-0 mt-2 text-center">
                            <a href="index.php" class="text-white fw-bold">Regresar</a>
                        </p>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card p-3 shadow-sm">
                        <h4>Solicitudes por Mes</h4>
                        <h5 id="totalSolicitudes">Total de solicitudes: <?= $totalSolicitudes; ?></h5>
                        <canvas id="graficoSolicitudes"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const dataSolicitudes = <?= $jsonSolicitudes; ?>;
        const vehiculos = <?= json_encode($vehiculos); ?>; // Pasamos los nombres de los vehículos al frontend

        let chartSolicitudes = null;

        function actualizarGraficas(filtroMes) {
            console.log('Actualizando gráficas con filtro de mes:', filtroMes);

            // Obtener los meses únicos
            const meses = Array.from({ length: 12 }, (_, i) => i + 1);
            const vehiculosIds = Object.keys(vehiculos); // Vehículos con ID

            // Filtrar datos según el mes (si se aplica un filtro)
            const datosFiltrados = filtroMes
                ? dataSolicitudes.filter(item => item.mes == filtroMes)
                : dataSolicitudes;

            // Verificar si hay datos filtrados
            if (datosFiltrados.length === 0) {
                document.getElementById('graficoSolicitudes').style.display = 'none';
                alert('No hay datos disponibles para este filtro.');
                return;
            } else {
                document.getElementById('graficoSolicitudes').style.display = 'block';
            }

            // Calcular la suma total de solicitudes
            let suma = datosFiltrados.reduce((total, item) => total + parseInt(item.total, 10), 0);
            document.getElementById('totalSolicitudes').innerText = `Total de solicitudes: ${suma}`;

            // Preparar datasets agrupados por vehículo
            const colors = vehiculosIds.map((_, index) => `hsl(${index * 360 / vehiculosIds.length}, 70%, 50%)`); // Colores dinámicos
            const datasets = vehiculosIds.map((vehiculoId, index) => {
                const datos = meses.map(mes => {
                    const item = datosFiltrados.find(d => d.vehiculo_id == vehiculoId && d.mes == mes);
                    return item ? item.total : 0;
                });
                return {
                    label: vehiculos[vehiculoId], // Usar el nombre del vehículo en lugar del ID
                    data: datos,
                    backgroundColor: colors[index] + '80', // Colores con transparencia
                    borderColor: colors[index],
                    borderWidth: 1
                };
            });

            // Destruir gráfico anterior
            if (chartSolicitudes) chartSolicitudes.destroy();

            // Crear nuevo gráfico
            const ctxSolicitudes = document.getElementById('graficoSolicitudes').getContext('2d');
            chartSolicitudes = new Chart(ctxSolicitudes, {
                type: 'bar',
                data: {
                    labels: meses.map(m => `Mes ${m}`),
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Inicializar gráfico
        actualizarGraficas("");

        // Evento para filtrar
        document.getElementById('filtrarButton').addEventListener('click', function () {
            const filtroMes = document.getElementById('filtroMes').value;
            actualizarGraficas(filtroMes);
        });
    </script>
</body>
</html>
