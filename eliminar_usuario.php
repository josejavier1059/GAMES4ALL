<?php
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");


if (!isset($_COOKIE['alias']) || $_COOKIE['rol'] !== 'administrador') {
    header('Location: index.php');
    exit();
}


if (!isset($_GET['id'])) {
    echo "<script>alert('No se proporcionó ningún ID de usuario.'); window.location.href='gestionar_usuarios.php';</script>";
    exit();
}

$id_usuario = mysqli_real_escape_string($conexion, $_GET['id']);


$pedidosQuery = mysqli_query($conexion, "SELECT id_pedido FROM pedido WHERE id_usuario = '$id_usuario'");
while ($pedido = mysqli_fetch_assoc($pedidosQuery)) {
    $id_pedido = $pedido['id_pedido'];
    mysqli_query($conexion, "DELETE FROM juegos_pedido WHERE id_pedido = '$id_pedido'");
}


mysqli_query($conexion, "DELETE FROM pedido WHERE id_usuario = '$id_usuario'");


mysqli_query($conexion, "DELETE FROM descuento WHERE id_usuario = '$id_usuario'");
mysqli_query($conexion, "DELETE FROM tarjeta WHERE id_usuario = '$id_usuario'");


if (mysqli_query($conexion, "DELETE FROM usuario WHERE id_usuario = '$id_usuario'")) {
    echo "<script>alert('Usuario eliminado correctamente.'); window.location.href='gestionar_usuarios.php';</script>";
} else {
    echo "<script>alert('Error al eliminar el usuario.'); window.location.href='gestionar_usuarios.php';</script>";
}

mysqli_close($conexion);
?>
