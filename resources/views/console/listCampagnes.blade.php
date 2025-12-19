@extends('layout.header.console')

@section('content')

<!-- Start Content -->
<div class="content pb-0">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div class="row col-12">
            <div class="col-sm-6">
                <h4 class="mb-0">{{ $title }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ $link_back }}">{{ $title_back }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-6">@include('layout.status')</div>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- start row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header d-flex align-items-center justify-content-between gap-2 flex-wrap">
                    <div class="table-search" style="margin-bottom:0 !important;">
                        <div class="search-input">
                            <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
                        </div>
                    </div>
                    <!-- Bouton déclencheur -->
                    <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal_add_campaign">
                        <i class="ti ti-square-rounded-plus-filled me-1"></i>Créer
                    </a>
                    <!-- <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Créer</a> -->
                </div>
                <!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>NOM DE CAMPAGNE</th>
                                    <th>NBRE D'ETAPES</th>
                                    <th>NBRE DE CANDIDATS</th>
                                    <th>CRÉÉE LE</th>
                                    <th>INSCRIPTION</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-uppercase fw-bold">Campagne N°001</td>
                                    <td>1 étape</td>
                                    <td>1 Candidats</td>
                                    <td>23/11/2025</td>
                                    <td>Autorisées</td>
                                    <td>
                                        <div class="d-inline-flex gap-2">
                                            <a href="{{ route('vue_campagne') }}" class="btn btn-icon btn-sm btn-success"><i class="ti ti-location"></i></a>
                                            <a class="btn btn-icon btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal_edit_campaign"><i class="ti ti-edit"></i></a>
                                            <a href="#;" class="btn btn-icon btn-sm btn-light"><i class="ti ti-menu-2"></i></a>
                                            <a class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-uppercase fw-bold">Campagne N°001</td>
                                    <td>3 étape</td>
                                    <td>25 Candidats</td>
                                    <td>23/11/2025</td>
                                    <td>Non-autorisées</td>
                                    <td>
                                        <div class="d-inline-flex gap-2">
                                            <a href="{{ route('vue_campagne') }}" class="btn btn-icon btn-sm btn-success"><i class="ti ti-location"></i></a>
                                            <a class="btn btn-icon btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal_edit_campaign"><i class="ti ti-edit"></i></a>
                                            <a href="#;" class="btn btn-icon btn-sm btn-light"><i class="ti ti-menu-2"></i></a>
                                            <a class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_contact"><i class="ti ti-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <!-- end row -->

</div>
<!-- End Content -->

<!-- Add offcanvas -->


<!-- Structure de la Modale -->
<div class="modal fade" id="modal_add_campaign" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter une nouvelle campagne</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('save_campagne') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- 2. INFORMATIONS PRINCIPALES -->
                    <input type="hidden" name="customer_id" value="0">
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required placeholder="Ex: Élection Miss 2024">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Promoteur <span class="text-danger">*</span></label>
                            <select class="select form-control form-select" name="customer_id" required>
                                <option value="">Sélectionner un Promoteur</option>
                                <option value="1">Promoteur A</option>
                                <option value="2">Promoteur B</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Décrivez la campagne<span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="4" name="description" required></textarea>
                        </div>
                    </div>

                    <!-- 1. IMAGE DE COUVERTURE (Mise en avant) -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Image de couverture <span class="text-danger">*</span></label>

                        <div class="position-relative w-100 rounded border border-dashed bg-light d-flex align-items-center justify-content-center overflow-hidden"
                            style="height: 250px; border-width: 2px !important; transition: all 0.3s ease;"
                            id="drop-zone">

                            <!-- Contenu par défaut -->
                            <div class="text-center p-4" id="upload-placeholder">
                                <div class="avatar avatar-lg bg-white border rounded-circle mb-2 mx-auto">
                                    <i class="ti ti-cloud-upload text-primary fs-3"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">Glissez une image ou cliquez</h6>
                                <p class="text-muted mb-0 fs-12">JPG, PNG. Max 5MB</p>
                            </div>

                            <!-- Image Preview -->
                            <img id="image-preview" src="#" alt="Aperçu" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover d-none">

                            <!-- Input File Invisible -->
                            <input type="file" name="image_couverture" id="input-image"
                                class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                accept="image/png, image/jpeg, image/jpg"
                                onchange="previewImage(this)">
                        </div>

                        <!-- Bouton Supprimer -->
                        <div class="d-flex justify-content-end mt-1">
                            <button type="button" id="remove-btn" class="btn btn-sm btn-link text-danger text-decoration-none d-none" onclick="removeImage()">
                                <i class="ti ti-trash me-1"></i> Supprimer l'image
                            </button>
                        </div>
                    </div>

                    <hr class="my-4 border-secondary opacity-10">
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="col-md-12 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitch" name="text_cover_isActive" value="0">
                                <label class="form-check-label" for="textCoverSwitch">Texte sur le cover</label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="col-md-12 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitch" name="identifiants_personnalises_isActive" value="0">
                                <label class="form-check-label" for="textCoverSwitch">Identifiants candidats personnalisés</label>
                            </div>
                        </div>
                    </div>

                    <!-- 3. CONFIGURATION & RÈGLES (Groupés sur fond gris) -->
                    <div class="bg-light p-3 rounded mb-4">

                        <div class="row">
                            <!-- Toggle Inscription -->
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="inscriptionSwitch" name="inscription_isActive" value="0">
                                    <label class="form-check-label fw-medium" for="inscriptionSwitch">Autoriser les inscriptions</label>
                                </div>
                            </div>

                            <!-- Bloc Conteneur (Masqué par défaut) -->
                            <div id="blocDates" style="display: none;">

                                <!-- Ligne Début -->
                                <div class="row">

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de début</label>
                                        <input type="date" class="form-control" name="inscription_date_debut">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de fin</label>
                                        <input type="date" class="form-control" name="inscription_date_fin">
                                    </div>


                                </div>

                                <!-- Ligne Fin -->
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Heure de début</label>
                                        <input type="time" class="form-control" name="heure_debut_inscription">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Heure de fin</label>
                                        <input type="time" class="form-control" name="heure_fin_inscription">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- 4. APPARENCE & OPTIONS -->
                    <div>
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Afficher les montants en pourcentage (%)</label>

                                <!-- Conteneur du groupe de boutons -->
                                <div class="btn-group w-100" role="group" aria-label="Affichage montant">

                                    <!-- Option 1 : Clair -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option1" value="clair" checked>
                                    <label class="btn btn-outline-custom" for="option1">Clair</label>

                                    <!-- Option 2 : Pourcentage -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option2" value="pourcentage">
                                    <label class="btn btn-outline-custom" for="option2">Pourcentage</label>

                                    <!-- Option 3 : Les deux -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option3" value="les_deux">
                                    <label class="btn btn-outline-custom" for="option3">Les deux</label>
                                </div>
                            </div>

                            <!-- Options Selects -->
                            <div class="bg-light p-3 rounded mb-3">
                                <div class="col-md-12 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitch" name="ordonner_candidats_votes_decroissants" value="0">
                                        <label class="form-check-label" for="textCoverSwitch">Ordonner les candidats par votes décroissants</label>
                                    </div>
                                </div>
                            </div>

                            <!-- 1. Quantité de votes (Tout en haut, pleine largeur) -->
                            <div class="col-12 mb-3">
                                <label class="form-label fw-medium">Quantité de votes visibles</label>
                                <input type="text" class="form-control" name="quantite_vote" placeholder="Ex: 10,20,50,100">
                                <!-- Texte d'aide en gris -->
                                <div class="form-text text-muted mt-2">
                                    Ce sont les quantités de votes que vos clients pourront choisir pour le paiement.
                                    <span class="fw-bold">Les packs dont le montant est inferieur à 200f seront ignorés.</span>
                                </div>
                            </div>

                            <!-- Couleurs -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Couleur Primaire</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="color_primaire" value="#000" title="Choisir">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Couleur Secondaire</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="color_secondaire" value="#000" title="Choisir">
                                </div>
                            </div>

                            <!-- 1. IMAGE DE COUVERTURE (Mise en avant) -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Condition de participation (Document)<span class="text-danger">*</span></label>

                                <div class="position-relative w-100 rounded border border-dashed bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                    style="height: 250px; border-width: 2px !important; transition: all 0.3s ease;"
                                    id="drop-zone">

                                    <!-- Contenu par défaut -->
                                    <div class="text-center p-4" id="upload-placeholder">
                                        <div class="avatar avatar-lg bg-white border rounded-circle mb-2 mx-auto">
                                            <i class="ti ti-cloud-upload text-primary fs-3"></i>
                                        </div>
                                        <h6 class="mb-1 fw-bold">Glissez un PDF ou cliquez</h6>
                                        <p class="text-muted mb-0 fs-12">PDF. Max 5MB</p>
                                    </div>

                                    <!-- Image Preview -->
                                    <img id="pdf-preview" src="#" alt="Aperçu" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover d-none">

                                    <!-- Input File Invisible -->
                                    <input type="file" name="condition_participation" id="input-image"
                                        class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                        accept=".pdf">
                                </div>

                                <!-- Bouton Supprimer -->
                                <div class="d-flex justify-content-end mt-1">
                                    <button type="button" id="remove-btn" class="btn btn-sm btn-link text-danger text-decoration-none d-none" onclick="removeImage()">
                                        <i class="ti ti-trash me-1"></i> Supprimer l'image
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="modal-footer border-top px-0 pb-0 mt-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-check me-1"></i> Créer la campagne</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add offcanvas -->

<!-- edit offcanvas -->
<!-- Modale de modification (ID statique pour test) -->
<div class="modal fade" id="modal_edit_campaign" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Modifier la campagne : Campagne Été 2024</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('save_campagne') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- 2. INFORMATIONS PRINCIPALES -->
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom de la campagne <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required placeholder="Ex: Élection Miss 2024">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Promoteur <span class="text-danger">*</span></label>
                            <select class="select form-control form-select" name="customer_id" required>
                                <option value="">Sélectionner un Promoteur</option>
                                <option value="1">Promoteur A</option>
                                <option value="2">Promoteur B</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Décrivez la campagne<span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="4" name="description" required></textarea>
                        </div>
                    </div>

                    <!-- 1. IMAGE DE COUVERTURE (Mise en avant) -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Image de couverture <span class="text-danger">*</span></label>

                        <div class="position-relative w-100 rounded border border-dashed bg-light d-flex align-items-center justify-content-center overflow-hidden"
                            style="height: 250px; border-width: 2px !important; transition: all 0.3s ease;"
                            id="drop-zone">

                            <!-- Contenu par défaut -->
                            <div class="text-center p-4" id="upload-placeholder">
                                <div class="avatar avatar-lg bg-white border rounded-circle mb-2 mx-auto">
                                    <i class="ti ti-cloud-upload text-primary fs-3"></i>
                                </div>
                                <h6 class="mb-1 fw-bold">Glissez une image ou cliquez</h6>
                                <p class="text-muted mb-0 fs-12">JPG, PNG. Max 5MB</p>
                            </div>

                            <!-- Image Preview -->
                            <img id="image-preview" src="#" alt="Aperçu" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover d-none">

                            <!-- Input File Invisible -->
                            <input type="file" name="image_couverture" id="input-image"
                                class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                accept="image/png, image/jpeg, image/jpg"
                                onchange="previewImage(this)">
                        </div>

                        <!-- Bouton Supprimer -->
                        <div class="d-flex justify-content-end mt-1">
                            <button type="button" id="remove-btn" class="btn btn-sm btn-link text-danger text-decoration-none d-none" onclick="removeImage()">
                                <i class="ti ti-trash me-1"></i> Supprimer l'image
                            </button>
                        </div>
                    </div>

                    <hr class="my-4 border-secondary opacity-10">
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="col-md-12 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitch" name="text_cover_isActive" value="0">
                                <label class="form-check-label" for="textCoverSwitch">Texte sur le cover</label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="col-md-12 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitch" name="identifiants_personnalises_isActive" value="0">
                                <label class="form-check-label" for="textCoverSwitch">Identifiants candidats personnalisés</label>
                            </div>
                        </div>
                    </div>

                    <!-- 3. CONFIGURATION & RÈGLES (Groupés sur fond gris) -->
                    <div class="bg-light p-3 rounded mb-4">

                        <div class="row">
                            <!-- Toggle Inscription -->
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="inscriptionSwitch" name="inscription_isActive" value="0">
                                    <label class="form-check-label fw-medium" for="inscriptionSwitch">Autoriser les inscriptions</label>
                                </div>
                            </div>

                            <!-- Bloc Conteneur (Masqué par défaut) -->
                            <div id="blocDates" style="display: none;">

                                <!-- Ligne Début -->
                                <div class="row">

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de début</label>
                                        <input type="date" class="form-control" name="inscription_date_debut">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Date de fin</label>
                                        <input type="date" class="form-control" name="inscription_date_fin">
                                    </div>


                                </div>

                                <!-- Ligne Fin -->
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Heure de début</label>
                                        <input type="time" class="form-control" name="heure_debut_inscription">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Heure de fin</label>
                                        <input type="time" class="form-control" name="heure_fin_inscription">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- 4. APPARENCE & OPTIONS -->
                    <div>
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Afficher les montants en pourcentage (%)</label>

                                <!-- Conteneur du groupe de boutons -->
                                <div class="btn-group w-100" role="group" aria-label="Affichage montant">

                                    <!-- Option 1 : Clair -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option1" value="clair" checked>
                                    <label class="btn btn-outline-custom" for="option1">Clair</label>

                                    <!-- Option 2 : Pourcentage -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option2" value="pourcentage">
                                    <label class="btn btn-outline-custom" for="option2">Pourcentage</label>

                                    <!-- Option 3 : Les deux -->
                                    <input type="radio" class="btn-check" name="afficher_montant_pourcentage" id="option3" value="les_deux">
                                    <label class="btn btn-outline-custom" for="option3">Les deux</label>
                                </div>
                            </div>

                            <!-- Options Selects -->
                            <div class="bg-light p-3 rounded mb-3">
                                <div class="col-md-12 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" role="switch" id="textCoverSwitch" name="ordonner_candidats_votes_decroissants" value="0">
                                        <label class="form-check-label" for="textCoverSwitch">Ordonner les candidats par votes décroissants</label>
                                    </div>
                                </div>
                            </div>

                            <!-- 1. Quantité de votes (Tout en haut, pleine largeur) -->
                            <div class="col-12 mb-3">
                                <label class="form-label fw-medium">Quantité de votes visibles</label>
                                <input type="text" class="form-control" name="quantite_vote" placeholder="Ex: 10,20,50,100">
                                <!-- Texte d'aide en gris -->
                                <div class="form-text text-muted mt-2">
                                    Ce sont les quantités de votes que vos clients pourront choisir pour le paiement.
                                    <span class="fw-bold">Les packs dont le montant est inferieur à 200f seront ignorés.</span>
                                </div>
                            </div>

                            <!-- Couleurs -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Couleur Primaire</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="color_primaire" value="#000" title="Choisir">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Couleur Secondaire</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" name="color_secondaire" value="#000" title="Choisir">
                                </div>
                            </div>

                            <!-- 1. IMAGE DE COUVERTURE (Mise en avant) -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Condition de participation (Document)<span class="text-danger">*</span></label>

                                <div class="position-relative w-100 rounded border border-dashed bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                    style="height: 250px; border-width: 2px !important; transition: all 0.3s ease;"
                                    id="drop-zone">

                                    <!-- Contenu par défaut -->
                                    <div class="text-center p-4" id="upload-placeholder">
                                        <div class="avatar avatar-lg bg-white border rounded-circle mb-2 mx-auto">
                                            <i class="ti ti-cloud-upload text-primary fs-3"></i>
                                        </div>
                                        <h6 class="mb-1 fw-bold">Glissez un PDF ou cliquez</h6>
                                        <p class="text-muted mb-0 fs-12">PDF. Max 5MB</p>
                                    </div>

                                    <!-- Image Preview -->
                                    <img id="pdf-preview" src="#" alt="Aperçu" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover d-none">

                                    <!-- Input File Invisible -->
                                    <input type="file" name="condition_participation" id="input-image"
                                        class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                        accept=".pdf">
                                </div>

                                <!-- Bouton Supprimer -->
                                <div class="d-flex justify-content-end mt-1">
                                    <button type="button" id="remove-btn" class="btn btn-sm btn-link text-danger text-decoration-none d-none" onclick="removeImage()">
                                        <i class="ti ti-trash me-1"></i> Supprimer l'image
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="modal-footer border-top px-0 pb-0 mt-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-check me-1"></i> Créer la campagne</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /edit offcanvas -->

<!-- delete modal -->
<div class="modal fade" id="delete_contact">
    <div class="modal-dialog modal-dialog-centered modal-sm rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-body p-4 text-center position-relative">
                <div class="mb-3 position-relative z-1">
                    <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle"><i class="ti ti-trash fs-24"></i></span>
                </div>
                <h5 class="mb-1">Confirmer la suppression</h5>
                <p class="mb-3">Êtes-vous sûr de vouloir supprimer l'entreprise sélectionnée ?</p>
                <!-- Formulaire de suppression -->
                <form  method="POST" action="{{ route('delete_campagne') }}">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-center">
                        <input type="hidden" name="campagne_id" value="">
                        <button type="button" class="btn btn-light position-relative z-1 me-2 w-100" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary position-relative z-1 w-100">Oui, supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- delete modal -->


<!-- Script JavaScript pour gérer l'affichage -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const switchBtn = document.getElementById('inscriptionSwitch');
        const blocDates = document.getElementById('blocDates');

        // Fonction pour afficher/masquer
        function toggleDates() {
            if (switchBtn.checked) {
                blocDates.style.display = 'flex'; // 'flex' car c'est une row bootstrap
            } else {
                blocDates.style.display = 'none';
                // Optionnel : Réinitialiser les dates si on décoche
                // blocDates.querySelectorAll('input').forEach(input => input.value = '');
            }
        }

        // Écouter le changement (clic)
        switchBtn.addEventListener('change', toggleDates);

        // Vérifier l'état au chargement de la page (utile en cas d'erreur de formulaire ou d'édition)
        toggleDates();
    });
</script>
@endsection
<!-- section js -->
@section('extra-js')

@endsection