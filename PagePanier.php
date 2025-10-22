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

<table border="1">
  <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix</th>
            <th>Action</th>
        </tr>
        <?php
            $total = 0;
            $count = count($_SESSION['panier']);
            $minRows = 5; // nombre de lignes minimales à afficher
            $emptyRows = max(0, $minRows - $count);
        ?>
        <?php foreach ($_SESSION['panier'] as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['name']); ?></td>
            <td><?php echo (int)$item['quantity']; ?></td>
            <td>
                <?php

                $price = 0;
                $product = "SELECT * FORM products WHERE id = " . (int)$item['product_id']." LIMIT 1";

                $price = $product['price'] * (int)$item['quantity'];
                $total += $price;
                ?>
                <?= number_format($price, 2) ?> €
            </td>
            <td>
                <form method="post" action="remove_from_cart.php">
                    <input type="hidden" name="product_id" value="<?= (int)$item['product_id'] ?>">
                    <button type="submit">Retirer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>

        <?php for ($i = 0; $i < $emptyRows; $i++): ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
        <?php endfor; ?>
        
        <tr>
            <td colspan="3"><strong>Total</strong></td>
            <td>
                <strong><?= number_format($total, 2) ?> €</strong>
            </td>
        </tr>
    </table>
</body>
</html>