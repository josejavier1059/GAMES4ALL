<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['usuario']) && isset($_POST['descuento'])) {
        $id_usuario = $_POST['usuario'];
        $descuento = $_POST['descuento'];

        $conexion = new mysqli("localhost", "root", "", "games4all");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

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

        $sql = "INSERT INTO descuento (id_usuario, valor) VALUES ($id_usuario, $descuento)";

        if ($conexion->query($sql) === TRUE) {
            header("Location: gestionar_descuentos.php");
            exit();
        } else {
            echo "Error al añadir el descuento: " . $conexion->error;
        }

        $conexion->close();
    } else {
        header("Location: añadir_descuento.php");
        exit();
    }
} else {
    header("Location: añadir_descuento.php");
    exit();
}
?>
