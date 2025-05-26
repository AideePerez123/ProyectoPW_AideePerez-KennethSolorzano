<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $nit = $_POST['nit'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $telefono = $_POST['telefono'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $fecha_salida = $_POST['fecha_salida'];

    try {
        // Registrar cliente si no existe
        $stmt = $pdo->prepare("INSERT INTO cliente (nombre, NIT, fecha_nacimiento, telefono) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $nit, $fecha_nacimiento, $telefono]);
        $id_cliente = $pdo->lastInsertId();

        // Buscar habitación disponible
        $stmt = $pdo->prepare("SELECT id_habitacion FROM habitacion WHERE id_habitacion NOT IN (
            SELECT id_habitacion FROM reserva
            WHERE NOT (fecha_salida <= ? OR fecha_ingreso >= ?)
        ) LIMIT 1");

        $stmt->execute([$fecha_salida, $fecha_ingreso]);
        $habitacion = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$habitacion) {
            die("No hay habitaciones disponibles en esas fechas.");
        }

        $id_habitacion = $habitacion['id_habitacion'];
        $id_empleado = 1; // Asignar manualmente o desde sesión

        // Registrar reserva
        $stmt = $pdo->prepare("INSERT INTO reserva (fecha_ingreso, fecha_salida, estado, id_cliente, id_habitacion, id_empleado)
                               VALUES (?, ?, 'confirmada', ?, ?, ?)");
        $stmt->execute([$fecha_ingreso, $fecha_salida, $id_cliente, $id_habitacion, $id_empleado]);

        header("Location: ../reservas.php?id_reserva=" . $pdo->lastInsertId());
        exit;
    } catch (Exception $e) {
        die("Error al procesar la reserva: " . $e->getMessage());
    }
}
?>