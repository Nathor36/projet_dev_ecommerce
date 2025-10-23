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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
