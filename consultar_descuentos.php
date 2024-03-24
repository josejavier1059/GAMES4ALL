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
            <form method="POST" action="menus.php">
                <input type="submit" value="Volver">
            </form>
        <h1>Tus Descuentos</h1>
    </div>

    <div style="overflow-y:auto; height: 200px;display: inline-block; background-color: #ffffff; opacity: 0.95; box-shadow: 0 0 10px 0 rgba(0,0,0,0.5); ">
        <table border='4' style='border-collapse: collapse;'>
            <tr>
                <th>DESCUENTOS DISPONIBLES</th>
            </tr>

            <?php 
            $sql = "SELECT d.valor FROM descuento d JOIN usuario u ON d.id_usuario = u.id_usuario WHERE u.alias = '$alias'";
            $resultado = $conexion->query($sql);

            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>".$fila['valor']."%</td>
                    </tr>";
            }

            $conexion->close();
            ?>

        </table>
    </div>
</body>
</html>