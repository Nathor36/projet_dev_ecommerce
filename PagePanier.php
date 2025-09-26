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

<div class="titlePanier">
  
  <h1>Mon Panier</h1>

</div>

</body>

  <main class="panier-body">

  <h2>Mes Articles</h2>

  <div class="panier-produits">
  
  <div class="baseproduct-card">

  <div class="product-card">
      <h3 class="card-title">Article 1</h3>
        
      <img src="images/a.jpg" alt="Article 1" class="card-image1">
        
        <p class="card-description1">Mackbook Air M2.</p>


      <div class="card-description2"

        <p> - 16GB RAM, 512GB SSD  </p>
        <p> - Couleur: Gris Sidéral </p>
        <p> - Processeur: Apple M2 </p>
        <p> - Écran: 13.6 pouces Retina </p>
        </div>

        <p class="card-price">350 €</p>

        <button class="bouton-achat">Clique-moi</button>
    </div>

 
    <div class="product-card">
        <h3 class="card-title">Article 2</h3>

      <img src="images/b.jpg" alt="Article 2" class="card-image2">

        <p class="card-description1">Mac Studio.</p>

        <div class="card-description2"

        <p> - 16GB RAM, 512GB SSD  </p>
        <p> - Couleur: Gris Sidéral </p>
        <p> - Processeur: Apple M2 </p>
        <p> - Écran: 13.6 pouces Retina </p>
        </div>



      <p class="card-price">499 €</p>

      <button class="bouton-achat">Clique-moi</button>

    </div>
  </div>
</main>

    </div>
  </div>
</main>



</html>