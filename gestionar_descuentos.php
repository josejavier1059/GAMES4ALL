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
    $consultaRol = $conexion->prepare("SELECT rol FROM usuario WHERE alias = ?");
    $consultaRol->bind_param("s", $alias);
    $consultaRol->execute();
    $resultadoRol = $consultaRol->get_result();

    if ($resultadoRol->num_rows == 0 || $resultadoRol->fetch_assoc()['rol'] !== 'administrador') {
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
    <div style="text-align: center; margin-right: 50%;">
        <div>
            <form method="POST" action="menus.php">
                <input type="submit" value="Volver">
            </form>
        </div>
        <h1>Gestor de Descuentos</h1>
        <a href="añadir_descuento.php" style="display: inline-block; margin-bottom: 10px; padding: 5px 10px; background-color: #173E59; color: #ffffff; text-decoration: none; border-radius: 5px;">Añadir Descuento</a>
    </div>

    <div style="overflow-y:auto; height: 300px; margin-right: 50%; display: inline-block; background-color: #ffffff; opacity: 0.95; box-shadow: 0 0 10px 0 rgba(0,0,0,0.5); ">
        <table border='4' style='border-collapse: collapse;'>
            <tr>
                <th>ID</th>
                <th>USUARIO</th>
                <th>DESCUENTO</th>
                <th>GESTIÓN</th>
            </tr>

            <?php 
            $sql = "SELECT d.id_descuento, d.id_usuario, d.valor, u.alias FROM descuento d
                    INNER JOIN usuario u ON d.id_usuario = u.id_usuario";
            $resultado = $conexion->query($sql);

            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td style='min-width: 40px;'>".$fila['id_descuento']."</td>
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