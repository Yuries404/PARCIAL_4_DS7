<?php
session_start();
require 'config.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Verifica que los datos necesarios se hayan enviado
if (isset($_POST['google_books_id'], $_POST['titulo'], $_POST['autor'])) {
    $user_id = $_SESSION['user_id'];
    $google_books_id = $_POST['google_books_id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $imagen_portada = $_POST['imagen_portada'] ?? '';
    $reseña = $_POST['reseña'] ?? ''; 

    // Inserta el libro en la tabla libros_guardados
    $stmt = $pdo->prepare("INSERT INTO libros_guardados (user_id, google_books_id, titulo, autor, imagen_portada, reseña_personal) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $google_books_id, $titulo, $autor, $imagen_portada, $reseña]);

    header("Location: biblioteca.php");
    exit;
} else {
    echo "Faltan datos para guardar el libro.";
}
?>
