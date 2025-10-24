<?php
session_start();
require_once 'connexion_bdd.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: connexion.php?erreur=connexion_requise");
    exit;
}

$id_utilisateur = $_SESSION['id_utilisateur'];

// Récupère les adresses existantes
$stmt = $pdo->prepare("SELECT * FROM adresses WHERE id_utilisateur = :id_utilisateur");
$stmt->execute(['id_utilisateur' => $id_utilisateur]);
$adresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// On sépare livraison et facturation
$livraison = null;
$facturation = null;
foreach ($adresses as $adr) {
    if ($adr['type'] === 'livraison') $livraison = $adr;
    if ($adr['type'] === 'facturation') $facturation = $adr;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Adresse de livraison - Haapple Store</title>
    <link rel="stylesheet" href="style_Commande.css">
</head>
<body>

<header class="navbar">
    <div class="logo">Haapple Store</div>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="produits.php">Produits</a></li>
            <li><a href="PagePanier.php">Panier</a></li>
            <li><a href="mes_commandes.php">Mes commandes</a></li>
            <li><a href="deconnexion.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<main class="confirmation-container">
    <h1>Adresse de livraison et de facturation</h1>

    <form method="POST" action="commande.php">
        <h2>Adresse de livraison</h2>
        <input type="text" name="rue_livraison" placeholder="Rue" required value="<?= htmlspecialchars($livraison['rue'] ?? '') ?>">
        <input type="text" name="ville_livraison" placeholder="Ville" required value="<?= htmlspecialchars($livraison['ville'] ?? '') ?>">
        <input type="text" name="cp_livraison" placeholder="Code postal" required value="<?= htmlspecialchars($livraison['code_postal'] ?? '') ?>">
        <input type="text" name="pays_livraison" placeholder="Pays" required value="<?= htmlspecialchars($livraison['pays'] ?? '') ?>">

        <h2>Adresse de facturation</h2>
        <input type="text" name="rue_facturation" placeholder="Rue" required value="<?= htmlspecialchars($facturation['rue'] ?? '') ?>">
        <input type="text" name="ville_facturation" placeholder="Ville" required value="<?= htmlspecialchars($facturation['ville'] ?? '') ?>">
        <input type="text" name="cp_facturation" placeholder="Code postal" required value="<?= htmlspecialchars($facturation['code_postal'] ?? '') ?>">
        <input type="text" name="pays_facturation" placeholder="Pays" required value="<?= htmlspecialchars($facturation['pays'] ?? '') ?>">

        <button type="submit" name="payer" class="btn-commander">Payer</button>
    </form>
</main>

</body>
</html>
