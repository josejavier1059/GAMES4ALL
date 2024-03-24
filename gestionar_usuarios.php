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
<body style="background-color: #4CC5B0; color: #000000;">
<div id="buscador">
        <form method="get" action="">
            <input type="text" name="busqueda" placeholder="Buscar por alias o correo...">
            <input type="submit" value="Buscar">
        </form>
    </div>

    <?php
    $conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Fallo al conectar con la base de datos.");

    $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

    $sql = "SELECT * FROM usuario WHERE alias LIKE '%$busqueda%' OR correo LIKE '%$busqueda%'";
    $resultado = mysqli_query($conexion, $sql) or die("Fallo en la consulta.");

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Alias</th><th>Correo</th><th>Acciones</th></tr>";

    while($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>{$fila['id_usuario']}</td>";
        echo "<td>{$fila['alias']}</td>";
        echo "<td>{$fila['correo']}</td>";
        echo "<td>
                <a href='eliminar_usuario.php?id={$fila['id_usuario']}'>Eliminar</a> |
                <a href='admin_edita_usuario.php?id={$fila['id_usuario']}'>Editar</a> |
                <a href='listar_tarjetas.php?id_usuario={$fila['id_usuario']}'>Listar Tarjetas</a> |
                </td>";
        echo "</tr>";
    }
    echo "</table>";

    mysqli_close($conexion);
    ?>

</body>
</html>
