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
$error="";
require_once "conexion.php";
require_once "funciones.php";
$id_viaje = isset($_GET['viaje']) ? $_GET['viaje'] : '';
$id_destino = isset($_GET['destino']) ? $_GET['destino'] : '';
$id_circuito = isset($_GET['circuito']) ? $_GET['circuito'] : '';
$id_usuario = $_SESSION['id'];
$reserva_realizada = false;

//Inicializo los array que van a conformar el formulario de acompañantes para pasarlos al "formulario_acomaniantes.js" que los renderiza
$nombre=array();
$apellido=array();
$email=array();
$cantidad_pasajes_a_reservar='';


/****************************************************************************************************************************/
/* Se obtiene capacidad de las cabinas y otros datos ************************************************************************/
/****************************************************************************************************************************/
$sql_viaje = "SELECT tv.tipo_viaje, codigo_vuelo, fecha_hora, naveNombre, origen, cabinaNombre,
                     precio, capacidad.id as idCapacidadCabina, nombre FROM viajes as v
                        INNER JOIN tipo_viajes as tv
                        ON v.tipo_viaje = tv.id 
                        INNER JOIN naves as n
                        ON v.nave = n.id
                        INNER JOIN modelos_naves as mn
                        ON n.modelo = mn.id
                        inner join capacidad
                        on capacidad.modelo = mn.id
                        inner join cabina
                        on capacidad.tipo_cabina = cabina.id
                        inner join estaciones
                        on v.origen = estaciones.id
                        WHERE v.id = '$id_viaje'";
$resultado_viaje = mysqli_query($conexion, $sql_viaje);
$fila_viaje = mysqli_fetch_assoc($resultado_viaje);
$tipo_viaje = $fila_viaje['tipo_viaje'];
$codigo_vuelo = $fila_viaje['codigo_vuelo'];
$fecha_hora = $fila_viaje['fecha_hora'];
$nave = $fila_viaje['naveNombre'];
$origen = $fila_viaje['origen'];
$nombre_estacion_origen = $fila_viaje['nombre'];
$nombre_estacion_destino = determina_nombre_estacion($id_destino);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva de pasajes</title>
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/gr.css">
</head>
<body>
<?php include "header.php" ?>
<div class="w3-container banda">
    <p class="w3-xxlarge w3-center">Reservas de pasajes</p>
    <div class="datos-reserva">
        Datos de la busqueda seleccionada<br><br>
        Tipo de viaje: <?php echo $tipo_viaje ?><br>
        Vuelo: <?php echo $codigo_vuelo ?><br>
        Fecha/Hora: <?php echo $fecha_hora ?><br>
        Origen: <?php echo $nombre_estacion_origen ?><br>
        Destino: <?php echo $nombre_estacion_destino ?><br>
        Nave: <?php echo $nave ?>
    </div>
</div>

<div class="w3-display-container">
    <?php
    if ($reserva_realizada == false && $error == "") {
        echo "<form class='w3-container w3-card-4 w3-content' id='reserva-lugares'>
              
                Seleccione la cabina donde desea realizar su reserva
                <table class='reservas'>
                  <tr>
                    <th class='reservas'>Nombre de la cabina</th>
                    <th class='reservas'>Precio del pasajes</th>
                    <th class='reservas'></th>
                  </tr>
                  <tr>";

        mysqli_data_seek($resultado_viaje, 0);
        while ($fila_viaje = mysqli_fetch_assoc($resultado_viaje)){
            echo "<tr>
                            <td class='reservas'>".$fila_viaje['cabinaNombre']."</td>
                            <td class='reservas'>".$fila_viaje['precio']."</td>
                            <td class='reservas'><input type='radio' name='idCapacidadCabina' value='".$fila_viaje['idCapacidadCabina']."'></td>
                          </tr>";
        }

        echo "</table>

                <center>Cantidad de pasajes a reservar:
                <input type='number' name='cantidad_pasajes_a_reservar' min='0' id='acompaniantes' value='$cantidad_pasajes_a_reservar'></center>
        
                <input type='hidden' name='id_destino' value='$id_destino'>
                <input type='hidden' name='id_viaje' value='$id_viaje'>
                <input type='hidden' name='codigo_vuelo' value='$codigo_vuelo'>
                <input type='hidden' name='id_circuito' value='$id_circuito'>
                <input type='hidden' name='tipo_viaje' value='$tipo_viaje'><br><br> 
                
                <!-- Sector formularios de acompañantes-->       
                <div id='area-formularios'></div>
                <div class='limpia-float'></div>
                
                <div id='mensaje'></div>
                
                <center><button class='w3-button w3-round-xlarge w3-blue btn1' type='submit' name='enviar' id='btn-accion'>Aceptar</button></center>
                <center><a class='w3-button w3-round-xlarge w3-blue btn1' href='buscador.php'>Volver al buscador</a></center>
                </form>";
    }
    ?>

</div>
<script src="js/jquery.min.js"></script>
<script src="js/formulario_acompaniantes.js"></script>
<script src="js/jquery-2.2.4.min.js"></script>
<!-- <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script> -->
<script src="js/control_reservas_pasajes.js"></script>
</body>
<?php include "pie.html";?>
</html>