<?php
$host = 'localhost'; // Adresse du serveur MySQL
$db = 'ecommerce'; // Nom de la base de données à utiliser
$user = 'root'; // Nom d'utilisateur pour accéder à la base de données
$pass = ''; // Mot de passe (vide par défaut sous XAMPP/MAMP)

$dsn = "mysql:host=$host;dbname=$db;charset=$charset"; // Chaîne DSN (Data Source Name) utilisée par PDO pour se connecter à MySQL
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Active les exceptions en cas d’erreur SQL   
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Les résultats seront des tableaux associatifs
]; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);  // Crée une instance PDO avec l'encodage défini directement dans la chaîne DSN
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Définit l’attribut d’erreur au mode exception (mieux pour le debug)
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage()); // En cas d’erreur de connexion, affiche un message et stoppe l’exécution
}
?>