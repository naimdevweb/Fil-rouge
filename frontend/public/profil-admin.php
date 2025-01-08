<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Compte</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
    <script type="module" src="../../assets/js/script.js" defer></script>
</head>
<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-semibold">Admin - Gestion</h1>
            <nav>
                <a href="/admin-dashboard.php" class="px-4 hover:underline">Tableau de Bord</a>
                <a href="/admin-users.php" class="px-4 hover:underline">Utilisateurs</a>
                <a href="/admin-books.php" class="px-4 hover:underline">Livres</a>
                <a href="/deconnexion.php" class="px-4 hover:underline">Déconnexion</a>
            </nav>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="container mx-auto p-8 mt-8">
    <?php
session_start();
require_once '../../db/connect_db.php'; // Connexion à la base de données

// Vérifiez si l'utilisateur est connecté et a le rôle administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header("Location: /login.php"); // Redirige vers la page de connexion si l'utilisateur n'est pas un administrateur
    exit();
}

// Récupérer les utilisateurs de la base de données
$sql = "SELECT id, user_nom, user_email FROM users"; // Remplacez 'users' par le nom réel de votre table
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupère tous les utilisateurs dans un tableau
?>

        <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Gérer les Utilisateurs</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="p-3 text-gray-600">Nom</th>
                            <th class="p-3 text-gray-600">Email</th>
                            <th class="p-3 text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr class="border-b">
                            <td class="p-3 text-gray-800"><?= htmlspecialchars($user['user_nom']) ?></td>
                            <td class="p-3 text-gray-800"><?= htmlspecialchars($user['user_email']) ?></td>
                            <td class="p-3 text-gray-800">
                                <!-- Supprimer un utilisateur -->
                                <form action="delete_user.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

</body>
</html>
