@extends('layouts.app') {{-- Assurez-vous d'avoir une vue de mise en page (layout) appropriée --}}
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Liste des congé cumulé par personne</h1>
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
                                    onclick="openCongeCumuleModal('add')" data-target="#congeCumuleModal">
                                    Ajouter
                                </button>
                                <x-conge-cumules.index :personnels='$personnels' />
                            @endhasanyrole
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-lg">
                                <table id="congeCumuleTable" style="width:100%"
                                    class="display table table-bordered table-striped dataTable dtr-inline">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>Personnel</th>
                                            <th>Année</th>
                                            <th>Jour Total</th>
                                            <th>Jour Prise</th>
                                            <th>Jour Reste</th>
                                            @hasanyrole('Ressource Humaine|Super Admin')
                                                <th class="no-export">Actions</th>
                                            @endhasanyrole
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
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $("#annee").datepicker({
            format: "yyyy",
            startView: "years",
            minViewMode: "years",
            autoclose: true
        });
        let table = new DataTable('#congeCumuleTable', {
            processing: true,
            // serverSide: true,
            ajax: "{{ route('conge-cumules.index') }}",
            columns: [{
                    data: 'personnel_id',
                    name: 'personnel_id'
                },
                {
                    data: 'annee',
                    name: 'annee'
                },
                {
                    data: 'jour_total',
                    name: 'jour_total'
                },
                {
                    data: 'jour_prise',
                    name: 'jour_prise'
                },
                {
                    data: 'jour_reste',
                    name: 'jour_reste'
                },
                @hasanyrole('Ressource Humaine|Super Admin')
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

            function openCongeCumuleModal(action, id = null) {
                // console.log('Ouverture de la modal avec action :', action);
                // Réinitialiser le formulaire
                $('#congeCumuleForm')[0].reset();

                // Modifier le titre de la modal en fonction de l'action
                $('#congeCumuleModalLabel').text(action === 'add' ? 'Ajouter un congé' : 'Modifier un congé');

                // Modifier l'action du formulaire en fonction de l'action
                $('#congeCumuleForm').attr('action', action === 'add' ? '{{ route('conge-cumules.store') }}' :
                    '{{ route('conge-cumules.update', ':id') }}'.replace(':id', id));

                // Pré-remplir les champs si l'action est 'edit'
                if (action === 'edit') {
                    axios.get('{{ route('conge-cumules.edit', ':id') }}'.replace(':id', id))
                        .then(response => {
                            const congeCumules = response.data;
                            $('#personnel_id').val(congeCumules.personnel_id);
                            $('#annee').val(congeCumules.annee);
                            $('#jour_total').val(congeCumules.jour_total);
                            $('#jour_prise').val(congeCumules.jour_prise);
                            $('#jour_reste').val(congeCumules.jour_reste);
                            // Pré-remplir d'autres champs au besoin
                        })
                        .catch(error => {
                            toastr.error(error.response.data.message);
                        });
                }

                // Ouvrir la modal
                $('#congeCumuleModal').modal('show');
            }

            function deleteCongeCumule(congeCumuleId) {
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
                        axios.delete(`/conge-cumules/${congeCumuleId}`)
                            .then(response => {
                                toastr.success(response.data.message);
                                $('#congeCumuleModal').modal('hide');
                                table.ajax.reload();
                            })
                            .catch(error => {
                                // Gestion des erreurs d'Axios
                                toastr.success(error.response.data.message);
                            });
                    }
                });
            }

            function saveCongeCumule() {
                // Récupérer l'action du formulaire
                const action = $('#congeCumuleForm').attr('action');

                // Effectuer la requête en fonction de l'action (ajout ou modification)
                axios({
                        method: action === '{{ route('conge-cumules.store') }}' ? 'post' : 'patch',
                        url: action,
                        data: $('#congeCumuleForm').serialize(),
                    })
                    .then(response => {
                        toastr.success(response.data.message)
                        $('#congeCumuleModal').modal('hide');
                        table.ajax.reload();
                    })
                    .catch(error => {
                        // Gestion des erreurs d'Axios
                        toastr.error(error.response.data.message);
                    });
            }
        @endhasanyrole
    </script>
@endsection
@endsection
