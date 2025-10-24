<?php
session_start();
require_once 'connexion_bdd.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Haapple Store</title>
    <link rel="stylesheet" href="style_Page_de_connexion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">Haapple Store</div>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="produits.php">Produits</a></li>
                <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><span>Bonjour, <?= htmlspecialchars($_SESSION['prenom']) ?></span></li>
                <li><a href="deconnexion.php">Se déconnecter</a></li>
            <?php else: ?>
                <li><a href="connexion.php">Se connecter</a></li>
            <?php endif; ?>
                <li><a href="PagePanier.php"><i class="fas fa-shopping-cart"></i></a></li>
            </ul>
        </nav>
    </header>

    <!-- Formulaire -->
    <div id="container">
        <form action="verification.php" method="POST">
            <h1>Connexion</h1>

            <label for="username"><b>Adresse Mail</b></label>
            <input type="text" placeholder="Entrer votre adresse mail" id="username" name="username" required>

            <label for="password"><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer le mot de passe" id="password" name="password" required>
            <a href="inscription.php" class="inscription">Créer un compte</a>
            <input type="submit" value="Connexion">

            <?php
            if(isset($_GET['erreur'])){
                $err = intval($_GET['erreur']);
                if($err === 1 || $err === 2){
                    echo "<p class='error'>Mail ou mot de passe incorrect</p>";
                }
            }
            ?>
        </form>
    </div>

</body>
</html>
