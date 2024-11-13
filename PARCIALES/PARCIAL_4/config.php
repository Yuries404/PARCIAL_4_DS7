<?php
// Configuración de Google OAuth
define('CLIENT_ID', ''); 
define('CLIENT_SECRET', ''); 
define('REDIRECT_URI', 'http://localhost/PARCIALES/PARCIAL_4/callback.php'); 
// Configuración de API de Google Books
define('GOOGLE_API_KEY', '');

// Configuración de base de datos
define('DB_HOST', 'localhost');       // Servidor de base de datos
define('DB_NAME', 'biblioteca');      // Nombre de la base de dato
define('DB_USER', 'root');      
define('DB_PASS', '');   

// Conexión a la base de datos usando PDO
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
 
// Esta función intercambia el code por el token de acceso
function obtenerTokenDeGoogle($code) {
    $url = 'https://oauth2.googleapis.com/token';
    $data = [
        'code' => $code,
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'redirect_uri' => REDIRECT_URI,
        'grant_type' => 'authorization_code'
    ];
 
    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
 
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result, true);
 
    return $response['access_token'] ?? null;
}
 
// Esta función obtiene los datos del usuario usando el token de acceso
function obtenerDatosUsuarioGoogle($token) {
    $url = "https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token=$token";
    $result = file_get_contents($url);
    return json_decode($result, true);
}
?>
