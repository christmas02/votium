@extends('layout.header.business')

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

    <!-- table header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">

            <div class="input-icon input-icon-start position-relative">
                <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">

            <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_candidat"><i class="ti ti-square-rounded-plus-filled me-1"></i>Créer</a>
            <div class="gap-2 d-flex align-items-center flex-wrap">
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><i class="ti ti-package-import me-2"></i>Importer</a>
                    <div class="dropdown-menu  dropdown-menu-end">
                        <ul>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-pdf me-1"></i>Importe en CSV </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-xls me-1"></i>Importe en Excel </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- table header -->

    <!-- Contact Grid -->
    <div class="row">
        <div class="col-xl-3 ">
            <div class="row mb-1">
                <div class="col-xl-12">

                    <div class="row mb-4 card card-body">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Choisir la campagne</label>
                            <select class="select form-control form-select js-select-campagne">
                                <option value="" selected disabled>Sélectionner</option>
                                @foreach($campagnes as $campagne)
                                <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Choisir l'étape</label>
                            <select class="select form-control form-select js-select-etape">
                                <option value="" selected disabled>Sélectionner</option>
                                @foreach($etapes as $etape)
                                <option value="{{ $etape->etape_id }}">{{ $etape->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Choisir la catégorie</label>
                            <select class="select form-control form-select js-select-categorie">
                                <option value="" selected disabled>Sélectionner</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                </div>

            </div>

        </div>


        <div class="col-xl-9">
            <div class="row bg-light js-candidat-table-body">
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="#"
                                        class="avatar avatar-xl flex-shrink-0 me-2">
                                        <img src="assets/img/profiles/avatar-19.jpg" alt="img" class="rounded-1">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="#" class="fw-medium">Da Robertson</a></h6>
                                        <p class="text-default mb-0">Num: 001</p>
                                        <p class="text-default mb-0">Age: 36 ans</p>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal_edit_candidat"><i
                                                class="ti ti-edit text-blue"></i> Modifier</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Supprimer</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ti ti-eye text-blue-light"></i> Voir</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>


    </div>
    <!-- /Contact Grid -->

    <!-- <div class="load-btn text-center">
        <a href="javascript:void(0);" class="btn btn-primary"><i class="ti ti-loader me-1"></i> Load More</a>
    </div> -->

</div>
<!-- End Content -->

<!-- Add offcanvas -->


<!-- Structure de la Modale -->
<div class="modal fade" id="modal_add_candidat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter candidat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('business.save_candidat') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <!-- ================= PHOTO ================= -->
                        <div class="col-md-12 mb-4">
                            <div class="d-flex align-items-center bg-light p-3 rounded">
                                <div class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">
                                    <i class="ti ti-photo text-muted fs-4" id="logo_placeholder"></i>
                                    <img src="#" alt="Aperçu" id="logo_preview" class="d-none w-100 h-100 object-fit-cover">
                                </div>

                                <div>
                                    <label class="form-label mb-1">Photo du candidat</label>
                                    <input type="file"
                                        class="form-control form-control-sm"
                                        name="photo"
                                        id="logo_input"
                                        accept="image/png, image/gif, image/jpeg"
                                        onchange="previewLogo(this)">
                                    <small class="text-muted">JPG, PNG ou GIF – max 800 Ko</small>
                                </div>
                            </div>
                        </div>

                        <!-- ================= IDENTITÉ ================= -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nom" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="prenom" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sexe <span class="text-danger">*</span></label>
                            <select class="form-select" name="sexe" required>
                                <option value="">Choisir</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_naissance" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Profession <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="profession" required>
                        </div>

                        <!-- ================= CONTACT ================= -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="telephone" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="candidat@exemple.com" required>
                        </div>

                        <!-- ================= LOCALISATION ================= -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pays <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pays" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ville <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ville" required>
                        </div>

                        <!-- ================= CANDIDATURE ================= -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Campagne <span class="text-danger">*</span></label>
                            <select class="form-select" name="campagne_id" required>
                                <option value="">Sélectionner une campagne</option>
                                <option value="1">Campagne A</option>
                                <option value="2">Campagne B</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Catégorie</label>
                            <select class="form-select" name="category_id">
                                <option value="">Sélectionner</option>
                                <option value="1">Catégorie A</option>
                                <option value="2">Catégorie B</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Étape <span class="text-danger">*</span></label>
                            <select class="form-select" name="etape_id" required>
                                <option value="">Sélectionner</option>
                                <option value="1">Étape A</option>
                                <option value="2">Étape B</option>
                            </select>
                        </div>

                        <!-- ================= DESCRIPTION ================= -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Présentation du candidat <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" rows="4" required
                                placeholder="Parlez brièvement de lui, son parcours, ces ambitions..."></textarea>
                        </div>

                    </div>

                    <!-- Modal Footer (Actions) -->
                    <div class="modal-footer border-top mt-4 pb-0 px-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Enregistrer</button>
                    </div>
                    <!-- ... -->
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add offcanvas -->

<!-- Structure de la Modale -->
<div class="modal fade" id="modal_add_categorie" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <!-- @csrf -->
                    <div>
                        <div class="row">

                            <!-- Nom Entreprise -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nom catégorie <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="entreprise" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la campagne <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner une campagne</option>
                                    <option value="1">Campagne A</option>
                                    <option value="2">Campagne B</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir l'étape <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="customer_id" required>
                                    <option value="">Sélectionner l'étape</option>
                                    <option value="1">Etape A</option>
                                    <option value="2">Etape B</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- Modal Footer (Actions) -->
                    <div class="modal-footer border-top mt-4 pb-0 px-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Enregistrer</button>
                    </div>
                    <!-- ... -->
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add offcanvas -->

<!-- edit offcanvas -->
<!-- Modale de modification (ID statique pour test) -->
<div class="modal fade" id="modal_edit_candidat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Modifier candidat : Kini KONIN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <!-- @csrf -->
                    <div>
                        <div class="row">
                            <!-- Logo Upload avec Prévisualisation -->
                            <div class="col-md-12 mb-3">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <!-- Zone de l'image -->
                                    <div class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">
                                        <!-- Icône par défaut (sera cachée au chargement) -->
                                        <i class="ti ti-photo text-muted fs-4" id="logo_placeholder"></i>

                                        <!-- Image de prévisualisation (cachée par défaut) -->
                                        <img src="#" alt="Aperçu" id="logo_preview" class="d-none w-100 h-100 object-fit-cover">
                                    </div>

                                    <div class="d-flex flex-column">
                                        <label class="form-label mb-1">Image du candidat</label>
                                        <!-- Ajout de l'événement onchange -->
                                        <input type="file"
                                            class="form-control form-control-sm"
                                            name="photo"
                                            id="logo_input"
                                            accept="image/png, image/gif, image/jpeg"
                                            onchange="previewLogo(this)">
                                        <small class="text-muted">JPG, GIF ou PNG. Max 800K</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Nom Entreprise -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nom" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="prenom" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sexe <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="sexe" required>
                                    <option value="">Choix</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>

                            <!-- Téléphone -->
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" name="telephone" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="email" placeholder="candidat@exemple.com" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Pays <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" name="pays" required>
                            </div>
                            <!-- Ville -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Ville <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="ville" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Profession <span class="text-danger">*</span></label>
                                <input type="text" class="form-control phone" name="profession" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la campagne <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="campagne_id" required>
                                    <option value="">Sélectionner une campagne</option>
                                    <option value="1">Campagne A</option>
                                    <option value="2">Campagne B</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir la catégorie <span class="text-danger"></span></label>
                                <select class="select form-control form-select" name="category_id">
                                    <option value="">Sélectionner la catégorie</option>
                                    <option value="1">Catégorie A</option>
                                    <option value="2">Catégorie B</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Choisir l'étape <span class="text-danger">*</span></label>
                                <select class="select form-control form-select" name="etape_id" required>
                                    <option value="">Sélectionner l'étape</option>
                                    <option value="1">Etape A</option>
                                    <option value="2">Etape B</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- Modal Footer (Actions) -->
                    <div class="modal-footer border-top mt-4 pb-0 px-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Enregistrer</button>
                    </div>
                    <!-- ... -->
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
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-light position-relative z-1 me-2 w-100" data-bs-dismiss="modal">Annuler</a>
                    <a href="#" class="btn btn-primary position-relative z-1 w-100" data-bs-dismiss="modal">Oui, supprimer</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- delete modal -->


<!-- Script JavaScript pour gérer l'affichage -->
<script>
    // Ce script centralise toute la logique jQuery pour la gestion des étapes de campagne
    $(document).ready(function() {


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //-- 1. SELECTION DE CAMPAGNE
        $(document).on('change', '.js-select-campagne', function() {
            const id = $(this).val();


            // 3. REQUÊTE AJAX POUR RÉCUPÉRER LES ÉTAPES
            $.ajax({
                url: `/business/recherche_candidat/${id}`,
                method: 'GET',
                success: function(candidats) {
                    renderEtapeTable(candidats);
                },
                error: function() {
                    $('.js-candidat-table-body').html('<div class="col-xxl-12 col-xl-12 col-md-12"><p class="text-danger">Erreur de chargement.</p></div>');
                }
            });
        });

        // --- 2. FONCTION DE RENDU DU TABLEAU ---
        function renderEtapeTable(candidats) {
            let html = '';
            if (candidats.length === 0) {
                html = '<div class="col-xxl-12 col-xl-12 col-md-12"><p class="text-center">Aucun candidat trouvé.</p></div>';
            } else {
                candidats.forEach(candidat => {
                    // On stocke l'objet entier en JSON dans un attribut data pour l'édition
                    const candidatData = encodeURIComponent(JSON.stringify(candidat));
                    html += `
                    <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="#"
                                        class="avatar avatar-xl flex-shrink-0 me-2">
                                        <img src="{{ env('IMAGES_PATH') }}/${candidat.photo}" alt="img" class="rounded-1">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="#" class="fw-medium">${candidat.nom} ${candidat.prenom}</a></h6>
                                        <p class="text-default mb-0">Num: 00${candidat.id}</p>
                                        <p class="text-default mb-0">Date de naissance: ${candidat.date_naissance}</p>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item js-btn-edit" data-candidat="${candidatData}"><i
                                                class="ti ti-edit text-blue"></i> Modifier</a>
                                        <a class="dropdown-item js-btn-delete" data-id="${candidat.candidat_id}"><i
                                                class="ti ti-trash"></i> Supprimer</a>
                                        <a class="dropdown-item" href="#"><i
                                                class="ti ti-eye text-blue-light"></i> Voir</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                `;
                });
            }
            $('.js-candidat-table-body').html(html);
        }

        // --- 3. OUVERTURE MODAL ÉDITION ---
        $(document).on('click', '.js-btn-edit', function() {
            const data = JSON.parse(decodeURIComponent($(this).data('etape')));
            const $modal = $('#modal_update_step');

            // Remplissage des champs du modal par leurs noms
            $modal.find('input[name="candidat_id"]').val(data.candidat_id);
           

            // Remplissage des packages
            renderUpdatePackages(data.package, $modal);

            $modal.modal('show');
        });

        // --- 4. OUVERTURE MODAL SUPPRESSION ---
        $(document).on('click', '.js-btn-delete', function() {
            const id = $(this).data('id');
            const $modal = $('#modal_delete_step');
            $modal.find('.js-confirm-delete').attr('data-id', id);
            $modal.modal('show');
        });

        // --- 5. ACTION SUPPRIMER ---
        $(document).on('click', '.js-confirm-delete', function() {
            const id = $(this).data('id');
            const $btn = $(this);

            // Désactiver le bouton pendant le chargement
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>...');

            $.ajax({
                url: `/business/delete_etape/${id}`,
                method: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#modal_delete_step').modal('hide');

                    if (response.success) {
                        showAjaxAlert('success', response.message);
                    }

                    // Rafraîchir le tableau
                    $('.js-select-campagne').trigger('change');
                },
                error: function(xhr) {
                    $('#modal_delete_step').modal('hide');
                    let msg = "Erreur lors de la suppression.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    showAjaxAlert('danger', msg);
                },
                complete: function() {
                    // Réinitialiser le bouton
                    $btn.prop('disabled', false).text('Supprimer');
                }
            });
        });

    });
</script>
@endsection
<!-- section js -->
@section('extra-js')

@endsection