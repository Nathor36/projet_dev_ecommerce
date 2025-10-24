
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style_panier.css">
</head>

<?php
session_start();
require_once 'connexion_bdd.php'; // inclusion du fichier de connexion
?>



 <!-- Requête SQL pour les Images. -->

 <?php

 // Préparer la requête avec JOIN pour filtrer par nom de catégorie
$stmt = $pdo->prepare("
    SELECT 
");

// Exécuter la requête en liant le paramètre
$stmt->execute(['categorie' => $categorie]);

// Récupérer tous les produits
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afficher les produits
foreach ($produits as $produit) {
    echo "<h2>" . htmlspecialchars($produit['nom']) . "</h2>";
    echo "<p><strong>Catégorie :</strong> " . htmlspecialchars($produit['nom']) . "</p>";
    echo "<p><strong>Description :</strong> " . htmlspecialchars($produit['description']) . "</p>";
    echo "<p><strong>Prix :</strong> " . htmlspecialchars($produit['prix']) . " €</p>";
    if (!empty($produit['image'])) {
        echo "<img src='images/" . htmlspecialchars($produit['image']) . "' alt='" . htmlspecialchars($produit['nom_produit']) . "' style='max-width:200px;'><br>";
    }
}
?>






<body>
    <!-- Navbar -->
    <nav class="navbar">
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
        
    </nav>

    
    <div class="cart-container">
        <h1 class="cart-title">Mon Panier</h1>
        
        <div class="cart-content" id="cartContent">
            <div class="cart-items" id="cartItems">

            </div>

            <div class="cart-summary">
                <div class="summary-title">Résumé</div>
                <div class="summary-row">
                    <span>Sous-total:</span>
                    <span id="subtotal">0.00€</span>
                </div>
                <div class="summary-row">
                    <span>Livraison:</span>
                    <span id="shipping">5.00€</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total:</span>
                    <span id="total">0.00€</span>
                </div>
                <button class="checkout-btn" onclick="checkout()">
                    Passer la commande
                </button>
            </div>
        </div>
    </div>

    <script>
       
    // Données du panier (exemple)
        let cartItems = [
            { id: 1, name: "MacBook Air M2", price: 29.99, quantity: 2, image: "" },
            { id: 2, name: "Jean Slim", price: 59.99, quantity: 1, image: "https://images.unsplash.com/photo-1542272604-787c3835535d?w=200&h=200&fit=crop" },
            { id: 3, name: "Baskets Blanches", price: 79.99, quantity: 1, image: "https://images.unsplash.com/photo-1549298916-b41d501d3772?w=200&h=200&fit=crop" }
        ];

        function renderCart() {
            const cartItemsContainer = document.getElementById('cartItems');
            
            if (cartItems.length === 0) {
                document.getElementById('cartContent').innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart" style="font-size: 80px; color: #ccc; margin-bottom: 20px;"></i>
                        <p>Votre panier est vide</p>
                        <a href="#" class="continue-shopping">Continuer mes achats</a>
                    </div>
                `;
                return;
            }

            cartItemsContainer.innerHTML = cartItems.map(item => `
                <div class="cart-item">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="item-details">
                        <div class="item-name">${item.name}</div>
                        <div class="item-price">${item.price.toFixed(2)}€</div>
                        <div class="quantity-control">
                            <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                            <span class="quantity-display">${item.quantity}</span>
                            <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                        </div>
                    </div>
                    <button class="remove-btn" onclick="removeItem(${item.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `).join('');

            updateSummary();
        }

        function updateQuantity(id, change) {
            const item = cartItems.find(i => i.id === id);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeItem(id);
                } else {
                    renderCart();
                }
            }
        }

        function removeItem(id) {
            cartItems = cartItems.filter(i => i.id !== id);
            renderCart();
        }

        function updateSummary() {
            const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const shipping = cartItems.length > 0 ? 5.00 : 0;
            const total = subtotal + shipping;

            document.getElementById('subtotal').textContent = subtotal.toFixed(2) + '€';
            document.getElementById('shipping').textContent = shipping.toFixed(2) + '€';
            document.getElementById('total').textContent = total.toFixed(2) + '€';
        }

        function checkout() {
            if (cartItems.length === 0) {
                alert('Votre panier est vide !');
                return;
            }
            alert('Redirection vers le paiement...');
        }

        // Initialiser le panier
        renderCart();
    </script>
</body>
</html>