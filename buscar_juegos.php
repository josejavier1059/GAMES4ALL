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
            color: #000000; /* Cambiado a negro */
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
            background-color: #ffffff; /* Fondo blanco */
            opacity: 0.95; /* Ligeramente opaco para ver el fondo, pero asegurar legibilidad */
            box-shadow: 0 0 10px 0 rgba(0,0,0,0.5); /* Opcional: sombra para darle profundidad */
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
<body>
    <div id="header">
        <h1>GAMES4ALL</h1>
        <h4>¡Encuentra tu próximo juego favorito!</h4>
    </div>

    <form action="buscar_juegos.php" method="post">
        <input type="text" name="filtro" placeholder="Buscar por plataforma, título...">
        <input type="submit" value="Buscar">
    </form>

    <?php
    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "games4all") or die("Error al conectar a la base de datos.");

    $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

    $consultaSQL = "SELECT * FROM juegos WHERE plataforma LIKE '%$filtro%' OR titulo LIKE '%$filtro%' OR tipo LIKE '%$filtro%'";

    $resultado = mysqli_query($conexion, $consultaSQL);

    if(mysqli_num_rows($resultado) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Plataforma</th><th>Título</th><th>Precio</th><th>Rebaja</th><th>Stock</th><th>Tipo</th></tr>";
        while($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr><td>".$fila['id_juego']."</td><td>".$fila['plataforma']."</td><td>".$fila['titulo']."</td><td>".$fila['precio']."</td><td>".$fila['rebaja']."</td><td>".$fila['stock']."</td><td>".$fila['tipo']."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron juegos que coincidan con la búsqueda.";
    }

    mysqli_close($conexion);
    ?>
</body>
</html>
