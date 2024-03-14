@extends('layouts.app') {{-- Assurez-vous d'avoir une vue de mise en page (layout) appropriée --}}

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Autorisation d'absence</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
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
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                onclick="openautorisationAbsenceModal('add')" data-target="#autorisationAbsenceModal">
                                Ajouter
                            </button>
                            <x-autorisation-absences.index :personnels="$personnels" />
                        </div>

                        <div class="card-body table-responsive">
                            <table id="autorisationAbsenceTable" style="width:100%"
                                class="display table table-bordered table-striped dataTable dtr-inline ">
                                <thead>
                                    <tr>
                                        <th>Personnel</th>
                                        <th>Date début</th>
                                        <th>Date fin</th>
                                        <th>Jours pris</th>
                                        <th>Jours restants</th>
                                        <th>Motif</th>
                                        <th>Observation</th>
                                        <th>Status</th>
                                        <th class="no-export col-1">Actions</th>
                                    </tr>
                                </thead>
                            </table>
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
        let table = new DataTable('#autorisationAbsenceTable', {
            processing: true,
            // serverSide: true,
            responsive: true,
            ajax: "{{ route('autorisation-absences.index') }}",
            columns: [{
                    data: 'personnel_id',
                    name: 'personnel_id'
                },
                {
                    data: 'date_debut',
                    name: 'date_debut'
                },
                {
                    data: 'date_fin',
                    name: 'date_fin'
                },
                {
                    data: 'jour_prise',
                    name: 'jour_prise'
                },
                {
                    data: 'jour_reste',
                    name: 'jour_reste'
                },
                {
                    data: 'motif',
                    name: 'motif'
                },
                {
                    data: 'observation',
                    name: 'observation'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        var colorClass = '';
                        var actionButtons = '';

                        switch (data) {
                            case 'stand by':
                                colorClass = 'badge badge-waring';
                                break;
                            case 'validated':
                                colorClass = 'badge badge-success';
                                break;
                            case 'refused':
                                colorClass = 'badge badge-danger';
                                break;
                            default:
                                colorClass = '';
                                break;
                        }

                        return '<div class="' + colorClass + '">' + data + '</div>' + actionButtons;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            dom: 'Bfrtip',
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
                        }
                    ]
                },

            ],
        });

        function openautorisationAbsenceModal(action, id = null) {
            // console.log('Ouverture de la modal avec action :', action);
            // Réinitialiser le formulaire
            $('#autorisationAbsenceForm')[0].reset();

            // Modifier le titre de la modal en fonction de l'action
            $('#autorisationAbsenceModalLabel').text(action === 'add' ? 'Ajouter une autorisation d\'absence' :
                'Modifier une autorisation d\'absence');

            // Modifier l'action du formulaire en fonction de l'action
            $('#autorisationAbsenceForm').attr('action', action === 'add' ?
                '{{ route('autorisation-absences.store') }}' :
                '{{ route('autorisation-absences.update', ':id') }}'.replace(':id', id));

            // Pré-remplir les champs si l'action est 'edit'
            if (action === 'edit') {
                axios.get('{{ route('autorisation-absences.edit', ':id') }}'.replace(':id', id))
                    .then(response => {
                        const autorisationAbsences = response.data;
                        $('#personnel_id').val(autorisationAbsences.personnel_id)
                        $('#date_debut').val(autorisationAbsences.date_debut)
                        $('#date_fin').val(autorisationAbsences.date_fin)
                        $('#jour_prise').val(autorisationAbsences.jour_prise)
                        $('#jour_reste').val(autorisationAbsences.jour_reste)
                        $('#motif').val(autorisationAbsences.motif)
                        $('#observation').val(autorisationAbsences.observation)
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Ouvrir la modal
            $('#autorisationAbsenceModal').modal('show');
        }

        function deleteautorisationAbsence(autorisationAbsenceId) {
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
                    axios.delete(`/autorisation-absences/${autorisationAbsenceId}`)
                        .then(response => {
                            handleServerResponse(response, 'Supprimé avec succès!', $(
                                '#autorisationAbsenceModal'));
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

        function saveautorisationAbsence() {
            // Récupérer l'action du formulaire
            const action = $('#autorisationAbsenceForm').attr('action');

            // Effectuer la requête en fonction de l'action (ajout ou modification)
            axios({
                    method: action === '{{ route('autorisation-absences.store') }}' ? 'post' : 'patch',
                    url: action,
                    data: $('#autorisationAbsenceForm').serialize(),
                })
                .then(response => {
                    handleServerResponse(response, 'Enregistré avec succès!', $('#autorisationAbsenceModal'));
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
            updateJourReste(); // Met à jour la liste déroulante de l'année
        });

        function validerAutorisation(id) {
            changerStatutAutorisation(id, 'validated');
        }

        // Fonction pour refuser une autorisation
        function refuserAutorisation(id) {
            changerStatutAutorisation(id, 'refused');
        }
    </script>
@endsection
@endsection
