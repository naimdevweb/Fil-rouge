<?php
require_once '../../utils/autoload.php';
session_start();

$userRepo = new UserRepository();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit();
}

$user = $userRepo->getUserData($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_nom = $_POST['user_nom'];
    $user_prenom = $_POST['user_prenom'];
    $user_email = $_POST['user_email'];
    $user_tel = $_POST['user_tel'];
    $user_password = $_POST['user_password'];

    if ($user_password) {
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);
    } else {
        $user_password = $user->getPassword();
    }

    $updated = $userRepo->updateUser($_SESSION['user_id'], $user_nom, $user_prenom, $user_email, $user_tel, $user_password);

    if ($updated) {
        $success_message = "Profil mis à jour avec succès.";
    } else {
        $error_message = "Erreur lors de la mise à jour du profil.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../assets/js/script.js"></script>
    <link rel="stylesheet" href="../../assets/css/output.css">
    <title>Modifier Profil</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <main class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Modifier Profil</h2>
        
        <?php if (isset($error_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <p class="text-sm"><?= htmlspecialchars($error_message) ?></p>
            </div>
        <?php endif; ?>
        
        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <p class="text-sm"><?= htmlspecialchars($success_message) ?></p>
            </div>
        <?php endif; ?>
        
        <form action="modifier.php" method="POST" class="space-y-4">
            <div>
                <label for="user_nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="user_nom" id="user_nom" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary" value="<?= htmlspecialchars($user->getNom()) ?>" required>
            </div>
            
            <div>
                <label for="user_prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" name="user_prenom" id="user_prenom" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary" value="<?= htmlspecialchars($user->getPrenom()) ?>" required>
            </div>
            
            <div>
                <label for="user_email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="user_email" id="user_email" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
            </div>
            
            <div>
                <label for="user_tel" class="block text-sm font-medium text-gray-700">Téléphone</label>
                <input type="text" name="user_tel" id="user_tel" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary" value="<?= htmlspecialchars($user->getTel()) ?>" required>
            </div>
            
            <div>
                <label for="user_password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                <input type="password" name="user_password" id="user_password" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
            </div>
            
            <div class="pt-4">
                <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Mettre à jour
                </button>
            </div>
        </form>
    </main>

</body>
