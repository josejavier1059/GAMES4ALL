<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

if (!isset($_COOKIE['alias'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alias = $_COOKIE['alias'];
    $numero = mysqli_real_escape_string($conexion, $_POST['numero']);
    $caducidad = mysqli_real_escape_string($conexion, $_POST['caducidad']);
    $titular = mysqli_real_escape_string($conexion, $_POST['titular']);

    $sql_check = "SELECT * FROM tarjeta WHERE numero = '$numero'";
    $result = $conexion->query($sql_check);

    if ($result->num_rows > 0) {
        header("Location: usuario_añade_tarjeta.php?error=TarjetaYaExiste");
        exit();
    }
    
    $queryUsuario = "SELECT id_usuario FROM usuario WHERE alias = '$alias'";
    $resultadoUsuario = mysqli_query($conexion, $queryUsuario);
    if ($fila = mysqli_fetch_assoc($resultadoUsuario)) {
        $id_usuario = $fila['id_usuario'];

        $caducidad = "20" . substr($caducidad, 3, 2) . "-" . substr($caducidad, 0, 2) . "-01";
        $fecha_actual = date("Y-m-d");
            
        if (strtotime($caducidad) < strtotime($fecha_actual)) {
            header("Location: usuario_añade_tarjeta.php?error=FechaError");
            exit();
        }
       
        $sql = "INSERT INTO tarjeta (numero, caducidad, titular, id_usuario) VALUES ('$numero', '$caducidad', '$titular', '$id_usuario')";

        if (mysqli_query($conexion, $sql)) {
            header('Location: gestionar_tarjetas.php');
        } else {
            header('Location: usuario_añade_tarjeta.php');
        }
    } else {
        header('Location: usuario_añade_tarjeta.php');
    }
}
?>
