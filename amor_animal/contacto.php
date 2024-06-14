<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Amor Animal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./issets/css/contacto.css">
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


<div class="container mt-5 pt-5">
    <div class="text-center mb-4">
        <h2>Estamos aquí para ayudarte</h2>
        <p class="lead">En Amor Animal, nos apasiona encontrar hogares amorosos para todos los animales. Si tienes alguna pregunta, no dudes en contactarnos a través de cualquiera de los medios que se indican a continuación.</p>
    </div>

    <div class="row mb-5">
        <div class="col-md-6 mb-4">
            <div class="p-4 border rounded shadow-sm bg-white">
                <h4>Dónde encontrarnos</h4>
                <p><strong>Dirección:</strong> Calle de los Animales 123, Ciudad Animal, PA 45678</p>
                <p><strong>Teléfono:</strong> +34 123 456 789</p>
                <p><strong>Email:</strong> contacto@amoranimal.org</p>
                <iframe class="w-100 rounded" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3048.678845193725!2d-74.00597218461063!3d40.712775979330025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a316f6f4b11%3A0x7a13c01394b02ffb!2s123%20Calle%20de%20los%20Animales%2C%20Ciudad%20Animal%2C%20PA%2045678%2C%20USA!5e0!3m2!1sen!2ses!4v1607116792340!5m2!1sen!2ses" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col-md-6">
            <form action="contacto.php" method="POST" class="p-4 border rounded shadow-sm bg-white">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-warning btn-block">Enviar</button>
            </form>
        </div>
    </div>

    <div class="text-center mb-5">
        <h2 class="mb-4">Testimonios</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm bg-light">
                    <p>"Gracias a Amor Animal, encontré al compañero perfecto. El proceso de adopción fue rápido y sencillo."</p>
                    <p><strong>- María López</strong></p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm bg-light">
                    <p>"El equipo de Amor Animal es increíble. Se nota que realmente aman a los animales y se preocupan por su bienestar."</p>
                    <p><strong>- Juan Pérez</strong></p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm bg-light">
                    <p>"Adoptar a mi perro de Amor Animal fue una de las mejores decisiones que he tomado. ¡Gracias por todo lo que hacen!"</p>
                    <p><strong>- Laura Sánchez</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <div class="p-4 border rounded shadow-sm bg-white">
            <h4>DONA POR Y PARA ELLOS</h4>
            <p>Colabora con la alimentación y salud de nuestros peluditos. Serás de mucha ayuda para ellos.</p>
            <form action="newsletter.php" method="POST" class="form-inline justify-content-center">
                <div class="form-group mb-2 mr-2">
                    <input type="email" class="form-control" id="email-newsletter" name="email" placeholder="Introduce tu correo electrónico" required>
                </div>
                <button type="submit" class="btn btn-warning mb-2">Suscribirse</button>
            </form>
        </div>
    </div>
</div>

<footer class="bg-dark text-light py-3">
    <div class="container text-center">
        <p>&copy; 2024 Amor Animal. Todos los derechos reservados.</p>
        <p>Síguenos en:
            <a href="#" class="text-light">Facebook</a> |
            <a href="#" class="text-light">Twitter</a> |
            <a href="#" class="text-light">Instagram</a>
        </p>
    </div>
</footer>

</body>
</html>



