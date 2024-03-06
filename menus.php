<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>G4A</title>
        <div style="background-color: #000000; text-align: center; color: #ffffff; padding: 30px;margin-top: -10px;margin-left: -10px;margin-right: -10px;margin-bottom: 100px;">
            <h1 style="font-family: 'Brush Script MT', cursive; font-size: 36px;">GAMES4ALL</h1>
            <h4 style="font-family: 'Brush Script MT', cursive; font-size: 20px;">¡Consigue tu juego preferido al mejor precio!</h4>
        </div>
    </head>

    <?php
            $alias = $_POST["alias"];

            $conexion = mysqli_connect("localhost", "root", "password", "games4all")or die("Fallo al hacer la consulta.");
            $consulta = mysqli_query($conexion, "SELECT * FROM usuario WHERE alias = '$alias'");

            $linea = mysqli_fetch_array($consulta);
            $id = $linea["id"];
            $id_rol = $linea["id_rol"];
            $alias = $linea["alias"];
            $pass = $linea["contraseña"];
            $email = $linea["email"];

            $consulta_rol = mysqli_query($conexion, "SELECT * FROM rol WHERE id = '$id_rol'");
            $linea_rol = mysqli_fetch_array($consulta_rol);

            $rol = $linea_rol["nombre"];

        ?>
    <body style="background-color: #173E59; text-align: center; color: #66B2D6;">
    <div style="float: left; width: 20%; height: 400px; background-color: #171A21; color: #B8B6B4;">
    <?php   if ($id_rol == 1){
                echo "Panel de $rol<br>Has iniciado sesión como:<br>$alias";
    ?>          
                <form method="post" action="perfil_usuario.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar perfil">
                </form>
                <br>

                <form method="post" action="index.php">
                    <input type="submit" value="Cerrar sesión">
                </form>
                <br> 
    <?php
            }
            else{
                echo "Panel de $rol<br>Has iniciado sesión como:<br>$alias";
    ?>          
                <form method="post" action="perfil_usuario.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar perfil">
                </form>

                <br>
                <form method="post" action="index.php">
                    <input type="submit" value="Cerrar sesión">
                </form>
        <?php
            }
        ?>
            </div>
    </body>
</html>