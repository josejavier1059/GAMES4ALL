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
        <div style="float: left; width: 20%; height: 350px;margin-top: -60px; background-color: #173E59; color: #ffffff;font-size: 25px;">

    <?php   if ($roles == "administrador"){
                echo "Panel de $roles<br>Has iniciado sesión como:<br>$alias";    //PANEL DEL ADMINISTRADOR
    ?>          
                <form method="post" action="gestionar_perfil.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar perfil">
                </form>
                

                <form method="post" action="gestionar_usuarios.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar usuarios">
                </form>
            

                <form method="post" action="gestionar_videojuegos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar videojuegos">
                </form>
                
                
                <form method="post" action="gestionar_pedidos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar pedidos">
                </form>
                

                <form method="post" action="gestionar_descuentos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar descuentos">
                </form>
                

                <form method="post" action="index.php">
                    <input type="submit" value="Cerrar sesión">
                </form>
                 
    <?php
            }
            else{
                echo "Panel de $roles<br>Has iniciado sesión como:<br>$alias";    //PANEL DEL USUARIO
    ?>          
                <form method="post" action="buscar_juegos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Buscar videojuegos">
                </form>
                

                <form method="post" action="hacer_pedido.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Hacer pedido">
                </form>
                

                <form method="post" action="gestionar_pedidos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar pedidos">
                </form>
                

                <form method="post" action="biblioteca_juegos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Mi biblioteca de juegos">
                </form>
            

                <form method="post" action="gestionar_perfil.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar perfil">
                </form>
                

                <form method="post" action="gestionar_descuentos.php">
                    <input type="hidden" name="alias" value=<?php echo $alias ?>>
                    <input type="submit" value="Gestionar descuentos">
                </form>
                

                <form method="post" action="index.php">
                    <input type="submit" value="Cerrar sesión">
                </form>
                
        <?php
            }
        ?>
            </div>
    </body>
</html>