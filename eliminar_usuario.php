<?php
// Incluir archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si el usuario está logueado como admin
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");  // Redirigir si no está logueado
    exit();
}

// Verificar si se ha pasado un ID de usuario
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    try {
        // Eliminar todas las ausencias asociadas a este usuario
        $stmt = $pdo->prepare("DELETE FROM ausencias WHERE usuario_id = :usuario_id");
        $stmt->bindParam(':usuario_id', $id_usuario);
        $stmt->execute();

        // Ahora eliminar el usuario
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id_usuario);
        $stmt->execute();

        // Redirigir a la lista de usuarios después de eliminar
        header("Location: ver_usuarios.php");
        exit();
    } catch (PDOException $e) {
        $error = "Error al eliminar el usuario: " . $e->getMessage();
    }
} else {
    $error = "No se ha proporcionado un ID de usuario válido.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Eliminar Usuario</h2>

        <!-- Mostrar mensaje de error si hay -->
        <?php if (isset($error)): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <p><a href="ver_usuarios.php">Volver a la lista de usuarios</a></p>
        <p><a href="logout.php">Cerrar sesión</a></p>
    </div>
</body>
</html>