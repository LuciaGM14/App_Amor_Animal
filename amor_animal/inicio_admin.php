<?php
include 'conexion.php';

session_start();

if (!isset($_SESSION['nombreProtectora'])) {
    header("Location: login.php");
    exit();
}

$idProtectora = $_SESSION['idProtectora'];
$nombreProtectora = $_SESSION['nombreProtectora'];

$carpeta_uploads = 'uploads/';
if (!is_dir($carpeta_uploads)) {
    if (!mkdir($carpeta_uploads, 0777, true)) {
        die('Error al crear la carpeta uploads');
    }
}


function subirImagen($file) {
    if (isset($file) && $file['error'] == 0) {
        $targetDir = "uploads/"; 
        $targetFile = $targetDir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if ($file["tmp_name"] != "" && getimagesize($file["tmp_name"]) !== false) {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                return $targetFile;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false; 
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar_animal'])) {
    $idAnimal = $_POST['id_animal_modificar'];
    $nombre = $_POST['nombre_' . $idAnimal];
    $especie = $_POST['especie_' . $idAnimal];
    $genero = $_POST['genero_' . $idAnimal];
    $edad = isset($_POST['edad_' . $idAnimal]) ? $_POST['edad_' . $idAnimal] : 0;
    $raza = $_POST['raza_' . $idAnimal];

    $ruta_imagen_animal = subirImagen($_FILES['imagen_' . $idAnimal]);
    if ($ruta_imagen_animal) {
        $sql = "UPDATE Animales SET nombreAnimal='$nombre', especieAnimal='$especie', generoAnimal='$genero', edadAnimal='$edad', razaAnimal='$raza', ruta_imagen_animal='$ruta_imagen_animal' WHERE idAnimal='$idAnimal'";
    } else {
        $sql = "UPDATE Animales SET nombreAnimal='$nombre', especieAnimal='$especie', generoAnimal='$genero', edadAnimal='$edad', razaAnimal='$raza' WHERE idAnimal='$idAnimal'";
    }

    if ($conexion->query($sql) === TRUE) {
        echo "Animal actualizado correctamente.";
    } else {
        echo "Error al actualizar el animal: " . $conexion->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_animal'])) {
    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $genero = $_POST['genero'];
    $edad = !empty($_POST['edad']) ? $_POST['edad'] : 0;
    $raza = $_POST['raza'];

    $ruta_imagen_animal = subirImagen($_FILES['imagen']);

    if ($ruta_imagen_animal) {
        $result = $conexion->query("SELECT idAnimal FROM Animales WHERE nombreAnimal = '$nombre'");
        if ($result->num_rows > 0) {
            echo "Ya existe un animal con ese nombre.";
        } else {
            $sql = "INSERT INTO Animales (nombreAnimal, especieAnimal, generoAnimal, edadAnimal, razaAnimal, idProtectora, ruta_imagen_animal) 
                    VALUES ('$nombre', '$especie', '$genero', '$edad', '$raza', '$idProtectora', '$ruta_imagen_animal')";

            if ($conexion->query($sql) === TRUE) {
                echo "Animal agregado correctamente.";
            } else {
                echo "Error al agregar el animal: " . $conexion->error;
            }
        }
    } else {
        echo "Error al subir la imagen.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar_animal'])) {
    $idAnimal = $_POST['id_animal_modificar'];
    $nombre = $_POST['nombre_' . $idAnimal];
    $especie = $_POST['especie_' . $idAnimal];
    $genero = $_POST['genero_' . $idAnimal];
    $edad = isset($_POST['edad_' . $idAnimal]) ? $_POST['edad_' . $idAnimal] : 0;
    $raza = $_POST['raza_' . $idAnimal];

    $ruta_imagen_animal = subirImagen($_FILES['imagen_' . $idAnimal]);
    if ($ruta_imagen_animal) {
        $sql = "UPDATE Animales SET nombreAnimal='$nombre', especieAnimal='$especie', generoAnimal='$genero', edadAnimal='$edad', razaAnimal='$raza', ruta_imagen_animal='$ruta_imagen_animal' WHERE idAnimal='$idAnimal'";
    } else {
        $sql = "UPDATE Animales SET nombreAnimal='$nombre', especieAnimal='$especie', generoAnimal='$genero', edadAnimal='$edad', razaAnimal='$raza' WHERE idAnimal='$idAnimal'";
    }

    if ($conexion->query($sql) === TRUE) {
        echo "Animal actualizado correctamente.";
    } else {
        echo "Error al actualizar el animal: " . $conexion->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_animal'])) {
    $idAnimalEliminar = $_POST['id_animal_eliminar'];

    $sql = "DELETE FROM Animales WHERE idAnimal='$idAnimalEliminar'";

    if ($conexion->query($sql) === TRUE) {
        echo "Animal eliminado correctamente.";
    } else {
        echo "Error al eliminar el animal: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./issets/css/inicio_admin.css" />
    <style>
        .animal-thumbnail {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Panel de Administrador</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h4>Bienvenido, <?php echo $nombreProtectora; ?>!</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="accion" onclick="mostrarFormulario('formulario_nuevo')">
                Nuevo
            </div>
        </div>
        <div class="col-md-4">
            <div class="accion" onclick="mostrarFormulario('formulario_modificacion')">
                Modificación
            </div>
        </div>
        <div class="col-md-4">
            <div class="accion" onclick="mostrarFormulario('formulario_eliminacion')">
                Eliminación
            </div>
        </div>
    </div>

    <div id="formulario_nuevo" style="display: none;">
        <h2 class="mt-4">Nuevo Animal</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="especie" class="form-label">Especie:</label>
                <input type="text" class="form-control" id="especie" name="especie" required>
            </div>
            <div class="mb-3">
                <label for="genero" class="form-label">Género:</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="Macho">Macho</option>
                    <option value="Hembra">Hembra</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="edad" class="form-label">Edad:</label>
                <input type="number" class="form-control" id="edad" name="edad">
            </div>
            <div class="mb-3">
                <label for="raza" class="form-label">Raza:</label>
                <input type="text" class="form-control" id="raza" name="raza" required>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" id="imagen" name="imagen" required onchange="mostrarVistaPrevia(this)">
                <img id="vista_previa_imagen" src="#" alt="Vista previa de la imagen" class="animal-thumbnail" style="display:none;">
            </div>
            <button type="submit" class="btn btn-primary" name="agregar_animal">Agregar Animal</button>
        </form>
    </div>

    <div id="formulario_modificacion" style="display: none;">
        <h2 class="mt-4">Modificar Animales</h2>
        <?php
        $result = $conexion->query("SELECT idAnimal, nombreAnimal, especieAnimal, generoAnimal, edadAnimal, razaAnimal, ruta_imagen_animal FROM Animales WHERE idProtectora = '$idProtectora'");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="animal-form">
                    <h3 class="text-center"><?php echo $row['nombreAnimal']; ?></h3>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nombre_<?php echo $row['idAnimal']; ?>" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre_<?php echo $row['idAnimal']; ?>" name="nombre_<?php echo $row['idAnimal']; ?>" value="<?php echo $row['nombreAnimal']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="especie_<?php echo $row['idAnimal']; ?>" class="form-label">Especie:</label>
                            <input type="text" class="form-control" id="especie_<?php echo $row['idAnimal']; ?>" name="especie_<?php echo $row['idAnimal']; ?>" value="<?php echo $row['especieAnimal']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="genero_<?php echo $row['idAnimal']; ?>" class="form-label">Género:</label>
                            <select class="form-select" id="genero_<?php echo $row['idAnimal']; ?>" name="genero_<?php echo $row['idAnimal']; ?>" required>
                                <option value="Macho" <?php if ($row['generoAnimal'] == 'Macho') echo 'selected'; ?>>Macho</option>
                                <option value="Hembra" <?php if ($row['generoAnimal'] == 'Hembra') echo 'selected'; ?>>Hembra</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edad_<?php echo $row['idAnimal']; ?>" class="form-label">Edad:</label>
                            <input type="number" class="form-control" id="edad_<?php echo $row['idAnimal']; ?>" name="edad_<?php echo $row['idAnimal']; ?>" value="<?php echo $row['edadAnimal']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="raza_<?php echo $row['idAnimal']; ?>" class="form-label">Raza:</label>
                            <input type="text" class="form-control" id="raza_<?php echo $row['idAnimal']; ?>" name="raza_<?php echo $row['idAnimal']; ?>" value="<?php echo $row['razaAnimal']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagen_<?php echo $row['idAnimal']; ?>" class="form-label">Imagen:</label>
                            <input type="file" class="form-control" id="imagen_<?php echo $row['idAnimal']; ?>" name="imagen_<?php echo $row['idAnimal']; ?>" onchange="mostrarVistaPrevia(this, 'vista_previa_<?php echo $row['idAnimal']; ?>')">
                            <?php if ($row['ruta_imagen_animal']) { ?>
                                <p>Imagen actual: <a href="<?php echo $row['ruta_imagen_animal']; ?>" target="_blank">Ver imagen</a></p>
                                <img src="<?php echo $row['ruta_imagen_animal']; ?>" alt="Imagen actual" class="animal-thumbnail">
                            <?php } ?>
                            <img id="vista_previa_<?php echo $row['idAnimal']; ?>" src="#" alt="Vista previa de la imagen" class="animal-thumbnail" style="display:none;">
                        </div>
                        <input type="hidden" name="id_animal_modificar" value="<?php echo $row['idAnimal']; ?>">
                        <button type="submit" class="btn btn-primary" name="modificar_animal">Modificar Animal</button>
                    </form>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <div id="formulario_eliminacion" style="display: none;">
        <h2 class="mt-4">Eliminar Animal</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="id_animal_eliminar" class="form-label">Selecciona un animal para eliminar:</label>
                <select class="form-select" id="id_animal_eliminar" name="id_animal_eliminar" required>
                    <?php
                    $result = $conexion->query("SELECT idAnimal, nombreAnimal, especieAnimal, razaAnimal FROM Animales WHERE idProtectora = '$idProtectora'");
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['idAnimal'] . "'>" . $row['nombreAnimal'] . " - " . $row['especieAnimal'] . " - " . $row['razaAnimal'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger" name="eliminar_animal">Eliminar Animal</button>
        </form>
    </div>

    <div id="visualizar_animales" class="mt-5">
        <h2 class="mt-4">Todos los Animales</h2>
        <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="filtro_nombre" placeholder="Nombre">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="filtro_especie" placeholder="Especie">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="filtro_genero">
                        <option value="">Género</option>
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="filtro_raza" placeholder="Raza">
                </div>
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>

        <?php
        $query = "SELECT idAnimal, nombreAnimal, especieAnimal, generoAnimal, edadAnimal, razaAnimal, ruta_imagen_animal FROM Animales WHERE idProtectora = '$idProtectora'";

        if (isset($_GET['filtro_nombre']) && !empty($_GET['filtro_nombre'])) {
            $filtro_nombre = $_GET['filtro_nombre'];
            $query .= " AND nombreAnimal LIKE '%$filtro_nombre%'";
        }
        if (isset($_GET['filtro_especie']) && !empty($_GET['filtro_especie'])) {
            $filtro_especie = $_GET['filtro_especie'];
            $query .= " AND especieAnimal LIKE '%$filtro_especie%'";
        }
        if (isset($_GET['filtro_genero']) && !empty($_GET['filtro_genero'])) {
            $filtro_genero = $_GET['filtro_genero'];
            $query .= " AND generoAnimal = '$filtro_genero'";
        }
        if (isset($_GET['filtro_raza']) && !empty($_GET['filtro_raza'])) {
            $filtro_raza = $_GET['filtro_raza'];
            $query .= " AND razaAnimal LIKE '%$filtro_raza%'";
        }

        $result = $conexion->query($query);
        if ($result->num_rows > 0) {
            echo '<div class="row mt-4">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-3">';
                echo '<div class="card mb-4">';
                if ($row['ruta_imagen_animal']) {
                    echo '<img src="' . $row['ruta_imagen_animal'] . '" class="card-img-top animal-thumbnail" alt="' . $row['nombreAnimal'] . '">';
                }
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['nombreAnimal'] . '</h5>';
                echo '<p class="card-text"><strong>Especie:</strong> ' . $row['especieAnimal'] . '</p>';
                echo '<p class="card-text"><strong>Género:</strong> ' . $row['generoAnimal'] . '</p>';
                echo '<p class="card-text"><strong>Edad:</strong> ' . $row['edadAnimal'] . '</p>';
                echo '<p class="card-text"><strong>Raza:</strong> ' . $row['razaAnimal'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p class="mt-4">No se encontraron animales.</p>';
        }
        ?>
    </div>

</div>

<script>
    function mostrarFormulario(idFormulario) {
        var formularios = document.querySelectorAll('[id^="formulario"]');
        formularios.forEach(formulario => {
            formulario.style.display = "none";
        });
        var formularioMostrar = document.getElementById(idFormulario);
        formularioMostrar.style.display = "block";
    }

    function mostrarVistaPrevia(input, idVistaPrevia = 'vista_previa_imagen') {
        var vistaPrevia = document.getElementById(idVistaPrevia);
        var reader = new FileReader();

        reader.onload = function(e) {
            vistaPrevia.src = e.target.result;
            vistaPrevia.style.display = "block";
        }

        reader.readAsDataURL(input.files[0]);
    }
</script>
</body>
</html>