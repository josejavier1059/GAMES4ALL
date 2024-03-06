<!DOCTYPE html>
<html lang="es">
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
            background-color: #0CAFDC;
            color: #ffffff;
            padding: 30px;

        }
        #header h1 {
            font-family: 'Brush Script MT', cursive; font-size: 36px;
        }

        #header h4 {
            font-family: 'Brush Script MT', cursive; font-size: 20px;
        }

        #content {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Consigue tu juego preferido al mejor precio!</h4>
    </div>

    <div id="content">
        <br>
        <form method="POST" action="login.php">
            <input type="submit" name="Acceso" value="Acceso">
        </form>
        <br>
        <form method="POST" action="añadir_usuario.php">
            <input type="submit" name="Registro" value="Registro">
        </form>
    </div>
</body>
</html>