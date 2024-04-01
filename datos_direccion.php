<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>G4A</title>
        <link rel="stylesheet" href="estilos.css">
        <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Consigue tu juego preferido al mejor precio!</h4>
    </div>
    </head>

    <body style="background-color: #4CC5B0; text-align: center; color: #000000;">
        <div style="float: left; width: 30%; height: 500px;margin-top: -60px; background-color: #173E59; color: #ffffff;font-size: 25px;">
         <?php
$conexion = new mysqli("localhost", "root", "", "games4all");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (isset($_GET['estado'])) {
    if ($_GET['estado'] == "actualizada") {
        echo "<h3>Dirección actualizada correctamente.</h3>";
    } else {
        echo "<h3>Error al actualizar la dirección.</h3>";
    }
}

if (!isset($_COOKIE["id"])) {
    header("Location: index.php");
    exit();
}

$origen = "";

if (isset($_GET['origen'])) {
    $origen = $_GET['origen'];
}

$id_usuario = $_COOKIE["id"];

if (isset($_POST['pais']) && isset($_POST['ciudad']) && isset($_POST['direccion']) && isset($_POST['codigo_postal'])) {
    $pais = $_POST['pais'];
    $ciudad = $_POST['ciudad'];
    $direccion = $_POST['direccion'];
    $codigo_postal = $_POST['codigo_postal'];

    setcookie("direccion", $direccion, 0, "/");

    $sql_update = "UPDATE usuario SET pais='$pais', ciudad='$ciudad', direccion='$direccion', cod_postal='$codigo_postal' WHERE id_usuario=$id_usuario";

    if ($conexion->query($sql_update) === TRUE) {
        echo "Datos de dirección actualizados correctamente.";
        header('Location: ' . $_SERVER['HTTP_REFERER'] . urlencode($origen). "&estado=actualizada");
        exit();
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER'] . urlencode($origen) . "&estado=error");
        exit();
    }
}

$sql = "SELECT * FROM usuario WHERE id_usuario = $id_usuario";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();

?>
<h2>Datos Dirección</h2>
<form action='datos_direccion.php' method='post'>
    <label for='pais'>País:</label>
    <input type='text' id='pais' name='pais' required value="<?php echo htmlspecialchars($fila['pais']); ?>"><br><br>
    <label for='ciudad'>Ciudad:</label>
    <input type='text' id='ciudad' name='ciudad' required value="<?php echo htmlspecialchars($fila['ciudad']); ?>"><br><br>
    <label for='direccion'>Dirección:</label>
    <input type='text' id='direccion' name='direccion' required value="<?php echo htmlspecialchars($fila['direccion']); ?>"><br><br>
    <label for='codigo_postal'>Código Postal:</label>
    <input type='text' id='codigo_postal' name='codigo_postal' required pattern="[0-9]{5}" title="Debe contener exactamente 5 dígitos" value="<?php echo htmlspecialchars($fila['cod_postal']); ?>"><br><br>
    <input type='submit' value='Guardar Dirección'>
</form>

<?php if ($origen == "carrito") { ?>
    <form action='ver_carrito.php' method='post'>
        <input type='submit' value='Volver'>
    </form>
<?php } else if ($origen == "perfil") { ?>
    <form action='gestionar_perfil.php' method='post'>
        <input type='submit' value='Volver'>
    </form>
<?php } else { ?>
    <form action='resumen_compra.php' method='post'>
        <input type='submit' value='Volver'>
    </form>
<?php }
$conexion->close();
?>
        </div>
    </body>
</html>