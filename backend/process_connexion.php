<?php
session_start();
require_once '../db/connect_db.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_email']) && isset($_POST['user_mdp'])) {
        $email = htmlspecialchars(trim($_POST['user_email']));  
        $password = trim($_POST['user_mdp']);  

        if (empty($email) || empty($password)) {
            $_SESSION["mdp"] = "Erreur : Tous les champs sont obligatoires.";
            header("Location: ../frontend/public/connexion.php");
            exit;
        }

        try {
            $sql = "SELECT * FROM users WHERE user_email = :email";  
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC); 

           
            if ($user) {
             
                if (password_verify($password, $user['user_mdp'])) {
                  
                    $_SESSION['user_email'] = $user['user_email'];  
                    $_SESSION["user_id"] = $user["id"]; 
                    $_SESSION["user_prenom"] = $user["user_prenom"]; // Assurez-vous que cette colonne existe

                    header("Location: ../frontend/public/profil.php");  
                    exit;
                } else {
                    $_SESSION["mdp"] = "Email ou mot de passe incorrect.";
                    header("Location: ../frontend/public/connexion.php");  
                    exit;
                }
            } else {
                $_SESSION["mdp"] = "Aucun utilisateur trouvé avec cet email.";
                header("Location: ../frontend/public/connexion.php");  
                exit;
            }

        } catch (PDOException $error) {
            $_SESSION["mdp"] = "Erreur lors de la requête : " . $error->getMessage();
            header("Location: ../frontend/public/connexion.php");  
            exit;
        }
    }
} else {
    header("Location: ../../frontend/public/connexion.php");
    exit;
}
?>
