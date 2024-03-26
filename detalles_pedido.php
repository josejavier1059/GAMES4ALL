<?php
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id_pedido = $_GET['id'];

        $conexion = new mysqli("localhost", "root", "", "games4all");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        
        if (!isset($_COOKIE['alias'])) {
            header('Location: index.php');
            exit();
        }

        $alias = $_COOKIE['alias'];
        $rol = $_COOKIE['rol'];

        $sql = "SELECT u.alias FROM pedido p JOIN usuario u ON p.id_usuario = u.id_usuario WHERE p.id_pedido = ".$id_pedido."";
        $resultadoUsuario = $conexion->query($sql);

        if ($rol !== 'administrador' && ($resultadoUsuario->num_rows == 0 || $resultadoUsuario->fetch_assoc()['alias'] !== $alias)){
            header('Location: index.php');
            exit();
        }
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
        <?php
            if ($rol === 'administrador') {
                echo '<form method="POST" action="gestionar_pedidos.php">
                      <input type="submit" value="Volver">';
            } else {
                echo '<form method="POST" action="consultar_pedidos.php">
                      <input type="submit" value="Volver">';
            }
            ?>
        </div>
        <h1>Detalles Pedido</h1>
    </div>

    <div style="display: inline-block; background-color: #ffffff; opacity: 0.95; box-shadow: 0 0 10px 0 rgba(0,0,0,0.5); ">
        <table border='4' style='border-collapse: collapse;'>
            <tr>
                <th>USUARIO</th>
                <th>TARJETA</th>
                <th>DESCUENTO</th>
                <th>SUBTOTAL</th>
                <th>TOTAL</th>
                <th>FECHA</th>
            </tr>

            <?php 
            $sql = "SELECT p.id_pedido, u.alias, t.numero, IFNULL(p.descuento, 0) as descuento, p.subtotal, p.fecha FROM pedido p JOIN usuario u ON p.id_usuario = u.id_usuario JOIN tarjeta t ON p.id_tarjeta = t.id_tarjeta WHERE p.id_pedido = ".$id_pedido."";
            $resultado = $conexion->query($sql);

            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>".$fila['alias']."</td>
                        <td>".$fila['numero']."</td>
                        <td>".$fila['descuento']."%</td>
                        <td>".$fila['subtotal']."€</td>
                        <td>".number_format($fila['subtotal']-($fila['subtotal']*($fila['descuento'] / 100)),2)."€</td>
                        <td>";echo date('d/m/Y', strtotime($fila['fecha']));"</td>
                    </tr>";
            }
            ?>
        </table>
    </div>
    <div>
        <h1 style="text-align: center;">Juegos Pedidos</h1>

        <div style="display: inline-block; background-color: #ffffff; opacity: 0.95; box-shadow: 0 0 10px 0 rgba(0,0,0,0.5); ">
            <table border='4' style='border-collapse: collapse;'>
                <tr>
                    <th>JUEGO</th>
                    <th>PLATAFORMA</th>
                    <th>FORMATO</th>
                </tr>

                <?php 
                $sql = "SELECT p.id_pedido, j.titulo, j.plataforma, j.formato FROM pedido p JOIN juegos_pedido jp ON p.id_pedido = jp.id_pedido JOIN juego j ON jp.id_juego = j.id_juego WHERE p.id_pedido = ".$id_pedido."";
                $resultado = $conexion->query($sql);

                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>
                            <td>".$fila['titulo']."</td>
                            <td>".$fila['plataforma']."</td>
                            <td>";echo $fila['formato'] == 0 ? "Físico" : "Digital";"</td>
                        </tr>";
                }

                $conexion->close();
                ?>
            </table>
        </div>
    </div>
    <?php
    } else {
        echo "ID de pedido no proporcionado.";
    }
    ?>
</body>
</html>