<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombreProtectora']) && isset($_POST['claveProtectora'])) {
    $nombreProtectora = $_POST['nombreProtectora'];
    $claveProtectora = hash('sha256', $_POST['claveProtectora']);

    if (isset($conexion) && $conexion) {
        $sql = "SELECT idProtectora, claveProtectora FROM Protectoras WHERE nombreProtectora = ? AND claveProtectora = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $nombreProtectora, $claveProtectora);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                session_start();
                $_SESSION['idProtectora'] = $row['idProtectora'];
                $_SESSION['nombreProtectora'] = $nombreProtectora;
                header("Location: inicio_admin.php");
                exit();
            } else {
                $error_message = "Credenciales incorrectas.";
            }
        } else {
            $error_message = "Error en la consulta: " . $conexion->error;
        }
    } else {
        $error_message = "Error de conexión a la base de datos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./issets/css/login.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand text-dark" href="./index.html">
                <img src="./issets/imagenes/icono.jpg" class="img-fluid logo-img logo-sm" alt="" />
                AMOR ANIMAL
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end text-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active text-dark" href="./index.html">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="./adopciones.php">ADOPCIONES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="./formulario_registro.php">REGISTRARSE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="./login.php">LOGIN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="contacto.php">CONTACTO</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 90vh;">
    <div class="card p-4" style="width: 500px;">
        <div class="text-center mb-4">
            <h1 class="card-title mt-2"><img src="./issets/imagenes/icono.jpg" alt="" class="logo" width="50">AMOR ANIMAL</h1>
        </div>
        <h2 class="text-center">Iniciar Sesión</h2>
        <p class="text-center">Inicia sesión identifícandose con nombre de la protectora y su contraseña.</p>
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <input type="text" class="form-control form-control-lg" id="nombreProtectora" name="nombreProtectora" placeholder="Nombre de la protectora" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control form-control-lg" id="claveProtectora" name="claveProtectora" placeholder="Contraseña" required>
            </div>
            <button id="custom-btn" type="submit" class="btn btn-block btn-success btn-lg">Iniciar Sesión</button>
        </form>
    </div>
</div>

</body>

</html>
