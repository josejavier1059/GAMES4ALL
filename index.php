<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>G4A</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body style="background: url('fondo1.png') no-repeat center center fixed; background-size: cover;background-color: #4CC5B0; text-align: center; color: #000000;">
    <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Consigue tu juego preferido al mejor precio!</h4>
    </div>

    <div>
        <h4>¡Bienvenido!</h4>
        <br>

        <?php
        /*
        if(isset($_GET["logout"]) && $_GET["logout"] === "true") {     //Con este bloque comprobamos si el usuario a cerrado sesion
            setcookie("alias", "", time() - 1, "/");                   // en caso que si, se eliminan las cookies estableciendo un 
            setcookie("password", "", time() - 1, "/");                // tiempo de expiracion negativo
            setcookie("id", $id, time() - 1, "/");
            setcookie("rol", $roles, time() - 1, "/");
            setcookie("correo", $email, time() - 1, "/");
                            
            exit();
            
            $conexion->close();

        }
        */
        
        // Eliminar todas las cookies establecidas a la vez
        if(isset($_GET["logout"]) && $_GET["logout"] === "true") {      //Con este bloque comprobamos si el usuario a cerrado sesion
            if (isset($_SERVER['HTTP_COOKIE'])) {                       // en caso que si, se eliminan las cookies estableciendo un 
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);       // tiempo de expiracion negativo
                foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1,"/"); // Establece la fecha de expiración en el pasado (elimina la cookie)
                }
            }
            $conexion->close();
            exit();
        }
        $alias = $_COOKIE['alias'];
        echo "$alias";
        ?>
        <form method="POST" action="login.php">
            <input type="submit" name="Acceso" value="Acceso">
        </form>
        <br>
        <form method="POST" action="registro_usuario.php">
            <input type="submit" name="Registro" value="Registro">
        </form>
    </div>
</body>
</html>