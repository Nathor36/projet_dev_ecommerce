<?php
session_start();
require_once 'connexion_bdd.php';

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: connexion.php");
    exit;
}

$id_commande = intval($_GET['id'] ?? 0);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande confirmée - Haapple Store</title>
    <link rel="stylesheet" href="style_Commande.css">
</head>
<body>
<main class="confirmation-container">
    <h1>✅ Merci pour votre commande !</h1>
    <p>Votre commande n° <strong>#<?= $id_commande ?></strong> a bien été enregistrée.</p>
    <p>Vous recevrez un email lorsque votre commande sera expédiée.</p>
    <a href="mes_commandes.php" class="btn-retour">Voir mes commandes</a>
</main>
</body>
</html>
