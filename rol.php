<?php
// rol.php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redirigir al login si no está logueado
    exit();
}

$error = '';

// Procesar la selección del rol
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rol = $_POST['rol'] ?? '';

    if ($rol) {
        // Guardar el rol en la sesión
        $_SESSION['rol'] = $rol;

        // Redirigir según el rol seleccionado
        if ($rol == 'admin') {
            header("Location: admin.php"); // Panel del administrador
        } else {
            header("Location: empleado.php"); // Panel del empleado
        }
        exit();
    } else {
        $error = "Por favor, selecciona un rol.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Rol</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Selecciona tu Rol</h2>
        <form action="rol.php" method="POST">
            <label for="rol">Rol:</label>
            <select name="rol" id="rol">
                <option value="empleado">Empleado</option>
                <option value="admin">Administrador</option>
            </select>
            <input type="submit" value="Seleccionar Rol">
        </form>

        <?php if ($error): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>
    </div>
</body>
</html>