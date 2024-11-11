<?php
// confirmar_dni.php
session_start();
include 'conexion.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'] ?? '';

    if (!empty($dni)) {
        try {
            // Verificar si el DNI existe en la base de datos
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE dni = :dni");
            $stmt->bindParam(':dni', $dni);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                // Si el DNI es válido, guarda el ID del usuario en la sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];

                // Redirigir al login o a la selección de rol
                header("Location: login.php");
                exit();
            } else {
                $error = "El DNI no está registrado.";
            }
        } catch (PDOException $e) {
            $error = "Error al verificar el DNI.";
        }
    } else {
        $error = "Por favor, ingrese su DNI.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar DNI</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Confirmar DNI</h2>
        <form action="confirmar_dni.php" method="POST">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" required>

            <input type="submit" value="Confirmar DNI">
        </form>

        <?php if ($error): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <p>¿No estás registrado? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>