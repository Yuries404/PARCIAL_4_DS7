<?php
require 'config.php';
include 'header.php';

    if (!empty($_GET['query'])) {
    $query = urlencode($_GET['query']);
    $apiKey = GOOGLE_API_KEY;  // Clave API
    $url = "https://www.googleapis.com/books/v1/volumes?q={$query}&key={$apiKey}";

    $response = file_get_contents(filename: $url);
    $data = json_decode($response, true);
   

    if (!empty($data['items'])) {
        echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;'>";

        foreach ($data['items'] as $book) {
            $titulo = $book['volumeInfo']['title'] ?? 'Sin título';
            $autor = $book['volumeInfo']['authors'][0] ?? 'Autor desconocido';
            $imagen = $book['volumeInfo']['imageLinks']['thumbnail'] ?? '';
            $google_books_id = $book['id'] ?? '';  // ID único de Google Books

            echo "<div style='background-color: #f4f4f9; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center;'>";
            if ($imagen) {
                echo "<img src='{$imagen}' alt='Portada' style='width: 100%; max-width: 150px; height: auto; border-radius: 5px; margin-bottom: 10px;'>";
            }
            echo "<h3 style='font-size: 1.2em; color: #333; margin-bottom: 5px;'>{$titulo}</h3>";
            echo "<p style='font-size: 1em; color: #555; margin: 0;'><strong>Autor:</strong> {$autor}</p>";

            // Formulario para enviar los datos a guardar.php mediante POST
            echo "<form action='guardar.php' method='post' style='margin-top: 15px;'>";
            echo "<input type='hidden' name='google_books_id' value='{$google_books_id}'>";
            echo "<input type='hidden' name='titulo' value='{$titulo}'>";
            echo "<input type='hidden' name='autor' value='{$autor}'>";
            echo "<input type='hidden' name='imagen_portada' value='{$imagen}'>";
            echo "<textarea name='reseña' placeholder='Escribe tu reseña...' style='width: 100%; padding: 10px; margin-top: 10px; border-radius: 5px; border: 1px solid #ccc; resize: none;'></textarea>";
            echo "<button type='submit' style='margin-top: 10px; padding: 10px 20px; background-color: #5cb85c; color: white; border: none; border-radius: 5px; cursor: pointer;'>Guardar en favoritos</button>";
            echo "</form>";

            echo "</div>";
        }

        echo "</div>";
    } else {
        echo "<p style='font-size: 1.2em; color: #666; text-align: center;'>No se encontraron resultados.</p>";
    }
}
 else {
    echo "Por favor ingresa un término de búsqueda.";
}
?>
