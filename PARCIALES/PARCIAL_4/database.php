<?php
// Configuración de la base de datos 
require_once 'config.php';

try {
    // Conexión a la base de datos usando PDO
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, 
        DB_USER, 
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Maneja errores de forma adecuada
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Establece el modo de obtención de datos
            PDO::ATTR_EMULATE_PREPARES => false,  // Mejora la seguridad
        ]
    );
} catch (PDOException $e) {
    // En caso de error, muestra un mensaje y termina la ejecución
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
