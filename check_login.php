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
            <h3>Acceso</h3>
            <?php
            $alias_log = $_POST["alias"];
            $passw_log = $_POST["password"];

            $conexion = mysqli_connect("localhost", "root", "", "games4all")or die("Fallo al hacer la consulta");
            $consulta = mysqli_query($conexion, "SELECT * FROM usuario WHERE alias = '$alias_log' AND password = '$passw_log'");

            $nUsuarios = mysqli_num_rows($consulta);
            if ($nUsuarios > 0) {
                for ($i = 0; $i < $nUsuarios; $i++) {
                    $fila = mysqli_fetch_array($consulta);
                    if($fila['alias'] == $alias_log && $fila['password'] == $passw_log){
                        $alias = $fila['alias'];
                        $pass = $fila['password'];
                        $direccion = $fila['direccion'];
                        setcookie("alias", $alias, 0, "/");
                        setcookie("password", $pass, 0, "/");
                        ?><h4>¡Bienvenido <?php echo $alias; ?>, nos alegra verte de nuevo!</h4>
                        <br>
                        <h4>Serás redirigido automaticamente</h4>
                <?php
                        header("refresh:3;url=menus.php");
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