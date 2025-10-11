<?php
$host = 'localhost';   // Adresse du serveur MySQL
$db   = 'ecommerce';   // Nom de la base de données
$user = 'root';        // Nom d'utilisateur MySQL
$pass = '';            // Mot de passe (vide par défaut sous XAMPP/MAMP)
$charset = 'utf8mb4';  // Jeu de caractères à utiliser

// Construction du DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Options PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Active les exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Résultats sous forme de tableaux associatifs
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Utilise les vraies requêtes préparées
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>