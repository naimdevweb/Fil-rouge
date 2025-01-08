<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/script.js"></script>
    <link rel="stylesheet" href="./assets/css/output.css">
    <title>Document</title>
</head>

</html>

<body class="bg-primary-blue"> 

<main>
<?php include('./frontend/components/header.php'); ?>

<section>
<img src="./assets/images/livre.jpg" alt="Livre" class="w-full h-auto max-h-80 object-cover">
</section>
 
<section class="text-center mt-4 uppercase">
<h1 class="text-xl font-semibold text-gray-800 text-center">Livres Disponible</h1 >
</section>

<section class="flex gap-10 pt-4 justify-center">
    <div class="max-w-xs bg-white rounded-lg shadow-lg overflow-hidden">
        <img src="./assets/images/george orwell.jpg" alt="livre 1984 George Orwell" class="w-21">
        <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-800 text-center">"1984" <br> George Orwell</h2>
            <p class="text-gray-600 mt-2">Un roman dystopique sur un régime totalitaire où le gouvernement surveille et contrôle la vie de ses citoyens.</p>
            <h3 class="text-lg font-medium text-gray-800 text-center mt-2">
                Marc
            </h3>
            <a href="./frontend/public/detail.php" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">En savoir plus</a>
        </div>
    </div>
    <div class="max-w-xs bg-white rounded-lg shadow-lg overflow-hidden">
        <img src="./assets/images/camus.jpg" alt="livre la peste" class="w-21">
        <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-800 text-center">"La Peste" <br> Albert Camus</h2>
            <p class="text-gray-600 mt-2">Un roman qui raconte la lutte contre une épidémie dévastatrice dans une ville isolée, offrant une réflexion sur la condition humaine.</p>
            <h3 class="text-lg font-medium text-gray-800 text-center mt-2">
                Marc
            </h3>
            <a href="./frontend/public/detail.php" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">En savoir plus</a>
        </div>
    </div>
    <div class="max-w-xs bg-white rounded-lg shadow-lg overflow-hidden">
        <img src="./assets/images/paulo coelho.jpg" alt="livre paulo coelho" class="w-21">
        <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-800 text-center">"L'Alchimiste" <br> Paulo Coelho</h2>
            <p class="text-gray-600 mt-2">Un voyage initiatique qui explore la quête de ses rêves et le sens de la vie, à travers les yeux d'un jeune berger espagnol.</p>
            <h3 class="text-lg font-medium text-gray-800 text-center mt-2">
                Marc
            </h3>
            <a href="./frontend/public/detail.php" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">En savoir plus</a>
        </div>
    </div>
</section>


</main>
<footer class="pt-4">
    <?php include('./frontend/components/footer.php'); ?>
</footer>
</body>
</html>
