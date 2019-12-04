<?php
session_start();
$usuario = $_SESSION['username'];
if(!isset($usuario)){
    header("location:login.php");
}
$rol = $_SESSION['rol'];
if($rol != 1){
    header("location:login.php");
}
require_once "conexion.php";
$email = isset($_POST['email']) ? $_POST['email'] : '';

//******************************************************
// Solo busca entre los los clientes que tengan facturas
//******************************************************
$busqueda_cliente = "select distinct credenciales.id, nombre, apellido, email from credenciales
                    inner join usuarios
                    on credenciales.id_usuario = usuarios.id
                    inner join reservas
                    on reservas.id_usuario = credenciales.id
                    inner join facturacion
                    on reservas.id = facturacion.id_reserva
                    where email like '%$email%'";


//*****************************************************
// busca entre todos los clientes, tengan o no facturas
//*****************************************************
//$busqueda_cliente = "select credenciales.id, nombre, apellido, email from credenciales
//                         inner join usuarios
//                         on credenciales.id_usuario = usuarios.id
//                         where email like '%$email%'";
$resultado_busqueda_cliente = mysqli_query($conexion, $busqueda_cliente);

$json = array();
while ($filas_busqueda_cliente = mysqli_fetch_assoc($resultado_busqueda_cliente)) {
    $json[] = array(
        'id' => $filas_busqueda_cliente['id'],
        'nombre' => $filas_busqueda_cliente['nombre'],
        'apellido' => $filas_busqueda_cliente['apellido'],
        'email' => $filas_busqueda_cliente['email']
    );
}

$jsonstring = json_encode($json);
echo $jsonstring;
?>