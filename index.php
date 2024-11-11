<?php
include 'conexion.php';

$error = '';

// Verificar si el formulario de inicio de sesión ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
    
    if (!empty($nombre) && !empty($dni)) {
        try {
            // Verifica que el nombre y el DNI existan en la base de datos
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nombre = :nombre AND dni = :dni");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':dni', $dni);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si el usuario existe, redirigir a la página de confirmación del DNI
            if ($user) {
                // Almacenamos el DNI del usuario para que se pueda confirmar
                session_start();
                $_SESSION['dni'] = $dni;  // Guardar el DNI en la sesión

                // Redirigimos al paso de confirmación del DNI
                header("Location: confirmar_dni.php");
                exit();
            } else {
                $error = "Nombre o DNI incorrectos.";
            }
        } catch (PDOException $e) {
            $error = "Error al verificar el usuario.";
        }
    } else {
        $error = "Por favor, ingrese su nombre y DNI.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="index.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" required>

            <input type="submit" value="Iniciar Sesión">
        </form>
        
        <?php if ($error): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>