<?php
require_once '../utils/autoload.php';
session_start();

// var_dump('test');
// die();

$bookRepo = new BookRepository();

$prix = isset($_GET['prix']) ? $_GET['prix'] : '';
$genre = isset($_GET['genre']) ? $_GET['genre'] : '';
$etat = isset($_GET['etat']) ? $_GET['etat'] : '';

$filters = [
    'prix' => $prix,
    'genre' => $genre,
    'etat' => $etat
];
// var_dump($filters);
// die();

$filteredBooks = $bookRepo->getFilteredBooks($filters);

$_SESSION['filtered_books'] = $filteredBooks;

header("Location: ../frontend/public/livre.php");
exit();