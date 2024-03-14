<!-- Modal générique pour ajout/modification -->
<div class="modal fade" id="congePriseModal" tabindex="-1" role="dialog" aria-labelledby="congePriseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="congePriseModalLabel">Ajouter/Modifier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter/modifier -->
                <form id="congePriseForm">
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
                                <label for="annee" class="form-label">Année</label>
                                <select class="custom-select" id="annee" name="annee">
                                    <option value="">Veuiller choisir</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="jour_restante" class="form-label">Jour Restante:</label>
                                <input type="number" class="form-control form-control-border border-width-2"
                                    id="jour_restante" name="jour_restante" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="date_debut" class="form-label">Jour Prise:</label>
                                <input type="date" class="form-control form-control-border border-width-2"
                                    id="date_debut" name="date_debut" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="date_fin" class="form-label">Jour Fin:</label>
                                <input type="date" class="form-control form-control-border border-width-2"
                                    id="date_fin" name="date_fin" autocomplete="off" onchange="congePrise()">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="nombre_jour" class="form-label">Nombre de jour:</label>
                                <input type="number" class="form-control form-control-border border-width-2"
                                    id="nombre_jour" name="nombre_jour" readonly>
                            </div>
                        </div>

                    </div>

                    <!-- Ajoutez d'autres champs au besoin -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="saveCongePrise()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
