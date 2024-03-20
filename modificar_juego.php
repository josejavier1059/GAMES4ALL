<?php
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

// Verificar si el usuario es administrador
if (!isset($_COOKIE['alias'])) {
    header('Location: index.php'); // Redirigir si la cookie de alias no está presente
    exit();
}

$alias = $_COOKIE['alias'];
$consultaRol = $conexion->prepare("SELECT rol FROM usuario WHERE alias = ?");
$consultaRol->bind_param("s", $alias);
$consultaRol->execute();
$resultadoRol = $consultaRol->get_result();

if ($resultadoRol->num_rows == 0 || $resultadoRol->fetch_assoc()['rol'] !== 'Administrador') {
    header('Location: index.php'); // Redirigir si no es administrador
    exit();
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_juego'])) {
    $id_juego = $_POST['id_juego'];
    $plataforma = $_POST['plataforma'];
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $rebaja = $_POST['rebaja'];
    $stock = $_POST['stock'];
    $id_tipo = $_POST['id_tipo']; // ID del tipo seleccionado en el formulario

    // Actualizar juego
    $stmtJuego = $conexion->prepare("UPDATE juegos SET plataforma=?, titulo=?, precio=?, rebaja=?, stock=?, tipo=? WHERE id_juego=?");
    $stmtJuego->bind_param("ssddiii", $plataforma, $titulo, $precio, $rebaja, $stock, $id_tipo, $id_juego);
    $stmtJuego->execute();

    header("Location: ver_eliminar_juegos.php?mensaje=juegoModificado");
    exit();
}

// Mostrar el formulario para un juego existente si se accede a través de GET con un ID de juego
if (isset($_GET['id'])) {
    $id_juego = $_GET['id'];

    // Obtener los detalles del juego para prellenar el formulario
    $stmtJuego = $conexion->prepare("SELECT * FROM juegos WHERE id_juego = ?");
    $stmtJuego->bind_param("i", $id_juego);
    $stmtJuego->execute();
    $resultadoJuego = $stmtJuego->get_result();
    $juego = $resultadoJuego->fetch_assoc();
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

<h2>Modificar Juego</h2>

<form action="modificar_juego.php" method="post">
    <input type="hidden" name="id_juego" value="<?php echo htmlspecialchars($juego['id_juego']); ?>">
    <p>Plataforma: <?php echo htmlspecialchars($juego['plataforma']); ?></p>
    <p>Título: <?php echo htmlspecialchars($juego['titulo']); ?></p>
    <label for="precio">Precio:</label>
    <input type="number" step="0.01" name="precio" required value="<?php echo htmlspecialchars($juego['precio']); ?>">
    <label for="rebaja">Rebaja:</label>
    <input type="number" step="0.01" name="rebaja" required value="<?php echo htmlspecialchars($juego['rebaja']); ?>">
    <label for="stock">Stock:</label>
    <input type="number" name="stock" required value="<?php echo htmlspecialchars($juego['stock']); ?>">
    <label for="id_tipo">Tipo:</label>
    <select name="id_tipo" required>
        <?php
        $consultaTipos = $conexion->prepare("SELECT id_tipo, titulo FROM tipo");
        $consultaTipos->execute();
        $resultadoTipos = $consultaTipos->get_result();

        while ($tipo = $resultadoTipos->fetch_assoc()) {
            $selected = $juego['tipo'] == $tipo['id_tipo'] ? 'selected' : '';
            echo "<option value=\"{$tipo['id_tipo']}\" $selected>{$tipo['titulo']}</option>";
        }
        ?>
    </select>
    <input type="submit" value="Modificar Juego">
</form>

</body>
</html>
<?php
}
?>

