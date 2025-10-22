<?php include 'includes/card.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Produits</title>
    <link rel="stylesheet" href="produit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">Haapple Store</div>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="produits.php" class="active">Produits</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="connexion.php">Se connecter</a></li>
                <li><a href="PagePanier.php"><i class="fas fa-shopping-cart"></i></a></li>
            </ul>
        </nav>
    </header>
    <button class='btn-acheter'>Smartphone</button>
    <button class='btn-acheter'>Ordinateur</button>
    <button class='btn-acheter'>Accessoire</button>
    <button class='btn-acheter'>Tablette</button>

    <?php
     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Smartphone']))
        // Filtrer les produits pour n'afficher que les smartphones
        $produits = array_filter($produits, function($produit) {
            return $produit['categorie'] === 'Smartphone';
        });
    ?>
    <?php foreach($produits as $produit):?> 
 <div class="card"> 

 <div class="products-card
 <img class="card-image" src="../projet_dev_ecommerce/images/A.jpg alt "Macbook air M2">
 <Div class="card-content">
  <h3 class="card-title">Macbook air M2 ; ?></h3>
  <p class="card-description">Portable Utra-Fin </p>
  <p class="card-category">Catégorie: Ordinateur</p>
  <div class="card-price">1299 €</div>
    </div>
    <button class='btn-acheter'>Ajouter $nom au panier </button>
    
 <?= createCard($produit['nom'], $produit['prix'], $produit['image'], $produit['description'], $produit['categorie'], $id) ?>
 
<?php endforeach; ?> 