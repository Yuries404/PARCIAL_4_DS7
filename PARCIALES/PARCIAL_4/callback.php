 <?php
session_start();
require 'config.php';
require 'database.php'; //conexión a base de datos
 

if (isset($_GET['code'])) {
    
    $token = obtenerTokenDeGoogle($_GET['code']); 
 
    // Obtén los datos del perfil del usuario
    $user_info = obtenerDatosUsuarioGoogle($token); 
 
    
    if (isset($user_info['email'], $user_info['name'], $user_info['id'])) {
        $email = $user_info['email'];
        $nombre = $user_info['name'];
        $google_id = $user_info['id'];
 
        // Verificar si el usuario ya existe en la base de datos
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE google_id = ?");
        $stmt->execute([$google_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
 
        if (!$user) { // Si el usuario no existe, insertar en la base de datos
            $stmt = $pdo->prepare("INSERT INTO usuarios (email, nombre, google_id) VALUES (?, ?, ?)");
            $stmt->execute([$email, $nombre, $google_id]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
        } else {
            // Si el usuario ya existe, guardar su ID en la sesión
            $_SESSION['user_id'] = $user['id'];
        }
 
        // Redirigir a la biblioteca después de la autenticación
        header("Location: biblioteca.php");
        exit;
    } else {
        // Manejar el error si no se obtuvieron los datos del usuario de Google
        echo "Error al obtener datos del usuario de Google. Por favor, inténtalo de nuevo.";
    }
} else {
    echo "Código de autorización no recibido.";
}
?>