<?php
session_start();
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'N/A';
$nit = isset($_GET['nit']) ? htmlspecialchars($_GET['nit']) : 'N/A';
$birthDate = isset($_GET['birthDate']) ? htmlspecialchars($_GET['birthDate']) : 'N/A';
$checkIn = isset($_GET['checkIn']) ? htmlspecialchars($_GET['checkIn']) : 'N/A';
$checkOut = isset($_GET['checkOut']) ? htmlspecialchars($_GET['checkOut']) : 'N/A';
$days = (strtotime($checkOut) - strtotime($checkIn)) / (60 * 60 * 24);
$totalCost = $days * 350.00;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva - Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/estilos.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="../imagenes/logo.png" alt="Hotel El Paraíso" style="height: 40px;">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#reserve">Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="text-center mb-4">Confirmación de Reserva</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card confirmation-card">
                    <div class="card-body">
                        <h3 class="text-center">¡Reserva Confirmada!</h3>
                        <p><strong>Nombre:</strong> <?php echo $name; ?></p>
                        <p><strong>NIT:</strong> <?php echo $nit; ?></p>
                        <p><strong>Fecha de Nacimiento:</strong> <?php echo $birthDate; ?></p>
                        <p><strong>Fecha de Ingreso:</strong> <?php echo $checkIn; ?></p>
                        <p><strong>Fecha de Salida:</strong> <?php echo $checkOut; ?></p>
                        <p><strong>Total a Pagar:</strong> Q. <?php echo number_format($totalCost, 2); ?></p>
                        <p class="text-center">Gracias por elegir Hotel El Paraíso. ¡Esperamos su visita!</p>
                        <a href="../index.php" class="btn btn-primary w-100">Volver al Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>