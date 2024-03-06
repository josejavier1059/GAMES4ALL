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
            <h3>Acceso</h3>
            <?php
            $alias = $_POST["alias"];
            $pass = $_POST["password"];

            $conexion = mysqli_connect("localhost", "root", "", "games4all")or die("Fallo al hacer la consulta");
            $consulta = mysqli_query($conexion, "SELECT * FROM usuario WHERE alias = '$alias' AND password = '$pass'");

            $nUsuarios = mysqli_num_rows($consulta);

            if ($nUsuarios > 0) {
                for ($i = 0; $i < $nUsuarios; $i++) {
                    $fila = mysqli_fetch_array($consulta);
                    if($fila['alias'] == $alias && $fila['password'] == $pass){
                        ?><h4>¡Bienvenido <?php echo $alias; ?>, nos alegra verte de nuevo!</h4>
                        
                        <form method="post" action="menus.php">
                            <input type="hidden" name="alias" value=<?php echo $alias ?>>
    		                <input type="hidden" name="pass" value=<?php echo $pass ?>>
                            <input type="submit" value="Acceder a tu perfil">
                        </form>
                    <?php
                    }

                }
            }
            else{
                    ?>
                    <h5>El usuario o contraseña introducidos no son correctos. Por favor, inténtelo de nuevo.</h5>

                    <form method="post" action="login.php">
                        <input type="submit" value="Volver">
                    </form>
                <?php
            }
            ?>
    </body>
</html>