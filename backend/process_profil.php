<?php
session_start();
require_once '../utils/autoload.php';

define('MAX_FILE_SIZE', 2 * 1024 * 1024); // 2MB
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    
    $bookRepo = new BookRepository();
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
        // Vérifier la taille du fichier
        if ($photo['size'] > MAX_FILE_SIZE) {
            $_SESSION['erreur_message'] = "La taille du fichier ne doit pas dépasser 2MB.";
            header("Location: ../frontend/public/profil.php");
            exit();
        }

        // Vérifier le type de fichier
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($photo['tmp_name']);
        if (!in_array($mimeType, $allowedMimeTypes)) {
            $_SESSION['erreur_message'] = "Seuls les fichiers JPEG, PNG et GIF sont autorisés.";
            header("Location: ../frontend/public/profil.php");
            exit();
        }

        // Dossier de téléchargement
        $uploadDir = '../assets/images/';
        $fileName = uniqid() . basename($photo['name']);
        $uploadPath = $uploadDir . $fileName;

        // Déplacer le fichier dans le dossier de destination
        if (move_uploaded_file($photo['tmp_name'], $uploadPath)) {
            $url_photo = $fileName;
            $bookRepo->insertBook($id_seller, $titre, $description_courte, $description_longue, $prix, $etat, $genre, $url_photo);

            // Rediriger vers la page de profil après l'ajout
            $_SESSION['success_message'] = "Le livre a été ajouté avec succès.";
            header("Location: ../frontend/public/profil.php");
            exit();
        } else {
            $_SESSION['erreur_message'] = "Erreur lors du téléchargement de l'image.";
            header("Location: ../frontend/public/profil.php");
            exit();
        }
    } else {
        $_SESSION['erreur_message'] = "Erreur lors du téléchargement de l'image.";
        header("Location: ../frontend/public/profil.php");
        exit();
    }
} else {
    $_SESSION['erreur_message'] = "Données invalides.";
    header("Location: ../frontend/public/profil.php");
    exit();
}
