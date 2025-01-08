<?php
session_start();
require_once '../db/connect_db.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo_url'])) {

   
    $id_seller = $_SESSION['user_id']; 
    $titre = $_POST['titre']; 
    $description_courte = $_POST['description_courte']; 
    $description_longue = $_POST['description_longue']; 
    $prix = $_POST['prix']; 
    $etat = $_POST['etat']; 
    $genre = $_POST['genre']; 
    $photo = $_FILES['photo_url']; 


    var_dump($photo);
    var_dump($prix);
    var_dump($etat);
    var_dump($titre);
    var_dump($description_courte);
    var_dump($description_longue);
    var_dump($id_seller);
    die();
    
    // Vérifier si l'image a bien été téléchargée
    if ($photo['error'] === UPLOAD_ERR_OK) {
        
        // Dossier de téléchargement
        $uploadDir = '../../assets/images/'; 
        $fileName = uniqid() . basename($photo['name']); // Crée un nom unique
        $uploadPath = $uploadDir . $fileName; 
        
        // Déplacer le fichier dans le dossier de destination
        if (move_uploaded_file($photo['tmp_name'], $uploadPath)) {
            $url_photo = $uploadPath; // URL de l'image

            try {
                // Insertion dans la base de données
                $sql = "INSERT INTO livre (id_seller, titre, description_courte, description_longue, prix, etat_id, genre_id, photo_url) 
                        VALUES (:id_seller, :titre, :description_courte, :description_longue, :prix, :etat_id, :genre_id, :photo_url)";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_seller', $id_seller, PDO::PARAM_INT); // ID du vendeur
                $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
                $stmt->bindParam(':description_courte', $description_courte, PDO::PARAM_STR);
                $stmt->bindParam(':description_longue', $description_longue, PDO::PARAM_STR);
                $stmt->bindParam(':prix', $prix, PDO::PARAM_INT);
                $stmt->bindParam(':etat_id', $etat, PDO::PARAM_INT);
                $stmt->bindParam(':genre_id', $genre, PDO::PARAM_INT);
                $stmt->bindParam(':photo_url', $url_photo, PDO::PARAM_STR);


               

                // Exécuter la requête d'insertion
                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Livre ajouté avec succès.";
                } else {
                    $_SESSION['error_message'] = "Erreur lors de l'ajout du livre.";
                }
            } catch (PDOException $e) {
                $_SESSION['error_message'] = "Erreur de base de données : " . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = "Erreur lors du téléchargement de l'image.";
        }
    } else {
        $_SESSION['error_message'] = "Erreur d'upload d'image.";
    }
    
    // Redirection après l'ajout
    header('Location: ../frontend/public/profil.php');
    exit;
}
