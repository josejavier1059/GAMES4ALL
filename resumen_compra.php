<?php
$conexion = new mysqli("localhost", "root", "", "games4all");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (!isset($_COOKIE["id"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["descuento"])) {
    $descuento = $_POST["descuento"];
    setcookie("descuento", $descuento, 0, "/");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
} 

if (isset($_COOKIE["descuento"])) {
    $descuento = $_COOKIE["descuento"];
} else {
    $descuento = 0;
}

$id_usuario = $_COOKIE["id"];
$num_tar = $_COOKIE["numero_tarjeta"];

$sql_juegos = "SELECT juego.titulo, juego.plataforma, ROUND(juego.precio - juego.precio * juego.rebaja / 100, 2) AS precio, juego.formato
               FROM carrito
               INNER JOIN juego ON carrito.id_juego = juego.id_juego
               WHERE carrito.id_usuario = $id_usuario";
$resultado_juegos = $conexion->query($sql_juegos);

$sql_direccion = "SELECT pais, ciudad, direccion, cod_postal, nombre FROM usuario WHERE id_usuario = $id_usuario";
$resultado_direccion = $conexion->query($sql_direccion);
$fila_direccion = $resultado_direccion->fetch_assoc();

$sql_tarjeta = "SELECT * FROM tarjeta WHERE numero = $num_tar";
$resultado_tarjeta = $conexion->query($sql_tarjeta);
$fila_tarjeta = $resultado_tarjeta->fetch_assoc();

$fecha_db = $fila_tarjeta["caducidad"];
$fecha_unix = strtotime($fecha_db);
$caducidad = date("m/y", $fecha_unix);

$sql_descuentos = "SELECT * FROM descuento WHERE id_usuario = $id_usuario";
$resultado_descuentos = $conexion->query($sql_descuentos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Compra</title>
</head>
<body style="background: url('fondo.png') no-repeat center center fixed; background-size: cover;background-color: #4CC5B0; text-align: left; color: #000000;">
    <h2>Resumen de Compra</h2>

    <h3>Juegos en el Carrito:</h3>
    <?php if ($resultado_juegos->num_rows > 0): ?>
    <ul>
        <?php while ($fila_juegos = $resultado_juegos->fetch_assoc()): ?>
            <li><?php echo $fila_juegos["titulo"]; ?> (<?php echo $fila_juegos["plataforma"]; ?>) - <?php echo $fila_juegos["precio"]; ?>€ | <?php echo ($fila_juegos["formato"] == 0 ? "Físico" : "Digital"); ?></li>
        <?php endwhile; ?>
    </ul>
    <?php endif; ?>

    <h3>Destinatario:</h3>
    <p><?php echo $fila_direccion["nombre"] ?></p>

    <h3>Dirección de Envío:</h3>
    <?php if ($fila_direccion): ?>
        <p>
            País: <?php echo $fila_direccion["pais"]; ?><br>
            Ciudad: <?php echo $fila_direccion["ciudad"]; ?><br>
            Dirección: <?php echo $fila_direccion["direccion"]; ?><br>
            Código Postal: <?php echo $fila_direccion["cod_postal"]; ?><br>
            <form action="datos_direccion.php?origen=resumen"  method="post">
                <input type="submit" value="Cambiar Dirección">
            </form>


        </p>
    <?php endif; ?>

    <h3>Tarjeta Utilizada:</h3>
    <?php if ($fila_tarjeta): ?>
        <p>
            Número de Tarjeta: <?php echo rtrim(preg_replace('/\B(?=(\d{4})+(?!\d))/', ' ', $fila_tarjeta['numero'])); ?><br>
            Titular: <?php echo $fila_tarjeta["titular"]; ?><br>
            Fecha de Expiración: <?php echo $caducidad; ?><br>
        </p>
    <?php endif; ?>

    <h3>Descuentos Disponibles:</h3>
    <?php if ($resultado_descuentos->num_rows > 0): ?>
        <form action="resumen_compra.php" method="post">
            <select name="descuento">
                <option value="0" <?php if ($descuento == 0) echo "selected"; ?>>Sin Descuento</option>
                <?php while ($fila_descuento = $resultado_descuentos->fetch_assoc()): ?>
                    <option value="<?php echo $fila_descuento['valor']; ?>" <?php if ($descuento == $fila_descuento['valor']) echo "selected"; ?>>
                        <?php echo $fila_descuento['valor']; ?>%
                    </option>
                <?php endwhile; ?>
            </select>
            <input type="submit" value="Aplicar Descuento">
        </form>
    <?php endif; ?>

    <?php
    $total = 0;
    $resultado_juegos->data_seek(0);
    while ($fila_juegos = $resultado_juegos->fetch_assoc()) {
        $total += $fila_juegos["precio"];
    }
    ?>

    <h3>Total de la Compra:</h3>
    <p><?php echo number_format($total * ((100 - $descuento) / 100), 2); ?>€</p>

    <form action="compra_realizada.php" method="post">
        <input type="submit" value="Comprar">
    </form>

    <br>

    <form action="introducir_tarjeta.php" method="post">
        <input type="submit" value="Volver">
    </form>

</body>
</html>

<?php
$conexion->close();
?>

