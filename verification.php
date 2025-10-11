<?php
session_start();
require_once 'connexion_bdd.php'; // ton fichier avec $pdo

if (!isset($_POST['username'], $_POST['password'])) {
    header('Location: connexion.php');
    exit;
}

$email = trim($_POST['username']);   // le champ du formulaire s’appelle "username", mais on s’en sert comme email
$password = trim($_POST['password']);

if ($email === '' || $password === '') {
    header('Location: connexion.php?erreur=2'); // champs vides
    exit;
}

try {
    // On cherche un utilisateur avec cet email
    $sql = "SELECT * FROM utilisateur WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['mot_de_passe'] === $password) {
        // Succès
        $_SESSION['user_id']  = $user['id_utilisateur'];
        $_SESSION['nom']      = $user['nom'];
        $_SESSION['prenom']   = $user['prenom'];
        $_SESSION['email']    = $user['email'];

        header('Location: index.php');
        exit;
    } else {
        // Mauvais mot de passe ou email
        header('Location: connexion.php?erreur=1');
        exit;
    }
} catch (PDOException $e) {
    // En cas de souci de connexion ou de requête
    header('Location: connexion.php?erreur=1');
    exit;
}
