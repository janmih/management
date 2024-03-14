<!-- Modal générique pour ajout/modification -->
<div class="modal fade" id="autorisationAbsenceModal" tabindex="-1" role="dialog"
    aria-labelledby="autorisationAbsenceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="autorisationAbsenceModalLabel">Ajouter/Modifier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter/modifier -->
                <form id="autorisationAbsenceForm">
                    @csrf
                    <!-- Champs du formulaire -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
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
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="date_debut" class="form-label">Debut le:</label>
                                <input type="date" class="form-control form-control-border border-width-2"
                                    id="date_debut" name="date_debut">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="date_fin" class="form-label">Fin le:</label>
                                <input type="date" class="form-control form-control-border border-width-2"
                                    id="date_fin" name="date_fin" onchange="calculJourPrise()">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="jour_reste" class="form-label">Jour Restante:</label>
                                <input type="number" class="form-control form-control-border border-width-2"
                                    id="jour_reste" name="jour_reste" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="jour_prise" class="form-label">Jour Prise:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="jour_prise" name="jour_prise" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="motif" class="form-label">Motif:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="motif" name="motif" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="observation" class="form-label">Observation:</label>
                                <textarea name="observation" id="observation" class="form-control form-control-border border-width-2"></textarea>
                            </div>
                        </div>

                    </div>

                    <!-- Ajoutez d'autres champs au besoin -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="saveautorisationAbsence()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
