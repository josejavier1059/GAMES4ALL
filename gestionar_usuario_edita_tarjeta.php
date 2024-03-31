<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

if (!isset($_COOKIE['alias'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['id_tarjeta'], $_POST['numero'], $_POST['caducidad'])) {
    $idTarjeta = mysqli_real_escape_string($conexion, $_POST['id_tarjeta']);
    $titular = mysqli_real_escape_string($conexion, $_POST['titular']);
    $numero = mysqli_real_escape_string($conexion, $_POST['numero']);
    $caducidad = mysqli_real_escape_string($conexion, $_POST['caducidad']);
    
    if (!preg_match('/^\d{16}$/', $numero)) {
        echo "<script>alert('El número de tarjeta no es válido.'); window.location.href='usuario_edita_tarjeta.php?id_tarjeta=$idTarjeta';</script>";
        exit();
    }
    
    $queryActualizar = "UPDATE tarjeta SET numero = '$numero', titular = '$titular', caducidad = '$caducidad' WHERE id_tarjeta = '$idTarjeta'";
    
    if (mysqli_query($conexion, $queryActualizar)) {
        echo "<script>alert('Tarjeta actualizada correctamente.'); window.location.href='gestionar_tarjetas.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la tarjeta: " . mysqli_error($conexion) . "'); window.location.href='usuario_edita_tarjeta.php?id_tarjeta=$idTarjeta';</script>";
    }
} else {
    header('Location: gestionar_tarjetas.php');
}
?>
