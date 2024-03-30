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
    <style>
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
    </head>
<body style="background-color: #4CC5B0; text-align: center; color: #000000;">
<div style="text-align: center;">
    <h1>Nuevos datos</h1>
    <?php
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id_usuario = $_GET['id'];

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

        $sql = "SELECT * FROM usuario WHERE id_usuario = $id_usuario";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
?>
        <form action="admin_edita_usuariook.php" method="post">
        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
        Alias: <input type="text" name="alias" value="<?php echo htmlspecialchars($usuario['alias']); ?>"><br>
        Nueva Contraseña: <input type="password" name="password_nueva"><br>
        Confirmar Nueva Contraseña: <input type="password" name="password_confirmacion"><br>
        <?php 
    // Verificar si las contraseñas coinciden
    if(isset($_POST['password_nueva']) && isset($_POST['password_confirmacion']) && $_POST['password_nueva'] == $_POST['password_confirmacion']){
        // Contraseñas coinciden, agregar campo oculto con la contraseña nueva
        echo "<input type='hidden' name='password_nueva_confirmada' value='" . htmlspecialchars($_POST['password_nueva']) . "'>";
    }
    ?>
        Correo: <input type="email" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>"><br>
        Nombre Completo: <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>"><br>
        Pais: <input type="text" name="pais" value="<?php echo htmlspecialchars($usuario['pais']); ?>"><br>
        Ciudad: <input type="text" name="ciudad" value="<?php echo htmlspecialchars($usuario['ciudad']); ?>"><br>
        Calle: <input type="text" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>"><br>
        Codigo postal: <input type="text" name="cod_postal" value="<?php echo htmlspecialchars($usuario['cod_postal']); ?>"><br><br>
        <input type="submit" value="Guardar cambios">
        </form>

  <?php } else{
            echo "No se encontró el usuario.";
        }
        $conexion->close();
        } else {
        echo "ID de usuario no proporcionado.";
    }    
    ?>
    <br>
    <form method="POST" action="gestionar_usuarios.php">
    	<input type="submit" value="Volver">
    </form>
</div>
<div style="float: left; width: 25%; height: 575px;margin-top: -425px; background-color: #173E59; color: #ffffff;font-size: 25px;">
            <h3>Perfil actual de <?php echo $usuario['alias']?></h3>
            <h6>Nombre de usuario: <?php echo $usuario['alias'] ?></h6>
            <h6>Contraseña: <?php echo $usuario['password'] ?></h6>
            <h6>Email: <?php echo $usuario['correo'] ?></h6>
            <h6>Nombre: <?php echo $usuario['nombre'] ?></h6>
            <h6>País: <?php echo $usuario['pais'] ?></h6>
            <h6>Ciudad: <?php echo $usuario['ciudad'] ?></h6>
            <h6>Calle: <?php echo $usuario['direccion'] ?></h6>
            <h6>Código Postal: <?php echo $usuario['cod_postal'] ?></h6>       
</div>
</body>
</html>
