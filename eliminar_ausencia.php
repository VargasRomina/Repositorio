<?php
// eliminar_ausencia.php
include 'conexion.php';

session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");  // Redirigir si no es administrador
    exit();
}

// Obtener el ID de la ausencia a eliminar
$ausencia_id = $_GET['id'] ?? null;

if ($ausencia_id) {
    try {
        // Eliminar la ausencia de la base de datos
        $stmt = $pdo->prepare("DELETE FROM ausencias WHERE id = :id");
        $stmt->bindParam(':id', $ausencia_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirigir al panel de administración tras la eliminación
        header("Location: admin.php");
        exit();
    } catch (PDOException $e) {
        $error = "Error al eliminar la ausencia: " . $e->getMessage();
    }
} else {
    $error = "ID de ausencia no válido.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Ausencia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Eliminar Ausencia</h2>

        <?php if (isset($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <p><a href="admin.php">Volver al Panel de Administración</a></p>
    </div>
</body>
</html>