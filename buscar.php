<?php
require_once "conexion.php";

$tipo_viajes = $_POST['tipo_viajes'];
$fecha_salida = $_POST['fecha_salida'];
$origen = $_POST['origen'];

// Segun el tipo de viaje, determino el destino
if ($tipo_viajes == 2) {    // 2 son vuelos Orbitales
    $destino = $origen;
}
else {
    $destino = $_POST['destino'];
}

// Segun el tipo de viaje, determino en que circuitos realizar la busqueda
$and = " and circuito_id in ";
if($tipo_viajes == 3) {    //Si es Entre Destinos
    if($destino > $origen){  //Si es de Ida
        $and .= "(1,2)";
    }else{                   //Si es de vuelta
        $and .= "(5,6)";
    }
}else{                  // Si es Orbital o Tour
    if($origen ==1) {   //Si sale de BS AS
        $and .= "(3)";
    }else if ($origen == 2){   //Si sale de Ankara
        $and .= "(4)";
    }
}

if(empty($fecha_salida)){
    $hoy = date("Y-m-d H:i:s");
    $opcion_fecha ="where fecha_hora > '$hoy%'";
}
else{
    $opcion_fecha ="where fecha_hora like '$fecha_salida%'";
}

$sql = "select viajes.id, fecha_hora, duracion, naveNombre, codigo_vuelo, circuitos.nombre as nombre_circuito, circuito_id, tipo_aceleracion from viajes
                left outer join naves
                on viajes.nave = naves.id  
                left outer join modelos_naves
                on naves.modelo = modelos_naves.id
                inner join circuitos
                on viajes.circuito_id = circuitos.id
                ".$opcion_fecha."
                and tipo_viaje = '$tipo_viajes'
                and origen = '$origen'" . $and.
    "order by fecha_hora asc";

$resultado = mysqli_query($conexion, $sql);

$json = array();
while ($fila = mysqli_fetch_array($resultado)) {
    $json[] = array(
        'id' => $fila['id'],
        'fecha_hora' => $fila['fecha_hora'],
        'duracion' => $fila['duracion'],
        'tipo_aceleracion' => $fila['tipo_aceleracion'],
        'nave' => $fila['naveNombre'],
        'codigo_vuelo' => $fila['codigo_vuelo'],
        'circuito' => $fila['nombre_circuito'],
        'destino' => $destino,
        'circuito_id' => $fila['circuito_id']
    );
}

$jsonstring = json_encode($json);
echo $jsonstring;
?>