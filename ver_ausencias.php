<?php
// ver_ausencias.php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener las ausencias del usuario
try {
    $stmt = $pdo->prepare("SELECT * FROM ausencias WHERE usuario_id = :usuario_id");
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->execute();
    $ausencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error al obtener las ausencias: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Mis Ausencias</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Mis Ausencias Registradas</h2>

        <?php if (isset($error)): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <?php if (!empty($ausencias)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ausencias as $ausencia): ?>
                        <tr>
                            <td><?= htmlspecialchars($ausencia['fecha_inicio']) ?></td>
                            <td><?= htmlspecialchars($ausencia['fecha_fin']) ?></td>
                            <td><?= htmlspecialchars($ausencia['motivo']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tienes ausencias registradas.</p>
        <?php endif; ?>

        <p><a href="registro_ausencia.php">Registrar otra ausencia</a></p>
        <p><a href="empleado.php">Volver al panel</a></p>
        <p><a href="logout.php">Cerrar sesión</a></p>
    </div>
</body>
</html>