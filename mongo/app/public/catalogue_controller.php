<?php
use MongoDB\Client;
require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://localhost:27017");
$collection = $client->pizzashop->produits;

$categorie = $_GET['categorie'] ?? null;
$categories = $collection->distinct("categorie");
$tailles_disponibles = ["normale", "grande"];
$message = $erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dernierProduit = $collection->findOne([], ['sort' => ['numero' => -1]]);
        $numero = ($dernierProduit->numero ?? 0) + 1;

        $tarifs = [];
        foreach ($_POST['tailles'] ?? [] as $index => $taille) {
            if ($taille && isset($_POST['tarifs'][$index]) && $_POST['tarifs'][$index] !== '') {
                $tarifs[] = ['taille' => $taille, 'tarif' => (float)$_POST['tarifs'][$index]];
            }
        }

        $produit = [
            'numero' => $numero,
            'categorie' => $_POST['categorie_produit'],
            'libelle' => $_POST['libelle']
        ];

        if (!empty($_POST['description'])) $produit['description'] = $_POST['description'];
        if ($tarifs) $produit['tarifs'] = $tarifs;

        $collection->insertOne($produit);
        $message = "Produit ajouté avec succès (N° $numero)";
        $categories = $collection->distinct("categorie");
    } catch (Exception $e) {
        $erreur = "Erreur : " . $e->getMessage();
    }
}

require_once __DIR__ . '/catalogue_view.php';
