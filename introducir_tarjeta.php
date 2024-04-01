<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>G4A</title>
    <link rel="stylesheet" href="estilos.css">
</head>
    
<body style="background: url('fondo1.png') no-repeat center center fixed; background-size: cover;margin-top: 200px;background-color: #4CC5B0; text-align: center; color: #000000;">
    <div style="background: url('fondo1.png') no-repeat center center fixed; background-size: cover;background-color: #4CC5B0; text-align: center; color: #000000;">
        <h1>Selecciona Tarjeta:</h1>

        <?php
        $conexion = new mysqli("localhost", "root", "", "games4all");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        if (!isset($_COOKIE["id"])) {
            header("Location: index.php");
            exit();
        }

        if (isset($_GET["error"])) {
            $error = $_GET["error"];
            if ($error == "FechaError") {
                echo "La tarjeta está caducada o la fecha no es válida.";
            }
            if ($error == "TarjeraNoCoincide") {
                echo "La tarjeta no coincide con la base de datos.";
            }
            if ($error == "SeleccionError") {
                echo "Error al seleccionar la tarjeta.";
            }
        }

        $id_usuario = $_COOKIE["id"];

        if (isset($_POST["seleccion_tarjeta"]) && $_POST["seleccion_tarjeta"] != "") {
            $id_tarjeta_seleccionada = $_POST["seleccion_tarjeta"];
            $sql_tarjeta = "SELECT * FROM tarjeta WHERE id_tarjeta = $id_tarjeta_seleccionada";
            $result_tarjeta = $conexion->query($sql_tarjeta);
            if ($result_tarjeta->num_rows != 1) {
                header("Location: introducir_tarjeta.php?error=SeleccionError");
                exit();
            }
            $tarjeta_seleccionada = $result_tarjeta->fetch_assoc();
            $numero_tarjeta_seleccionada = $tarjeta_seleccionada["numero"];
            $nombre_titular_seleccionado = $tarjeta_seleccionada["titular"];
            $fecha_expiracion_seleccionada = date("m/y", strtotime($tarjeta_seleccionada["caducidad"]));

        } 
        else if (isset($_POST["numero_tarjeta"]) && isset($_POST["nombre_titular"]) && isset($_POST["fecha_expiracion"]) && isset($_POST["cvv"])){
            $numero_tarjeta = $_POST["numero_tarjeta"];
            $nombre_titular = $_POST["nombre_titular"];
            $fecha_expiracion = $_POST["fecha_expiracion"];

            $fecha_expiracion = "20" . substr($fecha_expiracion, 3, 2) . "-" . substr($fecha_expiracion, 0, 2) . "-01";
            $fecha_actual = date("Y-m-d");
            
            if (strtotime($fecha_expiracion) < strtotime($fecha_actual)) {
                header("Location: introducir_tarjeta.php?error=FechaError");
                exit();
            }

            $sql_check = "SELECT * FROM tarjeta WHERE numero = '$numero_tarjeta'";
            $result = $conexion->query($sql_check);

            setcookie("numero_tarjeta", $numero_tarjeta, 0, "/");
            if ($result->num_rows > 0) {
                echo "La tarjeta ya existe en la base de datos.";
                $fila = $result->fetch_assoc();
                if ($fila["id_usuario"] == $id_usuario && $fila["titular"] == $nombre_titular && $fila["caducidad"] == $fecha_expiracion) {
                    header("Location: resumen_compra.php");
                    exit();
                } else {
                    header("Location: introducir_tarjeta.php?error=TarjeraNoCoincide");
                    exit();
                }
                

            } else {
                $sql_insert = "INSERT INTO tarjeta (numero, titular, caducidad, id_usuario) 
                            VALUES ('$numero_tarjeta', '$nombre_titular', '$fecha_expiracion', '$id_usuario')";
                
                if ($conexion->query($sql_insert) === TRUE) {
                    header("Location: resumen_compra.php");
                    exit();
                } else {
                    header("Location: introducir_tarjeta.php");
                    exit();
                }
            }
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Tus Tarjetas:
                <select name="seleccion_tarjeta">
                    <option value="">Núm. Tarjeta</option>
                    <?php
                    $sql_tarjetas_usuario = "SELECT * FROM tarjeta WHERE id_usuario = $id_usuario";
                    $result_tarjetas_usuario = $conexion->query($sql_tarjetas_usuario);
                    
                    if ($result_tarjetas_usuario && $result_tarjetas_usuario->num_rows > 0) {
                        while ($tarjeta = $result_tarjetas_usuario->fetch_assoc()) {
                            echo "<option value='" . $tarjeta["id_tarjeta"] . "'>" . rtrim(preg_replace('/\B(?=(\d{4})+(?!\d))/', ' ', $tarjeta['numero'])) . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No se encontraron tarjetas asociadas</option>";
                    }
                    ?>
                </select>
            <input type="submit" value="Seleccionar">
        </form>

        <br>
        <h2>O introduce una nueva tarjeta:</h2>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Número de Tarjeta (16 dígitos): <input type="text" name="numero_tarjeta" value="<?php echo isset($numero_tarjeta_seleccionada) ? $numero_tarjeta_seleccionada : ''; ?>" required pattern="\d{16}"><br><br>
            Nombre del Titular: <input type="text" name="nombre_titular" value="<?php echo isset($nombre_titular_seleccionado) ? $nombre_titular_seleccionado : ''; ?>" required><br><br>
            Fecha de Expiración(MM/YY): <input type="text" name="fecha_expiracion" value="<?php echo isset($fecha_expiracion_seleccionada) ? $fecha_expiracion_seleccionada : ''; ?>" placeholder="MM/YY" required pattern="\d{2}\/\d{2}"><br><br>
            CVV (3 dígitos): <input type="text" name="cvv" required pattern="\d{3}"><br><br>
            <input type="submit" value="Confirmar tarjeta">
        </form>

        <form action="ver_carrito.php" method="post">
            <input type="submit" value="Volver">
        </form>
    </div>
</body>
</html>
<?php $conexion->close(); ?>
