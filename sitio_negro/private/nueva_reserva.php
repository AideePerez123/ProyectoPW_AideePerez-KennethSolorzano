<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../public/login.php');
    exit;
}

include 'config.php';

$id_habitacion = isset($_GET['habitacion']) ? intval($_GET['habitacion']) : 0;

// Validar que la habitación exista
$stmt = $pdo->prepare("SELECT * FROM habitacion WHERE id_habitacion = ?");
$stmt->execute([$id_habitacion]);
$habitacion = $stmt->fetch();

if (!$habitacion) {
    die("Habitación no encontrada.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Habitación <?= $habitacion['numero_habitacion']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">Asignar Habitación <?= htmlspecialchars($habitacion['numero_habitacion']); ?></h2>

        <form action="guardar_reserva.php" method="POST">
            <input type="hidden" name="id_habitacion" value="<?= $id_habitacion; ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Huésped</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="mb-3">
                <label for="nit" class="form-label">NIT</label>
                <input type="text" class="form-control" id="nit" name="nit" required>
            </div>

            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" required>
            </div>

            <div class="mb-3">
                <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
            </div>

            <div class="mb-3">
                <label for="fecha_salida" class="form-label">Fecha de Salida</label>
                <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" required>
            </div>

            <button type="submit" class="btn btn-success">Guardar Reserva</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>