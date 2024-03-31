<?php
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

if (!isset($_COOKIE['alias']) || !isset($_COOKIE['rol'])) {
    header('Location: index.php');
    exit();
}

$alias = $_COOKIE['alias'];
$rol = $_COOKIE['rol'];
$id_usuario = $_COOKIE['id'];

if ($rol !== 'administrador') {
    header('Location: index.php');
    exit();
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == 'FechaError') {
        echo 'La tarjeta está caducada o la fecha no es válida.';
    }
    if ($error == 'TarjetaYaExiste') {
        echo 'La tarjeta ya existe en la base de datos.';
    }
}

if (isset($_GET['id_tarjeta'])) {
    $id_tarjeta = mysqli_real_escape_string($conexion, $_GET['id_tarjeta']);
    
    if (isset($_POST['actualizar'])) {
        $numero = mysqli_real_escape_string($conexion, $_POST['numero']);
        $caducidad = mysqli_real_escape_string($conexion, $_POST['caducidad']);
        $titular = mysqli_real_escape_string($conexion, $_POST['titular']);

        $sql_check = "SELECT * FROM tarjeta WHERE numero = '$numero'";
        $result = $conexion->query($sql_check);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['id_tarjeta'] != $id_tarjeta) {
                    header("Location: editar_tarjeta.php?id_tarjeta=" . $id_tarjeta . "&?error=TarjetaYaExiste");
                    exit();
                }
            }
        }
    
        $caducidad = "20" . substr($caducidad, 3, 2) . "-" . substr($caducidad, 0, 2) . "-01";
        $fecha_actual = date("Y-m-d");
            
        if (strtotime($caducidad) < strtotime($fecha_actual)) {
            header("Location: editar_tarjeta.php?id_tarjeta=" . $id_tarjeta . "&?error=FechaError");
            exit();
        }

        $consultaUpdate = "UPDATE tarjeta SET numero = '$numero', caducidad = '$caducidad', titular = '$titular' WHERE id_tarjeta = '$id_tarjeta'";
        if (mysqli_query($conexion, $consultaUpdate)) {
            echo "<script>alert('Tarjeta actualizada correctamente.'); window.location.href='gestionar_usuarios.php';</script>";
        } else {
            echo "Error al actualizar la tarjeta.";
        }
    }

    $consulta = "SELECT * FROM tarjeta WHERE id_tarjeta = '$id_tarjeta'";
    $resultado = mysqli_query($conexion, $consulta);
    if ($fila = mysqli_fetch_assoc($resultado)) {
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

            <form action="" method="post">
                <label for="numero">Número de Tarjeta:</label><br>
                <input type="text" id="numero" name="numero" value="<?php echo htmlspecialchars($fila['numero']); ?>" required><br>

                <label for="titular">Titular:</label><br>
                <input type="text" id="titular" name="titular" value="<?php echo htmlspecialchars($fila['titular']); ?>" required><br>

                <label for="caducidad">Caducidad (MM/YY):</label><br>
                <input type="text" id="caducidad" name="caducidad" value="<?php echo date("m/y", strtotime($fila['caducidad'])); ?>" required pattern="\d{2}\/\d{2}"><br>

                <input type="submit" name="actualizar" value="Actualizar Tarjeta">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "La tarjeta no se encontró.";
    }
} else {
    echo "No se proporcionó el ID de la tarjeta.";
}

mysqli_close($conexion);
?>
