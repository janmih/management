@extends('layouts.app') {{-- Assurez-vous d'avoir une vue de mise en page (layout) appropriée --}}

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Liste des articles demandés par personneS</h1>
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
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                onclick="openServiceModal('add')" data-target="#serviceModal">
                                Ajouter
                            </button>
                            <x-services.index /> --}}
                        </div>

                        <div class="card-body">
                            <div class="dt-bootstrap5 table-responsive-lg">
                                <table id="demandeTable" style="width:100%"
                                    class="display table table-bordered table-striped dataTable dtr-inline">
                                    <thead>
                                        <tr>
                                            <th>Designation</th>
                                            <th>Stock final</th>
                                            <th>Quantité</th>
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
    <script src="{{ asset('js/crud/myFonction.js') }}"></script>

    <script>
        let table = new DataTable('#demandeTable', {
            processing: true,
            autoautoWidth: true,
            columnDefs: [{
                    width: '10%',
                    targets: 2
                } // Réduit la largeur de la deuxième colonne à 10%
            ],
            // serverSide: true,
            ajax: "{{ route('demande-articles.index') }}",
            columns: [{
                    data: 'article_id',
                    name: 'article_id'
                },
                {
                    data: 'stock_final',
                    name: 'stock_final'
                },
                {
                    data: 'quantity',
                    name: 'quantity',
                },
                {
                    data: 'actions',
                    name: 'actions',
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
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            filename: 'Liste des services',
                            exportOptions: {
                                columns: ':not(.no-export)'
                            },
                            // customize: function(doc) {
                            //     // Ajustez les styles pour que la table occupe toute la page
                            //     doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                            //         .length + 1).join(
                            //         '*').split('');
                            //     doc.styles.tableHeader.fillColor = '#3498db';
                            //     doc.styles.tableHeader.color = '#F5EBEB';
                            //     // Ajoutez un titre au début du document
                            //     // Supprimez le titre par défaut (nom de l'application) du document
                            //     doc.content.splice(0, 1);
                            //     // doc.content[0].text = '';
                            //     doc.content.unshift({
                            //         text: 'Liste des services \n ------------ \n Votre sous-titre',
                            //         style: 'title',
                            //         margin: [0, 10, 0, 0]
                            //     });


                            // }
                            customize: function(doc) {
                                //Remove the title created by datatTables
                                doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                                    .length + 1).join(
                                    '*').split('');

                                doc.styles.tableHeader.fillColor = '#3498db';
                                doc.styles.tableHeader.color = '#F5EBEB';
                                doc.content.splice(0, 1);

                                // Logo converted to base64
                                // Done on http://codebeautify.org/image-to-base64-converter
                                var logo =
                                    'data:image/jpeg;base64,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';
                                doc.pageMargins = [20, 60, 20, 30];
                                doc.defaultStyle.fontSize =
                                    12;
                                doc.styles.tableHeader.fontSize = 11;
                                // doc['header'] = (function() {
                                //     return {
                                //         columns: [{
                                //             image: logo,
                                //             width: 100,
                                //             style: 'title',
                                //             margin: [0, 0, 0, 10],
                                //         }, ],
                                //     }
                                // });
                                doc.content.unshift({
                                    image: logo,
                                    width: 100,
                                    style: 'title',
                                    margin: [0, 0, 0, 10],
                                }, {
                                    text: "MINISTERE DE LA SANTE PUBLIQUE \n -------------- \n SECRETARIAT GENERAL \n -------------------- \n CELLULE D’ APPUI A LA MISE EN ŒUVRE DE LA COUVERTURE SANTE UNIVERSELLE \n --------------",
                                    margin: [0, 0, 0, 10],
                                    style: 'title',
                                });
                                // Utilisez les fonctions de DataTables pour obtenir le nombre d'éléments dans le tableau
                                var count = table.rows().count();
                                var now = new Date();
                                doc.content.push({
                                    text: 'Arrêter au nombre de : ' + nombreEnLettre(count) +
                                        'services',
                                    width: 'auto', // Taille automatique pour s'adapter au contenu
                                    style: 'left',
                                    margin: [0, 10, 0, 50],

                                }, {
                                    text: 'A Antananarivo le : ',
                                    width: 'auto', // Taille automatique pour s'adapter au contenu
                                    style: 'left',
                                    margin: [300, 0, 0, 50],

                                });
                                doc.content.push({
                                    columns: [{
                                        text: 'Viser par : ',
                                        width: 'auto', // Taille automatique pour s'adapter au contenu
                                        style: 'left',
                                        margin: [0, 0, 300, 10],
                                    }, {
                                        text: 'Approuver par : ',
                                        width: 'auto', // Taille automatique pour s'adapter au contenu
                                        style: 'left',
                                        margin: [10, 0, 0, 10],
                                    }]


                                });
                                doc['footer'] = function(page, pages) {
                                    return {
                                        columns: [{
                                                text: 'Approuver par : ',
                                                width: 'auto', // Taille automatique pour s'adapter au contenu
                                                style: 'left',
                                                margin: [10, 0, 0, 10],
                                            },
                                            {
                                                image: logo,
                                                width: 50,
                                                style: 'right'
                                            }
                                        ],
                                        margin: [40, 20, 40, 20],
                                        alignment: 'center'
                                    };
                                };


                            }
                        }
                    ]
                },

            ]
        });

        let commander = (article, id = {{ $personnel_id }}) => {
            let article_id = article.article_id;
            let stock_final = article.stock_final;
            let quantityInput = $('#quantity_' + article.article_id);
            let quantity = parseInt(quantityInput.val(), 10);

            if (quantity > stock_final) {
                quantityInput.val(stock_final);
                quantity = stock_final;
            }

            axios.get('/demande-articles/ajouter', {
                    params: {
                        id: id,
                        article_id: article_id,
                        quantity: quantity
                    }
                })
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    table.ajax.reload()
                    quantity.val('')
                })
                .catch(function(error) {
                    // Gérer les erreurs
                    console.error(error);
                });
        }
    </script>
@endsection
@endsection
