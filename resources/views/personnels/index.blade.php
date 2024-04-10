@extends('layouts.app') {{-- Assurez-vous d'avoir une vue de mise en page (layout) appropriée --}}

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Listes des personnels</h1>
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
                                onclick="openPersonnelModal('add')" data-target="#personnelModal">
                                Ajouter
                            </button>
                            <x-personnels.index :services="$services" />
                        </div>

                        <div class="card-body">
                            <div class="dt-bootstrap5 table-responsive">
                                <table id="personnelTable" style="width:100%"
                                    class="display table table-bordered table-striped dataTable dtr-inline">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Service</th>
                                            {{-- <th>CIN</th>
                                                    <th>Date de Naissance</th>
                                                    <th>Com CIN</th>
                                                    <th>Duplicata</th>
                                                    <th>Date Duplicata</th>
                                                    <th>DDN</th>
                                                    <th>Age</th>
                                                    <th>Genre</th>
                                                    <th>Adresse</th> --}}
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Fonction</th>
                                            <th>Matricule</th>
                                            {{-- <th>Indice</th>
                                                    <th>Corps</th>
                                                    <th>Grade</th>
                                                    <th>Date Effet Avancement</th>
                                                    <th>Fin Date Effet Avancement</th>
                                                    <th>Classe</th>
                                                    <th>Echelon</th> --}}
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
    <script src="{{ asset('js/jquery.inputmask.bundle.min.js') }}"></script>
    <script>
        $('#contact, #cin, #matricule').inputmask({
            'mask': ['+999 99 99 999 99', '999 999 999 999', '999 999']
        });
        let table = new DataTable('#personnelTable', {
            processing: true,
            // serverSide: true,
            ajax: "{{ route('personnels.index') }}",
            columns: [{
                    data: 'nom',
                    name: 'nom'
                },
                {
                    data: 'prenom',
                    name: 'prenom'
                },
                {
                    data: 'service_id',
                    name: 'service_id'
                },
                // {
                //     data: 'cin',
                //     name: 'cin'
                // },
                // {
                //     data: 'date_cin',
                //     name: 'date_cin'
                // },
                // {
                //     data: 'com_cin',
                //     name: 'com_cin'
                // },
                // {
                //     data: 'duplicata',
                //     name: 'duplicata'
                // },
                // {
                //     data: 'date_duplicata',
                //     name: 'date_duplicata'
                // },
                // {
                //     data: 'ddn',
                //     name: 'ddn'
                // },
                // {
                //     data: 'age',
                //     name: 'age'
                // },
                // {
                //     data: 'genre',
                //     name: 'genre'
                // },
                // {
                //     data: 'adresse',
                //     name: 'adresse'
                // },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'contact',
                    name: 'contact'
                },
                // {
                //     data: 'photo',
                //     name: 'photo',
                //     orderable: false,
                //     searchable: false,
                //     render: function(data, type, full, meta) {
                //         if (data) {
                //             // S'il y a une photo, afficher l'image en utilisant les classes de style Bootstrap
                //             return '<img src="' + data + '" alt="Photo" class="img-circle img-size-32">';
                //         } else {
                //             // Sinon, afficher une icône Font Awesome comme avatar par défaut
                //             return '<i class="fas fa-user-circle fa-2x"></i>';
                //         }
                //     }
                // },
                {
                    data: 'fonction',
                    name: 'fonction'
                },
                {
                    data: 'matricule',
                    name: 'matricule'
                },
                // {
                //     data: 'indice',
                //     name: 'indice'
                // },
                // {
                //     data: 'corps',
                //     name: 'corps'
                // },
                // {
                //     data: 'grade',
                //     name: 'grade'
                // },
                // {
                //     data: 'date_effet_avancement',
                //     name: 'date_effet_avancement'
                // },
                // {
                //     data: 'fin_date_effet_avancement',
                //     name: 'fin_date_effet_avancement'
                // },
                // {
                //     data: 'classe',
                //     name: 'classe'
                // },
                // {
                //     data: 'echelon',
                //     name: 'echelon'
                // },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            dom: 'Bfrtip',
            // select: true,
            // responsive: true,
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

        function openPersonnelModal(action, id = null) {
            // console.log('Ouverture de la modal avec action :', action);
            // Réinitialiser le formulaire
            $('#personnelForm')[0].reset();

            // Modifier le titre de la modal en fonction de l'action
            $('#personnelModalLabel').text(action === 'add' ? 'Ajouter un personnel' : 'Modifier un personnel');

            // Modifier l'action du formulaire en fonction de l'action
            $('#personnelForm').attr('action', action === 'add' ? '{{ route('personnels.store') }}' :
                '{{ route('personnels.update', ':id') }}'.replace(':id', id));

            // Pré-remplir les champs si l'action est 'edit'
            if (action === 'edit') {
                axios.get('{{ route('personnels.edit', ':id') }}'.replace(':id', id))
                    .then(response => {
                        const personnel = response.data;
                        $('#nom').val(personnel.nom);
                        $('#prenom').val(personnel.prenom);
                        $('#cin').val(personnel.cin);
                        $('#date_cin').val(personnel.date_cin);
                        $('#com_cin').val(personnel.com_cin);
                        $('#duplicata').val(personnel.duplicata);
                        $('#date_duplicata').val(personnel.date_duplicata);
                        $('#ddn').val(personnel.ddn);
                        $('#age').val(personnel.age);
                        $('#genre').val(personnel.genre);
                        $('#service_id').val(personnel.service_id);
                        $('#adresse').val(personnel.adresse);
                        $('#email').val(personnel.email);
                        $('#contact').val(personnel.contact);
                        // $('#photo').val(personnel.photo);
                        $('#fonction').val(personnel.fonction);
                        $('#matricule').val(personnel.matricule);
                        $('#indice').val(personnel.indice);
                        $('#corps').val(personnel.corps);
                        $('#grade').val(personnel.grade);
                        $('#date_effet_avancement').val(personnel.date_effet_avancement);
                        $('#fin_date_effet_avancement').val(personnel.fin_date_effet_avancement);
                        $('#classe').val(personnel.classe);
                        $('#echelon').val(personnel.echelon);
                        // Ajoutez d'autres champs au besoin
                        // Pré-remplir d'autres champs au besoin
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Ouvrir la modal
            $('#personnelModal').modal('show');
        }

        function deletePersonnel(personnelId) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: 'La suppression du personnel est irréversible!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Effectuer la suppression avec Axios
                    axios.delete(`/personnels/${personnelId}`)
                        .then(response => {
                            handleServerResponse(response, 'Personnel supprimé avec succès!');
                        })
                        // .then(response => {
                        //     if (response.data.success) {
                        //         // Succès
                        //         Swal.fire({
                        //             icon: 'success',
                        //             title: 'Personnel supprimé avec succès!',
                        //             showConfirmButton: false,
                        //             timer: 1500
                        //         });
                        //         // Actualiser la DataTable ou effectuer d'autres actions nécessaires
                        //         table.draw();
                        //     } else {
                        //         // Échec
                        //         Swal.fire({
                        //             icon: 'error',
                        //             title: 'Erreur lors de la suppression du personnel',
                        //             text: response.data.message,
                        //             showConfirmButton: true
                        //         });
                        //     }
                        // })
                        .catch(error => {
                            // Gestion des erreurs d'Axios
                            console.error(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur lors de la suppression du personnel',
                                text: 'Veuillez réessayer!',
                                showConfirmButton: true
                            });
                        });
                }
            });
        }

        function savePersonnel() {
            // Récupérer l'action du formulaire
            const action = $('#personnelForm').attr('action');

            // Effectuer la requête en fonction de l'action (ajout ou modification)
            axios({
                    method: action === '{{ route('personnels.store') }}' ? 'post' : 'patch',
                    url: action,
                    data: $('#personnelForm').serialize(),
                })
                .then(response => {
                    handleServerResponse(response, 'Personnel supprimé avec succès!', $('#personnelModal'));
                })
                .catch(error => {
                    // Gestion des erreurs d'Axios
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur lors de l\'enregistrement du personnel',
                        text: 'Veuillez réessayer!',
                        showConfirmButton: true
                    });
                });
        }
    </script>
@endsection
@endsection
