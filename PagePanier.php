<?php


session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
 }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier </title>
    <link rel="stylesheet" href="style_Panier.css">
</head>
<body>
    <h1>Mon Panier</h1>


</body>
</html>