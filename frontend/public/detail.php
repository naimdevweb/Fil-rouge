<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/script.js"></script>
    <link rel="stylesheet" href="../../assets/css/output.css">
    <title>Document</title>
</head>

</html>

<body class="bg-primary-blue"> 

<main>
    <?php include('../../frontend/components/header.php'); ?>

    <section class="flex justify-center items-center pt-8">
       
    <div class="p-4">
    <img src="../../assets/images/george orwell.jpg" alt="livre 1984 George Orwell" class="w-44 rounded-lg shadow-lg">
</div>


       
        <div class="w-1/2 p-4">
            <h2 class="text-3xl font-semibold text-gray-800 mb-4">"1984" <br> George Orwell</h2>
            <p class="text-gray-600 mb-4">Un roman dystopique sur un régime totalitaire où le gouvernement surveille et contrôle la vie de ses citoyens.</p>
            <div class="flex items-center space-x-4">
                <span class="text-xl font-semibold text-gray-800">Prix :</span>
                <span class="text-xl font-bold text-green-600">€19.99</span>
            </div>
            <a href="#" class="mt-4 inline-block bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">Acheter</a>
        </div>
    </section>

    <h1 class="text-xl font-semibold text-gray-800 text-center">Marc vend aussi cest livres</h1>

    <section class="flex gap-10 pt-4 justify-center">
       
        <div class="max-w-xs bg-white rounded-lg shadow-lg overflow-hidden">
        <img src="../../assets/images/george orwell.jpg" alt="livre 1984 George Orwell" class="w-21">
        <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-800 text-center">"1984" <br> George Orwell</h2>
            <p class="text-gray-600 mt-2">Un roman dystopique sur un régime totalitaire où le gouvernement surveille et contrôle la vie de ses citoyens.</p>
            
            <a href="./frontend/public/detail.php" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">Acheter</a>
        </div>
    </div>
    <div class="max-w-xs bg-white rounded-lg shadow-lg overflow-hidden">
        <img src="../../assets/images/camus.jpg" alt="livre la peste" class="w-21">
        <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-800 text-center">"La Peste" <br> Albert Camus</h2>
            <p class="text-gray-600 mt-2">Un roman qui raconte la lutte contre une épidémie dévastatrice dans une ville isolée, offrant une réflexion sur la condition humaine.</p>
           
            <a href="./frontend/public/detail.php" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">Acheter</a>
        </div>
    </div>
    <div class="max-w-xs bg-white rounded-lg shadow-lg overflow-hidden">
        <img src="../../assets/images/paulo coelho.jpg" alt="livre paulo coelho" class="w-21">
        <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-800 text-center">"L'Alchimiste" <br> Paulo Coelho</h2>
            <p class="text-gray-600 mt-2">Un voyage initiatique qui explore la quête de ses rêves et le sens de la vie, à travers les yeux d'un jeune berger espagnol.</p>
          
            <a href="./frontend/public/detail.php" class="block mt-4 text-center text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition duration-300">Acheter</a>
        </div>
    </div>
    </section>
</main>
<footer class="pt-4">
    <?php include('../../frontend/components/footer.php'); ?>
</footer>
</body>
