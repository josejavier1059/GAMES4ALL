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


if (!isset($_GET['id'])) {
    // Si no se proporciona un ID, redirigir de vuelta a la lista de juegos
    header('Location: ver_eliminar_juegos.php');
    exit();
}

$id_juego = $_GET['id'];
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

// Eliminar el juego seleccionado
$eliminar = "DELETE FROM juegos WHERE id_juego = '$id_juego'";
$resultado = mysqli_query($conexion, $eliminar);

if ($resultado) {
    echo "Juego eliminado con éxito.";
} else {
    echo "Error al eliminar el juego.";
}

// Redirigir de vuelta a la lista de juegos
header('Location: ver_eliminar_juegos.php');

?>
