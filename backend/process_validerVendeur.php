<?php
require_once '../utils/autoload.php';
session_start();

$userRepo = new UserRepository();

$id = $_POST['user_id'];
$action = $_POST['action'];

try {
    if ($action === 'valider') {
        $userRepo->validerVendeur($id);
    } elseif ($action === 'refuser') {
        $userRepo->refuserVendeur($id);
        $userRepo->updateUserRole($id,3);
    }
    header('Location: ../frontend/public/ajout.php?success=1');
} catch (PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
}