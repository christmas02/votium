@extends('refont.layout.app')

@section('title', 'Étapes de sessions')

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li><a href="{{ route('business.espace') }}"><i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil</a></li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li><a href="{{ route('business.list_campagne') }}">Sessions</a></li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li class="active">Étapes</li>
@endsection

{{-- ===== CSS SPÉCIFIQUE ===== --}}
@section('extra-css')
<style>
    /* ---- En-tête page ---- */
    .vt-etapes-header {
        display: flex; align-items: center;
        justify-content: space-between;
        gap: 16px; margin-bottom: 22px; flex-wrap: wrap;
    }
    .vt-etapes-title {
        font-size: 34px; font-weight: 800;
        color: var(--vt-text-main); margin: 0;
        letter-spacing: -.5px;
    }

    /* ---- Stat pills ---- */
    .vt-stat-pills { display: flex; gap: 12px; flex-wrap: wrap; }
    .vt-stat-pill {
        background: #fff; border: 1px solid var(--vt-border);
        border-radius: var(--vt-radius); padding: 12px 18px;
        box-shadow: var(--vt-shadow);
        display: flex; align-items: center; gap: 16px; min-width: 150px;
    }
    .vt-stat-pill-content { flex: 1; }
    .vt-stat-pill-label { font-size: 11px; font-weight: 500; color: var(--vt-text-muted); margin: 0 0 2px; }
    .vt-stat-pill-value { font-size: 22px; font-weight: 800; color: var(--vt-text-main); line-height: 1; }
    .vt-stat-pill-badge {
        background: #fde8cc; color: var(--vt-orange);
        font-size: 10.5px; font-weight: 700;
        padding: 3px 9px; border-radius: 50px; flex-shrink: 0;
    }
    .vt-stat-pill-badge.blue {
        background: #dbeafe; color: #2563eb;
    }

    /* ---- Layout deux colonnes ---- */
    .vt-etapes-layout {
        display: flex; align-items: flex-start; gap: 16px;
    }

    /* ---- Colonne filtre gauche ---- */
    .vt-etapes-filter {
        width: 264px; flex-shrink: 0;
        background: var(--vt-card-bg);
        border-radius: var(--vt-radius);
        box-shadow: var(--vt-shadow);
        padding: 20px 18px;
    }
    .vt-etapes-filter-title {
        font-size: 18px; font-weight: 700;
        color: var(--vt-text-main); margin: 0 0 18px;
    }
    .vt-filter-field-label {
        font-size: 12px; font-weight: 600;
        color: var(--vt-orange); margin-bottom: 6px;
    }
    .vt-filter-input-wrap { position: relative; margin-bottom: 14px; }
    .vt-filter-input-wrap .vt-fi-icon {
        position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 14px; pointer-events: none;
    }
    .vt-filter-select-icon {
        width: 100%; padding: 9px 30px 9px 34px;
        border: 1px solid var(--vt-border); border-radius: var(--vt-radius-sm);
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center / 15px;
        appearance: none; font-size: 13px; color: var(--vt-text-main);
        cursor: pointer; transition: border-color .15s;
    }
    .vt-filter-select-icon:focus { outline: none; border-color: var(--vt-orange); }

    /* Nom session sélectionnée */
    .vt-session-selected-label {
        font-size: 11px; color: var(--vt-text-muted); margin: 0 0 3px;
    }
    .vt-session-selected-name {
        font-size: 13px; font-weight: 700; color: var(--vt-orange);
        margin: 0 0 16px;
        word-break: break-word;
    }

    /* Bouton reset */
    .vt-btn-reset {
        width: 100%; padding: 10px;
        background: #fff; color: var(--vt-text-main);
        border: 1.5px solid var(--vt-border); border-radius: var(--vt-radius-sm);
        font-size: 13.5px; font-weight: 600; cursor: pointer; transition: all .15s;
    }
    .vt-btn-reset:hover { border-color: #94a3b8; background: #f8fafc; }

    /* ---- Colonne droite (tableau) ---- */
    .vt-etapes-main { flex: 1; min-width: 0; }
    .vt-etapes-table-card {
        background: var(--vt-card-bg); border-radius: var(--vt-radius);
        box-shadow: var(--vt-shadow); overflow: hidden;
    }
    .vt-etapes-table-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 20px; border-bottom: 1px solid var(--vt-border);
        gap: 12px; flex-wrap: wrap;
    }
    .vt-etapes-table-title {
        font-size: 15px; font-weight: 700; color: var(--vt-text-main); margin: 0;
    }

    /* Table */
    .vt-etapes-table { width: 100%; border-collapse: collapse; font-size: 12.5px; }
    .vt-etapes-table thead th {
        padding: 11px 16px; font-size: 11px; font-weight: 700;
        letter-spacing: .6px; text-transform: uppercase;
        color: var(--vt-text-muted); border-bottom: 1px solid var(--vt-border);
        white-space: nowrap;
    }
    .vt-etapes-table tbody td {
        padding: 13px 16px; border-bottom: 1px solid var(--vt-border);
        color: var(--vt-text-main); vertical-align: middle;
    }
    .vt-etapes-table tbody tr:last-child td { border-bottom: none; }
    .vt-etapes-table tbody tr:hover td { background: #fafbfc; }
    .vt-etapes-table .cell-name { font-weight: 700; }
    .vt-etapes-table .cell-prix { font-weight: 600; color: var(--vt-orange); }

    /* Badges état */
    .vt-badge-actif {
        background: var(--vt-green-light); color: var(--vt-green);
        font-size: 10.5px; font-weight: 700; padding: 3px 10px; border-radius: 50px;
        display: inline-flex; align-items: center; gap: 4px;
    }
    .vt-badge-inactif {
        background: #f1f5f9; color: var(--vt-text-muted);
        font-size: 10.5px; font-weight: 600; padding: 3px 10px; border-radius: 50px;
    }

    /* Boutons actions */
    .vt-etape-actions { display: flex; gap: 5px; }
    .vt-etape-btn {
        width: 30px; height: 30px; border-radius: 7px;
        border: 1px solid var(--vt-border); background: #fff; color: var(--vt-text-muted);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 13px; cursor: pointer; text-decoration: none; transition: all .15s;
    }
    .vt-etape-btn.edit:hover  { border-color: #93c5fd; color: #2563eb; background: #eff6ff; }
    .vt-etape-btn.del:hover   { border-color: #fca5a5; color: #dc2626; background: #fff5f5; }

    .vt-etapes-empty {
        padding: 32px 16px; text-align: center;
        color: var(--vt-text-muted); font-size: 13px;
    }

    /* Packages dans les modales */
    .vt-pkg-row {
        display: grid; grid-template-columns: 1fr 1fr auto;
        gap: 8px; align-items: center; margin-bottom: 8px;
    }
    .vt-pkg-input {
        width: 100%; padding: 8px 10px;
        border: 1px solid var(--vt-border); border-radius: var(--vt-radius-sm);
        font-size: 12.5px; color: var(--vt-text-main);
        background: #f8fafc;
    }
    .vt-pkg-input:focus { outline: none; border-color: var(--vt-orange); background: #fff; }
    .vt-pkg-del {
        width: 28px; height: 28px; border-radius: 6px;
        border: 1px solid #fca5a5; background: #fff5f5; color: #dc2626;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; cursor: pointer; flex-shrink: 0;
    }
    .vt-pkg-del:hover { background: #fee2e2; }
    .vt-pkg-add-btn {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 12px; color: var(--vt-orange); font-weight: 600;
        border: 1.5px dashed var(--vt-orange-border); border-radius: var(--vt-radius-sm);
        background: var(--vt-orange-light); padding: 7px 14px;
        cursor: pointer; transition: all .15s; width: 100%; margin-top: 4px;
        text-align: center; justify-content: center;
    }
    .vt-pkg-add-btn:hover { background: #fed7aa20; border-color: var(--vt-orange); }

    @media (max-width: 860px) {
        .vt-etapes-layout { flex-direction: column; }
        .vt-etapes-filter { width: 100%; }
        .vt-stat-pill { min-width: auto; flex: 1; }
    }
</style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    {{-- En-tête : titre + stat pills --}}
    <div class="vt-etapes-header">
        <h1 class="vt-etapes-title">Étapes</h1>
        <div class="vt-stat-pills">
            <div class="vt-stat-pill">
                <div class="vt-stat-pill-content">
                    <p class="vt-stat-pill-label">Nbre d'étapes</p>
                    <div class="vt-stat-pill-value" id="stat-nbre-etapes">0</div>
                </div>
                <span class="vt-stat-pill-badge">LIVE</span>
            </div>
            <div class="vt-stat-pill">
                <div class="vt-stat-pill-content">
                    <p class="vt-stat-pill-label">Session active</p>
                    <div class="vt-stat-pill-value" id="stat-session-name" style="font-size:13px; font-weight:600;">—</div>
                </div>
                <span class="vt-stat-pill-badge blue">SESSION</span>
            </div>
        </div>
    </div>

    {{-- Layout deux colonnes --}}
    <div class="vt-etapes-layout">

        {{-- =====================================================
             COLONNE GAUCHE — FILTRE
             ===================================================== --}}
        <div class="vt-etapes-filter">
            <h2 class="vt-etapes-filter-title">Filtrer</h2>

            {{-- Session --}}
            <p class="vt-filter-field-label">Choisir la session</p>
            <div class="vt-filter-input-wrap">
                <i class="ti ti-layout-list vt-fi-icon"></i>
                <select class="vt-filter-select-icon js-select-campagne">
                    <option value="" disabled {{ !request('campagne_id') ? 'selected' : '' }}>
                        Toutes les sessions
                    </option>
                    @foreach($campagnes as $item)
                        <option value="{{ $item['campagne']->campagne_id }}"
                            {{ request('campagne_id') == $item['campagne']->campagne_id ? 'selected' : '' }}>
                            {{ $item['campagne']->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nom session sélectionnée --}}
            <p class="vt-session-selected-label">Session sélectionnée</p>
            <p class="vt-session-selected-name js-display-campagne-name">Aucune</p>

            {{-- Bouton réinitialiser --}}
            <button type="button" class="vt-btn-reset" id="btn-reset-etapes">
                Réinitialiser
            </button>
        </div>

        {{-- =====================================================
             COLONNE DROITE — TABLEAU DES ÉTAPES
             ===================================================== --}}
        <div class="vt-etapes-main">
            <div class="vt-etapes-table-card">

                <div class="vt-etapes-table-header">
                    <h3 class="vt-etapes-table-title">Étapes de la session</h3>
                    <button id="btn-creer-etape"
                            class="vt-btn-primary d-none"
                            style="border-radius: var(--vt-radius-sm); padding: 8px 18px; font-size: 13px;"
                            data-bs-toggle="modal" data-bs-target="#modal_add_step_">
                        <i class="ti ti-plus" style="font-size:13px;"></i> Créer une étape
                    </button>
                </div>

                <div style="overflow-x: auto;">
                    <table class="vt-etapes-table">
                        <thead>
                            <tr>
                                <th>Nom de l'étape</th>
                                <th>Date début</th>
                                <th>Date fin</th>
                                <th>Prix du vote</th>
                                <th>Nbre votes</th>
                                <th>État</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="js-etape-table-body">
                            <tr>
                                <td colspan="7" class="vt-etapes-empty">
                                    Sélectionnez une session pour afficher les étapes.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

@endsection

{{-- =====================================================
     MODAL — NOUVELLE ÉTAPE
     ===================================================== --}}
<div class="modal fade" id="modal_add_step_" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Nouvelle étape</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_add_step" action="{{ route('business.save_etape') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="modal_add_campagne_id" name="campagne_id" value="">

                    <div class="mb-3">
                        <label class="form-label">Nom de l'étape <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Ex: Phase 1 — Demi-finale" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label">Date de début <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_debut" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Heure de début <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" name="heure_debut" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label">Date de fin <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="date_fin" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Heure de fin <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" name="heure_fin" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" name="description" placeholder="Décrivez cette étape..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Prix d'un vote (FCFA) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control js-prix-unitaire" name="prix_vote" placeholder="Ex: 500" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Packages de vote <span class="text-danger">*</span></label>
                        <div class="packages-wrapper">
                            <div class="packages-container" data-index="1" id="packages_container">
                                <div class="vt-pkg-row package-item package-itemadd">
                                    <input type="number" name="packages[0][votes]" class="vt-pkg-input js-package-votes" placeholder="Nombre de votes" required>
                                    <input type="number" name="packages[0][montant]" class="vt-pkg-input js-package-amount" placeholder="Prix (FCFA)" readonly required>
                                    <button type="button" class="vt-pkg-del remove-package d-none">✕</button>
                                </div>
                            </div>
                            <button type="button" class="vt-pkg-add-btn add-package">
                                <i class="ti ti-plus" style="font-size:12px;"></i> Ajouter un package
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer border-top px-0 pb-0 mt-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Enregistrer l'étape
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- =====================================================
     MODAL — MODIFIER ÉTAPE
     ===================================================== --}}
<div class="modal fade" id="modal_update_step" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Modifier l'étape</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_update_step" action="{{ route('business.update_etape') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="etape_id" id="upd_etape_id">
                    <input type="hidden" name="campagne_id" id="upd_campagne_id">

                    <div class="mb-3">
                        <label class="form-label">Nom de l'étape</label>
                        <input type="text" class="form-control" name="name" id="upd_name" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label">Date de début</label>
                            <input type="date" class="form-control" name="date_debut" id="upd_date_debut">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Heure de début</label>
                            <input type="time" class="form-control" name="heure_debut" id="upd_heure_debut">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label">Date de fin</label>
                            <input type="date" class="form-control" name="date_fin" id="upd_date_fin">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Heure de fin</label>
                            <input type="time" class="form-control" name="heure_fin" id="upd_heure_fin">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" name="description" id="upd_description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Prix d'un vote (FCFA)</label>
                        <input type="number" class="form-control js-prix-unitaire" name="prix_vote" id="upd_prix_vote">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Packages de vote</label>
                        <div class="packages-wrapper">
                            <div class="packages-container js-upd-packages-container"></div>
                            <button type="button" class="vt-pkg-add-btn js-add-package-upd mt-2">
                                <i class="ti ti-plus" style="font-size:12px;"></i> Ajouter un package
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer border-top px-0 pb-0 mt-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- =====================================================
     MODAL — SUPPRIMER ÉTAPE
     ===================================================== --}}
<div class="modal fade" id="modal_delete_step" tabindex="-1"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle">
                        <i class="ti ti-trash fs-24"></i>
                    </span>
                </div>
                <h5 class="mb-1">Supprimer l'étape</h5>
                <p class="mb-3 text-muted" style="font-size:13px;">Cette action est irréversible.</p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal">Annuler</button>
                    <button class="btn btn-danger w-100 js-confirm-delete">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
<script>

    /* -------------------------------------------------------
       Packages — ajout/suppression (formulaire création)
       ------------------------------------------------------- */
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('add-package') || e.target.closest('.add-package')) {
            const wrapper    = e.target.closest('.packages-wrapper');
            const container  = wrapper.querySelector('.packages-container');
            const index      = parseInt(container.dataset.index);
            const html = `
                <div class="vt-pkg-row package-item package-itemadd">
                    <input type="number" name="packages[${index}][votes]"
                           class="vt-pkg-input js-package-votes" placeholder="Nombre de votes" required>
                    <input type="number" name="packages[${index}][montant]"
                           class="vt-pkg-input js-package-amount" placeholder="Prix (FCFA)" readonly required>
                    <button type="button" class="vt-pkg-del remove-package">✕</button>
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
            container.dataset.index = index + 1;
        }
        if (e.target.classList.contains('remove-package')) {
            e.target.closest('.package-item').remove();
        }
    });

    /* Calcul montants auto (création) */
    document.addEventListener('input', function (e) {
        if (e.target.name === 'prix_vote' || e.target.name.includes('[votes]')) {
            calculerMontants();
        }
    });

    function calculerMontants() {
        const prixVote = parseFloat(document.querySelector('#form_add_step input[name="prix_vote"]')?.value) || 0;
        document.querySelectorAll('.package-itemadd').forEach(pkg => {
            const votes  = parseFloat(pkg.querySelector('input[name*="[votes]"]')?.value) || 0;
            const montantInput = pkg.querySelector('input[name*="[montant]"]');
            if (montantInput) montantInput.value = votes > 0 ? (prixVote * votes) : '';
        });
    }

    /* -------------------------------------------------------
       jQuery — logique principale
       ------------------------------------------------------- */
    $(document).ready(function () {

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        /* ----- 1. SÉLECTION DE SESSION ----- */
        $(document).on('change', '.js-select-campagne', function () {
            const id   = $(this).val();
            const name = $(this).find('option:selected').text();

            /* Met à jour la modale d'ajout */
            $('#modal_add_campagne_id').val(id);

            /* Bouton créer */
            if (id) {
                $('#btn-creer-etape').removeClass('d-none');
            } else {
                $('#btn-creer-etape').addClass('d-none');
            }

            /* Affichage visuel */
            $('.js-display-campagne-name').text(id ? name : 'Aucune');
            $('#stat-session-name').text(id ? name.substring(0, 18) + (name.length > 18 ? '…' : '') : '—');

            /* Chargement AJAX */
            $('.js-etape-table-body').html(
                '<tr><td colspan="7" class="vt-etapes-empty"><div class="spinner-border spinner-border-sm text-primary me-2"></div> Chargement...</td></tr>'
            );

            if (!id) {
                $('.js-etape-table-body').html(
                    '<tr><td colspan="7" class="vt-etapes-empty">Sélectionnez une session pour afficher les étapes.</td></tr>'
                );
                $('#stat-nbre-etapes').text('0');
                return;
            }

            $.ajax({
                url: `/business/recherche_etape_campagne/${id}`,
                method: 'GET',
                success: function (etapes) {
                    renderEtapeTable(etapes);
                    $('#stat-nbre-etapes').text(etapes.length);
                },
                error: function () {
                    $('.js-etape-table-body').html(
                        '<tr><td colspan="7" class="vt-etapes-empty" style="color:#dc2626;">Erreur de chargement.</td></tr>'
                    );
                }
            });
        });

        /* ----- 2. RENDU DU TABLEAU ----- */
        function renderEtapeTable(etapes) {
            if (etapes.length === 0) {
                $('.js-etape-table-body').html(
                    '<tr><td colspan="7" class="vt-etapes-empty">Aucune étape pour cette session.</td></tr>'
                );
                return;
            }
            let html = '';
            etapes.forEach(etape => {
                const data     = encodeURIComponent(JSON.stringify(etape));
                const actif    = etape.is_active == 0;
                const badgeCls = actif ? 'vt-badge-actif' : 'vt-badge-inactif';
                const badgeTxt = actif ? '<i class="ti ti-check" style="font-size:10px;"></i> Actif' : 'Inactif';

                html += `
                <tr>
                    <td class="cell-name">${etape.name}</td>
                    <td>${etape.date_debut || '—'}</td>
                    <td>${etape.date_fin || '—'}</td>
                    <td class="cell-prix">${Number(etape.prix_vote).toLocaleString('fr-FR')} FCFA</td>
                    <td>—</td>
                    <td><span class="${badgeCls}">${badgeTxt}</span></td>
                    <td>
                        <div class="vt-etape-actions">
                            <button class="vt-etape-btn edit js-btn-edit" data-etape="${data}" title="Modifier">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button class="vt-etape-btn del js-btn-delete" data-id="${etape.etape_id}" title="Supprimer">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
            });
            $('.js-etape-table-body').html(html);
        }

        /* ----- 3. MODAL ÉDITION ----- */
        $(document).on('click', '.js-btn-edit', function () {
            const data   = JSON.parse(decodeURIComponent($(this).data('etape')));
            const $modal = $('#modal_update_step');

            $modal.find('input[name="etape_id"]').val(data.etape_id);
            $modal.find('input[name="campagne_id"]').val(data.campagne_id);
            $modal.find('input[name="name"]').val(data.name);
            $modal.find('input[name="date_debut"]').val(data.date_debut);
            $modal.find('input[name="date_fin"]').val(data.date_fin);
            $modal.find('input[name="heure_debut"]').val(data.heure_debut);
            $modal.find('input[name="heure_fin"]').val(data.heure_fin);
            $modal.find('textarea[name="description"]').val(data.description);
            $modal.find('input[name="prix_vote"]').val(data.prix_vote);
            renderUpdatePackages(data.package, $modal);

            $modal.modal('show');
        });

        /* ----- 4. MODAL SUPPRESSION ----- */
        $(document).on('click', '.js-btn-delete', function () {
            const id = $(this).data('id');
            $('#modal_delete_step').find('.js-confirm-delete').attr('data-id', id);
            $('#modal_delete_step').modal('show');
        });

        /* ----- 5. CONFIRMER SUPPRESSION ----- */
        $(document).on('click', '.js-confirm-delete', function () {
            const id  = $(this).data('id');
            const $btn = $(this);
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

            $.ajax({
                url: `/business/delete_etape/${id}`,
                method: 'POST',
                data: { _method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    $('#modal_delete_step').modal('hide');
                    if (response.success && typeof showAjaxAlert === 'function')
                        showAjaxAlert('success', response.message);
                    $('.js-select-campagne').trigger('change');
                },
                error: function (xhr) {
                    $('#modal_delete_step').modal('hide');
                    const msg = xhr.responseJSON?.message || 'Erreur lors de la suppression.';
                    if (typeof showAjaxAlert === 'function') showAjaxAlert('danger', msg);
                },
                complete: function () { $btn.prop('disabled', false).text('Supprimer'); }
            });
        });

        /* ----- RESET ----- */
        $('#btn-reset-etapes').on('click', function () {
            $('.js-select-campagne').val('').trigger('change');
        });

        /* ----- PACKAGES (update modal) ----- */
        function renderUpdatePackages(packagesData, $modal) {
            const $container = $modal.find('.js-upd-packages-container');
            $container.empty();
            let packages = [];
            try { packages = typeof packagesData === 'string' ? JSON.parse(packagesData) : packagesData; }
            catch (e) { packages = []; }

            if (packages && packages.length > 0) {
                packages.forEach((pkg, i) => {
                    $container.append(`
                        <div class="vt-pkg-row package-item">
                            <input type="number" name="packages[${i}][votes]"
                                   value="${pkg.vote}" class="vt-pkg-input js-package-votes" placeholder="Votes">
                            <input type="number" name="packages[${i}][montant]"
                                   value="${pkg.montant}" class="vt-pkg-input js-package-amount" readonly>
                            <button type="button" class="vt-pkg-del js-remove-package">✕</button>
                        </div>`);
                });
            }
        }

        $(document).on('click', '.js-add-package-upd', function () {
            const $modal     = $(this).closest('.modal');
            const $container = $modal.find('.js-upd-packages-container');
            const index      = $container.find('.package-item').length;
            $container.append(`
                <div class="vt-pkg-row package-item">
                    <input type="number" name="packages[${index}][votes]"
                           class="vt-pkg-input js-package-votes" placeholder="Votes">
                    <input type="number" name="packages[${index}][montant]"
                           class="vt-pkg-input js-package-amount" readonly>
                    <button type="button" class="vt-pkg-del js-remove-package">✕</button>
                </div>`);
        });

        $(document).on('click', '.js-remove-package', function () {
            $(this).closest('.package-item').remove();
        });

        /* Calcul montants auto (édition) */
        $(document).on('input', '.js-package-votes', function () {
            const $modal      = $(this).closest('.modal');
            const prixUnit    = parseFloat($modal.find('.js-prix-unitaire').val()) || 0;
            const nbVotes     = parseFloat($(this).val()) || 0;
            $(this).closest('.package-item').find('.js-package-amount').val(nbVotes > 0 ? nbVotes * prixUnit : '');
        });

        $(document).on('input', '.js-prix-unitaire', function () {
            $(this).closest('.modal').find('.js-package-votes').each(function () {
                $(this).trigger('input');
            });
        });

        /* ----- ENREGISTREMENT AJAX (ajout) ----- */
        $('#form_add_step').on('submit', function (e) {
            e.preventDefault();
            const $form      = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const origHtml   = $submitBtn.html();
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').remove();
            $submitBtn.prop('disabled', true).html('Enregistrement...');

            $.ajax({
                url: $form.attr('action'), type: 'POST',
                data: new FormData(this), processData: false, contentType: false,
                success: function (response) {
                    $('#modal_add_step_').modal('hide');
                    $form[0].reset();
                    $form.find('.package-itemadd').not(':first').remove();
                    if (response.success && typeof showAjaxAlert === 'function')
                        showAjaxAlert('success', response.message);
                    $('.js-select-campagne').trigger('change');
                },
                error: function (xhr) {
                    handleFormErrors(xhr, $form);
                },
                complete: function () { $submitBtn.prop('disabled', false).html(origHtml); }
            });
        });

        /* ----- MISE À JOUR AJAX (édition) ----- */
        $('#form_update_step').on('submit', function (e) {
            e.preventDefault();
            const $form      = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const origHtml   = $submitBtn.html();
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').remove();
            $submitBtn.prop('disabled', true).html('Mise à jour...');

            $.ajax({
                url: $form.attr('action'), type: 'POST',
                data: new FormData(this), processData: false, contentType: false,
                success: function (response) {
                    $('#modal_update_step').modal('hide');
                    if (response.success && typeof showAjaxAlert === 'function')
                        showAjaxAlert('success', response.message);
                    $('.js-select-campagne').trigger('change');
                },
                error: function (xhr) {
                    handleFormErrors(xhr, $form);
                },
                complete: function () { $submitBtn.prop('disabled', false).html(origHtml); }
            });
        });

        /* ----- Gestion erreurs formulaires ----- */
        function handleFormErrors(xhr, $form) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                if (typeof showAjaxAlert === 'function')
                    showAjaxAlert('danger', 'Veuillez vérifier les champs du formulaire.');
                $.each(errors, function (fieldName, messages) {
                    let $input = $form.find(`[name="${fieldName}"], [name="${fieldName}[]"]`).first();
                    if ($input.length) {
                        $input.addClass('is-invalid');
                        const errHtml = `<div class="invalid-feedback d-block" style="color:#dc3545;font-size:11.5px;">${messages[0]}</div>`;
                        if ($input.closest('.input-group').length) $input.closest('.input-group').after(errHtml);
                        else $input.after(errHtml);
                    }
                });
                $form.find('.is-invalid').first().focus();
            } else {
                const msg = xhr.responseJSON?.message || 'Une erreur est survenue.';
                if (typeof showAjaxAlert === 'function') showAjaxAlert('danger', msg);
            }
        }

        /* ----- AUTOLOAD si session pré-sélectionnée (URL param) ----- */
        const preSelected = $('.js-select-campagne').val();
        if (preSelected) $('.js-select-campagne').trigger('change');

    });
</script>
@endsection
