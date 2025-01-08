<?php
session_start();
require_once '../../db/connect_db.php'; 


// Vérifier si l'ID du livre est passé via POST
if (isset($_POST['delete_book']) && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    // Préparer la requête SQL pour supprimer le livre
    $sql_delete = "DELETE FROM livre WHERE id = :book_id";
    $stmt = $pdo->prepare($sql_delete);
    
    // Lier l'ID du livre à la requête
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    
}



// Récupérer les genres
$sql_genre = "SELECT id, nom_genre FROM genre"; 
$stmt_genre = $pdo->prepare($sql_genre);
$stmt_genre->execute();
$genres = $stmt_genre->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les états
$sql_etat = "SELECT id, etat FROM etat"; 
$stmt_etat = $pdo->prepare($sql_etat);
$stmt_etat->execute();
$etats = $stmt_etat->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/public/connexion.php"); 
    exit();
}

$user_id = $_SESSION['user_id']; 

$sql = "SELECT l.photo_url, l.description_courte, l.description_longue, l.prix, l.titre, e.etat, g.nom_genre, l.id
        FROM livre l
        LEFT JOIN etat e ON l.etat_id = e.id
        LEFT JOIN genre g ON l.genre_id = g.id
        WHERE l.id_seller = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Message de succès ou d'erreur
if (isset($_SESSION['success_message'])) {
    echo "<div class='success-message'>{$_SESSION['success_message']}</div>";
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo "<div class='error-message'>{$_SESSION['error_message']}</div>";
    unset($_SESSION['error_message']);
}

// Récupérer le prénom de l'utilisateur
if (isset($_SESSION['user_prenom'])) {
    $user_prenom = $_SESSION['user_prenom'];
} else {
    $user_prenom = "Inconnu"; 
}



try {
    $sql = "SELECT role_id FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $role_id = $stmt->fetch(PDO::FETCH_ASSOC);

    

    // if ($role_id['role_id'] == 1) {
    //     header("Location: ../../frontend/public/admin.php");
    //     exit();
    // }

} catch (\Throwable $th) {
    //throw $th;
}




?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="../../assets/css/output.css"> 
</head>
<body class="bg-gray-100">

<?php include('../../frontend/components/header.php'); ?>

<main class="max-w-7xl mx-auto p-8">
<?php
// Vérifier si des messages de succès ou d'erreur existent
if (isset($_SESSION['delete_message'])) {
    echo "<div class='delete-message'>{$_SESSION['delete_message']}</div>";
    unset($_SESSION['delete_message']);
}

if (isset($_SESSION['erreur_message'])) {
    echo "<div class='erreur-message'>{$_SESSION['erreur_message']}</div>";
    unset($_SESSION['erreur_message']);
}
?>


    <!-- Profil Utilisateur -->
    <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="flex items-center space-x-6">
            <img src="https://via.placeholder.com/150" alt="Avatar" class="w-32 h-32 rounded-full border-4 border-gray-200">
            <div>
                <!-- Affichage du prénom de l'utilisateur -->
                <h1 class="text-3xl font-semibold text-gray-800"><?= htmlspecialchars($user_prenom);?></h1>
                <p class="text-gray-700 mt-2">Bonjour ! Je suis passionné de littérature et j'aime partager mes livres avec d'autres lecteurs. N'hésitez pas à me contacter pour des échanges ou des recommandations.</p>
                
                <a href="./modifier.php" class="mt-4 inline-block bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-300">Modifier le Profil</a>
                <form action="../../backend/process_deconnexion.php" method="POST">
    <button type="submit" class="mt-4 inline-block bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition duration-300">
        Se déconnecter
    </button>
</form>
            </div>
        </div>
    </section>


    <?php 
    
    if($role_id["role_id"] == 2){

    
    
    ?>

    <!-- Liste des Annonces -->
    <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Mes Annonces</h2>
        <?php if (count($livres) > 0): ?>
            <div class="grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 flex">
                <?php foreach ($livres as $livre): ?>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-lg transition duration-300">
                        <img src="<?= "../" . $livre['photo_url'] ?>" alt="Publication" class="max-w-xs max-h-xs object-cover rounded-t-lg mb-4">

                        <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($livre['titre']) ?></h3>
                        <p class="text-gray-600 mt-2 max-w-xs w-xs"><?= htmlspecialchars($livre['description_courte']) ?></p>


                        <div class="mt-4">
                            <span class="text-gray-700 font-bold block">Prix : <?= htmlspecialchars($livre['prix']) ?> €</span>
                            <span class="text-gray-700 font-bold block">Etat : <?= htmlspecialchars($livre['etat']) ?></span>
                            <span class="text-gray-700 font-bold block">Genre : <?= htmlspecialchars($livre['nom_genre']) ?></span>
                            <form action="../../backend/process_delete.php" method="POST">
    <input type="hidden" name="book_id" value="<?= $livre['id']; ?>"> 
    <button type="submit" name="delete_book" class="bg-red-600 text-white py-2 px-4 rounded-md">Supprimer l'annonce</button>
</form>

                        </div>
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
        <form action="../../backend/process_profil.php" method="post" enctype="multipart/form-data" class="space-y-6">
            
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
                <select name="genre_id" id="genre_id" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 bg-white">
                    <?php foreach ($genres as $genre) { 
                        echo "<option value='".$genre['id']."'>".$genre['nom_genre']."</option>"; 
                    } ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="etat" class="block text-sm font-medium text-gray-700">L'état de votre livre</label>
                <select name="etat" id="etat_id" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 bg-white">
                    <?php foreach ($etats as $etat) { 
                        echo "<option value='".$etat['id']."'>".$etat['etat']."</option>"; 
                    } ?>
                </select>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition duration-300">Ajouter le Livre</button>
        </form>
    </section>
    
    
    <?php 
};

 ?>
 <?php 
 
 if($role_id["role_id"] == 1){
 
 
 ?>

<section class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Panneau d'Administration</h1>

        <div class="space-y-6">
            <!-- Bouton pour gérer les utilisateurs -->
            <form action="./utilisateurs.php" method="post">
    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-300">
        Gérer les Utilisateurs
    </button>
</form>


            <!-- Bouton pour gérer les demandes d'ajout -->
            <form action="./ajout.php" method="post">
                <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-yellow-700 transition duration-300">
                    Gérer les Demandes d'Ajouts
                </button>
            </form>

        

        </div>
    </section>


 <?php }; ?>


</main>

<?php include('../../frontend/components/footer.php'); ?>

</body>
</html>
