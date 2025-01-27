
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion</title>
    <link rel="stylesheet" href="../../assets/css/output.css"> 
</head>
<body class="bg-gray-100">

<header class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-xl font-semibold">Admin - Gestion</h1>
        <nav>
            <a href="" class="px-4 hover:underline">Tableau de Bord</a>
            <a href="../../backend/process_deconnexion.php" class="px-4 hover:underline">Déconnexion</a>
            <a href="../public/ajout.php" class="px-4 hover:underline">Demande d'ajouts</a>
        </nav>
    </div>
</header>

<section class="bg-white rounded-lg shadow-lg p-6 mb-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Gestion des Utilisateurs</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
                <tr class="text-left border-b">
                    <th class="p-3 text-gray-600">Nom</th>
                    <th class="p-3 text-gray-600">Prénom</th>
                    <th class="p-3 text-gray-600">Email</th>
                    <th class="p-3 text-gray-600">Téléphone</th>
                    <th class="p-3 text-gray-600">Rôle</th>
                    <th class="p-3 text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <?php $roleName = $userRepo->getRoleNameById($user->getRoleId()); ?>
                    <tr class="border-b">
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($user->getNom()) ?></td>
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($user->getPrenom()) ?></td>
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($user->getEmail()) ?></td>
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($user->getTel()) ?></td>
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($roleName) ?></td>
                        <td class="p-3 text-gray-800">
                            <form action="../../backend/process_delete_users.php" method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?= $user->getId() ?>">
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>


    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Gestion des Livres</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
                <tr class="text-left border-b">
                    <th class="p-3 text-gray-600">Titre</th>
                    <th class="p-3 text-gray-600">Description Courte</th>
                    <th class="p-3 text-gray-600">Description Longue</th>
                    <th class="p-3 text-gray-600">Prix</th>
                    <th class="p-3 text-gray-600">Vendeur</th>
                    <th class="p-3 text-gray-600">Actions</th>
                    <th class="p-3 text-gray-600">Image</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livres as $livre): ?>
                <tr class="border-b">
                    <td class="p-3 text-gray-800"><?= htmlspecialchars($livre->getTitre()) ?></td>
                    <td class="p-3 text-gray-800"><?= htmlspecialchars($livre->getDescriptionCourte()) ?></td>
                    <td class="p-3 text-gray-800"><?= htmlspecialchars($livre->getDescriptionLongue()) ?></td>
                    <td class="p-3 text-gray-800"><?= htmlspecialchars($livre->getPrix()) ?> €</td>
                    <td class="p-3 text-gray-800"><?= htmlspecialchars($livre->getSellerNom()) ?> <?= htmlspecialchars($livre->getSellerPrenom()) ?></td>
                    <td class="p-3 text-gray-800">
                        <form action="../../backend/process_delete.php" method="POST" style="display: inline;">
                            <input type="hidden" name="book_id" value="<?= $livre->getId() ?>">
                            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                    </td>
                    <td class="p-3 text-gray-800">
                        <img src="../../assets/images/<?= htmlspecialchars($livre->getPhotoUrl()); ?>" alt="<?= htmlspecialchars($livre->getTitre()); ?>" class="w-full object-cover h-48">
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

</body>
</html>