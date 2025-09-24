<?php include 'includes/card.php'; ?>
<!DOCTYPE html>
<html>
<head>
 <title>Test Cards</title>
 <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="topnav">
  <a class="active" href="#home">Home</a>
  <a href="#news">News</a>
  <a href="contact.php">Contact</a>
</div>
<h1>Apple Store</h1>
<?php foreach($produits as $produit): ?> 
 <div class="card"> 
 <?= createCard($produit['nom'], $produit['prix'], $produit['image'], $produit['description'], $produit['categorie']) ?>
 </div>
<?php endforeach; ?> 
</html>