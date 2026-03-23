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

        /* ================================================
                                                                                           MODAL CANDIDAT — Design "Demande de retrait"
                                                                                           ================================================ */
        .vt-cand-modal .modal-content {
            border-radius: 16px;
            border: none;
            overflow: hidden;
        }

        .vt-cand-modal-header {
            background: linear-gradient(to bottom, #fff7ed 0%, #ffffff 100%);
            border-bottom: 1px solid var(--vt-orange-border);
            padding: 18px 22px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .vt-cand-modal-icon {
            width: 36px;
            height: 36px;
            background: var(--vt-orange-light);
            border: 1.5px solid var(--vt-orange-border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            color: var(--vt-orange);
            flex-shrink: 0;
        }

        .vt-cand-modal-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--vt-text-main);
            flex: 1;
            margin: 0;
        }

        .vt-cand-modal-close {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1.5px solid var(--vt-border);
            background: #fff;
            color: var(--vt-text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            cursor: pointer;
            transition: all .15s;
            flex-shrink: 0;
        }

        .vt-cand-modal-close:hover {
            border-color: #94a3b8;
            color: var(--vt-text-main);
        }

        .vt-cand-modal .modal-body {
            padding: 20px 22px 8px;
        }

        .vt-cm-section {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--vt-text-muted);
            margin: 16px 0 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .vt-cm-section::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--vt-border);
        }

        .vt-cm-photo-zone {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            border: 1.5px dashed var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fafafa;
            margin-bottom: 16px;
            transition: border-color .15s;
        }

        .vt-cm-photo-zone:hover {
            border-color: #94a3b8;
        }

        .vt-cm-avatar {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            background: #f1f5f9;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .vt-cm-avatar .placeholder-target {
            font-size: 22px;
            color: #94a3b8;
        }

        .vt-cm-avatar .preview-target {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vt-cm-photo-info {
            flex: 1;
        }

        .vt-cm-photo-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--vt-text-main);
            margin-bottom: 2px;
        }

        .vt-cm-photo-hint {
            font-size: 11px;
            color: var(--vt-text-muted);
        }

        .vt-cm-photo-btn {
            border: 1.5px solid var(--vt-border);
            border-radius: 6px;
            background: #fff;
            color: var(--vt-text-muted);
            font-size: 11.5px;
            font-weight: 600;
            padding: 6px 13px;
            cursor: pointer;
            transition: all .15s;
            position: relative;
            overflow: hidden;
        }

        .vt-cm-photo-btn:hover {
            border-color: var(--vt-orange);
            color: var(--vt-orange);
        }

        .vt-cm-photo-btn input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .vt-cm-field {
            margin-bottom: 12px;
        }

        .vt-cm-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--vt-text-muted);
            display: block;
            margin-bottom: 5px;
        }

        .vt-cm-input-wrap {
            position: relative;
        }

        .vt-cm-input-wrap .vt-cm-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
        }

        .vt-cm-input-wrap.top .vt-cm-icon {
            top: 13px;
            transform: none;
        }

        .vt-cm-input {
            width: 100%;
            padding: 9px 12px 9px 34px;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            font-size: 13px;
            color: var(--vt-text-main);
            background: #fff;
            transition: border-color .15s;
            font-family: inherit;
        }

        .vt-cm-input:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        .vt-cm-input::placeholder {
            color: #94a3b8;
        }

        textarea.vt-cm-input {
            resize: vertical;
            min-height: 80px;
            padding-top: 10px;
        }

        .vt-cm-select {
            width: 100%;
            padding: 9px 30px 9px 34px;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 9px center / 14px;
            appearance: none;
            font-size: 13px;
            color: var(--vt-text-main);
            cursor: pointer;
            transition: border-color .15s;
            font-family: inherit;
        }

        .vt-cm-select:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        .vt-cm-select:disabled {
            opacity: .5;
            cursor: not-allowed;
            background-color: #f8fafc;
        }

        .vt-cm-hint {
            font-size: 11px;
            color: var(--vt-orange);
            margin: 3px 0 0;
            font-style: italic;
        }

        .vt-cand-modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding: 14px 22px;
            border-top: 1px solid var(--vt-border);
            background: #fff;
        }

        .vt-cm-btn-cancel {
            padding: 9px 22px;
            border-radius: 8px;
            border: 1.5px solid var(--vt-border);
            background: #fff;
            color: var(--vt-text-main);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .vt-cm-btn-cancel:hover {
            border-color: #94a3b8;
        }

        .vt-cm-btn-submit {
            padding: 9px 22px;
            border-radius: 8px;
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

        .vt-cm-btn-submit:hover {
            background: var(--vt-orange-hover);
        }

        /* ---- Icon Picker ---- */
        .ip-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            width: 100%;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fff;
            cursor: pointer;
            text-align: left;
            transition: border-color .15s;
            font-family: inherit;
        }

        .ip-trigger:hover {
            border-color: var(--vt-orange);
        }

        .ip-trigger i {
            font-size: 16px;
            color: #94a3b8;
            flex-shrink: 0;
        }

        .ip-trigger-label {
            font-size: 13px;
            color: #94a3b8;
            flex: 1;
        }

        .ip-trigger-selected {
            font-size: 13px;
            color: var(--vt-text-main);
            flex: 1;
            font-weight: 500;
        }

        .ip-panel {
            position: absolute;
            left: 0;
            right: 0;
            top: calc(100% + 4px);
            background: #fff;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            z-index: 9999;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .10);
        }

        .ip-search-wrap {
            padding: 10px 12px;
            border-bottom: 1px solid var(--vt-border);
        }

        .ip-search {
            width: 100%;
            box-sizing: border-box;
            padding: 7px 10px;
            border: 1.5px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            font-size: 13px;
            color: var(--vt-text-main);
            outline: none;
            font-family: inherit;
        }

        .ip-search:focus {
            border-color: var(--vt-orange);
        }

        .ip-cats {
            display: flex;
            gap: 6px;
            padding: 8px 12px;
            flex-wrap: wrap;
            border-bottom: 1px solid var(--vt-border);
        }

        .ip-cat {
            font-size: 11.5px;
            padding: 3px 10px;
            border-radius: 50px;
            border: 1.5px solid var(--vt-border);
            background: #fff;
            color: var(--vt-text-muted);
            cursor: pointer;
            transition: all .15s;
        }

        .ip-cat:hover {
            border-color: var(--vt-orange);
            color: var(--vt-orange);
        }

        .ip-cat.active {
            background: var(--vt-orange-light);
            color: var(--vt-orange);
            border-color: var(--vt-orange);
        }

        .ip-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, 42px);
            gap: 3px;
            padding: 10px 12px;
            max-height: 220px;
            overflow-y: auto;
        }

        .ip-icon-btn {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1.5px solid transparent;
            cursor: pointer;
            background: transparent;
            color: var(--vt-text-main);
            transition: all .15s;
        }

        .ip-icon-btn:hover {
            background: #f8fafc;
            border-color: var(--vt-border);
        }

        .ip-icon-btn.selected {
            background: var(--vt-orange-light);
            border-color: var(--vt-orange);
            color: var(--vt-orange);
        }

        .ip-icon-btn i {
            font-size: 19px;
            pointer-events: none;
        }

        .ip-footer {
            padding: 8px 12px;
            border-top: 1px solid var(--vt-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ip-count {
            font-size: 11.5px;
            color: var(--vt-text-muted);
        }

        .ip-confirm {
            font-size: 12.5px;
            padding: 5px 14px;
            border-radius: var(--vt-radius-sm);
            border: 1.5px solid var(--vt-border);
            background: #fff;
            color: var(--vt-text-main);
            cursor: pointer;
            transition: all .15s;
        }

        .ip-confirm:hover {
            border-color: var(--vt-orange);
            color: var(--vt-orange);
        }

        .ip-empty {
            grid-column: 1/-1;
            padding: 1.5rem;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
        }
    </style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    {{-- En-tête : titre + actions --}}
    <div class="vt-page-header-row">
        <h1 class="vt-page-title-xl">Candidats</h1>
        <div class="vt-header-actions">
            <a href="javascript:void(0);" class="vt-btn-primary disabled js-btn-create-candidat"
                style="pointer-events:none; opacity:0.5;" data-bs-toggle="modal" data-bs-target="#modal_add_candidat">
                <i class="ti ti-plus" style="font-size:14px;"></i> Créer
            </a>

            <div class="dropdown js-btn-create-candidat" style="pointer-events:none; opacity:0.5;">
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
            <a href="javascript:void(0);" class="vt-btn-outline-dark js-btn-create-candidat"
                style="pointer-events:none; opacity:0.5;">
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
                                {{-- {{ strtoupper(substr($cat->name, 0, 1)) }} --}}
                                @if ($cat->icon)
                                    <i class="ti {{ $cat->icon }}" style="font-size:18px;"></i>
                                @else
                                    {{ strtoupper(substr($cat->name, 0, 1)) }}
                                @endif
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
<div class="modal fade vt-cand-modal" id="modal_add_candidat" tabindex="-1" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:560px;">
        <div class="modal-content">

            {{-- Header gradient --}}
            <div class="vt-cand-modal-header">
                <div class="vt-cand-modal-icon">
                    <i class="ti ti-plus"></i>
                </div>
                <h5 class="vt-cand-modal-title">Ajouter un candidat</h5>
                <button type="button" class="vt-cand-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x" style="font-size:12px;"></i>
                </button>
            </div>

            <div class="modal-body">
                <form class="ajax-form_old" action="{{ route('business.save_candidat') }}" method="POST"
                    enctype="multipart/form-data" id="form-add-candidat">
                    @csrf

                    {{-- Zone photo --}}
                    <div class="vt-cm-photo-zone image-upload-group">
                        <div class="vt-cm-avatar">
                            <i class="ti ti-user placeholder-target" style="font-size:20px; color:#94a3b8;"></i>
                            <img src="#" alt="" class="preview-target d-none">
                        </div>
                        <div class="vt-cm-photo-info">
                            <p class="vt-cm-photo-label">Photo du candidat<span class="text-danger">*</span></p>
                            <p class="vt-cm-photo-hint">JPG, PNG · Max 800K</p>
                        </div>
                        <label class="vt-cm-photo-btn">
                            <i class="ti ti-upload" style="font-size:12px;"></i> Choisir
                            <input type="file" name="photo" accept="image/*"
                                onchange="handleImagePreview(this)" required>
                        </label>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0 d-none remove-btn-target"
                            onclick="handleImageRemove(this)" style="font-size:11.5px;">
                            Supprimer
                        </button>
                    </div>

                    {{-- Section Identité --}}
                    <p class="vt-cm-section">Identité</p>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Nom complet <span class="text-danger">*</span></label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-user vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="name"
                                        placeholder="Ex : Marie Dupont" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Sexe</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-gender-bigender vt-cm-icon"></i>
                                    <select class="vt-cm-select" name="sexe">
                                        <option value="">Choisir</option>
                                        <option value="M">Masculin</option>
                                        <option value="F">Féminin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Date de naissance</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-calendar vt-cm-icon"></i>
                                    <input type="date" class="vt-cm-input" name="date_naissance">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Profession</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-briefcase vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="profession"
                                        placeholder="Ex : Styliste">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section Contact --}}
                    <p class="vt-cm-section">Contact</p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Téléphone</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-phone vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="telephone"
                                        placeholder="+225 ..." pattern="^\+?\d{10,15}$">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Email</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-mail vt-cm-icon"></i>
                                    <input type="email" class="vt-cm-input" name="email"
                                        placeholder="candidat@..."
                                        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Pays</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-map-pin vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="pays"
                                        placeholder="Ex : Côte d'Ivoire">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Ville</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-building-community vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="ville"
                                        placeholder="Ex : Abidjan">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section Candidature --}}
                    <p class="vt-cm-section">Candidature</p>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Session</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-calendar-event vt-cm-icon"></i>
                                    <input type="hidden" name="campagne_id" class="js-add-campagne-hidden">
                                    <select class="vt-cm-select js-add-campagne" disabled>
                                        <option value="">Sélectionner une session</option>
                                        @foreach ($campagnes as $item)
                                            @php($campagne = $item['campagne'] ?? null)
                                            @if ($campagne)
                                                <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Étape</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-flag vt-cm-icon"></i>
                                    <input type="hidden" name="etape_id" class="js-add-etape-hidden">
                                    <select class="vt-cm-select js-add-etape" disabled>
                                        <option value="">Sélectionner</option>
                                        @foreach ($etapes as $etape)
                                            <option value="{{ $etape->etape_id }}"
                                                data-campagne-id="{{ $etape->campagne_id }}">
                                                {{ $etape->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="vt-cm-hint d-none js-msg-no-etape">
                                    <i class="ti ti-info-circle"></i> Aucune étape disponible.
                                </p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Catégorie</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-tag vt-cm-icon"></i>
                                    <select name="category_id" class="vt-cm-select js-add-categorie">
                                        <option value="">Toutes</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}"
                                                data-campagne-id="{{ $category->campagne_id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Présentation</label>
                                <div class="vt-cm-input-wrap top">
                                    <i class="ti ti-pencil vt-cm-icon"></i>
                                    <textarea class="vt-cm-input" name="description" rows="3" placeholder="Parcours, ambitions, points forts..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            {{-- Footer --}}
            <div class="vt-cand-modal-footer">
                <button type="button" class="vt-cm-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="form-add-candidat" class="vt-cm-btn-submit js-btn-save-candidat">
                    <i class="ti ti-check" style="font-size:13px;"></i> Confirmer
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Modification candidat --}}
<div class="modal fade vt-cand-modal" id="modal_edit_candidat" tabindex="-1" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:560px;">
        <div class="modal-content">

            {{-- Header gradient --}}
            <div class="vt-cand-modal-header">
                <div class="vt-cand-modal-icon">
                    <i class="ti ti-pencil"></i>
                </div>
                <h5 class="vt-cand-modal-title">Modifier le candidat</h5>
                <button type="button" class="vt-cand-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x" style="font-size:12px;"></i>
                </button>
            </div>

            <div class="modal-body">
                <form id="form_edit_candidat" action="{{ route('business.update_candidat') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="candidat_id">
                    <input type="hidden" name="old_photo">

                    {{-- Zone photo --}}
                    <div class="vt-cm-photo-zone image-upload-group">
                        <div class="vt-cm-avatar">
                            <i class="ti ti-user placeholder-target" style="font-size:20px; color:#94a3b8;"></i>
                            <img src="#" alt="" class="preview-target d-none">
                        </div>
                        <div class="vt-cm-photo-info">
                            <p class="vt-cm-photo-label">Photo du candidat <span class="text-danger">*</span></p>
                            <p class="vt-cm-photo-hint">JPG, PNG · Max 800K</p>
                        </div>
                        <label class="vt-cm-photo-btn">
                            <i class="ti ti-upload" style="font-size:12px;"></i> Choisir
                            <input type="file" name="photo" accept="image/*"
                                onchange="handleImagePreview(this)">
                        </label>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0 d-none remove-btn-target"
                            onclick="handleImageRemove(this)" style="font-size:11.5px;">
                            Supprimer
                        </button>
                    </div>

                    {{-- Section Identité --}}
                    <p class="vt-cm-section">Identité</p>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Nom complet <span class="text-danger">*</span></label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-user vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="name"
                                        placeholder="Ex : Marie Dupont" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Sexe</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-gender-bigender vt-cm-icon"></i>
                                    <select class="vt-cm-select" name="sexe">
                                        <option value="">Choisir</option>
                                        <option value="M">Masculin</option>
                                        <option value="F">Féminin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Date de naissance</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-calendar vt-cm-icon"></i>
                                    <input type="date" class="vt-cm-input" name="date_naissance">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Profession</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-briefcase vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="profession"
                                        placeholder="Ex : Styliste">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section Contact --}}
                    <p class="vt-cm-section">Contact</p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Téléphone</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-phone vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="telephone"
                                        placeholder="+225 ..." pattern="^\+?\d{10,15}$">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Email</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-mail vt-cm-icon"></i>
                                    <input type="email" class="vt-cm-input" name="email"
                                        placeholder="candidat@..."
                                        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Pays</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-map-pin vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="pays"
                                        placeholder="Ex : Côte d'Ivoire">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Ville</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-building-community vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="ville"
                                        placeholder="Ex : Abidjan">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section Candidature --}}
                    <p class="vt-cm-section">Candidature</p>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Session</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-calendar-event vt-cm-icon"></i>
                                    <input type="hidden" name="campagne_id" class="js-edit-campagne-hidden">
                                    <select class="vt-cm-select js-edit-campagne" disabled>
                                        <option value="">Sélectionner une session</option>
                                        @foreach ($campagnes as $item)
                                            @php($campagne = $item['campagne'] ?? null)
                                            @if ($campagne)
                                                <option value="{{ $campagne->campagne_id }}">{{ $campagne->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Étape</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-flag vt-cm-icon"></i>
                                    <input type="hidden" name="etape_id" class="js-edit-etape-hidden">
                                    <select class="vt-cm-select js-edit-etape" disabled>
                                        <option value="">Sélectionner</option>
                                        @foreach ($etapes as $etape)
                                            <option value="{{ $etape->etape_id }}"
                                                data-campagne-id="{{ $etape->campagne_id }}">
                                                {{ $etape->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="vt-cm-hint d-none js-msg-no-etape">
                                    <i class="ti ti-info-circle"></i> Aucune étape disponible.
                                </p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Catégorie</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-tag vt-cm-icon"></i>
                                    <input type="hidden" name="category_id" class="js-edit-categorie-hidden">
                                    <select name="category_id" class="vt-cm-select js-edit-categorie" disabled>
                                        <option value="">Toutes</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}"
                                                data-campagne-id="{{ $category->campagne_id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Présentation</label>
                                <div class="vt-cm-input-wrap top">
                                    <i class="ti ti-pencil vt-cm-icon"></i>
                                    <textarea class="vt-cm-input" name="description" rows="3" placeholder="Parcours, ambitions, points forts..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            {{-- Footer --}}
            <div class="vt-cand-modal-footer">
                <button type="button" class="vt-cm-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="form_edit_candidat" class="vt-cm-btn-submit">
                    <i class="ti ti-device-floppy" style="font-size:13px;"></i> Enregistrer
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Archiver candidat --}}
<div class="modal fade vt-cand-modal" id="delete_contact" tabindex="-1" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content">

            {{-- Header gradient --}}
            <div class="vt-cand-modal-header">
                <div class="vt-cand-modal-icon" style="background:rgba(239,68,68,.15); color:#ef4444;">
                    <i class="ti ti-trash"></i>
                </div>
                <h5 class="vt-cand-modal-title">Supprimer le candidat</h5>
                <button type="button" class="vt-cand-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x" style="font-size:12px;"></i>
                </button>
            </div>

            {{-- Corps --}}
            <form id="form_delete_candidat" action="{{ route('business.delete_candidat') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="candidat_id">

                <div class="modal-body text-center px-4 py-4">
                    <p class="mb-0" style="font-size:14px; color:#64748b;">
                        Êtes-vous sûr de vouloir archiver ce candidat ?<br>
                        {{-- <span style="font-size:12.5px; color:#94a3b8;">Cette action est irréversible.</span> --}}
                    </p>
                </div>

                {{-- Footer --}}
                <div class="vt-cand-modal-footer">
                    <button type="button" class="vt-cm-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="vt-cm-btn-submit"
                        style="background:#ef4444; box-shadow:0 4px 12px rgba(239,68,68,.25);">
                        <i class="ti ti-trash" style="font-size:13px;"></i> Oui, archiver
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- Activation candidat --}}
<div class="modal fade vt-cand-modal" id="activate_contact" tabindex="-1" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content">

            {{-- Header --}}
            <div class="vt-cand-modal-header">
                <div class="vt-cand-modal-icon" style="background:rgba(34,197,94,.15); color:#22c55e;">
                    <i class="ti ti-eye"></i>
                </div>
                <h5 class="vt-cand-modal-title">Activer le candidat</h5>
                <button type="button" class="vt-cand-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x" style="font-size:12px;"></i>
                </button>
            </div>

            {{-- Corps --}}
            <form id="form_activate_candidat" action="{{ route('business.activate_candidat') }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="candidat_id">

                <div class="modal-body text-center px-4 py-4">
                    <p class="mb-0" style="font-size:14px; color:#64748b;">
                        Êtes-vous sûr de vouloir activer ce candidat ?
                    </p>
                </div>

                {{-- Footer --}}
                <div class="vt-cand-modal-footer">
                    <button type="button" class="vt-cm-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="vt-cm-btn-submit"
                        style="background:#22c55e; box-shadow:0 4px 12px rgba(34,197,94,.25);">
                        <i class="ti ti-eye" style="font-size:13px;"></i> Oui, activer
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- Ajout catégorie --}}
<div class="modal fade vt-cand-modal" id="modal_add_categorie" tabindex="-1" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:480px;">
        <div class="modal-content">

            <div class="vt-cand-modal-header">
                <div class="vt-cand-modal-icon">
                    <i class="ti ti-plus"></i>
                </div>
                <h5 class="vt-cand-modal-title">Ajouter une catégorie</h5>
                <button type="button" class="vt-cand-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x" style="font-size:12px;"></i>
                </button>
            </div>

            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.save_categorie') }}" method="POST"
                    id="form-add-categorie">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Session</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-calendar-event vt-cm-icon"></i>
                                    <input type="hidden" name="campagne_id">
                                    <input type="text" class="vt-cm-input js-cat-campagne-label" readonly
                                        placeholder="Sélectionnez d'abord une session">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Nom de la catégorie <span
                                        class="text-danger">*</span></label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-tag vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="name"
                                        placeholder="Ex : Meilleure actrice" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Description</label>
                                <div class="vt-cm-input-wrap top">
                                    <i class="ti ti-pencil vt-cm-icon"></i>
                                    <textarea class="vt-cm-input" name="description" rows="3" placeholder="Décrivez cette catégorie..."></textarea>
                                </div>
                            </div>
                        </div>
                        {{-- Dans votre formulaire --}}
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Icône</label>
                                <div class="vt-cm-input-wrap" style="position: relative;">
                                    <input type="hidden" name="icon" id="add_iconInput"
                                        value="{{ old('icon') }}">
                                    <button type="button" class="ip-trigger" id="add_triggerBtn"
                                        onclick="iconPickerToggle('add')">
                                        <i class="ti ti-mood-smile" id="add_previewIcon"></i>
                                        <span id="add_triggerLabel" class="ip-trigger-label">Sélectionner une
                                            icône</span>
                                        <i class="ti ti-chevron-down" style="font-size:13px; color:#94a3b8;"></i>
                                    </button>
                                    <div class="ip-panel" id="add_panel" style="display:none;">
                                        <div class="ip-search-wrap">
                                            <input class="ip-search" id="add_searchInput"
                                                placeholder="Rechercher une icône..."
                                                oninput="iconPickerFilter('add')">
                                        </div>
                                        <div class="ip-cats" id="add_catsBar"></div>
                                        <div class="ip-grid" id="add_iconGrid"></div>
                                        <div class="ip-footer">
                                            <span class="ip-count" id="add_countLabel"></span>
                                            <button type="button" class="ip-confirm"
                                                onclick="iconPickerToggle('add')">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="vt-cand-modal-footer">
                <button type="button" class="vt-cm-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="form-add-categorie" class="vt-cm-btn-submit">
                    <i class="ti ti-check" style="font-size:13px;"></i> Confirmer
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Modification catégorie --}}
<div class="modal fade vt-cand-modal" id="modal_edit_categorie" tabindex="-1" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:480px;">
        <div class="modal-content">

            <div class="vt-cand-modal-header">
                <div class="vt-cand-modal-icon">
                    <i class="ti ti-pencil"></i>
                </div>
                <h5 class="vt-cand-modal-title">Modifier la catégorie</h5>
                <button type="button" class="vt-cand-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x" style="font-size:12px;"></i>
                </button>
            </div>

            <div class="modal-body">
                <form class="ajax-form" action="{{ route('business.update_categorie') }}" method="POST"
                    id="form-edit-categorie">
                    @csrf
                    <input type="hidden" name="category_id" id="edit_cat_id">
                    <input type="hidden" name="campagne_id" id="edit_cat_campagne_id">

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Nom de la catégorie <span
                                        class="text-danger">*</span></label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-tag vt-cm-icon"></i>
                                    <input type="text" class="vt-cm-input" name="name" id="edit_cat_name"
                                        placeholder="Ex : Meilleure actrice" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Description <span class="text-danger">*</span></label>
                                <div class="vt-cm-input-wrap top">
                                    <i class="ti ti-pencil vt-cm-icon"></i>
                                    <textarea class="vt-cm-input" name="description" id="edit_cat_description" rows="3"
                                        placeholder="Décrivez cette catégorie..." required></textarea>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Icône</label>
                                <div class="vt-cm-input-wrap">
                                    <i class="ti ti-mood-smile vt-cm-icon"></i>
                                    <select class="vt-cm-select" name="icon" id="edit_cat_icon">
                                        <option value="">Sélectionner</option>
                                        <option value="homme">Homme</option>
                                        <option value="femme">Femme</option>
                                        <option value="enfant">Enfant</option>
                                        <option value="jeune">Jeune</option>
                                    </select>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-12">
                            <div class="vt-cm-field">
                                <label class="vt-cm-label">Icône</label>
                                <div class="vt-cm-input-wrap" style="position: relative;">
                                    <input type="hidden" name="icon" id="edit_iconInput">
                                    <button type="button" class="ip-trigger" id="edit_triggerBtn"
                                        onclick="iconPickerToggle('edit')">
                                        <i class="ti ti-mood-smile" id="edit_previewIcon"></i>
                                        <span id="edit_triggerLabel" class="ip-trigger-label">Sélectionner une
                                            icône</span>
                                        <i class="ti ti-chevron-down" style="font-size:13px; color:#94a3b8;"></i>
                                    </button>
                                    <div class="ip-panel" id="edit_panel" style="display:none;">
                                        <div class="ip-search-wrap">
                                            <input class="ip-search" id="edit_searchInput"
                                                placeholder="Rechercher une icône..."
                                                oninput="iconPickerFilter('edit')">
                                        </div>
                                        <div class="ip-cats" id="edit_catsBar"></div>
                                        <div class="ip-grid" id="edit_iconGrid"></div>
                                        <div class="ip-footer">
                                            <span class="ip-count" id="edit_countLabel"></span>
                                            <button type="button" class="ip-confirm"
                                                onclick="iconPickerToggle('edit')">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="vt-cand-modal-footer">
                <button type="button" class="vt-cm-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="form-edit-categorie" class="vt-cm-btn-submit">
                    <i class="ti ti-device-floppy" style="font-size:13px;"></i> Enregistrer
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Suppression catégorie --}}
<div class="modal fade vt-cand-modal" id="modal_delete_categorie" tabindex="-1" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content">

            <div class="vt-cand-modal-header">
                <div class="vt-cand-modal-icon" style="background:rgba(239,68,68,.15); color:#ef4444;">
                    <i class="ti ti-trash"></i>
                </div>
                <h5 class="vt-cand-modal-title">Supprimer la catégorie</h5>
                <button type="button" class="vt-cand-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x" style="font-size:12px;"></i>
                </button>
            </div>

            <form id="form_delete_categorie" action="{{ route('business.delete_categorie') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="category_id" id="delete_cat_id">

                <div class="modal-body text-center px-4 py-4">
                    <p class="mb-0" style="font-size:14px; color:#64748b;">
                        Êtes-vous sûr de vouloir supprimer cette catégorie ?<br>
                        <span style="font-size:12.5px; color:#94a3b8;">Cette action est irréversible.</span>
                    </p>
                </div>

                <div class="vt-cand-modal-footer">
                    <button type="button" class="vt-cm-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="vt-cm-btn-submit"
                        style="background:#ef4444; box-shadow:0 4px 12px rgba(239,68,68,.25);">
                        <i class="ti ti-trash" style="font-size:13px;"></i> Supprimer
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
    <script>
        /* =====================================================
                               ICON PICKER — autonome, sans CDN
                               ===================================================== */
        const IP_ICONS = {
            "Interface": ["ti-home", "ti-search", "ti-settings", "ti-bell", "ti-star", "ti-heart", "ti-bookmark",
                "ti-lock", "ti-lock-open", "ti-eye", "ti-eye-off", "ti-edit", "ti-trash", "ti-copy", "ti-download",
                "ti-upload", "ti-share", "ti-link", "ti-filter", "ti-sort-ascending", "ti-sort-descending",
                "ti-refresh", "ti-x", "ti-check", "ti-plus", "ti-minus", "ti-dots", "ti-dots-vertical", "ti-menu-2",
                "ti-layout-grid", "ti-list", "ti-info-circle", "ti-alert-circle", "ti-circle-check", "ti-circle-x",
                "ti-help-circle", "ti-zoom-in", "ti-zoom-out", "ti-adjustments"
            ],
            "Personnes": ["ti-user", "ti-users", "ti-user-plus", "ti-user-minus", "ti-user-check", "ti-user-x",
                "ti-mood-smile", "ti-mood-happy", "ti-mood-sad", "ti-mood-neutral", "ti-crown", "ti-medal",
                "ti-award", "ti-badge", "ti-id-badge", "ti-man", "ti-woman", "ti-baby-carriage"
            ],
            "Communication": ["ti-mail", "ti-message", "ti-message-2", "ti-messages", "ti-phone", "ti-phone-call",
                "ti-send", "ti-inbox", "ti-at", "ti-speakerphone", "ti-bell-ringing", "ti-message-dots"
            ],
            "Business": ["ti-briefcase", "ti-chart-bar", "ti-chart-pie", "ti-chart-line", "ti-trending-up",
                "ti-trending-down", "ti-report", "ti-cash", "ti-credit-card", "ti-receipt", "ti-building",
                "ti-building-store", "ti-presentation", "ti-clipboard", "ti-file", "ti-file-text", "ti-notes",
                "ti-calendar", "ti-clock", "ti-calculator"
            ],
            "Médias": ["ti-photo", "ti-camera", "ti-video", "ti-music", "ti-microphone", "ti-headphones", "ti-volume",
                "ti-volume-off", "ti-player-play", "ti-player-pause", "ti-player-stop", "ti-film", "ti-playlist",
                "ti-movie", "ti-radio"
            ],
            "Nature": ["ti-leaf", "ti-plant", "ti-tree", "ti-flower", "ti-sun", "ti-moon", "ti-cloud-rain",
                "ti-snowflake", "ti-wind", "ti-flame", "ti-droplet", "ti-mountain", "ti-world"
            ],
            "Transports": ["ti-car", "ti-bus", "ti-bicycle", "ti-plane", "ti-ship", "ti-rocket", "ti-train", "ti-truck",
                "ti-motorbike", "ti-walk", "ti-run", "ti-map", "ti-map-pin", "ti-compass", "ti-route"
            ],
            "Sport": ["ti-ball-football", "ti-ball-basketball", "ti-ball-tennis", "ti-ball-volleyball", "ti-swimming",
                "ti-yoga", "ti-dumbbell", "ti-trophy", "ti-medal-2", "ti-target"
            ],
            "Technologie": ["ti-device-laptop", "ti-device-mobile", "ti-device-tablet", "ti-device-desktop", "ti-cpu",
                "ti-wifi", "ti-cloud", "ti-code", "ti-terminal", "ti-database", "ti-server", "ti-api", "ti-robot",
                "ti-git-branch"
            ],
        };

        const IP_ALL_CATS = ["Tout", ...Object.keys(IP_ICONS)];
        let IP_STATE = {
            add: {
                selected: '',
                activeCat: 'Tout',
                open: false
            },
            edit: {
                selected: '',
                activeCat: 'Tout',
                open: false
            },
        };

        function ipAllIcons() {
            return Object.values(IP_ICONS).flat();
        }

        function ipGetFiltered(ns) {
            const state = IP_STATE[ns];
            const term = document.getElementById(ns + '_searchInput').value.toLowerCase().trim();
            const base = state.activeCat === 'Tout' ? ipAllIcons() : (IP_ICONS[state.activeCat] || []);
            return term ? base.filter(ic => ic.replace('ti-', '').includes(term)) : base;
        }

        function ipRenderCats(ns) {
            const bar = document.getElementById(ns + '_catsBar');
            bar.innerHTML = IP_ALL_CATS.map(cat =>
                `<span class="ip-cat${IP_STATE[ns].activeCat === cat ? ' active' : ''}"
               onclick="ipSetCat('${ns}','${cat}')">${cat}</span>`
            ).join('');
        }

        function ipRenderGrid(ns) {
            const grid = document.getElementById(ns + '_iconGrid');
            const icons = ipGetFiltered(ns);
            const sel = IP_STATE[ns].selected;
            document.getElementById(ns + '_countLabel').textContent =
                icons.length + ' icône' + (icons.length > 1 ? 's' : '');

            if (!icons.length) {
                grid.innerHTML = '<div class="ip-empty">Aucune icône trouvée</div>';
                return;
            }
            grid.innerHTML = icons.map(ic =>
                `<button type="button" class="ip-icon-btn${sel === ic ? ' selected' : ''}"
                 onclick="ipSelectIcon('${ns}','${ic}')" title="${ic.replace('ti-','')}">
             <i class="ti ${ic}"></i>
         </button>`
            ).join('');
        }

        function ipSetCat(ns, cat) {
            IP_STATE[ns].activeCat = cat;
            ipRenderCats(ns);
            ipRenderGrid(ns);
        }

        function ipSelectIcon(ns, ic) {
            IP_STATE[ns].selected = ic;
            document.getElementById(ns + '_iconInput').value = ic;

            const prev = document.getElementById(ns + '_previewIcon');
            const label = document.getElementById(ns + '_triggerLabel');
            prev.className = 'ti ' + ic;
            prev.style.color = 'var(--vt-orange)';
            label.textContent = ic.replace('ti-', '');
            label.className = 'ip-trigger-selected';

            ipRenderGrid(ns);
        }

        function iconPickerToggle(ns) {
            // Ferme l'autre picker si ouvert
            const other = ns === 'add' ? 'edit' : 'add';
            if (IP_STATE[other].open) {
                IP_STATE[other].open = false;
                document.getElementById(other + '_panel').style.display = 'none';
            }

            IP_STATE[ns].open = !IP_STATE[ns].open;
            const panel = document.getElementById(ns + '_panel');
            panel.style.display = IP_STATE[ns].open ? 'block' : 'none';

            if (IP_STATE[ns].open) {
                ipRenderCats(ns);
                ipRenderGrid(ns);
                setTimeout(() => document.getElementById(ns + '_searchInput').focus(), 50);
            }
        }

        function iconPickerFilter(ns) {
            ipRenderGrid(ns);
        }

        // Ferme le picker si clic hors du composant
        document.addEventListener('click', function(e) {
            ['add', 'edit'].forEach(ns => {
                if (!IP_STATE[ns].open) return;
                const wrap = document.getElementById(ns + '_panel');
                const btn = document.getElementById(ns + '_triggerBtn');
                if (wrap && !wrap.contains(e.target) && btn && !btn.contains(e.target)) {
                    IP_STATE[ns].open = false;
                    wrap.style.display = 'none';
                }
            });
        });

        $(document).ready(function() {

            /* =========================================================
               1. ÉTAT & CONSTANTES
               ========================================================= */
            let currentPage = 1;
            let searchTimeout = null;
            let afficherMontantPourcentage = null;
            const APP_IMAGES_PATH = "{{ env('IMAGES_PATH') }}/";

            /* =========================================================
               2. CLONES DOM (tous regroupés ici)
               ========================================================= */
            const $allEtapesOptions = $('.js-select-etape option').clone();
            const $allCategoriesOptions = $('.js-select-categorie option').clone();
            const $formCategoriesOptions = $('.js-add-categorie option').clone();

            /* =========================================================
               3. UTILITAIRES PURS
               ========================================================= */

            /**
             * Calcule l'âge à partir d'une date de naissance (string ISO).
             * Retourne '' si la date est absente.
             */
            function calculerAge(dateNaissanceStr) {
                if (!dateNaissanceStr) return '';
                const today = new Date();
                const naissance = new Date(dateNaissanceStr);
                let age = today.getFullYear() - naissance.getFullYear();
                const m = today.getMonth() - naissance.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < naissance.getDate())) age--;
                return age;
            }

            /**
             * Remet la pagination à 1 et recharge les candidats.
             * Utilisé par tous les filtres (étape, catégorie, recherche).
             */
            function resetEtRecharger() {
                currentPage = 1;
                chargerCandidats(false);
            }

            /* =========================================================
               4. UI HELPERS
               ========================================================= */

            /**
             * Active / désactive le bouton "Créer un candidat"
             * selon la présence d'une campagne ET d'une étape sélectionnées.
             */
            function updateCreateBtn() {
                const campagneId = $('.js-select-campagne').val();
                const etapeId = $('.js-select-etape').val();
                const $btn = $('.js-btn-create-candidat');

                const actif = !!(campagneId && etapeId);
                $btn.toggleClass('disabled', !actif)
                    .css({
                        'pointer-events': actif ? '' : 'none',
                        'opacity': actif ? '' : '0.5'
                    });
            }

            /**
             * Remplit les selects de filtres (étapes + catégories sidebar)
             * selon la campagne choisie.
             */
            function peuplerFiltresCampagne(campagneId) {
                const $selectEtape = $('.js-select-etape');
                const $selectCategorie = $('.js-select-categorie');

                $selectEtape.empty().prop('disabled', true)
                    .append('<option value="">Toutes les étapes</option>');
                $selectCategorie.empty().prop('disabled', true)
                    .append('<option value="">Toutes les catégories</option>');

                if (!campagneId) return;

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
            }

            /**
             * Met à jour la section catégories dans la sidebar
             * (affichage, filtrage des items, titre, bouton ajout).
             */
            function mettreAJourSectionCategories(campagneId, campagneName) {
                if (!campagneId) {
                    $('.js-cat-section').hide();
                    $('.js-cat-add-btn').prop('disabled', true).addClass('disabled');
                    return;
                }

                $('.js-cat-section').show();
                $('.js-cat-item').each(function() {
                    $(this).toggle($(this).data('campagne-id') == campagneId);
                });
                $('.js-cat-add-btn').prop('disabled', false).removeClass('disabled');
                $('.js-cat-heading').text('Catégories — ' + campagneName);
            }

            /**
             * Pré-remplit la modale "Ajouter une catégorie"
             * avec les infos de la campagne sélectionnée.
             */
            function syncModalAjoutCategorie(campagneId, campagneName) {
                $('#modal_add_categorie input[name="campagne_id"]').val(campagneId);
                $('#modal_add_categorie .js-cat-campagne-label').val(campagneName);
            }

            /**
             * Pré-remplit le formulaire d'ajout de candidat
             * avec la campagne et l'étape courantes.
             */
            function syncFormAjoutCandidat(campagneId) {
                // Le trigger('change') sur .js-add-campagne
                // déclenche automatiquement le peuplement du select catégorie
                $('.js-add-campagne-hidden').val(campagneId);
                $('.js-add-campagne').val(campagneId).trigger('change');
            }

            /**
             * Construit le bloc HTML d'une photo de candidat
             * (image réelle ou initiale de remplacement).
             */
            function buildPhotoHtml(candidat) {
                if (candidat.photo) {
                    const photoUrl = APP_IMAGES_PATH + candidat.photo;
                    return `<img src="${photoUrl}" alt="${candidat.name}">`;
                }
                const initiale = candidat.name ? candidat.name.charAt(0).toUpperCase() : '?';
                return `<div class="vt-cand-no-photo">${initiale}</div>`;
            }

            /**
             * Construit le HTML complet d'une carte candidat.
             * Extrait de renderCandidatCards pour garder cette dernière lisible.
             */
            function buildVotesHtml(candidat) {
                const votes = candidat.votes_count || 0;
                const percentage = candidat.vote_percentage || 0;
                const label = `vote${votes > 1 ? 's' : ''}`;

                if (afficherMontantPourcentage === 'pourcentage') {
                    return `
                        <div class="vt-cand-votes">
                            <i class="ti ti-chart-pie"></i>
                            <span>${percentage}%</span>
                        </div>`;

                } else if (afficherMontantPourcentage === 'clair') {
                    return `
                        <div class="vt-cand-votes">
                            <i class="ti ti-ticket"></i>
                            <span>${votes}</span>
                            <span class="label">${label}</span>
                        </div>`;

                } else {
                    // Les deux
                    return `
                <div class="vt-cand-votes">
                    <i class="ti ti-ticket"></i>
                    <span>${votes}</span>
                    <span class="label">${label}</span>
                    <span class="vt-cand-votes-separator">/</span>
                    <i class="ti ti-chart-pie"></i>
                    <span>${percentage}%</span>
                </div>`;
                }
            }

            function buildCardHtml(candidat, orderNum) {
                const data = encodeURIComponent(JSON.stringify(candidat));
                const age = calculerAge(candidat.date_naissance);
                const photoHtml = buildPhotoHtml(candidat);

                return `
                <div class="col-xxl-3 col-xl-3 col-md-6 col-sm-6">
                    <div class="vt-cand-card">

                        <div class="vt-cand-photo-wrap">
                            ${photoHtml}
                            <span class="vt-cand-num"># ${candidat.numero_candidat}</span>
                            <div class="vt-cand-menu dropdown">
                                <button class="vt-cand-menu-btn" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item js-btn-edit" href="javascript:void(0);" data-candidat="${data}">
                                        <i class="ti ti-edit me-1"></i> Modifier
                                    </a>
                                    ${candidat.is_active == 1
                                        ? `<a class="dropdown-item js-btn-delete" href="javascript:void(0);" data-id="${candidat.candidat_id}">
                                            <i class="ti ti-eye me-1" style="color:#22c55e;"></i> Archiver
                                        </a>`
                                        : `<a class="dropdown-item js-btn-activate" href="javascript:void(0);" data-id="${candidat.candidat_id}">
                                            <i class="ti ti-eye-off me-1" style="color:#ef4444;"></i> Activer
                                        </a>`
                                    }
                                    
                                </div>
                            </div>
                        </div>

                        <div class="vt-cand-body">
                            <p class="vt-cand-name" title="${candidat.name}">${candidat.name}</p>
                            <div class="vt-cand-meta">
                                ${age       ? `<span class="vt-cand-meta-item"><i class="ti ti-calendar"></i>${age} ans</span>`           : ''}
                                ${candidat.profession ? `<span class="vt-cand-meta-item"><i class="ti ti-briefcase"></i>${candidat.profession}</span>` : ''}
                            </div>
                        </div>

                        <div class="vt-cand-footer">
                            <!--Affichage conditionnel des votes -->
                            ${buildVotesHtml(candidat)}
                            <div class="vt-cand-actions">
                                <a href="javascript:void(0);" class="vt-cand-action-btn edit js-btn-edit"
                                   data-candidat="${data}" title="Modifier">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                ${candidat.is_active == 1
                                    ? `<a href="javascript:void(0);" class="vt-cand-action-btn del js-btn-delete"
                                                    data-id="${candidat.candidat_id}" title="Archiver">
                                                    <i class="ti ti-eye" style="color:#22c55e;"></i>
                                                </a>`
                                    : `<a href="javascript:void(0);" class="vt-cand-action-btn js-btn-activate"
                                                    data-id="${candidat.candidat_id}" title="Activer">
                                                    <i class="ti ti-eye-off" style="color:#ef4444;"></i>
                                                </a>`
                                }
                            </div>
                        </div>

                    </div>
                </div>`;
            }

            /* =========================================================
               5. AJAX
               ========================================================= */

            /**
             * Charge (ou ajoute) les candidats via AJAX selon les filtres actifs.
             * @param {boolean} append  true = "load more", false = nouveau chargement
             */
            function chargerCandidats(append = false) {
                const params = {
                    campagne_id: $('.js-select-campagne').val(),
                    etape_id: $('.js-select-etape').val(),
                    category_id: $('.js-select-categorie').val(),
                    search: $('.js-search-candidat').val(),
                    page: currentPage,
                };

                if (!append) {
                    $('.js-candidat-table-body').html(
                        '<div class="col-12 text-center p-5"><div class="spinner-border text-primary"></div></div>'
                    );
                }

                $.ajax({
                    url: '/business/recherche_candidat',
                    method: 'GET',
                    data: params,
                    success: function(response) {
                        renderCandidatCards(response.data, append);

                        if (response.current_page < response.last_page) {
                            const shown = response.current_page * (response.data?.length || 0);
                            $('.js-load-more').html(
                                `<i class="ti ti-refresh" style="font-size:14px;"></i> Charger plus (${shown} / ${response.total})`
                            );
                            $('.load-btn').show();
                        } else {
                            $('.load-btn').hide();
                        }
                    },
                });
            }

            /**
             * Injecte les cartes candidats dans le DOM.
             * Délègue la construction HTML à buildCardHtml().
             */
            function renderCandidatCards(candidats, append) {
                if (candidats.length === 0 && !append) {
                    $('.js-candidat-table-body').html(`
                        <div class="col-12">
                            <div class="vt-candidat-empty">
                                <i class="ti ti-users" style="font-size:32px; display:block; margin-bottom:8px; opacity:.3;"></i>
                                Aucun candidat trouvé.
                            </div>
                        </div>`);
                    return;
                }

                const html = candidats.map((candidat, index) => {
                    const orderNum = ((currentPage - 1) * 12) + (index + 1);
                    return buildCardHtml(candidat, orderNum);
                }).join('');

                if (append) $('.js-candidat-table-body').append(html);
                else $('.js-candidat-table-body').html(html);
            }

            /* =========================================================
               6. ÉVÉNEMENTS — FILTRES SIDEBAR
               ========================================================= */

            /* Changement de campagne : cascade complète */
            $('.js-select-campagne').on('change', function() {
                const campagneId = $(this).val();
                const campagneName = $('.js-select-campagne option:selected').text().trim();

                peuplerFiltresCampagne(campagneId);
                mettreAJourSectionCategories(campagneId, campagneName);

                if (campagneId) {
                    syncModalAjoutCategorie(campagneId, campagneName);
                    syncFormAjoutCandidat(campagneId);
                }

                resetEtRecharger();
                updateCreateBtn();
            });

            /* Changement d'étape : sync modale + rechargement */
            $(document).on('change', '.js-select-etape', function() {
                const etapeId = $(this).val();
                $('.js-add-etape-hidden').val(etapeId);
                $('.js-add-etape').val(etapeId);

                resetEtRecharger();
                updateCreateBtn();
            });

            /* Changement de catégorie : rechargement simple */
            $(document).on('change', '.js-select-categorie', resetEtRecharger);

            /* Recherche avec debounce */
            $(document).on('keyup', '.js-search-candidat', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(resetEtRecharger, 500);
            });

            /* Load more */
            $(document).on('click', '.js-load-more', function() {
                currentPage++;
                chargerCandidats(true);
            });

            /* =========================================================
               7. ÉVÉNEMENTS — CASCADE FORMULAIRE D'AJOUT
               ========================================================= */

            /* Sélection campagne dans la modale → peuple les catégories */
            $(document).on('change', '.js-add-campagne', function() {
                const campagneId = $(this).val();
                const $selectCat = $('.js-add-categorie');

                $selectCat.empty().prop('disabled', true)
                    .append('<option value="">Sélectionner</option>');
                $('.js-btn-save-candidat').prop('disabled', false);

                if (campagneId) {
                    $formCategoriesOptions.each(function() {
                        if ($(this).data('campagne-id') == campagneId)
                            $selectCat.append($(this).clone());
                    });
                    $selectCat.prop('disabled', false);
                }
            });

            /* =========================================================
               8. ÉVÉNEMENTS — MODALES (ouverture / pré-remplissage)
               ========================================================= */

            /* Ouvrir modale édition candidat */
            $(document).on('click', '.js-btn-edit', function() {
                const data = JSON.parse(decodeURIComponent($(this).data('candidat')));
                const $modal = $('#modal_edit_candidat');

                /* Champs texte / select */
                const champs = ['candidat_id', 'name', 'date_naissance', 'telephone',
                    'email', 'pays', 'ville', 'profession'
                ];
                champs.forEach(champ => $modal.find(`[name="${champ}"]`).val(data[champ]));
                $modal.find('[name="old_photo"]').val(data.photo);
                $modal.find('select[name="sexe"]').val(data.sexe);
                $modal.find('textarea[name="description"]').val(data.description);

                /* Candidature — pré-remplir Session / Étape / Catégorie */
                $modal.find('.js-edit-campagne-hidden').val(data.campagne_id);
                $modal.find('.js-edit-campagne').val(data.campagne_id);
                $modal.find('.js-edit-etape-hidden').val(data.etape_id);
                $modal.find('.js-edit-etape').val(data.etape_id);
                $modal.find('.js-edit-categorie').val(data.category_id);
                $modal.find('.js-edit-categorie-hidden').val(data.category_id);

                /* Aperçu photo */
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

            /* Ouvrir modale archiver candidat */
            $(document).on('click', '.js-btn-delete', function() {
                $('#delete_contact').find('input[name="candidat_id"]').val($(this).data('id'));
                $('#delete_contact').modal('show');
            });
            /* Ouvrir modale activer candidat */
            $(document).on('click', '.js-btn-activate', function() {
                $('#activate_contact').find('input[name="candidat_id"]').val($(this).data('id'));
                $('#activate_contact').modal('show');
            });

            /* Pré-remplir modale édition catégorie */
            $(document).on('click', '.js-btn-edit-cat', function() {
                const $btn = $(this);
                $('#edit_cat_id').val($btn.data('id'));
                $('#edit_cat_campagne_id').val($btn.data('campagne_id'));
                $('#edit_cat_name').val($btn.data('name'));
                $('#edit_cat_description').val($btn.data('description'));
                //Pré-remplit le icon picker
                const savedIcon = $btn.data('icon');
                if (savedIcon) {
                    ipSelectIcon('edit', savedIcon);
                } else {
                    IP_STATE['edit'].selected = '';
                    document.getElementById('edit_iconInput').value = '';
                    document.getElementById('edit_previewIcon').className = 'ti ti-mood-smile';
                    document.getElementById('edit_previewIcon').style.color = '';
                    document.getElementById('edit_triggerLabel').textContent = 'Sélectionner une icône';
                    document.getElementById('edit_triggerLabel').className = 'ip-trigger-label';
                }
            });

            /* Pré-remplir modale suppression catégorie */
            $(document).on('click', '.js-btn-delete-cat', function() {
                $('#delete_cat_id').val($(this).data('id'));
            });

            /* =========================================================
               9. ÉVÉNEMENTS — SOUMISSIONS AJAX (formulaires)
               ========================================================= */

            /**
             * Soumission générique via AJAX avec FormData.
             * Gère le spinner, les erreurs 422 et le callback post-succès.
             *
             * @param {jQuery}   $form
             * @param {string}   loadingLabel   Texte affiché sur le bouton pendant le chargement
             * @param {string}   originalLabel  Texte restauré après la requête
             * @param {Function} onSuccess      Callback appelé avec la réponse en cas de succès
             */
            function soumettreFormAjax($form, loadingLabel, originalLabel, onSuccess) {
                const $submitBtn = $form.find('button[type="submit"]');

                // Reset erreurs précédentes
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();

                $submitBtn.prop('disabled', true).html(loadingLabel);

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: new FormData($form[0]),
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        onSuccess(response);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            if (typeof showAjaxAlert === 'function')
                                showAjaxAlert('danger', 'Veuillez vérifier les champs du formulaire.');

                            $.each(xhr.responseJSON.errors, function(fieldName, messages) {
                                let $input = $form.find(
                                    `[name="${fieldName}"], [name="${fieldName}[]"]`
                                ).first();

                                if ($input.length > 0) {
                                    $input.addClass('is-invalid');
                                    const errorMsg =
                                        `<div class="invalid-feedback d-block" style="color:#dc3545;font-size:11.5px;margin-top:5px;">${messages[0]}</div>`;

                                    if ($input.closest('.vt-cm-input-wrap').length) {
                                        $input.closest('.vt-cm-input-wrap').after(errorMsg);
                                    } else if ($input.closest('.vt-input-wrap').length) {
                                        $input.closest('.vt-input-wrap').after(errorMsg);
                                    } else if ($input.closest('.input-group').length) {
                                        $input.closest('.input-group').after(errorMsg);
                                    } else if ($input.attr('type') === 'file' && $input.closest(
                                            '.image-upload-group').length) {
                                        $input.closest('.image-upload-group').after(errorMsg);
                                    } else {
                                        $input.after(errorMsg);
                                    }
                                }
                            });

                            $form.find('.is-invalid').first().focus();

                        } else {
                            if (typeof showAjaxAlert === 'function')
                                showAjaxAlert('danger', xhr.responseJSON?.message ||
                                    'Une erreur est survenue.');
                        }
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).html(originalLabel);
                    },
                });
            }

            /* Ajout candidat */
            $('#form-add-candidat').on('submit', function(e) {
                e.preventDefault();
                soumettreFormAjax(
                    $(this),
                    '<span class="spinner-border spinner-border-sm me-1"></span> Traitement...',
                    '<i class="ti ti-check" style="font-size:13px;"></i> Confirmer',
                    function(response) {
                        $('#modal_add_candidat').modal('hide');
                        if (response.success && typeof showAjaxAlert === 'function')
                            showAjaxAlert('success', response.message);
                        // Recharge uniquement les candidats sans toucher aux filtres
                        resetEtRecharger();
                    }
                );
            });

            /* Édition candidat */
            $('#form_edit_candidat').on('submit', function(e) {
                e.preventDefault();
                soumettreFormAjax(
                    $(this),
                    'Mise à jour...',
                    $(this).find('button[type="submit"]').html(),
                    function(response) {
                        $('#modal_edit_candidat').modal('hide');
                        if (response.success && typeof showAjaxAlert === 'function')
                            showAjaxAlert('success', response.message);
                        $('.js-select-campagne').trigger('change');
                    }
                );
            });

            /* Archiver candidat */
            $('#form_delete_candidat').on('submit', function(e) {
                e.preventDefault();
                soumettreFormAjax(
                    $(this),
                    '<span class="spinner-border spinner-border-sm"></span>',
                    'Oui, archiver',
                    function(response) {
                        $('#delete_contact').modal('hide');
                        if (response.success && typeof showAjaxAlert === 'function')
                            showAjaxAlert('success', response.message);
                        $('.js-select-campagne').trigger('change');
                    }
                );
            });
            /* Activer candidat */
            $('#form_activate_candidat').on('submit', function(e) {
                e.preventDefault();
                soumettreFormAjax(
                    $(this),
                    '<span class="spinner-border spinner-border-sm"></span>',
                    'Oui, activer',
                    function(response) {
                        $('#activate_contact').modal('hide');
                        if (response.success && typeof showAjaxAlert === 'function')
                            showAjaxAlert('success', response.message);
                        $('.js-select-campagne').trigger('change');
                    }
                );

            });

        });
    </script>
@endsection
