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
        <?php if ($categorie === null): ?>
        <hr>
        <h2>Ajouter un nouveau produit</h2>
        <form method="POST">
            <div>
                <label for="categorie_produit">Catégorie :</label>
                <select name="categorie_produit" id="categorie_produit" required>
                    <option value="">-- Choisir --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
                    <?php endforeach; ?>
                    <option value="__nouvelle__">+ Nouvelle catégorie</option>
                </select>
            </div>

            <div id="nouvelle-categorie">
                <label for="nouvelle_categorie_input">Nouvelle catégorie :</label>
                <input type="text" name="nouvelle_categorie" id="nouvelle_categorie_input">
            </div>

            <div>
                <label for="libelle">Libellé :</label>
                <input type="text" name="libelle" id="libelle" required>
            </div>

            <div>
                <label for="description">Description :</label>
                <textarea name="description" id="description" rows="3"></textarea>
            </div>

            <div>
                <label>Tarifs :</label>
                <div id="tarifs-container">
                    <div>
                        <select name="tailles[]">
                            <option value="">-- Taille --</option>
                            <?php foreach ($tailles_disponibles as $taille): ?>
                                <option value="<?php echo $taille; ?>"><?php echo $taille; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" name="tarifs[]" placeholder="Prix">
                    </div>
                </div>
                <button type="button" onclick="ajouterTarif()">+ Ajouter un tarif</button>
            </div>

            <button type="submit">Ajouter le produit</button>
        </form>

        <script src="catalogue.js"></script>
        <?php endif; ?>
    </div>
</body>
</html>