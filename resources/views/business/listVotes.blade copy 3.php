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

                <a href="javascript:void(0);" class="btn btn-primary">Nbre votes: 1200000</a>

                <a href="javascript:void(0);" class="btn btn-outline-light px-2 shadow">Total: 1200000 cfa</a>

            </div>
        </div>
        <!-- table header -->

        <!-- Contact Grid -->
        <div class="row">
            <div class="col-xl-3 ">

                <div class="row mb-4 card card-body">
                    <h6>Filtre</h6>
                    <hr>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Choisir la campagne</label>
                        <select class="select form-control form-select js-select-campagne">
                            <option value="" selected disabled>Sélectionner</option>
                            @foreach ($campagnes as $item)
                                @php($campagne = $item['campagne'] ?? null)
                                @if ($campagne)
                                    <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Choisir l'étape</label>
                        <select class="select form-control form-select js-select-etape" disabled>
                            <option value="" selected disabled>Sélectionner</option>
                            @foreach ($etapes as $etape)
                                <option value="{{ $etape->etape_id }}" data-campagne-id="{{ $etape->campagne_id }}">
                                    {{ $etape->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="col-md-12 mb-3">
                            <label class="form-label">Choisir la catégorie</label>
                            <select class="select form-control form-select js-select-categorie" disabled>
                                <option value="" selected disabled>Sélectionner</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}"
                                        data-campagne-id="{{ $category->campagne_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                    <div class="col-md-12 mb-3">
                        <label class="form-label">A partir du</label>
                        <input type="date" class="form-control" name="inscription_date_debut">
                    </div>
                    <div class="col-md-12 mb-3">Jusqu'au</label>
                        <input type="date" class="form-control" name="inscription_date_fin">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Jusqu'au <span class="text-danger">*</span></label>
                        <select class="select form-control form-select" name="customer_id" required>
                            <option value="">Confirmé</option>
                            <option value="1">Catégorie A</option>
                            <option value="2">Catégorie B</option>
                        </select>
                    </div>
                </div>


            </div>
            <div class="col-xl-9">

                <!-- end card header -->
                <div class="col-xl-9">
                    <div class="row bg-light js-candidat-table-body">
                        <!-- Les cartes des candidats seront chargées ici via AJAX -->

                    </div>
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

    <script>
        // Ce script centralise toute la logique jQuery pour la gestion des étapes de campagne
        $(document).ready(function() {
            let currentPage = 1;
            let searchTimeout = null;
            const APP_IMAGES_PATH = "{{ env('IMAGES_PATH') }}/";

            // --- ÉVÉNEMENTS ---

            // --- STOCKAGE DES OPTIONS (CLONE) ---
            // On sauvegarde toutes les options disponibles au chargement de la page
            // pour pouvoir les filtrer plus tard sans les perdre.
            const $allEtapesOptions = $('.js-select-etape option').clone();
            const $allCategoriesOptions = $('.js-select-categorie option').clone();

            // --- GESTION DU FILTRE EN CASCADE ---
            $('.js-select-campagne').on('change', function() {
                const campagneId = $(this).val();
                const $selectEtape = $('.js-select-etape');
                const $selectCategorie = $('.js-select-categorie');

                // 1. Réinitialiser les selects (vider et désactiver temporairement)
                $selectEtape.empty().prop('disabled', true);
                // $selectCategorie.empty().prop('disabled', true);

                // Ajouter l'option par défaut
                $selectEtape.append('<option value="" selected disabled>Sélectionner</option>');
                $selectCategorie.append('<option value="" selected disabled>Sélectionner</option>');

                if (campagneId) {
                    // 2. Filtrer et réinjecter les Etapes correspondantes
                    $allEtapesOptions.each(function() {
                        // On vérifie le data-campagne-id (on ignore l'option vide qui n'a pas de data)
                        if ($(this).data('campagne-id') == campagneId) {
                            $selectEtape.append($(this).clone());
                        }
                    });

                    // 3. Filtrer et réinjecter les Catégories correspondantes
                    $allCategoriesOptions.each(function() {
                        if ($(this).data('campagne-id') == campagneId) {
                            $selectCategorie.append($(this).clone());
                        }
                    });

                    // 4. Activer les champs s'il y a des options (ou juste activer)
                    $selectEtape.prop('disabled', false);
                    $selectCategorie.prop('disabled', false);
                }

                // 5. Lancer le rechargement des votes (Reset page 1)
                currentPage = 1;
                chargerCandidats(false);
            });

            // --- LOGIQUE POUR LE FORMULAIRE D'AJOUT (Candidature) ---

            // 1. On clone les options pour le formulaire d'ajout spécifiquement
            // Attention aux sélecteurs : on cible les classes .js-add-...
            const $formEtapesOptions = $('.js-add-etape option').clone();
            const $formCategoriesOptions = $('.js-add-categorie option').clone();
            $(document).on('change', '.js-add-campagne', function() {
                const campagneId = $(this).val();

                // Sélecteurs
                const $selectEtape = $('.js-add-etape');
                const $selectCategorie = $('.js-add-categorie');
                const $msgNoEtape = $('.js-msg-no-etape'); // Le message
                const $submitBtn = $('.js-btn-save-candidat'); // Le bouton

                // 1. RESET TOTAL (Visuel + Logique)
                // On vide les selects
                $selectEtape.empty().prop('disabled', true);
                $selectCategorie.empty().prop('disabled', true);
                $selectEtape.append('<option value="">Sélectionner</option>');
                $selectCategorie.append('<option value="">Sélectionner</option>');

                // On cache le message et on RÉACTIVE le bouton par défaut
                // (pour qu'il redevienne cliquable si on change pour une bonne campagne)
                $msgNoEtape.addClass('d-none');
                $submitBtn.prop('disabled', false);

                if (campagneId) {
                    let etapeCount = 0;

                    // 2. Filtrer les Etapes
                    $formEtapesOptions.each(function() {
                        if ($(this).data('campagne-id') == campagneId) {
                            $selectEtape.append($(this).clone());
                            etapeCount++;
                        }
                    });

                    // 3. Filtrer les Catégories
                    $formCategoriesOptions.each(function() {
                        if ($(this).data('campagne-id') == campagneId) {
                            $selectCategorie.append($(this).clone());
                        }
                    });

                    // 4. LOGIQUE DE BLOCAGE
                    if (etapeCount === 0) {
                        // CAS 1 : Aucune étape trouvée
                        $msgNoEtape.removeClass('d-none'); // Afficher message
                        $submitBtn.prop('disabled', true); // DÉSACTIVER BOUTON
                    } else {
                        // CAS 2 : Des étapes existent
                        $selectEtape.prop('disabled', false); // Activer le champ
                        // Le bouton est déjà activé par le reset du début
                    }

                    // On active toujours les catégories s'il y en a
                    $selectCategorie.prop('disabled', false);
                }
            });

            // 1. Recherche : On reset la page à 1 et on vide la liste
            $(document).on('keyup', '.js-search-candidat', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    currentPage = 1;
                    chargerCandidats(false);
                }, 500); // Délai de 500ms pour ne pas harceler le serveur
            });

            // 2. Filtres Select : On reset la page à 1
            $(document).on('change', '.js-select-etape, .js-select-categorie', function() {
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
                    $('.js-candidat-table-body').html(
                        '<div class="col-12 text-center p-5"><div class="spinner-border text-primary"></div></div>'
                    );
                }

                $.ajax({
                    url: `/business/recherche_votes`, // Assurez-vous que cette route existe et retourne les données au format attendu
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
                    html =
                        '<div class="col-12"><p class="text-center bg-white p-4 shadow-sm">Aucun candidat trouvé.</p></div>';
                    $('.js-candidat-table-body').html(html);
                    return;
                }

                candidats.forEach((candidat, index) => {
                    const data = encodeURIComponent(JSON.stringify(candidat));
                    const photoUrl = candidat.photo ? APP_IMAGES_PATH + candidat.photo :
                        'assets/img/profiles/avatar-01.jpg';
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
                                                <p class="text-muted mb-0 small">Profession: ${candidat.profession || ''}</p>
                                                <p class="text-muted mb-0 small">Vote: ${candidat.votes_count || 0}</p>
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
    </script>
@endsection
<!-- section js -->
