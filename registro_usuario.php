<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>G4A</title>
    <style>
        body {
            background: url('fondo.png') no-repeat center center fixed;
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