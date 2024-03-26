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
                Nombre Completo: 
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" required>
                <br><br><br>
                <input type="submit" value="Confirmar">
            </form>
            <br>
            <form method="POST" action="index.php">
            <input type="submit" value="Volver">
            </form>
            </div>
    </body>
</html>