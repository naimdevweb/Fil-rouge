<?php
session_start();
require_once '../db/connect_db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../connexion.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupérer les informations de l'utilisateur depuis la base de données
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() == 0) {
    echo "Utilisateur introuvable.";
    exit();
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Traitement pour modifier les informations utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_info'])) {
    $nom = $_POST['user_nom'];
    $prenom = $_POST['user_prenom'];
    $email = $_POST['user_email'];
    $tel = $_POST['user_tel'];

    if (empty($nom) || empty($prenom) || empty($email) || empty($tel)) {
        $error_message = "Tous les champs doivent être remplis.";
    } else {
        $sql_update = "UPDATE users SET user_nom = :user_nom, user_prenom = :user_prenom, user_email = :user_email, user_tel = :user_tel WHERE id = :id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':user_nom', $nom);
        $stmt_update->bindParam(':user_prenom', $prenom);
        $stmt_update->bindParam(':user_email', $email);
        $stmt_update->bindParam(':user_tel', $tel);
        $stmt_update->bindParam(':id', $user_id, PDO::PARAM_INT);

        if ($stmt_update->execute()) {
            $success_message = "Informations mises à jour avec succès.";
        } else {
            $error_message = "Erreur lors de la mise à jour des informations.";
        }
    }
}

$_SESSION['user_prenom'] = $prenom;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $password_error_message = "Tous les champs de mot de passe doivent être remplis.";
    } elseif (!password_verify($current_password, $user['user_password'])) {
        $password_error_message = "Le mot de passe actuel est incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $password_error_message = "Les nouveaux mots de passe ne correspondent pas.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Mise à jour du mot de passe dans la base de données
        $sql_update_password = "UPDATE users SET user_password = :user_password WHERE id = :id";
        $stmt_update_password = $pdo->prepare($sql_update_password);
        $stmt_update_password->bindParam(':user_password', $hashed_password);
        $stmt_update_password->bindParam(':id', $user_id, PDO::PARAM_INT);

        if ($stmt_update_password->execute()) {
            $password_success_message = "Mot de passe mis à jour avec succès.";
        } else {
            $password_error_message = "Erreur lors de la mise à jour du mot de passe.";
        }
    }
}



header("location: ../frontend/public/profil.php");
?>

