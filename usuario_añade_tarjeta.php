<?php
if (!isset($_COOKIE['alias'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Añadir Nueva Tarjeta - G4A</title>
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

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 10px; 
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Añadir Nueva Tarjeta</h2>

<form action="procesar_usuario_añade_tarjeta.php" method="post">
    <label for="numero">Número de Tarjeta:</label><br>
    <input type="text" id="numero" name="numero" required><br>

    <label for="caducidad">Caducidad (YYYY-MM-DD):</label><br>
    <input type="date" id="caducidad" name="caducidad" required><br>

    <label for="titular">Titular:</label><br>
    <input type="text" id="titular" name="titular" required><br>

    <input type="submit" value="Añadir Tarjeta">
</form>

</body>
</html>
