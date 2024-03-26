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
    if (!isset($_COOKIE['rol'])) {
        header('Location: index.php');
        exit();
    }

    if ($_COOKIE['rol'] !== 'administrador') {
        header('Location: index.php');
        exit();
    }

    $alias = $_COOKIE['alias'];
    $rol = $_COOKIE['rol'];
        
    ?>
    <body style="background-color: #4CC5B0; text-align: center; color: #000000;">
        <div style="float: left; width: 20%; height: 350px;margin-top: -25px; background-color: #173E59; color: #ffffff;font-size: 25px;">
            <?php echo "Panel de $rol<br>Has iniciado sesión como:<br>$alias" ?>

            <form method="post" action="buscar_juegos.php?admin=admin">
                <input type="submit" value="Listar Juegos">
            </form>
            
            <form method="post" action="admin_introduce_juego.php">
                <input type="submit" value="Añadir Juego">
            </form>
        
            <form method="post" action="ver_eliminar_juegos.php">
                <input type="submit" value="Modificar o Eliminar Juegos">
            </form>
            
            <form method="post" action="menus.php">
                <input type="submit" value="Volver">
            </form>  

         </div>
    </body>
</html>