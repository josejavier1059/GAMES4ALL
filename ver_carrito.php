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
        <div style="float: left; width: 30%; height: 700px;margin-top: -60px; background-color: #173E59; color: #ffffff;font-size: 25px;">
            <?php
$conexion = new mysqli("localhost", "root", "", "games4all");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (isset($_GET["error"])) {
    $error = $_GET["error"];
    if ($error == "NoHayStock") {
        echo "Lo sentimos, uno o más juegos de tu carrito no tienen stock disponible. Se han eliminado del carrito.<br>";
    }

}

$id_usuario = $_COOKIE["id"];
$direccion = $_COOKIE["direccion"];

$sql = "SELECT juego.id_juego, juego.titulo, juego.plataforma, juego.formato, ROUND(juego.precio - juego.precio * juego.rebaja / 100, 2) AS precio FROM carrito INNER JOIN juego ON carrito.id_juego = juego.id_juego WHERE carrito.id_usuario = $id_usuario";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    echo "<h2>Carrito de Compras</h2>";
    echo "<table border='1'>
            <tr>
                <th>Juego</th>
                <th>Plataforma</th>
                <th>Precio</th>
                <th>Formato</th>
                <th></th>
            </tr>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>".$fila["titulo"]."</td>
                <td>".$fila["plataforma"]."</td>
                <td>".$fila["precio"]."€</td> 
                <td>".($fila["formato"] == 0 ? "Físico" : "Digital")."</td>
                <td>
                    <form action='quitar_carrito.php' method='post'>
                        <input type='hidden' name='id_juego' value='".$fila["id_juego"]."'>
                        <input type='submit' value='Quitar'>
                    </form>
            </tr>";
    }
    echo "</table><br>";

    if ($direccion == "null") {
        echo "<form action='datos_direccion.php?origen=carrito' method='post'>
        <input type='submit' value='Introducir Dirección'>
        </form>";
    } else {
        echo "<form action='introducir_tarjeta.php' method='post'>
        <input type='submit' value='Comenzar proceso de Compra'>
        </form>";
    }


    echo "<form action='vaciar_carrito.php' method='post'>
            <input type='submit' value='Vaciar Carrito'>
          </form>";

    echo "<form action='buscar_juegos.php' method='post'>
            <input type='submit' value='Seguir Comprando'>
          </form>";
} else {
    echo "<h2>Carrito de Compras</h2>
          El carrito está vacío.
          <form action='buscar_juegos.php' method='post'>
            <input type='submit' value='Comenzar a buscar Juegos'>
          </form>";
}

echo "<form action='menus.php' method='post'>
        <input type='submit' value='Volver'>
      </form>";

$conexion->close();
?>
        </div>
    </body>
</html>