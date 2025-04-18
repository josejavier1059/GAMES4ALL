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
        <div style="float: left; width: 60%; height: 800px;margin-top: -60px; background-color: #173E59; color: #ffffff;font-size: 25px;">
	<?php

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_juego = $_GET['id'];
    $id_usuario = $_COOKIE['id'];

    $conexion = new mysqli("localhost", "root", "", "games4all");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    if (!isset($_COOKIE['alias'])) {
        header('Location: index.php');
        exit();
    }

    $alias = $_COOKIE['alias'];
    $rol = $_COOKIE['rol'];
    


    $consultaSQL = "SELECT juego.id_juego, juego.plataforma, juego.titulo, juego.precio, juego.rebaja, juego.formato, juego.stock, info_juego.genero, info_juego.descripcion, ROUND(juego.precio - juego.precio * juego.rebaja / 100, 2) AS precio_rebajado, CONCAT('images/', info_juego.imagen) AS imagen FROM juego INNER JOIN info_juego ON juego.titulo = info_juego.titulo_juego WHERE id_juego = $id_juego"; 
    $resultado = mysqli_query($conexion, $consultaSQL);
    
    if(mysqli_num_rows($resultado) == 1) {
        $juego = mysqli_fetch_assoc($resultado);
            
        echo "<h1>".$juego['titulo']."</h1>
            <p>Plataforma: ".$juego['plataforma']."</p>
            <p>Precio: "; 
            if ($juego['rebaja'] > 0) {
                echo "<del>" . number_format($juego['precio'], 2, ',', '.') . "€</del>  " . str_repeat("&nbsp;", 1) . "-" . $juego['rebaja'] . "%". str_repeat("&nbsp;", 2);
            }
            echo number_format($juego['precio_rebajado'], 2, ',', '.') . "€</p>
            <p>Formato: ".($juego['formato'] == 0 ? "Físico" : "Digital")."</p>
            <p>Género: ".$juego['genero']."</p>
            <p>".$juego['descripcion']."</p>
            <img src='".$juego['imagen']."' style='width: 200px; height: 200px;'>";

        echo"<br><br>";

        $comprado = false;
        if($juego['formato'] == 1) {
            $consultaBiblioteca = "SELECT * FROM biblioteca WHERE id_usuario = $id_usuario AND id_juego = $id_juego";
            $resultadoBiblioteca = mysqli_query($conexion, $consultaBiblioteca);
            if(mysqli_num_rows($resultadoBiblioteca) > 0) { //si está en la biblioteca
                $comprado = true;
            }
        }

        $consultaSQL = "SELECT * FROM carrito WHERE id_usuario = $id_usuario AND id_juego = $id_juego";
        $resultado = mysqli_query($conexion, $consultaSQL);
    if($rol == "usuario"){
        if ($comprado) {
            echo "<p>Ya tienes este juego en tu biblioteca.</p>";
        } else {
            if(mysqli_num_rows($resultado) == 1) {
                echo "<form method='POST' action='quitar_carrito.php'>
                    <input type='hidden' name='id_juego' value='".$juego['id_juego']."'>
                    <input type='submit' value='Quitar del Carrito'>
                    </form>";
    
                    echo "<form method='POST' action='ver_carrito.php'>
                    <input type='submit' value='Acceder al Carrito'>
                    </form>";
            } else {
                if($juego['stock'] > 0){
                    echo "<form method='POST' action='añadir_carrito.php'>
                        <input type='hidden' name='id_juego' value='".$juego['id_juego']."'>
                        <input type='submit' value='Añadir al Carrito'>
                        </form>";
                } else {
                    echo "<p>Agotado temporalmente</p>";
                }
            }
        }
    }
        echo "<form method='POST' action='buscar_juegos.php'>
            <input type='submit' value='Volver'>
            </form>";

    } else {
        echo "El juego no existe.";
        header('Location: buscar_juegos.php');
        exit();
    }

    $conexion->close();
} else {
    echo "ID de juego inválido.";
    header('Location: buscar_juegos.php');
    exit();
}

?>
        </div>
    </body>
</html>