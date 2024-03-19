<?php
$conexion = new mysqli("localhost", "root", "", "games4all");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Verifica que se haya recibido un id_usuario
if (!isset($_POST['id_usuario']) || empty($_POST['id_usuario'])) {
    die("No se proporcionó el ID del usuario.");
}

$id_usuario = $_POST['id_usuario'];

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
        
        <form action="procesar_edicion_usuario.php" method="post">
        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
        Alias: <input type="text" name="alias" value="<?php echo htmlspecialchars($usuario['alias']); ?>"><br>
        Contraseña Antigua: <input type="password" name="password_antigua"><br>
        Nueva Contraseña: <input type="password" name="password_nueva"><br>
        Confirmar Nueva Contraseña: <input type="password" name="password_confirmacion"><br>
        Correo: <input type="email" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>"><br>
        <input type="submit" value="Guardar cambios">
</form>
    </body>
</html>