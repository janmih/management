@extends('layouts.app') {{-- Assurez-vous d'avoir une vue de mise en page (layout) appropriée --}}

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Liste des permissions</h1>
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
                            <button type="button" class="btn btn-primary" onclick="$('#permissionForm')[0].reset();"
                                data-toggle="modal" data-target="#permissionModal">
                                Ajouter
                            </button>
                            <x-permissions.index />
                        </div>

                        <div class="card-body">
                            <div class="dt-bootstrap5 table-responsive-lg">
                                <table id="permissionTable" style="width:100%"
                                    class="display table table-bordered table-striped dataTable dtr-inline">
                                    <thead>
                                        <tr>
                                            <th>Permission</th>
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
        let table = new DataTable('#permissionTable', {
            processing: true,
            autoautoWidth: true,
            ajax: "{{ route('permissions.index') }}",
            columns: [{
                data: 'name',
                name: 'name'
            }, ],
            responsive: true,
        });

        function savePermission() {
            let permission = $('#name').val()
            // Effectuer la requête en fonction de l'action (ajout ou modification)
            axios.post("{{ route('permissions.store') }}", {
                    name: permission
                })
                .then(response => {
                    toastr.success(response.data.message)
                    $('#permissionModal').modal('hide')
                    table.ajax.reload()
                })
                .catch(error => {
                    document.getElementById("name").classList.add("is-invalid");
                    $("#nameError").text(error.response.data.errors.name);
                });
        }
    </script>
@endsection
@endsection
