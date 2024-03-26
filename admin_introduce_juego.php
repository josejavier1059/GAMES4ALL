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

<div id="header">
    <h1>GAMES4ALL</h1>
    <h4>Introduce un nuevo juego o revisa la información existente</h4>
</div>

<form method="POST" action="gestionar_videojuegos.php">
    <input type="submit" value="Volver">
</form>

<h2>Información de Juegos Existentes</h2>
<table>
    <thead>
        <tr>
            <th></th>
            <th>Juego</th>
            <th>Género</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar con la base de datos.");
        $consulta = "SELECT * FROM info_juego ORDER BY titulo_juego ASC";
        $resultado = mysqli_query($conexion, $consulta);

        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
                  <td><img src='images/".$fila['imagen']."' style='width: 50px; height: 50px;'></td>
                  <td>".$fila['titulo_juego']."</td>
                  <td>".$fila['genero']."</td>
                  <td>".$fila['descripcion']."</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

<h2>Introducir Nuevo Juego</h2>
<p>*NOTA: Descripción, Género e Imagen solo son necesarios para un juego nuevo, si se introducen de nuevo actualizará los datos</p>
<form action="procesar_introduce_juego.php" method="post" enctype="multipart/form-data">
    <label for="plataforma">Plataforma:</label>
    <select name="plataforma" id="plataforma" required placeholder="Plataforma">
        <option value="PC">PC</option>
        <option value="Nintendo Switch">Nintendo Switch</option>
        <option value="PlayStation 4">PlayStation 4</option>
        <option value="PlayStation 5">PlayStation 5</option>
        <option value="Xbox One">Xbox One</option>
        <option value="Xbox Series">Xbox Series</option>
    </select>
    <input type="text" name="titulo" required placeholder="Título del juego">
    <input type="number" min="0" step="0.01" name="precio" required placeholder="Precio">
    <input type="number" min="0" max="100" step="1" name="rebaja" required placeholder="Rebaja">
    <input type="number" name="stock" required placeholder="Stock">
    <input type="number" name="formato" min="0" max="1" step="1" required placeholder="F0/D1">
    <input type="text" name="genero" placeholder="Género (*Nota)">
    <textarea name="descripcion" placeholder="Descripción (*Nota)" cols="100" rows="5" style="resize: none;"></textarea>
    <label>Imagen:</label>
    <input type="file" name="imagen" accept="image/*">
    <br>
    <input type="submit" value="Introducir Juego">
</form>

</body>
</html>
