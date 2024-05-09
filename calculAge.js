// calculAge.js
function calculateAge() {
    var dob = document.getElementById("ddn").value;
    var today = new Date();
    var birthDate = new Date(dob);
    var age = today.getFullYear() - birthDate.getFullYear();
    var monthDiff = today.getMonth() - birthDate.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    document.getElementById("age").value = age + 1;
}
// calculAge.js
function reposJourTotal() {
    // Obtenez les valeurs des champs de date
    var dateDebutValue = document.getElementById("date_debut").value;
    var dateFinValue = document.getElementById("date_fin").value;

    // Convertissez les valeurs en objets Date
    var dateDebut = new Date(dateDebutValue);
    var dateFin = new Date(dateFinValue);

    // Vérifiez si les dates sont valides
    if (isNaN(dateDebut.getTime()) || isNaN(dateFin.getTime())) {
        alert("Veuillez saisir des dates valides.");
        return;
    }

    // Calcul de la différence en jours en excluant les week-ends
    var differenceJours = dateFin.getDate() - dateDebut.getDate() + 1;
    // Afficher la différence
    document.getElementById("nombre_jour").value = differenceJours;
}

function congePrise() {
    // Obtenez les valeurs des champs de date
    var dateDebutValue = document.getElementById("date_debut").value;
    var dateFinValue = document.getElementById("date_fin").value;

    // Convertissez les valeurs en objets Date
    var dateDebut = new Date(dateDebutValue);
    var dateFin = new Date(dateFinValue);

    // Vérifiez si les dates sont valides
    if (isNaN(dateDebut.getTime()) || isNaN(dateFin.getTime())) {
        alert("Veuillez saisir des dates valides.");
        return;
    }

    // Calcul de la différence en jours en excluant les week-ends
    var differenceJours = Math.floor((dateFin - dateDebut) / (1000 * 60 * 60 * 24)) + 1;

    // Afficher la différence dans le champ "nombre_jour"
    document.getElementById("nombre_jour").value = differenceJours;
}

function calculJourPrise() {
    // Obtenez les valeurs des champs de date
    var dateDebutValue = document.getElementById("date_debut").value;
    var dateFinValue = document.getElementById("date_fin").value;

    // Convertissez les valeurs en objets Date
    var dateDebut = new Date(dateDebutValue);
    var dateFin = new Date(dateFinValue);

    // Vérifiez si les dates sont valides
    if (isNaN(dateDebut.getTime()) || isNaN(dateFin.getTime())) {
        alert("Veuillez saisir des dates valides.");
        return;
    }

    // Calcul de la différence en jours en excluant les week-ends
    var differenceJours = dateFin.getDate() - dateDebut.getDate() + 1;

    if (differenceJours > 3) {
        Swal.fire({
            icon: 'error',
            title: '3 jours maximum',
            text: 'Veuillez réessayer!',
            showConfirmButton: true
        });
    }
    // Afficher la différence dans le champ "nombre_jour"
    document.getElementById("jour_prise").value = differenceJours;
}

function congeCumuleDiff() {
    var jt = document.getElementById("jour_total").value;
    var jp = document.getElementById("jour_prise").value;
    var jrs = jt - jp;

    document.getElementById("jour_reste").value = jrs;
}