<?php
session_start();
require_once '../../utils/autoload.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit();
}

$userRepo = new UserRepository();
$user = $userRepo->getUserData($_SESSION['user_id']);
$role = $user->getRoleId();

if ($role != 1) {
    header('Location: ../../index.php');
    exit();
}

try {
    $demandesEnAttente = $userRepo->getVendeursEnAttente();
    $demandesTraitees = $userRepo->getVendeursTraites();
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
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Demandes en attente</h1>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg mb-8">
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
            <?php if (!empty($demandesEnAttente)): ?>
                <?php foreach ($demandesEnAttente as $demande): ?>
                    <tr class="border-b">
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($demande->getNom()) ?></td>
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($demande->getPrenom()) ?></td>
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($demande->getNomEntreprise()) ?></td>
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($demande->getAdresseEntreprise()) ?></td>
                        <td class="p-3 text-gray-800">
                            <form action="../../backend/process_validerVendeur.php" method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?= $demande->getId() ?>">
                                <input type="hidden" name="action" value="valider">
                                <button type="submit" class="text-green-600 hover:underline">Accepter</button>
                            </form>
                            <form action="../../backend/process_validerVendeur.php" method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?= $demande->getId() ?>">
                                <input type="hidden" name="action" value="refuser">
                                <button type="submit" class="text-red-600 hover:underline">Refuser</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="p-3 text-center text-gray-600">Aucune demande de vendeur trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Demandes traitées</h1>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
        <thead>
            <tr class="text-left border-b">
                <th class="p-3 text-gray-600">Nom</th>
                <th class="p-3 text-gray-600">Prénom</th>
                <th class="p-3 text-gray-600">Nom de l'Entreprise</th>
                <th class="p-3 text-gray-600">Adresse de l'Entreprise</th>
                <th class="p-3 text-gray-600">Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($demandesTraitees)): ?>
                <?php foreach ($demandesTraitees as $demande): ?>
                    <tr class="border-b">
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($demande->getNom()) ?></td>
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($demande->getPrenom()) ?></td>
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($demande->getNomEntreprise()) ?></td>
                        <td class="p-3 text-gray-800"><?= htmlspecialchars($demande->getAdresseEntreprise()) ?></td>
                        <td class="p-3 text-gray-800"><?= $demande->isApproved() ? 'Acceptée' : 'Refusée' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="p-3 text-center text-gray-600">Aucune demande traitée trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>