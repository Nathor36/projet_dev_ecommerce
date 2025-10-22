<?php

$produits = [
 ['nom' => 'iPhone 32 Pro', 'prix' => 1449, 'image' => 'C.jpg', 'description' => 'Smartphone haut de gamme', 'categorie' => 'smartphone' , 'Id' => "1"],
 ['nom' => 'MacBook Air M2', 'prix' => 2036, 'image' => 'A.jpg', 'description' => 'Portable ultra-fin', 'categorie' => 'ordinateur' , 'Id' => "2"],
 ['nom' => 'AirPods Pro', 'prix' => 279, 'image' => 'E.jpg', 'description' => 'Écouteurs sans fil', 'categorie' => 'accessoire', 'Id' => "3"],
 ['nom' => 'iPad Air', 'prix' => 699, 'image' => 'F.jpg', 'description' => 'Tablette polyvalente', 'categorie' => 'tablette' , 'Id' => "4"],
 ['nom' => 'Rolex Apple Watch', 'prix' => 44449, 'image' => 'D.jpg', 'description' => 'Montre connectée', 'categorie' => 'accessoire' , 'Id' => "5"],
 ['nom' => 'haappel fortuna watch', 'prix' => 147450, 'image' => 'G.jpg' , 'description' => 'montre de luxe', 'categorie' => 'accessoire' , 'Id' => "6"],
 ['nom' => 'Mac Studio', 'prix' => 2299, 'image' => 'B.jpg', 'description' => 'Station ultra-puissante', 'categorie' => 'ordinateur', 'Id' => "7"],
 ['nom' => 'haarpods' , 'prix' => 1100, 'image' => 'H.jpeg' , 'description' => 'ecouteurs derniere generation', 'categorie' => 'accessoires' , 'Id' => "8"],
 ['nom' => 'iphone 64 mini' , 'prix' => 2100, 'image' => 'i.webp' , 'description' => 'telephone derniere generation', 'categorie' => 'smartphone' , 'Id' => "9"],
 ['nom' => 'ipad KIDIZOOM' , 'prix' => 100, 'image' => 'j.jpg' , 'description' => 'tablette du peuple', 'categorie' => 'tablette' , 'Id' => "10"],
];

$_SESSION['panier'] = [

    // Trouver les articles dans le panier

    [
        'product_id' => 1,
        'quantity' => 1,
        'name' => 'Product A',
    ],
    [
        'product_id' => 2,
        'quantity' => 1,
        'name' => 'Product B',
    ],
    [
        'product_id' => 3,
        'quantity' => 1,
        'name' => 'Product C',
    ],
    [
        'product_id' => 4,
        'quantity' => 1,
        'name' => 'Product D',
    ],
    [
        'product_id' => 5,
        'quantity' => 1,
        'name' => 'Product E',
    ],
    [
        'product_id' => 6,
        'quantity' => 1,
        'name' => 'Product F',
    ],
    [
        'product_id' => 7,
        'quantity' => 1,
        'name' => 'Product G',
    ],
    [
        'product_id' => 8,
        'quantity' => 1,
        'name' => 'Product H',
    ],
    [
        'product_id' => 9,
        'quantity' => 1,
        'name' => 'Product I',
    ],
    [
        'product_id' => 10,
        'quantity' => 1,
        'name' => 'Product J',
    ],
    
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