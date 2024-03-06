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
        <div style="float: center;">
            <h3>Registro de usuario</h3>

            <form method="POST" action="registro_usuario_confirmado.php" style="float: center;">
                Nombre de usuario:
                <input type="text" name="alias_target" id="alias_target" placeholder="Nombre de usuario" required>
                <br><br>
                Contraseña:
                <input type="password" name="pass_target" id="pass_target" placeholder="Contraseña" required>
                <br><br>
                Email:
                <input type="email" name="email_target" id="email_target" placeholder="Email" required>
                <br><br>
                <input type="submit" value="Confirmar">
            </form>
            </div>
    </body>
</html>