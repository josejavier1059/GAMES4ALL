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
$conexion = new mysqli("localhost", "root", "", "games4all");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$id_usuario = $_POST['id_usuario'];
$alias = $_POST['alias'];
$correo = $_POST['correo'];
$passwordAntigua = $_POST['password_antigua'];
$passwordNueva = $_POST['password_nueva'];
$passwordConfirmacion = $_POST['password_confirmacion'];

// Verificar contraseña antigua
$consulta = $conexion->prepare("SELECT password FROM usuario WHERE id_usuario = ?");
$consulta->bind_param("i", $id_usuario);
$consulta->execute();
$resultado = $consulta->get_result();
$usuario = $resultado->fetch_assoc();

if ($usuario['password'] !== $passwordAntigua) {
    die("La contraseña antigua no es correcta.");
}

// Verificar que la nueva contraseña y su confirmación coincidan
if ($passwordNueva !== $passwordConfirmacion) {
    die("La nueva contraseña y su confirmación no coinciden.");
}

// Omitir la actualización de la contraseña si no se proporciona una nueva
if (!empty($passwordNueva)) {
    $query = "UPDATE usuario SET alias=?, correo=?, password=? WHERE id_usuario=?";
    $stmt = $conexion->prepare($query);
    // Aquí simplemente asignamos passwordNueva directamente sin encriptar
    $stmt->bind_param("sssi", $alias, $correo, $passwordNueva, $id_usuario);
} else {
    // Actualizar solo alias y correo si no se cambia la contraseña
    $query = "UPDATE usuario SET alias=?, correo=? WHERE id_usuario=?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssi", $alias, $correo, $id_usuario);
}

if ($stmt->execute()) {
    echo "Registro actualizado con éxito.<br>";
    echo "Serás redirigido automaticamente.";
    header("refresh:3;url=menus.php");
} else {
    echo "Error al actualizar el registro: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
    </body>
</html>

