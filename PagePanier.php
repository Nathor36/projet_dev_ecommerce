<?php


session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
 }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier - E-commerce</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Mon Site E-commerce</h1>
        <nav>
            <a href="index.php">Accueil</a> |
            <a href="PagePanier.php">Panier (<?php echo count($_SESSION['panier']); ?>)</a>
        </nav>
    </header>
    <main>
        <h2>Votre panier</h2>
        <?php if (empty($_SESSION['panier'])): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($_SESSION['panier'] as $item): ?>
                    <li><?php echo htmlspecialchars($item); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Mon Site E-commerce</p>
    </footer>
</body>
</html>