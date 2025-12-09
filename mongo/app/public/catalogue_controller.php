<?php

use MongoDB\Client;

require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://localhost:27017");
$collection = $client->pizzashop->produits;

//récup la catégorie dans l'URL
$categorie = null;
if (isset($_GET['categorie'])) {
    $categorie = $_GET['categorie'];
}

require_once __DIR__ . '/catalogue_view.php';