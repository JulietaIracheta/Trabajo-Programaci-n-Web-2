<?php
session_start();
require_once "conexion.php";
require_once  "funciones.php";
$usuario = $_SESSION['username'];
if(!isset($usuario)){
    header("location:login.php");
}
$rol = $_SESSION['rol'];
if($rol != 1){
    header("location:login.php");
}
$mes = isset($_POST['mes']) ? $_POST['mes'] : '';
$anio = isset($_POST['anio']) ? $_POST['anio'] : '';

?>
    <title>Grafico</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/gr.css">
    <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
    <script src="js/Chart.bundle.js"></script>
    <script src="js/Chart.js"></script>

<?php include "header-admin.php" ?>
<div class="w3-container banda">
    <h3 class="w3-xxlarge w3-center">Cabinas mas reservadas</h3>
</div>
<form action="cabinaMasReservada.php" method="post" class="w3-container w3-card-4 fact_mensual">
    <p>Ingrese un mes y un año para obtener el reporte</p>
    Año
    <input type="text" name="anio">
    Mes
    <input type="text" name="mes">
    <button type="submit" name="enviar">Buscar</button>
</form>

<?php
    if(!empty($mes) && !empty($anio)) {
    echo "<table class='w3-table-all fact_mensual'>
          <tr>
            <th width='157'><b>Cabina</b></th>
            <th width='157'><b>Veces reservada</b></th>
            <th width='157'><b>Porcentaje</b></th>
          </tr>";

    $sql_resultado_cabina_mas_vendida = cabina_mas_vendida($mes, $anio);
    $total_mes ='0';
    while ($fila_cabina_mas_vendida = mysqli_fetch_assoc($sql_resultado_cabina_mas_vendida)){
        $total_mes += $fila_cabina_mas_vendida['cantidad'];
    }
        mysqli_data_seek($sql_resultado_cabina_mas_vendida, 0);
    while ($fila_cabina_mas_vendida = mysqli_fetch_assoc($sql_resultado_cabina_mas_vendida)){
        echo "<tr>
            <td>".$fila_cabina_mas_vendida['cabinaNombre']."</td> 
            <td>".$fila_cabina_mas_vendida['cantidad']."</td>
            <td>".round(($fila_cabina_mas_vendida['cantidad']*100)/$total_mes,2)." %</td>
      </tr>";
    }
?>
    </table>

    <canvas id="myChart"></canvas>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'pie',
            data:{
                datasets: [{
                    data:[
                        <?php
                        $sql_resultado_cabina_mas_vendida = cabina_mas_vendida($mes, $anio);
                        while ($fila_cabina_mas_vendida = mysqli_fetch_assoc($sql_resultado_cabina_mas_vendida)) {
                        ?>
                        '<?php echo $fila_cabina_mas_vendida["cantidad"]; ?>',
                        <?php
                        }
                        ?>
                    ],
                    backgroundColor: ['#42a5f5', 'red', 'green','pink','yellow','blue','black'],
                    label: 'Cabina mas vendida'}],
                    labels: [
                        <?php
                        $sql_resultado_cabina_mas_vendida = cabina_mas_vendida($mes, $anio);
                        while ($fila_cabina_mas_vendida = mysqli_fetch_assoc($sql_resultado_cabina_mas_vendida)) {
                        ?>
                        '<?php echo $fila_cabina_mas_vendida["cabinaNombre"]; ?>',
                        <?php

                        }
                        ?>
                    ]},
            options: {responsive: true}
        });
    </script>
<?php
}
else {
//    echo "Debe ingresar un mes y un año";
}
include "pie.html";
?>