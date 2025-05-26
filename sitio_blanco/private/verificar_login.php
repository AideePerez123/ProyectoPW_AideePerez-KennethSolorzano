<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consultar al empleado por su usuario
    $stmt = $pdo->prepare("SELECT * FROM empleado WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($empleado && password_verify($contrasena, $empleado['contrasena'])) {
        // Iniciar sesión
        $_SESSION['logged_in'] = true;
        $_SESSION['id_empleado'] = $empleado['id_empleado'];
        $_SESSION['nombre_empleado'] = $empleado['nombre'] ?? 'Empleado';

        // Redirigir al dashboard
        header('Location: dashboard.php');
        exit;
    } else {
        echo "<div class='alert alert-danger text-center'>Usuario o contraseña incorrectos.</div>";
        echo "<p><a href='../login.php' class='btn btn-secondary'>Volver a intentar</a></p>";
    }
}
?>