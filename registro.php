<?php
// Conexión a la base de datos
include 'conexion.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $dni = $_POST['dni'] ?? '';
    $confirmar_dni = $_POST['confirmar_dni'] ?? '';

    if (!empty($nombre) && !empty($dni) && !empty($confirmar_dni)) {
        // Verificar si las contraseñas coinciden
        if ($dni === $confirmar_dni) {
            try {
                // Verificar si el DNI ya existe
                $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE dni = :dni");
                $stmt->bindParam(':dni', $dni);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $error = "El DNI ya está registrado.";
                } else {
                    // Registrar el nuevo usuario
                    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, dni) VALUES (:nombre, :dni)");
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':dni', $dni);
                    $stmt->execute();

                    // Redirigir al login o página de rol
                    header("Location: login.php");
                    exit();
                }
            } catch (PDOException $e) {
                $error = "Error al registrar el usuario: " . $e->getMessage();
            }
        } else {
            $error = "Las contraseñas no coinciden.";
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
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>

        <!-- Mostrar mensaje de error si hay -->
        <?php if ($error): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <!-- Formulario de registro -->
        <form action="registro.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="dni">Contraseña (DNI):</label>
            <input type="text" id="dni" name="dni" required>

            <label for="confirmar_dni">Confirmar Contraseña (DNI):</label>
            <input type="text" id="confirmar_dni" name="confirmar_dni" required>

            <input type="submit" value="Registrar">
        </form>

        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>