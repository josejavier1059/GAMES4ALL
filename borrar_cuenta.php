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
    ?>
    <body style="background-color: #4CC5B0; text-align: center; color: #000000;">
        <div style="float: left; width: 20%; height: 450px;margin-top: -60px; background-color: #173E59; color: #ffffff;font-size: 25px;">
           <h4>BORRAR CUENTA</h4>
	                  
           <form method="post" action="confirmar_borrar_cuenta.php">
                ¿Seguro que deseas eliminar la cuenta de <?php echo $alias ?>?<br><br>
                Esto eliminara la información de tu usuario y tus tarjetas<br><br>
                <input type="submit" value="Borrar cuenta">
            </form>

            <form method="post" action="gestionar_perfil.php">
                <input type="submit" value="Volver">
            </form>

        </div>
    </body>
</html>