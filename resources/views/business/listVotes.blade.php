@extends('refont.layout.app')

@section('title', 'Votes')

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li><a href="{{ route('business.espace') }}"><i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil</a></li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li><a href="{{ route('business.list_campagne') }}">Sessions</a></li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li><a href="{{ route('business.list_candidat') }}">Candidats</a></li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li class="active">Votes</li>
@endsection

{{-- ===== CSS SPÉCIFIQUE ===== --}}
@section('extra-css')
<style>
    /* ---- En-tête page votes ---- */
    .vt-votes-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 20px;
    }
    .vt-votes-title {
        font-size: 34px; font-weight: 800;
        color: var(--vt-text-main); margin: 0;
        letter-spacing: -.5px;
    }

    /* ---- Stat pills ---- */
    .vt-stat-pills {
        display: flex; gap: 12px; flex-wrap: wrap;
    }
    .vt-stat-pill {
        background: #fff;
        border: 1px solid var(--vt-border);
        border-radius: var(--vt-radius);
        padding: 12px 18px;
        box-shadow: var(--vt-shadow);
        display: flex; align-items: center;
        gap: 16px; min-width: 160px;
    }
    .vt-stat-pill-content { flex: 1; }
    .vt-stat-pill-label {
        font-size: 11px; font-weight: 500;
        color: var(--vt-text-muted); margin: 0 0 2px;
    }
    .vt-stat-pill-value {
        font-size: 22px; font-weight: 800;
        color: var(--vt-text-main); line-height: 1;
    }
    .vt-stat-pill-badge {
        background: #fde8cc; color: var(--vt-orange);
        font-size: 10.5px; font-weight: 700;
        padding: 3px 9px; border-radius: 50px;
        flex-shrink: 0;
    }

    /* ---- Layout deux colonnes ---- */
    .vt-votes-layout {
        display: flex; align-items: flex-start; gap: 16px;
    }

    /* ---- Colonne filtre gauche ---- */
    .vt-votes-filter {
        width: 264px; flex-shrink: 0;
        background: var(--vt-card-bg);
        border-radius: var(--vt-radius);
        box-shadow: var(--vt-shadow);
        padding: 20px 18px;
    }
    .vt-votes-filter-title {
        font-size: 18px; font-weight: 700;
        color: var(--vt-text-main); margin: 0 0 18px;
    }
    .vt-filter-field-label {
        font-size: 12px; font-weight: 600;
        color: var(--vt-orange); margin-bottom: 6px;
    }
    .vt-filter-input-wrap {
        position: relative; margin-bottom: 14px;
    }
    .vt-filter-input-wrap .vt-fi-icon {
        position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 14px; pointer-events: none;
    }
    .vt-filter-select-icon,
    .vt-filter-date-icon {
        width: 100%;
        padding: 9px 30px 9px 34px;
        border: 1px solid var(--vt-border);
        border-radius: var(--vt-radius-sm);
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center / 15px;
        appearance: none;
        font-size: 13px; color: var(--vt-text-main);
        cursor: pointer; transition: border-color .15s;
    }
    .vt-filter-date-icon {
        background-image: none;
        cursor: text;
    }
    .vt-filter-select-icon:focus,
    .vt-filter-date-icon:focus {
        outline: none; border-color: var(--vt-orange);
    }
    .vt-filter-select-icon:disabled { opacity: .5; cursor: not-allowed; }

    /* Boutons filtre */
    .vt-btn-apply {
        width: 100%; padding: 11px;
        background: var(--vt-orange); color: #fff;
        border: none; border-radius: var(--vt-radius-sm);
        font-size: 14px; font-weight: 700;
        cursor: pointer; transition: background .15s;
        margin-bottom: 8px;
    }
    .vt-btn-apply:hover { background: var(--vt-orange-hover); }

    .vt-btn-reset {
        width: 100%; padding: 10px;
        background: #fff; color: var(--vt-text-main);
        border: 1.5px solid var(--vt-border);
        border-radius: var(--vt-radius-sm);
        font-size: 13.5px; font-weight: 600;
        cursor: pointer; transition: all .15s;
    }
    .vt-btn-reset:hover { border-color: #94a3b8; background: #f8fafc; }

    /* ---- Colonne tableau droite ---- */
    .vt-votes-main { flex: 1; min-width: 0; }

    .vt-votes-table-card {
        background: var(--vt-card-bg);
        border-radius: var(--vt-radius);
        box-shadow: var(--vt-shadow);
        overflow: hidden;
    }
    .vt-votes-table-header {
        display: flex; align-items: center;
        justify-content: space-between;
        padding: 18px 20px 14px;
        border-bottom: 1px solid var(--vt-border);
    }
    .vt-votes-table-title {
        font-size: 16px; font-weight: 700;
        color: var(--vt-text-main); margin: 0;
    }
    .vt-results-label {
        font-size: 12px; color: var(--vt-text-muted); font-weight: 500;
    }

    /* Table */
    .vt-votes-table {
        width: 100%; border-collapse: collapse; font-size: 12.5px;
    }
    .vt-votes-table thead th {
        padding: 10px 16px;
        font-size: 11px; font-weight: 700;
        letter-spacing: .6px; text-transform: uppercase;
        color: var(--vt-text-muted);
        border-bottom: 1px solid var(--vt-border);
        white-space: nowrap;
    }
    .vt-votes-table tbody td {
        padding: 13px 16px;
        border-bottom: 1px solid var(--vt-border);
        color: var(--vt-text-main);
        vertical-align: middle;
    }
    .vt-votes-table tbody tr:last-child td { border-bottom: none; }
    .vt-votes-table tbody tr:hover td { background: #fafbfc; }

    /* Cellule session en orange */
    .vt-votes-table .cell-session {
        color: var(--vt-orange);
        font-weight: 600;
        font-size: 12px;
    }

    /* Badge status */
    .vt-status-confirmed {
        background: var(--vt-green-light); color: var(--vt-green);
        font-size: 10.5px; font-weight: 600;
        padding: 3px 9px; border-radius: 50px;
        display: inline-flex; align-items: center; gap: 4px;
    }
    .vt-status-pending {
        background: #fef9c3; color: #a16207;
        font-size: 10.5px; font-weight: 600;
        padding: 3px 9px; border-radius: 50px;
    }
    .vt-status-rejected {
        background: #fee2e2; color: #dc2626;
        font-size: 10.5px; font-weight: 600;
        padding: 3px 9px; border-radius: 50px;
    }

    /* Empty / loading state */
    .vt-votes-empty {
        padding: 32px 16px;
        text-align: center;
        color: var(--vt-text-muted);
        font-size: 13px;
    }

    @media (max-width: 860px) {
        .vt-votes-layout { flex-direction: column; }
        .vt-votes-filter { width: 100%; }
        .vt-stat-pill { min-width: auto; flex: 1; }
    }
</style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    {{-- En-tête : titre + stat pills --}}
    <div class="vt-votes-header">
        <h1 class="vt-votes-title">Votes</h1>

        <div class="vt-stat-pills">
            <div class="vt-stat-pill">
                <div class="vt-stat-pill-content">
                    <p class="vt-stat-pill-label">Nbre votes</p>
                    <div class="vt-stat-pill-value" id="btn-total-votes">0</div>
                </div>
                <span class="vt-stat-pill-badge">LIVE</span>
            </div>
            <div class="vt-stat-pill">
                <div class="vt-stat-pill-content">
                    <p class="vt-stat-pill-label">Total</p>
                    <div class="vt-stat-pill-value" id="btn-total-montant">0</div>
                </div>
                <span class="vt-stat-pill-badge">FCFA</span>
            </div>
        </div>
    </div>

    {{-- Layout deux colonnes --}}
    <div class="vt-votes-layout">

        {{-- =====================================================
             COLONNE GAUCHE — FILTRES
             ===================================================== --}}
        <div class="vt-votes-filter">
            <h2 class="vt-votes-filter-title">Filtrer</h2>

            {{-- Session --}}
            <p class="vt-filter-field-label">Choisir la session</p>
            <div class="vt-filter-input-wrap">
                <i class="ti ti-layout-list vt-fi-icon"></i>
                <select id="filter-campagne" class="vt-filter-select-icon js-select-campagne">
                    <option value="">Toutes les sessions</option>
                    @foreach ($campagnes as $item)
                        @php($campagne = $item['campagne'] ?? null)
                        @if ($campagne)
                            <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- Étape --}}
            <p class="vt-filter-field-label">Choisir l'étape</p>
            <div class="vt-filter-input-wrap">
                <i class="ti ti-file-description vt-fi-icon"></i>
                <select id="filter-etape" class="vt-filter-select-icon js-select-etape" disabled>
                    <option value="">Toutes les étapes</option>
                    @foreach ($etapes as $etape)
                        <option value="{{ $etape->etape_id }}" data-campagne-id="{{ $etape->campagne_id }}">
                            {{ $etape->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Date début --}}
            <p class="vt-filter-field-label">À partir du</p>
            <div class="vt-filter-input-wrap">
                <i class="ti ti-calendar vt-fi-icon"></i>
                <input type="date" id="filter-date-debut" class="vt-filter-date-icon filter-input">
            </div>

            {{-- Date fin --}}
            <p class="vt-filter-field-label">Jusqu'au</p>
            <div class="vt-filter-input-wrap">
                <i class="ti ti-calendar vt-fi-icon"></i>
                <input type="date" id="filter-date-fin" class="vt-filter-date-icon filter-input">
            </div>

            {{-- Statut --}}
            <p class="vt-filter-field-label">Statut</p>
            <div class="vt-filter-input-wrap">
                <i class="ti ti-shield-check vt-fi-icon"></i>
                <select id="filter-status" class="vt-filter-select-icon filter-input">
                    <option value="">Tous les statuts</option>
                    <option value="confirmed">Confirmé</option>
                    <option value="created">En attente (Créé)</option>
                    <option value="rejected">Rejeté</option>
                </select>
            </div>

            {{-- Actions --}}
            <button type="button" id="btn-apply-filters" class="vt-btn-apply">
                Appliquer
            </button>
            <button type="button" id="btn-reset-filters" class="vt-btn-reset">
                Réinitialiser
            </button>
        </div>

        {{-- =====================================================
             COLONNE DROITE — TABLEAU DES VOTES
             ===================================================== --}}
        <div class="vt-votes-main">
            <div class="vt-votes-table-card">

                <div class="vt-votes-table-header">
                    <h3 class="vt-votes-table-title">Historique des votes</h3>
                    <span class="vt-results-label" id="results-label">Résultats filtrés</span>
                </div>

                <div style="overflow-x: auto;">
                    <table class="vt-votes-table" id="table-votes">
                        <thead>
                            <tr>
                                <th>Session</th>
                                <th>Étape</th>
                                <th>Qte</th>
                                <th>Montant</th>
                                <th>Candidat</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="votes-table-body">
                            <tr>
                                <td colspan="7" class="vt-votes-empty">
                                    Sélectionnez une session pour afficher les votes.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
    {{-- fin layout --}}

@endsection

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
<script>
$(document).ready(function () {

    /* -------------------------------------------------------
       Charger les votes via AJAX
       ------------------------------------------------------- */
    function loadVotes() {
        const campagneId = $('#filter-campagne').val();
        const etapeId    = $('#filter-etape').val();
        const dateDebut  = $('#filter-date-debut').val();
        const dateFin    = $('#filter-date-fin').val();
        const status     = $('#filter-status').val();

        $('#votes-table-body').html(
            '<tr><td colspan="7" class="vt-votes-empty"><div class="spinner-border spinner-border-sm text-primary me-2"></div> Chargement...</td></tr>'
        );

        $.ajax({
            url: "{{ route('business.recherche_vote') }}",
            type: 'GET',
            data: {
                campagne_id: campagneId,
                etape_id:    etapeId,
                date_debut:  dateDebut,
                date_fin:    dateFin,
                status:      status
            },
            success: function (response) {
                /* Injecter le HTML des lignes (rendu côté serveur) */
                if (response.html && response.html.trim() !== '') {
                    $('#votes-table-body').html(response.html);
                } else {
                    $('#votes-table-body').html(
                        '<tr><td colspan="7" class="vt-votes-empty">Aucun vote pour cette sélection.</td></tr>'
                    );
                }

                /* Mettre à jour les stats */
                const total = response.total_votes || 0;
                const montant = (response.total_montant || 0).toLocaleString('fr-FR');
                $('#btn-total-votes').text(total.toLocaleString('fr-FR'));
                $('#btn-total-montant').text(montant + ' FCFA');
                $('#results-label').text(total + ' résultat(s)');
            },
            error: function () {
                $('#votes-table-body').html(
                    '<tr><td colspan="7" class="vt-votes-empty" style="color:#dc2626;">Une erreur est survenue lors du chargement.</td></tr>'
                );
            }
        });
    }

    /* -------------------------------------------------------
       Filtre session → cascade étapes
       ------------------------------------------------------- */
    $('#filter-campagne').on('change', function () {
        const campagneId = $(this).val();
        const $etape     = $('#filter-etape');

        $etape.val('');

        if (campagneId) {
            $etape.prop('disabled', false);
            $etape.find('option').not(':first').hide();
            $etape.find('option[data-campagne-id="' + campagneId + '"]').show();
        } else {
            $etape.prop('disabled', true);
            $etape.find('option').show();
        }

        /* Lancer automatiquement quand on change de session */
        loadVotes();
    });

    /* -------------------------------------------------------
       Bouton Appliquer
       ------------------------------------------------------- */
    $('#btn-apply-filters').on('click', function () {
        loadVotes();
    });

    /* -------------------------------------------------------
       Bouton Réinitialiser
       ------------------------------------------------------- */
    $('#btn-reset-filters').on('click', function () {
        $('#filter-campagne').val('').trigger('change');
        $('#filter-date-debut').val('');
        $('#filter-date-fin').val('');
        $('#filter-status').val('');
        $('#btn-total-votes').text('0');
        $('#btn-total-montant').text('0');
        $('#results-label').text('Résultats filtrés');
        $('#votes-table-body').html(
            '<tr><td colspan="7" class="vt-votes-empty">Sélectionnez une session pour afficher les votes.</td></tr>'
        );
    });

});
</script>
@endsection
