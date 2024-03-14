<!-- Modal générique pour ajout/modification -->
<div class="modal fade" id="missionModal" tabindex="-1" role="dialog" aria-labelledby="missionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="missionModalLabel">Ajouter/Modifier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter/modifier -->
                <form id="missionForm">
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
                                <label for="date_debut" class="form-label">Date début:</label>
                                <input type="date" class="form-control form-control-border border-width-2"
                                    id="date_debut" name="date_debut" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="date_fin" class="form-label">Date fin:</label>
                                <input type="date" class="form-control form-control-border border-width-2"
                                    id="date_fin" name="date_fin" autocomplete="off" onchange="reposJourTotal()">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="nombre_jour" class="form-label">Jour Total:</label>
                                <input type="number" class="form-control form-control-border border-width-2"
                                    id="nombre_jour" name="nombre_jour" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="lieu" class="form-label">Lieu:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="lieu" name="lieu" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="type" class="form-label">Type de mission</label>
                                <select class="custom-select" id="type" name="type">
                                    <option value="PTF">PTF</option>
                                    <option value="OR">OR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="observation" class="form-label">Observation:</label>
                                <textarea rows="3" class="form-control form-control-border border-width-2" id="observation" name="observation"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Ajoutez d'autres champs au besoin -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="saveMission()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
