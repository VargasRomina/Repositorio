<?php
// admin.php
session_start();

// Verificar si el usuario está logueado y es un administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php"); // Redirigir al login si no está logueado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenido, <?= $_SESSION['nombre'] ?> (Administrador)</h2>

        <p><a href="ver_usuarios.php">Ver Usuarios Registrados</a></p>
        <p><a href="ver_ausencias.php">Ver Todas las Ausencias</a></p>
        <p><a href="logout.php">Cerrar Sesión</a></p>
    </div>
</body>
</html>