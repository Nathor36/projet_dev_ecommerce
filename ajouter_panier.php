<?php
session_start();
require_once 'connexion_bdd.php';

header('Content-Type: application/json');

// Vérifier que l'ID du produit est fourni
if (!isset($_POST['id_produit'])) {
    echo json_encode(['success' => false, 'message' => 'ID produit manquant']);
    exit;
}

$id_produit = intval($_POST['id_produit']);
$session_id = session_id();

try {
    // Récupérer l'ID utilisateur s'il est connecté
    $id_utilisateur = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    // Vérifier si un panier existe déjà pour cette session ou cet utilisateur
    if ($id_utilisateur) {
        $stmt = $pdo->prepare("SELECT id_panier FROM paniers WHERE id_utilisateur = :id_utilisateur LIMIT 1");
        $stmt->execute([':id_utilisateur' => $id_utilisateur]);
    } else {
        $stmt = $pdo->prepare("SELECT id_panier FROM paniers WHERE session_id = :session_id AND id_utilisateur IS NULL LIMIT 1");
        $stmt->execute([':session_id' => $session_id]);
    }
    
    $panier = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si aucun panier n'existe, en créer un
    if (!$panier) {
        $stmt = $pdo->prepare("INSERT INTO paniers (session_id, id_utilisateur, date_creation) VALUES (:session_id, :id_utilisateur, NOW())");
        $stmt->execute([
            ':session_id' => $session_id,
            ':id_utilisateur' => $id_utilisateur
        ]);
        $id_panier = $pdo->lastInsertId();
    } else {
        $id_panier = $panier['id_panier'];
    }
    
    // Vérifier si le produit est déjà dans le panier
    $stmt = $pdo->prepare("SELECT quantite FROM panier_produits WHERE id_panier = :id_panier AND id_produit = :id_produit");
    $stmt->execute([
        ':id_panier' => $id_panier,
        ':id_produit' => $id_produit
    ]);
    
    $produit_panier = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($produit_panier) {
        // Augmenter la quantité
        $stmt = $pdo->prepare("UPDATE panier_produits SET quantite = quantite + 1 WHERE id_panier = :id_panier AND id_produit = :id_produit");
        $stmt->execute([
            ':id_panier' => $id_panier,
            ':id_produit' => $id_produit
        ]);
    } else {
        // Ajouter le produit au panier
        $stmt = $pdo->prepare("INSERT INTO panier_produits (id_panier, id_produit, quantite) VALUES (:id_panier, :id_produit, 1)");
        $stmt->execute([
            ':id_panier' => $id_panier,
            ':id_produit' => $id_produit
        ]);
    }
    
    echo json_encode(['success' => true, 'message' => 'Produit ajouté au panier']);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}
?>