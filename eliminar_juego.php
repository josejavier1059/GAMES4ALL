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

if (!isset($_GET['id'])) {
    header('Location: ver_eliminar_juegos.php');
    exit();
}

$id_juego = $_GET['id'];
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

//Antes de eliminar el juego mirar si existe alguna otra version del juego, si no existe eliminar la info del juego
$consulta = "SELECT * FROM juego WHERE id_juego = '$id_juego'";
$resultado = mysqli_query($conexion, $consulta);
$juego = mysqli_fetch_assoc($resultado);

$titulo = $juego['titulo'];

$consulta = "SELECT * FROM juego WHERE titulo = '$titulo'";
$resultado = mysqli_query($conexion, $consulta);

if (mysqli_num_rows($resultado) == 1) {
    $eliminarInfo = "DELETE FROM info_juego WHERE titulo_juego = '$titulo'";
    if (!mysqli_query($conexion, $eliminarInfo)) {
        header('Location: ver_eliminar_juegos.php?error=errorAlEliminarInfo');
        exit();
    }
}

$eliminar = "DELETE FROM juego WHERE id_juego = '$id_juego'";
$resultado = mysqli_query($conexion, $eliminar);

if ($resultado) {
    echo "Juego eliminado con éxito.";
} else {
    echo "Error al eliminar el juego.";
}

header('Location: ver_eliminar_juegos.php');

?>
