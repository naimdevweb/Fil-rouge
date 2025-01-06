<?php
session_start();
require_once '../db/connect_db.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  
    $email = htmlspecialchars(trim($_POST['user_email']));
    $nom = htmlspecialchars(trim($_POST['user_nom']));
    $prenom = htmlspecialchars(trim($_POST['user_prenom']));
    $tel = htmlspecialchars(trim($_POST['user_tel']));
    $password = trim($_POST['user_mdp']);

    // Vérification que tous les champs sont remplis
    if (empty($email) || empty($nom) || empty($prenom) || empty($tel) || empty($password)) {
        $_SESSION["erreur"] = "Erreur : Tous les champs sont obligatoires.";
        header("Location: ../frontend/public/inscription.php");
        exit;
    }

    // Vérification si l'email est déjà utilisé
    try {
        $sql = "SELECT * FROM users WHERE user_email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
       
        $stmt->execute();

        // Si l'email ou le pseudo existe déjà
        if ($stmt->rowCount() > 0) {
            $_SESSION["erreur"] = "Erreur : L'email ou le '$nom' est déjà utilisé.";
            header("Location: ../frontend/public/inscription.php");
            exit;
        }

        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertion dans la base de données
        $sql = "INSERT INTO users (user_email, user_nom, user_prenom, user_tel,  user_mdp,role) 
                VALUES (:email, :nom, :prenom, :tel,  :password,:role)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':tel' => $tel,
            ':password' => $hashedPassword,
            ':role' => 3,

        ]);

        // Récupération de l'ID de l'utilisateur et mise en session
        $_SESSION["user"] = $nom;
        $_SESSION["user_id"] = $pdo->lastInsertId();

        // Redirection après l'inscription
        header("Location: ../index.php");
        exit;

    } catch (PDOException $error) {
        $_SESSION["erreur"] = "Erreur lors de la requête : " . $error->getMessage();
        header("Location: ../frontend/public/inscription.php");
        exit;
    }

}
?>
