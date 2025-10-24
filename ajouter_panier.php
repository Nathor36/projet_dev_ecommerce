<?php
session_start();
require_once 'connexion_bdd.php';

// Vérifie la présence des données
if (!isset($_POST['id_produit']) || !isset($_POST['quantite'])) {
    header("Location: produits.php");
    exit;
}

$id_produit = intval($_POST['id_produit']);
$quantite = intval($_POST['quantite']);
if ($quantite < 1) $quantite = 1;

// Récupération de la session ou de l’utilisateur connecté
$session_id = session_id();
$id_utilisateur = $_SESSION['id_utilisateur'] ?? null;

// Vérifie ou crée un panier
$stmt = $pdo->prepare("SELECT id_panier FROM paniers WHERE session_id = :session_id LIMIT 1");
$stmt->execute(['session_id' => $session_id]);
$panier = $stmt->fetch();

if (!$panier) {
    $stmt = $pdo->prepare("INSERT INTO paniers (session_id, id_utilisateur) VALUES (:session_id, :id_utilisateur)");
    $stmt->execute(['session_id' => $session_id, 'id_utilisateur' => $id_utilisateur]);
    $id_panier = $pdo->lastInsertId();
} else {
    $id_panier = $panier['id_panier'];
}

// Vérifie si le produit est déjà dans le panier
$stmt = $pdo->prepare("SELECT quantite FROM panier_produits WHERE id_panier = :id_panier AND id_produit = :id_produit");
$stmt->execute(['id_panier' => $id_panier, 'id_produit' => $id_produit]);
$existant = $stmt->fetch();

if ($existant) {
    // Met à jour la quantité
    $stmt = $pdo->prepare("
        UPDATE panier_produits 
        SET quantite = quantite + :quantite 
        WHERE id_panier = :id_panier AND id_produit = :id_produit
    ");
    $stmt->execute([
        'quantite' => $quantite,
        'id_panier' => $id_panier,
        'id_produit' => $id_produit
    ]);
} else {
    // Ajoute un nouvel article
    $stmt = $pdo->prepare("
        INSERT INTO panier_produits (id_panier, id_produit, quantite) 
        VALUES (:id_panier, :id_produit, :quantite)
    ");
    $stmt->execute([
        'id_panier' => $id_panier,
        'id_produit' => $id_produit,
        'quantite' => $quantite
    ]);
}

// Retour à la page des produits
header("Location: PagePanier.php");
exit;
?>
