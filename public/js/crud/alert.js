function alertSwal(response, successMessage, modal) {
    if (response.data.success) {
        // Succès
        Swal.fire({
            icon: 'success',
            title: successMessage,
            showConfirmButton: false,
            timer: 1500
        });
        // Actualiser la DataTable ou effectuer d'autres actions nécessaires
        table.draw();
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