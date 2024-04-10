@extends('layouts.app') {{-- Assurez-vous d'avoir une vue de mise en page (layout) appropriée --}}

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cotisation mission social</h1>
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
                            <h3>La somme des cotisatons se totalise {{ number_format($totalPaye, 2, ',', ' ') }}
                                MGA</h3>
                        </div>

                        <div class="card-body table-responsive-lg">
                            <table id="cotisationTable" style="width:100%"
                                class="display table table-bordered table-striped dataTable dtr-inline">
                                <thead>
                                    <tr>
                                        <th>Personnel</th>
                                        <th>Mission</th>
                                        <th>Montant</th>
                                        <th>Status</th>
                                        <th class="no-export">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" style="text-align:right">Total:</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


@section('scripts')
    <script src="{{ asset('js/handleServerResponse.js') }}"></script>

    <script>
        // Fonction pour formater le montant
        function formatMontant(montant) {
            return Number(montant).toLocaleString('fr-FR', {
                style: 'currency',
                currency: 'MGA'
            });
        }
        let table = new DataTable('#cotisationTable', {
            processing: true,
            // serverSide: true,
            response: true,
            ajax: "{{ route('cotisation-socials.index') }}",
            columns: [{
                    data: 'personnel_id',
                    name: 'personnel_id'
                },
                {
                    data: 'mission_id',
                    name: 'mission_id',
                },
                {
                    data: 'montant',
                    name: 'montant',
                    render: function(data, type, row) {
                        return formatMontant(data);
                    }
                },
                {
                    data: 'status',
                    name: 'status'
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
                            extend: 'colvisGroup',
                            text: 'Show all',
                            show: ':hidden'
                        },
                        {
                            extend: 'colvisGroup',
                            text: 'Hide',
                            show: [1],
                            hide: [0, 2]
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

            ],
            footerCallback: function(row, data, start, end, display) {
                let api = this.api();

                // Remove the formatting to get integer data for summation
                let intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i :
                        0;
                };

                // Total over all pages
                total = api
                    .column(2)
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);

                // Total over this page
                pageTotal = api
                    .column(2, {
                        page: 'current'
                    })
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);

                // Update footer
                api.column(2).footer().innerHTML =
                    'Ar ' + pageTotal + ' ( Ar ' + total + ' total)';
            }
        });

        function payerCotisation(id) {
            // Afficher une boîte de dialogue de confirmation avec SweetAlert
            Swal.fire({
                title: 'Êtes-vous sûr de vouloir payer cette cotisation ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, Payer'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si l'utilisateur confirme, effectuer l'action de paiement
                    axios.post('/cotisations/' + id)
                        .then(function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            // Actualiser la DataTable ou effectuer d'autres actions nécessaires
                            table.ajax.reload();
                        })
                        .catch(function(error) {
                            Swal.fire({
                                icon: 'danger',
                                title: response.data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            // console.error('Erreur lors du paiement:', error);
                        });
                }
            });
        }
    </script>
@endsection
@endsection
