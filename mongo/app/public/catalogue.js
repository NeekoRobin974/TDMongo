document.addEventListener('DOMContentLoaded', function() {
    const categorieSelect = document.getElementById('categorie_produit');
    const nouvelleCategorie = document.getElementById('nouvelle-categorie');
    const input = document.getElementById('nouvelle_categorie_input');

    if (categorieSelect) {
        categorieSelect.addEventListener('change', function() {
            if (this.value === '__nouvelle__') {
                nouvelleCategorie.style.display = 'block';
                input.required = true;
            } else {
                nouvelleCategorie.style.display = 'none';
                input.required = false;
            }
        });
    }

    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const categorieSelect = document.getElementById('categorie_produit');
            if (categorieSelect.value === '__nouvelle__') {
                const nouvelleCategorie = document.getElementById('nouvelle_categorie_input').value;
                if (nouvelleCategorie) {
                    categorieSelect.value = nouvelleCategorie;
                }
            }
        });
    }
});

function ajouterTarif() {
    const container = document.getElementById('tarifs-container');
    const ligne = document.createElement('div');
    ligne.innerHTML = `
        <select name="tailles[]">
            <option value="">-- Taille --</option>
            <option value="normale">normale</option>
            <option value="grande">grande</option>
        </select>
        <input type="number" name="tarifs[]" placeholder="Prix">
    `;
    container.appendChild(ligne);
}
