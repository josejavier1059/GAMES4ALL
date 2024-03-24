<?php
    if(isset($_GET['id']) && !empty($_GET['id'])) {
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

        $id_descuento = $_GET['id'];
        $sql = "DELETE FROM descuento WHERE id_descuento = $id_descuento";

        if ($conexion->query($sql) === TRUE) {
            header("Location: gestionar_descuentos.php");
            exit();
        } else {
            echo "Error al eliminar el descuento: " . $conexion->error;
        }

        $conexion->close();
    } else {
        header("Location: gestionar_descuentos.php");
        exit();
    }
?>