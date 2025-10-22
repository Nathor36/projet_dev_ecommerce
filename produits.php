<!DOCTYPE html>
<?php 
session_start(); // On démarre la session PHP  

require_once 'connexion_bdd.php';  // fichier de connexion et il contien la variable $pdo
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Produits</title>

    <link rel="stylesheet" href="produit.css">  <!--relie le ficher css avec se fichier (si quelqu'un lit sa fais un style stp sinon je vais passer ma nuit BOBBY -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">     <!-- Azouz se lien c'est pour ton panier de mort et le relier au site (oui celui-ci) -->
</head>
<body>
    <!-- c'est a partir de la c'est le haut du site -->
    <header class="navbar">

        <div class="logo">Haapple Store</div> <!-- sa c'est pour que le nom du site soit a gauche -->

        <!-- début de la nav bar ON TOUCHE PAS A SA C'EST FINI (sauf dans la page panier) -->
        <nav>
            <ul>
                <!-- la c'est la nav bar sa permet de relier les ficher au autre (c'est logique faut juste lire)-->
                <li><a href="index.php">Accueil</a></li>
                <li><a href="produits.php" class="active">Produits</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="connexion.php">Se connecter</a></li>
                <li><a href="PagePanier.php"><i class="fas fa-shopping-cart"></i></a></li> <!-- un peu compliquer a écrire mais simple a comprendre c'est pour le que sa aille chercher dans le lien tu peux pas le louper en gros pour le petit logo de panier -->
            </ul>
        </nav>
    </header>

    <!-- la c'est la que les vrais chose commence c'est juste en dessuis de la nav bar  -->

    <h1>Nos Produits</h1>

        <footer>
        <!-- inchalla sa marche c'est les futur boutton pour trié -->
        <button class='btn-filtre'>Smartphone</button>
        <button class='btn-filtre'>Ordinateur</button>
        <button class='btn-filtre'>Accessoire</button>
        <button class='btn-filtre'>Tablette</button>
    
        </footer>
    <?php
    //la c'est le début pour afficher les produit qui sont dans la base de donné 

    // la c'est la première étape et on prépare la requête SQL pour aller chercher tout nos produits dans la table du même nom
    $tproduit = "SELECT * FROM produits"; 

    // la c'est la deuxième étape on éxecute la requête sql donc le $tproduit dans la base de donné $pdo et cette requete elle a pour nom bas = $requete
    $requete = $pdo->query($tproduit); 

    // la déreniére étape on récuper tout les résultat donc de la requete "SELECT * FROM produits" mais sous la forme d'un tableau 
    $articles = $requete->fetchAll(PDO::FETCH_ASSOC);  
    ?>

    <!-- *************** AFFICHAGE DES PRODUITS *************** -->
    <section class="produits">
        <!-- On parcourt le tableau $articles, chaque élément correspond à un produit -->
        <?php foreach($articles as $article): ?>
            
            <!-- Bloc HTML représentant un seul produit -->
            <article class="produit"> 
                
                <!-- Si une image existe pour le produit -->
                <?php if (!empty($article['image'])): ?>
                    
                    <!-- On affiche l’image du produit (dossier images/) -->
                    <img src="images/<?php echo htmlspecialchars($article['image']); ?>" 
                         alt="<?php echo htmlspecialchars($article['nom']); ?>" 
                         class="image-produit">
                
                <?php else: ?>
                    <!-- Sinon, on affiche une image par défaut -->
                    <img src="images/placeholder.png" alt="Image non disponible" class="image-produit">
                <?php endif; ?>

                <!-- Nom du produit -->
                <h2><?php echo htmlspecialchars($article["nom"]); ?></h2>

                <!-- Description du produit (si elle existe) -->
                <?php if (!empty($article["description"])): ?>
                    <p class="description"><?php echo htmlspecialchars($article["description"]); ?></p>
                <?php endif; ?>

                <!-- Prix du produit (si défini) -->
                <?php if (isset($article["prix"])): ?>
                    <!-- number_format formate le nombre avec 2 décimales et des séparateurs français -->
                    <p class="prix"><?php echo number_format($article["prix"], 2, ',', ' '); ?> €</p>
                <?php endif; ?>

                <!-- Bouton pour ajouter le produit au panier -->
                <button class="btn-acheter">Ajouter au panier</button>
            </article>

        <?php endforeach; ?>
    </section>

</body>
</html>
