<?php
session_start();
require_once 'connexion_bdd.php'; // ton fichier avec $pdo

// Vérifie que le formulaire a bien été soumis
if (!isset($_POST['username'], $_POST['password'])) {
    header('Location: connexion.php');
    exit;
}

$email = trim($_POST['username']);   // Le champ username est utilisé comme email
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

    if ($user) {
        // Vérifie le mot de passe avec password_verify()
        if (password_verify($password, $user['mot_de_passe'])) {
            // Succès : on enregistre les infos dans la session
            session_regenerate_id(true); // sécurité
            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION['nom']     = $user['nom'];
            $_SESSION['prenom']  = $user['prenom'];
            $_SESSION['email']   = $user['email'];

            header('Location: index.php');
            exit;
        } else {
            // Mauvais mot de passe
            header('Location: connexion.php?erreur=1');
            exit;
        }
    } else {
        // Email inconnu
        header('Location: connexion.php?erreur=1');
        exit;
    }

} catch (PDOException $e) {
    // En cas d'erreur SQL
    header('Location: connexion.php?erreur=1');
    exit;
}
