// Initialise la DataTable avec les colonnes dynamiques
function initializeDataTable(tableId, ajaxUrl, colonnes) {
    let colonnesDataTable = colonnes.map(colonne => ({
        data: colonne.data,
        name: colonne.name
    }));

    let table = new DataTable(tableId, {
        processing: true,
        serverSide: true,
        ajax: ajaxUrl,
        columns: colonnesDataTable,
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
                customize: function (doc) {
                    // Ajustez les styles pour que la table occupe toute la page
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                        .length + 1).join(
                            '*').split('');
                    doc.styles.tableHeader.fillColor = '#3498db';
                    doc.styles.tableHeader.color = '#D04848';
                }
            }
            ]
        }]
    });
}

