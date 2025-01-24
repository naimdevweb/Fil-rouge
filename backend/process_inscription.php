<?php
require_once '../utils/autoload.php';
session_start();

$userRepo = new UserRepository();

$email = $_POST['email'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$tel = $_POST['tel'];
$password = $_POST['password'];
$role = $_POST['role'];

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

try {
    $user = new User($nom, $prenom, $email, $role, $tel, $hashedPassword);
    $userRepo->create($user);

    // Récupérer l'ID de l'utilisateur inséré
    $user_id = $userRepo->getLastInsertId();

    $_SESSION["user"] = $userRepo->getUserData($user_id);
    $userName = $_SESSION['user']->getNom();

    // Si le rôle est vendeur, insérer les informations du vendeur
    if ($role == 2) {
        $adresse_entreprise = $_POST['adresse_entreprise'];
        $nom_entreprise = $_POST['nom_entreprise'];

        if (!$adresse_entreprise || !$nom_entreprise) {
            $_SESSION["erreur"] = "Tous les champs sont obligatoires pour les vendeurs.";
            header("Location: ../frontend/public/inscription.php");
            exit;
        }

        $vendeur = new Vendeur($user_id, $nom_entreprise, $adresse_entreprise);
        $userRepo->insertVendeur($vendeur);
    }

    header("Location: ../frontend/public/profil.php");
    exit;
} catch (PDOException $e) {
    header("Location: ../frontend/public/inscription.php");
    exit;
}