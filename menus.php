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

            $conexion = mysqli_connect("localhost", "root", "", "games4all")or die("Fallo al hacer la consulta.");
            $consulta = mysqli_query($conexion, "SELECT * FROM usuario WHERE alias = '$alias'");

            $linea = mysqli_fetch_array($consulta);
            $id = $linea["id_usuario"];
            $roles = $linea["rol"];
            $alias = $linea["alias"];
            $pass = $linea["password"];
            $email = $linea["correo"];

        ?>
    <body style="background-color: #173E59; text-align: center; color: #66B2D6;">
    <div style="float: left; width: 20%; height: 400px; background-color: #171A21; color: #B8B6B4;">
    <?php   if ($roles == "administrador"){
                echo "Panel de $roles<br>Has iniciado sesión como:<br>$alias";    //PANEL DEL ADMINISTRADOR
    ?>          
                <form method="post" action="gestionar_perfil.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar perfil">
                </form>
                <br>

                <form method="post" action="gestionar_usuarios.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar usuarios">
                </form>
                <br>

                <form method="post" action="gestionar_videojuegos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar videojuegos">
                </form>
                <br>
                
                <form method="post" action="gestionar_pedidos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar pedidos">
                </form>
                <br>

                <form method="post" action="gestionar_descuentos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar descuentos">
                </form>
                <br>

                <form method="post" action="index.php">
                    <input type="submit" value="Cerrar sesión">
                </form>
                <br> 
    <?php
            }
            else{
                echo "Panel de $roles<br>Has iniciado sesión como:<br>$alias";    //PANEL DEL USUARIO
    ?>          
                <form method="post" action="buscar_juegos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Buscar videojuegos">
                </form>
                <br>

                <form method="post" action="hacer_pedido.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Hacer pedido">
                </form>
                <br>

                <form method="post" action="gestionar_pedidos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar pedidos">
                </form>
                <br>

                <form method="post" action="biblioteca_juegos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Mi biblioteca de juegos">
                </form>
                <br>

                <form method="post" action="gestionar_perfil.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar perfil">
                </form>
                <br>

                <form method="post" action="gestionar_descuentos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar descuentos">
                </form>
                <br>

                <form method="post" action="index.php">
                    <input type="submit" value="Cerrar sesión">
                </form>
                <br>
        <?php
            }
        ?>
            </div>
    </body>
</html>