// Récupère la liste d'éléments et toutes les cases à cocher
const rows = document.querySelectorAll('.table-row');
const checkboxes = document.querySelectorAll('.filter-checkbox');

// Ajoute un événement "change" à chaque case à cocher
checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        filterTable();
    });
});

// Fonction qui filtre le tableau en fonction des cases à cocher sélectionnées
function filterTable() {
    // Récupère les cases à cocher sélectionnées
    const inscrit = document.getElementById('inscrit').checked;
    const nonInscrit = document.getElementById('non-inscrit').checked;
    const fini = document.getElementById('fini').checked;
    const organisateur = document.getElementById('organisateur').checked;

    // Parcours le tableau et masque/affiche chaque ligne en fonction des cases à cocher sélectionnées
    rows.forEach(function (row) {
        const estInscrit = row.getAttribute('data-est-inscrit') === '1';
        const estFini = row.getAttribute('data-est-fini') === '1';
        const estOrganisateur = row.getAttribute('data-est-organisateur') === '1';
        let doitAfficher = true;

        if (inscrit && !estInscrit) {
            doitAfficher = false;
        } else if (nonInscrit && estInscrit) {
            doitAfficher = false;
        } else if (fini && !estFini) {
            doitAfficher = false;
        } else if (organisateur && !estOrganisateur) {
            doitAfficher = false;
        }

        if (doitAfficher) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
}