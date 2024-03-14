<!-- Modal générique pour ajout/modification -->
<div class="modal fade" id="congeCumuleModal" tabindex="-1" role="dialog" aria-labelledby="congeCumuleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="congeCumuleModalLabel">Ajouter/Modifier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter/modifier -->
                <form id="congeCumuleForm">
                    <!-- Champs du formulaire -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="personnel_id" class="form-label">Personnel</label>
                                <select class="custom-select" id="personnel_id" name="personnel_id">
                                    @foreach ($personnels as $personnel)
                                        <option value="{{ $personnel->id }}">
                                            {{ $personnel->nom . ' ' . $personnel->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="annee" class="form-label">Année:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="annee" name="annee" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="jour_total" class="form-label">Jour Total:</label>
                                <input type="number" class="form-control form-control-border border-width-2"
                                    id="jour_total" name="jour_total" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="jour_prise" class="form-label">Jour Prise:</label>
                                <input type="number" class="form-control form-control-border border-width-2"
                                    id="jour_prise" name="jour_prise" autocomplete="off" onchange="congeCumuleDiff()">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="jour_reste" class="form-label">Jour Reste:</label>
                                <input type="number" class="form-control form-control-border border-width-2"
                                    id="jour_reste" name="jour_reste" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Ajoutez d'autres champs au besoin -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="saveCongeCumule()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
