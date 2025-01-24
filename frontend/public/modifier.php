<?php
session_start();
require_once '../../utils/autoload.php';

$userRepo = new UserRepository();
$user_id = $_SESSION['user_id'];
$userData = $userRepo->getUserData($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['user_nom'];
    $prenom = $_POST['user_prenom'];
    $email = $_POST['user_email'];
    $tel = $_POST['user_tel'];
    $password = $_POST['user_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($nom) || empty($prenom) || empty($email) || empty($tel)) {
        $error_message = "Tous les champs doivent être remplis.";
    } elseif (!empty($password) && $password !== $confirm_password) {
        $error_message = "Les mots de passe ne correspondent pas.";
    } else {
        $userRepo->updateUser($user_id, $nom, $prenom, $email, $tel, $password);
        $success_message = "Informations mises à jour avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Profil</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body class="bg-gray-100">

<?php include('../../frontend/components/header.php'); ?>

<main class="max-w-7xl mx-auto p-8">
    <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Modifier Profil</h2>
        <?php if (isset($error_message)): ?>
            <p class="text-red-500"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <p class="text-green-500"><?= htmlspecialchars($success_message) ?></p>
        <?php endif; ?>
        <form action="modifier.php" method="POST">
            <div class="mb-4">
                <label for="user_nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="user_nom" id="user_nom" class="mt-1 block w-full" value="<?= htmlspecialchars($userData['user_nom']) ?>" required>
            </div>
            <div class="mb-4">
                <label for="user_prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" name="user_prenom" id="user_prenom" class="mt-1 block w-full" value="<?= htmlspecialchars($userData['user_prenom']) ?>" required>
            </div>
            <div class="mb-4">
                <label for="user_email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="user_email" id="user_email" class="mt-1 block w-full" value="<?= htmlspecialchars($userData['user_email']) ?>" required>
            </div>
            <div class="mb-4">
                <label for="user_tel" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input type="text" name="user_tel" id="user_tel" class="mt-1 block w-full" value="<?= htmlspecialchars($userData['user_tel']) ?>" required>
            </div>
            <div class="mb-4">
                <label for="user_password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                <input type="password" name="user_password" id="user_password" class="mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                <input type="password" name="confirm_password" id="confirm_password" class="mt-1 block w-full">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour</button>
            </div>
        </form>
    </section>
</main>
</body>
</html>