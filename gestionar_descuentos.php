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
    <body style="background-color: #4CC5B0; color: #000000;">
    <div style="text-align: center; margin-right: 50%;">
        <a href="menus.php">Volver</a>
        <h1>Gestor de Descuentos</h1>
        <a href="añadir_descuento.php" style="display: inline-block; margin-bottom: 10px; padding: 5px 10px; background-color: #173E59; color: #ffffff; text-decoration: none; border-radius: 5px;">Añadir Descuento</a>
    </div>

    <div style="overflow-y:auto; height: 200px; margin-right: 50%; display: inline-block;">
        <table border='4' style='border-collapse: collapse;'>
            <tr>
                <th>ID_DESCUENTO</th>
                <th>USUARIO</th>
                <th>DESCUENTO</th>
                <th>GESTIÓN</th>
            </tr>

            <?php  
            $conexion = new mysqli("localhost", "root", "", "games4all");

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            $sql = "SELECT d.id_descuento, d.id_usuario, d.valor, u.alias FROM descuento d
                    INNER JOIN usuario u ON d.id_usuario = u.id_usuario";
            $resultado = $conexion->query($sql);

            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>".$fila['id_descuento']."</td>
                        <td>".$fila['alias']."</td>
                        <td>".$fila['valor']."%</td>
                        <td>
                            <a href='eliminar_descuento.php?id=".$fila['id_descuento']."'>Eliminar</a> |
                            <a href='modificar_descuento.php?id=".$fila['id_descuento']."'>Modificar</a>
                        </td>
                    </tr>";
            }

            $conexion->close();
            ?>

        </table>
    </div>
</body>
</html>