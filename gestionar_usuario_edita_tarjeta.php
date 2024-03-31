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

    $sql_check = "SELECT * FROM tarjeta WHERE numero = '$numero'";
    $result = $conexion->query($sql_check);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['id_tarjeta'] != $idTarjeta) {
                header("Location: usuario_edita_tarjeta.php?id_tarjeta=" . $idTarjeta . "&?error=TarjetaYaExiste");
                exit();
            }
        }
    }

    $caducidad = "20" . substr($caducidad, 3, 2) . "-" . substr($caducidad, 0, 2) . "-01";
    $fecha_actual = date("Y-m-d");
        
    if (strtotime($caducidad) < strtotime($fecha_actual)) {
        header("Location: usuario_edita_tarjeta.php?id_tarjeta=" . $idTarjeta . "&?error=FechaError");
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
