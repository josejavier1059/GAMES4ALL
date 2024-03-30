<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

if (!isset($_COOKIE['alias'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['id_tarjeta'])) {
    $idTarjeta = mysqli_real_escape_string($conexion, $_POST['id_tarjeta']);

    $queryEliminar = "DELETE FROM tarjeta WHERE id_tarjeta = '$idTarjeta'";
    if (mysqli_query($conexion, $queryEliminar)) {
        echo "<script>alert('Tarjeta eliminada correctamente.'); window.location.href='gestionar_tarjetas.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar la tarjeta.'); window.location.href='gestionar_tarjetas.php';</script>";
    }
} else {
    header('Location: gestionar_tarjetas.php');
}
?>
