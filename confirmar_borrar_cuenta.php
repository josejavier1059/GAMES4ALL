<?php

    $conexion = mysqli_connect("localhost", "root", "", "games4all")or die("Fallo al hacer la consulta.");
    $alias = $_COOKIE['alias'];

    ?>

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
        <div style="float: left; width: 20%; height: 450px;margin-top: -60px; background-color: #173E59; color: #ffffff;font-size: 25px;">
           <h4>BORRAR CUENTA</h4>
	      
            <?php  
                if($conexion){    
                    if(mysqli_query($conexion, "DELETE FROM usuario WHERE alias = '$alias'")){

                        foreach ($_COOKIE as $key => $value) {
                            setcookie($key, '', time() - 3600, '/');
                        }
                        $_COOKIE = array();

                        echo '¡Usuario eliminado con éxito!';
                        header("refresh:3;url=index.php?logout=true");          
                    }
                    else{
                        echo 'Se ha producido un error, no se ha podido eliminar su cuenta.';
                        header("refresh:3;url=gestionar_perfil.php");  
                    }
                }    
            ?>          
            

        </div>
    </body>
</html>