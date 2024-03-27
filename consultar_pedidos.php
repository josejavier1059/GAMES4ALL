<?php
    $conexion = new mysqli("localhost", "root", "", "games4all");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    if (!isset($_COOKIE['alias'])) {
        header('Location: index.php');
        exit();
    }

    $alias = $_COOKIE['alias'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>G4A</title>
        <link rel="stylesheet" href="estilos.css">
        <style>
            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            tr:hover {background-color: #f5f5f5;}
        </style>
        <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Consigue tu juego preferido al mejor precio!</h4>
    </div>
    </head>
    <body style="background-color: #4CC5B0; color: #000000;">
    <div style="text-align: center;">
        <div>
            <form method="POST" action="menus.php">
                <input type="submit" value="Volver">
            </form>
        </div>
        <h1>Pedidos Realizados</h1>
    </div>

    <div style="overflow-y:auto; height: 300px; display: inline-block; background-color: #ffffff; opacity: 0.95; box-shadow: 0 0 10px 0 rgba(0,0,0,0.5); ">
        <table border='4' style='border-collapse: collapse;'>
            <tr>
                <th>TARJETA</th>
                <th>DESCUENTO</th>
                <th>SUBTOTAL</th>
                <th>TOTAL</th>
                <th>REVISAR</th>
            </tr>

            <?php 
            $sql = "SELECT p.id_pedido, u.alias, t.numero, IFNULL(p.descuento, 0) as descuento, p.subtotal FROM pedido p JOIN usuario u ON p.id_usuario = u.id_usuario JOIN tarjeta t ON p.id_tarjeta = t.id_tarjeta";
            $resultado = $conexion->query($sql);

            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                <td>" . rtrim(preg_replace('/\B(?=(\d{4})+(?!\d))/', ' ', $fila['numero'])) . "</td>
                <td>" . $fila['descuento'] . "%</td>
                <td>" . $fila['subtotal'] . "€</td>
                <td>" . number_format($fila['subtotal'] - ($fila['subtotal'] * ($fila['descuento'] / 100)), 2) . "€</td>
                <td>
                    <a href='detalles_pedido.php?id=" . $fila['id_pedido'] . "'>Detalles</a>
                </td>
              </tr>";
            }

            $conexion->close();
            ?>

        </table>
    </div>
</body>
</html>