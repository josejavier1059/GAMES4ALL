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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_juego'])) {
    $id_juego = $_POST['id_juego'];
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $rebaja = $_POST['rebaja'];
    $stock = $_POST['stock'];
    $genero = $_POST['genero'];
    $descripcion = $_POST['descripcion'];
    
    if (isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];
        $imagen_extension = strtolower(pathinfo($imagen_nombre, PATHINFO_EXTENSION));

        $imagen_nueva = str_replace(" ", "_", $titulo) . ".$imagen_extension";
        $imagen_destino = "images/" . $imagen_nueva;
        move_uploaded_file($imagen_temp, $imagen_destino);
    } else {
        $stmtImagen = $conexion->prepare("SELECT imagen FROM info_juego WHERE titulo_juego=(SELECT titulo FROM juego WHERE id_juego=?)");
        $stmtImagen->bind_param("i", $id_juego);
        $stmtImagen->execute();
        $resultadoImagen = $stmtImagen->get_result();
        $filaImagen = $resultadoImagen->fetch_assoc();
        $imagen_nueva = $filaImagen['imagen'];
    }

    $stmtJuego = $conexion->prepare("UPDATE juego SET precio=?, rebaja=?, stock=? WHERE id_juego=?");
    $stmtJuego->bind_param("diii", $precio, $rebaja, $stock, $id_juego);
    $stmtJuego->execute();

    $stmtInfoJuego = $conexion->prepare("UPDATE info_juego SET genero=?, descripcion=?, imagen=? WHERE titulo_juego=(SELECT titulo FROM juego WHERE id_juego=?)");
    $stmtInfoJuego->bind_param("sssi", $genero, $descripcion, $imagen_nueva,$id_juego);
    $stmtInfoJuego->execute();

    header("Location: ver_eliminar_juegos.php?mensaje=juegoModificado");
    exit();
}

if (isset($_GET['id'])) {
    $id_juego = $_GET['id'];

    $stmtJuego = $conexion->prepare("SELECT info_juego.*, juego.* FROM info_juego JOIN juego ON info_juego.titulo_juego = juego.titulo WHERE id_juego = ?");
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

        .form-group {
            margin-bottom: 100px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group textarea {
            width: 200%; /* O ajusta el ancho según tu diseño */
            height: 200px; /* O ajusta la altura según tu diseño */
        }
    </style>
</head>
<body style="background-color: #4CC5B0; color: #000000;">

<h2>Modificar Juego</h2>

<form action="modificar_juego.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_juego" value="<?php echo htmlspecialchars($juego['id_juego']); ?>">
    <input type="hidden" name="titulo" value="<?php echo htmlspecialchars($juego['titulo']); ?>">
    <p>Plataforma: <?php echo htmlspecialchars($juego['plataforma']); ?></p>
    <p>Título: <?php echo htmlspecialchars($juego['titulo']); ?></p>
    <p>Formato: <?php echo $juego['formato'] == 0 ? "Físico" : "Digital"; ?></p>
    <label for="precio">Precio:</label>
    <input type="number" step="0.01" name="precio" required value="<?php echo htmlspecialchars($juego['precio']); ?>">
    <label for="rebaja">Rebaja:</label>
    <input type="number" min="0" max="100" step="1" name="rebaja" required value="<?php echo htmlspecialchars($juego['rebaja']); ?>">
    <label for="stock">Stock:</label>
    <input type="number" name="stock" required value="<?php echo htmlspecialchars($juego['stock']); ?>">
    <label for="stock">Género:</label>
    <input type="text" name="genero" required value="<?php echo htmlspecialchars($juego['genero']); ?>">
    <br>
    <div>
        <label for="stock">Descripción:</label>
        <textarea name="descripcion" required cols="100" rows="5" style="resize: none;"><?php echo htmlspecialchars($juego['descripcion']); ?></textarea>
    </div>
    <label for="imagen">Imagen:</label>
    <input type="file" name="imagen" accept="image/*">
    <img src="<?php echo 'images/' . $juego['imagen']; ?>" alt="Imagen anterior" width="256 px" height="256 px">
    <input type="submit" value="Modificar Juego">
</form>

</body>
</html>
<?php
}
?>

