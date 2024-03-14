<!-- Modal générique pour ajout/modification -->
<div class="modal fade" id="articleModal" tabindex="-1" role="dialog" aria-labelledby="articleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="articleModalLabel">Ajouter/Modifier stock par service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter/modifier -->
                <form id="articleForm" enctype="multipart/form-data">
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
                        <div class="mb-3 col-6">
                            <label for="reference_mouvement" class="form-label">Reference mouvement</label>
                            <input type="text" class="form-control" id="reference_mouvement"
                                name="reference_mouvement">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="compte_PCOP" class="form-label">Compte PCOP</label>
                            <input type="text" class="form-control" id="compte_PCOP" name="compte_PCOP">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="reference" class="form-label">Reference article</label>
                            <input type="text" class="form-control" id="reference" name="reference">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="designation" class="form-label">Designation</label>
                            <textarea class="form-control" id="designation" name="designation"></textarea>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="conditionnement" class="form-label">Conditionnement</label>
                            <input type="text" class="form-control" id="conditionnement" name="conditionnement">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="unite" class="form-label">Unité</label>
                            <input type="text" class="form-control" id="unite" name="unite">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="date_peremption" class="form-label">Date de péremption</label>
                            <input type="date" class="form-control" id="date_peremption" name="date_peremption">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="provenance" class="form-label">Provenance</label>
                            <input type="text" class="form-control" id="provenance" name="provenance">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="entree" class="form-label">Entrée</label>
                            <input type="text" class="form-control" id="entree" name="entree">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="etat_article" class="form-label">Etat article</label>
                            <input type="text" class="form-control" id="etat_article" name="etat_article">
                        </div>
                    </div>
                    <!-- Ajoutez d'autres champs au besoin -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="saveArticle()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
