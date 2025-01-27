<?php
session_start();
require_once '../utils/autoload.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    
    $bookRepo = new BookRepository();
    // var_dump($_SESSION);
    // die();
    $id_seller = $_SESSION['user_id'];
    
    $titre = $_POST['titre'];
    $description_courte = $_POST['description_courte'];
    $description_longue = $_POST['description_longue'];
    $prix = str_replace(',', '.', $_POST['prix']); 
    $etat = $_POST['etat'];
    $genre = $_POST['genre_id'];
    $photo = $_FILES['photo'];

    // Vérifier si l'image a bien été téléchargée
    if ($photo['error'] === UPLOAD_ERR_OK) {
        // Dossier de téléchargement
        $uploadDir = '../assets/images/';
        $fileName = uniqid() . basename($photo['name']);
        $uploadPath = $uploadDir . $fileName;

        // Déplacer le fichier dans le dossier de destination
        if (move_uploaded_file($photo['tmp_name'], $uploadPath)) {
            $url_photo = $fileName; // Nom du fichier image

            try {
                // Insérer le livre dans la base de données
                $bookRepo->insertBook($id_seller, $titre, $description_courte, $description_longue, $prix, $etat, $genre, $url_photo);

                // Rediriger vers la page de profil après l'ajout
                $_SESSION['success_message'] = "Le livre a été ajouté avec succès.";
                header("Location: ../frontend/public/profil.php");
                exit();
            } catch (Exception $e) {
                $_SESSION['error_message'] = "Erreur lors de l'ajout du livre : " . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = "Erreur lors du téléchargement de l'image.";
        }
    } else {
        $_SESSION['error_message'] = "Erreur lors du téléchargement de l'image.";
    }
} else {
    $_SESSION['error_message'] = "Données invalides.";
    header("Location: ../frontend/public/profil.php");
    exit();
}
?>