<?php
require_once '../../db/connect_db.php';

try {
    $sql = "SELECT users.user_nom, users.id, users.user_prenom, vendeur.adresse_entreprise, vendeur.nom_entreprise
            FROM `users`
            INNER JOIN vendeur ON vendeur.user_id = users.id
            WHERE role_id = 3";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Demandes de Vendeurs</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body class="bg-gray-100">

<?php include('../../frontend/components/header.php'); ?>

<main class="max-w-7xl mx-auto p-8">

    <!-- Messages de succès ou d'erreur -->
    <?php 
    if (isset($_GET['success'])) {
        echo "<div class='text-green-500 text-center p-4 bg-green-100 rounded-lg mb-6'>La demande a bien été validée</div>";
    }
    if (isset($_GET['delete'])) {
        echo "<div class='text-red-500 text-center p-4 bg-red-100 rounded-lg mb-6'>La demande a bien été refusée</div>";
    }
    ?>

    <h1 class="text-3xl font-semibold text-gray-800 mb-6">Gestion des demandes de validation des vendeurs</h1>

    <!-- Liste des demandes -->
    <?php foreach ($demandes as $demande) {
        

        
        ?>

        

        <article class="flex flex-col sm:flex-row sm:space-x-6 bg-white p-6 rounded-lg shadow-lg mb-6">
            <!-- Informations Utilisateur -->
            <div class="flex flex-col w-full sm:w-[30%] mb-4 sm:mb-0">
                <p class="text-gray-700 font-semibold text-sm">Nom : <?= htmlspecialchars($demande['user_nom']) ?></p>
                <p class="text-gray-700 font-semibold text-sm">Prénom : <?= htmlspecialchars($demande['user_prenom']) ?></p>
            </div>

            <!-- Informations sur l'entreprise -->
            <div class="flex flex-col w-full sm:w-[30%] mb-4 sm:mb-0">
                <p class="text-gray-700 font-semibold text-sm">Adresse de l'entreprise : <?= htmlspecialchars($demande['adresse_entreprise']) ?></p>
                <p class="text-gray-700 font-semibold text-sm">Nom de l'entreprise : <?= htmlspecialchars($demande['nom_entreprise']) ?></p>
            </div>

            <!-- Actions de validation et refus -->
            <div class="flex flex-col w-full sm:w-[30%] space-y-4">
                <form action="../../backend/process_validerVendeur.php" method="post" class="flex flex-col items-start w-full">
                    <input name="user_id" value="<?= $demande['id'] ?>" type="hidden">
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-blue-600 transition duration-200 w-full sm:w-auto">Valider</button>
                </form>

                <form action="../../backend/process_deleteVendeur.php" method="post" class="flex flex-col items-start w-full">
                    <input name="user_id" value="<?= $demande['id'] ?>" type="hidden">
                    <button type="submit" class="bg-red-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-red-600 transition duration-200 w-full sm:w-auto">Refuser</button>
                </form>
            </div>
        </article>

    <?php } ?>

</main>

<footer class="pt-4">
    <?php include('../../frontend/components/footer.php'); ?>
</footer>

</body>
</html>
