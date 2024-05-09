<!-- Modal générique pour ajout/modification -->
<div class="modal fade" id="personnelModal" tabindex="-1" role="dialog" aria-labelledby="personnelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="personnelModalLabel">Ajouter/Modifier un personnel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter/modifier -->
                <form id="personnelForm">
                    <!-- Champs du formulaire -->
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="nom" class="form-label">Nom:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="nom" name="nom">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="prenom" class="form-label">Prénom:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="prenom" name="prenom">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="cin" class="form-label">CIN:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="cin" name="cin" data-inputmask="'mask': '999 999 999 999'">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="date_cin" class="form-label">Date création CIN:</label>
                                <input type="date" class="form-control form-control-border border-width-2"
                                    id="date_cin" name="date_cin">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="com_cin" class="form-label">Communne CIN:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="com_cin" name="com_cin">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="duplicata" class="form-label">Duplicata:</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="duplicata" name="duplicata">
                                    <label class="form-check-label" for="duplicata">Duplicata</label>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <div
                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="duplicata" name="duplicata">
                                    <label class="custom-control-label" for="duplicata">Duplicata</label>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="date_duplicata" class="form-label">Date Duplicata:</label>
                                <input type="date" class="form-control form-control-border border-width-2"
                                    id="date_duplicata" name="date_duplicata">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="ddn" class="form-label">Date de naissance:</label>
                                <input type="date" class="form-control form-control-border border-width-2"
                                    id="ddn" name="ddn" onchange="calculateAge()">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="age" class="form-label">Age:</label>
                                <input type="number" class="form-control form-control-border border-width-2"
                                    id="age" name="age" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            {{-- <div class="form-group">
                                <label for="genre" class="form-label">Genre:</label>
                                <select class="form-select" id="genre" name="genre">
                                    <option value="Masculin">Masculin</option>
                                    <option value="Féminin">Féminin</option>
                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label for="genre" class="form-label">Genre</label>
                                <select class="custom-select" id="genre" name="genre">
                                    <option value="Masculin">Masculin</option>
                                    <option value="Féminin">Féminin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="service_id" class="form-label">Service</label>
                                <select class="custom-select" id="service_id" name="service_id">
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="adresse" class="form-label">Adresse:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="adresse" name="adresse">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control form-control-border border-width-2"
                                    id="email" name="email">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="contact" class="form-label">Contact:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="contact" name="contact" data-inputmask="'mask': '+999 99 99 999 99'">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="fonction" class="form-label">Fonction:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="fonction" name="fonction">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="matricule" class="form-label">Matricule:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="matricule" name="matricule" data-inputmask="'mask': '999 999'">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="indice" class="form-label">Indice:</label>
                                <input type="number" class="form-control form-control-border border-width-2"
                                    id="indice" name="indice">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="corps" class="form-label">Corps:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="corps" name="corps">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="grade" class="form-label">Grade:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="grade" name="grade">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="date_effet_avancement" class="form-label">Date Effet Avancement:</label>
                                <input type="date" class="form-control form-control-border border-width-2"
                                    id="date_effet_avancement" name="date_effet_avancement">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="fin_date_effet_avancement" class="form-label">Fin Date Effet
                                    Avancement:</label>
                                <input type="date" class="form-control form-control-border border-width-2"
                                    id="fin_date_effet_avancement" name="fin_date_effet_avancement">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="classe" class="form-label">Classe:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="classe" name="classe">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="echelon" class="form-label">Échelon:</label>
                                <input type="text" class="form-control form-control-border border-width-2"
                                    id="echelon" name="echelon">
                            </div>
                        </div>
                        <!-- Ajoutez d'autres champs si nécessaire -->
                    </div>


                    <!-- Ajoutez d'autres champs au besoin -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="savePersonnel()">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
