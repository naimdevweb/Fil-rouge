<?php 

require_once '../db/connect_db.php';
session_start();



$id = $_POST['user_id'];

try {
    $sql = "DELETE FROM vendeur  WHERE user_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);
    header('Location: ../frontend/public/ajout.php?delete=1');
} catch (PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
}
