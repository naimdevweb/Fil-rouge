<?php
require_once '../utils/autoload.php';
session_start();

$bookrepo = new BookRepository;

$query = isset($_GET['query']) ? $_GET['query'] : '';
// var_dump($query);
// die();

$searchResults = $bookrepo->searchBooks($query);
// var_dump($searchResults);
//  die();

$_SESSION['search_results'] = $searchResults;


header("Location: ../frontend/public/search_results.php");
exit();