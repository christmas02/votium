@extends('refont.layout.app')

@section('title', 'Sessions de votes')

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li>
        <a href="{{ route('business.espace') }}">
            <i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil
        </a>
    </li>
    <li class="vt-breadcrumb-sep">
        <i class="ti ti-chevron-right" style="font-size:11px;"></i>
    </li>
    <li class="active">Sessions</li>
@endsection

{{-- ===== CSS SPÉCIFIQUE ===== --}}
@section('extra-css')
    <style>
        /* ---- Page header ---- */
        .vt-page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--vt-text-main);
            margin: 0 0 8px;
            letter-spacing: -.3px;
        }

        .vt-page-desc {
            font-size: 12.5px;
            color: var(--vt-text-muted);
            margin: 0 0 20px;
            max-width: 620px;
            line-height: 1.6;
        }

        /* ---- Toolbar ---- */
        .vt-toolbar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .vt-counter-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--vt-card-bg);
            border: 1px solid var(--vt-border);
            border-radius: 50px;
            padding: 7px 16px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--vt-text-main);
            box-shadow: var(--vt-shadow);
            white-space: nowrap;
        }

        .vt-counter-num {
            font-size: 13px;
            font-weight: 700;
            color: var(--vt-orange);
        }

        .vt-search-wrap {
            position: relative;
            flex: 1;
            max-width: 340px;
            min-width: 200px;
        }

        .vt-search-wrap .vt-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--vt-text-muted);
            font-size: 14px;
            pointer-events: none;
        }

        .vt-search-input {
            width: 100%;
            padding: 8px 14px 8px 36px;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: var(--vt-card-bg);
            font-size: 12.5px;
            color: var(--vt-text-main);
            box-shadow: var(--vt-shadow);
            transition: border-color .15s, box-shadow .15s;
            font-family: inherit;
        }

        .vt-search-input::placeholder {
            color: var(--vt-text-muted);
        }

        .vt-search-input:focus {
            outline: none;
            border-color: var(--vt-orange);
            box-shadow: 0 0 0 3px var(--vt-orange-light), var(--vt-shadow);
        }

        .vt-btn-dark {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--vt-navy);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 8px 18px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background .15s, box-shadow .15s;
            white-space: nowrap;
            box-shadow: var(--vt-shadow);
        }

        .vt-btn-dark:hover {
            background: var(--vt-navy-dark);
            color: #fff;
            box-shadow: var(--vt-shadow-md);
        }

        /* ---- Sessions table card ---- */
        .vt-sessions-card {
            background: var(--vt-card-bg);
            border-radius: var(--vt-radius);
            box-shadow: var(--vt-shadow);
            overflow: hidden;
        }

        .vt-sessions-table {
            width: 100%;
            border-collapse: collapse;
        }

        .vt-sessions-table thead th {
            padding: 12px 16px;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--vt-text-muted);
            border-bottom: 1px solid var(--vt-border);
            background: var(--vt-card-bg);
            white-space: nowrap;
        }

        .vt-sessions-table tbody td {
            padding: 12px 16px;
            font-size: 12.5px;
            color: var(--vt-text-main);
            border-bottom: 1px solid var(--vt-border);
            vertical-align: middle;
        }

        .vt-sessions-table tbody tr:last-child td {
            border-bottom: none;
        }

        .vt-sessions-table tbody tr:hover {
            background: #f8fafc;
        }

        .vt-sessions-table tbody tr:hover td {
            background: transparent;
        }

        /* Lien nom de session */
        .vt-session-name {
            font-weight: 600;
            color: var(--vt-text-main);
            text-decoration: none;
            font-size: 12.5px;
            transition: color .15s;
        }

        .vt-session-name:hover {
            color: var(--vt-orange);
            text-decoration: underline;
        }

        /* Badge inscription */
        .vt-badge-on {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--vt-green-light);
            color: var(--vt-green);
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 50px;
        }

        .vt-badge-on i {
            font-size: 10px;
        }

        .vt-badge-off {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #f1f5f9;
            color: var(--vt-text-muted);
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 50px;
        }

        /* Boutons actions */
        .vt-action-btns {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .vt-action-btn {
            width: 32px;
            height: 32px;
            border-radius: var(--vt-radius-sm);
            border: 1px solid var(--vt-border);
            background: var(--vt-card-bg);
            color: var(--vt-text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }

        .vt-action-btn:hover {
            border-color: var(--vt-text-muted);
            color: var(--vt-text-main);
            background: var(--vt-page-bg);
        }

        .vt-action-btn.danger {
            color: #dc2626;
        }

        .vt-action-btn.danger:hover {
            border-color: #fca5a5;
            background: #fff5f5;
            box-shadow: var(--vt-shadow);
        }

        .vt-action-btn.success {
            color: var(--vt-green);
        }

        .vt-action-btn.success:hover {
            border-color: #86efac;
            background: #f0fdf4;
            box-shadow: var(--vt-shadow);
        }

        .vt-action-btn.info {
            color: var(--vt-blue-chart);
        }

        .vt-action-btn.info:hover {
            border-color: #93c5fd;
            background: #eff6ff;
            box-shadow: var(--vt-shadow);
        }

        /* ---- Pied de tableau ---- */
        .vt-table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-top: 1px solid var(--vt-border);
            font-size: 12px;
            color: var(--vt-text-muted);
            flex-wrap: wrap;
            gap: 8px;
            background: var(--vt-card-bg);
        }

        .vt-pagination {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .vt-pagination-btn {
            width: 28px;
            height: 28px;
            border-radius: var(--vt-radius-sm);
            border: 1px solid var(--vt-border);
            background: var(--vt-card-bg);
            color: var(--vt-text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            transition: all .15s;
            text-decoration: none;
        }

        .vt-pagination-btn:hover {
            border-color: var(--vt-orange);
            color: var(--vt-orange);
            background: var(--vt-orange-light);
        }

        .vt-pagination-btn:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .vt-pagination-label {
            padding: 0 8px;
            font-size: 11.5px;
            color: var(--vt-text-muted);
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .vt-toolbar {
                gap: 10px;
                margin-bottom: 16px;
            }

            .vt-search-wrap {
                min-width: 120px;
            }

            .vt-sessions-table {
                font-size: 11.5px;
            }

            .vt-sessions-table thead th,
            .vt-sessions-table tbody td {
                padding: 10px 12px;
            }

            .vt-action-btns {
                gap: 3px;
            }
        }

        /* ================================================
                                       MODAL "NOUVELLE SESSION" / "MODIFIER SESSION"
                                       ================================================ */

        /* Header gradient — commun à tous les modals session */
        .vt-modal-ns-header {
            background: linear-gradient(to bottom, #fdf6f0 0%, #ffffff 70%);
            padding: 24px 24px 16px;
            border-bottom: 1px solid var(--vt-orange-border);
        }

        .vt-modal-ns-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--vt-text-main);
            margin: 0 0 4px;
        }

        .vt-modal-ns-sub {
            font-size: 12px;
            color: var(--vt-orange);
            font-style: italic;
            margin: 0;
        }

        .vt-modal-close {
            position: absolute;
            top: 18px;
            right: 20px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1.5px solid var(--vt-border);
            background: #fff;
            color: var(--vt-text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            cursor: pointer;
            transition: all .15s;
        }

        .vt-modal-close:hover {
            border-color: #94a3b8;
            color: var(--vt-text-main);
        }

        /* Labels uppercase orange */
        .vt-ns-label {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--vt-text-muted);
            margin-bottom: 7px;
            display: block;
        }

        /* Inputs */
        .vt-ns-input {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            font-size: 13px;
            color: var(--vt-text-main);
            background: #fff;
            transition: border-color .15s;
            font-family: inherit;
        }

        .vt-ns-input:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        .vt-ns-input::placeholder {
            color: #94a3b8;
        }

        textarea.vt-ns-input {
            resize: vertical;
            min-height: 90px;
        }

        /* Select */
        .vt-ns-select {
            width: 100%;
            padding: 10px 32px 10px 13px;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center / 15px;
            appearance: none;
            font-size: 13px;
            color: var(--vt-text-main);
            cursor: pointer;
            transition: border-color .15s;
            font-family: inherit;
        }

        .vt-ns-select:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        /* Zone upload */
        .vt-ns-dropzone {
            width: 100%;
            padding: 16px 18px;
            border: 2px dashed var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            position: relative;
            transition: border-color .15s;
            overflow: hidden;
        }

        .vt-ns-dropzone:hover {
            border-color: #94a3b8;
        }

        .vt-ns-dropzone-text {
            font-size: 12.5px;
            color: var(--vt-text-muted);
            flex: 1;
        }

        .vt-ns-dropzone-btn {
            background: var(--vt-orange);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            flex-shrink: 0;
            white-space: nowrap;
            position: relative;
            z-index: 1;
        }

        .vt-ns-dropzone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

        .vt-ns-dropzone-preview {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        /* Option cards */
        .vt-ns-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 16px;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fff;
            margin-bottom: 8px;
            cursor: pointer;
            transition: border-color .15s;
            gap: 12px;
        }

        .vt-ns-option:hover {
            border-color: #94a3b8;
        }

        .vt-ns-option input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--vt-orange);
            flex-shrink: 0;
            cursor: pointer;
        }

        .vt-ns-option-text {
            flex: 1;
        }

        .vt-ns-option-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--vt-text-main);
            margin: 0 0 2px;
        }

        .vt-ns-option-desc {
            font-size: 11.5px;
            color: var(--vt-text-muted);
            margin: 0;
        }

        /* Radio pills */
        .vt-ns-radio-pills {
            display: flex;
            gap: 6px;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .vt-ns-radio-pills input[type="radio"] {
            display: none;
        }

        .vt-ns-radio-pills label {
            padding: 5px 14px;
            border-radius: 50px;
            border: 1.5px solid var(--vt-border);
            font-size: 12px;
            font-weight: 600;
            color: var(--vt-text-muted);
            cursor: pointer;
            transition: all .15s;
            white-space: nowrap;
        }

        .vt-ns-radio-pills input[type="radio"]:checked+label {
            background: var(--vt-orange);
            color: #fff;
            border-color: var(--vt-orange);
        }

        /* Couleurs */
        .vt-ns-color-wrap {
            display: flex;
            align-items: stretch;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            overflow: hidden;
            background: #fff;
        }

        .vt-ns-color-text {
            flex: 1;
            padding: 9px 12px;
            border: none;
            outline: none;
            font-size: 13px;
            color: var(--vt-text-main);
            font-family: monospace;
        }

        .vt-ns-color-display {
            width: 42px;
            flex-shrink: 0;
            border-left: 1.5px solid var(--vt-border);
            position: relative;
            overflow: hidden;
            min-height: 38px;
        }

        .vt-ns-color-swatch {
            position: absolute;
            inset: 0;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            opacity: 0;
            cursor: pointer;
        }

        /* Hint */
        .vt-ns-hint {
            font-size: 11.5px;
            color: var(--vt-orange);
            margin: 6px 0 0;
            font-style: italic;
        }

        /* Section étape active */
        .vt-ns-section-title {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--vt-orange);
            margin-bottom: 4px;
            display: block;
        }

        .vt-ns-section-desc {
            font-size: 11.5px;
            color: var(--vt-orange);
            margin-bottom: 14px;
            line-height: 1.5;
        }

        /* Footer sticky */
        .vt-modal-ns-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding: 14px 24px;
            border-top: 1px solid var(--vt-border);
            background: #fff;
            z-index: 10;
        }

        .vt-ns-btn-cancel {
            padding: 9px 22px;
            border-radius: 50px;
            border: 1.5px solid var(--vt-border);
            background: #fff;
            color: var(--vt-text-main);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .vt-ns-btn-cancel:hover {
            border-color: #94a3b8;
        }

        .vt-ns-btn-submit {
            padding: 9px 24px;
            border-radius: 50px;
            background: var(--vt-orange);
            color: #fff;
            border: none;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .vt-ns-btn-submit:hover {
            background: var(--vt-orange-hover);
        }
    </style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    {{-- Page header --}}
    <h1 class="vt-page-title">Sessions de votes</h1>
    <p class="vt-page-desc">
        Gérez vos campagnes : étapes, candidats, inscriptions, packs de votes et affichage (pourcentage / clair).
        Tout est modifiable par session.
    </p>

    <div class="col-sm-12">@include('layout.status')</div>

    {{-- Toolbar --}}
    <div class="vt-toolbar">

        {{-- Compteur --}}
        <div class="vt-counter-pill">
            <span class="vt-counter-num">{{ count($campagnes) }}</span>
            sessions
        </div>

        {{-- Recherche --}}
        <div class="vt-search-wrap">
            <i class="ti ti-search vt-search-icon"></i>
            <input type="text" id="searchSession" class="vt-search-input" placeholder="Rechercher une session...">
        </div>

        {{-- Nouvelle session --}}
        <a href="javascript:void(0);" class="vt-btn-dark" data-bs-toggle="modal" data-bs-target="#modal_add_campaign">
            <i class="ti ti-plus" style="font-size:14px;"></i> Nouvelle session
        </a>

    </div>

    {{-- Tableau des sessions --}}
    <div class="vt-sessions-card">
        <div style="overflow-x: auto;">
            <table class="vt-sessions-table" id="sessions-table">
                <thead>
                    <tr>
                        <th style="width:40%;">Nom de session</th>
                        <th>Nbre d'étapes</th>
                        <th>Nbre de candidats</th>
                        <th>Créée le</th>
                        <th>Inscriptions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="sessions-tbody">
                    @forelse($campagnes as $item)
                        <tr class="session-row" data-name="{{ strtolower($item['campagne']->name) }}">
                            <td>
                                <a href="{{ route('business.list_etape', [$customer->customer_id, $item['campagne']->campagne_id]) }}"
                                    class="vt-session-name">
                                    {{ $item['campagne']->name }}
                                </a>
                            </td>
                            <td>{{ $item['nbrEtape'] }}</td>
                            <td>{{ $item['nbrCandidat'] }}</td>
                            <td>{{ $item['campagne']->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if ($item['campagne']->inscription_isActive)
                                    <span class="vt-badge-on">
                                        <i class="ti ti-check" style="font-size:11px;"></i> Autorisées
                                    </span>
                                @else
                                    <span class="vt-badge-off">Non‑autorisées</span>
                                @endif
                            </td>
                            <td>
                                <div class="vt-action-btns">
                                    <a href="{{ route('business.site_campagne', [$item['campagne']->campagne_id]) }}"
                                        target="_blank" class="vt-action-btn success" title="Voir le site">
                                        <i class="ti ti-external-link"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="vt-action-btn info" data-bs-toggle="modal"
                                        data-bs-target="#modal_edit_campaign_{{ $item['campagne']->campagne_id }}"
                                        title="Modifier">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    @if ($item['campagne']->inscription_isActive)
                                        <a href="javascript:void(0);" class="vt-action-btn" title="Options">
                                            <i class="ti ti-menu-2"></i>
                                        </a>
                                    @endif
                                    <a href="javascript:void(0);" class="vt-action-btn danger" data-bs-toggle="modal"
                                        data-bs-target="#delete_contact_{{ $item['campagne']->campagne_id }}"
                                        title="Supprimer">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-row">
                            <td colspan="6" style="padding: 20px; font-size:13px; color: var(--vt-text-muted);">
                                Aucune session trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pied de tableau --}}
        <div class="vt-table-footer">
            <span id="table-count">
                {{ count($campagnes) }} affichée(s) &bull; Données en direct
            </span>
            <div class="vt-pagination">
                <button class="vt-pagination-btn" disabled>
                    <i class="ti ti-chevron-left" style="font-size:12px;"></i>
                </button>
                <span class="vt-pagination-label">Page 1 / 1</span>
                <button class="vt-pagination-btn" disabled>
                    <i class="ti ti-chevron-right" style="font-size:12px;"></i>
                </button>
            </div>
        </div>

    </div>

@endsection

{{-- =====================================================
     MODALES (inchangées, juste déplacées hors du @section)
     ===================================================== --}}

{{-- =====================================================
     MODAL — NOUVELLE SESSION
     ===================================================== --}}
<div class="modal fade" id="modal_add_campaign" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 680px;">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">

            {{-- Header gradient --}}
            <div class="vt-modal-ns-header position-relative">
                <h2 class="vt-modal-ns-title">Nouvelle session</h2>
                <p class="vt-modal-ns-sub">
                    Paramétrez la session : cover, inscriptions, affichage des votes, packs visibles, couleurs.
                </p>
                <button type="button" class="vt-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x" style="font-size:14px;"></i>
                </button>
            </div>

            {{-- Corps --}}
            <div class="modal-body" style="padding: 22px 24px 0;">
                <form class="ajax-form" action="{{ route('business.save_campagne') }}" method="POST"
                    enctype="multipart/form-data" id="form-new-session">
                    @csrf
                    <input type="hidden" name="_form_id" value="form_create">
                    <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">

                    {{-- Ligne 1 : Nom + Inscriptions --}}
                    <div class="row g-3 mb-4">
                        <div class="col-8">
                            <label class="vt-ns-label">Nom de la session</label>
                            <input type="text" class="vt-ns-input" name="name"
                                placeholder="Ex: Finale CNC 2026" required onfocus="this.classList.add('focused')"
                                onblur="this.classList.remove('focused')">
                        </div>
                        <div class="col-4">
                            <label class="vt-ns-label">Inscriptions</label>
                            <select class="vt-ns-select" id="inscriptions-select">
                                <option value="">Choisissez une option</option>
                                <option value="1">Autorisées</option>
                                <option value="0">Non-autorisées</option>
                            </select>
                            {{-- Champ caché pour la compatibilité backend --}}
                            <input type="hidden" name="inscription_isActive" id="inscription_isActive_hidden"
                                value="1">
                        </div>
                    </div>

                    {{-- ----------------------------------------
                        Si inscriptions autorisées, afficher les champs liés (date de début/fin, heure de début/fin.)
                         ---------------------------------------- --}}
                    <div class="mb-4" id="bloc-dates-inscription"
                        style="padding: 18px; background: #fdf6f0; border-radius: var(--vt-radius-sm); border: 1px solid var(--vt-orange-border);">
                        <span class="vt-ns-section-title">Les differentes date d'inscriptions</span>
                        <div class="row g-3">

                            <div class="col-6">
                                <label class="vt-ns-label">Date Début</label>
                                <input type="date" class="vt-ns-input" name="inscription_date_debut">
                            </div>
                            <div class="col-6">
                                <label class="vt-ns-label">Date Fin</label>
                                <input type="date" class="vt-ns-input" name="inscription_date_fin">
                            </div>
                            <div class="col-6">
                                <label class="vt-ns-label">Heure Début</label>
                                <input type="time" class="vt-ns-input" name="heure_debut_inscription">
                            </div>
                            <div class="col-6">
                                <label class="vt-ns-label">Heure Fin</label>
                                <input type="time" class="vt-ns-input" name="heure_fin_inscription">
                            </div>

                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="vt-ns-label">Décrivez la session</label>
                        <textarea class="vt-ns-input" name="description" rows="4" placeholder="But, durée, règles, infos utiles..."
                            required></textarea>
                    </div>

                    {{-- Image de couverture --}}
                    <div class="mb-4 image-upload-group">
                        <label class="vt-ns-label">Image de couverture</label>
                        <div class="vt-ns-dropzone drop-zone-target">
                            <div class="placeholder-target">
                                <span class="vt-ns-dropzone-text">
                                    Glissez une image ici (démo) · ou cliquez sur "Choisir"
                                </span>
                            </div>
                            <img src="#" alt="" class="vt-ns-dropzone-preview preview-target">
                            <button type="button" class="vt-ns-dropzone-btn">Choisir</button>
                            <input type="file" name="image_couverture" accept="image/*"
                                onchange="handleNsImagePreview(this, 'form-new-session')">
                        </div>
                    </div>

                    {{-- OPTIONS --}}

                    {{-- Texte sur le cover --}}
                    <label class="vt-ns-option" for="textCoverSwitch">
                        <div class="vt-ns-option-text">
                            <p class="vt-ns-option-title">Texte sur le cover</p>
                            <p class="vt-ns-option-desc">Afficher un titre/infos au-dessus de l'image de couverture.
                            </p>
                        </div>
                        <input type="checkbox" id="textCoverSwitch" name="text_cover_isActive" value="1">
                    </label>

                    {{-- Identifiants personnalisés --}}
                    <label class="vt-ns-option" for="identifiantsSwitch">
                        <div class="vt-ns-option-text">
                            <p class="vt-ns-option-title">Identifiants candidats personnalisés</p>
                            <p class="vt-ns-option-desc">Permet d'imposer des numéros / codes (ex: 0001...)</p>
                        </div>
                        <input type="checkbox" id="identifiantsSwitch" name="identifiants_personnalises_isActive"
                            value="1">
                    </label>

                    {{-- Affichage des votes --}}
                    <div class="vt-ns-option" style="cursor: default;">
                        <div class="vt-ns-option-text">
                            <p class="vt-ns-option-title">Affichage des votes</p>
                            <p class="vt-ns-option-desc">Choix visible côté public (selon la session).</p>
                        </div>
                        <div class="vt-ns-radio-pills">
                            <input type="radio" name="afficher_montant_pourcentage" id="aff_clair" value="clair"
                                checked>
                            <label for="aff_clair">Clair</label>
                            <input type="radio" name="afficher_montant_pourcentage" id="aff_pct"
                                value="pourcentage">
                            <label for="aff_pct">Pourcentage</label>
                            <input type="radio" name="afficher_montant_pourcentage" id="aff_deux"
                                value="les_deux">
                            <label for="aff_deux">Les deux</label>
                        </div>
                    </div>

                    {{-- Ordonner candidats --}}
                    <label class="vt-ns-option" for="ordonnerSwitch">
                        <div class="vt-ns-option-text">
                            <p class="vt-ns-option-title">Ordonner les candidats par votes décroissants</p>
                            <p class="vt-ns-option-desc">Recommandé pour afficher un classement.</p>
                        </div>
                        <input type="checkbox" id="ordonnerSwitch" name="ordonner_candidats_votes_decroissants"
                            value="1">
                    </label>

                    {{-- Quantité de votes visibles --}}
                    {{-- <div class="mb-4 mt-2">
                        <label class="vt-ns-label">Quantité de votes visibles</label>
                        <input type="text" class="vt-ns-input" name="quantite_vote"
                               value="1,2,5,10,20,50" placeholder="Ex: 1,2,5,10,20,50">
                        <p class="vt-ns-hint">
                            Astuce : les packs &lt; 200 FCFA seront ignorés (démo). Prix du vote défini à l'étape.
                        </p>
                    </div> --}}



                    {{-- Couleurs --}}
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="vt-ns-label">Couleur primaire</label>
                            <div class="vt-ns-color-wrap">
                                <input type="text" class="vt-ns-color-text" id="cp-text-new" value="#01233f"
                                    maxlength="7"
                                    oninput="syncColor('cp-text-new','cp-swatch-new','cp-display-new')">
                                <div class="vt-ns-color-display" id="cp-display-new" style="background:#01233f;"
                                    title="Choisir">
                                    <input type="color" class="vt-ns-color-swatch" id="cp-swatch-new"
                                        name="color_primaire" value="#01233f"
                                        oninput="syncColorFromSwatch('cp-swatch-new','cp-text-new','cp-display-new')">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="vt-ns-label">Couleur secondaire</label>
                            <div class="vt-ns-color-wrap">
                                <input type="text" class="vt-ns-color-text" id="cs-text-new" value="#f17100"
                                    maxlength="7"
                                    oninput="syncColor('cs-text-new','cs-swatch-new','cs-display-new')">
                                <div class="vt-ns-color-display" id="cs-display-new" style="background:#f17100;"
                                    title="Choisir">
                                    <input type="color" class="vt-ns-color-swatch" id="cs-swatch-new"
                                        name="color_secondaire" value="#f17100"
                                        oninput="syncColorFromSwatch('cs-swatch-new','cs-text-new','cs-display-new')">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Conditions de participation --}}
                    <div class="mb-4">
                        <label class="vt-ns-label">Conditions de participation (document)</label>
                        <div class="vt-ns-dropzone" style="height: 52px;">
                            <span class="vt-ns-dropzone-text" id="pdf-label-new">
                                Ajoutez un PDF (démo) — Conditions de vote / participation.&nbsp;
                                <span style="color: var(--vt-text-muted); font-weight:600;">Aucun document</span>
                            </span>
                            <button type="button" class="vt-ns-dropzone-btn"
                                style="background: var(--vt-navy);">Insérer</button>
                            <input type="file" name="condition_participation" accept=".pdf"
                                onchange="document.getElementById('pdf-label-new').innerHTML = 'Ajoutez un PDF — <strong>' + this.files[0].name + '</strong>'">
                        </div>
                    </div>

                </form>
            </div>

            {{-- Footer sticky --}}
            <div class="vt-modal-ns-footer">
                <button type="button" class="vt-ns-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="form-new-session" class="vt-ns-btn-submit">
                    <i class="ti ti-device-floppy" style="font-size:14px;"></i> Valider
                </button>
            </div>

        </div>
    </div>
</div>

{{-- =====================================================
     MODALES ÉDITION — design "Nouvelle session"
     ===================================================== --}}
@foreach ($campagnes as $item)
    @php $cid = $item['campagne']->campagne_id; @endphp

    <div class="modal fade" id="modal_edit_campaign_{{ $cid }}" tabindex="-1" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 680px;">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">

                {{-- Header gradient --}}
                <div class="vt-modal-ns-header position-relative">
                    <h2 class="vt-modal-ns-title">Modifier la session</h2>
                    <p class="vt-modal-ns-sub">
                        {{ $item['campagne']->name }}
                    </p>
                    <button type="button" class="vt-modal-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x" style="font-size:14px;"></i>
                    </button>
                </div>

                {{-- Corps --}}
                <div class="modal-body" style="padding: 22px 24px 0;">
                    <form class="ajax-form" action="{{ route('business.update_campagne') }}" method="POST"
                        enctype="multipart/form-data" id="form-edit-{{ $cid }}">
                        @csrf
                        <input type="hidden" name="campagne_id" value="{{ $cid }}">
                        <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">
                        <input type="hidden" name="old_image_couverture"
                            value="{{ $item['campagne']->image_couverture }}">
                        <input type="hidden" name="old_condition_participation"
                            value="{{ $item['campagne']->condition_participation }}">

                        {{-- Ligne 1 : Nom + Inscriptions --}}
                        <div class="row g-3 mb-4">
                            <div class="col-8">
                                <label class="vt-ns-label">Nom de la session</label>
                                <input type="text" class="vt-ns-input" name="name"
                                    value="{{ $item['campagne']->name }}" required>
                            </div>
                            <div class="col-4">
                                <label class="vt-ns-label">Inscriptions</label>
                                <select class="vt-ns-select"
                                    onchange="toggleBlocInscription('{{ $cid }}', this.value)">
                                    <option value="1"
                                        {{ $item['campagne']->inscription_isActive ? 'selected' : '' }}>
                                        Autorisées
                                    </option>
                                    <option value="0"
                                        {{ !$item['campagne']->inscription_isActive ? 'selected' : '' }}>
                                        Non-autorisées
                                    </option>
                                </select>
                                <input type="hidden" name="inscription_isActive"
                                    id="inscr-hidden-{{ $cid }}"
                                    value="{{ $item['campagne']->inscription_isActive ? '1' : '0' }}">
                            </div>
                        </div>

                        {{-- Bloc dates : id unique par campagne --}}
                        <div class="mb-4" id="bloc-dates-inscription-{{ $cid }}"
                            style="display: {{ $item['campagne']->inscription_isActive ? 'block' : 'none' }}; padding: 18px; background: #fdf6f0; border-radius: var(--vt-radius-sm); border: 1px solid var(--vt-orange-border);">
                            <span class="vt-ns-section-title">Les différentes dates d'inscriptions</span>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="vt-ns-label">Date Début</label>
                                    <input type="date" class="vt-ns-input" name="inscription_date_debut"
                                        value="{{ $item['campagne']->inscription_date_debut ?? '' }}">
                                </div>
                                <div class="col-6">
                                    <label class="vt-ns-label">Date Fin</label>
                                    <input type="date" class="vt-ns-input" name="inscription_date_fin"
                                        value="{{ $item['campagne']->inscription_date_fin ?? '' }}">
                                </div>
                                <div class="col-6">
                                    <label class="vt-ns-label">Heure Début</label>
                                    <input type="time" class="vt-ns-input" name="heure_debut_inscription"
                                        value="{{ $item['campagne']->heure_debut_inscription ?? '' }}">
                                </div>
                                <div class="col-6">
                                    <label class="vt-ns-label">Heure Fin</label>
                                    <input type="time" class="vt-ns-input" name="heure_fin_inscription"
                                        value="{{ $item['campagne']->heure_fin_inscription ?? '' }}">
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label class="vt-ns-label">Décrivez la session</label>
                            <textarea class="vt-ns-input" name="description" rows="4" required>{{ $item['campagne']->description }}</textarea>
                        </div>

                        {{-- Image de couverture --}}
                        <div class="mb-4 image-upload-group">
                            <label class="vt-ns-label">Image de couverture</label>
                            <div class="vt-ns-dropzone drop-zone-target"
                                style="{{ $item['campagne']->image_couverture ? 'border-color: var(--vt-orange);' : '' }}">
                                <div
                                    class="placeholder-target{{ $item['campagne']->image_couverture ? ' d-none' : '' }}">
                                    <span class="vt-ns-dropzone-text">
                                        Glissez une image ici · ou cliquez sur "Choisir"
                                    </span>
                                </div>
                                <img src="{{ $item['campagne']->image_couverture ? asset(env('IMAGES_PATH') . '/' . $item['campagne']->image_couverture) : '#' }}"
                                    alt="Aperçu" class="vt-ns-dropzone-preview preview-target"
                                    style="{{ $item['campagne']->image_couverture ? 'display:block;' : '' }}">
                                <button type="button" class="vt-ns-dropzone-btn">Choisir</button>
                                <input type="file" name="image_couverture" accept="image/*"
                                    onchange="handleNsImagePreview(this, 'form-edit-{{ $cid }}')">
                            </div>
                            <button type="button"
                                class="btn btn-sm btn-link text-danger text-decoration-none remove-btn-target p-0 mt-1{{ $item['campagne']->image_couverture ? '' : ' d-none' }}"
                                onclick="handleImageRemove(this)">
                                <i class="ti ti-trash me-1"></i> Supprimer l'image
                            </button>
                        </div>

                        {{-- OPTIONS --}}

                        {{-- Texte sur le cover --}}
                        <label class="vt-ns-option" for="textCover-{{ $cid }}">
                            <div class="vt-ns-option-text">
                                <p class="vt-ns-option-title">Texte sur le cover</p>
                                <p class="vt-ns-option-desc">Afficher un titre/infos au-dessus de l'image de
                                    couverture.</p>
                            </div>
                            <input type="checkbox" id="textCover-{{ $cid }}" name="text_cover_isActive"
                                value="1" {{ $item['campagne']->text_cover_isActive ? 'checked' : '' }}>
                        </label>

                        {{-- Identifiants personnalisés --}}
                        <label class="vt-ns-option" for="identifiants-{{ $cid }}">
                            <div class="vt-ns-option-text">
                                <p class="vt-ns-option-title">Identifiants candidats personnalisés</p>
                                <p class="vt-ns-option-desc">Permet d'imposer des numéros / codes (ex: 0001...)</p>
                            </div>
                            <input type="checkbox" id="identifiants-{{ $cid }}"
                                name="identifiants_personnalises_isActive" value="1"
                                {{ $item['campagne']->identifiants_personnalises_isActive ? 'checked' : '' }}>
                        </label>

                        {{-- Affichage des votes --}}
                        <div class="vt-ns-option" style="cursor: default;">
                            <div class="vt-ns-option-text">
                                <p class="vt-ns-option-title">Affichage des votes</p>
                                <p class="vt-ns-option-desc">Choix visible côté public (selon la session).</p>
                            </div>
                            <div class="vt-ns-radio-pills">
                                <input type="radio" name="afficher_montant_pourcentage"
                                    id="aff_clair_{{ $cid }}" value="clair"
                                    {{ $item['campagne']->afficher_montant_pourcentage == 'clair' ? 'checked' : '' }}>
                                <label for="aff_clair_{{ $cid }}">Clair</label>

                                <input type="radio" name="afficher_montant_pourcentage"
                                    id="aff_pct_{{ $cid }}" value="pourcentage"
                                    {{ $item['campagne']->afficher_montant_pourcentage == 'pourcentage' ? 'checked' : '' }}>
                                <label for="aff_pct_{{ $cid }}">Pourcentage</label>

                                <input type="radio" name="afficher_montant_pourcentage"
                                    id="aff_deux_{{ $cid }}" value="les_deux"
                                    {{ $item['campagne']->afficher_montant_pourcentage == 'les_deux' ? 'checked' : '' }}>
                                <label for="aff_deux_{{ $cid }}">Les deux</label>
                            </div>
                        </div>

                        {{-- Ordonner candidats --}}
                        <label class="vt-ns-option" for="ordonner-{{ $cid }}">
                            <div class="vt-ns-option-text">
                                <p class="vt-ns-option-title">Ordonner les candidats par votes décroissants</p>
                                <p class="vt-ns-option-desc">Recommandé pour afficher un classement.</p>
                            </div>
                            <input type="checkbox" id="ordonner-{{ $cid }}"
                                name="ordonner_candidats_votes_decroissants" value="1"
                                {{ $item['campagne']->ordonner_candidats_votes_decroissants ? 'checked' : '' }}>
                        </label>

                        {{-- Couleurs --}}
                        <div class="row g-3 mb-4 mt-1">
                            <div class="col-6">
                                <label class="vt-ns-label">Couleur primaire</label>
                                <div class="vt-ns-color-wrap">
                                    <input type="text" class="vt-ns-color-text" id="cp-text-{{ $cid }}"
                                        value="{{ $item['campagne']->color_primaire ?? '#01233f' }}" maxlength="7"
                                        oninput="syncColor('cp-text-{{ $cid }}','cp-swatch-{{ $cid }}','cp-display-{{ $cid }}')">
                                    <div class="vt-ns-color-display" id="cp-display-{{ $cid }}"
                                        style="background:{{ $item['campagne']->color_primaire ?? '#01233f' }};">
                                        <input type="color" class="vt-ns-color-swatch"
                                            id="cp-swatch-{{ $cid }}" name="color_primaire"
                                            value="{{ $item['campagne']->color_primaire ?? '#01233f' }}"
                                            oninput="syncColorFromSwatch('cp-swatch-{{ $cid }}','cp-text-{{ $cid }}','cp-display-{{ $cid }}')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="vt-ns-label">Couleur secondaire</label>
                                <div class="vt-ns-color-wrap">
                                    <input type="text" class="vt-ns-color-text" id="cs-text-{{ $cid }}"
                                        value="{{ $item['campagne']->color_secondaire ?? '#f17100' }}" maxlength="7"
                                        oninput="syncColor('cs-text-{{ $cid }}','cs-swatch-{{ $cid }}','cs-display-{{ $cid }}')">
                                    <div class="vt-ns-color-display" id="cs-display-{{ $cid }}"
                                        style="background:{{ $item['campagne']->color_secondaire ?? '#f17100' }};">
                                        <input type="color" class="vt-ns-color-swatch"
                                            id="cs-swatch-{{ $cid }}" name="color_secondaire"
                                            value="{{ $item['campagne']->color_secondaire ?? '#f17100' }}"
                                            oninput="syncColorFromSwatch('cs-swatch-{{ $cid }}','cs-text-{{ $cid }}','cs-display-{{ $cid }}')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Conditions de participation --}}
                        <div class="mb-4">
                            <label class="vt-ns-label">Conditions de participation (document)</label>
                            @if ($item['campagne']->condition_participation)
                                <div class="mb-2">
                                    <a href="{{ env('IMAGES_PATH') }}/{{ $item['campagne']->condition_participation }}"
                                        target="_blank"
                                        style="font-size:12.5px; color: var(--vt-orange); display:inline-flex; align-items:center; gap:5px;">
                                        <i class="ti ti-file-type-pdf" style="font-size:15px;"></i>
                                        Voir le document actuel
                                    </a>
                                </div>
                            @endif
                            <div class="vt-ns-dropzone" style="height: 52px;">
                                <span class="vt-ns-dropzone-text" id="pdf-label-{{ $cid }}">
                                    @if ($item['campagne']->condition_participation)
                                        Remplacer le document PDF
                                    @else
                                        Ajoutez un PDF — Conditions de vote / participation.&nbsp;
                                        <span style="color: var(--vt-text-muted); font-weight:600;">Aucun
                                            document</span>
                                    @endif
                                </span>
                                <button type="button" class="vt-ns-dropzone-btn"
                                    style="background: var(--vt-navy);">Insérer</button>
                                <input type="file" name="condition_participation" accept=".pdf"
                                    onchange="document.getElementById('pdf-label-{{ $cid }}').innerHTML = '📄 <strong>' + this.files[0].name + '</strong>'">
                            </div>
                        </div>

                    </form>
                </div>

                {{-- Footer sticky --}}
                <div class="vt-modal-ns-footer">
                    <button type="button" class="vt-ns-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" form="form-edit-{{ $cid }}" class="vt-ns-btn-submit">
                        <i class="ti ti-device-floppy" style="font-size:14px;"></i> Enregistrer
                    </button>
                </div>

            </div>
        </div>
    </div>
@endforeach

{{-- Modales suppression --}}
@foreach ($campagnes as $item)
    <div class="modal fade" id="delete_contact_{{ $item['campagne']->campagne_id }}" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle">
                            <i class="ti ti-trash fs-24"></i>
                        </span>
                    </div>
                    <h5 class="mb-1">Confirmer la suppression</h5>
                    <p class="mb-3">Êtes-vous sûr de vouloir supprimer cette session ?</p>
                    <form method="POST" action="{{ route('business.delete_campagne') }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="campagne_id" value="{{ $item['campagne']->campagne_id }}">
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-light w-100"
                                data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-danger w-100">Supprimer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Modale catégorie --}}
<div class="modal fade" id="modal_add_categorie" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.save_categorie') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom catégorie <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Choisir la campagne <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="campagne_id" required>
                                <option value="">Sélectionner une campagne</option>
                                @foreach ($campagnes as $item)
                                    <option value="{{ $item['campagne']->campagne_id }}">
                                        {{ $item['campagne']->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Décrivez la catégorie <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="4" name="description" required></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Choisir icone</label>
                            <select class="form-control form-select" name="icon">
                                <option value="">Sélectionner</option>
                                <option value="homme">Homme</option>
                                <option value="femme">Femme</option>
                                <option value="enfant">Enfant</option>
                                <option value="jeune">Jeune</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top mt-4 pb-0 px-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i>
                            Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
    {{-- Scripts modal nouvelle session --}}
    <script>
        /* Sync couleur : text → swatch + display */
        function syncColor(textId, swatchId, displayId) {
            const val = document.getElementById(textId).value;
            if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                document.getElementById(swatchId).value = val;
                document.getElementById(displayId).style.background = val;
            }
        }
        /* Sync couleur : swatch → text + display */
        function syncColorFromSwatch(swatchId, textId, displayId) {
            const val = document.getElementById(swatchId).value;
            document.getElementById(textId).value = val;
            document.getElementById(displayId).style.background = val;
        }
        /* Preview image drop zone */
        function handleNsImagePreview(input, formId) {
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const form = document.getElementById(formId);
                const preview = form.querySelector('.vt-ns-dropzone-preview');
                const placeholder = form.querySelector('.placeholder-target');
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sel = document.getElementById('inscriptions-select');
            const hidden = document.getElementById('inscription_isActive_hidden');
            const bloc = document.getElementById('bloc-dates-inscription');

            function toggleBlocDates(value) {
                if (value === '1') {
                    bloc.style.display = 'block';
                } else {
                    bloc.style.display = 'none';
                }
            }

            if (sel) {
                // Au changement
                sel.addEventListener('change', function() {
                    hidden.value = this.value;
                    toggleBlocDates(this.value);
                });

                // Au chargement de la page (utile en mode édition si la valeur est déjà définie)
                toggleBlocDates(sel.value);
            }
        });

        $(document).ready(function() {

            /* Recherche en temps réel */
            $('#searchSession').on('input', function() {
                var q = $(this).val().toLowerCase();
                var visible = 0;
                $('.session-row').each(function() {
                    var match = $(this).data('name').includes(q);
                    $(this).toggle(match);
                    if (match) visible++;
                });
                $('#table-count').text(visible + ' affichée(s)');
                $('#empty-row').toggle(visible === 0);
            });

            /* Toggle inscription dates */
            document.addEventListener('change', function(e) {
                if (!e.target.classList.contains('inscriptionSwitch')) return;
                const modalBody = e.target.closest('.modal-body');
                if (!modalBody) return;
                const bloc = modalBody.querySelector('.blocDates');
                if (bloc) bloc.classList.toggle('d-none', !e.target.checked);
            });

        });

        /**
         * Affiche/masque le bloc dates d'inscription selon la valeur du select
         * @param {string} cid   - Identifiant unique de la campagne
         * @param {string} value - Valeur sélectionnée ('1' ou '0')
         */
        function toggleBlocInscription(cid, value) {
            // Sync hidden input
            const hidden = document.getElementById('inscr-hidden-' + cid);
            if (hidden) hidden.value = value;

            // Affiche ou masque le bloc
            const bloc = document.getElementById('bloc-dates-inscription-' + cid);
            if (bloc) bloc.style.display = (value === '1') ? 'block' : 'none';
        }
    </script>
@endsection
