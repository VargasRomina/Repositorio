<?php
// editar_usuario.php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$error = '';
$usuario_id = $_GET['id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $rol = $_POST['rol'];

    if ($usuario_id && !empty($nombre) && !empty($dni)) {
        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET nombre = :nombre, dni = :dni, rol = :rol WHERE id = :id");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':id', $usuario_id);
            $stmt->execute();

            header("Location: ver_usuarios.php");
            exit();
        } catch (PDOException $e) {
            $error = "Error al actualizar el usuario: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}

// Obtener los datos del usuario a editar
if ($usuario_id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $usuario_id);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Error al obtener el usuario: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Editar Usuario</h2>

        <?php if (isset($error)): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <?php if ($usuario): ?>
            <form action="editar_usuario.php?id=<?= $usuario['id'] ?>" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" value="<?= htmlspecialchars($usuario['dni']) ?>" required>

                <label for="rol">Rol:</label>
                <select name="rol" id="rol" required>
                    <option value="empleado" <?= $usuario['rol'] == 'empleado' ? 'selected' : '' ?>>Empleado</option>
                    <option value="admin" <?= $usuario['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>

                <input type="submit" value="Actualizar Usuario">
            </form>
        <?php else: ?>
            <p>Usuario no encontrado.</p>
        <?php endif; ?>

        <p><a href="ver_usuarios.php">Volver a la lista de usuarios</a></p>
        <p><a href="logout.php">Cerrar sesión</a></p>
    </div>
</body>
</html>