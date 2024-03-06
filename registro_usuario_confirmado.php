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
    <body style="background-color: #4CC5B0; text-align: center; color: #000000;">
        <div style="float: center;">
            <h3>Registro de usuario</h3>
        <?php
       
        $alias_target = $_POST["alias_target"];
        $pass_target = $_POST["pass_target"];
        $email_target = $_POST["email_target"];

        
        $conexion = mysqli_connect("localhost", "root", "", "games4all")or die("Fallo al hacer la consulta");
    
    ?>
        <?php   
                if(mysqli_query($conexion, "INSERT INTO usuario(alias, password, correo) VALUES ('$alias_target', '$pass_target', '$email_target')")){
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