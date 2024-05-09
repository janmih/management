@extends('layouts.app') {{-- Assurez-vous d'avoir une vue de mise en page (layout) appropriée --}}

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Demande congé</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $mainSegment }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            @hasanyrole('Ressource Humaine|Super Admin')
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    onclick="openCongePriseModal('add')" data-target="#congePriseModal">
                                    Ajouter
                                </button>
                                <x-conge-prises.index :personnels="$personnels" />
                            @endhasanyrole
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-lg">
                                <table id="congePriseTable" style="width:100%"
                                    class="display table table-bordered table-striped dataTable dtr-inline ">
                                    <thead>
                                        <tr>
                                            <th>Personnel</th>
                                            <th>Année</th>
                                            <th>Debut</th>
                                            <th>Fin</th>
                                            <th>Nombre jour</th>
                                            <th id="status">Status</th>
                                            <th class="no-export">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


@section('scripts')
    <script src="{{ asset('js/handleServerResponse.js') }}"></script>
    <script src="{{ asset('js/calculAge.js') }}"></script>

    <script>
        let table = new DataTable('#congePriseTable', {
            processing: true,
            // serverSide: true,
            ajax: "{{ route('conge-prises.index') }}",
            columns: [{
                    data: 'personnel_id',
                    name: 'personnel_id'
                },
                {
                    data: 'annee',
                    name: 'annee'
                },
                {
                    data: 'date_debut',
                    name: 'date_debut',
                    render: function(data, type, row) {
                        return new Date(data).toLocaleDateString('fr-FR');
                    }
                },
                {
                    data: 'date_fin',
                    name: 'date_fin',
                    render: function(data, type, row) {
                        return new Date(data).toLocaleDateString('fr-FR');
                    }
                },
                {
                    data: 'nombre_jour',
                    name: 'nombre_jour'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        if (data === 'valide') {
                            return '<h5><span class="badge badge-success">' + data + '</span></h5>';
                        } else if (data == 'refuse') {
                            return '<h5><span class="badge badge-danger">' + data + '</span></h5>';
                        } else {
                            return data;

                        }
                    }
                },
                @hasanyrole('Ressource Humaine|Super Admin|SSE|SPSS|SMF|Chefferie')
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                @endhasanyrole
            ],
            dom: 'Bfrtip',
            select: true,
            responsive: true,
            buttons: [{
                    extend: 'collection',
                    text: 'Exporter',
                    className: 'btn btn-info',
                    buttons: [{
                            extend: 'copy',
                            text: '<i class="fas fa-copy"></i>',
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        }, {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i>',
                            exportOptions: {
                                columns: ':not(.no-export)'
                            },
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        },
                        {
                            extend: 'csv',
                            text: 'CSV',
                            exportOptions: {
                                columns: ':not(.no-export)'
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            exportOptions: {
                                columns: ':not(.no-export)'
                            },
                            customize: function(doc) {
                                // Ajustez les styles pour que la table occupe toute la page
                                doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                                    .length + 1).join(
                                    '*').split('');
                                doc.styles.tableHeader.fillColor = '#3498db';
                                doc.styles.tableHeader.color = '#D04848';
                            }
                        }
                    ]
                },

            ]
        });
        @hasanyrole('Ressource Humaine|Super Admin')
            function openCongePriseModal(action, id = null) {
                // console.log('Ouverture de la modal avec action :', action);
                // Réinitialiser le formulaire
                $('#congePriseForm')[0].reset();

                // Modifier le titre de la modal en fonction de l'action
                $('#congePriseModalLabel').text(action === 'add' ? 'Ajouter un congé' : 'Modifier un congé');

                // Modifier l'action du formulaire en fonction de l'action
                $('#congePriseForm').attr('action', action === 'add' ? '{{ route('conge-prises.store') }}' :
                    '{{ route('conge-prises.update', ':id') }}'.replace(':id', id));

                // Pré-remplir les champs si l'action est 'edit'
                if (action === 'edit') {
                    axios.get('{{ route('conge-prises.edit', ':id') }}'.replace(':id', id))
                        .then(response => {
                            const congePrises = response.data;
                            $('#personnel_id').val(congePrises.personnel_id)
                            $('#date_debut').val(congePrises.date_debut)
                            $('#date_fin').val(congePrises.date_fin)
                            $('#nombre_jour').val(congePrises.nombre_jour)
                            // Pré-remplir le champ "année" avec la valeur récupérée de la base de données
                            $('#annee').val(congePrises.annee);

                            // Enregistrer la valeur de l'année récupérée de la base de données
                            $('#annee').data('selected-year', congePrises.annee);

                            // Mettre à jour la liste déroulante de l'année en fonction du personnel sélectionné
                            updateYearDropdown();

                            // Appeler la fonction pour récupérer le nombre de jours restants
                            updateCongeRestante(congePrises.annee)
                                .then(jourRestante => {
                                    // Enregistrer la valeur du nombre de jours restants récupérée de la base de données
                                    $('#jour_restante').data('selected-jour-restante', jourRestante);

                                    // Sélectionner automatiquement le nombre de jours restants correspondant à la valeur récupérée de la base de données
                                    selectJourRestanteFromDatabaseValue();
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }

                // Ouvrir la modal
                $('#congePriseModal').modal('show');
            }

            function deleteCongePrise(congePriseId) {
                Swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: 'La suppression du service est irréversible!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer!',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Effectuer la suppression avec Axios
                        axios.delete(`/conge-prises/${congePriseId}`)
                            .then(response => {
                                handleServerResponse(response, 'Supprimé avec succès!', $('#congePriseModal'));
                            })
                            .catch(error => {
                                // Gestion des erreurs d'Axios
                                console.error(error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur lors de la suppression',
                                    text: 'Veuillez réessayer!',
                                    showConfirmButton: true
                                });
                            });
                    }
                });
            }

            function saveCongePrise() {
                // Récupérer l'action du formulaire
                const action = $('#congePriseForm').attr('action');

                // Effectuer la requête en fonction de l'action (ajout ou modification)
                axios({
                        method: action === '{{ route('conge-prises.store') }}' ? 'post' : 'patch',
                        url: action,
                        data: $('#congePriseForm').serialize(),
                    })
                    .then(response => {
                        handleServerResponse(response, 'Congé enregistré avec succès!', $('#congePriseModal'));
                    })
                    .catch(error => {
                        // Gestion des erreurs d'Axios
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur lors de l\'enregistrement',
                            text: 'Veuillez réessayer!',
                            showConfirmButton: true
                        });
                    });
            }

            // Gère le changement de la liste déroulante du personnel
            $('#personnel_id').change(function() {
                updateYearDropdown(); // Met à jour la liste déroulante de l'année
            });

            // Gère le changement de la liste déroulante de l'année
            $('#annee').change(function() {
                updateCongeRestante($('#annee').val()); // Met à jour le champ "conge_restante"
            });
        @endhasanyrole
        @hasanyrole('SSE|SPSS|SMF|Chefferie|Super Admin')
            function validerConge(congePriseId) {
                Swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: 'Cette action est irréversible!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer!',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Effectuer la suppression avec Axios
                        axios.get(`/valide-conge/${congePriseId}`, {
                                params: {
                                    'conge_prise_id': congePriseId
                                }
                            })
                            .then(response => {
                                toastr.success(response.data.message);
                                $('#congePriseModal').modal('hide');
                                table.ajax.reload();
                            })
                            .catch(error => {
                                // Gestion des erreurs d'Axios
                                toastr.error(error.response.data.message);
                            });
                    }
                });
            }
        @endhasanyrole
    </script>
@endsection
@endsection
