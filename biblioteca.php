<?php
$conexion = new mysqli("localhost", "root", "", "games4all");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (!isset($_COOKIE["id"])) {
    die("Error: No se encontró el ID de usuario.");
}

$id_usuario = $_COOKIE["id"];

$sql_biblioteca = "SELECT biblioteca.clave, juego.titulo, CONCAT('images/', info_juego.imagen) AS imagen, juego.plataforma
                   FROM biblioteca 
                   INNER JOIN juego ON biblioteca.id_juego = juego.id_juego 
                   INNER JOIN info_juego ON juego.titulo = info_juego.titulo_juego
                   WHERE biblioteca.id_usuario = $id_usuario";;
$resultado = $conexion->query($sql_biblioteca);

echo "<h1 style='text-align: center;'>Biblioteca</h1>";

if(mysqli_num_rows($resultado) > 0) {
    echo "<div style='margin: 0 auto; width: 80%; text-align: center;'>";
    echo "<table style='border-collapse: collapse; margin: 0 auto;'>";
    echo "<tr>
        <th></th>
        <th>Juego</th>
        <th>Plataforma</th>
        <th>Clave</th>
    </tr>";
    while($fila = mysqli_fetch_assoc($resultado)) {
        $clave = rtrim(chunk_split($fila["clave"], 4, "-"),"-");
        echo "<tr>
            <td><img src='".$fila['imagen']."' style='width: 50px; height: 50px;'></td>
            <td>".$fila['titulo']."</a></td>
            <td>".$fila['plataforma']."</td>
            <td>".$clave."</td>
        </tr>";
    }
    echo "</table></div>";
} else {
    echo "<p style='text-align: center;'>Aún no has comprado ningún juego digital</p>";
}

echo "<div style='text-align: center; margin-top: 20px;'>
        <a href='menus.php' style='text-decoration: none; padding: 10px 20px; background-color: #007bff; color: white; border-radius: 5px;'>Volver al Menú</a>
      </div>";

$conexion->close();
?>
