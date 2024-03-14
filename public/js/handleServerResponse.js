function handleServerResponse(response, successMessage, modal) {
    if (response.data.success) {
        // Succès
        Swal.fire({
            icon: 'success',
            title: successMessage,
            showConfirmButton: false,
            timer: 1500
        });
        // Actualiser la DataTable ou effectuer d'autres actions nécessaires
        table.ajax.reload();
        // table.draw();
        // Fermer la modal
        if (modal) {
            modal.modal('hide');
        }
    } else {
        // Échec
        Swal.fire({
            icon: 'error',
            title: response.data.message,
            showConfirmButton: true
        });
    }
}

// Méthode pour appeler la fonction Axios en fonction du statut souhaité
function changerStatutAutorisation(id, statut) {
    // Afficher une alerte de confirmation SweetAlert
    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Voulez-vous vraiment effectuer cette action?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, continuer'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('test')
            // Si l'utilisateur confirme, envoyer la requête Axios
            axios.get(`/valide-autorisation/${id}/${statut}`)
                .then(response => {
                    console.log(response)
                    Swal.fire({
                        icon: 'success',
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Actualiser la DataTable ou effectuer d'autres actions nécessaires
                    table.ajax.reload();
                })
                .catch(error => {
                    // En cas d'erreur, afficher une alerte d'erreur SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur s\'est produite. Veuillez réessayer.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    console.error(error);
                });
        }
    });
}



function selectYearFromDatabaseValue() {
    var selectedYear = $('#annee').data('selected-year');
    if (selectedYear) {
        $('#annee').val(selectedYear);
    }
}

// Fonction pour sélectionner automatiquement le nombre de jours restants correspondant à la valeur récupérée de la base de données
function selectJourRestanteFromDatabaseValue() {
    var selectedJourRestante = $('#jour_restante').data('selected-jour-restante');
    if (selectedJourRestante) {
        $('#jour_restante').val(selectedJourRestante);
    }
}

// Fonction pour mettre à jour la liste déroulante de l'année en fonction de la personne sélectionnée
function updateYearDropdown() {
    var personnelId = $('#personnel_id').val();

    // Effectue une requête AJAX pour obtenir les années associées à la personne
    axios.get('/get-annee/' + personnelId)
        .then(function (response) {
            // Met à jour la liste déroulante de l'année avec les données reçues
            $('#annee').html(response.data);
            $('#jour_restante').val('');
            selectYearFromDatabaseValue()
        })
        .catch(function (error) {
            console.error(error);
        });
}

// Fonction pour mettre à jour le champ "jour restante" avec la valeur récupérée de la base de données
function updateCongeRestante(annee = null) {
    return new Promise((resolve, reject) => {
        var personnelId = $('#personnel_id').val();
        // Effectue une requête Axios pour obtenir le congé restant associé à la personne et à l'année
        axios.get('/get-conge-restants/' + personnelId + '/' + annee)
            .then(function (response) {
                // Met à jour le champ "jour_restante" avec la valeur reçue
                var jourRestante = response.data[0];
                $('#jour_restante').val(jourRestante);

                // Résoudre la promesse avec la valeur de "jour restante"
                resolve(jourRestante);
            })
            .catch(function (error) {
                console.error(error);
                reject(error); // Rejeter la promesse en cas d'erreur
            });
    });
}

// Fonction pour mettre à jour le champ "jour restant" avec la valeur récupérée de la base de données
function updateJourReste() {
    var personnelId = $('#personnel_id').val();
    var annee = new Date().getFullYear(); // Obtenir l'année en cours
    // Effectue une requête Axios pour obtenir le congé restant associé à la personne et à l'année
    axios.get('/get-autorisation-restants/' + personnelId + '/' + annee)
        .then(function (response) {
            // Met à jour le champ "jour_restant" avec la valeur reçue
            var jourRestant = response.data[0];
            $('#jour_reste').val(jourRestant);
        })
        .catch(function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Erreur s\'est produite',
                text: 'Veuillez réessayer!',
                showConfirmButton: true
            });
            console.error('Erreur lors de la mise à jour du jour restant:', error);
        });
}



