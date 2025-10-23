<?php
session_start();
require_once 'connexion_bdd.php';

// Vérifie la connexion
if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: connexion.php?erreur=connexion_requise");
    exit;
}

$id_utilisateur = $_SESSION['id_utilisateur'];

// Récupère toutes les commandes de l'utilisateur
$stmt = $pdo->prepare("
    SELECT id_commande, total, date_commande 
    FROM commandes 
    WHERE id_utilisateur = :id_utilisateur
    ORDER BY date_commande DESC
");
$stmt->execute(['id_utilisateur' => $id_utilisateur]);
$commandes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Commandes - Haapple Store</title>
    <link rel="stylesheet" href="style_Commande.css">
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
            <li><a href="PagePanier.php"><i class="fas fa-shopping-cart"></i></a></li>
            <li><a href="mes_commandes.php" class="active">Mes Commandes</a></li>
        </ul>
    </nav>
</header>

<!-- CONTENU -->
<main class="confirmation-container">
    <h1>📦 Mes Commandes</h1>

    <?php if (empty($commandes)) : ?>
        <p>Vous n’avez encore passé aucune commande.</p>
        <a href="produits.php" class="btn-retour">Découvrir nos produits</a>
    <?php else : ?>
        <table class="table-panier">
            <thead>
                <tr>
                    <th>ID Commande</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Détails</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandes as $commande) : ?>
                    <tr>
                        <td>#<?= htmlspecialchars($commande['id_commande']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?></td>
                        <td><?= number_format($commande['total'], 2, ',', ' ') ?> €</td>
                        <td><a href="details_commande.php?id=<?= $commande['id_commande'] ?>" class="btn-commander">Voir</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

</body>
</html>
