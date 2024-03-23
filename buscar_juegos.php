<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Buscar Juegos - G4A</title>
    <style>
        body {
            background: url('fondo.png') no-repeat center center fixed;
            background-size: contain;
            text-align: center;
            color: #000000; 
            margin: 0;
        }

        #header {
            background-color: #173E59;
            text-align: center;
            color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
        }

        table {
            margin: auto;
            width: 80%;
            border-collapse: collapse;
            background-color: #ffffff;
            opacity: 0.95; 
            box-shadow: 0 0 10px 0 rgba(0,0,0,0.5); 
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {background-color: #f5f5f5;}

        form {
            margin: 20px;
        }

        input[type="text"], select {
            padding: 10px;
            margin: 5px;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body style="background-color: #4CC5B0; color: #000000;">
    <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Encuentra tu próximo juego favorito!</h4>
        
    </div>
    
    <div>
        <form method="POST" action="menus.php">
            <input type="submit" value="Volver">
        </form>
    </div>

    <form action="buscar_juegos.php" method="post">
        <input type="text" name="filtro" placeholder="Buscar por plataforma, título...">
        <input type="text" name="genero" placeholder="Buscar por género...">
        <input type="submit" value="Buscar">
    </form>

    <?php
    $conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

    $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';
    $genero = isset($_POST['genero']) ? $_POST['genero'] : '';

    $consultaSQL = "SELECT juego.id_juego, juego.plataforma, juego.titulo, juego.precio, juego.rebaja, juego.stock, juego.formato, info_juego.genero, info_juego.descripcion, ROUND(juego.precio - juego.precio * juego.rebaja / 100, 2) AS precio_rebajado FROM juego INNER JOIN info_juego ON juego.titulo = info_juego.titulo_juego WHERE (juego.plataforma LIKE '%$filtro%' OR juego.titulo LIKE '%$filtro%') AND info_juego.genero LIKE '%$genero%'";

    $resultado = mysqli_query($conexion, $consultaSQL);
    echo "<div style='overflow-y:auto; height: 300px; background-color: #ffffff; opacity: 0.95; box-shadow: 0 0 10px 0 rgba(0,0,0,0.5); padding: 0; margin: 0;'>";
    if(mysqli_num_rows($resultado) > 0) {
        echo "<table style='width:100%; border-collapse: collapse;'>";
        echo "<tr>
            <th>Plataforma</th>
            <th>Título</th>
            <th>Género</th>
            <th>Precio</th>
            <th>Rebaja</th>
            <th>Unidades</th>
            <th>Formato</th>
        </tr>";
        while($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
                <td>".$fila['plataforma']."</td>
                <td>".$fila['titulo']."</td>
                <td>".$fila['genero']."</td>
                <td>".$fila['precio_rebajado']."€</td>
                <td>".$fila['rebaja']."%</td>
                <td>".$fila['stock']."</td>
                <td>";echo $fila['formato'] == 0 ? "Físico" : "Digital";"</td>
            </tr>";
        }
        echo "</table></div>";
    } else {
        echo "No se encontraron juegos que coincidan con la búsqueda.";
    }

    mysqli_close($conexion);
    ?>
</body>
</html>
