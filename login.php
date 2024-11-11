<?php
// login.php
include 'conexion.php';

$error = ''; // Variable para mostrar mensajes de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $dni = $_POST['dni'] ?? '';
    
    if (!empty($nombre) && !empty($dni)) {
        try {
            // Verificar el usuario en la base de datos con nombre y DNI
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nombre = :nombre AND dni = :dni");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':dni', $dni);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Si el usuario es válido, redirigir a rol.php para seleccionar rol
                session_start();
                $_SESSION['usuario_id'] = $user['id'];  // Guarda el ID del usuario
                $_SESSION['nombre'] = $user['nombre'];  // Guarda el nombre del usuario
                header("Location: rol.php"); // Redirige a la página de selección de rol
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
        <form action="login.php" method="POST">
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