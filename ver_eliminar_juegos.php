<?php
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

if (!isset($_COOKIE['alias'])) {
    header('Location: index.php');
    exit();
}

$alias = $_COOKIE['alias'];
$rol = $_COOKIE['rol'];

if ($rol !== 'administrador') {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Introducir Nuevo Juego - G4A</title>
    <style>
        body {
            background: url('fondo.png') no-repeat center center fixed;
            background-size: contain;
            text-align: center;
            color: #4CC5B0; 
            margin: 0;
        }

        #header {
            background-color: #173E59;
            text-align: center;
            color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
        }

        form {
            margin: auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            display: inline-block;
            color: #000;
        }

        input[type="text"], input[type="number"], textarea {
            padding: 10px;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            margin: 20px auto;
            width: 80%;
            border-collapse: collapse;
            background-color: #ffffff;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<h2>Juegos Existentes</h2>
<table>
    <head>
        <tr>
            <th>ID</th>
            <th>Plataforma</th>
            <th>Título</th>
            <th>Precio</th>
            <th>Rebaja</th>
            <th>Stock</th>
            <th>Formato</th>
            <th>Acciones</th>
        </tr>
    </head>
    <body style="background-color: #4CC5B0; color: #000000;">
        <?php
        $conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");
        $consulta = "SELECT id_juego, plataforma, titulo, precio, rebaja, stock, formato FROM juego";
        $resultado = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
            <td>".$fila['id_juego']."</td>
            <td>".$fila['plataforma']."</td>
            <td>".$fila['titulo']."</td>
            <td>".$fila['precio']."€</td>
            <td>".$fila['rebaja']."%</td>
            <td>".$fila['stock']."</td>
            <td>";echo $fila['formato'] == 0 ? "Físico" : "Digital";"</td>";
            echo "<td><a href='modificar_juego.php?id=".$fila['id_juego']."'>Modificar</a> | <a href='eliminar_juego.php?id=".$fila['id_juego']."'>Eliminar</a></td>";
            echo "</tr>";
        }
        ?>
    </body>
</table>

</body>
</html>
