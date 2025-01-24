<?php
session_start();
require_once '../../utils/autoload.php';

if($role != 1){
    header('Location: ../../index.php');
    exit();
}
$userRepo = new UserRepository();

try {
    $demandes = $userRepo->getVendeurs();
} catch (PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Vendeurs</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>

<body class="bg-gray-100">

    <?php include('../../frontend/components/header.php'); ?>

    <main class="max-w-7xl mx-auto p-8">
        <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Demandes de Vendeurs</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="p-3 text-gray-600">Nom</th>
                            <th class="p-3 text-gray-600">Prénom</th>
                            <th class="p-3 text-gray-600">Nom de l'Entreprise</th>
                            <th class="p-3 text-gray-600">Adresse de l'Entreprise</th>
                            <th class="p-3 text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($demandes)): ?>
                            <?php foreach ($demandes as $demande): ?>
                                <tr class="border-b">
                                    <td class="p-3 text-gray-800"><?= htmlspecialchars($demande['user_nom']) ?></td>
                                    <td class="p-3 text-gray-800"><?= htmlspecialchars($demande['user_prenom']) ?></td>
                                    <td class="p-3 text-gray-800"><?= htmlspecialchars($demande['nom_entreprise']) ?></td>
                                    <td class="p-3 text-gray-800"><?= htmlspecialchars($demande['adresse_entreprise']) ?></td>
                                    <td class="p-3 text-gray-800">
                                        <form action="../../backend/process_validerVendeur.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="user_id" value="<?= $demande['id'] ?>">
                                            <input type="hidden" name="action" value="valider">
                                            <button type="submit" class="text-green-600 hover:underline">Accepter</button>
                                        </form>
                                        <form action="../../backend/process_validerVendeur.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="user_id" value="<?= $demande['id'] ?>">
                                            <input type="hidden" name="action" value="refuser">
                                            <button type="submit" class="text-red-600 hover:underline">Refuser</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="p-3 text-gray-800">Aucune demande en attente.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <footer class="pt-4">
        <?php include('../../frontend/components/footer.php'); ?>
    </footer>

</body>

</html>