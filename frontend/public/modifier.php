<?php
session_start();
require_once '../../db/connect_db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../connexion.php");
    exit();
}


$user_id = $_SESSION['user_id'];


$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();


if ($stmt->rowCount() == 0) {
   
    echo "Utilisateur introuvable.";
    exit();
}


$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_info'])) {
    $nom = $_POST['user_nom'];
    $prenom = $_POST['user_prenom'];
    $email = $_POST['user_email'];
    $tel = $_POST['user_tel'];

    if (empty($nom) || empty($prenom) || empty($email) || empty($tel)) {
        $error_message = "Tous les champs doivent être remplis.";
    } else {
        $sql_update = "UPDATE users SET user_nom = :user_nom, user_prenom = :user_prenom, user_email = :user_email, user_tel = :user_tel WHERE id = :id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':user_nom', $nom);
        $stmt_update->bindParam(':user_prenom', $prenom);
        $stmt_update->bindParam(':user_email', $email);
        $stmt_update->bindParam(':user_tel', $tel);
        $stmt_update->bindParam(':id', $user_id, PDO::PARAM_INT);

        if ($stmt_update->execute()) {
            $success_message = "Informations mises à jour avec succès.";
        } else {
            $error_message = "Erreur lors de la mise à jour des informations.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Profil</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body class="bg-gray-100">

<main>
    <?php include('../../frontend/components/header.php'); ?>

    <!-- Affichage des messages d'erreur ou de succès -->
    <?php if (!empty($error_message)) : ?>
        <div class="text-red-600 text-center"><?= htmlspecialchars($error_message); ?></div>
    <?php elseif (!empty($success_message)) : ?>
        <div class="text-green-600 text-center"><?= htmlspecialchars($success_message); ?></div>
    <?php endif; ?>

    <!-- Formulaire pour modifier les informations de l'utilisateur -->
    <section class="mt-8">
        <h2 class="text-2xl font-bold text-center">Modifier mon profil</h2>
        <form action="../../backend/process_modifier.php" method="POST" class="space-y-6 px-4 py-4">
            <div class="flex flex-wrap gap-4">
                <div class="w-full sm:w-[48%]">
                    <label for="user_nom" class="block">Nom</label>
                    <input type="text" name="user_nom" id="user_nom" value="<?= htmlspecialchars($user['user_nom']); ?>" class="w-full p-2 border border-gray-300 rounded-md mt-1">
                </div>
                <div class="w-full sm:w-[48%]">
                    <label for="user_prenom" class="block">Prénom</label>
                    <input type="text" name="user_prenom" id="user_prenom" value="<?= htmlspecialchars($user['user_prenom']); ?>" class="w-full p-2 border border-gray-300 rounded-md mt-1">
                </div>
                <div class="w-full sm:w-[48%]">
                    <label for="user_email" class="block">Email</label>
                    <input type="email" name="user_email" id="user_email" value="<?= htmlspecialchars($user['user_email']); ?>" class="w-full p-2 border border-gray-300 rounded-md mt-1">
                </div>
                <div class="w-full sm:w-[48%]">
                    <label for="user_tel" class="block">Téléphone</label>
                    <input type="tel" name="user_tel" id="user_tel" value="<?= htmlspecialchars($user['user_tel']); ?>" class="w-full p-2 border border-gray-300 rounded-md mt-1">
                </div>
            </div>

            <div class="flex flex-wrap gap-4 justify-center sm:justify-start">
                <button type="reset" class="w-full sm:w-auto bg-gray-200 text-gray-800 py-2 px-4 rounded-md">Annuler</button>
                <button type="submit" name="save_info" class="w-full sm:w-auto bg-red-600 text-white py-2 px-4 rounded-md">Sauvegarder</button>
            </div>

            <h3 class="text-xl font-semibold mt-8">Changer le mot de passe</h3>
            <div class="flex flex-wrap gap-4">
                <div class="w-full">
                    <label for="current_password" class="block">Mot de passe actuel</label>
                    <input type="password" name="current_password" id="current_password" class="w-full p-2 border border-gray-300 rounded-md mt-1">
                </div>
                <div class="w-full">
                    <label for="new_password" class="block">Nouveau mot de passe</label>
                    <input type="password" name="new_password" id="new_password" class="w-full p-2 border border-gray-300 rounded-md mt-1">
                </div>
                <div class="w-full">
                    <label for="confirm_password" class="block">Confirmer le mot de passe</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="w-full p-2 border border-gray-300 rounded-md mt-1">
                </div>
            </div>

            <div class="flex flex-wrap gap-4 justify-center sm:justify-start">
                <button type="reset" class="w-full sm:w-auto bg-gray-200 text-gray-800 py-2 px-4 rounded-md">Annuler</button>
                <button type="submit" name="save_info" class="w-full sm:w-auto bg-gray-600 text-white py-2 px-4 rounded-md">Sauvegarder</button>
                <button type="submit" name="change_password" class="w-full sm:w-auto bg-blue-600 text-white py-2 px-4 rounded-md">Changer le mot de passe</button>
            </div>
        </form>
    </section>
</main>

<footer class="pt-4">
    <?php include('../../frontend/components/footer.php'); ?>
</footer>

</body>
</html>
