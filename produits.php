<!DOCTYPE html>
<?php 
session_start(); // On démarre la session PHP  

require_once 'connexion_bdd.php';  // fichier de connexion et il contien la variable $pdo
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Produits</title>

    <link rel="stylesheet" href="style.css">  <!--relie le ficher css avec se fichier (si quelqu'un lit sa fais un style stp sinon je vais passer ma nuit BOBBY -->

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
         
        <form method="get" style="display:inline;">
        <input type="hidden" name="categorie" value="">
        <button type="submit" class="btn-filtre">Afficher tout les Produits</button>
    </form>          
        
        <form method="get" style="display:inline;">
        <input type="hidden" name="categorie" value="Smartphone">
        <button type="submit" class="btn-filtre">Smartphone</button>
    </form>

    <form method="get" style="display:inline;">
        <input type="hidden" name="categorie" value="Ordinateur">
        <button type="submit" class="btn-filtre">Ordinateur</button>
    </form>

    <form method="get" style="display:inline;">
        <input type="hidden" name="categorie" value="Accessoire">
        <button type="submit" class="btn-filtre">Accessoire</button>
    </form>

    <form method="get" style="display:inline;">
        <input type="hidden" name="categorie" value="Tablette">
        <button type="submit" class="btn-filtre">Tablette</button>
    </form>


</footer>

<?php
// Récupérer le nom de la catégorie depuis un paramètre GET ou POST
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';

// Préparer la requête avec JOIN pour filtrer par nom de catégorie
$stmt = $pdo->prepare("
    SELECT p.* 
    FROM produits p
    INNER JOIN categories c ON p.id_categorie = c.id_categorie
    WHERE c.nom = :categorie    
");

// Exécuter la requête en liant le paramètre
$stmt->execute(['categorie' => $categorie]);

// Récupérer tous les produits
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afficher les produits
foreach ($produits as $produit) {
    echo "<h2>" . htmlspecialchars($produit['nom']) . "</h2>";
    echo "<p><strong>Description :</strong> " . htmlspecialchars($produit['description']) . "</p>";
    echo "<p><strong>Prix :</strong> " . htmlspecialchars($produit['prix']) . " €</p>";
    if (!empty($produit['image'])) {
        echo "<img src='images/" . htmlspecialchars($produit['image']) . "' alt='" . htmlspecialchars($produit['nom']) . "' style='max-width:200px;'><br>";
    }
}
?>
</body>
</html>
