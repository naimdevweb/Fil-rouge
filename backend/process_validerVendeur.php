<?php 

require_once '../db/connect_db.php';
session_start();



$id = $_POST['user_id'];

try {
    $sql = "UPDATE users SET role_id = 2 WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);
    header('Location: ../frontend/public/ajout.php?success=1');
} catch (PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
}
