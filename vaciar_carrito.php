<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {    
    if (!isset($_COOKIE["id"])) {
        header("Location: index.php");
        exit();
    }
    $id_usuario = $_COOKIE["id"];

    $conexion = new mysqli("localhost", "root", "", "games4all");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "DELETE FROM carrito WHERE id_usuario = $id_usuario";

    if ($conexion->query($sql) === TRUE) {
        echo "Carrito vaciado exitosamente.";
    } else {
        echo "Error al vaciar el carrito: " . $conexion->error;
    }

    $conexion->close();

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>