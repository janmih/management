function openModal(action, id = null, modalSelector, formSelector) {
    // Réinitialiser le formulaire
    $(formSelector)[0].trigger('reset');

    // Modifier le titre de la modalité en fonction de l'action
    $(`${modalSelector}Label`).text(action === 'add' ? 'Ajouter un élément' : 'Modifier un élément');

    // Modifier l'action du formulaire en fonction de l'action
    $(formSelector).attr('action', action === 'add' ? `{{ route('${getModelName()}.store') }}` :
        `{{ route('${getModelName()}.update', ':id') }}`.replace(':id', id));

    // Pré-remplir les champs si l'action est 'edit'
    if (action === 'edit') {
        axios.get(`{{ route('${getModelName()}.edit', ':id') }}`.replace(':id', id))
            .then(response => {
                const item = response.data;
                // Personnaliser le pré-remplissage des champs si nécessaire
            })
            .catch(error => {
                console.error(error);
            });
    }

    // Ouvrir la modalité
    $(modalSelector).modal('show');
}


function getModelName() {
    // Logique pour extraire le nom du modèle de la route en cours
    // Adapté à votre structure d'URL
    const currentRoute = '{{ Route::currentRouteName() }}';
    const modelName = currentRoute.split('.')[0]; // Supposant que le modèle est le premier segment de la route
    return modelName;
}
