@extends('layouts.app') {{-- Assurez-vous d'avoir une vue de mise en page (layout) appropriée --}}
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cotisation mission social mensuel</h1>
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
                            {{-- <h3>La somme des cotisatons se totalise {{ number_format($totalPaye, 2, ',', ' ') }}
                                MGA</h3> --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#cotisationModal">
                                        Ajouter
                                    </button>
                                    <x-cotisation-social-mensuels.index :personnels="$personnels" />
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-border border-width-2"
                                            placeholder="Sélectionner l'année" id="annee" name="annee">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive-lg">
                            <table id="cotisationTable" style="width:100%"
                                class="display table table-bordered table-striped dataTable dtr-inline">
                                <thead>
                                    <tr>
                                        <th>Personnel</th>
                                        <th>Jan</th>
                                        <th>Fev</th>
                                        <th>Mars</th>
                                        <th>Avril</th>
                                        <th>Mai</th>
                                        <th>Juin</th>
                                        <th>Juillet</th>
                                        <th>Aout</th>
                                        <th>Sept</th>
                                        <th>Oct</th>
                                        <th>Nov</th>
                                        <th>Dec</th>
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
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('#annee').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });
        let table = new DataTable('#cotisationTable', {
            processing: true,
            // serverSide: true,
            response: true,
            ajax: "{{ route('cotisation-social-mensuels.index') }}",
            columns: [{
                    data: 'personnel',
                    name: 'personnel'
                },
                {
                    data: 'jan',
                    name: 'jan'
                },
                {
                    data: 'fev',
                    name: 'fev'
                },
                {
                    data: 'mars',
                    name: 'mars'
                },
                {
                    data: 'avril',
                    name: 'avril'
                },
                {
                    data: 'mai',
                    name: 'mai',
                },
                {
                    data: 'juin',
                    name: 'juin'
                },
                {
                    data: 'juillet',
                    name: 'juillet'
                },
                {
                    data: 'aout',
                    name: 'aout'
                },
                {
                    data: 'sept',
                    name: 'sept'
                },
                {
                    data: 'oct',
                    name: 'oct'
                },
                {
                    data: 'nov',
                    name: 'nov'
                },
                {
                    data: 'dece',
                    name: 'dece'
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
                        extend: 'colvisGroup',
                        text: 'Show all',
                        show: ':hidden'
                    },
                    {
                        extend: 'colvisGroup',
                        text: 'Hide',
                        show: [1],
                        hide: [0, 2]
                    }
                ]
            }, ]
        });
        $('#annee').on('change', () => {
            table.ajax.url("{{ route('cotisation-social-mensuels.index') }}" + "?annee=" + $('#annee').val())
                .load();
        })

        function saveCotisation() {
            axios.post(
                    "{{ route('cotisation-social-mensuels.store') }}",
                    $('#cotisationForm').serialize(),
                )
                .then(response => {
                    toastr.success(response.data.message);
                    $('#cotisationModal').modal('hide');
                    table.ajax.reload();
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
