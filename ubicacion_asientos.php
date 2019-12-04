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
require_once "funciones.php";

$codigo_reserva = isset($_GET['reserva']) ? $_GET['reserva'] : '';

$sql_datos_reserva = "select cantidad, id_viajes, idCapacidadCabina, filas, columnas, estacion_origen, estacion_destino, naveNombre, cabinaNombre, codigo_vuelo from reservas
                        inner join capacidad
                        on reservas.idCapacidadCabina = capacidad.id
                        inner join modelos_naves
                        on capacidad.modelo = modelos_naves.id
                        inner join cabina
                        on capacidad.tipo_cabina = cabina.id
                        where cod_reserva ='$codigo_reserva'";
$resultado_datos_reserva = mysqli_query($conexion, $sql_datos_reserva);
$datos_reserva = mysqli_fetch_assoc($resultado_datos_reserva);

$cantidad_asientos_reservados = $datos_reserva ['cantidad'];
$id_vuelo = $datos_reserva ['id_viajes'];  /// Se deberia renombrar en la tabla reservas el campo cod_vuelo por vuelo, para una mas facil comprension del campo al que hace referencia. OJO de hacer esto corregir el codigo en reservas.php
$tipo_cabina = $datos_reserva ['idCapacidadCabina'];
$filas_cabina = $datos_reserva['filas'];
$columnas_cabina = $datos_reserva['columnas'];
$estacion_origen = $datos_reserva['estacion_origen'];
$estacion_destino = $datos_reserva['estacion_destino'];
$naveNombre = $datos_reserva['naveNombre'];
$cabinaNombre = $datos_reserva['cabinaNombre'];
$codigo_vuelo = $datos_reserva['codigo_vuelo'];


$sql_datos_nave = "select * from viajes
                    left outer join naves
                    on viajes.nave = naves.id
                    where viajes.id='$id_vuelo'";

$resultado_datos_nave = mysqli_query($conexion, $sql_datos_nave);
$datos_nave = mysqli_fetch_assoc($resultado_datos_nave);
$fecha_hora = $datos_nave['fecha_hora'];
$codigo_vuelo = $datos_nave['codigo_vuelo'];

$nombre_estacion_origen = determina_nombre_estacion($estacion_origen);
$nombre_estacion_destino = determina_nombre_estacion($estacion_destino);

$sql_menu = "select * from menu";
$resultado_menu = mysqli_query($conexion, $sql_menu);




/* consulto la bd para ver que asientos ya hay reservados */
$sql= "select asiento from ubicacion where codigo_vuelo ='$codigo_vuelo'";
$resultado = mysqli_query($conexion, $sql);

$registro = mysqli_fetch_assoc($resultado);
$reg=$registro['asiento'];
while ($registro = mysqli_fetch_assoc($resultado)){
    $reg = $reg .','. $registro['asiento'];
}
$array = explode(",", $reg);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Check-in</title>
    <link rel="stylesheet" href="css/resetcss.css">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="stylesheet" href="css/gr.css">
</head>
<body>
<?php include "header.php" ?>
<div class="w3-container banda">
    <p class="w3-xxlarge w3-center selec-asientos">Selección de asientos</p>
    <div class="datos-reserva">
        <p class="w3-xlarge">Datos de la reserva</p><br>
        Reserva: <b><?php echo $codigo_reserva ?></b><br>
        Vuelo: <b><?php echo $codigo_vuelo ?></b><br>
        Fecha/Hora: <b><?php echo $fecha_hora ?></b><br>
        Origen: <b><?php echo $nombre_estacion_origen ?></b><br>
        Destino: <b><?php echo $nombre_estacion_destino ?></b><br>
        Nave: <b><?php echo $naveNombre ?></b><br>
        Cabina: <b><?php echo $cabinaNombre ?></b><br>
        <span class="destacado">Reserva para: <b><?php echo $cantidad_asientos_reservados ?></b> persona/s</span>
    </div>
</div>


<form id="ubicacion_asientos">

    <p class="item-reserva det1">Seleccione el menú</p>
    <?php
    echo "<div class='opciones-menu'>";
    while($menu = mysqli_fetch_array($resultado_menu)){
    echo "<label>$menu[nombre_menu]</label><input type='radio' name='menu' value='$menu[id_menu]' id='menu'>";
    }
    echo "</div>";
    ?>

    <p class="item-reserva">Seleccione el/los asientos</p>
    <div class="cabina-asientos">
    <input name="cantidad_asientos_reservados" type="hidden" value="<?php echo $cantidad_asientos_reservados ?>">
    <input name="codigo_reserva" type="hidden" value="<?php echo $codigo_reserva ?>">
    <?php
        for ($fila=1; $fila<=$filas_cabina; $fila++){
            echo "<div>";
            for ($columna=1; $columna<=$columnas_cabina; $columna++){
                $ubicacion = "c".$columna."f".$fila;
                $numero_asiento= (($fila-1)*$columnas_cabina+$columna);

                if (in_array($ubicacion, $array)){
                    echo "<label class='asientos reservado'>
                          <p>Asiento ".$numero_asiento."<br>F".$fila." - C".$columna."<br><span class='reservado'>Reservado</span></p>
                          </label>";
                }
                else {
                    echo "<label class='asientos vacante'>
                          <p>Asiento ".$numero_asiento."<br>F".$fila." - C".$columna."</p>
                          <input type='checkbox' name='asiento[]' value='".$ubicacion."' id='asiento'><p class='disponible'>Disponible</p>
                          </label>";
                }
            }
            echo "</div>";
        }
    ?>
    </div>
    <input type="submit" name="enviar" value="Reservar ubicación" id="btn-accion">
    <div id="mensaje"></div>
    <div id="codigo"></div>
</form>

<script src="js/jquery.min.js"></script>
<script src="js/seleccion_asientos.js"></script>
<?php include "pie.html";?>
</body>
</html>