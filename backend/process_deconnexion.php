<?php



session_start();

// Supprimer toutes les variables de session
session_unset();


session_destroy();


header("Location: ../frontend/public/connexion.php");
exit();
?>
