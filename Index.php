<?php
session_start();
include 'includes/card.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Haapple Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
    <div class="logo">Haapple Store</div>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="produits.php">Produits</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['username']) && $_SESSION['username'] !== ""): ?>
                <li><a href="logout.php">Se déconnecter</a></li>
            <?php else: ?>
                <li><a href="connexion.php">Se connecter</a></li>
            <?php endif; ?>
            <li><a href="PagePanier.php"><i class="fas fa-shopping-cart"></i></a></li>
        </ul>
    </nav>
</header>

<!-- Message de bienvenue -->
<main>
    <h1>Haapple Store</h1>

    <?php
    if (isset($_SESSION['username']) && $_SESSION['username'] !== "") {
        $user = htmlspecialchars($_SESSION['username']);
        echo "<p>Bonjour <strong>$user</strong>, vous êtes connecté.</p>";
    } else {
        echo "<p>Vous n'êtes pas connecté.</p>";
    }
    ?>

    <div class="images-container">
        <img src="images/logo.png" alt="logo du site" class="logo-image">
    </div>
</main>

</body>
</html>
