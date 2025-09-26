<?php

$produits = [
 ['nom' => 'iPhone 32 Pro', 'prix' => 1449, 'image' => 'C.jpg', 'description' => 'Smartphone haut de gamme', 'categorie' => 'smartphone'],
 ['nom' => 'MacBook Air M2', 'prix' => 2036, 'image' => 'A.jpg', 'description' => 'Portable ultra-fin', 'categorie' => 'ordinateur'],
 ['nom' => 'AirPods Pro', 'prix' => 279, 'image' => 'E.jpg', 'description' => 'Écouteurs sans fil', 'categorie' => 'accessoire'],
 ['nom' => 'iPad Air', 'prix' => 699, 'image' => 'F.jpg', 'description' => 'Tablette polyvalente', 'categorie' => 'tablette'],
 ['nom' => 'Rolex Apple Watch', 'prix' => 44449, 'image' => 'D.jpg', 'description' => 'Montre connectée', 'categorie' => 'accessoire'],
 ['nom' => 'haappel fortuna watch', 'prix' => 147450, 'image' => 'G.jpg' , 'description' => 'montre de luxe', 'categorie' => 'accessoire'],
 ['nom' => 'Mac Studio', 'prix' => 2299, 'image' => 'B.jpg', 'description' => 'Station ultra-puissante', 'categorie' => 'ordinateur'],
 ['nom' => 'haarpods' , 'prix' => 1100, 'image' => 'H.jpeg' , 'description' => 'ecouteurs derniere generation', 'categorie' => 'accessoires'],
 ['nom' => 'iphone 64 mini' , 'prix' => 2100, 'image' => 'i.webp' , 'description' => 'telephone derniere generation', 'categorie' => 'smartphone'],
 ['nom' => 'ipad KIDIZOOM' , 'prix' => 100, 'image' => 'j.jpg' , 'description' => 'tablette du peuple', 'categorie' => 'tablette'],
];

function createCard($nom, $prix, $image, $description, $categorie)
{
return "
<div class='product-card'>
<img src='../projet_dev_ecommerce/images/$image' alt='$nom' class='card-image'>
<div class='card-content'>
<h3 class='card-title'>$nom</h3>
<p class='card-description'>$description</p>
<p class='card-category'>Catégorie: $categorie</p>
<div class='card-price'>$prix €</div>

<button class='btn-acheter'>Ajouter au panier</button>
</div>
</div>";
}