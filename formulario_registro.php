<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si el usuario está logueado y es administrador
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");  // Redirigir si no está logueado o no es admin
    exit();
}

$error = '';
$exito = '';

// Procesar el formulario si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $dni = $_POST['dni'] ?? '';
    $rol = $_POST['rol'] ?? 'empleado'; // Por defecto, el rol es "empleado"

    if (!empty($nombre) && !empty($dni)) {
        try {
            // Insertar un nuevo usuario en la base de datos
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, dni, rol) VALUES (:nombre, :dni, :rol)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':rol', $rol);
            $stmt->execute();
            
            $exito = "Usuario registrado exitosamente.";
        } catch (PDOException $e) {
            $error = "Error al registrar el usuario: " . $e->getMessage();
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
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 2rem;
            text-align: center;
            color: #333;
        }
        label {
            font-size: 1.1rem;
            color: #555;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1.1rem;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        .error-message {
            color: red;
            font-size: 1.1rem;
        }
        .success-message {
            color: green;
            font-size: 1.1rem;
        }
        a {
            display: block;
            margin-top: 10px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registrar Usuario</h2>

        <!-- Mostrar mensaje de éxito o error si hay -->
        <?php if ($exito): ?>
            <p class="success-message"><?= $exito ?></p>
        <?php elseif ($error): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <!-- Formulario para registrar un nuevo usuario -->
        <form action="formulario_registros.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="empleado">Empleado</option>
                <option value="admin">Admin</option>
            </select>

            <input type="submit" class="btn" value="Registrar Usuario">
        </form>

        <a href="ver_usuarios.php">Volver a la lista de usuarios</a>
    </div>
</body>
</html>