<?php
session_start();
require_once '../utils/autoload.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
  
    $bookRepo = new BookRepository();

    $book_id = $_POST['book_id'];

    try {
        // Récupérer les informations du livre
        $book = $bookRepo->getBookById($book_id);

        if ($book) {
            // Supprimer le fichier image associé
            $file_path = $book['photo_url'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            // Supprimer le livre de la base de données
            $bookRepo->deleteBook($book_id);

            $_SESSION['delete_message'] = "Le livre a été supprimé avec succès.";
        } else {
            $_SESSION['erreur_message'] = "Le livre n'existe pas.";
        }
    } catch (Exception $e) {
        $_SESSION['erreur_message'] = "Erreur lors de la suppression du livre : " . $e->getMessage();
    }

    header("Location: ../frontend/public/profil.php");
    exit();
} else {
    $_SESSION['erreur_message'] = "Données invalides.";
    header("Location: ../frontend/public/profil.php");
    exit();
}
?>