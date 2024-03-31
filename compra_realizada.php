<?php
$conexion = new mysqli("localhost", "root", "", "games4all");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id_usuario = $_COOKIE["id"];

$sql_comprobar_stock = "SELECT juego.id_juego, juego.stock, juego.formato
                        FROM carrito
                        INNER JOIN juego ON carrito.id_juego = juego.id_juego
                        WHERE carrito.id_usuario = $id_usuario";
$resultado_stock = $conexion->query($sql_comprobar_stock);

while ($fila_stock = $resultado_stock->fetch_assoc()) {
    if ($fila_stock["stock"] <= 0) {
        $sql_vaciar_carrito = "DELETE FROM carrito WHERE id_usuario = $id_usuario";
        if (!$conexion->query($sql_vaciar_carrito) === TRUE) {
            echo "Error al vaciar el carrito: " . $conexion->error . "<br>";
        }
        header("Location: ver_carrito.php?error=NoHayStock");
        exit();
    }
}

$sql_guardar_claves = "INSERT INTO biblioteca (id_usuario, id_juego, clave) VALUES ";

$sql_juegos_digitales = "SELECT carrito.id_juego
                         FROM carrito 
                         INNER JOIN juego ON carrito.id_juego = juego.id_juego 
                         WHERE carrito.id_usuario = $id_usuario AND juego.formato = 1";
$resultado_juegos_digitales = $conexion->query($sql_juegos_digitales);

if ($resultado_juegos_digitales->num_rows > 0) {
    $valores_claves = array();

    while ($fila_juego_digital = $resultado_juegos_digitales->fetch_assoc()) {
        $clave_juego_digital = mt_rand(1000000000000000, 9999999999999999);
        $valores_claves[] = "($id_usuario, " . $fila_juego_digital["id_juego"] . ", '$clave_juego_digital')";
    }

    $sql_guardar_claves .= implode(",", $valores_claves);

    if (!$conexion->query($sql_guardar_claves) === TRUE) {
        echo "Error al generar y guardar claves: " . $conexion->error . "<br>";
        header("Location: ver_carrito.php?error=ErrorClaves");
        exit();
    }

}

$sql_id_tarjeta = "SELECT id_tarjeta FROM tarjeta WHERE id_usuario = $id_usuario";
$resultado_id_tarjeta = $conexion->query($sql_id_tarjeta);
$fila_id_tarjeta = $resultado_id_tarjeta->fetch_assoc();
$id_tarjeta = $fila_id_tarjeta["id_tarjeta"];

$descuento = isset($_COOKIE["descuento"]) ? $_COOKIE["descuento"] : 0;


$sql_juegos_fisicos = "SELECT COUNT(*) AS count FROM carrito c JOIN juego j ON c.id_juego = j.id_juego WHERE c.id_usuario = $id_usuario AND j.formato = 0";
$resultado_juegos_fisicos = $conexion->query($sql_juegos_fisicos);
$fila_juegos_fisicos = $resultado_juegos_fisicos->fetch_assoc();
$juegos_fisicos_en_carrito = $fila_juegos_fisicos['count'] > 0;

$fecha_actual = date("Y-m-d H:i:s");
$fecha_entrega = null;

if ($juegos_fisicos_en_carrito) {
    $numero_dias = rand(1, 4);
    $fecha_entrega = date("Y-m-d H:i:s", strtotime($fecha_actual . " + $numero_dias days"));
}

$sql_insert_pedido = "INSERT INTO pedido (id_usuario, id_tarjeta, descuento, subtotal, fecha) 
                      VALUES ($id_usuario, $id_tarjeta, $descuento, (SELECT SUM(ROUND(precio - precio * rebaja / 100, 2)) FROM juego WHERE id_juego IN (SELECT id_juego FROM carrito WHERE id_usuario = $id_usuario)), '$fecha_actual')";
if ($conexion->query($sql_insert_pedido) === TRUE) {

    $id_pedido = $conexion->insert_id;

    $sql_insert_juegos_fisicos = "INSERT INTO juegos_pedido (id_pedido, id_juego, fecha_entrega) SELECT $id_pedido, c.id_juego, '$fecha_entrega' FROM carrito c JOIN juego j ON c.id_juego = j.id_juego WHERE c.id_usuario = $id_usuario AND j.formato = 0";
    if (!$conexion->query($sql_insert_juegos_fisicos) === TRUE) {
        echo "Error al asociar juegos físicos del carrito al pedido: " . $conexion->error . "<br>";
        header("Location: ver_carrito.php?error=ErrorJuegosFisicos");
        exit();
    }

    $sql_insert_juegos_digitales = "INSERT INTO juegos_pedido (id_pedido, id_juego) SELECT $id_pedido, c.id_juego FROM carrito c JOIN juego j ON c.id_juego = j.id_juego WHERE c.id_usuario = $id_usuario AND j.formato = 1";
    if (!$conexion->query($sql_insert_juegos_digitales) === TRUE) {
        echo "Error al asociar juegos digitales del carrito al pedido: " . $conexion->error . "<br>";
        header("Location: ver_carrito.php?error=ErrorJuegosDigitales");
        exit();
    }
} else {
    echo "Error al crear el pedido: " . $conexion->error . "<br>";
    header("Location: ver_carrito.php?error=ErrorPedido");
    exit();
}

$sql_bajar_stock = "UPDATE juego 
                    SET stock = stock - 1 
                    WHERE id_juego IN (SELECT id_juego FROM carrito WHERE id_usuario = $id_usuario)";
if (!$conexion->query($sql_bajar_stock) === TRUE) {
    echo "Error al actualizar el stock: " . $conexion->error . "<br>";
    header("Location: ver_carrito.php?error=ErrorStock");
    exit();
}

if ($descuento > 0) {
    $sql_eliminar_descuento = "DELETE FROM descuento WHERE id_usuario = $id_usuario AND valor = $descuento";
    if (!$conexion->query($sql_eliminar_descuento) === TRUE) {
        echo "Error al eliminar el descuento: " . $conexion->error . "<br>";
        header("Location: ver_carrito.php?error=ErrorDescuento");
        exit();
    }
    setcookie("descuento", 0, 0,"/");
}

$sql_vaciar_carrito = "DELETE FROM carrito WHERE id_usuario = $id_usuario";
if (!$conexion->query($sql_vaciar_carrito) === TRUE) {
    echo "Error al vaciar el carrito: " . $conexion->error . "<br>";
    header("Location: ver_carrito.php?error=ErrorVaciarCarrito");
    exit();
}

$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agradecimiento por tu Compra</title>
</head>
<body style="background: url('fondo.png') no-repeat center center fixed; background-size: cover; margin-top: 200px; background-color: #4CC5B0; text-align: left; color: #000000;">
    <h2>Muchas gracias por tu compra</h2>
    <p>¡Esperamos que disfrutes de tus productos!</p>
    <p>Encontrarás las claves de tus juegos digitales en tu Biblioteca y la fecha de entrega de los físicos en tus Pedidos</p>

    <form action="menus.php" method="post">
        <input type="submit" value="Volver al Menú">
    </form>

    <form action="consultar_pedidos.php" method="post">
        <input type="submit" value="Ver Pedidos">
    </form>

    <form action="biblioteca.php" method="post">
        <input type="submit" value="Ver Biblioteca">
    </form>
</body>
</html>