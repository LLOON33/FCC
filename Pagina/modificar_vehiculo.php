<?php
include "modelo/conexion.php";
$id = $_GET["id"];
$sql = $conexion->query("SELECT * FROM vehiculos WHERE id=$id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>FIRE CAR CONTROL</title>
    <!-- Incluye todos los estilos necesarios -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/style.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="images/icono.png" />
</head>
<body class= "bg-login">
   <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark" id="navbar">
       <div class="container">
           <a class="navbar-brand">Datos de vehiculos</a>
           <!-- Resto de la barra de navegación -->
       </div>
   </nav>

   <section class=" d-flex align-items-center">
       <div class="container">
           <div class="row justify-content-center mt-4">
               <div class="col-lg-4">
                   <div class="text-center page-heading">
                       <h1 class="text-white">Modificar vehiculo</h1>
                   </div>
                   <div class="bg-white p-4 rounded">
                       <form class="login-form" method="POST" action="controlador/modificar_car.php">
                           <input type="hidden" name="id" value="<?= $_GET['id'] ?>"> <!-- Asegúrate de tener el ID aquí -->

                           <?php 
                           while($datos = $sql->fetch_object()) { ?>
                               <div class="row">
                                   <div class="col-lg-12 mt-2">
                                       <input type="text" class="form-control" placeholder="Ingrese patente" name="patente" value="<?= $datos->patente ?>">
                                   </div>
                                   <div class="col-lg-12 mt-2">
                                       <input type="text" class="form-control" placeholder="Ingrese tipo de vehículo" name="tipo" value="<?= $datos->tipo ?>">
                                   </div>
                                   <div class="col-lg-12 mt-2">
                                       <input type="text" class="form-control" placeholder="Ingrese modelo" name="modelo" value="<?= $datos->modelo ?>">
                                   </div>
                                   <div class="col-lg-12 mt-2">
                                       <input type="number" class="form-control" placeholder="Ingrese año del vehículo" name="anno" value="<?= $datos->anno ?>">
                                   </div>
                                   <div class="col-lg-12 mt-2">
                                       <input type="number" class="form-control" placeholder="Ingrese kilometraje" name="kilometraje_actual" value="<?= $datos->kilometraje_actual ?>">
                                   </div>
                                   <div class="col-lg-12 mt-2">
                                        <label for="estado" class="form-label">Estado del Vehículo</label>
                                        <select class="form-control" id="estado" name="estado" required>
                                            <option value="Activo" <?= $datos->estado == "Activo" ? 'selected' : '' ?>>Activo</option>
                                            <option value="Inactivo" <?= $datos->estado == "Inactivo" ? 'selected' : '' ?>>Inactivo</option>
                                        </select>
                                    </div>
                                   <div class="col-lg-12 mt-2">
                                       <input type="date" class="form-control" placeholder="Ingrese fecha de ingreso" name="fecha_ingreso" value="<?= $datos->fecha_ingreso ?>">
                                   </div>
                               </div>
                           <?php } ?>

                           <div class="col-lg-12 mt-3 mb-4">
                               <button type="submit" class="btn btn-primary w-100" name="btnregistrar" value="ok">Modificar</button>
                           </div>
                           <div class="text-center">
                               <p class="mb-0 mt-2 text-center">
                                   <a href="vehiculo.php" class="text-dark fw-bold">Regresar</a>
                               </p>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </section>
</body>
</html>

</html>