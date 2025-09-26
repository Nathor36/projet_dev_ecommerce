<?php include 'includes/card.php'; ?>
<!DOCTYPE html>
<html>
<head>
 <title>Produits</title>
 <link rel="stylesheet" href="style.css">
 <header class="navbar">
  <div class="logo">Haapple Store</div>
  <nav>
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="produits.php">Produits</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="PagePanier.php"><i class="fas fa-shopping-cart"></i></a></li>
    </ul>
  </nav>
</header>
</head>

<?php foreach($produits as $produit): ?> 
 <div class="card"> 
 <?= createCard($produit['nom'], $produit['prix'], $produit['image'], $produit['description'], $produit['categorie']) ?>
<?php endforeach; ?> 