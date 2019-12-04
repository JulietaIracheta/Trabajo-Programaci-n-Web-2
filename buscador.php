<?php
session_start();
$usuario = $_SESSION['username'];
if(!isset($usuario)){
    header("location:login.php");
}
$rol = $_SESSION['rol'];
if($rol != 2){
    header("location:login.php");
}
require_once "conexion.php";
$sql_estaciones= "select * from estaciones";
$resultado_estaciones = mysqli_query($conexion, $sql_estaciones);
$registro_estaciones = mysqli_fetch_all($resultado_estaciones);
//$fecha_actual = date("Y-m-d H:i:s");
$fecha_minimo = date("Y-m-d",strtotime($fecha_actual."+ 0 days"));
$error_fecha = "";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <title>Busqueda de viajes</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/gr.css">

</head>
<body>
<?php include "header.php" ?>
<div class="w3-container banda">
    <p class="w3-xxlarge w3-center">Busqueda de viajes</p>
</div>

<div class="container">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#about" role="tab" data-toggle="tab">Vuelos Orbitales</a></li>
        <li><a href="#specs" role="tab" data-toggle="tab">Vuelos entre destinos</a></li>
        <li><a href="#reviews" role="tab" data-toggle="tab">Tours</a></li>
    </ul>

    <!-- Lenguetas -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="about">

            <!-- ORBITALES -->
            <p class="detalle_tipo_viaje">Vuelos Orbitales</p>
            <p class="descripcion">Los vuelos Orbitales salen todos los días de la semana, desde dos localidades diferentes.</p>

            <form id="orbital">
                <input id="tipo_viajes" name="tipo_viajes" type="hidden" value="2">
                <div class="selector">
                    <label for='fecha_salida' class="buscador">Fecha Salida:</label>
                    <input name="fecha_salida"type="date" min="<?php echo $fecha_minimo?>">
                </div>
                <div class="selector">
                    <label for="origen" class="buscador">Lugar de Salida:</label>
                    <select name="origen">
                        <?php
                        $es=0;
                        for ($es;$es<2;$es++) {
                            echo"<option value='".$registro_estaciones[$es][0]."'>".$registro_estaciones[$es][1]."</option>";
                        }
                        ?>
                    </select>
                </div>

                <button id="submit" type="submit" name="enviar">Buscar</button>
            </form>
        </div>

        <!-- ENTRE DESTINOS -->
        <div role="tabpanel" class="tab-pane fade" id="specs">
            <p class="detalle_tipo_viaje">Vuelos entre Destinos</p>
            <p class="descripcion">Estos vuelos se realizán todos los días de la semana.</p>
            <div class="distribucion">
                <form id="destinos">

                    <input name="tipo_viajes" type="hidden" value="3">
                    <div class="selector">
                        <label for='fecha_salida' class="buscador">Fecha Salida:</label>
                        <input name="fecha_salida"type="date" min="<?php echo $fecha_minimo?>">
                    </div>
                    <div class="selector">
                        <label for='origen' class="buscador">Lugar de Salida:</label>
                        <select name='origen' id="origen">
                            <option>Elija una opción</option>
                            <?php
                            $es=0;
                            while($es < count($registro_estaciones)) {
                                echo"<option value='".$registro_estaciones[$es][0]."'>".$registro_estaciones[$es][1]."</option>";
                                $es++;
                            }
                            ?>
                        </select>
                    </div>
                    <div id="estac"></div>
                    <div class="selector">
                        <label for='destino' class="buscador">Lugar de Destino:</label>
                        <select name='destino' id="estaciones">
                            <!-- Recibe los datos segun la estacion de origen que se haya seleccionado -->
                        </select>
                    </div>

                    <button type="submit" name="enviar">Buscar</button>
                </form>
                <div class="detalle-circuitos">
                    Circuito 1
                    <li>Bs.As/Ankara</li>
                    <li>EEI</li>
                    <li>Orbital Hotel</li>
                    <li>Luna</li>
                    <li>Marte</li>
                </div>
                <div class="detalle-circuitos">
                    Circuito 2
                    <li>Bs.As/Ankara</li>
                    <li>EEI</li>
                    <li>Luna</li>
                    <li>Ganimides</li>
                    <li>Europa</li>
                    <li>Io</li>
                    <li>Encedalo</li>
                    <li>Titan</li>
                </div>
            </div>
        </div>

        <!-- TOURS -->
        <div role="tabpanel" class="tab-pane fade" id="reviews">
            <p class="detalle_tipo_viaje">Tours</p>
            <p class="descripcion">Estos vuelos se realizan solamente los días domingos</p>
            <form id="tours">

                <input name="tipo_viajes" type="hidden" value="1">
                <input name="origen" type="hidden" value="1">
                <input name="destino" type="hidden" value="1">
                <div class="selector">
                    <label for='fecha_salida' class="buscador">Fecha Salida:</label>
                    <input name="fecha_salida"type="date" min="<?php echo $fecha_minimo?>">
                </div>

                <button type="submit" name="enviar">Buscar</button>
            </form>
        </div>
    </div>
    <?php

    if ($error_fecha == "") {
        if (mysqli_affected_rows($conexion) > 0) {
            echo "<table class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <td>Código de Vuelo</td>
                    <td>Fecha y Hora</td>
                    <td>Duración del viaje</td>
                    <td>Tipo</td>
                    <td>Nave</td>
                    <td>Circuito</td>
                    <td class='btn-reserva'></td>
                  </tr>
                 </thead>
                 <tbody id='resultados'>";
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontraron vuelos disponibles</p>";
        }
    }
    ?>
</div><!-- container -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- <script src="bootstrap/js/bootstrap.min.js"></script> -->

<!-- Bootstrap -->
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-2.2.4.min.js"></script>

<!-- <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script> -->
<script src="js/selector_viajes.js"></script>
</body>
<?php include "pie.html";?>
<?php
//$sesion = 2;  //Sesion = 2 es el usuario registrado
//if($sesion == 2){
//    echo "<script src='js/muestra.js'></script>";
//}
?>
</html>
