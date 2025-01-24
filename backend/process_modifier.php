<?php
session_start();
require_once '../utils/autoload.php';


$userRepo = new UserRepository();

$user_id = $_SESSION['user_id'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Récupérer les informations de l'utilisateur
$user = $userRepo->getUserById($user_id);

if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
    $password_error_message = "Tous les champs de mot de passe doivent être remplis.";
} elseif (!password_verify($current_password, $user['user_password'])) {
    $password_error_message = "Le mot de passe actuel est incorrect.";
} elseif ($new_password !== $confirm_password) {
    $password_error_message = "Les nouveaux mots de passe ne correspondent pas.";
} else {
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    try {
        // Mettre à jour le mot de passe de l'utilisateur
        $userRepo->updateUserPassword($user_id, $hashed_password);
        $password_success_message = "Mot de passe mis à jour avec succès.";
    } catch (Exception $e) {
        $password_error_message = "Erreur lors de la mise à jour du mot de passe : " . $e->getMessage();
    }
}

header("Location: ../frontend/public/profil.php");
exit();
?>