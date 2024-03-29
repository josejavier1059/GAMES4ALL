<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

if (!isset($_COOKIE['alias'])) {
    header('Location: index.php');
    exit();
}

$alias = $_COOKIE['alias'];
$queryUsuario = "SELECT id_usuario FROM usuario WHERE alias = '$alias'";
$resultadoUsuario = mysqli_query($conexion, $queryUsuario);
$usuario = mysqli_fetch_assoc($resultadoUsuario);
$id_usuario = $usuario['id_usuario'];

$queryTarjetas = "SELECT id_tarjeta, numero, caducidad FROM tarjeta WHERE id_usuario = '$id_usuario'";
$resultadoTarjetas = mysqli_query($conexion, $queryTarjetas);

if (!$resultadoTarjetas) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Lista de Tarjetas - G4A</title>
    <style>
    body {
        background: url('fondo.png') no-repeat center center fixed;
        background-size: contain;
        text-align: center;
        color: #4CC5B0; 
        margin: 0;
    }

    #header {
        background-color: #173E59;
        text-align: center;
        color: #ffffff;
        padding: 20px;
        margin-bottom: 20px;
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
<body>

<h2>Lista de Tarjetas</h2>

<?php
if (mysqli_num_rows($resultadoTarjetas) > 0) {
    while ($tarjeta = mysqli_fetch_assoc($resultadoTarjetas)) {
        echo "<div class='tarjeta-info'>";
        echo "Tarjeta: " . $tarjeta['numero'] . " - Caducidad: " . date("m/Y", strtotime($tarjeta['caducidad']));
        echo " <a href='usuario_edita_tarjeta.php?id_tarjeta=" . $tarjeta['id_tarjeta'] . "'><button>Modificar</button></a>";
        echo "</div>";
    }
} else {
    echo "No tienes tarjetas registradas.";
}
?>

</body>
</html>
