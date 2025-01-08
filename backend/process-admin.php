<?php
session_start();
require_once '../../db/connect_db.php'; // Connexion à la base de données

// Vérifiez si l'utilisateur est connecté et est administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: ../frontend/public/profil-admin.php"); // Redirige si l'utilisateur n'est pas un administrateur
    exit();
}

// Récupérer tous les utilisateurs
$sql = "SELECT id, user_nom, user_email FROM users"; 
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
