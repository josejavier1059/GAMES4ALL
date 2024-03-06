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

     <?php
        $alias = $_POST["alias"];

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
                <input type="hidden" name="alias" value=<?php echo $alias ?>>
                <input type="hidden" name="alias_target" value=<?php echo $alias ?>>
                <input type="submit" value="Editar">
            </form>

            <form method="post" action="borrar_usuario.php">
                <input type="hidden" name="alias" value=<?php echo $alias ?>>
                <input type="hidden" name="alias_target" value=<?php echo $alias ?>>
                <input type="submit" value="Borrar cuenta">
            </form>
            
        </div>
    </body>
</html>