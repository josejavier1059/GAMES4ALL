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

$plataforma = $_POST['plataforma'];
$titulo = $_POST['titulo'];
$precio = $_POST['precio'];
$rebaja = $_POST['rebaja'];
$stock = $_POST['stock'];
$formato = $_POST['formato'];
$genero = $_POST['genero'];
$descripcion = $_POST['descripcion'];

$imagen_nombre = $_FILES['imagen']['name'];
$imagen_temp = $_FILES['imagen']['tmp_name'];
$imagen_extension = strtolower(pathinfo($imagen_nombre, PATHINFO_EXTENSION));

$imagen_nueva = str_replace(" ", "_", $titulo) . ".$imagen_extension";
$imagen_destino = "images/" . $imagen_nueva;
move_uploaded_file($imagen_temp, $imagen_destino);

$consulta = "SELECT * FROM info_juego WHERE titulo_juego = '$titulo'";
$resultado = mysqli_query($conexion, $consulta);
if (mysqli_num_rows($resultado) == 0) { //No existe info del juego
    //DEBE proporcionar info
    if (empty($descripcion) || empty($genero) || empty($imagen_nombre)) {
        header('Location: admin_introduce_juego.php?error=faltanDatosInfo');
        exit();
    }
    $insertarInfo = "INSERT INTO info_juego (titulo_juego, genero, descripcion, imagen) VALUES ('$titulo', '$genero', '$descripcion', '$imagen_nueva')";
    if (!mysqli_query($conexion, $insertarInfo)) {
        header('Location: admin_introduce_juego.php?error=errorAlIntoducirInfo');
        exit();
    }
} else {
    //actualizamos la info (si se han indicado los campos)
    if (!empty($descripcion) && !empty($genero) && !empty($imagen_nombre)) {
        $actualizarInfo = "UPDATE info_juego SET genero = '$genero', descripcion = '$descripcion', imagen= '$imagen_nueva' WHERE titulo_juego = '$titulo'";
        if (!mysqli_query($conexion, $actualizarInfo)) {
            header('Location: admin_introduce_juego.php?error=errorAlActualizarInfo');
            exit();
        }
    }
}

// Verificar si existe ya existe esa version del juego
$consultaJuegoExistente = "SELECT id_juego FROM juego WHERE titulo = '$titulo' AND plataforma = '$plataforma' AND formato = '$formato'";
$resultadoJuegoExistente = mysqli_query($conexion, $consultaJuegoExistente);

if (mysqli_num_rows($resultadoJuegoExistente) > 0) {
    header('Location: admin_introduce_juego.php?error=juegoYaExistente');
    exit();
}

$insertarJuego = "INSERT INTO juego (plataforma, titulo, precio, rebaja, stock, formato) VALUES ('$plataforma', '$titulo', $precio, $rebaja, $stock, '$formato')";
if (!mysqli_query($conexion, $insertarJuego)) {
    header('Location: admin_introduce_juego.php?error=errorAlIntroducirJuego');
    exit();
}

header('Location: buscar_juegos.php?success=1');
?>
