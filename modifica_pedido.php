<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['id_pedido']) && isset($_POST['descuento']) && isset($_POST['subtotal']) && isset($_POST['fecha'])) {
        $id_pedido = $_POST['id_pedido'];
        $descuento = $_POST['descuento'];
        $subtotal = $_POST['subtotal'];
        $fecha = $_POST['fecha'];

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

        $consulta = $conexion->prepare("UPDATE pedido SET descuento = ?, subtotal = ?, fecha = ? WHERE id_pedido = ?");
        $consulta->bind_param("ddsi", $descuento, $subtotal, $fecha, $id_pedido);

        if ($consulta->execute()) {
            header("Location: gestionar_pedidos.php");
            exit();
        } else {
            echo "Error al modificar el pedido: " . $conexion->error;
        }

        $conexion->close();
    } else {
        header("Location: modificar_pedido.php");
        exit();
    }
} else {
    header("Location: modificar_pedido.php");
    exit();
}
?>