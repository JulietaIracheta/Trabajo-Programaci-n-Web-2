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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscador de usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/gr.css">
</head>

<body>
<?php include "header-admin.php" ?>
<div class="w3-container banda">
    <h3 class="w3-xxlarge w3-center">Facturación mensual</h3>
</div>
<div class="w3-display-container">
    <div class="w3-container w3-card-4 w3-content">
    <form id="busca-usuarios">
        <label class="facturacion_mensual">Buscar usuario por email</label>
        <input name="email" type="text" class="facturacion">
        <p class="aclaracion">Ingrese en el recuadro el email por el que desea buscar al cliente</p>
    </form>

    <table class="w3-table-all">
        <thead>
        <tr>
            <th width="157"><b>Nombre</b></th>
            <th width="221"><b>Apellido</b></th>
            <th width="176"><b>Email</b></th>
            <th width="73"><b>Facturas</b></th>
        </tr>
        </thead>
        <tbody id="resultados"></tbody>
    </table>
   </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- <script src="bootstrap/js/bootstrap.min.js"></script> -->

<!-- Bootstrap -->
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-2.2.4.min.js"></script>

<!-- <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script> -->
<script src="js/buscar_usuarios.js"></script>
</body>

<?php
include "pie.html";
?>
</html>