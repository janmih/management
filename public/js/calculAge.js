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

    // Vérifiez si la date de début est inférieure à la date de fin
    if (dateDebut > dateFin) {
        alert("La date de début ne peut pas être supérieure à la date de fin.");
        return;
    }

    // Calcul de la différence en jours en excluant les week-ends
    var differenceJours = 0;

    while (dateDebut < dateFin) {
        // Vérifiez si le jour actuel n'est pas un samedi (6) ou un dimanche (0)
        if (dateDebut.getDay() !== 6 && dateDebut.getDay() !== 0) {
            differenceJours++;
        }
        // Ajoutez un jour à la date de début
        dateDebut.setDate(dateDebut.getDate() + 1);
    }

    // Afficher la différence
    // console.log("Différence de jours (en excluant les week-ends) : ", differenceJours);

    // Vous pouvez également afficher la différence dans un élément HTML si nécessaire
    // document.getElementById("resultat_difference").innerText = "Différence de jours : " + differenceJours;

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

    // Vérifiez si la date de début est inférieure à la date de fin
    if (dateDebut > dateFin) {
        alert("La date de début ne peut pas être supérieure à la date de fin.");
        return;
    }

    // Calcul de la différence en jours en excluant les week-ends
    var differenceJours = dateFin.getDate() - dateDebut.getDate() + 1;
    console.log(dateFin.getDate());
    console.log(dateDebut.getDate());
    console.log(differenceJours);

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

    // Vérifiez si la date de début est inférieure à la date de fin
    if (dateDebut > dateFin) {
        alert("La date de début ne peut pas être supérieure à la date de fin.");
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