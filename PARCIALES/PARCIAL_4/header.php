<?php
$pageTitle = basename($_SERVER['PHP_SELF']) == 'biblioteca.php' ? 'Mi Biblioteca' : 'Buscar Libros';
?>
<div class="container">

<header>
<link rel="stylesheet" href="style.css">


    <div class="header-left">
        <h2><?php echo $pageTitle; ?></h2>
        <?php if ($pageTitle !== 'Mi Biblioteca'): ?>
            <a href="biblioteca.php" class="home-link">Volver a Biblioteca</a>
        <?php endif; ?>
    </div>

    <div class="header-center">
        <form class="search-bar" method="get" action="buscar.php">
            <input type="text" name="query" placeholder="Buscar libros...">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <div class="header-right">
        <a href="logout.php" class="logout-btn">Cerrar sesión</a>
    </div>
    
</header>
</div>
