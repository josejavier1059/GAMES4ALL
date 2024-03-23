<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_descuento']) && isset($_POST['descuento'])) {
        $id_descuento = $_POST['id_descuento'];
        $nuevo_descuento = $_POST['descuento'];

        $conexion = new mysqli("localhost", "root", "", "games4all");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        if (!isset($_COOKIE['alias'])) {
            header('Location: index.php');
            exit();
        }
    
        $alias = $_COOKIE['alias'];
        $consultaRol = $conexion->prepare("SELECT rol FROM usuario WHERE alias = ?");
        $consultaRol->bind_param("s", $alias);
        $consultaRol->execute();
        $resultadoRol = $consultaRol->get_result();
    
        if ($resultadoRol->num_rows == 0 || $resultadoRol->fetch_assoc()['rol'] !== 'administrador') {
            header('Location: index.php');
            exit();
        }

        $sql = "UPDATE descuento SET valor = $nuevo_descuento WHERE id_descuento = $id_descuento";

        if ($conexion->query($sql) === TRUE) {
            header("Location: gestionar_descuentos.php");
            exit();
        } else {
            echo "Error al modificar el descuento: " . $conexion->error;
        }

        $conexion->close();
    } else {
        header("Location: modificar_descuento.php");
        exit();
    }
} else {
    header("Location: modificar_descuento.php");
    exit();
}
?>
