<?php
// Datos de conexión a la base de datos
$host = 'localhost';       // Dirección del servidor
$dbname = 'registro_ausencias';  // Nombre de la base de datos
$username = 'root';        // Nombre de usuario (en XAMPP es por defecto 'root')
$password = '';            // Contraseña (en XAMPP generalmente está vacía)

// Intentamos establecer la conexión con la base de datos
try {
    // Creación de la conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configuramos el PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Puedes descomentar la siguiente línea para verificar que la conexión fue exitosa
    // echo "Conexión exitosa a la base de datos!";
} catch (PDOException $e) {
    // Si hay un error de conexión, se muestra el mensaje de error
    die("Error de conexión: " . $e->getMessage());
}
?>