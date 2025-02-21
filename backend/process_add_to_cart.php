<?php
include_once '../utils/autoload.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("location: ..frontend/public/connexion.php");
    exit();
}

$acheteur_id = $_SESSION['user_id'];
$livre_id = isset($_GET['livre_id']) ? intval($_GET['livre_id']) : 0;
// var_dump($livre_id);
// die();

if($livre_id > 0){
    $bookRepo = new BookRepository();
    $bookRepo->addToCart($acheteur_id,$livre_id);
}

header("Location: ../frontend/public/panier.php");
exit();