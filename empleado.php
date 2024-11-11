<?php
// empleado.php
session_start();

// Verificar si el usuario está logueado y es un empleado
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'empleado') {
    header("Location: login.php"); // Redirigir al login si no está logueado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Empleado</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenido, <?= $_SESSION['nombre'] ?> (Empleado)</h2>

        <p><a href="registro_ausencia.php">Registrar Ausencia</a></p>
        <p><a href="ver_ausencias.php">Ver Mis Ausencias</a></p>
        <p><a href="logout.php">Cerrar Sesión</a></p>
    </div>
</body>
</html>