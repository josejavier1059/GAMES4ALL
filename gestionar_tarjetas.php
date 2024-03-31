<?php

$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");


if (!isset($_COOKIE['alias'])) {
    header('Location: index.php');
    exit();
}

$alias = $_COOKIE['alias'];


$queryUsuario = $conexion->prepare("SELECT id_usuario FROM usuario WHERE alias = ?");
$queryUsuario->bind_param("s", $alias);
$queryUsuario->execute();
$resultadoUsuario = $queryUsuario->get_result();

if ($resultadoUsuario->num_rows > 0) {
    $fila = $resultadoUsuario->fetch_assoc();
    $id_usuario = $fila['id_usuario'];
    
    
    $queryTarjetas = $conexion->prepare("SELECT * FROM tarjeta WHERE id_usuario = ?");
    $queryTarjetas->bind_param("i", $id_usuario);
    $queryTarjetas->execute();
    $resultadoTarjetas = $queryTarjetas->get_result();
} else {
    die("Usuario no encontrado.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestionar Tarjetas - G4A</title>
    <meta charset="utf-8">
    <style>
        body {
            background: url('fondo.png') no-repeat center center fixed;
            background-color: #4CC5B0;
            background-size: contain;
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
        .tarjeta-info {
            margin: 10px auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            display: inline-block;
            color: #000;
        }
        form {
            margin: auto;
            display: inline;
        }
        input[type="submit"], button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<div id="header">
    <h1>GAMES4ALL</h1>
    <h4>¡Consigue tu juego preferido al mejor precio!</h4>
</div>
<body>

<div id="header2">
<h2>TUS TARJETAS</h2>
<br>
<form action="usuario_añade_tarjeta.php" method="post">
    <input type="submit" value="Añadir Tarjeta">
</form>
<br>
<?php
if (isset($resultadoTarjetas) && $resultadoTarjetas->num_rows > 0) {
    while ($tarjeta = $resultadoTarjetas->fetch_assoc()) {
        echo "<div class='tarjeta-info'>";
        echo "Tarjeta: " . rtrim(preg_replace('/\B(?=(\d{4})+(?!\d))/', ' ', $tarjeta['numero'])) . " - Caducidad: " . date("m/Y", strtotime($tarjeta['caducidad']));
        echo " <a href='usuario_edita_tarjeta.php?id_tarjeta=" . $tarjeta['id_tarjeta'] . "'><button>Modificar</button></a>";
        echo " <form style='display:inline' action='procesar_usuario_elimina_tarjeta.php' method='post'>";
        echo "<input type='hidden' name='id_tarjeta' value='" . $tarjeta['id_tarjeta'] . "'>";
        echo "<input type='submit' value='Eliminar'>";
        echo "</form>";
        echo "</div>";
        ?><br><?php
    }
} else {
    echo "No tienes tarjetas registradas.";
}
?>
<br>
<form action="menus.php">
    <input type="submit" value="Volver" />
</form>
</div>
</body>
</html>
