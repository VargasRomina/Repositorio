<?php
// editar_ausencia.php
include 'conexion.php';

session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");  // Redirigir si no es administrador
    exit();
}

// Obtener el ID de la ausencia a editar
$ausencia_id = $_GET['id'] ?? null;

// Buscar la ausencia en la base de datos
if ($ausencia_id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM ausencias WHERE id = :id");
        $stmt->bindParam(':id', $ausencia_id, PDO::PARAM_INT);
        $stmt->execute();
        $ausencia = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ausencia) {
            $error = "Ausencia no encontrada.";
        }
    } catch (PDOException $e) {
        $error = "Error al obtener la ausencia: " . $e->getMessage();
    }
}

// Actualizar la ausencia en la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';
    $tipo_ausencia = $_POST['tipo_ausencia'] ?? '';
    $motivo = $_POST['motivo'] ?? '';

    try {
        $stmt = $pdo->prepare("UPDATE ausencias SET fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, tipo_ausencia = :tipo_ausencia, motivo = :motivo WHERE id = :id");
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':tipo_ausencia', $tipo_ausencia);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':id', $ausencia_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirigir al panel de administración tras la actualización
        header("Location: admin.php");
        exit();
    } catch (PDOException $e) {
        $error = "Error al actualizar la ausencia: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ausencia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Editar Ausencia</h2>

        <?php if (isset($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($ausencia): ?>
            <form action="editar_ausencia.php?id=<?= htmlspecialchars($ausencia_id) ?>" method="POST">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= htmlspecialchars($ausencia['fecha_inicio']) ?>" required>

                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="<?= htmlspecialchars($ausencia['fecha_fin']) ?>" required>

                <label for="tipo_ausencia">Tipo de Ausencia:</label>
                <input type="text" id="tipo_ausencia" name="tipo_ausencia" value="<?= htmlspecialchars($ausencia['tipo_ausencia']) ?>" required>

                <label for="motivo">Motivo:</label>
                <textarea id="motivo" name="motivo" required><?= htmlspecialchars($ausencia['motivo']) ?></textarea>

                <input type="submit" value="Actualizar Ausencia">
                </form>
        <?php else: ?>
            <p>No se encontró la ausencia especificada.</p>
        <?php endif; ?>

        <p><a href="admin.php">Volver al Panel de Administración</a></p>
    </div>
</body>
</html>