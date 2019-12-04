<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/gr.css">
</head>

<?php
session_start();
require_once "conexion.php";
require "funciones.php";
$usuario = $_SESSION['username'];
if(!isset($usuario)){
    header("location:login.php");
}
$id_usuario_session = $_SESSION['id'];
$rol = $_SESSION['rol'];

switch ($rol) {
    case 1:
        include "header-admin.php";
        habilita_lista_de_espera();
        echo "<body>
        <p class='panel-control'>Panel de Control</p>";
        break;
    case 2:
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $hoy = date("Y-m-d");

        $sql_id_usuario = "select id_usuario from credenciales where id = '$id_usuario_session'";
        $resultado_id_usuario = mysqli_query($conexion,$sql_id_usuario);
        $fila_id_usuario = mysqli_fetch_assoc($resultado_id_usuario);
        $numero_de_usuario = $fila_id_usuario['id_usuario'];

        $sql_verifica_chequeoMedico = "select se_chequeo from usuarios where id = '$numero_de_usuario'";
        $resultado_verifica_chequeoMedico = mysqli_query($conexion, $sql_verifica_chequeoMedico);
        $fila_verifica_chequeoMedico = mysqli_fetch_assoc($resultado_verifica_chequeoMedico);
        $chequeo_medico = $fila_verifica_chequeoMedico['se_chequeo'];


        // Si no hizo el chequeo medico, verifica fecha del turno para asignar resultado del chequeo médico
        if($chequeo_medico == 0){
            $sql_turno = "SELECT fecha FROM turnos WHERE id_usuario = '$numero_de_usuario'";
            $resultado_turno = mysqli_query($conexion,$sql_turno);
            $fila_turno = mysqli_fetch_assoc($resultado_turno);

            if($fila_turno){
                if($fila_turno['fecha']<=$hoy){
                    $codigo_generado = random_int(1,3);
                    $sql_nivel_de_vuelo = "UPDATE usuarios SET nivel_vuelo = '$codigo_generado', se_chequeo = 1  WHERE id='$numero_de_usuario'";
                    $resultado_nivel_de_vuelo = mysqli_query($conexion,$sql_nivel_de_vuelo);
                }
            }
        }

        include "header.php";

        echo "<body>
        <div class='w3-container banda'>
            <p class='w3-xxxlarge w3-center w3-lobster'>Bienvenido ". $usuario ." a Gaucho Rocket<img src='img/cohete-espacial-mini.png'></p>
            <div class='bienvenida'>
                <p>Recuerde que:</p>
                <li>Si al realizar la reserva, el cupo de la cabina está lleno, su reserva entra en lista de esperá. La misma se activa 2Hs antes de la partida de la nave</li>
                <li>Una vez hecha la reserva, deberá sacar un turno en alguno de nuestros 3 centros médicos, para realizar un chequeo y saber si apto para realizar el viaje</li>
                <li>La reserva puede ser hecha de forma grupal, pero los turnos para el chequeo médico, se tramitan de forma individual</li>
                <li> De no llegar en el chequeo médico, al nivel requerido para realizar el vuelo, la reserva será dada de baja de forma automática</li>
                <li>Si la reserva es grupal, y un integrante no pasa el chequeo médico, cae toda la reserva grupal</li>
                <li>Aprobado el chequeo médico, debe realizar el pago. El mismo debe estar efectuado para poder realizar el Check-in</li>
                <li>El Check-in debe realizarse entre las 48Hs y 2Hs antes de la partida de la nave. De no realizarse, cae automaticamente la reserva y no hay devolución del pago</li>
            </div>
        </div>";
        break;
}
echo "</body>";
include "pie.html";
?>