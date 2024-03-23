<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Añadir Descuento - G4A</title>
    <link rel="stylesheet" href="estilos.css">
    <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Consigue tu juego preferido al mejor precio!</h4>
    </div>
</head>
<body style="background-color: #4CC5B0; color: #000000;">
<div style="text-align: center; margin-right: 50%;">
    <a href="menus.php">Volver</a>
    <h1>Añadir Descuento</h1>
</div>

<div style="text-align: center; margin-right: 50%;">
    <form action="añade_descuento.php" method="post">
        <label for="usuario">Usuario:</label>
        <select name="usuario" id="usuario">
            <?php
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

            $sql = "SELECT id_usuario, alias FROM usuario";
            $resultado = $conexion->query($sql);

            while ($fila = $resultado->fetch_assoc()) {
                echo "<option value='" . $fila['id_usuario'] . "'>" . $fila['alias'] . "</option>";
            }

            $conexion->close();
            ?>
        </select><br><br>
        <label for="descuento">Descuento (%):</label>
        <input type="number" name="descuento" id="descuento" min="1" max="100" required><br><br>
        <input type="submit" value="Añadir Descuento">
    </form>
</div>
</body>
</html>
