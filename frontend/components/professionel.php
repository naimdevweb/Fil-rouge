

<link rel="stylesheet" href="../../assets/css/output.css"> 
</head>

<body class="bg-gray-100">
<section class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <div class="flex items-center space-x-6">
            <!-- Avatar -->
            <img src="https://via.placeholder.com/150" alt="Avatar" class="w-32 h-32 rounded-full border-4 border-gray-200">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800"><?= htmlspecialchars($user->getPrenom()); ?></h1>
                <p class="text-lg text-gray-600">Professionnel</p>
                <p class="text-gray-700 mt-2">Nous offrons une large gamme de services et de produits. N'hésitez pas à nous contacter pour plus d'informations.</p>
            </div>
            <div class="flex justify-end space-x-4 mt-6">
        <a href="./modifier.php" 
           class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
            Modifier
        </a>
        <a href="../../backend/process_deconnexion.php" 
           class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-300">
            Déconnexion
        </a>
    </div>
        </div>
        
    </section>
    

    <!-- Détails de l'entreprise -->
    <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Détails de l'entreprise</h2>

        <div class="space-y-4">
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Nom de l'Entreprise</span>
                <span class="text-gray-800"><?= htmlspecialchars($vendeur->getNomEntreprise()); ?></span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold text-gray-600">Adresse de l'entreprise</span>
                <span class="text-gray-800"><?= htmlspecialchars($vendeur->getAdresseEntreprise()); ?></span>
            </div>
        </div>
    </section>

    <!-- Formulaire pour ajouter un livre -->
    <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ajouter un Livre</h2>
        <form action="../../backend/process_profil.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="titre" class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" name="titre" id="titre" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="prix" class="block text-sm font-medium text-gray-700">Prix</label>
                <input type="number" name="prix" id="prix" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="etat" class="block text-sm font-medium text-gray-700">État</label>
                <select name="etat" id="etat" class="mt-1 block w-full" required>
                    <option value="1">Neuf</option>
                    <option value="2">Moyen</option>
                    <option value="3">Mauvais</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="genre_id" class="block text-sm font-medium text-gray-700">Genre</label>
                <select name="genre_id" id="genre_id" class="mt-1 block w-full" required>
                    <option value="1">Roman</option>
                    <option value="2">Policier</option>
                    <option value="3">Aventure</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="photo" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="photo" id="photo" class="mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="description_courte" class="block text-sm font-medium text-gray-700">Description Courte</label>
                <textarea name="description_courte" id="description_courte" class="mt-1 block w-full" required></textarea>
            </div>
            <div class="mb-4">
                <label for="description_longue" class="block text-sm font-medium text-gray-700">Description Longue</label>
                <textarea name="description_longue" id="description_longue" class="mt-1 block w-full" required></textarea>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
            </div>
        </form>
    </section>

    <!-- Annonces de livres -->
   <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Annonces de Livres</h2>
    <?php if (!empty($livres)): ?>
        <div class="grid grid-cols-1 gap-4">
            <?php foreach ($livres as $livre): ?>
                <div class="bg-gray-100 rounded-lg p-4 shadow">
                    <img src="../../assets/images/<?= htmlspecialchars($livre->getPhotoUrl()); ?>" alt="<?= htmlspecialchars($livre->getTitre()); ?>" class="flex-wrap h-48">
                    <h3 class="text-lg font-semibold mt-2"><?= htmlspecialchars($livre->getTitre()); ?></h3>
                    <p class="text-gray-600"><?= htmlspecialchars($livre->getDescriptionCourte()); ?></p>
                    <p class="text-gray-600"><?= htmlspecialchars($livre->getDescriptionLongue()); ?></p>
                    <p class="text-gray-800 font-bold mt-2"><?= htmlspecialchars($livre->getPrix()); ?> €</p>
                    <p class="text-gray-800 font-bold mt-2"><?= htmlspecialchars($livre->getEtat()); ?></p>
                    <p class="text-gray-800 font-bold mt-2"><?= htmlspecialchars($livre->getGenre()); ?></p>
                    <form action="../../backend/delete_book.php" method="POST" class="mt-4">
                        <input type="hidden" name="book_id" value="<?= htmlspecialchars($livre->getId()); ?>">
                        <button type="submit" class="bg-red-500 text-black px-4 py-2 rounded">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-700">Vous n'avez pas encore publié d'annonces.</p>
    <?php endif; ?>
    </section>

</body>
</html>
