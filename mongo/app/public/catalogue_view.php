<?php
/**
 * @var string|null $categorie
 * @var MongoDB\Collection $collection
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue Pizzashop</title>
    <link rel="stylesheet" href="catalogue.css">
</head>
<body>
    <div class="container">
        <h1>Catalogue Pizzashop</h1>

        <?php if ($categorie == null): ?>
            <h2>Choisissez une catégorie :</h2>

            <?php
            //récup toutes les catégories (juste 1 fois chacune)
            $categories = $collection->distinct("categorie");

            //affichage
            foreach ($categories as $cat) {
                echo '<a href="?categorie=' . $cat . '" class="categorie">';
                echo $cat;
                echo '</a>';
            }
            ?>

        <?php else: ?>
            <!--page d'une catégorie avec les produits-->
            <a href="catalogue_controller.php" class="retour">Retour</a>

            <h2>Catégorie : <?php echo $categorie; ?></h2>

            <?php
            //récup les produits de cette catégorie
            $produits = $collection->find(["categorie" => $categorie]);

            //affichage produits
            foreach ($produits as $produit) {
                echo '<div class="produit">';
                echo '<p><strong>N° ' . $produit["numero"] . '</strong></p>';
                echo '<h3>' . $produit["libelle"] . '</h3>';

                if (isset($produit["description"])) {
                    echo '<p>' . $produit["description"] . '</p>';
                }

                if (isset($produit["tarifs"])) {
                    echo '<p><strong>Tarifs :</strong></p>';
                    foreach ($produit["tarifs"] as $tarif) {
                        echo '<p>' . $tarif["taille"] . ' : ' . $tarif["tarif"] . ' €</p>';
                    }
                }

                echo '</div>';
            }
            ?>

        <?php endif; ?>
    </div>
</body>
</html>