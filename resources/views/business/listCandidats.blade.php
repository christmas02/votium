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
                <input type="text" class="form-control js-search-candidat" placeholder="rechercher un candidat...">
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
                <!-- Les cartes des candidats seront chargées ici via AJAX -->

            </div>
        </div>


    </div>
    <!-- /Contact Grid -->

    <!-- Bouton Load More (Ajouter l'ID et cacher par défaut) -->
    <div class="load-btn text-center justify-content-center p-4" id="load-more-container" style="display: none;">
        <a href="javascript:void(0);" class="btn btn-primary js-load-more">
            <i class="ti ti-loader me-1"></i> Charger plus
        </a>
    </div>

</div>
<!-- End Content -->

<!-- Add offcanvas -->


<!-- Structure de la Modale -->
<div class="modal fade" id="modal_add_candidat" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter candidat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.save_candidat') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <!-- Logo Upload avec Prévisualisation -->
                        <div class="col-md-12 mb-3 image-upload-group">
                            <div class="d-flex align-items-center bg-light p-2 rounded">
                                <!-- Zone de l'image -->
                                <div class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">
                                    <!-- Placeholder -->
                                    <i class="ti ti-photo text-muted fs-4 placeholder-target"></i>
                                    <!-- Preview -->
                                    <img src="#" alt="Aperçu" class="preview-target d-none w-100 h-100 object-fit-cover">
                                </div>

                                <div class="d-flex flex-column">
                                    <label class="form-label mb-1">Logo de l'entreprise</label>
                                    <input type="file"
                                        class="form-control form-control-sm"
                                        name="photo"
                                        accept="image/*"
                                        onchange="handleImagePreview(this)">
                                    <small class="text-muted">JPG, GIF ou PNG. Max 800K</small>

                                    <!-- Bouton supprimer pour le logo (optionnel) -->
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0 d-none remove-btn-target text-start" onclick="handleImageRemove(this)">
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- ================= IDENTITÉ ================= -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom complet<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
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
                                @foreach($campagnes as $campagne)
                                <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Catégorie</label>
                            <select class="form-select" name="category_id">
                                <option value="">Sélectionner</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Étape <span class="text-danger">*</span></label>
                            <select class="form-select" name="etape_id" required>
                                <option value="">Sélectionner</option>
                                @foreach($etapes as $etape)
                                <option value="{{ $etape->etape_id }}">{{ $etape->name }}</option>
                                @endforeach
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

<!-- edit offcanvas -->
<!-- Modale de modification (ID statique pour test) -->
<div class="modal fade" id="modal_edit_candidat" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Modifier le candidat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- L'action sera définie dynamiquement en JS -->
                <form id="form_edit_candidat" action="{{ route('business.update_candidat') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="candidat_id">
                    <input type="hidden" name="old_photo">
                    <div class="modal-body">
                        <div class="row">
                            <!-- Logo Upload avec Prévisualisation -->
                            <div class="col-md-12 mb-3 image-upload-group">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <!-- Zone de l'image -->
                                    <div class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">
                                        <!-- Placeholder -->
                                        <i class="ti ti-photo text-muted fs-4 placeholder-target"></i>
                                        <!-- Preview -->
                                        <img src="#" alt="Aperçu" class="preview-target d-none w-100 h-100 object-fit-cover">
                                    </div>

                                    <div class="d-flex flex-column">
                                        <label class="form-label mb-1">Photo du candidat</label>
                                        <input type="file"
                                            class="form-control form-control-sm"
                                            name="photo"
                                            accept="image/*"
                                            onchange="handleImagePreview(this)">
                                        <small class="text-muted">JPG, GIF ou PNG. Max 800K</small>

                                        <!-- Bouton supprimer pour le logo (optionnel) -->
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0 d-none remove-btn-target text-start" onclick="handleImageRemove(this)">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- IDENTITÉ -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nom complet<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sexe <span class="text-danger">*</span></label>
                                <select class="form-select" name="sexe" required>
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

                            <!-- CONTACT -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="telephone" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <!-- LOCALISATION -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pays <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pays" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ville <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="ville" required>
                            </div>

                            <!-- CANDIDATURE -->
                            <!-- <div class="col-md-12 mb-3">
                                <label class="form-label">Campagne <span class="text-danger">*</span></label>
                                <select class="form-select" name="campagne_id">
                                    @foreach($campagnes as $campagne)
                                    <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Catégorie</label>
                                <select class="form-select" name="category_id">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Étape <span class="text-danger">*</span></label>
                                <select class="form-select" name="etape_id" >
                                    @foreach($etapes as $etape)
                                    <option value="{{ $etape->etape_id }}">{{ $etape->name }}</option>
                                    @endforeach
                                </select>
                            </div> -->

                            <!-- DESCRIPTION -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Présentation du candidat <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="description" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /edit offcanvas -->

<!-- delete modal -->
<div class="modal fade" id="delete_contact" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <!-- On enveloppe le contenu dans le formulaire -->
            <form id="form_delete_candidat" action="{{ route('business.delete_candidat') }}" method="POST">
                @csrf
                @method('DELETE') <!-- Bonne pratique Laravel pour la suppression -->

                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle">
                            <i class="ti ti-trash fs-24"></i>
                        </span>
                    </div>
                    <h5 class="mb-1">Confirmer la suppression</h5>
                    <p class="mb-3">Êtes-vous sûr de vouloir supprimer ce candidat ?</p>

                    <!-- Input caché pour l'ID -->
                    <input type="hidden" name="candidat_id">

                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-light me-2 w-100" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger w-100">Oui, supprimer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- delete modal -->


<!-- Script JavaScript pour gérer l'affichage -->
<script>
    // Ce script centralise toute la logique jQuery pour la gestion des étapes de campagne
    $(document).ready(function() {
        let currentPage = 1;
        let searchTimeout = null;
        const APP_IMAGES_PATH = "{{ env('IMAGES_PATH') }}/";

        // --- ÉVÉNEMENTS ---

        // 1. Recherche : On reset la page à 1 et on vide la liste
        $(document).on('keyup', '.js-search-candidat', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                currentPage = 1;
                chargerCandidats(false);
            }, 500); // Délai de 500ms pour ne pas harceler le serveur
        });

        // 2. Filtres Select : On reset la page à 1
        $(document).on('change', '.js-select-campagne, .js-select-etape, .js-select-categorie', function() {
            currentPage = 1;
            chargerCandidats(false);
        });

        // 3. Bouton Load More
        $(document).on('click', '.js-load-more', function() {
            currentPage++;
            chargerCandidats(true); // "true" pour ajouter à la suite
        });

        // --- FONCTION AJAX ---

        function chargerCandidats(append = false) {
            const campagneId = $('.js-select-campagne').val();
            // if (!campagneId) return; // Sécurité : on attend au moins la campagne

            const params = {
                campagne_id: campagneId,
                etape_id: $('.js-select-etape').val(),
                category_id: $('.js-select-categorie').val(),
                search: $('.js-search-candidat').val(),
                page: currentPage
            };

            if (!append) {
                $('.js-candidat-table-body').html('<div class="col-12 text-center p-5"><div class="spinner-border text-primary"></div></div>');
            }

            $.ajax({
                url: `/business/recherche_candidat`,
                method: 'GET',
                data: params,
                success: function(response) {
                    // IMPORTANT : On utilise response.data car on a paginé manuellement dans le contrôleur
                    renderCandidatCards(response.data, append);

                    // Affichage du bouton Load More
                    if (response.current_page < response.last_page) {
                        $('.load-btn').show();
                    } else {
                        $('.load-btn').hide();
                    }
                }
            });
        }

        function renderCandidatCards(candidats, append) {
            let html = '';
            if (candidats.length === 0 && !append) {
                html = '<div class="col-12"><p class="text-center bg-white p-4 shadow-sm">Aucun candidat trouvé.</p></div>';
                $('.js-candidat-table-body').html(html);
                return;
            }

            candidats.forEach((candidat, index) => {
                const data = encodeURIComponent(JSON.stringify(candidat));
                const photoUrl = candidat.photo ? APP_IMAGES_PATH + candidat.photo : 'assets/img/profiles/avatar-01.jpg';
                const orderNum = ((currentPage - 1) * 12) + (index + 1);

                html += `
                    <div class="col-xxl-3 col-xl-4 col-md-6 mb-3">
                        <div class="card border shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xl flex-shrink-0 me-2">
                                            <img src="${photoUrl}" class="rounded-1 object-fit-cover w-100 h-100">
                                        </div>
                                        <div>
                                            <h6 class="fs-14 mb-0"><a href="#" class="fw-medium text-dark">${candidat.name}</a></h6>
                                            <p class="text-muted mb-0 small">Num: ${String(orderNum).padStart(3, '0')}</p>
                                            <p class="text-muted mb-0 small">Âge: ${calculerAge(candidat.date_naissance)}</p>
                                            <p class="text-muted mb-0 small">${candidat.profession || ''}</p>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item js-btn-edit" href="javascript:void(0);" data-candidat="${data}"><i class="ti ti-edit text-blue me-1"></i> Modifier</a>
                                            <a class="dropdown-item js-btn-delete" href="javascript:void(0);" data-id="${candidat.candidat_id}"><i class="ti ti-trash text-danger me-1"></i> Supprimer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
            });

            if (append) {
                $('.js-candidat-table-body').append(html);
            } else {
                $('.js-candidat-table-body').html(html);
            }
        }

        // Gestion de l'édition (Remplissage de la modale)
        $(document).on('click', '.js-btn-edit', function() {
            const data = JSON.parse(decodeURIComponent($(this).data('candidat')));
            const $modal = $('#modal_edit_candidat');

            // Remplissage des champs

            $modal.find('input[name="candidat_id"]').val(data.candidat_id);
            $modal.find('input[name="old_photo"]').val(data.photo);
            $modal.find('input[name="name"]').val(data.name);
            $modal.find('select[name="sexe"]').val(data.sexe);
            $modal.find('input[name="date_naissance"]').val(data.date_naissance);
            $modal.find('input[name="telephone"]').val(data.phonenumber);
            $modal.find('input[name="email"]').val(data.email);
            $modal.find('input[name="pays"]').val(data.pays);
            $modal.find('input[name="ville"]').val(data.ville);
            $modal.find('input[name="profession"]').val(data.profession);
            $modal.find('select[name="campagne_id"]').val(data.campagne_id);
            $modal.find('select[name="category_id"]').val(data.category_id || "");
            $modal.find('select[name="etape_id"]').val(data.etape_id);


            // 4. Remplissage de la description (textarea)
            $modal.find('textarea[name="description"]').val(data.description);

            // --- GESTION DE LA PHOTO ACTUELLE ---
            const $preview = $modal.find('.preview-target');
            const $placeholder = $modal.find('.placeholder-target');
            const $removeBtn = $modal.find('.remove-btn-target');
            const $fileInput = $modal.find('input[name="photo"]');
            const APP_IMAGES_PATH = "{{ env('IMAGES_PATH') }}/"

            // Reset de l'input file (au cas où)
            $fileInput.val('');

            if (data.photo) {
                // On affiche l'image venant du serveur
                $preview.attr('src', APP_IMAGES_PATH + data.photo).removeClass('d-none');
                $placeholder.addClass('d-none');
                $removeBtn.removeClass('d-none');
            } else {
                // Pas de photo : on affiche le placeholder
                $preview.attr('src', '#').addClass('d-none');
                $placeholder.removeClass('d-none');
                $removeBtn.addClass('d-none');
            }

            $modal.modal('show');
        });

        // OUVERTURE MODAL SUPPRESSION ---
        $(document).on('click', '.js-btn-delete', function() {
            const id = $(this).data('id');
            const $modal = $('#delete_contact');
            $modal.find('.js-confirm-delete').attr('data-id', id);
            $modal.find('input[name="candidat_id"]').val(id);
            $modal.modal('show');
        });

        // Supposons que candidat.date_naissance = "2000-05-15" (format YYYY-MM-DD)
        function calculerAge(dateNaissanceStr) {
            if (!dateNaissanceStr) return ''; // si pas de date

            const today = new Date();
            const naissance = new Date(dateNaissanceStr);

            let age = today.getFullYear() - naissance.getFullYear();
            const moisDiff = today.getMonth() - naissance.getMonth();
            const jourDiff = today.getDate() - naissance.getDate();

            // Si le mois ou le jour n’est pas encore passé cette année, on retire 1
            if (moisDiff < 0 || (moisDiff === 0 && jourDiff < 0)) {
                age--;
            }

            return age;
        }

    });

    $(document).ready(function() {

        // --- MISE À JOUR DU CANDIDAT EN AJAX ---
        $('#form_edit_candidat').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let $submitBtn = $form.find('button[type="submit"]');
            let originalBtnHtml = $submitBtn.html();
            let formData = new FormData(this);

            // 🔄 Nettoyage des anciennes erreurs
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').remove();

            // Désactiver le bouton
            $submitBtn.prop('disabled', true).html('Mise à jour...');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST', // PUT/PATCH via _method si besoin
                data: formData,
                processData: false,
                contentType: false,

                success: function(response) {
                    // 1. Fermer le modal
                    $('#modal_edit_candidat').modal('hide');

                    // 2. Message succès
                    if (response.success && typeof showAjaxAlert === 'function') {
                        showAjaxAlert('success', response.message);
                    }

                    // 3. Rafraîchir le tableau / données
                    $('.js-select-campagne').trigger('change');
                },

                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;

                        if (typeof showAjaxAlert === 'function') {
                            showAjaxAlert('danger', 'Veuillez corriger les champs en erreur.');
                        }

                        // 🔁 Affichage champ par champ
                        $.each(errors, function(fieldName, messages) {

                            // Gestion des champs Laravel complexes (ex: skills.0.name)
                            let fieldSelector = fieldName
                                .replace(/\.(\d+)\./g, '[$1][')
                                .replace(/\./g, ']')
                                .replace(/$/, ']');

                            let $input = $form.find(
                                `[name="${fieldName}"],
                         [name="${fieldName}[]"],
                         [name="${fieldSelector}"]`
                            ).first();

                            if ($input.length) {
                                $input.addClass('is-invalid');

                                let errorHtml = `
                            <div class="invalid-feedback d-block">
                                ${messages[0]}
                            </div>
                        `;

                                // 📍 Placement intelligent
                                if ($input.closest('.input-group').length) {
                                    $input.closest('.input-group').after(errorHtml);
                                } else if ($input.attr('type') === 'file' && $input.closest('.image-upload-group').length) {
                                    $input.closest('.image-upload-group').after(errorHtml);
                                } else {
                                    $input.after(errorHtml);
                                }
                            }
                        });

                        // 🎯 Focus premier champ invalide
                        $form.find('.is-invalid').first().focus();

                    } else {
                        const errorTxt = xhr.responseJSON?.message || 'Erreur lors de la modification.';
                        if (typeof showAjaxAlert === 'function') {
                            showAjaxAlert('danger', errorTxt);
                        }
                    }
                },

                complete: function() {
                    // Réactiver le bouton
                    $submitBtn.prop('disabled', false).html(originalBtnHtml);
                }
            });
        });


        // Delete candidat
        $('#form_delete_candidat').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let $submitBtn = $form.find('button[type="submit"]');
            let formData = new FormData(this);

            // Désactiver le bouton
            $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // 1. Fermer le modal
                    $('#delete_contact').modal('hide');

                    // 2. Afficher le message de succès (utilise la fonction showAjaxAlert définie précédemment)
                    if (response.success) {
                        showAjaxAlert('success', response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Erreur lors de la suppression.";

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).flat().join("<br>");
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    showAjaxAlert('danger', errorMessage);
                },
                complete: function() {
                    // Réactiver le bouton
                    $submitBtn.prop('disabled', false).html("Oui, supprimer");
                }
            });
        });


    });
</script>
@endsection
<!-- section js -->
@section('extra-js')

@endsection