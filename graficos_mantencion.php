<?php  
require 'modelo/conexion.php'; // Conexión a la base de datos

// Consulta para mantenimientos por mes y tipo
$sqlMantenimientos = "SELECT tipo_mantenimiento, MONTH(fecha_mantenimiento) AS mes, COUNT(*) AS total 
                      FROM mantenimientos 
                      GROUP BY tipo_mantenimiento, MONTH(fecha_mantenimiento)";
$resultMantenimientos = $conexion->query($sqlMantenimientos);

$dataMantenimientos = [];
$totalMantenimientos = 0; // Variable para almacenar el total de mantenimientos

while ($row = $resultMantenimientos->fetch_assoc()) {
    $dataMantenimientos[] = $row;
    $totalMantenimientos += $row['total']; // Sumar el total de mantenimientos
}

// Convertir los datos a JSON para el frontend
$jsonMantenimientos = json_encode($dataMantenimientos);
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
                        <h4>Mantenimientos por Mes</h4>
                        <h5 id="totalMantenimientos">Total de mantenimientos: <?= $totalMantenimientos; ?></h5>
                        <canvas id="graficoMantenimientos"></canvas>

                        
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <script>
        const dataMantenimientos = <?= $jsonMantenimientos; ?>;

        let chartMantenimientos = null;

        function actualizarGraficas(filtroMes) {
            console.log('Actualizando gráficas con filtro de mes:', filtroMes);

            // Obtener los meses y tipos únicos
            const meses = [...new Set(dataMantenimientos.map(item => item.mes))];
            const tipos = [...new Set(dataMantenimientos.map(item => item.tipo_mantenimiento))];

            // Filtrar datos según el mes (si se aplica un filtro)
            const datosFiltrados = filtroMes 
                ? dataMantenimientos.filter(item => item.mes == filtroMes)
                : dataMantenimientos;

            // Calcular la suma total de todos los mantenimientos
            let suma = datosFiltrados.reduce((total, item) => total +parseInt(item.total, 10), 0);
            document.getElementById('totalMantenimientos').innerText = `Total de mantenimientos: ${suma}`;

            // Preparar datasets agrupados por tipo
            const datasets = tipos.map(tipo => {
                const datos = meses.map(mes => {
                    const item = datosFiltrados.find(d => d.tipo_mantenimiento === tipo && d.mes == mes);
                    return item ? item.total : 0;
                });
                return {
                    label: tipo,
                    data: datos,
                    backgroundColor: tipo === "Preventiva" ? 'rgba(54, 162, 235, 0.5)' : 'rgba(255, 99, 132, 0.5)',
                    borderColor: tipo === "Preventiva" ? 'rgba(54, 162, 235, 1)' : 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                };
            });

            // Destruir gráfico anterior
            if (chartMantenimientos) chartMantenimientos.destroy();

            // Crear nuevo gráfico
            const ctxMantenimientos = document.getElementById('graficoMantenimientos').getContext('2d');
            chartMantenimientos = new Chart(ctxMantenimientos, {
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
