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


    <h1>Mon Panier</h1>



</body>

  <main class="panier-body">
  <h1>Mes Articles</h1>

  <div class="panier-produits">
    <!-- Article 1 -->
    <div class="product-card">
      <img src="images/a.jpg" alt="Article 1" class="card-image">
      <h3 class="card-title">Article 1</h3>
      <p class="card-price">350 €</p>
    </div>

    <!-- Article 2 -->
    <div class="product-card">
        <h3 class="card-title">Article 2</h3>
      <img src="images/b.jpg" alt="Article 2" class="card-image">

      <p class="card-price">499 €</p>
    </div>
  </div>
</main>

    </div>
  </div>
</main>



</html>