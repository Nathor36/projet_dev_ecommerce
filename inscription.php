<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Haapple Store</title>
    <link rel="stylesheet" href="style_Page_de_connexion.css">
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
                <li><a href="connexion.php">Se connecter</a></li>
                <li><a href="PagePanier.php"><i class="fas fa-shopping-cart"></i></a></li>
            </ul>
        </nav>
    </header>

    <!-- Formulaire -->
    <div id="container">
        <form action="traitement_inscription.php" method="POST">
            <h1>Créer un compte</h1>

            <label for="nom"><b>Nom</b></label>
            <input type="text" id="nom" name="nom" placeholder="Votre nom" required>

            <label for="prenom"><b>Prénom</b></label>
            <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>

            <label for="email"><b>Email</b></label>
            <input type="email" id="email" name="email" placeholder="Votre email" required>

            <label for="password"><b>Mot de passe</b></label>
            <input type="password" id="password" name="password" placeholder="Créer un mot de passe" required>

            <label for="password_confirm"><b>Confirmez le mot de passe</b></label>
            <input type="password" id="password_confirm" name="password_confirm" placeholder="Confirmez le mot de passe" required>

            <input type="submit" value="S'inscrire">

            <?php
            if (isset($_GET['erreur'])) {
                $err = intval($_GET['erreur']);
                if ($err === 1) echo "<p class='error'>Les mots de passe ne correspondent pas.</p>";
                if ($err === 2) echo "<p class='error'>Cet email est déjà utilisé.</p>";
                if ($err === 3) echo "<p class='error'>Erreur interne, veuillez réessayer.</p>";
            }
            ?>
        </form>
    </div>

</body>
</html>
