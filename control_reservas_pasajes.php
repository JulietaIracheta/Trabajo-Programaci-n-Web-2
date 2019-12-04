<?php
session_start();
require_once "conexion.php";
require "funciones.php";

$tipo_viaje = $_POST['tipo_viaje'];
$id_viaje = $_POST['id_viaje'];
$id_usuario = $_SESSION['id'];
$idCapacidadCabina = $_POST['idCapacidadCabina'];
$cantidad_pasajes_a_reservar = $_POST['cantidad_pasajes_a_reservar'];
$id_estacion_destino = $_POST['id_destino'];
$codigo_vuelo = $_POST['codigo_vuelo'];
$id_circuito = $_POST['id_circuito'];

$error_form_acompaniante_nombre ='';
$error_form_acompaniante_apellido ='';
$error_form_acompaniante_email ='';
$estado ='';

/****************************************************************************************************************************/
/* Se obtiene capacidad de las cabinas y otros datos ************************************************************************/
/****************************************************************************************************************************/
$sql_cabina = "SELECT (filas*columnas) as capacidadCabina, origen as id_estacion_origen FROM viajes as v
                        INNER JOIN naves as n
                        ON v.nave = n.id
						INNER JOIN modelos_naves as mn
                        ON n.modelo = mn.id
                        inner join capacidad
                        on capacidad.modelo = mn.id
                        WHERE v.id = '$id_viaje'
                        and capacidad.id = '$idCapacidadCabina'";
$resultado_cabina = mysqli_query($conexion, $sql_cabina);
$fila_cabina = mysqli_fetch_assoc($resultado_cabina);
$capacidadCabina = $fila_cabina['capacidadCabina'];
$id_estacion_origen = $fila_cabina['id_estacion_origen'];


/**************************************************************************************************************/
/*    De acuerdo al sentido del viaje, ordena las estaciones   ****    Usado para ENTRE DESTINOS    ***********/
/**************************************************************************************************************/
$sql_sentido_del_vuelo = "select sentido from circuitos where id='$id_circuito'";
$resultado_sentido_del_vuelo = mysqli_query($conexion,$sql_sentido_del_vuelo);
$fila_sentido_del_vuelo = mysqli_fetch_assoc($resultado_sentido_del_vuelo);
$sentido_del_vuelo = $fila_sentido_del_vuelo['sentido'];

$sql_estaciones = "SELECT c.id as circuito, e.id, e.nombre FROM viajes as v
                    INNER JOIN circuitos as c
                    ON v.circuito_id = c.id
                    INNER JOIN circuitos_estaciones as ce
                    ON c.id = ce.circuito_id
                    INNER JOIN estaciones as e
                    ON ce.estacion_id = e.id
                    WHERE v.id = '$id_viaje'";

if($sentido_del_vuelo == 'ida'){
    $sql_estaciones .= " ORDER BY e.id asc";
}else{
    $sql_estaciones .= " ORDER BY e.id desc ";
}



$resultado_estaciones = mysqli_query($conexion,$sql_estaciones);
$error = "";
$reserva_realizada = false;


    // ********* VALIDO DATOS DEL FORMULARIO *************
    // Genero variables, para validar que lleguen datos en los campos (que no esten vacios)
    $campos_form_vacios = false;
    $class_error_alerta =  "class='w3-panel w3-red'";

    // Veo que se haya seleccionado una opcion de cabina de la nave
    if (empty($idCapacidadCabina)) {
        $error .= "<p>Debe seleccionar una cabina</p>";
        $class_error_alerta ="animated shake w3-red";
        $campos_form_vacios = true;
    }
    // veo que se haya ingresado un valor en pasajes a reservar
    if ($cantidad_pasajes_a_reservar <= 0) {
        $error .= "<p>La cantidad de pasajes a reservar tiene que ser como minimo igual a 1</p>";
        $class_error_alerta ="animated shake w3-red";
        $campos_form_vacios = true;
    }
    elseif($cantidad_pasajes_a_reservar>1) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $posicion_dato='lleno';

        foreach ($nombre as $valor) {
            if(empty($valor)){
                $error_form_acompaniante_nombre = "<br>- Falta/n nombre/s";
                $posicion_dato='vacio';
            }
        }
        foreach ($apellido as $valor) {
            if(empty($valor)){
                $error_form_acompaniante_apellido = "<br>- Falta/n apellido/s";
                $posicion_dato='vacio';
            }
        }
        foreach ($email as $valor) {
            if(empty($valor)){
                $error_form_acompaniante_email = "<br>- Falta/n email/s";
                $posicion_dato='vacio';
            }
            elseif(!$estructura_mail = valida_email($valor)) {
                $error_form_acompaniante_email = "<br>- Verifique la correcta escritura del/los email/s";
                $posicion_dato='vacio';
            }
        }

       if($posicion_dato=='vacio') {
           $error .= "Debe completar todos los datos del formulario";
           $error .= $error_form_acompaniante_nombre.$error_form_acompaniante_apellido.$error_form_acompaniante_email;
           $class_error_alerta ="animated shake w3-red";
           $campos_form_vacios = true;
       }
    }

    /////////////////////////////////////////////
    // Persisto datos si los campos estan llenos
    if ($campos_form_vacios == false) {

        // Genero codigo de reserva
        $longitud = 7;
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo_de_reserva = generarCodigo($longitud, $pattern);

        // Controlo tipo de viaje y persisto
        if ($tipo_viaje == "Tour" || $tipo_viaje == "Suborbitales") {
            $sql_reservas = "SELECT r.id_viajes , sum(cantidad) as cantidad FROM reservas as r
                                    WHERE r.codigo_vuelo = '$codigo_vuelo'
                                    and r.idCapacidadCabina = '$idCapacidadCabina'
                                    GROUP BY r.codigo_vuelo";
            $resultado = mysqli_query($conexion, $sql_reservas);
            $fila = mysqli_fetch_assoc($resultado);
            $capacidad_disponible = $capacidadCabina - $fila['cantidad'];


            if (($capacidad_disponible - $cantidad_pasajes_a_reservar) >= 0) {
                $sql_nueva_reserva = "INSERT INTO reservas (id_viajes,codigo_vuelo,cantidad,id_usuario,cod_reserva,estacion_origen,estacion_destino,idCapacidadCabina,pago,lista_espera,check_in,reserva_activa) VALUES
                                                        ('$id_viaje','$codigo_vuelo','$cantidad_pasajes_a_reservar','$id_usuario','$codigo_de_reserva','$id_estacion_origen','$id_estacion_destino','$idCapacidadCabina','0','0','0','1')";
                $consulta = mysqli_query($conexion, $sql_nueva_reserva);
                $reserva_realizada = true;
                $error = "<p>La reserva fue realizada con éxito.</p>";
                $class_error_alerta ="w3-green";
                $estado="ok";
            } else {

                $sql_nueva_reserva = "INSERT INTO reservas (id_viajes,codigo_vuelo,cantidad,id_usuario,cod_reserva,estacion_origen,estacion_destino,idCapacidadCabina,pago,lista_espera,check_in,reserva_activa) VALUES
                                                        ('$id_viaje','$codigo_vuelo','$cantidad_pasajes_a_reservar','$id_usuario','$codigo_de_reserva','$id_estacion_origen','$id_estacion_destino','$idCapacidadCabina','0','1','0','0')";
                $consulta = mysqli_query($conexion, $sql_nueva_reserva);
                $reserva_realizada = true;
                $error = "<p>La reserva entro en LISTA DE ESPERA.<br>Lo que significa que la misma esta pendiente de confirmación hasta que haya alguna cancelación de reserva.</p>";
                $class_error_alerta ="animated shake w3-yellow";
                $estado="ok";
            }

        } elseif ($tipo_viaje == "Entre destinos") {
            $sePuedeReservar = false;

                while($fila_estaciones = mysqli_fetch_assoc($resultado_estaciones)){

                    $sql_reservas_destino = "SELECT r.id_viajes, sum(cantidad) as cantidad FROM reservas as r 
                                                    WHERE r.codigo_vuelo = '$codigo_vuelo'
                                                    AND r.estacion_destino = '" . $fila_estaciones['id'] . "'
                                                    and r.idCapacidadCabina = '$idCapacidadCabina'
                                                    GROUP BY r.codigo_vuelo";
                    $resultado_reservas_destino = mysqli_query($conexion, $sql_reservas_destino);
                    $fila_reservas_destino = mysqli_fetch_assoc($resultado_reservas_destino);

                    if (mysqli_affected_rows($conexion) > 0) {
                        $capacidadCabina += $fila_reservas_destino['cantidad'];
                    }


                    $sql_reservas_origen = "SELECT r.id_viajes, sum(cantidad) as cantidad FROM reservas as r 
                                                    WHERE r.codigo_vuelo = '$codigo_vuelo'
                                                    AND r.estacion_origen = '" . $fila_estaciones['id'] . "'
                                                    and r.idCapacidadCabina = '$idCapacidadCabina'
                                                    GROUP BY r.codigo_vuelo";
                    $resultado_reservas_origen = mysqli_query($conexion, $sql_reservas_origen);
                    $fila_reservas_origen = mysqli_fetch_assoc($resultado_reservas_origen);

                    if (mysqli_affected_rows($conexion) > 0) {
                        $capacidadCabina -= $fila_reservas_origen['cantidad'];
                    }



                    if($sentido_del_vuelo == 'ida'){
                        $condicion =  $fila_estaciones['id'] >= $id_estacion_origen && $fila_estaciones['id'] < $id_estacion_destino;

                    }else{
                       $condicion = $fila_estaciones['id'] < $id_estacion_origen && $fila_estaciones['id'] >= $id_estacion_destino;
                    }

                    if ($condicion) {
                        if ($capacidadCabina < $cantidad_pasajes_a_reservar) {
                            $sePuedeReservar = false;
                            break;
                        }
                    } else {
                        $sePuedeReservar = true;
                    }

                }

                if($sePuedeReservar == true){
                    $sql_nueva_reserva = "INSERT INTO reservas (id_viajes,codigo_vuelo,cantidad,id_usuario,cod_reserva,estacion_origen,estacion_destino,idCapacidadCabina,pago,lista_espera,check_in,reserva_activa) 
                                                VALUES ('$id_viaje','$codigo_vuelo','$cantidad_pasajes_a_reservar','$id_usuario','$codigo_de_reserva','$id_estacion_origen','$id_estacion_destino','$idCapacidadCabina','0','0','0','1')";
                    $consulta = mysqli_query($conexion, $sql_nueva_reserva);
                    $reserva_realizada = true;
                    $error = "<p>La reserva fue realizada con éxito.</p>";
                    $class_error_alerta ="w3-green";
                    $estado="ok";

                }elseif ($sePuedeReservar == false){
                    $sql_nueva_reserva = "INSERT INTO reservas (id_viajes,codigo_vuelo,cantidad,id_usuario,cod_reserva,estacion_origen,estacion_destino,idCapacidadCabina,pago,lista_espera,check_in,reserva_activa) 
                                                VALUES ('$id_viaje','$codigo_vuelo','$cantidad_pasajes_a_reservar','$id_usuario','$codigo_de_reserva','$id_estacion_origen','$id_estacion_destino','$idCapacidadCabina','0','1','0','0')";
                    $consulta = mysqli_query($conexion, $sql_nueva_reserva);
                    $reserva_realizada = true;
                    $error = "<p>La reserva entro en LISTA DE ESPERA.<br>Lo que significa que la misma esta pendiente de confirmación hasta que haya alguna cancelación de reserva.</p>";
                    $class_error_alerta ="animated shake w3-yellow";
                    $estado="ok";
                }

        }


        // Obtengo el id de la reserva, para guardar a todos los integrantes de la reserva en la tabla "integrantes viaje"
        $sql_id_reserva = "select id from reservas where cod_reserva = '$codigo_de_reserva'";
        $resultado_id_reserva = mysqli_query($conexion, $sql_id_reserva);
        $fila_id_reserva = mysqli_fetch_assoc($resultado_id_reserva);
        $id_reserva = $fila_id_reserva['id'];


        // Guarda en la BD los datos de los acompañantes para que realicen el registro y posterior confirmación
        if ($cantidad_pasajes_a_reservar > 1) {

            for ($i=0;$i<$cantidad_pasajes_a_reservar-1;$i++) {

                $sql_email = "SELECT email FROM usuarios WHERE email = '$email[$i]'";
                $resultado_email = mysqli_query($conexion,$sql_email);
                $lista_email = mysqli_fetch_all($resultado_email);
                if(!empty($lista_email)) {
                    $error .= "<p class='w3-red'>El Email ".$email[$i]." ya existe en nuestra base de datos</p>";
                }
                else {
                    $sql_datos_acompaniantes = "insert into usuarios (nombre, apellido, email, nivel_vuelo, se_chequeo, confirmacion_mail)
                                            values ('$nombre[$i]','$apellido[$i]','$email[$i]','0','0','0')";
                    $consulta_datos_acompañantes = mysqli_query($conexion, $sql_datos_acompaniantes);
                }

                // Guarda en la tabla "integrantes_viaje", a los acompañantes
                $sql_id_usuario_acompaniantes = "select id from usuarios where email = '$email[$i]'";
                $resultado_id_usuario_acompaniantes = mysqli_query($conexion, $sql_id_usuario_acompaniantes);
                $filas_id_usuario_acompaniantes = mysqli_fetch_assoc($resultado_id_usuario_acompaniantes);
                $id_usuario_acompaniantes = $filas_id_usuario_acompaniantes['id'];

                $sql_integrantes_reserva = "insert into integrantes_viaje (id_usuarios, id_reserva) values('$id_usuario_acompaniantes','$id_reserva')";
                $resultado_integrantes_reserva = mysqli_query($conexion, $sql_integrantes_reserva);

            }
        }

        // Guarda en la tabla "integrantes_viaje", al que realiza la reserva
        $sql_id_usuario_reserva = "select id_usuario from credenciales where id ='$id_usuario'";
        $resultados_id_usuario_reserva = mysqli_query($conexion, $sql_id_usuario_reserva);
        $fila_id_usuario_reserva = mysqli_fetch_assoc($resultados_id_usuario_reserva);
        $id_usuario_reserva = $fila_id_usuario_reserva['id_usuario'];

        $sql_integrantes_reserva = "insert into integrantes_viaje (id_usuarios, id_reserva) values('$id_usuario_reserva','$id_reserva')";
        $resultado_integrantes_reserva = mysqli_query($conexion, $sql_integrantes_reserva);

    }

$mensajeFinal = array('mensaje' => $error,'clase' => $class_error_alerta,'estado' => $estado);
$jsonstring = json_encode($mensajeFinal);
echo $jsonstring;
?>