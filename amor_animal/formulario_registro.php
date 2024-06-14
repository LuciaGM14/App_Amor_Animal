<?php
include 'conexion.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreProtectora = $_POST['nombre_protectora'];
    $telefonoProtectora = $_POST['telefono_protectora'];
    $ciudadProtectora = $_POST['ciudad_protectora'];
    $paisProtectora = $_POST['pais_protectora'];
    $claveProtectora = hash('sha256', $_POST['clave_protectora']); 

    $queryProtectora = "INSERT INTO Protectoras (nombreProtectora, claveProtectora, telefonoProtectora, ciudadProtectora, paisProtectora) 
                        VALUES (?, ?, ?, ?, ?)";
    $stmtProtectora = $conexion->prepare($queryProtectora);
    $stmtProtectora->bind_param("ssiss", $nombreProtectora, $claveProtectora, $telefonoProtectora, $ciudadProtectora, $paisProtectora);

    if ($stmtProtectora->execute()) {
        $msg = "Registro de protectora exitoso.";
    } else {
        $msg = "Error al registrar la protectora.";
    }

    $stmtProtectora->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Protectora - Adopciones Animales</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./issets/css/formulario_registro.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <div class="container text-center">
        <a class="navbar-brand mx-auto" href="./index.html">
            <img src="./issets/imagenes/icono.jpg" class="img-fluid logo-img logo-sm" alt="" />
            AMOR ANIMAL
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse  justify-content-end text-center" id="navbarNav">
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


<div class="container-fluid mt-5 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4">Registro de Protectora</h2>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                            <label for="nombre_protectora">Nombre de la Protectora</label>
                            <input type="text" class="form-control" name="nombre_protectora" required>
                        </div>

                        <div class="form-group">
                            <label for="clave_protectora">Clave de la Protectora</label>
                            <input type="password" class="form-control" name="clave_protectora" required>
                        </div>

                        <div class="form-group">
                            <label for="telefono_protectora">Teléfono de la Protectora</label>
                            <input type="tel" class="form-control" name="telefono_protectora" required>
                        </div>

                        <div class="form-group">
                            <label for="ciudad_protectora">Ciudad de la Protectora</label>
                            <input type="text" class="form-control" name="ciudad_protectora" required>
                        </div>

                        <div class="form-group">
                            <label for="pais_protectora">País de la Protectora</label>
                            <input type="text" class="form-control" name="pais_protectora" required>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                        </div>
                    </form>
                    <?php if ($msg): ?>
                        <div class="alert alert-<?php echo strpos($msg, 'exitoso') !== false ? 'success' : 'danger'; ?>" role="alert">
                            <?php echo $msg; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>





