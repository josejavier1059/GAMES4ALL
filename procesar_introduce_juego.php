<?php
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

// Verificar si el usuario está logueado mediante la cookie 'alias'
if (!isset($_COOKIE['alias'])) {
    header('Location: index.php'); // Redirige al usuario a la página de inicio si no está logueado
    exit();
}

$alias = $_COOKIE['alias'];

// Preparar y ejecutar la consulta para verificar el rol del usuario
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

$plataforma = $_POST['plataforma'];
$titulo = $_POST['titulo'];
$precio = $_POST['precio'];
$rebaja = $_POST['rebaja'];
$stock = $_POST['stock'];
$id_tipo = $_POST['id_tipo'] ?? null;
$genero = $_POST['genero'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';

// Verificar si se ha proporcionado id_tipo
if (!empty($id_tipo)) {
    // Verificar que el id_tipo exista y coincida con el título del juego
    $consulta = "SELECT * FROM tipo WHERE id_tipo = '$id_tipo' AND titulo = '$titulo'";
    $resultado = mysqli_query($conexion, $consulta);
    if (mysqli_num_rows($resultado) == 0) {
        // Si no hay coincidencia, redirigir con error
        header('Location: admin_introduce_juego.php?error=noCoincideTipo');
        exit();
    }
} else {
    // Si no se proporcionó id_tipo, intentar insertar o actualizar el tipo basado en el título del juego
    if (!empty($genero) && !empty($descripcion)) {
        // Verificar si ya existe un tipo con el mismo título
        $consultaExistente = mysqli_query($conexion, "SELECT id_tipo FROM tipo WHERE titulo = '$titulo'");
        if ($fila = mysqli_fetch_assoc($consultaExistente)) {
            $id_tipo = $fila['id_tipo'];
        } else {
            $insertarTipo = "INSERT INTO tipo (titulo, genero, descripcion) VALUES ('$titulo', '$genero', '$descripcion')";
            if (!mysqli_query($conexion, $insertarTipo)) {
                header('Location: admin_introduce_juego.php?error=errorTipo');
                exit();
            }
            $id_tipo = mysqli_insert_id($conexion);
        }
    } else {
        header('Location: admin_introduce_juego.php?error=faltanDatosTipo');
        exit();
    }
}

// Primero verificar si ya existe un juego con el mismo título y plataforma
$consultaJuegoExistente = "SELECT id_juego FROM juegos WHERE titulo = '$titulo' AND plataforma = '$plataforma'";
$resultadoJuegoExistente = mysqli_query($conexion, $consultaJuegoExistente);
if (mysqli_num_rows($resultadoJuegoExistente) > 0) {
    // Si el juego ya existe, redirigir con un mensaje de error
    header('Location: admin_introduce_juego.php?error=juegoYaExistente');
    exit();
}

// Insertar el nuevo juego usando el id_tipo obtenido o asignado
$insertarJuego = "INSERT INTO juegos (plataforma, titulo, precio, rebaja, stock, tipo) VALUES ('$plataforma', '$titulo', $precio, $rebaja, $stock, '$id_tipo')";
if (mysqli_query($conexion, $insertarJuego)) {
    header('Location: buscar_juegos.php?success=1');
} else {
    header('Location: admin_introduce_juego.php?error=errorAlIntroducirJuego');
}
?>
