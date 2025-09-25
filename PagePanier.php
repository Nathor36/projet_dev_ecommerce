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
    <title>Mon Panier </title>
    <link rel="stylesheet" href="style_Panier.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<header class="navbar">
  <div class="logo">Ma Boutique</div>
  <nav>
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="produits.php">Produits</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="PagePanier.php"><i class="fas fa-shopping-cart"></i></a></li>
    </ul>
  </nav>
</header>

<div class="titlePanier">
  
  <h1>Mon Panier</h1>



</body>

  <main class="panier-body">
  <h1>Mes Articles</h1>

  <div class="panier-produits">
  
  <div class="product-card">
      <h3 class="card-title">Article 1</h3>
        
      <img src="images/a.jpg" alt="Article 1" class="card-image1">
        
        <p class="card-description1">Mackbook Air M2.</p>
        <p class="card-description1">16GB RAM, 512GB SSD</p>
        <p class="card-description1">Couleur: Gris Sidéral</p>
        <p class="card-description1">Processeur: Apple M2</p>
        <p class="card-description1">Écran: 13.6 pouces Retina</p>
      

        <p class="card-price">350 €</p>

        <button class="bouton-achat">Clique-moi</button>
    </div>

    <!-- Article 2 -->
    <div class="product-card">
        <h3 class="card-title">Article 2</h3>

      <img src="images/b.jpg" alt="Article 2" class="card-image2">

      <p class="card-description2">Mackbook Air M2.</p>
        <p class="card-description2">16GB RAM, 512GB SSD</p>
        <p class="card-description2">Couleur: Gris Sidéral</p>
        <p class="card-description2">Processeur: Apple M2</p>
        <p class="card-description2">Écran: 13.6 pouces Retina</p>
      

      <p class="card-price">499 €</p>

      <button class="bouton-achat">Clique-moi</button>

    </div>
  </div>
</main>

    </div>
  </div>
</main>



</html>