<?php
session_start();
require_once 'conexion.php';
$usuario = $_SESSION['username'];
if(!isset($usuario)){
    header("location:login.php");
}

$tarjeta = isset($_POST['num_tarjeta']) ? $_POST['num_tarjeta'] : '';
$tipo_tarjeta = isset($_POST['tipo_tarjeta']) ? $_POST['tipo_tarjeta'] : '';
$titular_tarjeta = isset($_POST['titular_tarjeta']) ? $_POST['titular_tarjeta'] : '';
$fecha_expiracion = isset($_POST['fecha_expiracion']) ? $_POST['fecha_expiracion'] : '';
$anio_expiracion = isset($_POST['anio_expiracion']) ? $_POST['anio_expiracion'] : '';
$codigo_seguridad = isset($_POST['codigo_seguridad']) ? $_POST['codigo_seguridad'] : '';
$total_a_pagar = isset($_POST['total_a_pagar']) ? $_POST['total_a_pagar'] : '';
$id_reserva = isset($_POST['id_reserva']) ? $_POST['id_reserva'] : '';
date_default_timezone_set('America/Argentina/Buenos_Aires');
$anio_actual = (int)date("Y");
$mes_actual = (int)date("m");
$fecha_de_pago = date("Y-m-d");
$campos_vacios = false;
$error="";
$estado = "";
$num_tarjeta = "";

        $contador =1;
        if(is_array($tarjeta)){ // verifica que sea un array. Si llega vacia, No verifica   ** https://stackoverflow.com/questions/2630013/invalid-argument-supplied-for-foreach  ** https://thisinterestsme.com/invalid-argument-supplied-for-foreach/
            foreach ($tarjeta as $grupo_4_digitos){
                if(empty($grupo_4_digitos)){
                    $error .= "<p>Complete los dígitos del ".$contador."º grupo de números de la tarjeta</p>";
                    $campos_vacios = true;
                    $class_error_alerta ="animated shake w3-red";
                }
                if(!empty($grupo_4_digitos) && strlen($grupo_4_digitos) < 4){
                    $error .= "<p>El ".$contador."º grupo de números de la tarjeta no tiene 4 dígitos</p>";
                    $campos_vacios = true;
                    $class_error_alerta ="animated shake w3-red";
                }
                $contador++;
            }
        }
        if (empty($tipo_tarjeta)) {
            $error .= "<p>Seleccione el tipo de tarjeta</p>";
            $campos_vacios = true;
            $class_error_alerta ="animated shake w3-red";
        }
        if (empty($titular_tarjeta)) {
            $error .= "<p>Faltan los datos del titular</p>";
            $campos_vacios = true;
            $class_error_alerta ="animated shake w3-red";
        }
        if (empty($fecha_expiracion)) {
            $error .= "<p>La fecha de expiración no puede quedar vacia</p>";
            $campos_vacios = true;
            $class_error_alerta ="animated shake w3-red";
        }
        if (empty($anio_expiracion)) {
            $error .= "<p>El año de expiración no puede quedar vacio</p>";
            $campos_vacios = true;
            $class_error_alerta ="animated shake w3-red";
        }
        if (empty($codigo_seguridad)) {
            $error .= "<p>Ingrese el código de seguridad</p>";
            $campos_vacios = true;
            $class_error_alerta ="animated shake w3-red";
        }
        if (!empty($codigo_seguridad) && strlen($codigo_seguridad) < 3) {
            $error .= "<p>El código de seguridad debe tener 3 dígitos</p>";
            $campos_vacios = true;
            $class_error_alerta ="animated shake w3-red";
        }


        if ($campos_vacios==false) {
            foreach ($tarjeta as $t){
                $num_tarjeta.=$t;
            }

            if($anio_expiracion < $anio_actual || ($anio_expiracion == $anio_actual && $fecha_expiracion<$mes_actual)){
                $error = "<p>La tarjeta ingresada está vencida.</p>";
                $class_error_alerta ="animated shake w3-red";
            }else if(validarTarjeta($num_tarjeta,$tipo_tarjeta,$conexion) == true){
//                $sql_pago = "UPDATE reservas SET pago = 1 WHERE cod_reserva = '$cod_reserva'";
                $sql_pago = "UPDATE reservas SET pago = 1 WHERE id = '$id_reserva'";
                $resultado_pago = mysqli_query($conexion,$sql_pago);

                $sql_facturacion ="INSERT INTO facturacion (fecha_pago, monto_pago, id_reserva, numero_tarjeta, tipo_de_tarjeta, titular)
                                    VALUES ('$fecha_de_pago','$total_a_pagar','$id_reserva','$tarjeta[3]','$tipo_tarjeta','$titular_tarjeta')";
                $resultado_facturacion = mysqli_query($conexion,$sql_facturacion);

                $error = "<p>El pago ha sido realizado con éxito.</p>";
                $class_error_alerta ="w3-green";
                $estado = "ok";

            }else{
                $error = "<p>La tarjeta ingresada es incorrecta.</p>";
                $class_error_alerta ="animated shake w3-yellow";
            }
        }


function validarTarjeta($numero_tarjeta, $tipo_tarjeta,$conexion){
    $sql_validacion_tarjetas = "SELECT validacion_tarjeta FROM tarjetas_credito WHERE id ='$tipo_tarjeta'";
    $resultado_validacion_tarjetas = mysqli_query($conexion,$sql_validacion_tarjetas);

    while ($fila_validacion = mysqli_fetch_assoc($resultado_validacion_tarjetas)){
        if (preg_match($fila_validacion['validacion_tarjeta'], $numero_tarjeta)) {
            $tarjeta_valida = true;
        } else {
            $tarjeta_valida = false;
        }
    }
    return $tarjeta_valida;
}

$mensajeFinal = array('mensaje' => $error,'clase' => $class_error_alerta,'estado' => $estado);
$jsonstring = json_encode($mensajeFinal);
echo $jsonstring;
?>