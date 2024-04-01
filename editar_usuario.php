<?php
$conexion = new mysqli("localhost", "root", "", "games4all");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if (!isset($_COOKIE['id']) || empty($_COOKIE['id'])) {
    die("No se proporcionó el ID del usuario.");
}

$id_usuario = $_COOKIE['id'];

$consulta = $conexion->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
$consulta->bind_param("i", $id_usuario);
$consulta->execute();
$resultado = $consulta->get_result();

if ($resultado->num_rows == 0) {
    die("Usuario no encontrado con ID: $id_usuario.");
}

$usuario = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>G4A</title>
        <link rel="stylesheet" href="estilos.css">
        <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Consigue tu juego preferido al mejor precio!</h4>
    </div>
    </head>

    <body style="background-color: #4CC5B0; text-align: center; color: #000000;">

        <?php
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            if ($error == "AntiguaIncorrecta") {
                echo "La contraseña antigua no es correcta.";
            } else if ($error == "NoCoinciden") {
                echo "La nueva contraseña y su confirmación no coinciden.";
            }
        }
        ?>
        <form action="procesar_edicion_usuario.php" method="post">
        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
        Alias: <input type="text" name="alias" value="<?php echo htmlspecialchars($usuario['alias']); ?>"><br>
        Contraseña Antigua: <input type="password" name="password_antigua"><br>
        Nueva Contraseña: <input type="password" name="password_nueva"><br>
        Confirmar Nueva Contraseña: <input type="password" name="password_confirmacion"><br>
        Correo: <input type="email" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>"><br>
        Nombre Completo: <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>"><br>
        <input type="submit" value="Guardar cambios">
</form>

	<form method="POST" action="gestionar_perfil.php">
                <input type="submit" value="Volver">
            </form>
    </body>
</html>