<?php



session_start();


session_unset();


session_destroy();


header("Location: ../frontend/public/connexion.php");
exit();
?>
