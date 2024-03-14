function deleting(url, id) {
    return new Promise((resolve, reject) => {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: 'La suppression est irréversible!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Effectuer la suppression avec Axios
                axios.delete(`/${url}/${id}`)
                    .then(response => {
                        resolve(response.data); // Résoudre la promesse avec la réponse du serveur
                    })
                    .catch(error => {
                        reject(error); // Rejeter la promesse en cas d'erreur
                    });
            } else {
                // Rejeter la promesse si l'utilisateur annule
                reject('Suppression annulée');
            }
        });
    });
}
