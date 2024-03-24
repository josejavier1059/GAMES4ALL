<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Modificar Pedido - G4A</title>
    <link rel="stylesheet" href="estilos.css">
    <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Consigue tu juego preferido al mejor precio!</h4>
    </div>
</head>
<body style="background-color: #4CC5B0; color: #000000;">
<div style="text-align: center;">
        <form method="POST" action="gestionar_pedidos.php">
            <input type="submit" value="Volver">
        </form>
    <h1>Modificar Pedido</h1>
</div>

<div style="text-align: center;">
    <?php
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id_pedido = $_GET['id'];

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

        $sql = "SELECT p.id_pedido, u.alias, t.numero, IFNULL(p.descuento, 0) as descuento, p.subtotal, p.fecha FROM pedido p JOIN usuario u ON p.id_usuario = u.id_usuario JOIN tarjeta t ON p.id_tarjeta = t.id_tarjeta WHERE p.id_pedido = ".$id_pedido."";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            $pedido = $resultado->fetch_assoc();
    ?>
    <form action="modifica_pedido.php" method="post">
        <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?php echo $pedido['alias']; ?>" disabled><br><br>
        <label for="descuento">Descuento (%):</label>
        <input type="number" name="descuento" id="descuento" min="0" max="100" step="1" value="<?php echo $pedido['descuento']; ?>" required><br><br>
        <label for="subtotal">Subtotal (€):</label>
        <input type="number" name="subtotal" id="subtotal" min="0" step="0.01" value="<?php echo $pedido['subtotal']; ?>" required><br><br>
        <label for="fecha">Fecha (dd/mm/aaaa):</label>
        <input type="date" name="fecha" id="fecha" value="<?php echo $pedido['fecha']; ?>" required><br><br>
        <input type="submit" value="Modificar Pedido">
    </form>
    <?php
        } else {
            echo "No se encontró el pedido.";
        }

        $conexion->close();
    } else {
        echo "ID de pedido no proporcionado.";
    }
    ?>
</div>
</body>
</html>
