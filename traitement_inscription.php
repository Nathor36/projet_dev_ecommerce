<?php
session_start();
require_once 'connexion_bdd.php';

// Vérifie que le formulaire est bien envoyé
if (!isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['password'], $_POST['password_confirm'])) {
    header("Location: inscription.php?erreur=3");
    exit;
}

$nom = trim($_POST['nom']);
$prenom = trim($_POST['prenom']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$password_confirm = trim($_POST['password_confirm']);

// Vérifie que les champs ne sont pas vides
if ($nom === '' || $prenom === '' || $email === '' || $password === '' || $password_confirm === '') {
    header("Location: inscription.php?erreur=3");
    exit;
}

// Vérifie que les mots de passe correspondent
if ($password !== $password_confirm) {
    header("Location: inscription.php?erreur=1");
    exit;
}

// Vérifie que l'email n'est pas déjà pris
$stmt = $pdo->prepare("SELECT id_utilisateur FROM utilisateurs WHERE email = :email LIMIT 1");
$stmt->execute(['email' => $email]);
$existant = $stmt->fetch();

if ($existant) {
    header("Location: inscription.php?erreur=2");
    exit;
}

// Hash du mot de passe
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    // Insertion dans la table utilisateurs
    $stmt = $pdo->prepare("
        INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe)
        VALUES (:nom, :prenom, :email, :mot_de_passe)
    ");
    $stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'mot_de_passe' => $hashed_password
    ]);

    // Récupère l'ID du nouvel utilisateur
    $id_utilisateur = $pdo->lastInsertId();

    // Création automatique d’une adresse de base (optionnelle mais utile pour éviter les erreurs de commande)
    $stmt = $pdo->prepare("
        INSERT INTO adresses (id_utilisateur, type, rue, ville, code_postal, pays)
        VALUES (:id_utilisateur, 'livraison', 'Adresse par défaut', 'Paris', '75000', 'France')
    ");
    $stmt->execute(['id_utilisateur' => $id_utilisateur]);

    $stmt = $pdo->prepare("
        INSERT INTO adresses (id_utilisateur, type, rue, ville, code_postal, pays)
        VALUES (:id_utilisateur, 'facturation', 'Adresse par défaut', 'Paris', '75000', 'France')
    ");
    $stmt->execute(['id_utilisateur' => $id_utilisateur]);

    // Connexion automatique après inscription
    $_SESSION['id_utilisateur'] = $id_utilisateur;
    $_SESSION['nom'] = $nom;
    $_SESSION['prenom'] = $prenom;
    $_SESSION['email'] = $email;

    header("Location: index.php");
    exit;

} catch (PDOException $e) {
    error_log("Erreur SQL inscription : " . $e->getMessage());
    header("Location: inscription.php?erreur=3");
    exit;
}
