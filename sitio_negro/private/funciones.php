<?php
session_start();

// para verificar si el usuario está autenticado como empleado
function verificar_login() {
    if (!isset($_SESSION['id_empleado'])) {
        header('Location: ../login.php');
        exit;
    }
}


function conectar_db() {
    $host = 'localhost';
    $dbname = 'hotel_paraíso'; 
    $user = 'root';
    $pass = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

function calcular_dias_estadia($fecha_inicio, $fecha_fin) {
    $inicio = strtotime($fecha_inicio);
    $fin = strtotime($fecha_fin);
    $diferencia = $fin - $inicio;
    return round($diferencia / 86400); // 86400 segundos en un día
}

function validar_fecha($fecha) {
    $formato = 'Y-m-d';
    $dt = DateTime::createFromFormat($formato, $fecha);
    return $dt && $dt->format($formato) === $fecha;
}

// para verificar si la fecha de nacimiento no es futura
function validar_fecha_nacimiento($fecha_nacimiento) {
    if (!validar_fecha($fecha_nacimiento)) return false;

    $hoy = new DateTime();
    $nacimiento = new DateTime($fecha_nacimiento);

    return $nacimiento <= $hoy;
}

// para verificar si las fechas de ingreso y salida son coherentes
function validar_fechas_reserva($fecha_ingreso, $fecha_salida) {
    if (!validar_fecha($fecha_ingreso) || !validar_fecha($fecha_salida)) return false;

    $ingreso = new DateTime($fecha_ingreso);
    $salida = new DateTime($fecha_salida);

    return $ingreso < $salida;
}

// para verificar disponibilidad de habitación en fechas dadas
function habitacion_disponible($pdo, $id_habitacion, $fecha_ingreso, $fecha_salida) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM reserva 
                        WHERE id_habitacion = ? 
                        AND NOT (fecha_salida <= ? OR fecha_ingreso >= ?)");
    $stmt->execute([$id_habitacion, $fecha_salida, $fecha_ingreso]);
    return $stmt->fetchColumn() == 0;
}

// para obtener todas las habitaciones disponibles para ciertas fechas
function obtener_habitaciones_disponibles($pdo, $fecha_ingreso, $fecha_salida) {
    $stmt = $pdo->query("SELECT * FROM habitacion");
    $disponibles = [];

    while ($hab = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (habitacion_disponible($pdo, $hab['id_habitacion'], $fecha_ingreso, $fecha_salida)) {
            $disponibles[] = $hab;
        }
    }

    return $disponibles;
}

// para egistrar nueva reserva
function registrar_reserva($pdo, $id_cliente, $id_habitacion, $id_empleado, $fecha_ingreso, $fecha_salida) {
    $stmt = $pdo->prepare("INSERT INTO reserva (fecha_ingreso, fecha_salida, estado, id_cliente, id_habitacion, id_empleado)
                        VALUES (?, ?, 'confirmada', ?, ?, ?)");
    return $stmt->execute([$fecha_ingreso, $fecha_salida, $id_cliente, $id_habitacion, $id_empleado]);
}

// Registrar nuevo cliente
function registrar_cliente($pdo, $nombre, $nit, $fecha_nacimiento, $telefono) {
    $stmt = $pdo->prepare("INSERT INTO cliente (nombre, NIT, fecha_nacimiento, telefono)
                        VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $nit, $fecha_nacimiento, $telefono]);
    return $pdo->lastInsertId(); // devuelve el ID del cliente insertado
}

// para btener información de una reserva por ID
function obtener_reserva_por_id($pdo, $id_reserva) {
    $stmt = $pdo->prepare("SELECT r.*, c.nombre AS cliente_nombre, h.numero_habitacion, h.tipo
                        FROM reserva r
                        JOIN cliente c ON r.id_cliente = c.id_cliente
                        JOIN habitacion h ON r.id_habitacion = h.id_habitacion
                        WHERE r.id_reserva = ?");
    $stmt->execute([$id_reserva]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// actualizar estado de la reserva
function actualizar_estado_reserva($pdo, $id_reserva, $estado) {
    $stmt = $pdo->prepare("UPDATE reserva SET estado = ? WHERE id_reserva = ?");
    return $stmt->execute([$estado, $id_reserva]);
}
?>