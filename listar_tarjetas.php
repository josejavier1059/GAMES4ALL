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

if (isset($_GET['id_usuario'])) {
    $id_usuario = mysqli_real_escape_string($conexion, $_GET['id_usuario']);
} else {
    echo "No se proporcionó ningún ID de usuario.";
    exit;
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
   
    <form method="POST" action="gestionar_usuarios.php">
        <input type="submit" value="Volver">
    </form>

    <?php
    $consulta = "SELECT * FROM tarjeta WHERE id_usuario = '$id_usuario'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        echo "<table>";
        echo "<tr><th>ID Tarjeta</th><th>Número</th><th>Caducidad</th><th>Titular</th></tr>";
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila['id_tarjeta']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['numero']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['caducidad']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['titular']) . "</td>";
            echo "<td><a href='editar_tarjeta.php?id_tarjeta=" . $fila['id_tarjeta'] . "'>Editar</a></td>";
        
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No se encontraron tarjetas para este usuario.</p>";
    }
    mysqli_close($conexion);
    ?>
</body>
</html>
