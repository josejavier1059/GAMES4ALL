<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>G4A</title>
        <div style="background-color: #173E59; text-align: center; color: #ffffff; padding: 30px;margin-top: -10px;margin-left: -10px;margin-right: -10px;margin-bottom: 100px;">
            <h1 style="font-family: 'Brush Script MT', cursive; font-size: 36px;">GAMES4ALL</h1>
            <h4 style="font-family: 'Brush Script MT', cursive; font-size: 20px;">¡Consigue tu juego preferido al mejor precio!</h4>
        </div>
    </head>

    <body style="background-color: #4CC5B0; text-align: center; color: #000000;">
        <form method="POST" action="check_login.php">
            <h3>Accede a tu cuenta</h3>
            <input type="text" name="alias" id="alias" placeholder="Nombre de usuario">
            <input type="password" name="passwrd" id="passwrd" placeholder="Contraseña">
            <input type="submit" placeholder="Acceder" value="Acceder">
        </form>
        <br>
        <form method="POST" action="index.php">
            <input type="submit" value="Volver">
        </form>
    </body>
</html>