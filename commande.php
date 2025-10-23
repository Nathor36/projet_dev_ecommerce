<?php
session_start();
require_once 'connexion_bdd.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: connexion.php?erreur=connexion_requise");
    exit;
}

$id_utilisateur = $_SESSION['id_utilisateur'];
$session_id = session_id();

// Vérifie que le formulaire vient bien de choix_adresse.php
if (!isset($_POST['payer'])) {
    header("Location: PagePanier.php");
    exit;
}

// --- Enregistre ou met à jour les adresses ---
// Livraison
$stmt = $pdo->prepare("
    INSERT INTO adresses (id_utilisateur, type, rue, ville, code_postal, pays)
    VALUES (:id_utilisateur, 'livraison', :rue, :ville, :cp, :pays)
    ON DUPLICATE KEY UPDATE rue = :rue, ville = :ville, code_postal = :cp, pays = :pays
");
$stmt->execute([
    'id_utilisateur' => $id_utilisateur,
    'rue' => $_POST['rue_livraison'],
    'ville' => $_POST['ville_livraison'],
    'cp' => $_POST['cp_livraison'],
    'pays' => $_POST['pays_livraison']
]);

// Facturation
$stmt = $pdo->prepare("
    INSERT INTO adresses (id_utilisateur, type, rue, ville, code_postal, pays)
    VALUES (:id_utilisateur, 'facturation', :rue, :ville, :cp, :pays)
    ON DUPLICATE KEY UPDATE rue = :rue, ville = :ville, code_postal = :cp, pays = :pays
");
$stmt->execute([
    'id_utilisateur' => $id_utilisateur,
    'rue' => $_POST['rue_facturation'],
    'ville' => $_POST['ville_facturation'],
    'cp' => $_POST['cp_facturation'],
    'pays' => $_POST['pays_facturation']
]);

// Récupère les ID des adresses
$stmt = $pdo->prepare("SELECT id_adresse, type FROM adresses WHERE id_utilisateur = :id");
$stmt->execute(['id' => $id_utilisateur]);
$ids = $stmt->fetchAll();
foreach ($ids as $a) {
    if ($a['type'] == 'livraison') $id_adresse_livraison = $a['id_adresse'];
    if ($a['type'] == 'facturation') $id_adresse_facturation = $a['id_adresse'];
}

// --- Récupère le panier ---
$stmt = $pdo->prepare("SELECT id_panier FROM paniers WHERE session_id = :session_id LIMIT 1");
$stmt->execute(['session_id' => $session_id]);
$panier = $stmt->fetch();
if (!$panier) die("Aucun panier trouvé.");

$id_panier = $panier['id_panier'];

// --- Récupère les produits du panier ---
$stmt = $pdo->prepare("
    SELECT p.id_produit, p.prix, pp.quantite
    FROM panier_produits pp
    JOIN produits p ON pp.id_produit = p.id_produit
    WHERE pp.id_panier = :id_panier
");
$stmt->execute(['id_panier' => $id_panier]);
$produits = $stmt->fetchAll();

$total = 0;
foreach ($produits as $p) {
    $total += $p['prix'] * $p['quantite'];
}

// --- Crée la commande ---
$stmt = $pdo->prepare("
    INSERT INTO commandes (id_utilisateur, id_adresse_livraison, id_adresse_facturation, total, date_commande)
    VALUES (:id_utilisateur, :livraison, :facturation, :total, NOW())
");
$stmt->execute([
    'id_utilisateur' => $id_utilisateur,
    'livraison' => $id_adresse_livraison,
    'facturation' => $id_adresse_facturation,
    'total' => $total
]);
$id_commande = $pdo->lastInsertId();

// --- Enregistre les produits de la commande ---
$stmt = $pdo->prepare("
    INSERT INTO commandes_produits (id_commande, id_produit, quantite, prix_unitaire)
    VALUES (:id_commande, :id_produit, :quantite, :prix_unitaire)
");
foreach ($produits as $p) {
    $stmt->execute([
        'id_commande' => $id_commande,
        'id_produit' => $p['id_produit'],
        'quantite' => $p['quantite'],
        'prix_unitaire' => $p['prix']
    ]);
}

// --- Vide le panier ---
$pdo->prepare("DELETE FROM panier_produits WHERE id_panier = :id_panier")->execute(['id_panier' => $id_panier]);
$pdo->prepare("DELETE FROM paniers WHERE id_panier = :id_panier")->execute(['id_panier' => $id_panier]);

header("Location: confirmation_commande.php?id=" . $id_commande);
exit;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande validée - Haapple Store</title>
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
        </ul>
    </nav>
</header>

<main class="confirmation-container">
    <h1>✅ Commande validée !</h1>
    <p>Merci pour votre achat chez <strong>Haapple Store</strong> 🛒</p>
    <p>Numéro de commande : <strong>#<?= $id_commande ?></strong></p>
    <p>Total payé : <strong><?= number_format($total, 2, ',', ' ') ?> €</strong></p>
    <a href="mes_commandes.php" class="btn-retour">Voir mes commandes</a>
</main>

</body>
</html>
