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
        <div style="float: center;">
            <h3>Registro de usuario</h3>
        <?php
       
        $alias_target = $_POST["alias_target"];
        $pass_target = $_POST["pass_target"];
        $email_target = $_POST["email_target"];
        $nombre = $_POST["nombre"];

        
        $conexion = mysqli_connect("localhost", "root", "", "games4all")or die("Fallo al hacer la consulta");
    
    ?>
        <?php   
                if(mysqli_query($conexion, "INSERT INTO usuario(alias, password, correo, nombre) VALUES ('$alias_target', '$pass_target', '$email_target', '$nombre')")){
        ?>          ¡El usuario <?php echo $alias_target ?> se ha creado con éxito!<br><br>

                    <form method="POST" action="login.php">
                        <input type="submit" value="Accede a tu cuenta">
                    </form> 
        <?php   
                }
                else{
        ?>          Ha ocurrido un error al crear el usuario. Por favor, inténtelo de nuevo.
                    <form method="POST" action="registro_usuario.php">
                        <input type="hidden" name="alias" value=<?php echo $alias_target ?>>
                        <input type="submit" value="Volver">
                    </form>
        <?php
                }
        ?>
        </div>
    </body>
</html>