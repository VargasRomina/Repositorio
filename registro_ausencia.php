<?php
// registro_ausencia.php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$error = '';
$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $motivo = $_POST['motivo'];

    if (!empty($fecha_inicio) && !empty($fecha_fin) && !empty($motivo)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO ausencias (usuario_id, fecha_inicio, fecha_fin, motivo) VALUES (:usuario_id, :fecha_inicio, :fecha_fin, :motivo)");
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);
            $stmt->bindParam(':motivo', $motivo);
            $stmt->execute();

            header("Location: ver_ausencias.php");
            exit();
        } catch (PDOException $e) {
            $error = "Error al registrar la ausencia: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Ausencia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Registrar Ausencia</h2>

        <?php if (isset($error)): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <form action="registro_ausencia.php" method="POST">
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

            <label for="motivo">Motivo:</label>
            <textarea id="motivo" name="motivo" required></textarea>

            <input type="submit" value="Registrar Ausencia">
        </form>

        <p><a href="ver_ausencias.php">Ver mis ausencias</a></p>
        <p><a href="empleado.php">Volver al panel</a></p>
        <p><a href="logout.php">Cerrar sesión</a></p>
    </div>
</body>
</html>