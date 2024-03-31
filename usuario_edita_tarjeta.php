<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

if (!isset($_COOKIE['alias'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['id_tarjeta'])) {
    echo "No se especificó una tarjeta para editar.";
    exit;
}

$idTarjeta = mysqli_real_escape_string($conexion, $_GET['id_tarjeta']);
$queryTarjeta = "SELECT * FROM tarjeta WHERE id_tarjeta = '$idTarjeta'";
$resultadoTarjeta = mysqli_query($conexion, $queryTarjeta);
$tarjeta = mysqli_fetch_assoc($resultadoTarjeta);

if (!$tarjeta) {
    echo "La tarjeta especificada no existe.";
    exit;
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == 'FechaError') {
        //echo 'La tarjeta está caducada o la fecha no es válida.';
    }
    if ($error == 'TarjetaYaExiste') {
        //echo 'La tarjeta ya existe en la base de datos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar Tarjeta - G4A</title>
    <style>
    body {
        background: url('fondo.png') no-repeat center center fixed;
        background-size: contain;
        background-color: #4CC5B0;
        text-align: center;
        color: #4CC5B0; 
        margin: 0;
    }

    #header {
            background-color: #173E59;
            text-align: center;
            color: #ffffff;
            padding: 35px;
            margin-bottom: 20px;
    }
    #header2 {
            text-align: center;
            color: #000000;
            padding: 35px;
            margin-bottom: 20px;
            margin-left: -500px;
        }

    form {
        margin: auto;
        padding: 20px;
        background-color: #f2f2f2;
        border-radius: 5px;
        display: inline-block;
        color: #000;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin: 10px; 
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    .tarjeta-info {
        background-color: #ffffff;
        color: #003366;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 8px;
        display: inline-block;
        width: auto;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>
</head>
<div id="header">
    <h1>GAMES4ALL</h1>
    <h4>¡Consigue tu juego preferido al mejor precio!</h4>
</div>
<body>
<div id="header2">
<h2>Editar Tarjeta</h2>

<form action="gestionar_usuario_edita_tarjeta.php" method="post">
    <input type="hidden" name="id_tarjeta" value="<?php echo $idTarjeta; ?>">

    <label for="numero">Número de Tarjeta:</label><br>
    <input type="text" id="numero" name="numero" value="<?php echo $tarjeta['numero']; ?>" required pattern="\d{16}"><br>
    
    <label for="numero">Titular:</label><br>
    <input type="text" id="titular" name="titular" value="<?php echo $tarjeta['titular']; ?>" required><br>

    <label for="caducidad">Caducidad (MM/YY):</label><br>
    <input type="text" id="caducidad" name="caducidad" value="<?php echo date("m/y", strtotime($tarjeta['caducidad'])); ?>" required pattern="\d{2}\/\d{2}"><br>
    
    <input type="submit" value="Aceptar">
</form>

<br><br>
<form action="gestionar_tarjetas.php">
    <input type="submit" value="Volver" />
</form>
</div>
</body>
</html>
