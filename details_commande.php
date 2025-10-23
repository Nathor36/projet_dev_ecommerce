<?php
session_start();
require_once 'connexion_bdd.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: connexion.php?erreur=connexion_requise");
    exit;
}

$id_utilisateur = $_SESSION['id_utilisateur'];
$id_commande = intval($_GET['id'] ?? 0);

// Récupère la commande (vérifie qu’elle appartient bien à l’utilisateur)
$stmt = $pdo->prepare("
    SELECT * FROM commandes 
    WHERE id_commande = :id_commande AND id_utilisateur = :id_utilisateur
");
$stmt->execute(['id_commande' => $id_commande, 'id_utilisateur' => $id_utilisateur]);
$commande = $stmt->fetch();

if (!$commande) {
    die("Commande introuvable ou non autorisée.");
}

// Récupère les produits de la commande
$stmt = $pdo->prepare("
    SELECT p.nom, cp.quantite, cp.prix_unitaire 
    FROM commandes_produits cp
    JOIN produits p ON cp.id_produit = p.id_produit
    WHERE cp.id_commande = :id_commande
");
$stmt->execute(['id_commande' => $id_commande]);
$produits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la commande #<?= $id_commande ?></title>
    <link rel="stylesheet" href="produit.css">
</head>
<body>

<header class="navbar">
    <div class="logo">Haapple Store</div>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="produits.php">Produits</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="PagePanier.php"><i class="fas fa-shopping-cart"></i></a></li>
            <li><a href="mes_commandes.php" class="active">Mes Commandes</a></li>
        </ul>
    </nav>
</header>

<main class="confirmation-container">
    <h1>🧾 Détails de la commande #<?= $id_commande ?></h1>
    <p>Date : <?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?></p>
    <p>Total : <strong><?= number_format($commande['total'], 2, ',', ' ') ?> €</strong></p>

    <table class="table-panier">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nom']) ?></td>
                    <td><?= intval($p['quantite']) ?></td>
                    <td><?= number_format($p['prix_unitaire'], 2, ',', ' ') ?> €</td>
                    <td><?= number_format($p['prix_unitaire'] * $p['quantite'], 2, ',', ' ') ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="mes_commandes.php" class="btn-retour">⬅ Retour à mes commandes</a>
</main>

</body>
</html>
