<?php
require_once '../utils/autoload.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    
    $userRepo = new UserRepository();

    $user_id = $_POST['user_id'];

    try {
        // Supprimer l'utilisateur de la base de données
        $userRepo->deleteUser($user_id);

        $_SESSION['delete_message'] = "L'utilisateur a été supprimé avec succès.";
    } catch (Exception $e) {
        $_SESSION['erreur_message'] = "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
    }

    header("Location: ../frontend/public/profil.php");
    exit();
} else {
    $_SESSION['erreur_message'] = "Données invalides.";
    header("Location: ../frontend/public/profil.php");
    exit();
}