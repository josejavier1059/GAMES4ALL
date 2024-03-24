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
        $alias = $_COOKIE['alias'];

        $conexion = mysqli_connect("localhost", "root", "", "games4all")or die("Fallo al hacer la consulta.");
        $consulta = mysqli_query($conexion, "SELECT * FROM usuario WHERE alias = '$alias'");

        $linea = mysqli_fetch_array($consulta);           
        $id = $linea["id_usuario"];
        $roles = $linea["rol"];
        $alias = $linea["alias"];
        $pass = $linea["password"];
        $email = $linea["correo"];

        setcookie("id", $id, 0, "/");
        setcookie("rol", $roles, 0, "/");
        setcookie("correo", $email, 0, "/");
        
    ?>
    <body style="background-color: #4CC5B0; text-align: center; color: #000000;">
        <div style="float: left; width: 20%; height: 350px;margin-top: -60px; background-color: #173E59; color: #ffffff;font-size: 25px;">

    <?php   if ($roles == "administrador"){
                echo "Panel de $roles<br>Has iniciado sesión como:<br>$alias";    //PANEL DEL ADMINISTRADOR
    ?>          
                <form method="post" action="buscar_juegos.php">
                    <input type="submit" value="Listar Juegos">
                </form>
                

                <form method="post" action="admin_introduce_juego.php">
                    <input type="submit" value="Añadir Juego">
                </form>
            

                <form method="post" action="ver_eliminar_juegos.php">
                    <input type="submit" value="Modificar o Eliminar Juegos">
                </form>
                
                
               

                
    <?php
    }
    ?>
   
         </div>
    </body>
</html>