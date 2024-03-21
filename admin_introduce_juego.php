<?php
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");


if (!isset($_COOKIE['alias'])) {
    header('Location: index.php');
    exit();
}

$alias = $_COOKIE['alias'];

// Preparar y ejecutar la consulta
$consulta = $conexion->prepare("SELECT rol FROM usuario WHERE alias = ?");
$consulta->bind_param("s", $alias);
$consulta->execute();
$resultado = $consulta->get_result();

// Si no se encuentra el usuario o el rol no es administrador, redirigir
if ($resultado->num_rows === 0) {
    header('Location: index.php'); // Usuario no encontrado
    exit();
}

$fila = $resultado->fetch_assoc();
if ($fila['rol'] !== 'Administrador') {
    header('Location: index.php'); // No es administrador
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

<div id="header">
    <h1>GAMES4ALL</h1>
    <h4>Introduce un nuevo juego o revisa los tipos existentes</h4>
</div>

<h2>Tipos de Juegos Existentes</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Género</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar con la base de datos.");
        $consulta = "SELECT * FROM tipo";
        $resultado = mysqli_query($conexion, $consulta);

        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>".$fila['id_tipo']."</td>";
            echo "<td>".$fila['titulo']."</td>";
            echo "<td>".$fila['genero']."</td>";
            echo "<td>".$fila['descripcion']."</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<h2>Introducir Nuevo Juego</h2>
<form action="procesar_introduce_juego.php" method="post">
    <input type="text" name="plataforma" required placeholder="Plataforma (ej. PC, PlayStation)">
    <input type="text" name="titulo" required placeholder="Título del juego">
    <input type="number" step="0.01" name="precio" required placeholder="Precio">
    <input type="number" step="0.01" name="rebaja" required placeholder="Rebaja">
    <input type="number" name="stock" required placeholder="Stock">
    <input type="number" name="id_tipo" placeholder="ID Tipo (si ya existe)">
    <input type="text" name="genero" placeholder="Género (solo si ID Tipo no se proporciona)">
    <textarea name="descripcion" placeholder="Descripción (solo si ID Tipo no se proporciona)"></textarea>
    <input type="submit" value="Introducir Juego">
</form>

</body>
</html>
