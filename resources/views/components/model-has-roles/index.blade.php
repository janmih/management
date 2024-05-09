<!-- Modal générique pour ajout/modification -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">Ajouter/Modifier un role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter/modifier -->
                <form id="roleForm">
                    <!-- Champs du formulaire -->
                    <div class="form-group">
                        <label for="personnel_id" class="form-label">Personnel</label>
                        <select class="custom-select" id="personnel_id" name="personnel_id">
                            <option value="" selected>Veuiller choisir</option>
                            @foreach ($personnels as $personnel)
                                <option value="{{ $personnel->id }}">
                                    {{ $personnel->nom . ' ' . $personnel->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="roles" class="form-label">Roles</label>
                        <select id="roles" name="role_id[]" class="form-select" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="saveModelHasRole()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
