<?php
session_start();
require_once "conexion.php";
require_once "vendor/autoload.php";
$numerofactura = $_GET ['numerofactura'];
$codigo_reserva = $_GET ['codreserva'];
$idcliente = $_GET ['idcliente'];
$nombre = $_GET ['nombre'];
$apellido = $_GET ['apellido'];
$pago = $_GET['pago'];
$fechaPago = $_GET['fechaPago'];
$usuario = $_SESSION['username'];
$date= date("Y-m-d");

$sql_datos_factura = "SELECT v.codigo_vuelo, v.fecha_hora, cantidad, est1.nombre as origen, est2.nombre as destino, naveNombre,
                     tipo_aceleracion, tipo_viajes.tipo_viaje as nombre_tipo_viaje, cabinaNombre FROM reservas as r
                     INNER JOIN viajes as v on r.id_viajes = v.id
                     inner join capacidad
                     on r.idCapacidadCabina = capacidad.id
                     inner join modelos_naves
                     on capacidad.modelo = modelos_naves.id
                     inner join tipo_viajes
                     on v.tipo_viaje = tipo_viajes.id
                     inner join cabina
                     on capacidad.tipo_cabina = cabina.id
                     inner join estaciones as est1
                     on r.estacion_origen = est1.id
                     inner join estaciones as est2
                     on r.estacion_destino = est2.id
                     WHERE r.id_usuario = '$idcliente'
                     and cod_reserva ='$codigo_reserva'";

$resultado_datos_factura = mysqli_query($conexion, $sql_datos_factura);
$fila_datos_factura = mysqli_fetch_assoc($resultado_datos_factura);
$codigo_vuelo = $fila_datos_factura['codigo_vuelo'];
$fecha_hora = $fila_datos_factura['fecha_hora'];
$cantidad = $fila_datos_factura['cantidad'];
$naveNombre = $fila_datos_factura['naveNombre'];
$tipo_aceleracion = $fila_datos_factura['tipo_aceleracion'];
$nombre_tipo_viaje = $fila_datos_factura['nombre_tipo_viaje'];
$cabina = $fila_datos_factura['cabinaNombre'];
$origen = $fila_datos_factura['origen'];
$destino = $fila_datos_factura['destino'];


$mpdf = new \Mpdf\Mpdf([

]);

$mpdf -> writeHtml("
<div style=\"border-bottom: 4px solid;\"><img src=\"img/cohete-espacial-mini.png\" style=\"
    float: left;
    margin-right: 30px;
\"><br><p style=\"
    font-family: cursive;
    font-size: 40px;
    margin-top: 0px;
    font-weight: bold;
    margin-bottom: 0px;
\">Gaucho Rocket</p></div>


<h3 style=\"
    margin-bottom: 5px;
    font-family: monospace;
    font-size: 18px;
\">DATOS DE LA EMPRESA</h3>
<table style=\"
    border: solid 1px #848282;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 50px;
    margin-left: 50px;
\"><tbody><tr>
        <td style=\"
    width: 300px;
\">Número de factura:</td>
        <td style=\"
    width: 200px;
\">$numerofactura</td>
    </tr>
    <tr>
        <td>Fecha emisión de factura:</td>
        <td>$date</td>
    </tr>
    <tr>
        <td>Nombre</td>
        <td>Gaucho Rocket</td>
    </tr>
    <tr>
        <td>Dirección:</td>
        <td>Florencio Varela 1903</td>
    </tr>
    <tr>
        <td>Provincia:</td>
        <td>Buenos Aires</td>
    </tr>
    <tr>
        <td>Código Postal:</td>
        <td>1754</td>
    </tr>
    <tr>
        <td>Teléfono:</td>
        <td>4480-8900</td>
    </tr>
    <tr>
        <td>Identificacion Fiscal de la tienda:</td>
        <td>11223344N</td>
    </tr>
    </tbody></table>
<h3 style=\"
    margin-bottom: 5px;
    font-family: monospace;
    font-size: 18px;
\">DATOS DEL CLIENTE</h3>
<table style=\"
    border: solid 1px #888787;
    padding: 20px;
    border-radius: 10px;
    margin-left: 50px;
\">
    <tbody style=\"
\">
    <tr>
        <td style=\"
    width: 300px;
\">Nombre/s:</td>
        <td style=\"
    width: 200px;
\">$nombre</td>
    </tr>
    <tr>
        <td>Apellido/s:</td>
        <td>$apellido</td>
    </tr>
    <tr>
        <td>Total de la factura:</td>
        <td>$$pago</td>
    </tr>
    <tr>
        <td>Fecha pago:</td>
        <td>$fechaPago</td>
    </tr>
    </tbody></table>
<h3 style=\"
    margin-bottom: 5px;
    font-family: monospace;
    font-size: 18px;
\">DETALLE DE LA FACTURA</h3>
<table style=\"
    border: solid 1px #888787;
    padding: 20px;
    border-radius: 10px;
    margin-left: 50px;
\">
    <tbody style=\"
\">
    <tr>
        <td style=\"
    width: 300px;
\">Fecha del viaje:</td>
        <td style=\"
    width: 200px;
\">$fecha_hora</td>
    </tr>
    <tr>
        <td>Cantidad de pasajes:</td>
        <td>$cantidad</td>
    </tr>
    <tr>
        <td>Código de vuelo:</td>
        <td>$codigo_vuelo</td>
    </tr>
    <tr>
        <td>Tipo de aceleración:</td>
        <td>$tipo_aceleracion</td>
    </tr>
    <tr>
        <td>Nave:</td>
        <td>$naveNombre</td>
    </tr>
        <tr>
        <td>Cabina:</td>
        <td>$cabina</td>
    </tr>
    <tr>
        <td>Tipo de viaje:</td>
        <td>$nombre_tipo_viaje</td>
    </tr>
    <tr>
        <td>Origen:</td>
        <td>$origen</td>
    </tr>
    <tr>
        <td>Destino:</td>
        <td>$destino</td>
    </tr>
    </tbody></table>  ",\Mpdf\HTMLParserMode::HTML_BODY);
$mpdf ->Output();

?>