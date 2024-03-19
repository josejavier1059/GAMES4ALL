<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>G4A</title>
    <style>
        body {
            background: url('fondo1.png') no-repeat center center fixed;
            background-size: contain;
            text-align: center;
            color: #4CC5B0; /* Color del texto en tu página */
            margin: 0; /* Elimina el margen predeterminado del cuerpo */

        }

        #header {
            background-color: #173E59;
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
</head>

<body style="background-color: #4CC5B0; text-align: center; color: #000000;">
    <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Consigue tu juego preferido al mejor precio!</h4>
    </div>

    <div>
        <h4>¡Bienvenido!</h4>
        <br>

        <?php
        if(isset($_GET["logout"]) && $_GET["logout"] === "true") {   //Con este bloque comprobamos si el usuario a cerrado sesion
            setcookie("alias", "", time() - 1, "/");                   // en caso que si, se eliminan las cookies estableciendo un 
            setcookie("password", "", time() - 1, "/");                // tiempo de expiracion negativo
            setcookie("id", $id, time() - 1, "/");
            setcookie("rol", $roles, time() - 1, "/");
            setcookie("correo", $email, time() - 1, "/");
                            
            exit();
        }

        /*
        // Eliminar todas las cookies establecidas a la vez
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-3600); // Establece la fecha de expiración en el pasado (elimina la cookie)
            }
        }

        */
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