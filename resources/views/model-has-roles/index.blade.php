@extends('layouts.app') {{-- Assurez-vous d'avoir une vue de mise en page (layout) appropriée --}}
@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Role des utilisateurs</h1>
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
                            <button type="button" class="btn btn-primary" onclick="$('#roleForm')[0].reset();"
                                data-toggle="modal" data-target="#roleModal">
                                Ajouter
                            </button>
                            <x-model-has-roles.index :personnels='$personnels' :roles='$roles' />
                        </div>

                        <div class="card-body">
                            <div class="dt-bootstrap5 table-responsive-lg">
                                <table id="modeHasRoleTable" style="width:100%"
                                    class="display table table-bordered table-striped dataTable dtr-inline">
                                    <thead>
                                        <tr>
                                            <th>Model</th>
                                            <th>Role</th>
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
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        $('#roles').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
        let table = new DataTable('#modeHasRoleTable', {
            processing: true,
            autoautoWidth: true,
            ajax: "{{ route('model-has-roles.index') }}",
            columns: [{
                data: 'name',
                name: 'name'
            }, {
                data: 'roles',
                name: 'roles',
                render: function(data, type, row) {
                    var rolesArray = data.split(' - ');
                    var badgesHtml = '';

                    // Parcourez chaque rôle et créez un badge pour chacun
                    rolesArray.forEach(function(role) {
                        badgesHtml +=
                            '<span class="badge badge-primary" style="font-size: 1rem; margin: 3px">' +
                            role + '</span>';
                    });

                    return badgesHtml;
                }
            }],
            responsive: true,
        });

        let saveModelHasRole = () => {
            axios.post('{{ route('model-has-roles.store') }}', $('#roleForm').serialize())
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                })
        }
    </script>
@endsection
@endsection
