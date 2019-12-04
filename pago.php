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
$id_usuario = $_SESSION['id'];
$cod_reserva = isset($_GET['reserva']) ? $_GET['reserva'] : '';
$error="";
require 'conexion.php';
require_once "funciones.php";

$anio_actual = date("Y");

$sql_meses = "SELECT * FROM meses";
$resultado_meses = mysqli_query($conexion, $sql_meses);

$sql_tarjetas = "SELECT id , tipo_tarjeta FROM tarjetas_credito";
$resultado_tarjetas = mysqli_query($conexion,$sql_tarjetas);

$sql_datos_reserva = "SELECT cap.precio, cab.cabinaNombre, cantidad, estacion_origen, estacion_destino, naveNombre, fecha_hora, r.codigo_vuelo, r.id as id_reserva FROM reservas as r
                    INNER JOIN capacidad as cap
                    ON r.idCapacidadCabina = cap.id
                    INNER JOIN cabina as cab
                    ON cap.tipo_cabina = cab.id
                    inner join viajes
                    on r.id_viajes = viajes.id
                    inner join modelos_naves
                    on cap.modelo = modelos_naves.id
                    WHERE r.cod_reserva = '$cod_reserva'";
$resultado_datos_reserva = mysqli_query($conexion,$sql_datos_reserva);
$fila_datos_reserva = mysqli_fetch_assoc($resultado_datos_reserva);
$precio = $fila_datos_reserva['precio'];
$cabina = $fila_datos_reserva['cabinaNombre'];
$cantidad_asientos = $fila_datos_reserva['cantidad'];
$estacion_origen = $fila_datos_reserva['estacion_origen'];
$estacion_destino = $fila_datos_reserva['estacion_destino'];
$naveNombre = $fila_datos_reserva['naveNombre'];
$fecha_hora = $fila_datos_reserva['fecha_hora'];
$codigo_vuelo = $fila_datos_reserva['codigo_vuelo'];
$id_reserva = $fila_datos_reserva['id_reserva'];

$nombre_estacion_origen = determina_nombre_estacion($estacion_origen);
$nombre_estacion_destino = determina_nombre_estacion($estacion_destino);

$total_a_pagar = $precio * $cantidad_asientos;
?>

<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Abonar</title>

    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel='stylesheet' href='css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/w3.css">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/gr.css">
</head>

<body>
<?php include "header.php" ?>

<div class="w3-container banda">
    <p class="w3-xxlarge w3-center">Pago de reservas</p><br>
    <div class="datos-reserva">
        <p>Datos de la reserva</p>
        Reserva: <b><?php echo $cod_reserva ?></b><br>
        Cabina: <b><?php echo $cabina ?></b><br>
        Precio por asiento: <b><?php echo $precio ?></b><br>
        Cantidad de asientos: <b><?php echo $cantidad_asientos ?></b><br>
        Nave: <b><?php echo $naveNombre ?></b><br>
        Fecha y hora: <b><?php echo $fecha_hora ?></b><br>
        Código de vuelo: <b><?php echo $codigo_vuelo ?></b><br>
        Origen: <b><?php echo $nombre_estacion_origen ?></b><br>
        Destino: <b><?php echo $nombre_estacion_destino ?></b><br>
        TOTAL: <b>$<?php echo $total_a_pagar ?><br>
    </div>
</div>
<?php
//if($pagoRealizado == false) {
?>
<!-- DATOS QUE ESTAN EN LA TARJETA-->
<div class="checkout">
    <div class="credit-card-box">
        <div class="flip">

            <div class="front">
                <div class="number"></div>
                <div class="card-holder">
                    <label>Titular de la tarjeta</label>
                    <div></div>
                </div>
                <div class="card-expiration-date">
                    <label>Expira</label>
                    <div></div>
                </div>
            </div>

            <div class="back">
                <div class="strip"></div>
                <div class="logo">

                </div>
                <div class="ccv">
                    <label>Codigo de seguridad</label>
                    <div></div>
                </div>
            </div>

        </div>
    </div>


    <!-- ACA COMIENZA EL FORMULARIO-->

    <form class="form" autocomplete="off" id="campos-tarjeta">
        <input type="hidden" name="total_a_pagar" value="<?php echo $total_a_pagar ?>">
        <input type="hidden" name="id_reserva" value="<?php echo $id_reserva ?>">

        <fieldset name="num_tarjeta">
            <label for="card-number">Número de tarjeta</label>
            <input type="num" id="card-number" class="input-cart-number" maxlength="4" name="num_tarjeta[]"/>
            <input type="num" id="card-number-1" class="input-cart-number" maxlength="4" name="num_tarjeta[]"/>
            <input type="num" id="card-number-2" class="input-cart-number" maxlength="4" name="num_tarjeta[]"/>
            <input type="num" id="card-number-3" class="input-cart-number" maxlength="4" name="num_tarjeta[]"/>
        </fieldset>
        <fieldset name="tipo_tarjeta">
            <label for="card-type">Tipo de Tarjeta</label>
            <div class="select">
                <select id="card-type" name="tipo_tarjeta">
                    <option value="">Seleccione un tarjeta</option>
                    <?php
                    while ($fila_tipo_tarjeta = mysqli_fetch_assoc($resultado_tarjetas)) {
                        echo "<option value='" . $fila_tipo_tarjeta['id'] . "'>" . $fila_tipo_tarjeta['tipo_tarjeta'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </fieldset>
        <fieldset>
            <label for="card-holder">Titular de la tarjeta</label>
            <input type="text" id="card-holder" name="titular_tarjeta"/>
        </fieldset>

        <fieldset class="fieldset-expiration">

            <label for="card-expiration-month">Fecha de expiracion</label>
            <div class="select">
                <select id="card-expiration-month" name="fecha_expiracion">
                    <option value="">Mes</option>
                    <?php
                    while ($fila_meses = mysqli_fetch_assoc($resultado_meses)) {
                        echo "<option value='" . $fila_meses['id'] . "'>" . $fila_meses['meses'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="select">
                <select id="card-expiration-year" name="anio_expiracion">
                    <option value="">Año</option>
                    <?php
                    for ($i = $anio_actual; $i <= ($anio_actual + 6); $i++) {
                        echo "<option value='" . $i . "'>$i</option>";
                    }
                    ?>
                </select>
            </div>
        </fieldset>
        <fieldset class="fieldset-ccv">
            <label for="card-ccv">Codigo de seguridad</label>
            <input type="text" id="card-ccv" maxlength="3" name="codigo_seguridad">
        </fieldset>
        <div class="limpia-float"></div>
        <button class="btn" type="submit" name="enviar" id="btn-accion">Aceptar</button>

        <div id='mensaje'></div>
    </form>
</div>
<?php
//}else if ($pagoRealizado == true){
//    echo $error;
//    echo "<br>";
//    echo "<div class='w3-center'><a href='inicio.php' class='w3-button w3-round-xlarge w3-blue'>Volver al inicio</a></div>";
//}
?>
<!-- partial -->
<script src='js/jquery.min.js'></script>
<script src="js/tarjeta_credito.js"></script>
<script src="js/pago_tarjeta.js"></script>
</body>
<?php
include "pie.html";
?>
</html>
