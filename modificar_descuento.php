<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Modificar Descuento - G4A</title>
    <link rel="stylesheet" href="estilos.css">
    <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Consigue tu juego preferido al mejor precio!</h4>
    </div>
</head>
<body style="background-color: #4CC5B0; color: #000000;">
<div style="text-align: center; margin-right: 50%;">
    <a href="gestionar_descuentos.php">Volver</a>
    <h1>Modificar Descuento</h1>
</div>

<div style="text-align: center; margin-right: 50%;">
    <?php
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id_descuento = $_GET['id'];

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

        $sql = "SELECT * FROM descuento WHERE id_descuento = $id_descuento";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            $descuento = $resultado->fetch_assoc();
    ?>
    <form action="modifica_descuento.php" method="post">
        <input type="hidden" name="id_descuento" value="<?php echo $descuento['id_descuento']; ?>">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?php echo $descuento['id_usuario']; ?>" disabled><br><br>
        <label for="descuento">Descuento (%):</label>
        <input type="number" name="descuento" id="descuento" min="1" max="100" value="<?php echo $descuento['valor']; ?>" required><br><br>
        <input type="submit" value="Modificar Descuento">
    </form>
    <?php
        } else {
            echo "No se encontró el descuento.";
        }

        $conexion->close();
    } else {
        echo "ID de descuento no proporcionado.";
    }
    ?>
</div>
</body>
</html>
