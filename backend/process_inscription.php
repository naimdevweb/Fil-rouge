<?php
require_once '../utils/autoload.php';
session_start();

try {
    $userRepo = new UserRepository();

    $email = $_POST['email'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel = $_POST['tel'];
    $mdp = $_POST['password'];
    $role = $_POST['role'];
    
    $hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);

    // Créer un nouvel utilisateur
    $user = new User( $nom, $prenom,$email, $role, $tel, $hashedPassword  );
    $userRepo->Create($user);

    // Récupérer l'ID de l'utilisateur inséré
    $user_id = $userRepo->getLastInsertId();

    // Vérifiez que l'ID de l'utilisateur est récupéré correctement
    if (!$user_id) {
        throw new Exception("Erreur lors de la récupération de l'ID de l'utilisateur.");
    }

    $_SESSION["user_id"] = $user_id;
    $_SESSION["user"] = $userRepo->getUserData($user_id);
    $userName = $_SESSION['user']->getNom();

    // Si le rôle est vendeur, insérer les informations du vendeur
    if ($role == 2) {
        $adresse_entreprise = $_POST['adresse_entreprise'];
        $nom_entreprise = $_POST['nom_entreprise'];

        if (!$adresse_entreprise || !$nom_entreprise) {
            $_SESSION["erreur"] = "Tous les champs sont obligatoires pour les vendeurs.";
            header("Location: ../frontend/public/inscription.php");
            exit();
        }

        $vendeur = new Vendeur($user_id, '', '', $nom_entreprise, $adresse_entreprise, null);
        $userRepo->insertVendeur($vendeur);
    }

    header("Location: ../frontend/public/profil.php");
    exit();
} catch (PDOException $e) {
    error_log("Erreur de base de données : " . $e->getMessage());
    $_SESSION["erreur"] = "Erreur de base de données.";
    header("Location: ../frontend/public/inscription.php");
    exit();
} catch (Exception $e) {
    error_log("Erreur : " . $e->getMessage());
    $_SESSION["erreur"] = $e->getMessage();
    header("Location: ../frontend/public/inscription.php");
    exit();
}