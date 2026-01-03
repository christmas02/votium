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


    <div class="row" x-data="campagneHandler()">
        <!-- Colonne Gauche -->
        <div class="col-xl-3">
            <div class="card border shadow-none">
                <div class="card-body">
                    <label class="form-label">Choisir la campagne</label>
                    <select class="form-select js-select-campagne">
                        <option value="" selected disabled>Sélectionnez</option>
                        @foreach($campagnes as $campagne)
                        <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                        @endforeach
                    </select>

                    <p class="mt-3 mb-0">Campagne sélectionnée :</p>
                    <h4 class="fw-bold js-display-campagne-name" style="color: #f3613c;">Aucune</h4>
                </div>
            </div>
        </div>

        <!-- Colonne Droite : Liste des étapes -->
        <div class="col-xl-9">
            <div class="card border shadow-none">
                <div class="card-header d-flex align-items-center justify-content-between bg-transparent border-0">
                    <div class="search-input">
                        <input type="text" class="form-control" placeholder="Rechercher ...">
                    </div>
                    <button id="btn-creer-etape" class="btn btn-primary d-flex align-items-center d-none" style="background-color: #f3613c; border:none;" data-bs-toggle="modal" data-bs-target="#modal_add_step_">
                        <i class="ti ti-circle-plus me-1"></i> Créer
                    </button>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr class="text-muted fs-11 text-uppercase">
                                    <th>Nom de l'étape</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Prix du vote</th>
                                    <th>Nbre de votes</th>
                                    <th>Etat</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody class="js-etape-table-body">
                                <tr>
                                    <td colspan="7" class="text-center">Sélectionnez une campagne pour voir les étapes.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- End Content -->

<!-- Modal Nouvelle Étape -->
<div class="modal fade" id="modal_add_step_" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h4 class="modal-title fw-bold" style="color: #2d3748;">Nouvelle étape</h4>
                <button type="button" class="btn-close bg-light rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_add_step" action="{{ route('business.save_etape') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="modal_add_campagne_id" name="campagne_id" value="">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom de l'étape</label>
                        <input type="text" class="form-control bg-light border-0" name="name" placeholder="Attribuez un nom à cette étape.">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Date de début</label>
                            <input type="date" class="form-control bg-light border-0" name="date_debut">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Heure de début</label>
                            <input type="time" class="form-control bg-light border-0" name="heure_debut">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Date de fin</label>
                            <input type="date" class="form-control bg-light border-0" name="date_fin">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Heure de fin</label>
                            <input type="time" class="form-control bg-light border-0" name="heure_fin">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Décrivez l'étape</label>
                        <textarea class="form-control bg-light border-0" rows="4" name="description" placeholder="Décrivez l'étape ..."></textarea>
                    </div>

                    <!-- <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Type d'éligibilité</label>
                            <select class="form-select bg-light border-0" name="type_eligibility">
                                <option>Choisir</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Seuil de sélection</label>
                            <input type="number" class="form-control bg-light border-0" name="seuil_selection" placeholder="Ex: 1000">
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="col-md-12 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="reinitialisation" name="reinitialisation" value="1">
                                <label class="form-check-label" for="reinitialisation">Réinitialisation</label>
                            </div>
                        </div>
                    </div> -->

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Prix d'un vote</label>
                        <input type="text" class="form-control bg-light border-0" name="prix_vote" placeholder="Ex: 500">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Packages de vote</label>

                        <div class="packages-wrapper">
                            <div class="packages-container" data-index="1" id="packages_container">

                                <!-- Package par défaut -->
                                <div class="row g-2 align-items-end package-item package-itemadd mb-2">
                                    <div class="col-5">
                                        <input type="number" name="packages[0][votes]" class="form-control bg-light border-0" placeholder="Nombre de votes" required>
                                    </div>

                                    <div class="col-5">
                                        <input type="number" name="packages[0][montant]" class="form-control bg-light border-0" placeholder="Prix (FCFA)" readonly required>
                                    </div>

                                    <div class="col-2 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-package d-none">✕</button>
                                    </div>
                                </div>

                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm mt-2 add-package" id="addPackage">
                                + Ajouter un package
                            </button>
                        </div>
                    </div>


                    <!-- Le bouton de validation n'est pas visible sur votre capture, mais voici le style habituel -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background-color: #f3613c; border:none;">Enregistrer l'étape</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal update étape -->
<div class="modal fade" id="modal_update_step" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h4 class="modal-title fw-bold" style="color: #2d3748;">Modifier l'étape</h4>
                <button type="button" class="btn-close bg-light rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Route de mise à jour -->
                <form id="form_update_step" action="{{ route('business.update_etape') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Champs cachés pour l'ID de l'étape et de la campagne -->
                    <input type="hidden" name="etape_id" id="upd_etape_id">
                    <input type="hidden" name="campagne_id" id="upd_campagne_id">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom de l'étape</label>
                        <input type="text" class="form-control bg-light border-0" name="name" id="upd_name">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Date de début</label>
                            <input type="date" class="form-control bg-light border-0" name="date_debut" id="upd_date_debut">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Heure de début</label>
                            <input type="time" class="form-control bg-light border-0" name="heure_debut" id="upd_heure_debut">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Date de fin</label>
                            <input type="date" class="form-control bg-light border-0" name="date_fin" id="upd_date_fin">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Heure de fin</label>
                            <input type="time" class="form-control bg-light border-0" name="heure_fin" id="upd_heure_fin">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Décrivez l'étape</label>
                        <textarea class="form-control bg-light border-0" rows="3" name="description" id="upd_description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Prix d'un vote (FCFA)</label>
                        <!-- Classe js-prix-unitaire pour le calcul automatique -->
                        <input type="number" class="form-control bg-light border-0 js-prix-unitaire" name="prix_vote" id="upd_prix_vote">
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-semibold mb-0">Packages de vote</label>
                            <!-- <span class="badge bg-soft-primary text-primary border">
                                Total : <span class="js-total-packages-sum">0</span> FCFA
                            </span> -->
                        </div>

                        <div class="packages-wrapper">
                            <!-- Le conteneur qui recevra les packages via jQuery -->
                            <div class="packages-container js-upd-packages-container">
                                <!-- Injecté dynamiquement par JS -->
                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm mt-2 js-add-package-upd">
                                <i class="ti ti-plus me-1"></i> Ajouter un package
                            </button>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background-color: #f3613c; border:none;">
                            Mettre à jour l'étape
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modal_delete_step" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h4>Êtes-vous sûr ?</h4>
                <p>Cette action est irréversible.</p>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button class="btn btn-danger js-confirm-delete">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Fonction pour gérer le package des votes
    document.addEventListener('click', function(e) {

        if (e.target.classList.contains('add-package')) {

            const wrapper = e.target.closest('.packages-wrapper');
            const container = wrapper.querySelector('.packages-container');

            let index = parseInt(container.dataset.index);

            const html = `
        <div class="row g-2 align-items-end package-item package-itemadd mb-2">
            <div class="col-5">
                <input type="number" name="packages[${index}][votes]" class="form-control bg-light border-0" placeholder="Nombre de votes" required>
            </div>
            <div class="col-5">
                <input type="number" name="packages[${index}][montant]" class="form-control bg-light border-0" placeholder="Prix (FCFA)" readonly required>
            </div>
            <div class="col-2 text-end">
                <button type="button" class="btn btn-danger btn-sm remove-package">✕</button>
            </div>
        </div>
        `;

            container.insertAdjacentHTML('beforeend', html);
            container.dataset.index = index + 1;
        }

        // Supprimer un package
        if (e.target.classList.contains('remove-package')) {
            e.target.closest('.package-item').remove();
        }

    });

    // Quand on change le prix du vote
    document.addEventListener('input', function(e) {
        if (e.target.name === 'prix_vote' || e.target.name.includes('[votes]')) {
            calculerMontants();
        }
    });

    // Calculer les montants en fonction du prix par vote
    function calculerMontants() {
        const prixVote = parseFloat(document.querySelector('input[name="prix_vote"]').value) || 0;

        document.querySelectorAll('.package-itemadd').forEach(package => {
            const votesInput = package.querySelector('input[name*="[votes]"]');
            const montantInput = package.querySelector('input[name*="[montant]"]');

            const votes = parseFloat(votesInput.value) || 0;

            const montant = prixVote * votes;

            montantInput.value = montant > 0 ? montant : '';
        });
    }

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
            const name = $(this).find('option:selected').text();

            // 1. INJECTION DE L'ID DANS LE MODAL
            $('#modal_add_campagne_id').val(id);

            // 2. AFFICHAGE DU BOUTON CRÉER
            if (id) {
                $('#btn-creer-etape').removeClass('d-none').addClass('d-flex');
            } else {
                $('#btn-creer-etape').addClass('d-none').removeClass('d-flex');
            }

            // Mise à jour visuelle immédiate
            $('.js-display-campagne-name').text(name);
            $('.js-etape-table-body').html('<tr><td colspan="7" class="text-center">Chargement...</td></tr>');

            // 3. REQUÊTE AJAX POUR RÉCUPÉRER LES ÉTAPES
            $.ajax({
                url: `/business/recherche_etape_campagne/${id}`,
                method: 'GET',
                success: function(etapes) {
                    renderEtapeTable(etapes);
                },
                error: function() {
                    $('.js-etape-table-body').html('<tr><td colspan="7" class="text-danger">Erreur de chargement.</td></tr>');
                }
            });
        });

        // --- 2. FONCTION DE RENDU DU TABLEAU ---
        function renderEtapeTable(etapes) {
            let html = '';
            if (etapes.length === 0) {
                html = '<tr><td colspan="7" class="text-center">Aucune étape trouvée.</td></tr>';
            } else {
                etapes.forEach(etape => {
                    // On stocke l'objet entier en JSON dans un attribut data pour l'édition
                    const etapeData = encodeURIComponent(JSON.stringify(etape));

                    html += `
                <tr>
                    <td class="fw-bold">${etape.name}</td>
                    <td>${etape.date_debut}</td>
                    <td>${etape.date_fin}</td>
                    <td>${etape.prix_vote} FCFA</td>
                    <td>NAN</td>
                    <td>${etape.is_active == 0 ? 'Actif' : 'Inactif'}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-info js-btn-edit" data-etape="${etapeData}">
                            <i class="ti ti-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger js-btn-delete" data-id="${etape.etape_id}">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>
                </tr>`;
                });
            }
            $('.js-etape-table-body').html(html);
        }

        // --- 3. OUVERTURE MODAL ÉDITION ---
        $(document).on('click', '.js-btn-edit', function() {
            const data = JSON.parse(decodeURIComponent($(this).data('etape')));
            const $modal = $('#modal_update_step');

            // Remplissage des champs du modal par leurs noms
            $modal.find('input[name="etape_id"]').val(data.etape_id);
            $modal.find('input[name="campagne_id"]').val(data.campagne_id);
            $modal.find('input[name="name"]').val(data.name);
            $modal.find('input[name="date_debut"]').val(data.date_debut);
            $modal.find('input[name="date_fin"]').val(data.date_fin);
            $modal.find('input[name="heure_debut"]').val(data.heure_debut);
            $modal.find('input[name="heure_fin"]').val(data.heure_fin);
            $modal.find('textarea[name="description"]').val(data.description);
            $modal.find('textarea[name="type_eligibility"]').val(data.type_eligibility);
            $modal.find('textarea[name="seuil_selection"]').val(data.seuil_selection);
            $modal.find('input[name="prix_vote"]').val(data.prix_vote);
            $modal.find('input[name="renitialisation"]').val(data.renitialisation);

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

        function renderUpdatePackages(packagesData, $modal) {
            const $container = $modal.find('.js-upd-packages-container');
            $container.empty();

            let packages = [];
            try {
                packages = typeof packagesData === 'string' ? JSON.parse(packagesData) : packagesData;
            } catch (e) {
                packages = [];
            }

            if (packages && packages.length > 0) {
                packages.forEach((pkg, i) => {
                    const html = `
                <div class="row g-2 mb-2 package-item">
                    <div class="col-5">
                        <input type="number" name="packages[${i}][votes]" value="${pkg.vote}" 
                               class="form-control bg-light border-0 js-package-votes" placeholder="Votes">
                    </div>
                    <div class="col-5">
                        <input type="number" name="packages[${i}][montant]" value="${pkg.montant}" 
                               class="form-control bg-light border-0 js-package-amount" readonly>
                    </div>
                    <div class="col-2 text-end">
                        <button type="button" class="btn btn-danger btn-sm js-remove-package">✕</button>
                    </div>
                </div>`;
                    $container.append(html);
                });
            }
            calculateGlobalTotal();
        }

        // --- 3. CALCULS AUTOMATIQUES ---

        // A. Calcul lorsqu'on modifie le nombre de votes d'un package
        $(document).on('input', '.js-package-votes', function() {
            // 1. On identifie le modal dans lequel on se trouve (Ajout ou Update)
            const $modal = $(this).closest('.modal');

            // 2. On récupère le prix unitaire spécifique à CE modal
            const prixUnitaire = parseFloat($modal.find('.js-prix-unitaire').val()) || 0;

            // 3. On calcule le montant de la ligne actuelle
            const nbVotes = parseFloat($(this).val()) || 0;
            const montantLigne = nbVotes * prixUnitaire;

            // 4. On met à jour l'input montant de cette ligne uniquement
            $(this).closest('.package-item').find('.js-package-amount').val(montantLigne > 0 ? montantLigne : '');

            // 5. On met à jour le total global de CE modal
            calculateGlobalTotal($modal);
        });

        // B. Calcul lorsqu'on modifie le prix unitaire principal
        $(document).on('input', '.js-prix-unitaire', function() {
            const $modal = $(this).closest('.modal');

            // On demande à chaque champ de vote de CE modal de se recalculer
            $modal.find('.js-package-votes').each(function() {
                // On déclenche l'événement input manuellement sur chaque ligne
                $(this).trigger('input');
            });
        });

        // C. Fonction de somme globale (Indépendante par modal)
        function calculateGlobalTotal($modal) {
            // Si $modal n'est pas défini, on cherche le modal ouvert
            const $currentModal = $modal || $('.modal.show');
            let total = 0;

            // On additionne uniquement les montants du modal en question
            $currentModal.find('.js-package-amount').each(function() {
                total += parseFloat($(this).val()) || 0;
            });

            // On affiche le total dans le badge du modal correspondant
            $currentModal.find('.js-total-packages-sum').text(total.toLocaleString('fr-FR'));
        }

        // D. Mise à jour de la fonction "Ajouter un package" pour ne pas casser les calculs
        $(document).on('click', '.js-add-package-upd', function() {
            const $modal = $(this).closest('.modal');
            const $container = $modal.find('.js-upd-packages-container');
            const index = $container.find('.package-item').length;

            const html = `
                <div class="row g-2 mb-2 package-item">
                    <div class="col-5">
                        <input type="number" name="packages[${index}][votes]" class="form-control bg-light border-0 js-package-votes">
                    </div>
                    <div class="col-5">
                        <input type="number" name="packages[${index}][montant]" class="form-control bg-light border-0 js-package-amount" readonly>
                    </div>
                    <div class="col-2 text-end">
                        <button type="button" class="btn btn-danger btn-sm js-remove-package">✕</button>
                    </div>
                </div>`;

            $container.append(html);
        });

        // E. Suppression d'un package
        $(document).on('click', '.js-remove-package', function() {
            const $modal = $(this).closest('.modal');
            $(this).closest('.package-item').remove();
            calculateGlobalTotal($modal);
        });

    });

    $(document).ready(function() {

        // --- ENREGISTREMENT DE L'ÉTAPE EN AJAX ---
        $('#form_add_step').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let $submitBtn = $form.find('button[type="submit"]');
            let formData = new FormData(this);

            $submitBtn.prop('disabled', true).html('Enregistrement...');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // 1. Fermer le modal
                    $('#modal_add_step_').modal('hide');

                    // 2. Réinitialiser le formulaire
                    $form[0].reset();
                   
                    // On garde la première ligne (:first) et on supprime les autres
                    $form.find('.package-itemadd').not(':first').remove();

                    // 3. Afficher le message de succès (Dynamique)
                    if (response.success) {
                        showAjaxAlert('success', response.message);
                    }

                    // 4. RAFRAÎCHIR LE TABLEAU
                    $('.js-select-campagne').trigger('change');
                },
                error: function(xhr) {
                    let errorMessage = "Une erreur est survenue.";

                    // Si c'est une erreur de validation Laravel (422)
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).flat().join("<br>");
                    }
                    // Si le contrôleur a envoyé un message d'erreur spécifique
                    else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    // Afficher l'alerte d'erreur (danger)
                    showAjaxAlert('danger', errorMessage);
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).html("Enregistrer l'étape");
                }
            });
        });

        // --- MISE À JOUR DE L'ÉTAPE EN AJAX ---
        $('#form_update_step').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let $submitBtn = $form.find('button[type="submit"]');
            let formData = new FormData(this);

            // Désactiver le bouton
            $submitBtn.prop('disabled', true).html('Mise à jour...');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // 1. Fermer le modal
                    $('#modal_update_step').modal('hide');

                    // 2. Afficher le message de succès (utilise la fonction showAjaxAlert définie précédemment)
                    if (response.success) {
                        showAjaxAlert('success', response.message);
                    }

                    // 3. RAFRAÎCHIR LE TABLEAU
                    $('.js-select-campagne').trigger('change');
                },
                error: function(xhr) {
                    let errorMessage = "Erreur lors de la modification.";

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
                    $submitBtn.prop('disabled', false).html("Mettre à jour l'étape");
                }
            });
        });
    });

    function showAjaxAlert(type, message) {
        const title = type === 'success' ? 'Succès' : (type === 'danger' ? 'Erreur' : 'Attention');
        const alertClass = 'alert-' + type;

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                <strong>${title} — </strong> ${message}
            </div>
        `;

        // Injecter l'alerte en haut du conteneur et scroller vers le haut
        $('#ajax-alert-container').html(alertHtml);

        // Optionnel : Scroller automatiquement vers le message pour être sûr que l'utilisateur le voit
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');

        // Optionnel : Faire disparaître l'alerte après 5 secondes
        // setTimeout(function() {
        //     $('.alert').alert('close');
        // }, 5000);
    }
</script>
@endsection
<!-- section js -->
@section('extra-js')

@endsection