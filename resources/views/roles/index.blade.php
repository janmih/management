@extends('layouts.app') {{-- Assurez-vous d'avoir une vue de mise en page (layout) appropriée --}}

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Liste des roles</h1>
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
                            <x-roles.index />
                        </div>

                        <div class="card-body">
                            <div class="dt-bootstrap5 table-responsive-lg">
                                <table id="roleTable" style="width:100%"
                                    class="display table table-bordered table-striped dataTable dtr-inline">
                                    <thead>
                                        <tr>
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
    <script>
        let table = new DataTable('#roleTable', {
            processing: true,
            autoautoWidth: true,
            ajax: "{{ route('roles.index') }}",
            columns: [{
                data: 'name',
                name: 'name'
            }, ],
            responsive: true,
        });

        function saveRole() {
            let role = $('#name').val()
            // Effectuer la requête en fonction de l'action (ajout ou modification)
            axios.post("{{ route('roles.store') }}", {
                    name: role
                })
                .then(response => {
                    toastr.success(response.data.message)
                    $('#roleModal').modal('hide')
                    table.ajax.reload()
                })
                .catch(error => {
                    toastr.error("Une erreur est survenue lors du Enregistrement. Veuillez réessayer.")
                });
        }
    </script>
@endsection
@endsection
