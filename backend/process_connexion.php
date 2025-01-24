<?php
session_start();
require_once '../utils/autoload.php';

$email = htmlspecialchars(trim($_POST['user_email']));
$password = trim($_POST['user_mdp']);

if (empty($email) || empty($password)) {
    $_SESSION["mdp"] = "Erreur : Tous les champs sont obligatoires.";
    header("Location: ../frontend/public/connexion.php");
    exit;
}

try {
    $userRepo = new UserRepository();
    $user = $userRepo->getUserByEmail($email);

    if ($user) {
        // Vérifiez le mot de passe
        if (password_verify($password, $user->getPassword())) {
            $_SESSION['user_email'] = $user->getEmail();
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_prenom'] = $user->getPrenom();

            header("Location: ../frontend/public/profil.php");
            exit;
        } else {
            $_SESSION["mdp"] = "Erreur : Mot de passe incorrect.";
            header("Location: ../frontend/public/connexion.php");
            exit;
        }
    } else {
        $_SESSION["mdp"] = "Erreur : Utilisateur non trouvé.";
        header("Location: ../frontend/public/connexion.php");
        exit;
    }
} catch (PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
}