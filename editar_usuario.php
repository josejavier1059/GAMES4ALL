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
        <style>
            body {
            background: url('fondo.png') no-repeat center center fixed;
            background-size: contain;
            text-align: center;
            color: #4CC5B0; /* Color del texto en tu página */
            margin: 0; /* Elimina el margen predeterminado del cuerpo */
        }

        #header {
            background-color: #173E59;
            text-align: center;
            color: #ffffff;
            padding: 20px;
            margin-top: -10px;
            margin-left: 0px;
            margin-right: 0px;
            margin-bottom: 100px;
        }

        #header h1 {
            font-family: 'Brush Script MT', cursive; font-size: 36px;
        }

        #header h4 {
            font-family: 'Brush Script MT', cursive; font-size: 20px;
        }
        </style>
        <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Consigue tu juego preferido al mejor precio!</h4>
    </div>
    </head>

    <body>
        
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