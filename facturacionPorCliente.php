<?php
session_start();
require_once "conexion.php";
$usuario = $_SESSION['username'];
if(!isset($usuario)){
    header("location:login.php");
}
$id_cliente = isset($_GET['id']) ? $_GET['id'] : '';

$ran=rand(1,10000);

$sql_facturas = "SELECT monto_pago, nombre, apellido, fecha_pago, reservas.cod_reserva from reservas as r
                 inner join facturacion
                 on r.id = facturacion.id_reserva
                 inner join credenciales
                 on credenciales.id = r.id_usuario
                 inner join usuarios
                 on usuarios.id = credenciales.id_usuario
                 inner join reservas
                 on facturacion.id_reserva = reservas.id
                 where r.id_usuario = '$id_cliente'";
$resultado_facturas = mysqli_query($conexion, $sql_facturas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturacion por cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/gr.css">
</head>
<?php include "header-admin.php" ?>
<body>
<div class="w3-container banda">
    <h3 class="w3-xxlarge w3-center">Facturación por cliente</h3>
</div>
<div class="w3-container w3-card-4 w3-content">
    <h3 class="w3-xlarge w3-center">Detalle de facturas</h3>
    <table class="w3-table-all detalle-fac">
        <tr>
            <td width="157"><b>Nombre</b></td>
            <td width="221"><b>Apellido</b></td>
            <td width="176"><b>Pago</b></td>
            <td width="176"><b>Codigo de Reserva</b></td>
            <td width="176"><b>Fecha pago</b></td>
            <td width="176"><b>Factura</b></td>
        </tr>
<?php
if($resultado_facturas) {
    while ($fila_facturas = mysqli_fetch_assoc($resultado_facturas)) {
        echo "<tr>
                <td>" . $fila_facturas['nombre'] . "</td>
                <td>" . $fila_facturas['apellido'] . "</td>
                <td>" . $fila_facturas['monto_pago'] . "</td>
                <td>" . $fila_facturas['cod_reserva'] . "</td>
                <td>" . $fila_facturas['fecha_pago'] . "</td>
                <td><a href='factura.php?numerofactura=" . $ran . "&nombre=" . $fila_facturas['nombre'] .
                             "&apellido=" . $fila_facturas['apellido'] . "&pago=" . $fila_facturas['monto_pago'] .
                             "&fechaPago=" .$fila_facturas['fecha_pago'] . "&idcliente=".$id_cliente."&codreserva=".$fila_facturas['cod_reserva']."'> Ver factura</a></td> 
          </tr>";
    }
}
?>
    </table>
</div>
</body>
<?php
include "pie.html";
?>
</html>