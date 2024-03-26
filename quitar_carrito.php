<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_juego"])) {
    $id_juego = $_POST["id_juego"];
    
    if (!isset($_COOKIE["id"])) {
        header("Location: index.php");
        exit();
    }
    $id_usuario = $_COOKIE["id"];

    $conexion = new mysqli("localhost", "root", "", "games4all");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "DELETE FROM carrito WHERE id_usuario = $id_usuario AND id_juego = $id_juego";

    if ($conexion->query($sql) === TRUE) {
        echo "Juego eliminado del carrito exitosamente.";
    } else {
        echo "Error al eliminar el juego del carrito: " . $conexion->error;
    }

    $conexion->close();

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>