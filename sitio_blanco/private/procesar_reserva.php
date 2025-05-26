<?php
header('Content-Type: application/json');
include 'config.php';
include '../private/funciones.php'; // Incluir funciones para validar y registrar

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Leer datos JSON enviados por fetch
        $input = json_decode(file_get_contents('php://input'), true);
        $nombre = $input['name'] ?? '';
        $nit = $input['nit'] ?? '';
        $fecha_nacimiento = $input['birthDate'] ?? '';
        $telefono = $input['telefono'] ?? '1234567890'; // Valor por defecto, ajusta según sea necesario
        $fecha_ingreso = $input['checkIn'] ?? '';
        $fecha_salida = $input['checkOut'] ?? '';

        if (empty($nombre) || empty($nit) || empty($fecha_ingreso) || empty($fecha_salida)) {
            throw new Exception("Faltan datos requeridos.");
        }

        // Validar fechas (usando funciones de funciones.php)
        if (!validar_fecha($fecha_nacimiento) || !validar_fecha_nacimiento($fecha_nacimiento) || !validar_fechas_reserva($fecha_ingreso, $fecha_salida)) {
            throw new Exception("Fechas inválidas.");
        }

        // Conectar a la base de datos
        $pdo = conectar_db();

        // Registrar cliente
        $id_cliente = registrar_cliente($pdo, $nombre, $nit, $fecha_nacimiento, $telefono);

        // Obtener empleado de la sesión
        $id_empleado = $_SESSION['id_empleado'] ?? 1; // Usar el empleado autenticado

        // Buscar habitación disponible (usando la lógica existente)
        $stmt = $pdo->prepare("SELECT id_habitacion FROM habitacion WHERE id_habitacion NOT IN (
            SELECT id_habitacion FROM reserva
            WHERE NOT (fecha_salida <= ? OR fecha_ingreso >= ?)
        ) LIMIT 1");
        $stmt->execute([$fecha_salida, $fecha_ingreso]);
        $habitacion = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$habitacion) {
            throw new Exception("No hay habitaciones disponibles en esas fechas.");
        }

        $id_habitacion = $habitacion['id_habitacion'];

        // Registrar reserva
        registrar_reserva($pdo, $id_cliente, $id_habitacion, $id_empleado, $fecha_ingreso, $fecha_salida);

        // Devolver respuesta JSON
        echo json_encode([
            'success' => true,
            'message' => 'Reserva procesada exitosamente.',
            'room' => "Habitación " . $id_habitacion,
            'id_reserva' => $pdo->lastInsertId()
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}
?>