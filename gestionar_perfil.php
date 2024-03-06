<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>G4A</title>
        <div style="background-color: #0CAFDC; text-align: center; color: #ffffff; padding: 30px;margin-top: -10px;margin-left: -10px;margin-right: -10px;margin-bottom: 100px;">
            <h1 style="font-family: 'Brush Script MT', cursive; font-size: 36px;">GAMES4ALL</h1>
            <h4 style="font-family: 'Brush Script MT', cursive; font-size: 20px;">¡Consigue tu juego preferido al mejor precio!</h4>
        </div>
    </head>

    <body style="background-color: #4CC5B0; text-align: center; color: #000000;">
        <div style="float: center; width: 100%;"> <!-- ZONA CENTRAL -->
            <h3>Perfil de <?php echo $alias ?></h3>
            <h6>Nombre de usuario: <?php echo $alias ?></h6>
            <h6>Rol: <?php echo $rol ?></h6>
            <h6>Contraseña: <?php echo $pass ?></h6>
            <h6>Email: <?php echo $email ?></h6>
            
            <form method="post" action="editar_usuario.php" style="float: center;">
                <input type="hidden" name="alias" value=<?php echo $alias ?>>
                <input type="hidden" name="alias_target" value=<?php echo $alias ?>>
                <input type="submit" value="Editar">
            </form>

            <form method="post" action="borrar_usuario.php" style="float: center;">
                <input type="hidden" name="alias" value=<?php echo $alias ?>>
                <input type="hidden" name="alias_target" value=<?php echo $alias ?>>
                <input type="submit" value="Borrar cuenta">
            </form>
            
        </div>
    </body>
</html>