<?php
session_start();
require_once '../../db/connect_db.php'; 

$sql_genre = "SELECT id, nom_genre FROM genre"; 
$stmt_genre = $pdo->prepare($sql_genre);
$stmt_genre->execute();
$genres = $stmt_genre->fetchAll(PDO::FETCH_ASSOC);


$sql_etat = "SELECT id, etat FROM etat"; 
$stmt_etat = $pdo->prepare($sql_etat);
$stmt_etat->execute();
$etats = $stmt_etat->fetchAll(PDO::FETCH_ASSOC);



if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/public/connexion.php"); 
    exit();
}

$user_id = $_SESSION['user_id']; 

// Récupérer les livres de l'utilisateur
$sql = "SELECT photo_url, description_courte, description_longue, prix, titre, etat_id, genre_id, id_seller, id FROM livre WHERE id_seller = :id;";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier s'il y a un message de succès ou d'erreur
if (isset($_SESSION['success_message'])) {
    echo "<div class='success-message'>{$_SESSION['success_message']}</div>";
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo "<div class='error-message'>{$_SESSION['error_message']}</div>";
    unset($_SESSION['error_message']);
}

if (isset($_SESSION['user_prenom'])) {
    $user_prenom = $_SESSION['user_prenom'];
} else {
    $user_prenom = "Inconnu"; 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="../../assets/css/output.css"> <!-- Assurez-vous que votre fichier CSS est bien lié -->
</head>
<body class="bg-gray-100">

<?php include('../../frontend/components/header.php'); ?>

<main class="max-w-7xl mx-auto p-8">
    <!-- Profil Utilisateur -->
    <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="flex items-center space-x-6">
            <img src="https://via.placeholder.com/150" alt="Avatar" class="w-32 h-32 rounded-full border-4 border-gray-200">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800"><?= htmlspecialchars($user_prenom) ?></h1>
                <p class="text-gray-600">Membre depuis janvier 2023</p>
                <p class="text-gray-700 mt-2">Bonjour ! Je suis passionné de littérature et j'aime partager mes livres avec d'autres lecteurs. N'hésitez pas à me contacter pour des échanges ou des recommandations.</p>
            </div>
        </div>
    </section>

    <!-- Liste des Annonces -->
    <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Mes Annonces</h2>
        <?php if (count($livres) > 0): ?>
            <div class="space-y-4">
                <?php foreach ($livres as $livre): ?>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($livre['titre']) ?></h3>
                        <p class="text-gray-600 mt-2"><?= htmlspecialchars($livre['description_longue']) ?></p>
                        <p class="text-gray-600 mt-2"><?= htmlspecialchars($livre['description_courte']) ?></p>
                        <span class="text-gray-700 font-bold mt-2 block">Prix : <?= htmlspecialchars($livre['prix']) ?> €</span>
                        <span class="text-gray-700 font-bold mt-2 block">Etat : <?= htmlspecialchars($livre['etat_id']) ?></span>
                        <img src="<?= htmlspecialchars($livre['photo_url']) ?>" alt="Image du Livre" class="w-full mt-4 rounded-lg">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">Vous n'avez pas encore ajouté d'annonces.</p>
        <?php endif; ?>
    </section>

    <!-- Ajouter un Livre -->
    <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ajouter un Livre</h2>
        <form action="../../backend/process_profil.php" method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="titre" class="block text-gray-700">Titre du Livre</label>
                <input type="text" name="titre" id="titre" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="description_longue" class="block text-gray-700">Description longue</label>
                <textarea name="description_longue" id="description_longue" rows="4" class="w-full p-3 border border-gray-300 rounded-lg" required></textarea>
            </div>
            <div>
                <label for="description_courte" class="block text-gray-700">Description courte</label>
                <textarea name="description_courte" id="description_courte" rows="4" class="w-full p-3 border border-gray-300 rounded-lg" required></textarea>
            </div>
          
            <div>
                <label for="prix" class="block text-gray-700">Prix</label>
                <input type="number" name="prix" id="prix" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="photo_url" class="block text-gray-700">Image du Livre</label>
                <input type="file" name="photo_url" id="photo_url" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
    <label for="genre" class="block text-sm font-medium text-gray-700">Le genre du livre</label>
    <select name="genre" id="genre_id" 
        class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 bg-white">
        <?php 
        foreach ($genres as $genre) {
            echo "<option value='".$genre['id']."'>".$genre['nom_genre']."</option>";
        }
        ?>
    </select>
</div>

<div class="mb-4">
    <label for="etat" class="block text-sm font-medium text-gray-700">L'état de votre livre</label>
    <select name="etat" id="etat_id" 
        class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 bg-white">
        <?php 
        foreach ($etats as $etat) {
            echo "<option value='".$etat['id']."'>".$etat['etat']."</option>";
        }
        ?>
    </select>
</div>

            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition duration-300">Ajouter le Livre</button>
        </form>
    </section>
</main>

<?php include('../../frontend/components/footer.php'); ?>

</body>
</html>
