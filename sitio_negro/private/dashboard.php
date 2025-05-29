<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Hotel El Paraíso</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="/public/estilos.css" rel="stylesheet">

    <style>
        body {
            background-color:rgb(14, 14, 14);
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #2a4c70;
        }

        .navbar-brand img {
            height: 40px;
        }

        .nav-link,
        .navbar-brand {
            color: white !important;
        }

        .room-card {
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 260px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            padding: 1rem;
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .room-available {
            background-color: #e6ffe6;
            border-left: 6px solid #28a745;
        }

        .room-occupied {
            background-color: #ffe6e6;
            border-left: 6px solid #dc3545;
        }

        .card-title {
            font-weight: bold;
            font-size: 1.3rem;
        }

        .footer {
            margin-top: 4rem;
            padding: 1rem 0;
            text-align: center;
            color: #777;
            font-size: 0.95rem;
            background-color: #e9ecef;
        }

        .btn-status {
            font-size: 0.85rem;
            padding: 0.3rem 0.6rem;
            cursor: default;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="../public/index.php">
            <img src="../imagenes/logo.png" alt="Logo Hotel El Paraíso" class="me-2">
            <span>Hotel El Paraíso</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/reservas.php">Reservas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h2 class="text-center mb-5 fw-bold text-dark">Estado de Habitaciones</h2>
    <div class="row g-4 justify-content-center">
        <?php
        $habitaciones = [
            ['id' => 1, 'estado' => 'ocupada', 'cliente' => 'Juan Pérez', 'total' => 1050.00],
            ['id' => 2, 'estado' => 'disponible', 'cliente' => '', 'total' => 0],
            ['id' => 3, 'estado' => 'ocupada', 'cliente' => 'María Gómez', 'total' => 800.00],
            ['id' => 4, 'estado' => 'disponible', 'cliente' => '', 'total' => 0],
            ['id' => 5, 'estado' => 'ocupada', 'cliente' => 'Carlos López', 'total' => 1200.00],
            ['id' => 6, 'estado' => 'disponible', 'cliente' => '', 'total' => 0],
            ['id' => 7, 'estado' => 'disponible', 'cliente' => '', 'total' => 0],
            ['id' => 8, 'estado' => 'ocupada', 'cliente' => 'Ana Martínez', 'total' => 950.00],
        ];

        foreach ($habitaciones as $hab): ?>
            <div class="col-md-6 col-lg-3">
                <div class="card room-card shadow-sm <?= $hab['estado'] === 'ocupada' ? 'room-occupied' : 'room-available'; ?>">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">Habitación <?= $hab['id']; ?></h5>
                            <span class="badge bg-<?= $hab['estado'] === 'ocupada' ? 'danger' : 'success'; ?> btn-status mb-3">
                                <?= $hab['estado'] === 'ocupada' ? 'Ocupada' : 'Disponible'; ?>
                            </span>
                            <?php if ($hab['estado'] === 'ocupada'): ?>
                                <p class="mb-1"><strong>Huésped:</strong><br><?= htmlspecialchars($hab['cliente']); ?></p>
                                <p><strong>Total:</strong> Q.<?= number_format($hab['total'], 2); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="footer">
    &copy; 2025 Hotel Vacacional El Paraíso 
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap @5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>