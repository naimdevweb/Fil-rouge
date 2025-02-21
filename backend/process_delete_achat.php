<?php
require_once '../utils/autoload.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['livre_id'])) {
    $bookRepo = new BookRepository();
    $acheteur_id = $_SESSION['user_id'];
    $livre_id = intval($_POST['livre_id']);

    try {
      
        $bookRepo->deleteAchat($acheteur_id, $livre_id);
        $_SESSION['delete_message'] = "L'annonce a été supprimée du panier avec succès.";
    } catch (Exception $e) {
        $_SESSION['erreur_message'] = "Erreur lors de la suppression de l'annonce : " . $e->getMessage();
    }

    header("Location: ../frontend/public/panier.php");
    exit();
} else {
    $_SESSION['erreur_message'] = "Données invalides.";
    header("Location: ../frontend/public/panier.php");
    exit();
}