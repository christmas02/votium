@extends('refont.layout.console')

@section('title', 'Sessions')

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li>
        <a href="{{ route('console.espace') }}"><i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil</a>
    </li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li class="active">Sessions</li>
@endsection

{{-- ===== CSS ===== --}}
@section('extra-css')
    <style>
        /* ================================================================
           PAGE HEADER & TOOLBAR
           ================================================================ */
        .vt-lc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .vt-lc-title {
            font-size: 34px;
            font-weight: 800;
            color: var(--vt-text-main);
            margin: 0;
            letter-spacing: -.5px;
        }

        .vt-lc-toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            border-bottom: 1px solid var(--vt-border);
            flex-wrap: wrap;
        }

        .vt-lc-count {
            font-size: 13px;
            color: var(--vt-text-muted);
            font-weight: 500;
            flex: 1;
            min-width: 80px;
        }

        .vt-lc-count strong {
            color: var(--vt-orange);
            font-weight: 700;
        }

        .vt-lc-search-wrap {
            position: relative;
        }

        .vt-lc-search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
        }

        .vt-lc-search {
            padding: 8px 12px 8px 32px;
            width: 220px;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            font-size: 13px;
            color: var(--vt-text-main);
            background: #fafafa;
            transition: border-color .15s;
        }

        .vt-lc-search:focus {
            outline: none;
            border-color: var(--vt-orange);
            background: #fff;
        }

        .vt-lc-search::placeholder {
            color: #b0bec5;
        }

        /* ================================================================
           TABLE
           ================================================================ */
        .vt-lc-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .vt-lc-table thead th {
            padding: 11px 16px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .6px;
            text-transform: uppercase;
            color: var(--vt-text-muted);
            border-bottom: 1px solid var(--vt-border);
            white-space: nowrap;
        }

        .vt-lc-table tbody td {
            padding: 13px 16px;
            border-bottom: 1px solid var(--vt-border);
            color: var(--vt-text-main);
            vertical-align: middle;
        }

        .vt-lc-table tbody tr:last-child td {
            border-bottom: none;
        }

        .vt-lc-table tbody tr:hover td {
            background: #fafbfc;
        }

        /* Cellule session */
        .vt-lc-sess-name {
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
        }

        /* Badges */
        .vt-lc-badge-actif {
            background: var(--vt-green-light);
            color: var(--vt-green);
            font-size: 10.5px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .vt-lc-badge-inactif {
            background: #f1f5f9;
            color: var(--vt-text-muted);
            font-size: 10.5px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 50px;
        }

        /* Boutons action */
        .vt-lc-actions {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .vt-lc-btn {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1px solid var(--vt-border);
            background: #fff;
            color: var(--vt-text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }

        .vt-lc-btn.view:hover {
            border-color: #93c5fd;
            color: #2563eb;
            background: #eff6ff;
        }

        .vt-lc-btn.edit:hover {
            border-color: #fcd34d;
            color: #d97706;
            background: #fffbeb;
        }

        .vt-lc-btn.del:hover {
            border-color: #fca5a5;
            color: #dc2626;
            background: #fff5f5;
        }

        /* Empty */
        .vt-lc-empty {
            padding: 32px 16px;
            text-align: center;
            color: var(--vt-text-muted);
            font-size: 13px;
        }

        /* ================================================================
           MODAUX — BASE COMMUNE
           ================================================================ */
        #modal_add_campaign .modal-content,
        .vt-edit-campaign .modal-content,
        .vt-delete-modal .modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .18);
        }

        /* Header gradient */
        .vt-mhg {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 22px 24px 18px;
            background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);
            border-bottom: 1px solid #f0e6d8;
        }

        .vt-mhg-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            background: var(--vt-orange-light);
            border: 1.5px solid var(--vt-orange-border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--vt-orange);
            font-size: 18px;
        }

        .vt-mhg-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--vt-text-main);
            margin: 0;
            flex: 1;
        }

        .vt-mhg-close {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1.5px solid var(--vt-border);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--vt-text-muted);
            font-size: 13px;
            cursor: pointer;
            transition: all .15s;
            flex-shrink: 0;
        }

        .vt-mhg-close:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
        }

        /* Body + section */
        .modal-body,
        .vt-mbody {
            max-height: 65vh;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .vt-mbody {
            padding: 20px 24px 4px;
        }

        .vt-msect {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0 14px;
        }

        .vt-msect::before,
        .vt-msect::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--vt-border);
        }

        .vt-msect span {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: var(--vt-text-muted);
            white-space: nowrap;
        }

        /* Champ */
        .vt-mf {
            margin-bottom: 12px;
        }

        .vt-mf-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--vt-text-muted);
            margin-bottom: 5px;
            display: block;
        }

        .vt-mf-wrap {
            position: relative;
        }

        .vt-mf-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
            z-index: 1;
        }

        .vt-mf-input {
            width: 100%;
            padding: 9px 12px 9px 34px;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            font-size: 13px;
            color: var(--vt-text-main);
            background: #fafafa;
            transition: border-color .15s, background .15s;
        }

        .vt-mf-input:focus {
            outline: none;
            border-color: var(--vt-orange);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, .07);
        }

        .vt-mf-input::placeholder {
            color: #b0bec5;
        }

        textarea.vt-mf-input {
            padding-top: 9px;
            resize: vertical;
            min-height: 80px;
        }

        input[type="file"].vt-mf-input {
            cursor: pointer;
        }

        .vt-mf-select {
            width: 100%;
            padding: 9px 34px 9px 34px;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            font-size: 13px;
            color: var(--vt-text-main);
            background: #fafafa;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 15px;
            appearance: none;
            cursor: pointer;
            transition: border-color .15s;
        }

        .vt-mf-select:focus {
            outline: none;
            border-color: var(--vt-orange);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, .07);
        }

        .vt-mf-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        @media (max-width: 500px) {
            .vt-mf-row {
                grid-template-columns: 1fr;
            }
        }

        /* Toggle row */
        .vt-toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 14px;
            border-radius: var(--vt-radius-sm);
            background: #f8fafc;
            border: 1px solid var(--vt-border);
            margin-bottom: 8px;
        }

        .vt-toggle-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--vt-text-main);
        }

        /* Zone couverture */
        .vt-nc-cover-zone {
            position: relative;
            width: 100%;
            height: 160px;
            border: 2px dashed var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: border-color .15s;
            cursor: pointer;
        }

        .vt-nc-cover-zone:hover {
            border-color: var(--vt-orange);
        }

        .vt-nc-cover-placeholder {
            text-align: center;
            pointer-events: none;
        }

        .vt-nc-cover-placeholder i {
            font-size: 30px;
            color: #cbd5e1;
        }

        .vt-nc-cover-placeholder p {
            font-size: 11.5px;
            color: var(--vt-text-muted);
            margin: 6px 0 0;
        }

        .vt-nc-cover-preview {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .vt-nc-cover-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .vt-nc-cover-del {
            display: none;
            margin-top: 6px;
            font-size: 11.5px;
            color: #dc2626;
            font-weight: 600;
            background: none;
            border: none;
            cursor: pointer;
            align-items: center;
            gap: 4px;
        }

        .vt-nc-cover-del.visible {
            display: inline-flex;
        }

        /* Radio pills */
        .vt-radio-pills {
            display: flex;
        }

        .vt-radio-pills input[type="radio"] {
            display: none;
        }

        .vt-radio-pills label {
            flex: 1;
            text-align: center;
            padding: 8px 0;
            font-size: 12.5px;
            font-weight: 600;
            border: 1.5px solid var(--vt-border);
            color: var(--vt-text-muted);
            cursor: pointer;
            transition: all .15s;
            background: #fafafa;
        }

        .vt-radio-pills label:first-of-type {
            border-radius: var(--vt-radius-sm) 0 0 var(--vt-radius-sm);
        }

        .vt-radio-pills label:last-of-type {
            border-radius: 0 var(--vt-radius-sm) var(--vt-radius-sm) 0;
        }

        .vt-radio-pills input[type="radio"]:checked+label {
            background: var(--vt-orange-light);
            border-color: var(--vt-orange);
            color: var(--vt-orange);
        }

        /* Couleurs */
        .vt-color-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .vt-color-text {
            flex: 1;
            padding: 8px 10px;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            font-size: 12.5px;
            font-family: monospace;
            color: var(--vt-text-main);
            background: #fafafa;
        }

        .vt-color-text:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        .vt-color-swatch {
            width: 34px;
            height: 34px;
            border-radius: 7px;
            cursor: pointer;
            border: 1.5px solid var(--vt-border);
            padding: 2px;
            flex-shrink: 0;
        }

        /* Bloc dates inscriptions */
        .vt-insc-bloc {
            padding: 12px 14px;
            background: #f8fafc;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            margin-bottom: 8px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        /* Footer modal */
        .vt-mfooter {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 24px 20px;
            border-top: 1px solid var(--vt-border);
            margin-top: 8px;
            position: sticky;
            bottom: 0;
            background: #fff;
            z-index: 10;
        }

        .vt-mfooter-cancel {
            padding: 9px 22px;
            border-radius: var(--vt-radius-sm);
            border: 1.5px solid var(--vt-border);
            background: #fff;
            color: var(--vt-text-main);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .vt-mfooter-cancel:hover {
            border-color: #94a3b8;
            background: #f8fafc;
        }

        .vt-mfooter-submit {
            padding: 9px 22px;
            border-radius: var(--vt-radius-sm);
            background: var(--vt-orange);
            border: none;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background .15s;
        }

        .vt-mfooter-submit:hover {
            background: #c2560a;
        }

        .vt-mfooter-danger {
            padding: 9px 22px;
            border-radius: var(--vt-radius-sm);
            background: #dc2626;
            border: none;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: background .15s;
        }

        .vt-mfooter-danger:hover {
            background: #b91c1c;
        }

        /* Modal suppression */
        .vt-del-body {
            padding: 28px 24px 8px;
            text-align: center;
        }

        .vt-del-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #fff5f5;
            border: 1.5px solid #fca5a5;
            color: #dc2626;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .vt-del-title {
            font-size: 17px;
            font-weight: 700;
            margin: 0 0 8px;
            color: var(--vt-text-main);
        }

        .vt-del-desc {
            font-size: 13px;
            color: var(--vt-text-muted);
            margin: 0 0 4px;
        }

        .vt-del-footer {
            display: flex;
            gap: 10px;
            padding: 0 24px 24px;
        }

        .vt-del-footer .vt-mfooter-cancel {
            flex: 1;
            text-align: center;
            justify-content: center;
            display: flex;
        }
    </style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    <div class="vt-lc-header">
        <h1 class="vt-lc-title">Sessions</h1>
    </div>

    <div class="col-sm-12">@include('layout.status')</div>

    <div class="vt-card" style="overflow:hidden;">

        {{-- Toolbar --}}
        <div class="vt-lc-toolbar">
            <span class="vt-lc-count"><strong>{{ count($campagnes) }}</strong> session(s)</span>
            <div class="vt-lc-search-wrap">
                <i class="ti ti-search vt-lc-search-icon"></i>
                <input type="text" class="vt-lc-search" id="lc-search" placeholder="Rechercher...">
            </div>
            <button class="vt-btn-primary" style="border-radius:var(--vt-radius-sm); padding:8px 18px; font-size:13px;"
                data-bs-toggle="modal" data-bs-target="#modal_add_campaign">
                <i class="ti ti-plus" style="font-size:13px;"></i> Créer une session
            </button>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table class="vt-lc-table">
                <thead>
                    <tr>
                        <th>Session</th>
                        <th>Promoteur</th>
                        {{-- <th>Nbre d'étapes</th>
                        <th>Nbre de candidats</th> --}}
                        <th>Créée le</th>
                        <th>Inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="lc-tbody">
                    @forelse ($campagnes as $campagne)
                        <tr class="lc-row"
                            data-search="{{ strtolower($campagne->name . ' ' . ($customers[$campagne->customer_id] ?? '')) }}">
                            <td><span class="vt-lc-sess-name">{{ $campagne->name }}</span></td>
                            <td style="font-size:12.5px; font-weight:600;">{{ $customers[$campagne->customer_id] ?? '—' }}
                            </td>
                            {{-- <td style="color:var(--vt-text-muted); font-size:12px;">1 étape</td>
                            <td style="color:var(--vt-text-muted); font-size:12px;">1 candidat(s)</td> --}}
                            <td style="font-size:12px; color:var(--vt-text-muted);">
                                {{ $campagne->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if ($campagne->inscription_isActive)
                                    <span class="vt-lc-badge-actif"><i class="ti ti-check" style="font-size:10px;"></i>
                                        Autorisées</span>
                                @else
                                    <span class="vt-lc-badge-inactif">Non autorisées</span>
                                @endif
                            </td>
                            <td>
                                <div class="vt-lc-actions">
                                    <a href="{{ route('business.site_campagne', [$campagne->campagne_id]) }}" target="_blank"
                                        class="vt-lc-btn view" title="Voir le site">
                                        <i class="ti ti-location"></i>
                                    </a>
                                    <button type="button" class="vt-lc-btn edit" title="Modifier" data-bs-toggle="modal"
                                        data-bs-target="#modal_edit_campaign_{{ $campagne->campagne_id }}">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <button type="button" class="vt-lc-btn del" title="Supprimer" data-bs-toggle="modal"
                                        data-bs-target="#delete_contact_{{ $campagne->campagne_id }}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="vt-lc-empty">Aucune session enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection

{{-- =====================================================
     MODALS
     ===================================================== --}}
@section('modals')

    <div class="modal fade" id="modal_add_campaign" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="vt-mhg">
                    <div class="vt-mhg-icon"><i class="ti ti-calendar-plus"></i></div>
                    <h5 class="vt-mhg-title">Nouvelle session</h5>
                    <button type="button" class="vt-mhg-close" data-bs-dismiss="modal"><i class="ti ti-x"></i></button>
                </div>

                <form class="ajax-form" action="{{ route('console.save_campagne') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="vt-mbody">

                        {{-- INFORMATIONS --}}
                        <div class="vt-msect"><span>Informations</span></div>

                        <div class="vt-mf">
                            <label class="vt-mf-label">Nom de la session <span style="color:#ef4444;">*</span></label>
                            <div class="vt-mf-wrap">
                                <i class="ti ti-forms vt-mf-icon"></i>
                                <input type="text" class="vt-mf-input" name="name"
                                    placeholder="Ex: Élection Miss 2024" required>
                            </div>
                        </div>

                        <div class="vt-mf">
                            <label class="vt-mf-label">Promoteur <span style="color:#ef4444;">*</span></label>
                            <div class="vt-mf-wrap">
                                <i class="ti ti-building vt-mf-icon"></i>
                                <select class="vt-mf-select" name="customer_id" required>
                                    <option value="" disabled selected>Choisir un promoteur</option>
                                    @foreach ($customers as $customerId => $entreprise)
                                        <option value="{{ $customerId }}">{{ $entreprise }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="vt-mf">
                            <label class="vt-mf-label">Description <span style="color:#ef4444;">*</span></label>
                            <div class="vt-mf-wrap">
                                <i class="ti ti-align-left vt-mf-icon" style="top:14px; transform:none;"></i>
                                <textarea class="vt-mf-input" name="description" rows="3" required></textarea>
                            </div>
                        </div>

                        {{-- COUVERTURE --}}
                        <div class="vt-msect"><span>Image de couverture</span></div>

                        <div class="vt-nc-cover-zone" id="add-cover-zone">
                            <div class="vt-nc-cover-placeholder">
                                <i class="ti ti-cloud-upload"></i>
                                <p>Glissez ou cliquez pour choisir une image<br>
                                    <span style="font-size:10.5px;">1920×1080 · JPG, PNG · max 2 Mo</span>
                                </p>
                            </div>
                            <img class="vt-nc-cover-preview" id="add-cover-preview" src="#" alt="">
                            <input type="file" class="vt-nc-cover-input" name="image_couverture" accept="image/*"
                                onchange="handleNcCover(this,'add-cover-zone','add-cover-preview','add-cover-del')">
                        </div>
                        <button type="button" class="vt-nc-cover-del" id="add-cover-del"
                            onclick="handleNcCoverRemove('add-cover-zone','add-cover-preview','add-cover-del')">
                            <i class="ti ti-trash" style="font-size:11px;"></i> Supprimer l'image
                        </button>

                        {{-- OPTIONS --}}
                        <div class="vt-msect"><span>Options</span></div>

                        <div class="vt-toggle-row">
                            <span class="vt-toggle-label">Texte sur le cover</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    name="text_cover_isActive" value="1">
                            </div>
                        </div>

                        <div class="vt-toggle-row">
                            <span class="vt-toggle-label">Identifiants candidats personnalisés</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    name="identifiants_personnalises_isActive" value="1">
                            </div>
                        </div>

                        <div class="vt-toggle-row">
                            <span class="vt-toggle-label">Autoriser les inscriptions</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input inscriptionSwitch" type="checkbox" role="switch"
                                    name="inscription_isActive" value="1">
                            </div>
                        </div>

                        <div class="vt-insc-bloc blocDates d-none">
                            <div class="vt-mf" style="margin:0;">
                                <label class="vt-mf-label">Date début</label>
                                <input type="date" class="vt-mf-input" style="padding-left:12px;"
                                    name="inscription_date_debut">
                            </div>
                            <div class="vt-mf" style="margin:0;">
                                <label class="vt-mf-label">Date fin</label>
                                <input type="date" class="vt-mf-input" style="padding-left:12px;"
                                    name="inscription_date_fin">
                            </div>
                            <div class="vt-mf" style="margin:0;">
                                <label class="vt-mf-label">Heure début</label>
                                <input type="time" class="vt-mf-input" style="padding-left:12px;"
                                    name="heure_debut_inscription">
                            </div>
                            <div class="vt-mf" style="margin:0;">
                                <label class="vt-mf-label">Heure fin</label>
                                <input type="time" class="vt-mf-input" style="padding-left:12px;"
                                    name="heure_fin_inscription">
                            </div>
                        </div>

                        <div class="vt-toggle-row">
                            <span class="vt-toggle-label">Ordonner les candidats par votes décroissants</span>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    name="ordonner_candidats_votes_decroissants" value="1">
                            </div>
                        </div>

                        {{-- APPARENCE --}}
                        <div class="vt-msect"><span>Apparence</span></div>

                        <div class="vt-mf">
                            <label class="vt-mf-label">Afficher les montants</label>
                            <div class="vt-radio-pills">
                                <input type="radio" name="afficher_montant_pourcentage" id="add_opt_clair"
                                    value="clair" checked>
                                <label for="add_opt_clair">Clair</label>
                                <input type="radio" name="afficher_montant_pourcentage" id="add_opt_pct"
                                    value="pourcentage">
                                <label for="add_opt_pct">Pourcentage</label>
                                <input type="radio" name="afficher_montant_pourcentage" id="add_opt_deux"
                                    value="les_deux">
                                <label for="add_opt_deux">Les deux</label>
                            </div>
                        </div>

                        <div class="vt-mf-row">
                            <div class="vt-mf">
                                <label class="vt-mf-label">Couleur primaire</label>
                                <div class="vt-color-wrap">
                                    <input type="text" class="vt-color-text" id="add_cprim_txt" value="#000000"
                                        maxlength="7" oninput="syncColorSwatch(this,'add_cprim_sw')">
                                    <input type="color" class="vt-color-swatch" id="add_cprim_sw"
                                        name="color_primaire" value="#000000"
                                        oninput="syncColorText(this,'add_cprim_txt')">
                                </div>
                            </div>
                            <div class="vt-mf">
                                <label class="vt-mf-label">Couleur secondaire</label>
                                <div class="vt-color-wrap">
                                    <input type="text" class="vt-color-text" id="add_csec_txt" value="#000000"
                                        maxlength="7" oninput="syncColorSwatch(this,'add_csec_sw')">
                                    <input type="color" class="vt-color-swatch" id="add_csec_sw"
                                        name="color_secondaire" value="#000000"
                                        oninput="syncColorText(this,'add_csec_txt')">
                                </div>
                            </div>
                        </div>

                        {{-- DOCUMENT --}}
                        <div class="vt-msect"><span>Document</span></div>

                        <div class="vt-mf">
                            <label class="vt-mf-label">Condition de participation (PDF)</label>
                            <div class="vt-mf-wrap">
                                <i class="ti ti-file-text vt-mf-icon"></i>
                                <input type="file" class="vt-mf-input" name="condition_participation" accept=".pdf">
                            </div>
                        </div>

                    </div>

                    <div class="vt-mfooter">
                        <button type="button" class="vt-mfooter-cancel" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="vt-mfooter-submit">
                            <i class="ti ti-check" style="font-size:13px;"></i> Créer la session
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- =====================================================
     MODALS — MODIFIER UNE SESSION
     ===================================================== --}}
    @foreach ($campagnes as $campagne)
        <div class="modal fade vt-edit-campaign" id="modal_edit_campaign_{{ $campagne->campagne_id }}" tabindex="-1"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="vt-mhg">
                        <div class="vt-mhg-icon"><i class="ti ti-edit"></i></div>
                        <h5 class="vt-mhg-title">{{ $campagne->name }}</h5>
                        <button type="button" class="vt-mhg-close" data-bs-dismiss="modal"><i
                                class="ti ti-x"></i></button>
                    </div>

                    <form class="ajax-form" action="{{ route('console.update_campagne') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="campagne_id" value="{{ $campagne->campagne_id }}">
                        <input type="hidden" name="old_image_couverture" value="{{ $campagne->image_couverture }}">
                        <input type="hidden" name="old_condition_participation"
                            value="{{ $campagne->condition_participation }}">

                        <div class="vt-mbody">

                            {{-- INFORMATIONS --}}
                            <div class="vt-msect"><span>Informations</span></div>

                            <div class="vt-mf">
                                <label class="vt-mf-label">Nom de la session <span style="color:#ef4444;">*</span></label>
                                <div class="vt-mf-wrap">
                                    <i class="ti ti-forms vt-mf-icon"></i>
                                    <input type="text" class="vt-mf-input" name="name"
                                        value="{{ $campagne->name }}" required>
                                </div>
                            </div>

                            <div class="vt-mf">
                                <label class="vt-mf-label">Promoteur <span style="color:#ef4444;">*</span></label>
                                <div class="vt-mf-wrap">
                                    <i class="ti ti-building vt-mf-icon"></i>
                                    <select class="vt-mf-select" name="customer_id" required>
                                        @foreach ($customers as $customerId => $entreprise)
                                            <option value="{{ $customerId }}"
                                                {{ $campagne->customer_id == $customerId ? 'selected' : '' }}>
                                                {{ $entreprise }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="vt-mf">
                                <label class="vt-mf-label">Description <span style="color:#ef4444;">*</span></label>
                                <div class="vt-mf-wrap">
                                    <i class="ti ti-align-left vt-mf-icon" style="top:14px; transform:none;"></i>
                                    <textarea class="vt-mf-input" name="description" rows="3" required>{{ $campagne->description }}</textarea>
                                </div>
                            </div>

                            {{-- COUVERTURE --}}
                            <div class="vt-msect"><span>Image de couverture</span></div>

                            <div class="vt-nc-cover-zone" id="edit-cover-zone-{{ $campagne->campagne_id }}"
                                style="{{ $campagne->image_couverture ? 'border-style:solid; border-color:var(--vt-orange);' : '' }}">
                                <div class="vt-nc-cover-placeholder {{ $campagne->image_couverture ? 'd-none' : '' }}">
                                    <i class="ti ti-cloud-upload"></i>
                                    <p>Glissez ou cliquez pour choisir une image<br>
                                        <span style="font-size:10.5px;">1920×1080 · JPG, PNG · max 2 Mo</span>
                                    </p>
                                </div>
                                <img class="vt-nc-cover-preview" id="edit-cover-preview-{{ $campagne->campagne_id }}"
                                    src="{{ $campagne->image_couverture ? env('IMAGES_PATH') . '/' . $campagne->image_couverture : '#' }}"
                                    alt="" style="{{ $campagne->image_couverture ? 'display:block;' : '' }}">
                                <input type="file" class="vt-nc-cover-input" name="image_couverture" accept="image/*"
                                    onchange="handleNcCover(this,'edit-cover-zone-{{ $campagne->campagne_id }}','edit-cover-preview-{{ $campagne->campagne_id }}','edit-cover-del-{{ $campagne->campagne_id }}')">
                            </div>
                            <button type="button"
                                class="vt-nc-cover-del {{ $campagne->image_couverture ? 'visible' : '' }}"
                                id="edit-cover-del-{{ $campagne->campagne_id }}"
                                onclick="handleNcCoverRemove('edit-cover-zone-{{ $campagne->campagne_id }}','edit-cover-preview-{{ $campagne->campagne_id }}','edit-cover-del-{{ $campagne->campagne_id }}')">
                                <i class="ti ti-trash" style="font-size:11px;"></i> Supprimer l'image
                            </button>

                            {{-- OPTIONS --}}
                            <div class="vt-msect"><span>Options</span></div>

                            <div class="vt-toggle-row">
                                <span class="vt-toggle-label">Texte sur le cover</span>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        name="text_cover_isActive" value="1"
                                        {{ $campagne->text_cover_isActive ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="vt-toggle-row">
                                <span class="vt-toggle-label">Identifiants candidats personnalisés</span>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        name="identifiants_personnalises_isActive" value="1"
                                        {{ $campagne->identifiants_personnalises_isActive ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="vt-toggle-row">
                                <span class="vt-toggle-label">Autoriser les inscriptions</span>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input inscriptionSwitch" type="checkbox" role="switch"
                                        name="inscription_isActive" value="1"
                                        {{ $campagne->inscription_isActive ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="vt-insc-bloc blocDates {{ $campagne->inscription_isActive ? '' : 'd-none' }}">
                                <div class="vt-mf" style="margin:0;">
                                    <label class="vt-mf-label">Date début</label>
                                    <input type="date" class="vt-mf-input" style="padding-left:12px;"
                                        name="inscription_date_debut" value="{{ $campagne->inscription_date_debut }}">
                                </div>
                                <div class="vt-mf" style="margin:0;">
                                    <label class="vt-mf-label">Date fin</label>
                                    <input type="date" class="vt-mf-input" style="padding-left:12px;"
                                        name="inscription_date_fin" value="{{ $campagne->inscription_date_fin }}">
                                </div>
                                <div class="vt-mf" style="margin:0;">
                                    <label class="vt-mf-label">Heure début</label>
                                    <input type="time" class="vt-mf-input" style="padding-left:12px;"
                                        name="heure_debut_inscription" value="{{ $campagne->heure_debut_inscription }}">
                                </div>
                                <div class="vt-mf" style="margin:0;">
                                    <label class="vt-mf-label">Heure fin</label>
                                    <input type="time" class="vt-mf-input" style="padding-left:12px;"
                                        name="heure_fin_inscription" value="{{ $campagne->heure_fin_inscription }}">
                                </div>
                            </div>

                            <div class="vt-toggle-row">
                                <span class="vt-toggle-label">Ordonner les candidats par votes décroissants</span>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        name="ordonner_candidats_votes_decroissants" value="1"
                                        {{ $campagne->ordonner_candidats_votes_decroissants ? 'checked' : '' }}>
                                </div>
                            </div>

                            {{-- APPARENCE --}}
                            <div class="vt-msect"><span>Apparence</span></div>

                            <div class="vt-mf">
                                <label class="vt-mf-label">Afficher les montants</label>
                                <div class="vt-radio-pills">
                                    <input type="radio" name="afficher_montant_pourcentage"
                                        id="edit_clair_{{ $campagne->campagne_id }}" value="clair"
                                        {{ $campagne->afficher_montant_pourcentage == 'clair' ? 'checked' : '' }}>
                                    <label for="edit_clair_{{ $campagne->campagne_id }}">Clair</label>
                                    <input type="radio" name="afficher_montant_pourcentage"
                                        id="edit_pct_{{ $campagne->campagne_id }}" value="pourcentage"
                                        {{ $campagne->afficher_montant_pourcentage == 'pourcentage' ? 'checked' : '' }}>
                                    <label for="edit_pct_{{ $campagne->campagne_id }}">Pourcentage</label>
                                    <input type="radio" name="afficher_montant_pourcentage"
                                        id="edit_deux_{{ $campagne->campagne_id }}" value="les_deux"
                                        {{ $campagne->afficher_montant_pourcentage == 'les_deux' ? 'checked' : '' }}>
                                    <label for="edit_deux_{{ $campagne->campagne_id }}">Les deux</label>
                                </div>
                            </div>

                            <div class="vt-mf-row">
                                <div class="vt-mf">
                                    <label class="vt-mf-label">Couleur primaire</label>
                                    <div class="vt-color-wrap">
                                        <input type="text" class="vt-color-text"
                                            id="edit_cprim_txt_{{ $campagne->campagne_id }}"
                                            value="{{ $campagne->color_primaire }}" maxlength="7"
                                            oninput="syncColorSwatch(this,'edit_cprim_sw_{{ $campagne->campagne_id }}')">
                                        <input type="color" class="vt-color-swatch"
                                            id="edit_cprim_sw_{{ $campagne->campagne_id }}" name="color_primaire"
                                            value="{{ $campagne->color_primaire }}"
                                            oninput="syncColorText(this,'edit_cprim_txt_{{ $campagne->campagne_id }}')">
                                    </div>
                                </div>
                                <div class="vt-mf">
                                    <label class="vt-mf-label">Couleur secondaire</label>
                                    <div class="vt-color-wrap">
                                        <input type="text" class="vt-color-text"
                                            id="edit_csec_txt_{{ $campagne->campagne_id }}"
                                            value="{{ $campagne->color_secondaire }}" maxlength="7"
                                            oninput="syncColorSwatch(this,'edit_csec_sw_{{ $campagne->campagne_id }}')">
                                        <input type="color" class="vt-color-swatch"
                                            id="edit_csec_sw_{{ $campagne->campagne_id }}" name="color_secondaire"
                                            value="{{ $campagne->color_secondaire }}"
                                            oninput="syncColorText(this,'edit_csec_txt_{{ $campagne->campagne_id }}')">
                                    </div>
                                </div>
                            </div>

                            {{-- DOCUMENT --}}
                            <div class="vt-msect"><span>Document</span></div>

                            @if ($campagne->condition_participation)
                                <div style="margin-bottom: 8px;">
                                    <a href="{{ env('IMAGES_PATH') }}/{{ $campagne->condition_participation }}"
                                        target="_blank"
                                        style="font-size:12.5px; color:var(--vt-orange); font-weight:600; text-decoration:none;">
                                        <i class="ti ti-file-text" style="font-size:13px;"></i> Voir le document actuel
                                    </a>
                                </div>
                            @endif

                            <div class="vt-mf">
                                <label class="vt-mf-label">Remplacer le document (PDF)</label>
                                <div class="vt-mf-wrap">
                                    <i class="ti ti-file-text vt-mf-icon"></i>
                                    <input type="file" class="vt-mf-input" name="condition_participation"
                                        accept=".pdf">
                                </div>
                            </div>

                        </div>

                        <div class="vt-mfooter">
                            <button type="button" class="vt-mfooter-cancel" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="vt-mfooter-submit">
                                <i class="ti ti-device-floppy" style="font-size:13px;"></i> Enregistrer
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- =====================================================
     MODALS — SUPPRIMER UNE SESSION
     ===================================================== --}}
    @foreach ($campagnes as $campagne)
        <div class="modal fade vt-delete-modal" id="delete_contact_{{ $campagne->campagne_id }}"
            data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="vt-del-body">
                        <div class="vt-del-icon"><i class="ti ti-trash"></i></div>
                        <h5 class="vt-del-title">Supprimer la session</h5>
                        <p class="vt-del-desc">
                            Confirmer la suppression de <strong>{{ $campagne->name }}</strong> ?<br>
                            <span style="font-size:11.5px;">Cette action est irréversible.</span>
                        </p>
                    </div>
                    <form method="POST" action="{{ route('console.delete_campagne') }}">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="campagne_id" value="{{ $campagne->campagne_id }}">
                        <div class="vt-del-footer">
                            <button type="button" class="vt-mfooter-cancel" data-bs-dismiss="modal"
                                style="flex:1;justify-content:center;display:flex;">Annuler</button>
                            <button type="submit" class="vt-mfooter-danger">
                                <i class="ti ti-trash" style="font-size:13px;"></i> Supprimer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
    <script>
        /* -------------------------------------------------------
       Recherche client-side
       ------------------------------------------------------- */
        document.getElementById('lc-search').addEventListener('input', function() {
            var q = this.value.toLowerCase();
            document.querySelectorAll('.lc-row').forEach(function(row) {
                row.style.display = row.dataset.search.includes(q) ? '' : 'none';
            });
        });

        /* -------------------------------------------------------
           Toggle inscription dates
           ------------------------------------------------------- */
        document.addEventListener('change', function(e) {
            if (!e.target.classList.contains('inscriptionSwitch')) return;
            var parent = e.target.closest('.vt-mbody');
            if (!parent) return;
            var bloc = parent.querySelector('.blocDates');
            if (bloc) bloc.classList.toggle('d-none', !e.target.checked);
        });

        /* -------------------------------------------------------
           Couverture — preview
           ------------------------------------------------------- */
        function handleNcCover(input, zoneId, previewId, delId) {
            var file = input.files[0];
            if (!file) return;
            var zone = document.getElementById(zoneId);
            var preview = document.getElementById(previewId);
            var del = document.getElementById(delId);
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                var ph = zone.querySelector('.vt-nc-cover-placeholder');
                if (ph) ph.style.display = 'none';
                zone.style.borderStyle = 'solid';
                zone.style.borderColor = 'var(--vt-orange)';
                if (del) del.classList.add('visible');
            };
            reader.readAsDataURL(file);
        }

        function handleNcCoverRemove(zoneId, previewId, delId) {
            var zone = document.getElementById(zoneId);
            var preview = document.getElementById(previewId);
            var del = document.getElementById(delId);
            preview.src = '#';
            preview.style.display = 'none';
            zone.style.borderStyle = 'dashed';
            zone.style.borderColor = '';
            var ph = zone.querySelector('.vt-nc-cover-placeholder');
            if (ph) ph.style.display = '';
            if (del) del.classList.remove('visible');
            var inp = zone.querySelector('input[type="file"]');
            if (inp) inp.value = '';
        }

        /* -------------------------------------------------------
           Couleurs — sync swatch ↔ texte
           ------------------------------------------------------- */
        function syncColorSwatch(textEl, swatchId) {
            var v = textEl.value;
            if (/^#[0-9a-fA-F]{6}$/.test(v)) {
                document.getElementById(swatchId).value = v;
            }
        }

        function syncColorText(swatchEl, textId) {
            document.getElementById(textId).value = swatchEl.value;
        }
    </script>
@endsection
