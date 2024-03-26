<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_juego"])) {
    $id_juego = $_POST["id_juego"];
    $id_usuario = $_COOKIE["id"];

    $conexion = new mysqli("localhost", "root", "", "games4all");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    $sql = "INSERT INTO carrito (id_usuario, id_juego) VALUES ('$id_usuario', '$id_juego')"; 

    if ($conexion->query($sql) === TRUE) {
        echo "Juego agregado al carrito exitosamente.";
    } else {
        echo "Error al agregar el juego al carrito: " . $conexion->error;
    }

    $conexion->close();

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>