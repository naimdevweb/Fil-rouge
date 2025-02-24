<?php
require_once '../utils/autoload.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/public/login.php");
    exit();
}

$acheteur_id = $_SESSION['user_id'];
$livre_id = isset($_GET['livre_id']) ? intval($_GET['livre_id']) : 0;

if ($livre_id > 0) {
    $bookRepo = new BookRepository();
    try {
        $bookRepo->addToCart($acheteur_id, $livre_id);
        $_SESSION['success_message'] = "Le livre a été ajouté au panier avec succès.";
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Erreur lors de l'ajout du livre au panier : " . $e->getMessage();
    }
} else {
    $_SESSION['error_message'] = "ID de livre invalide.";
}

header("Location: ../frontend/public/panier.php");
exit();