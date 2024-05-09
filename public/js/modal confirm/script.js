const toastr = require("toastr");

let confirmation = (method, response) => {
    if (response.data.success) {
        // Succès
        toastr.success(successMessage)
        table.ajax.reload();
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
    $.confirm({
        title: 'Confirmation!',
        content: 'Voulez-vous ouvrir le lien?',
        buttons: {
            Confirmer: {
                btnClass: 'btn-blue',
                action: function () {
                    axios({
                        url: url,
                        method: method
                    })
                        .then(() => {
                            toastr.success(response)
                        })
                        .catch(() => {
                            toastr.error(response)
                        })
                },
            },
            Annuler: {
                btnClass: 'btn-warning',
                action: function () {
                    this.close()
                },
            },
        }
    });
}