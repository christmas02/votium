@extends('layout.header.business')

@section('content')
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

        <!-- Stats Header (Ajout d'IDs pour mise à jour dynamique) -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                {{-- Recherche textuelle si besoin --}}
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="javascript:void(0);" class="btn btn-primary" id="btn-total-votes">Nbre votes: 0</a>
                <a href="javascript:void(0);" class="btn btn-outline-light px-2 shadow" id="btn-total-montant">Total: 0
                    cfa</a>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar Filtres -->
            <div class="col-xl-3">
                <div class="row mb-4 card card-body">
                    <h6>Filtre</h6>
                    <hr>

                    <!-- CAMPAGNE -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Choisir la campagne</label>
                        <select id="filter-campagne" class="select form-control form-select js-select-campagne">
                            <option value="" selected>Toutes les campagnes</option>
                            @foreach ($campagnes as $item)
                                @php($campagne = $item['campagne'] ?? null)
                                @if ($campagne)
                                    <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- ETAPE -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Choisir l'étape</label>
                        <!-- Ajout de l'ID filter-etape -->
                        <select id="filter-etape" class="select form-control form-select js-select-etape" disabled>
                            <option value="" selected>Toutes les étapes</option>
                            @foreach ($etapes as $etape)
                                <option value="{{ $etape->etape_id }}" data-campagne-id="{{ $etape->campagne_id }}">
                                    {{ $etape->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- DATES -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">A partir du</label>
                        <input type="date" id="filter-date-debut" class="form-control filter-input">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Jusqu'au</label>
                        <input type="date" id="filter-date-fin" class="form-control filter-input">
                    </div>

                    <!-- STATUS -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Statut</label>
                        <select id="filter-status" class="select form-control form-select filter-input">
                            <option value="">Tous les statuts</option>
                            <option value="confirmed">Confirmé</option>
                            <option value="created">En attente (Créé)</option>
                            <option value="rejected">Rejeté</option>
                        </select>
                    </div>

                    <!-- Bouton Reset optionnel -->
                    <div class="col-md-12">
                        <button type="button" id="btn-reset-filters"
                            class="btn btn-sm btn-light w-100">Réinitialiser</button>
                    </div>
                </div>
            </div>

            <!-- Tableau -->
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0" id="table-votes">
                                <thead class="table-light">
                                    <tr>
                                        <th>CAMPAGNE</th>
                                        <th>ETAPES</th>
                                        <th>QTE</th>
                                        <th>MONTANT</th>
                                        <th>CANDIDAT</th>
                                        <th>DATE</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody id="votes-table-body">
                                    <!-- Le contenu sera chargé ici par AJAX -->
                                    <tr>
                                        <td colspan="7" class="text-center">Veuillez sélectionner une campagne pour
                                            afficher les données.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // 1. Fonction principale pour charger les données
            function loadVotes() {
                // Récupération des valeurs
                let campagneId = $('#filter-campagne').val();
                let etapeId = $('#filter-etape').val();
                let dateDebut = $('#filter-date-debut').val();
                let dateFin = $('#filter-date-fin').val();
                let status = $('#filter-status').val();

                // Afficher un indicateur de chargement
                $('#votes-table-body').html(
                    '<tr><td colspan="7" class="text-center"><div class="spinner-border text-primary" role="status"></div> Chargement...</td></tr>'
                    );

                $.ajax({
                    url: "{{ route('business.recherche_vote') }}",
                    type: "GET",
                    data: {
                        campagne_id: campagneId,
                        etape_id: etapeId,
                        date_debut: dateDebut,
                        date_fin: dateFin,
                        status: status
                    },
                    success: function(response) {
                        // Remplacer le contenu du tableau
                        $('#votes-table-body').html(response.html);

                        // Mettre à jour les compteurs en haut
                        $('#btn-total-votes').text('Nbre votes: ' + response.total_votes);
                        $('#btn-total-montant').text('Total: ' + response.total_montant + ' cfa');
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        $('#votes-table-body').html(
                            '<tr><td colspan="7" class="text-center text-danger">Une erreur est survenue lors du chargement.</td></tr>'
                            );
                    }
                });
            }

            // 2. Gestionnaire d'événement : Changement de Campagne
            $('#filter-campagne').on('change', function() {
                let selectedCampagne = $(this).val();
                let $etapeSelect = $('#filter-etape');

                // Réinitialiser la sélection de l'étape
                $etapeSelect.val('');

                if (selectedCampagne) {
                    $etapeSelect.prop('disabled', false);

                    // Logique pour filtrer les options du select Étape
                    // On cache tout d'abord
                    $etapeSelect.find('option').not(':first').hide();

                    // On affiche seulement celles qui correspondent à la campagne
                    $etapeSelect.find('option[data-campagne-id="' + selectedCampagne + '"]').show();
                } else {
                    // Si aucune campagne sélectionnée, on désactive les étapes
                    $etapeSelect.prop('disabled', true);
                    $etapeSelect.find('option').show();
                }

                // Lancer le chargement AJAX
                loadVotes();
            });

            // 3. Gestionnaire d'événement : Changement sur les autres filtres
            $('#filter-etape, #filter-date-debut, #filter-date-fin, #filter-status').on('change', function() {
                loadVotes();
            });

            // 4. Bouton Reset
            $('#btn-reset-filters').on('click', function() {
                $('#filter-campagne').val('').trigger('change');
                $('#filter-date-debut').val('');
                $('#filter-date-fin').val('');
                $('#filter-status').val('');
                // Le trigger('change') sur campagne va s'occuper de recharger le tableau
            });

            // Optionnel : Charger les données au chargement de la page si voulu
            // loadVotes(); 
        });
    </script>
@endsection
