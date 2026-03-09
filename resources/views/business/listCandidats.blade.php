@extends('refont.layout.app')

@section('title', 'Candidats')

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li><a href="{{ route('business.espace') }}"><i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil</a></li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li><a href="{{ route('business.list_campagne') }}">Sessions</a></li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li class="active">Candidats</li>
@endsection

{{-- ===== CSS SPÉCIFIQUE ===== --}}
@section('extra-css')
    <style>
        /* ---- En-tête de page ---- */
        .vt-page-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .vt-page-title-xl {
            font-size: 36px;
            font-weight: 800;
            color: var(--vt-text-main);
            margin: 0;
            letter-spacing: -.5px;
        }

        .vt-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Boutons header */
        .vt-btn-muted {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            padding: 8px 4px;
            transition: color .15s;
        }

        .vt-btn-muted:hover {
            color: var(--vt-text-main);
        }

        .vt-btn-outline-dark {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1.5px solid var(--vt-border);
            border-radius: 50px;
            padding: 8px 18px;
            background: #fff;
            color: var(--vt-text-main);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all .15s;
        }

        .vt-btn-outline-dark:hover {
            border-color: #94a3b8;
            color: var(--vt-text-main);
            background: #f8fafc;
        }

        /* ---- Layout deux colonnes candidats ---- */
        .vt-candidat-layout {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        /* ---- Colonne gauche (filtre + catégories) ---- */
        .vt-candidat-sidebar {
            width: 280px;
            flex-shrink: 0;
            background: var(--vt-card-bg);
            border-radius: var(--vt-radius);
            box-shadow: var(--vt-shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .vt-sidebar-section {
            padding: 18px 18px 0;
        }

        .vt-sidebar-section-title {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--vt-text-muted);
            margin-bottom: 14px;
        }

        .vt-sidebar-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--vt-text-muted);
            margin-bottom: 5px;
        }

        .vt-sidebar-select {
            width: 100%;
            padding: 9px 30px 9px 12px;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center / 15px;
            appearance: none;
            font-size: 13px;
            font-weight: 500;
            color: var(--vt-text-main);
            cursor: pointer;
            transition: border-color .15s;
            margin-bottom: 14px;
        }

        .vt-sidebar-select:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        .vt-sidebar-select:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        /* Séparateur */
        .vt-sidebar-divider {
            height: 1px;
            background: var(--vt-border);
            margin: 6px 0 14px;
        }

        /* ---- Section Catégories ---- */
        .vt-cat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 18px;
            margin-bottom: 4px;
        }

        .vt-cat-heading {
            font-size: 17px;
            font-weight: 700;
            color: var(--vt-text-main);
        }

        .vt-cat-subtitle {
            font-size: 11.5px;
            color: var(--vt-text-muted);
            padding: 0 18px;
            margin-bottom: 14px;
        }

        .vt-cat-add-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid var(--vt-border);
            background: #fff;
            color: var(--vt-text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            font-weight: 300;
            transition: all .15s;
            flex-shrink: 0;
        }

        .vt-cat-add-btn:hover {
            border-color: var(--vt-orange);
            color: var(--vt-orange);
            background: var(--vt-orange-light);
        }

        /* Liste catégories */
        .vt-cat-list {
            padding: 0 12px;
            flex: 1;
            overflow-y: auto;
            max-height: 340px;
        }

        .vt-cat-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 8px;
            border-radius: var(--vt-radius-sm);
            border: 1px solid var(--vt-border);
            margin-bottom: 8px;
            background: #fff;
            transition: box-shadow .15s;
        }

        .vt-cat-item:hover {
            box-shadow: var(--vt-shadow);
        }

        .vt-cat-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #fde8cc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 700;
            color: var(--vt-orange);
            flex-shrink: 0;
        }

        .vt-cat-info {
            flex: 1;
            min-width: 0;
        }

        .vt-cat-name {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--vt-text-main);
            text-transform: uppercase;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .vt-cat-count {
            font-size: 11px;
            color: var(--vt-text-muted);
            margin: 0;
        }

        .vt-cat-actions {
            display: flex;
            gap: 5px;
            flex-shrink: 0;
        }

        .vt-cat-btn {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: 1px solid var(--vt-border);
            background: #fff;
            color: var(--vt-text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }

        .vt-cat-btn:hover {
            border-color: #94a3b8;
            color: var(--vt-text-main);
        }

        .vt-cat-btn.danger:hover {
            border-color: #fca5a5;
            color: #dc2626;
            background: #fff5f5;
        }

        /* Bouton export sidebar */
        .vt-sidebar-export {
            margin: 12px 12px 12px;
            width: calc(100% - 24px);
            background: var(--vt-orange);
            color: #fff;
            border: none;
            border-radius: var(--vt-radius-sm);
            padding: 11px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: background .15s;
            text-decoration: none;
        }

        .vt-sidebar-export:hover {
            background: var(--vt-orange-hover);
            color: #fff;
        }

        /* ---- Colonne droite (contenu candidats) ---- */
        .vt-candidat-main {
            flex: 1;
            min-width: 0;
        }

        /* Barre de recherche */
        .vt-candidat-search-wrap {
            position: relative;
            margin-bottom: 16px;
        }

        .vt-candidat-search-wrap .vt-s-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
            pointer-events: none;
        }

        .vt-candidat-search {
            width: 100%;
            padding: 11px 16px 11px 44px;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius);
            background: #fff;
            font-size: 13.5px;
            box-shadow: var(--vt-shadow);
            transition: border-color .15s;
        }

        .vt-candidat-search::placeholder {
            color: #94a3b8;
        }

        .vt-candidat-search:focus {
            outline: none;
            border-color: #94a3b8;
        }

        /* Grille des candidats (reprise du JS existant) */
        .js-candidat-table-body {
            /* garde le nom pour le JS */
        }

        /* Bouton load more */
        .vt-load-more-wrap {
            text-align: center;
            padding: 20px 0;
            display: none;
        }

        .vt-load-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border: 1.5px solid var(--vt-border);
            border-radius: 50px;
            padding: 9px 22px;
            background: #fff;
            color: var(--vt-text-main);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
            text-decoration: none;
        }

        .vt-load-more-btn:hover {
            border-color: #94a3b8;
            box-shadow: var(--vt-shadow);
            color: var(--vt-text-main);
        }

        /* Empty state candidats */
        .vt-candidat-empty {
            background: #fff;
            border-radius: var(--vt-radius);
            padding: 40px 20px;
            text-align: center;
            color: var(--vt-text-muted);
            font-size: 13px;
            box-shadow: var(--vt-shadow);
        }

        /* =====================================================
                       CARTE CANDIDAT — design compact
                       ===================================================== */
        .vt-cand-card {
            background: #fff;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius);
            overflow: hidden;
            transition: box-shadow .15s, transform .15s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .vt-cand-card:hover {
            box-shadow: var(--vt-shadow-md);
            transform: translateY(-1px);
        }

        /* Bandeau photo */
        .vt-cand-photo-wrap {
            position: relative;
            height: 250px;
            background: linear-gradient(135deg, #f0f2f5 0%, #e2e8f0 100%);
            overflow: hidden;
            flex-shrink: 0;
        }

        .vt-cand-photo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            display: block;
        }

        .vt-cand-photo-wrap .vt-cand-num {
            position: absolute;
            top: 8px;
            left: 8px;
            background: rgba(0, 0, 0, .45);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 50px;
            letter-spacing: .3px;
        }

        .vt-cand-photo-wrap .vt-cand-menu {
            position: absolute;
            top: 6px;
            right: 6px;
        }

        .vt-cand-menu-btn {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .85);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: var(--vt-text-main);
            transition: background .15s;
        }

        .vt-cand-menu-btn:hover {
            background: #fff;
        }

        /* Avatar initiales (fallback sans photo) */
        .vt-cand-no-photo {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            color: var(--vt-text-muted);
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }

        /* Corps de la carte */
        .vt-cand-body {
            padding: 12px 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .vt-cand-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--vt-text-main);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-transform: uppercase;
            letter-spacing: .2px;
        }

        .vt-cand-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 2px;
        }

        .vt-cand-meta-item {
            display: flex;
            align-items: center;
            gap: 3px;
            font-size: 11px;
            color: var(--vt-text-muted);
            background: var(--vt-page-bg);
            padding: 2px 8px;
            border-radius: 50px;
        }

        .vt-cand-meta-item i {
            font-size: 11px;
        }

        /* Pied de carte : votes + actions */
        .vt-cand-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 14px 12px;
            border-top: 1px solid var(--vt-border);
            margin-top: auto;
        }

        .vt-cand-votes {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 700;
            color: var(--vt-orange);
        }

        .vt-cand-votes i {
            font-size: 13px;
        }

        .vt-cand-votes span.label {
            font-size: 10.5px;
            font-weight: 500;
            color: var(--vt-text-muted);
        }

        .vt-cand-actions {
            display: flex;
            gap: 5px;
        }

        .vt-cand-action-btn {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: 1px solid var(--vt-border);
            background: #fff;
            color: var(--vt-text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }

        .vt-cand-action-btn.edit:hover {
            border-color: #93c5fd;
            color: #2563eb;
            background: #eff6ff;
        }

        .vt-cand-action-btn.del:hover {
            border-color: #fca5a5;
            color: #dc2626;
            background: #fff5f5;
        }

        @media (max-width: 860px) {
            .vt-candidat-layout {
                flex-direction: column;
            }

            .vt-candidat-sidebar {
                width: 100%;
            }
        }

        /* ---- Image upload dans modale d'édition ---- */
        .image-upload-group .avatar {
            width: 120px !important;
            height: 120px !important;
            min-width: 120px;
            min-height: 120px;
            flex-shrink: 0;
        }

        .image-upload-group .preview-target {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-upload-group .ti-photo {
            font-size: 48px !important;
        }
    </style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    {{-- En-tête : titre + actions --}}
    <div class="vt-page-header-row">
        <h1 class="vt-page-title-xl">Candidats</h1>
        <div class="vt-header-actions">
            <a href="javascript:void(0);" class="vt-btn-primary" data-bs-toggle="modal"
                data-bs-target="#modal_add_candidat">
                <i class="ti ti-plus" style="font-size:14px;"></i> Créer
            </a>
            <div class="dropdown">
                <a href="javascript:void(0);" class="vt-btn-muted dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="ti ti-package-import" style="font-size:15px;"></i> Importer
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file-type-csv me-2"></i>Importer
                            en CSV</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file-type-xls me-2"></i>Importer
                            en Excel</a></li>
                </ul>
            </div>
            <a href="javascript:void(0);" class="vt-btn-outline-dark">
                <i class="ti ti-download" style="font-size:14px;"></i> Exporter
            </a>
        </div>
        <div class="col-sm-12">@include('layout.status')</div>
    </div>

    {{-- Layout deux colonnes --}}
    <div class="vt-candidat-layout">

        {{-- =====================================================
             COLONNE GAUCHE — FILTRE + CATÉGORIES
             ===================================================== --}}
        <div class="vt-candidat-sidebar">

            {{-- Filtres --}}
            <div class="vt-sidebar-section">
                <p class="vt-sidebar-section-title">Choisir la session</p>

                <p class="vt-sidebar-label">Session</p>
                <select class="vt-sidebar-select js-select-campagne">
                    <option value="">— Toutes les sessions —</option>
                    @foreach ($campagnes as $item)
                        @php($campagne = $item['campagne'] ?? null)
                        @if ($campagne)
                            <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                        @endif
                    @endforeach
                </select>

                <p class="vt-sidebar-label">Choisir l'étape</p>
                <select class="vt-sidebar-select js-select-etape" disabled>
                    <option value="">Toutes les étapes</option>
                    @foreach ($etapes as $etape)
                        <option value="{{ $etape->etape_id }}" data-campagne-id="{{ $etape->campagne_id }}">
                            {{ $etape->name }}
                        </option>
                    @endforeach
                </select>

                <p class="vt-sidebar-label">Choisir la catégorie</p>
                <select class="vt-sidebar-select js-select-categorie" disabled>
                    <option value="">Toutes les catégories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}" data-campagne-id="{{ $category->campagne_id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="vt-sidebar-divider"></div>

            {{-- Catégories --}}
            <div class="js-cat-section" style="display:none;">
                <div class="vt-cat-header">
                    <span class="vt-cat-heading">Catégories</span>
                    <button class="vt-cat-add-btn" data-bs-toggle="modal" data-bs-target="#modal_add_categorie"
                        title="Ajouter une catégorie">+</button>
                </div>
                <p class="vt-cat-subtitle">Gérer les catégories de la session.</p>

                <div class="vt-cat-list" id="sidebar-categories">

                    @forelse ($categories as $cat)
                        <div class="vt-cat-item js-cat-item" data-campagne-id="{{ $cat->campagne_id }}">
                            <div class="vt-cat-avatar">
                                {{ strtoupper(substr($cat->name, 0, 1)) }}
                            </div>
                            <div class="vt-cat-info">
                                <p class="vt-cat-name">{{ $cat->name }}</p>
                                <p class="vt-cat-count">{{ $cat->candidats_count }}
                                    candidat{{ $cat->candidats_count > 1 ? 's' : '' }}</p>
                            </div>
                            <div class="vt-cat-actions">
                                <a href="javascript:void(0);" class="vt-cat-btn js-btn-edit-cat"
                                    data-id="{{ $cat->category_id }}" data-description="{{ $cat->description }}"
                                    data-name="{{ $cat->name }}" data-icon="{{ $cat->icon }}"
                                    data-campagne_id="{{ $cat->campagne_id }}" data-bs-toggle="modal"
                                    data-bs-target="#modal_edit_categorie" title="Modifier">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <a href="javascript:void(0);" class="vt-cat-btn danger js-btn-delete-cat"
                                    data-id="{{ $cat->category_id }}" data-bs-toggle="modal"
                                    data-bs-target="#modal_delete_categorie" title="Supprimer">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p style="font-size:12px; color:#94a3b8; padding: 0 6px;">
                            Aucune catégorie. Sélectionnez une session.
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- Bouton exporter bas de sidebar --}}
            <a href="javascript:void(0);" class="vt-sidebar-export">
                <i class="ti ti-download"></i> Exporter
            </a>

        </div>
        {{-- fin sidebar --}}

        {{-- =====================================================
             COLONNE DROITE — RECHERCHE + CANDIDATS
             ===================================================== --}}
        <div class="vt-candidat-main">

            {{-- Recherche --}}
            <div class="vt-candidat-search-wrap">
                <i class="ti ti-search vt-s-icon"></i>
                <input type="text" class="vt-candidat-search js-search-candidat"
                    placeholder="Rechercher un candidat ...">
            </div>

            {{-- Grille candidats (remplie via AJAX - classes JS conservées) --}}
            <div class="row g-3 js-candidat-table-body">
                <div class="col-12">
                    <div class="vt-candidat-empty">
                        <i class="ti ti-users" style="font-size:32px; display:block; margin-bottom:8px; opacity:.3;"></i>
                        Sélectionnez une session pour afficher les candidats.
                    </div>
                </div>
            </div>

            {{-- Bouton charger plus --}}
            <div class="vt-load-more-wrap load-btn" id="load-more-container">
                <a href="javascript:void(0);" class="vt-load-more-btn js-load-more">
                    <i class="ti ti-refresh" style="font-size:14px;"></i>
                    Charger plus
                </a>
            </div>

        </div>
        {{-- fin main --}}

    </div>
    {{-- fin layout --}}

@endsection

{{-- =====================================================
     MODALES
     ===================================================== --}}

{{-- Ajout candidat --}}
<div class="modal fade" id="modal_add_candidat" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter candidat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.save_candidat') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3 image-upload-group">
                            <div class="d-flex align-items-center bg-light p-2 rounded">
                                <div
                                    class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">
                                    <i class="ti ti-photo text-muted fs-4 placeholder-target"></i>
                                    <img src="#" alt="Aperçu"
                                        class="preview-target d-none w-100 h-100 object-fit-cover">
                                </div>
                                <div class="d-flex flex-column">
                                    <label class="form-label mb-1">Photo du candidat</label>
                                    <input type="file" class="form-control form-control-sm" name="photo"
                                        accept="image/*" onchange="handleImagePreview(this)">
                                    <small class="text-muted">JPG, GIF ou PNG. Max 800K</small>
                                    <button type="button"
                                        class="btn btn-sm btn-link text-danger p-0 d-none remove-btn-target text-start"
                                        onclick="handleImageRemove(this)">Supprimer</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom complet <span class="text-danger">*</span></label>
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
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="telephone" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email"
                                placeholder="candidat@exemple.com" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pays <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pays" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ville <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ville" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Campagne <span class="text-danger">*</span></label>
                            <select name="campagne_id" class="form-select js-add-campagne" required>
                                <option value="">Sélectionner une campagne</option>
                                @foreach ($campagnes as $item)
                                    @php($campagne = $item['campagne'] ?? null)
                                    @if ($campagne)
                                        <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Étape <span class="text-danger">*</span></label>
                            <select name="etape_id" class="form-select js-add-etape" required disabled>
                                <option value="">Sélectionner</option>
                                @foreach ($etapes as $etape)
                                    <option value="{{ $etape->etape_id }}"
                                        data-campagne-id="{{ $etape->campagne_id }}">{{ $etape->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger d-none js-msg-no-etape mt-1"><i class="ti ti-info-circle"></i>
                                Aucune étape disponible.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Catégorie</label>
                            <select name="category_id" class="form-select js-add-categorie" disabled>
                                <option value="">Sélectionner</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}"
                                        data-campagne-id="{{ $category->campagne_id }}">{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Présentation du candidat <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" rows="4" required
                                placeholder="Parlez brièvement de lui, son parcours, ses ambitions..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top mt-4 pb-0 px-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary js-btn-save-candidat"><i
                                class="ti ti-device-floppy me-1"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modification candidat --}}
<div class="modal fade" id="modal_edit_candidat" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Modifier le candidat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_edit_candidat" action="{{ route('business.update_candidat') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="candidat_id">
                    <input type="hidden" name="old_photo">
                    <div class="row">
                        <div class="col-md-12 mb-3 image-upload-group">
                            <div class="d-flex align-items-center bg-light p-2 rounded">
                                <div
                                    class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">
                                    <i class="ti ti-photo text-muted fs-4 placeholder-target"></i>
                                    <img src="#" alt="Aperçu"
                                        class="preview-target d-none w-100 h-100 object-fit-cover">
                                </div>
                                <div class="d-flex flex-column">
                                    <label class="form-label mb-1">Photo du candidat</label>
                                    <input type="file" class="form-control form-control-sm" name="photo"
                                        accept="image/*" onchange="handleImagePreview(this)">
                                    <small class="text-muted">JPG, GIF ou PNG. Max 800K</small>
                                    <button type="button"
                                        class="btn btn-sm btn-link text-danger p-0 d-none remove-btn-target text-start"
                                        onclick="handleImageRemove(this)">Supprimer</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nom complet <span class="text-danger">*</span></label>
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
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="telephone" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pays <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pays" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ville <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ville" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Présentation du candidat <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top pb-0 px-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i>
                            Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Suppression candidat --}}
<div class="modal fade" id="delete_contact" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <form id="form_delete_candidat" action="{{ route('business.delete_candidat') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle"><i
                                class="ti ti-trash fs-24"></i></span>
                    </div>
                    <h5 class="mb-1">Confirmer la suppression</h5>
                    <p class="mb-3">Êtes-vous sûr de vouloir supprimer ce candidat ?</p>
                    <input type="hidden" name="candidat_id">
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger w-100">Oui, supprimer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Ajout catégorie --}}
<div class="modal fade" id="modal_add_categorie" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Ajouter une catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.save_categorie') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nom catégorie <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Choisir la campagne <span class="text-danger">*</span></label>

                        {{-- Campagne pré-remplie automatiquement via JS --}}
                        <input type="hidden" name="campagne_id">

                        <input type="text" class="form-control js-cat-campagne-label" readonly disabled
                            placeholder="Sélectionnez d'abord une session">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icone</label>
                        <select class="form-select" name="icon">
                            <option value="">Sélectionner</option>
                            <option value="homme">Homme</option>
                            <option value="femme">Femme</option>
                            <option value="enfant">Enfant</option>
                            <option value="jeune">Jeune</option>
                        </select>
                    </div>
                    <div class="modal-footer border-top pb-0 px-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i>
                            Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modification catégorie --}}
<div class="modal fade" id="modal_edit_categorie" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Modifier la catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.update_categorie') }}" method="POST">
                    @csrf
                    <input type="hidden" name="category_id" id="edit_cat_id">
                    <input type="hidden" name="campagne_id" id="edit_cat_campagne_id">
                    <div class="mb-3">
                        <label class="form-label">Nom catégorie <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="edit_cat_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" name="description" id="edit_cat_description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icone</label>
                        <select class="form-select" name="icon" id="edit_cat_icon">
                            <option value="">Sélectionner</option>
                            <option value="homme">Homme</option>
                            <option value="femme">Femme</option>
                            <option value="enfant">Enfant</option>
                            <option value="jeune">Jeune</option>
                        </select>
                    </div>
                    <div class="modal-footer border-top pb-0 px-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary"><i class="ti ti-check me-1"></i>
                            Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Suppression catégorie --}}
<div class="modal fade" id="modal_delete_categorie" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <form id="form_delete_categorie" action="{{ route('business.delete_categorie') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle"><i
                                class="ti ti-trash fs-24"></i></span>
                    </div>
                    <h5 class="mb-1">Supprimer la catégorie</h5>
                    <p class="mb-3">Cette action est irréversible.</p>
                    <input type="hidden" name="category_id" id="delete_cat_id">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger w-100">Supprimer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
    <script>
        $(document).ready(function() {

            let currentPage = 1;
            let searchTimeout = null;
            const APP_IMAGES_PATH = "{{ env('IMAGES_PATH') }}/";

            /* --- Options clonées pour les filtres --- */
            const $allEtapesOptions = $('.js-select-etape option').clone();
            const $allCategoriesOptions = $('.js-select-categorie option').clone();

            /* -------------------------------------------------------
               FILTRE EN CASCADE (sidebar gauche)
               ------------------------------------------------------- */

            $('.js-select-campagne').on('change', function() {
                const campagneId = $(this).val();
                const $selectEtape = $('.js-select-etape');
                const $selectCategorie = $('.js-select-categorie');

                $selectEtape.empty().prop('disabled', true)
                    .append('<option value="">Toutes les étapes</option>');
                $selectCategorie.empty().prop('disabled', true)
                    .append('<option value="">Toutes les catégories</option>');

                if (campagneId) {
                    const campagneName = $('.js-select-campagne option:selected').text().trim();

                    // Pré-remplir la modale
                    $('#modal_add_categorie input[name="campagne_id"]').val(campagneId);
                    $('#modal_add_categorie .js-cat-campagne-label').val(campagneName);

                    // Remplir étapes et catégories filtrées
                    $allEtapesOptions.each(function() {
                        if ($(this).data('campagne-id') == campagneId)
                            $selectEtape.append($(this).clone());
                    });
                    $allCategoriesOptions.each(function() {
                        if ($(this).data('campagne-id') == campagneId)
                            $selectCategorie.append($(this).clone());
                    });

                    $selectEtape.prop('disabled', false);
                    $selectCategorie.prop('disabled', false);

                    // Afficher section catégories + filtrer les items
                    $('.js-cat-section').show();
                    $('.js-cat-item').each(function() {
                        $(this).toggle($(this).data('campagne-id') == campagneId);
                    });

                    // Débloquer bouton + titre dynamique
                    $('.js-cat-add-btn').prop('disabled', false).removeClass('disabled');
                    $('.js-cat-heading').text('Catégories — ' + campagneName);

                } else {
                    $('.js-cat-section').hide();
                    $('.js-cat-add-btn').prop('disabled', true).addClass('disabled');
                }

                currentPage = 1;
                chargerCandidats(false);
            });

            /* -------------------------------------------------------
               FORMULAIRE AJOUT — cascade campagne → étape/catégorie
               ------------------------------------------------------- */
            const $formEtapesOptions = $('.js-add-etape option').clone();
            const $formCategoriesOptions = $('.js-add-categorie option').clone();

            $(document).on('change', '.js-add-campagne', function() {
                const campagneId = $(this).val();
                const $selectEtape = $('.js-add-etape');
                const $selectCat = $('.js-add-categorie');
                const $msgNoEtape = $('.js-msg-no-etape');
                const $submitBtn = $('.js-btn-save-candidat');

                $selectEtape.empty().prop('disabled', true).append(
                    '<option value="">Sélectionner</option>');
                $selectCat.empty().prop('disabled', true).append('<option value="">Sélectionner</option>');
                $msgNoEtape.addClass('d-none');
                $submitBtn.prop('disabled', false);

                if (campagneId) {
                    let etapeCount = 0;
                    $formEtapesOptions.each(function() {
                        if ($(this).data('campagne-id') == campagneId) {
                            $selectEtape.append($(this).clone());
                            etapeCount++;
                        }
                    });
                    $formCategoriesOptions.each(function() {
                        if ($(this).data('campagne-id') == campagneId)
                            $selectCat.append($(this).clone());
                    });

                    if (etapeCount === 0) {
                        $msgNoEtape.removeClass('d-none');
                        $submitBtn.prop('disabled', true);
                    } else {
                        $selectEtape.prop('disabled', false);
                    }
                    $selectCat.prop('disabled', false);
                }
            });

            /* -------------------------------------------------------
               RECHERCHE
               ------------------------------------------------------- */
            $(document).on('keyup', '.js-search-candidat', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    currentPage = 1;
                    chargerCandidats(false);
                }, 500);
            });

            /* -------------------------------------------------------
               FILTRES ÉTAPE / CATÉGORIE
               ------------------------------------------------------- */
            $(document).on('change', '.js-select-etape, .js-select-categorie', function() {
                currentPage = 1;
                chargerCandidats(false);
            });

            /* -------------------------------------------------------
               LOAD MORE
               ------------------------------------------------------- */
            $(document).on('click', '.js-load-more', function() {
                currentPage++;
                chargerCandidats(true);
            });

            /* -------------------------------------------------------
               AJAX — CHARGER CANDIDATS
               ------------------------------------------------------- */
            function chargerCandidats(append = false) {
                const params = {
                    campagne_id: $('.js-select-campagne').val(),
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
                    url: `/business/recherche_candidat`,
                    method: 'GET',
                    data: params,
                    success: function(response) {
                        renderCandidatCards(response.data, append);
                        if (response.current_page < response.last_page) {
                            /* Met à jour le texte du bouton */
                            const shown = response.current_page * (response.data?.length || 0);
                            $('.js-load-more').html(
                                '<i class="ti ti-refresh" style="font-size:14px;"></i> Charger plus (' +
                                shown + ' / ' + response.total + ')'
                            );
                            $('.load-btn').show();
                        } else {
                            $('.load-btn').hide();
                        }
                    }
                });
            }

            /* -------------------------------------------------------
               RENDER CARTES CANDIDATS
               ------------------------------------------------------- */
            function renderCandidatCards(candidats, append) {
                let html = '';
                if (candidats.length === 0 && !append) {
                    html =
                        '<div class="col-12"><div class="vt-candidat-empty"><i class="ti ti-users" style="font-size:32px; display:block; margin-bottom:8px; opacity:.3;"></i>Aucun candidat trouvé.</div></div>';
                    $('.js-candidat-table-body').html(html);
                    return;
                }

                candidats.forEach((candidat, index) => {
                    const data = encodeURIComponent(JSON.stringify(candidat));
                    const photoUrl = candidat.photo ? APP_IMAGES_PATH + candidat.photo :
                        'assets/img/profiles/avatar-01.jpg';
                    const orderNum = ((currentPage - 1) * 12) + (index + 1);

                    const age = calculerAge(candidat.date_naissance);
                    const profession = candidat.profession ? candidat.profession : '';
                    const votes = candidat.votes_count || 0;
                    const numLabel = String(orderNum).padStart(3, '0');
                    const initiales = candidat.name ? candidat.name.charAt(0).toUpperCase() : '?';
                    const photoHtml = candidat.photo ?
                        `<img src="${photoUrl}" alt="${candidat.name}">` :
                        `<div class="vt-cand-no-photo">${initiales}</div>`;

                    html += `
                    <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-6">
                        <div class="vt-cand-card">

                            {{-- Bandeau photo --}}
                            <div class="vt-cand-photo-wrap">
                                ${photoHtml}
                                <span class="vt-cand-num"># ${numLabel}</span>
                                <div class="vt-cand-menu dropdown">
                                    <button class="vt-cand-menu-btn" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item js-btn-edit" href="javascript:void(0);" data-candidat="${data}">
                                            <i class="ti ti-edit me-1"></i> Modifier
                                        </a>
                                        <a class="dropdown-item text-danger js-btn-delete" href="javascript:void(0);" data-id="${candidat.candidat_id}">
                                            <i class="ti ti-trash me-1"></i> Supprimer
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Corps --}}
                            <div class="vt-cand-body">
                                <p class="vt-cand-name" title="${candidat.name}">${candidat.name}</p>
                                <div class="vt-cand-meta">
                                    ${age ? `<span class="vt-cand-meta-item"><i class="ti ti-calendar"></i>${age} ans</span>` : ''}
                                    ${profession ? `<span class="vt-cand-meta-item"><i class="ti ti-briefcase"></i>${profession}</span>` : ''}
                                </div>
                            </div>

                            {{-- Pied --}}
                            <div class="vt-cand-footer">
                                <div class="vt-cand-votes">
                                    <i class="ti ti-ticket"></i>
                                    <span>${votes}</span>
                                    <span class="label">vote${votes > 1 ? 's' : ''}</span>
                                </div>
                                <div class="vt-cand-actions">
                                    <a href="javascript:void(0);"
                                    class="vt-cand-action-btn edit js-btn-edit"
                                    data-candidat="${data}" title="Modifier">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);"
                                    class="vt-cand-action-btn del js-btn-delete"
                                    data-id="${candidat.candidat_id}" title="Supprimer">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>`;
                });

                if (append) $('.js-candidat-table-body').append(html);
                else $('.js-candidat-table-body').html(html);
            }

            /* -------------------------------------------------------
               ÉDITION CANDIDAT (remplir modale)
               ------------------------------------------------------- */
            $(document).on('click', '.js-btn-edit', function() {
                const data = JSON.parse(decodeURIComponent($(this).data('candidat')));
                const $modal = $('#modal_edit_candidat');

                $modal.find('input[name="candidat_id"]').val(data.candidat_id);
                $modal.find('input[name="old_photo"]').val(data.photo);
                $modal.find('input[name="name"]').val(data.name);
                $modal.find('select[name="sexe"]').val(data.sexe);
                $modal.find('input[name="date_naissance"]').val(data.date_naissance);
                $modal.find('input[name="telephone"]').val(data.telephone);
                $modal.find('input[name="email"]').val(data.email);
                $modal.find('input[name="pays"]').val(data.pays);
                $modal.find('input[name="ville"]').val(data.ville);
                $modal.find('input[name="profession"]').val(data.profession);
                $modal.find('textarea[name="description"]').val(data.description);

                const $preview = $modal.find('.preview-target');
                const $placeholder = $modal.find('.placeholder-target');
                const $removeBtn = $modal.find('.remove-btn-target');
                $modal.find('input[name="photo"]').val('');
                if (data.photo) {
                    $preview.attr('src', APP_IMAGES_PATH + data.photo).removeClass('d-none');
                    $placeholder.addClass('d-none');
                    $removeBtn.removeClass('d-none');
                } else {
                    $preview.attr('src', '#').addClass('d-none');
                    $placeholder.removeClass('d-none');
                    $removeBtn.addClass('d-none');
                }
                $modal.modal('show');
            });

            /* -------------------------------------------------------
               SUPPRESSION CANDIDAT
               ------------------------------------------------------- */
            $(document).on('click', '.js-btn-delete', function() {
                const id = $(this).data('id');
                $('#delete_contact').find('input[name="candidat_id"]').val(id);
                $('#delete_contact').modal('show');
            });

            /* -------------------------------------------------------
               ÉDITION CATÉGORIE (remplir modale)
               ------------------------------------------------------- */
            $(document).on('click', '.js-btn-edit-cat', function() {
                $('#edit_cat_id').val($(this).data('id'));
                $('#edit_cat_campagne_id').val($(this).data('campagne_id'));
                $('#edit_cat_name').val($(this).data('name'));
                $('#edit_cat_description').val($(this).data('description'));
                $('#edit_cat_icon').val($(this).data('icon'));
            });

            /* -------------------------------------------------------
               SUPPRESSION CATÉGORIE
               ------------------------------------------------------- */
            $(document).on('click', '.js-btn-delete-cat', function() {
                $('#delete_cat_id').val($(this).data('id'));
            });

            /* -------------------------------------------------------
               SUBMIT AJAX — édition candidat
               ------------------------------------------------------- */
            $('#form_edit_candidat').on('submit', function(e) {
                e.preventDefault();
                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');
                const originalBtnHtml = $submitBtn.html();
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();
                $submitBtn.prop('disabled', true).html('Mise à jour...');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal_edit_candidat').modal('hide');
                        if (response.success && typeof showAjaxAlert === 'function')
                            showAjaxAlert('success', response.message);
                        $('.js-select-campagne').trigger('change');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (typeof showAjaxAlert === 'function')
                                showAjaxAlert('danger',
                                    'Veuillez corriger les champs en erreur.');
                            $.each(errors, function(fieldName, messages) {
                                let $input = $form.find(`[name="${fieldName}"]`)
                                    .first();
                                if ($input.length) {
                                    $input.addClass('is-invalid');
                                    $input.after(
                                        `<div class="invalid-feedback d-block">${messages[0]}</div>`
                                    );
                                }
                            });
                        } else {
                            if (typeof showAjaxAlert === 'function')
                                showAjaxAlert('danger', xhr.responseJSON?.message || 'Erreur.');
                        }
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).html(originalBtnHtml);
                    }
                });
            });

            /* -------------------------------------------------------
               SUBMIT AJAX — suppression candidat
               ------------------------------------------------------- */
            $('#form_delete_candidat').on('submit', function(e) {
                e.preventDefault();
                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');
                $submitBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#delete_contact').modal('hide');
                        if (response.success && typeof showAjaxAlert === 'function')
                            showAjaxAlert('success', response.message);
                        $('.js-select-campagne').trigger('change');
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message || 'Erreur lors de la suppression.';
                        if (typeof showAjaxAlert === 'function') showAjaxAlert('danger', msg);
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).html('Oui, supprimer');
                    }
                });
            });

            /* -------------------------------------------------------
               UTILITAIRE — Calcul d'âge
               ------------------------------------------------------- */
            function calculerAge(dateNaissanceStr) {
                if (!dateNaissanceStr) return '';
                const today = new Date();
                const naissance = new Date(dateNaissanceStr);
                let age = today.getFullYear() - naissance.getFullYear();
                const m = today.getMonth() - naissance.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < naissance.getDate())) age--;
                return age;
            }

        });
    </script>
@endsection
