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
require "funciones.php";
$id_usuario = $_SESSION['id'];
$sql_reservas = "SELECT r.cod_reserva, v.codigo_vuelo, v.fecha_hora, r.pago, r.lista_espera, r.check_in, r.id, v.tipo_viaje as id_tipo_viaje,
                 cantidad, circuito_id, id_viajes, idCapacidadCabina, (filas*columnas) as capacidadCabina, estacion_origen,
                 estacion_destino, naveNombre, tipo_aceleracion, tipo_viajes.tipo_viaje as nombre_tipo_viaje, cabinaNombre,
                 est1.nombre as origen, est2.nombre as destino, precio FROM reservas as r
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
                 WHERE r.id_usuario = '$id_usuario'
                 order by fecha_hora asc";
$resultado_reservas = mysqli_query($conexion,$sql_reservas);
$sinReservas = false;
date_default_timezone_set('America/Argentina/Buenos_Aires');
$hoy = date("Y-m-d H:i:s");
if(mysqli_affected_rows($conexion) == 0){
    $sinReservas = true;
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/gr.css">
</head>
<?php include "header.php" ?>
<body>

<div class="w3-container banda">
    <p class="w3-xxlarge w3-center">Mis Reservas</p>
</div>
<div class="w3-container banda descripcion2">
    <p><span class="atencion">Pendiente de chequeo médico</span>Todavia no ha realizado el chequeo correspondiente</p>
    <p><span class="alerta">Reserva CANCELADA - No apto para el viaje</span>Se cancela la reserva por no obtener el apto médico necesario para el viaje</p>
    <p><span><span class="w3-button w3-round-xlarge w3-blue btn1 reserva2">Pagar</span></span>Se aprobo el chequeo médico, ya puede pagar la reserva</p>
    <p><span class="aprobado">Aprobada</span>Se ha aprobado el pago. En espera de la ventana de tiempo correspondiente para realizar el Check-in</p>
    <p><span><span class="w3-button w3-round-xlarge w3-green btn1 reserva2">Check-in</span></span>Ya puede realizar el Check-in</p>
    <p><span class="ok">OK - Apto para abordar la nave</span>El Check-in ya esta realizado. Esta en condiciones para abordar la nave cuando corresponda</p>
    <p><span class="alerta">Reserva CAIDA por falta de Check-In</span>Se cancela la reserva por no haber cumplimentado en tiempo el Check-in</p>
    <p><span class="atencion">Lista de espera</span>La reserva se haya en lista de espera</p>
    <p><span>El viaje ya partió</span></p>
</div>
<?php
if($sinReservas == false){
?>

<div class="w3-display-container">
<div class="w3-container w3-card-4 mis_reservas">
<table class="w3-table-all">
    <tr>
        <th width="111">Cod.Reserva
        <th>Origen</th>
        <th>Destino</th>
        <th width="114">Tipo</th>
        <th width="59">Veloc.</th>
        <th>Nave</th>
        <th width="71">Cabina</th>
        <th width="52">Cant.</th>
        <th>Precio</th>
        <th>Total</th>
        <th width="86">Cod.Vuelo</th>
        <th width="90">Fecha/Hora</th>
        <th>Estado</th>
    </tr>
    <?php
    while ($fila_reservas = mysqli_fetch_assoc($resultado_reservas)) {
        $fecha_vuelo = date("Y-m-d H:i:s",strtotime($fila_reservas['fecha_hora']));
//        $hora_vuelo = date("G-i-s",strtotime($fila_reservas['fecha_hora']));
//        $hora_checkIn = date("G-i-s",strtotime($fila_reservas['fecha_hora']."- 2 hour"));
        $fecha_checkIn_inicio = date("Y-m-d H:i:s", strtotime($fila_reservas['fecha_hora']."- 2 days"));
        $fecha_checkIn_fin = date("Y-m-d H:i:s", strtotime($fila_reservas['fecha_hora']."- 2 hour"));
        $boton = "";
        $codigo_reserva = $fila_reservas['cod_reserva'];
        $id_estacion_origen = $fila_reservas['estacion_origen'];
        $id_estacion_destino = $fila_reservas['estacion_destino'];
        $tipo_viaje = $fila_reservas['nombre_tipo_viaje'];
        $aceleracion = $fila_reservas['tipo_aceleracion'];
        $nombre_nave = $fila_reservas['naveNombre'];
        $nombre_cabina = $fila_reservas['cabinaNombre'];
        $origen = $fila_reservas['origen'];
        $destino = $fila_reservas['destino'];
        $cantidad = $fila_reservas['cantidad'];
        $precio = $fila_reservas['precio'];
        $codigo_vuelo = $fila_reservas['codigo_vuelo'];
        $total = $cantidad * $precio;

        $id_reserva = $fila_reservas['id'];
        $circuito_id = $fila_reservas['circuito_id'];
        $id_viajes = $fila_reservas['id_viajes'];
        $idCapacidadCabina = $fila_reservas['idCapacidadCabina'];
        $capacidadCabina = $fila_reservas['capacidadCabina'];
        $id_tipo_viaje = $fila_reservas['id_tipo_viaje'];

        //***************************************************
        // Se determina el grado obtenido en el cheque medico
        //***************************************************
        $sql_integrantes = "select id_usuarios from integrantes_viaje
                            where id_reserva = '$id_reserva'";
        $resultados_integrantes = mysqli_query($conexion, $sql_integrantes);
        $nivel_vuelo_grupal='3';

        while ($fila_integrantes = mysqli_fetch_assoc($resultados_integrantes)){
            $id_integrante = $fila_integrantes['id_usuarios'];

            $sql_nivel_vuelo = "select nivel_vuelo from usuarios
                                where id = '$id_integrante'";
            $resultados_nivel_vuelo = mysqli_query($conexion,$sql_nivel_vuelo);
            $fila_nivel_vuelo = mysqli_fetch_assoc($resultados_nivel_vuelo);
            $nivel_vuelo = $fila_nivel_vuelo['nivel_vuelo'];

            if($nivel_vuelo_grupal>$nivel_vuelo){
                $nivel_vuelo_grupal = $nivel_vuelo;
            }
        }

        //***********************************************
        // Se determina el tipo de aceleracion de la nave
        //***********************************************
        $sql_tipo_de_aceleracion = "select tipo_aceleracion from reservas
                                    inner join capacidad
                                    on reservas.idCapacidadCabina = capacidad.id
                                    inner join modelos_naves
                                    on capacidad.modelo = modelos_naves.id
                                    where cod_reserva = '$codigo_reserva'";

        $resultados_tipo_de_aceleracion = mysqli_query($conexion, $sql_tipo_de_aceleracion);
        $filas_tipo_de_aceleracion = mysqli_fetch_assoc($resultados_tipo_de_aceleracion);
        $tipo_de_aceleracion = $filas_tipo_de_aceleracion['tipo_aceleracion'];



        If($nivel_vuelo_grupal == 0){
            $boton = "<span class='atencion'>Pendiente de chequeo médico</span>";

        } else if($tipo_de_aceleracion == 'AA' && $nivel_vuelo_grupal < 3){
            $boton = "<span class='alerta'>Reserva CANCELADA - No apto para el viaje</span>";
            cambia_estado_reserva_caida($id_reserva);
            habilita_cupo_en_lista_espera($codigo_vuelo, $cantidad, $circuito_id, $id_viajes, $idCapacidadCabina, $capacidadCabina);

        } else if ($fila_reservas['pago'] == 0 && $fila_reservas['lista_espera'] != 1 ) {
            $boton = "<a class='w3-button w3-round-xlarge w3-blue btn1 reserva' href='pago.php?reserva=" . $fila_reservas['cod_reserva'] . "'>Pagar</a>";

        }else if($fila_reservas['pago'] == 1 && $fila_reservas['lista_espera'] != 1 && $fila_reservas['check_in'] != 1 && $hoy >= $fecha_checkIn_inicio && $hoy <= $fecha_checkIn_fin){
            $boton = "<a class='w3-button w3-round-xlarge w3-green btn1 reserva' href='ubicacion_asientos.php?reserva=".$fila_reservas['cod_reserva']."'>Check-In</a>";

        } else if ($fila_reservas['pago'] == 1 && $fila_reservas['lista_espera'] != 1 && $fila_reservas['check_in'] != 1 && $hoy < $fecha_checkIn_inicio) {
            $boton = "<span class='aprobado'>Aprobada</span>";

        } else if ($fila_reservas['pago'] == 1 && $fila_reservas['lista_espera'] != 1 && $fila_reservas['check_in'] == 1 && $hoy >= $fecha_checkIn_inicio) {
            $boton = "<span class='ok'>OK - Apto para abordar la nave - QR 
                      <a href='codigo-qr.php?codigo_reserva=".$codigo_reserva."'><img src='img/qr/codigo-".$codigo_reserva.".png' width='50px'></a></span>";

        } else if($fila_reservas['pago'] == 1 && $fila_reservas['lista_espera'] != 1 && $fila_reservas['check_in'] != 1 && $hoy >= $fecha_checkIn_inicio && $hoy > $fecha_checkIn_fin){
            $boton = "<span class='alerta'>Reserva CAIDA por falta de Check-In</span>";

        } else if ($fila_reservas['pago'] != 1 && $fila_reservas['lista_espera'] == 1 && $fila_reservas['check_in'] != 1) {
            $boton = "<span class='atencion'>Lista de espera</span>";
        }else{
            $boton = "<span class='alerta'>Error en estado de Reserva</span>";
        }
        if($fecha_vuelo <= $hoy){
            $boton = "El viaje ya partió";

        }

        echo "<tr>
              <td>" . $codigo_reserva . "</td>
              <td>" . $origen . "</td>
              <td>" . $destino . "</td>
              <td>" . $tipo_viaje . "</td>
              <td>" . $aceleracion . "</td>
              <td>" . $nombre_nave . "</td>
              <td>" . $nombre_cabina . "</td>
              <td>" . $cantidad . "</td>
              <td>$ " . $precio . "</td>
              <td>$ " . $total . "</td>
              <td>" . $codigo_vuelo . "</td>
              <td>" . $fila_reservas['fecha_hora'] . "</td>
              <td>" .$boton . "</td>";
    }
}else if($sinReservas == true){
    echo "<p class='w3-center animated shake w3-red cuadro-mensaje'>No tiene reservas activas.</p>";
    }
    ?>
</table>
</div>
</body>
<?php include "pie.html";?>
</html>