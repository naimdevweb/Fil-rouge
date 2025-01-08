<?php 

require_once '../db/connect_db.php';
session_start();



$id = $_POST['user_nom'];


try {
    $sql = "DELETE FROM users  WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);
    header('Location: ../frontend/public/utilisateurs.php?sucess1=1');
} catch (PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
}
