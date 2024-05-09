@extends('layouts.app') {{-- Assurez-vous d'avoir une vue de mise en page (layout) appropriée --}}
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Liste des repos médical</h1>
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
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                onclick="openReposMedicalModal('add')" data-target="#reposMedicalModal">
                                Ajouter
                            </button>
                            <x-repos-medicals.index :personnels='$personnels' />
                        </div>

                        <div class="card-body">
                            <div class="dt-bootstrap5 table-responsive-lg">
                                <table id="reposMedicalTable" style="width:100%"
                                    class="display table table-bordered table-striped dataTable dtr-inline">
                                    <thead>
                                        <tr>
                                            <th>Personnel</th>
                                            <th>Date début</th>
                                            <th>Date fin</th>
                                            <th>Jour Total</th>
                                            <th>Motif</th>
                                            <th>Observation</th>
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
    <script src="{{ asset('js/calculAge.js') }}"></script>
    <script src="{{ asset('js/handleServerResponse.js') }}"></script>

    <script>
        let table = new DataTable('#reposMedicalTable', {
            processing: true,
            // serverSide: true,
            ajax: "{{ route('repos-medicals.index') }}",
            columns: [{
                    data: 'personnel_id',
                    name: 'personnel_id'
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
                    data: 'motif',
                    name: 'motif'
                },
                {
                    data: 'observation',
                    name: 'observation'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
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

        function openReposMedicalModal(action, id = null) {
            // console.log('Ouverture de la modal avec action :', action);
            // Réinitialiser le formulaire
            $('#reposMedicalForm')[0].reset();

            // Modifier le titre de la modal en fonction de l'action
            $('#reposMedicalModalLabel').text(action === 'add' ? 'Ajouter un repos' : 'Modifier un repos');

            // Modifier l'action du formulaire en fonction de l'action
            $('#reposMedicalForm').attr('action', action === 'add' ? '{{ route('repos-medicals.store') }}' :
                '{{ route('repos-medicals.update', ':id') }}'.replace(':id', id));

            // Pré-remplir les champs si l'action est 'edit'
            if (action === 'edit') {
                axios.get('{{ route('repos-medicals.edit', ':id') }}'.replace(':id', id))
                    .then(response => {
                        const reposMedicals = response.data;
                        $('#personnel_id').val(reposMedicals.personnel_id);
                        $('#date_debut').val(reposMedicals.date_debut);
                        $('#date_fin').val(reposMedicals.date_fin);
                        $('#nombre_jour').val(reposMedicals.nombre_jour);
                        $('#motif').val(reposMedicals.motif);
                        $('#observation').val(reposMedicals.observation);
                        // Pré-remplir d'autres champs au besoin
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Ouvrir la modal
            $('#reposMedicalModal').modal('show');
        }

        function deleteReposMedical(reposMedicalId) {
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
                    axios.delete(`/repos-medicals/${reposMedicalId}`)
                        .then(response => {
                            handleServerResponse(response, 'Supprimé avec succès!');
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

        function saveReposMedical() {
            // Récupérer l'action du formulaire
            const action = $('#reposMedicalForm').attr('action');

            // Effectuer la requête en fonction de l'action (ajout ou modification)
            axios({
                    method: action === '{{ route('repos-medicals.store') }}' ? 'post' : 'patch',
                    url: action,
                    data: $('#reposMedicalForm').serialize(),
                })
                .then(response => {
                    handleServerResponse(response, 'Enregistré avec succès!', $('#reposMedicalModal'));
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
    </script>
@endsection
@endsection
