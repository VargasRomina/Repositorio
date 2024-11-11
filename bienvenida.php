<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['nombre'])) {
    // Si no está logueado, redirigir a la página de inicio de sesión
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="welcome-container">
        <div class="welcome-box">
            <h1>¡Bienvenido, <?php echo $_SESSION['nombre']; ?>!</h1>
            <p>Has iniciado sesión correctamente.</p>
            <p><a href="rol.php">Selecciona tu rol</a></p> <!-- Redirige a la página de selección de rol -->
        </div>
    </div>
</body>
</html>