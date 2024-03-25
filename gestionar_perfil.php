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

     <?php
        if (!isset($_COOKIE['alias'])) {
            header('Location: index.php');
            exit();
        }
    
        $alias = $_COOKIE['alias'];

        $conexion = mysqli_connect("localhost", "root", "", "games4all")or die("Fallo al hacer la consulta.");
        $consulta = mysqli_query($conexion, "SELECT * FROM usuario WHERE alias = '$alias'");

        $linea = mysqli_fetch_array($consulta);
        $id = $linea["id_usuario"];
        $roles = $linea["rol"];
        $alias = $linea["alias"];
        $pass = $linea["password"];
        $email = $linea["correo"];

    ?>
    <body style="background-color: #4CC5B0; text-align: center; color: #000000;">
        <div style="float: left; width: 20%; height: 400px;margin-top: -60px; background-color: #173E59; color: #ffffff;font-size: 25px;">
            <h3>Perfil de <?php echo $alias ?></h3>
            <h6>Nombre de usuario: <?php echo $alias ?></h6>
            <h6>Rol: <?php echo $roles ?></h6>
            <h6>Contraseña: <?php echo $pass ?></h6>
            <h6>Email: <?php echo $email ?></h6>
            
            <form method="post" action="editar_usuario.php">
            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id); ?>">
            <input type="submit" value="Editar">
            </form>
	
	    <form method="POST" action="menus.php">
                <input type="submit" value="Volver">
            </form>	
	    
        </div>
    </body>
</html>