<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
$imagePath = __DIR__ . '/../imagenes/fondo.png';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../estilos.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../imagenes/logo.png" alt="Hotel El Paraíso" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#reserve">Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="public/login.php">Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero text-center d-flex align-items-center justify-content-center">
        <div>
            <h1>Bienvenidos a Hotel El Paraíso</h1>
            <p>Un lugar ideal para personas de la tercera edad</p>
        </div>
    </div>

    <div class="container my-5" id="reserve">
        <h2 class="text-center mb-4">Realiza tu Reserva</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-body">
                        <form id="reservationForm" action="public/confirmar_reserva.php" method="GET" onsubmit="return validateForm(event)">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="nit" class="form-label">NIT</label>
                                <input type="text" class="form-control" id="nit" name="nit" required>
                            </div>
                            <div class="mb-3">
                                <label for="birthDate" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control date-input" id="birthDate" name="birthDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="checkIn" class="form-label">Fecha de Ingreso</label>
                                <input type="date" class="form-control date-input" id="checkIn" name="checkIn" required>
                            </div>
                            <div class="mb-3">
                                <label for="checkOut" class="form-label">Fecha de Salida</label>
                                <input type="date" class="form-control date-input" id="checkOut" name="checkOut" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Reservar</button>
                        </form>
                        <div id="availability" class="mt-3 text-center"></div>
                        <div id="dateError" class="mt-2 text-center text-danger"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="room-preview text-center">
                    <h3 class="text-white">Nuestras Habitaciones</h3>
                    <p class="text-white">Disfrute de nuestras cómodas habitaciones dobles, diseñadas para su descanso.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>