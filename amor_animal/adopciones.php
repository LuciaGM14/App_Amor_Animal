<?php
session_start();

include 'conexion.php';

$sql_razas = "SELECT especieAnimal, razaAnimal FROM Animales";
$resultado_razas = $conexion->query($sql_razas);
$razas = [];
if ($resultado_razas) {
    while ($row = $resultado_razas->fetch_assoc()) {
        $razas[$row['especieAnimal']][] = $row['razaAnimal'];
    }
}

$sql_especies = "SELECT DISTINCT especieAnimal FROM Animales";
$resultado_especies = $conexion->query($sql_especies);
$especies = [];
if ($resultado_especies) {
    while ($row = $resultado_especies->fetch_assoc()) {
        $especies[] = $row['especieAnimal'];
    }
}

$filtro_especie = isset($_GET['especie']) ? $_GET['especie'] : '';
$filtro_raza = isset($_GET['raza']) ? $_GET['raza'] : '';
$filtro_edad = isset($_GET['edad']) ? $_GET['edad'] : '';
$filtro_genero = isset($_GET['genero']) ? $_GET['genero'] : '';

$sql_adopciones = "SELECT idAnimal, nombreAnimal, generoAnimal, edadAnimal, razaAnimal, ruta_imagen_animal FROM Animales WHERE 1=1";

if ($filtro_especie != '') {
    $sql_adopciones .= " AND especieAnimal LIKE '%" . $conexion->real_escape_string($filtro_especie) . "%'";
}
if ($filtro_raza != '') {
    $sql_adopciones .= " AND razaAnimal LIKE '%" . $conexion->real_escape_string($filtro_raza) . "%'";
}
if ($filtro_edad != '') {
    $sql_adopciones .= " AND edadAnimal = " . intval($filtro_edad);
}
if ($filtro_genero != '') {
    $sql_adopciones .= " AND generoAnimal LIKE '%" . $conexion->real_escape_string($filtro_genero) . "%'";
}

$resultado_adopciones = $conexion->query($sql_adopciones);

if ($resultado_adopciones) {
    $adopciones = $resultado_adopciones->fetch_all(MYSQLI_ASSOC);
} else {
    $adopciones = [];
    echo "Error en la consulta: " . $conexion->error;
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Adopciones</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./issets/css/adopciones.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const razas = <?php echo json_encode($razas); ?>;
            const especieSelect = document.getElementById("especie");
            const razaSelect = document.getElementById("raza");

            especieSelect.addEventListener("change", function() {
                const especie = this.value;
                razaSelect.innerHTML = '<option value="">Seleccione</option>';

                if (especie && razas[especie]) {
                    razas[especie].forEach(function(raza) {
                        const option = document.createElement("option");
                        option.value = raza;
                        option.text = raza;
                        razaSelect.appendChild(option);
                    });
                }
            });

            especieSelect.dispatchEvent(new Event('change'));
        });
    </script>
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


<div class="container mt-5 py-5">
    <div class="row">
        <aside class="col-lg-2 d-none d-lg-block mb-4">
            <form method="GET" action="adopciones.php" class="p-3 border rounded bg-light">
                <div class="form-group mb-3">
                    <label for="especie">Especie</label>
                    <select name="especie" id="especie" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach ($especies as $especie): ?>
                            <option value="<?php echo htmlspecialchars($especie); ?>" <?php if ($filtro_especie == $especie) echo 'selected'; ?>><?php echo htmlspecialchars($especie); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="raza">Raza</label>
                    <select name="raza" id="raza" class="form-control">
                        <option value="">Seleccione</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="edad">Edad</label>
                    <input type="number" name="edad" id="edad" class="form-control" value="<?php echo htmlspecialchars($filtro_edad); ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="genero">Género</label>
                    <select name="genero" id="genero" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Macho" <?php if ($filtro_genero == 'Macho') echo 'selected'; ?>>Macho</option>
                        <option value="Hembra" <?php if ($filtro_genero == 'Hembra') echo 'selected'; ?>>Hembra</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2">Aplicar filtros</button>
            </form>
        </aside>
        
        <div class="col-md-12 d- d-lg-none mb-4">
            <button class="btn btn-primary w-100" type="button" data-toggle="collapse" data-target="#collapseFiltros" aria-expanded="false" aria-controls="collapseFiltros">
                Filtros
            </button>
            <div class="collapse" id="collapseFiltros">
                <div class="card card-body">
                    <form method="GET" action="adopciones.php">
                        <div class="form-group mb-3">
                            <label for="especie">Especie</label>
                            <select name="especie" id="especie" class="form-control">
                                <option value="">Seleccione</option>
                                <?php foreach ($especies as $especie): ?>
                                    <option value="<?php echo htmlspecialchars($especie); ?>" <?php if ($filtro_especie == $especie) echo 'selected'; ?>><?php echo htmlspecialchars($especie); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="raza">Raza</label>
                            <select name="raza" id="raza" class="form-control">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edad">Edad</label>
                            <input type="number" name="edad" id="edad" class="form-control" value="<?php echo htmlspecialchars($filtro_edad); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="genero">Género</label>
                            <select name="genero" id="genero" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Macho" <?php if ($filtro_genero == 'Macho') echo 'selected'; ?>>Macho</option>
                                <option value="Hembra" <?php if ($filtro_genero == 'Hembra') echo 'selected'; ?>>Hembra</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Aplicar filtros</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-10 col-md-12">
            <div class="row">
                <?php if (!empty($adopciones)): ?>
                    <?php foreach ($adopciones as $adopcion): ?>
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm" style="width: 100%;">
                                <img src="<?php echo htmlspecialchars($adopcion['ruta_imagen_animal']); ?>" class="card-img-top img-fluid" alt="Imagen de <?php echo htmlspecialchars($adopcion['nombreAnimal']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($adopcion['nombreAnimal']); ?></h5>
                                    <p class="card-text">Género: <?php echo htmlspecialchars($adopcion['generoAnimal']); ?></p>
                                    <p class="card-text">Edad: <?php echo htmlspecialchars($adopcion['edadAnimal']); ?> años</p>
                                    <p class="card-text">Raza: <?php echo htmlspecialchars($adopcion['razaAnimal']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            No hay animales disponibles para adopción.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>


