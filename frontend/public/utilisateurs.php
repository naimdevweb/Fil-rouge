<?php
require_once '../../db/connect_db.php';

try {
    $sql = "SELECT id, user_nom, user_prenom, user_email, user_tel, role_id FROM users WHERE role_id != 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body>
    <?php include('../../frontend/components/header.php'); ?>

    <main class="container mx-auto p-6">

        <h1 class="text-3xl font-semibold mb-6 text-center">Gestion des Utilisateurs</h1>

        <?php


        if (isset($_GET['sucess1'])) {
            echo "<p class='text-green-500 text-center'>L'utilisateur a été supprimé avec succès.</p>";
        } 
        ?>

       
        <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">Nom</th>
                    <th class="px-6 py-4 text-left">Prénom</th>
                    <th class="px-6 py-4 text-left">Téléphone</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-left">Rôle</th>
                    <th class="px-6 py-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($utilisateurs as $utilisateur) {
                    ?>
                    <tr class="border-b border-gray-200">
                        <td class="px-6 py-4"><?= htmlspecialchars($utilisateur['user_nom']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($utilisateur['user_prenom']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($utilisateur['user_tel']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($utilisateur['user_email']) ?></td>
                        <td class="px-6 py-4">
                            <?php

                            if ($utilisateur['role_id'] == 2) {
                                echo "Vendeur";
                            } elseif ($utilisateur['role_id'] == 3) {
                                echo "Client";
                            }
                           
                            ?>
                        </td>
                        <td class="px-6 py-4">
                            
                            <form action="../../backend/process_delete_users.php" method="POST" class="inline-block">
                                <input type="hidden" name="user_nom" value="<?= $utilisateur['id'] ?>">
                                <button type="submit" class="bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer class="pt-4">
        <?php include('../../frontend/components/footer.php'); ?>
    </footer>

</body>
</html>
