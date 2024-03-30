<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_usuario'])){
        $id_usuario = $_POST['id_usuario'];
        $alias_user = $_POST['alias'];
        $password = $_POST['password_nueva'];
        $email = $_POST['correo'];
        $nombre = $_POST['nombre'];
        $pais = $_POST['pais'];
        $ciudad = $_POST['ciudad'];
        $direccion = $_POST['direccion'];
        $cod_postal = $_POST['cod_postal'];


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

        if ($rol !== 'administrador') {
            header('Location: index.php');
            exit();
        }

        $sql = "UPDATE usuario SET alias = '$alias_user', password = '$password', correo = '$email', nombre = '$nombre', pais = '$pais', ciudad = '$ciudad', direccion = '$direccion', cod_postal = '$cod_postal' WHERE id_usuario = $id_usuario";

        if ($conexion->query($sql) === TRUE) {
            header("Location: gestionar_usuarios.php");
            exit();
        } else {
            echo "Error al modificar el usuario: " . $conexion->error;
        }

        $conexion->close();
    } else {
        header("admin_edita_usuario.php");
        exit();
    }
} else {
    header("Location: admin_edita_usuario.php");
    exit();
}
?>