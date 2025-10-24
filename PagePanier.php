<<<<<<< HEAD

=======
<?php
session_start();
require_once 'connexion_bdd.php';

// Récupération du panier lié à la session ou à l'utilisateur connecté
$session_id = session_id();
$id_utilisateur = $_SESSION['id_utilisateur'] ?? null;

// Vérifie si le panier existe
$stmt = $pdo->prepare("SELECT id_panier FROM paniers WHERE session_id = :session_id LIMIT 1");
$stmt->execute(['session_id' => $session_id]);
$panier = $stmt->fetch();

if (!$panier) {
    // Crée un panier vide s’il n’existe pas encore
    $stmt = $pdo->prepare("INSERT INTO paniers (session_id, id_utilisateur) VALUES (:session_id, :id_utilisateur)");
    $stmt->execute([
        'session_id' => $session_id,
        'id_utilisateur' => $id_utilisateur
    ]);
    $id_panier = $pdo->lastInsertId();
} else {
    $id_panier = $panier['id_panier'];
}

// --- Supprimer un produit du panier ---
if (isset($_GET['remove'])) {
    $id_produit = intval($_GET['remove']);
    $stmt = $pdo->prepare("DELETE FROM panier_produits WHERE id_panier = :id_panier AND id_produit = :id_produit");
    $stmt->execute(['id_panier' => $id_panier, 'id_produit' => $id_produit]);
    header("Location: PagePanier.php");
    exit;
}

// --- Mettre à jour les quantités ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST['quantite'] as $id_produit => $quantite) {
        $quantite = max(1, intval($quantite)); // au moins 1
        $stmt = $pdo->prepare("
            UPDATE panier_produits 
            SET quantite = :quantite 
            WHERE id_panier = :id_panier AND id_produit = :id_produit
        ");
        $stmt->execute([
            'quantite' => $quantite,
            'id_panier' => $id_panier,
            'id_produit' => $id_produit
        ]);
    }
    header("Location: PagePanier.php");
    exit;
}

// --- Récupération des produits du panier ---
$query = "
    SELECT p.id_produit, p.nom, p.image, p.prix, pp.quantite
    FROM panier_produits pp
    JOIN produits p ON pp.id_produit = p.id_produit
    WHERE pp.id_panier = :id_panier
";
$stmt = $pdo->prepare($query);
$stmt->execute(['id_panier' => $id_panier]);
$produits = $stmt->fetchAll();

// --- Calcul du total ---
$total = 0;
foreach ($produits as $p) {
    $total += $p['prix'] * $p['quantite'];
}
?>
>>>>>>> 2fab57854fdb2070a28811954aa79a751cf2c61a
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
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
=======
    <title>Mon Panier - Haapple Store</title>
    <link rel="stylesheet" href="style_Panier.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
    <div class="logo">Haapple Store</div>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="produits.php">Produits</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="connexion.php">Se connecter</a></li>
            <li><a href="PagePanier.php" class="active"><i class="fas fa-shopping-cart"></i></a></li>
        </ul>
    </nav>
</header>

<!-- CONTENU PRINCIPAL -->
<main class="container">
    <h1>Mon panier</h1>

    <?php if (empty($produits)) : ?>
        <p>Votre panier est vide 😢</p>
        <a href="produits.php" class="btn-retour">Voir les produits</a>
    <?php else : ?>
        <form method="POST">
            <table class="table-panier">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Sous-total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $produit) : ?>
                        <tr>
                            <td><img src="images/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" width="80"></td>
                            <td><?= htmlspecialchars($produit['nom']) ?></td>
                            <td><?= number_format($produit['prix'], 2, ',', ' ') ?> €</td>
                            <td>
                                <input type="number" name="quantite[<?= $produit['id_produit'] ?>]" value="<?= intval($produit['quantite']) ?>" min="1">
                            </td>
                            <td><?= number_format($produit['prix'] * $produit['quantite'], 2, ',', ' ') ?> €</td>
                            <td><a href="PagePanier.php?remove=<?= $produit['id_produit'] ?>" class="btn-supprimer">🗑️</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-panier">
                <p><strong>Total :</strong> <?= number_format($total, 2, ',', ' ') ?> €</p>
                <button type="submit" name="update" class="btn-maj">Mettre à jour le panier</button>
                <a href="produits.php" class="btn-retour">Continuer mes achats</a>
                <a href="commande.php" class="btn-commander">Passer la commande</a>
            </div>
        </form>
    <?php endif; ?>
</main>

</body>
</html>
>>>>>>> 2fab57854fdb2070a28811954aa79a751cf2c61a
