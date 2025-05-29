<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$imagePath = __DIR__ . '/imagenes/fondo.png';
if (file_exists($imagePath)) {
    echo "<!-- Debug: fondo.png exists -->";
} else {
    echo "<!-- Debug: fondo.png does NOT exist at $imagePath -->";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"  rel="stylesheet">
    <link href="public/css/estilos.css" rel="stylesheet">
</head>
<body style="background-color: #1e1e1e; color: #e6e6e6;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="imagenes/logo.png" alt="Logo Hotel El Paraíso" class="me-2" style="height: 40px;">
                <span>Hotel El Paraíso</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="public/login.php">Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero text-center d-flex align-items-center justify-content-center py-5" style="background: url(imagenes/fondo.png) no-repeat center center / cover; height: 400px;">
        <div>
            <h1>Bienvenidos a Hotel El Paraíso</h1>
            <p>Un lugar ideal para personas de la tercera edad</p>
        </div>
    </div>

    <!-- Reserva Pública -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Realiza tu Reserva</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-custom shadow-sm">
                    <div class="card-body">
                        <form id="reservationForm" action="public/confirmar_reserva.php" method="GET" onsubmit="return validateForm(event)">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control bg-secondary text-white" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="nit" class="form-label">NIT</label>
                                <input type="text" class="form-control bg-secondary text-white" id="nit" name="nit" required>
                            </div>
                            <div class="mb-3">
                                <label for="birthDate" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control bg-secondary text-white" id="birthDate" name="birthDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="checkIn" class="form-label">Fecha de Ingreso</label>
                                <input type="date" class="form-control bg-secondary text-white" id="checkIn" name="checkIn" required>
                            </div>
                            <div class="mb-3">
                                <label for="checkOut" class="form-label">Fecha de Salida</label>
                                <input type="date" class="form-control bg-secondary text-white" id="checkOut" name="checkOut" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Reservar</button>
                        </form>
                        <div id="availability" class="mt-3 text-center"></div>
                        <div id="dateError" class="mt-2 text-center text-danger"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="room-preview text-center p-4 rounded">
                    <h3>Nuestras Habitaciones</h3>
                    <p>Diseñadas para ofrecer comodidad incluso en la oscuridad.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
    <script>
        function validateForm(event) {
            const birthDate = new Date(document.getElementById("birthDate").value);
            const checkIn = new Date(document.getElementById("checkIn").value);
            const checkOut = new Date(document.getElementById("checkOut").value);
            const dateError = document.getElementById("dateError");
            dateError.textContent = "";

            if (checkIn >= checkOut) {
                dateError.textContent = "La fecha de salida debe ser mayor a la de ingreso.";
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>
</body>
</html>