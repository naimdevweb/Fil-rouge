
<?php
session_start();
require_once '../db/connect_db.php';  
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_book']) && isset($_POST['book_id'])) {

$user_id = $_SESSION['user_id'];
$book_id = $_POST['book_id'];

try {
   
    $sql = "SELECT photo_url FROM livre WHERE id = :book_id AND id_seller = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($book) {
        
        $file_path = $book['photo_url'];
        if (file_exists($file_path)) {
            unlink($file_path); 
        }

        // Supprimer le livre de la base de données
        $delete_sql = "DELETE FROM livre WHERE id = :book_id AND id_seller = :user_id";
        $stmt_delete = $pdo->prepare($delete_sql);
        $stmt_delete->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt_delete->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_delete->execute();
      

        $_SESSION['delete_message'] = "Le livre a été supprimé avec succès.";
    } else {
        $_SESSION['erreur_message'] = "Le livre n'existe pas ou vous n'avez pas l'autorisation de le supprimer.";
    }
   

} catch (PDOException $e) {
    $_SESSION['erreur_message'] = "Erreur de base de données : " . $e->getMessage();
}


}

header("location: ../frontend/public/profil.php");
