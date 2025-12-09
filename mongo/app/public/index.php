<?php
/**
 * Created by PhpStorm.
 * User: canals5
 * Date: 28/10/2019
 * Time: 16:16
 */

use MongoDB\Client;

require_once __DIR__ . "/../src/vendor/autoload.php";

$c = new Client("mongodb://localhost:27017");
echo "connected to mongo <br>";

//1°)liste des produits : numero, categorie, libelle
$db = $c->pizzashop->produits
    ->find(
        [],
            ["numero"=>1,
            "categorie"=>1,
            "libelle"=>1,]
    );

foreach ($db as $prod) {
    echo "Numéro : " . (isset($prod["numero"]) ? $prod["numero"] : "") . " | ";
    echo "Catégorie : " . (isset($prod["categorie"]) ? $prod["categorie"] : "") . " | ";
    echo "Libellé : " . (isset($prod["libelle"]) ? $prod["libelle"] : "") . "<br>";
}

//liste des produits dont le tarif en taille normale est <= 3.0
$db = $c->pizzashop->produits->find(
    ["tarifs"=>[
        '$elemMatch'=>[
            "taille"=>"normale",
            "tarif"=>['$lte' => 3.0]
        ]
    ]
    ],
    ["projection"=>[
        "numero"=>1,
        "categorie"=>1,
        "libelle"=>1,
        "tarifs"=>1
    ]
    ]
);

foreach ($db as $prod) {
    echo "Numéro : " . (isset($prod["numero"]) ? $prod["numero"] : "") . " | ";
    echo "Catégorie : " . (isset($prod["categorie"]) ? $prod["categorie"] : "") . " | ";
    echo "Libellé : " . (isset($prod["libelle"]) ? $prod["libelle"] : "") . " | ";
}

//2°)afficher le produit numéro 6, préciser : libellé, catégorie, description, tarifs
$db = $c->pizzashop->produits
    ->find(
        ["numero" => 6],
        ['projection'=>
            ["libelle"=>1,
            "categorie"=>1,
            "description"=>1,
            "tarifs"=>1,]
        ]
    );
foreach ($db as $prod) {
    echo "<br>Libellé : " . (isset($prod["libelle"]) ? $prod["libelle"] : "") . " | ";
    echo "Catégorie : " . (isset($prod["categorie"]) ? $prod["categorie"] : "") . " | ";
    echo "Description : " . (isset($prod["description"]) ? $prod["description"] : "") . " | ";
    if (isset($prod["tarifs"])) {
        foreach ($prod["tarifs"] as $tarif) {
            echo "Taille : " . (isset($tarif["taille"]) ? $tarif["taille"] : "") . " - ";
            echo "Tarif : " . (isset($tarif["tarif"]) ? $tarif["tarif"] : "") . " | ";
        }
    }
    echo "<br>";
}

//3°)liste des produits dont le tarif en taille normale est <= 3.0
$db = $c->pizzashop->produits
    ->find(
        ["tarifs.taille" => "normale",
            "tarifs.tarif" => ['$lte' => 3.0]
        ]
    );

foreach ($db as $prod) {
    echo "<br>Numéro : " . (isset($prod["numero"]) ? $prod["numero"] : "") . " | ";
    echo "Libellé : " . (isset($prod["libelle"]) ? $prod["libelle"] : "") . " | ";
    if (isset($prod["tarifs"])) {
        foreach ($prod["tarifs"] as $tarif) {
            echo "Taille : " . (isset($tarif["taille"]) ? $tarif["taille"] : "") . " - ";
            echo "Tarif : " . (isset($tarif["tarif"]) ? $tarif["tarif"] : "") . " | ";
        }
    }
    echo "<br>";
}