<!-- Modal générique pour ajout/modification -->
<div class="modal fade" id="stockServiceModal" tabindex="-1" role="dialog" aria-labelledby="stockServiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockServiceModalLabel">Ajouter/Modifier stock par service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter/modifier -->
                <form id="stockServiceForm" enctype="multipart/form-data">
                    <!-- Ajout du champ pour le fichier -->
                    <div class="row">
                        <!-- Champs du formulaire -->
                        <div class="mb-3 col-6">
                            <label for="service_id" class="form-label">Service ID</label>
                            <select class="custom-select" id="service_id" name="service_id">
                                <option value="" selected>Veuiller choisir</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">
                                        {{ $service->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fin de l'ajout -->
                        <div class="mb-3 col-6">
                            <label for="designation" class="form-label">Designation</label>
                            <textarea class="form-control" id="designation" name="designation"></textarea>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="reference_article" class="form-label">Reference article</label>
                            <input type="text" class="form-control" id="reference_article" pattern="\d{4}-\d{1,9}"
                                name="reference_article">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="stock_initial" class="form-label">Stock initial</label>
                            <input type="text" class="form-control" id="stock_initial" name="stock_initial">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="entree" class="form-label">Entrée</label>
                            <input type="text" class="form-control" id="entree" name="entree">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="sortie" class="form-label">Sortie</label>
                            <input type="text" class="form-control" id="sortie" name="sortie">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="stock_final" class="form-label">Stock final</label>
                            <input type="text" class="form-control" id="stock_final" name="stock_final">
                        </div>
                    </div>
                    <!-- Ajoutez d'autres champs au besoin -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="saveStockService()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
