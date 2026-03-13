@extends('refont.layout.app')

@section('title', 'Paramètres du compte')

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li><a href="{{ route('business.espace') }}"><i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil</a></li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li><a href="{{ route('business.list_retrait') }}">Retraits</a></li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li class="active">Paramètres</li>
@endsection

{{-- ===== CSS SPÉCIFIQUE ===== --}}
@section('extra-css')
    <style>
        /* ---- En-tête page ---- */
        .vt-profile-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .vt-profile-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--vt-text-main);
            margin: 0 0 4px;
            letter-spacing: -.4px;
        }

        .vt-profile-subtitle {
            font-size: 13px;
            color: var(--vt-text-muted);
            margin: 0;
        }

        .vt-btn-accueil {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1.5px solid var(--vt-border);
            border-radius: 50px;
            padding: 7px 16px;
            background: #fff;
            color: var(--vt-text-main);
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: all .15s;
            flex-shrink: 0;
        }

        .vt-btn-accueil:hover {
            border-color: #94a3b8;
            color: var(--vt-text-main);
        }

        /* ---- Conteneur principal (tabs + content) ---- */
        .vt-profile-container {
            background: #fff;
            border-radius: var(--vt-radius);
            box-shadow: var(--vt-shadow);
            display: flex;
            overflow: hidden;
            min-height: 500px;
        }

        /* ---- Sidebar tabs ---- */
        .vt-profile-tabs {
            width: 200px;
            flex-shrink: 0;
            padding: 18px 12px;
            border-right: 1px solid var(--vt-border);
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .vt-tab-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: var(--vt-radius-sm);
            border: none;
            background: transparent;
            color: var(--vt-text-muted);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-align: left;
            width: 100%;
            transition: all .15s;
        }

        .vt-tab-btn i {
            font-size: 16px;
            flex-shrink: 0;
        }

        .vt-tab-btn:hover {
            background: var(--vt-page-bg);
            color: var(--vt-text-main);
        }

        .vt-tab-btn.active {
            background: var(--vt-orange-light);
            color: var(--vt-orange);
            font-weight: 600;
        }

        .vt-tab-btn.active i {
            color: var(--vt-orange);
        }

        /* ---- Contenu de l'onglet ---- */
        .vt-profile-content {
            flex: 1;
            padding: 28px 32px;
            display: none;
        }

        .vt-profile-content.active {
            display: block;
        }

        /* ---- En-tête de section ---- */
        .vt-section-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--vt-text-main);
            margin: 0 0 4px;
        }

        .vt-section-desc {
            font-size: 13px;
            color: var(--vt-text-muted);
            margin: 0 0 24px;
        }

        /* ---- Séparateur de groupe ---- */
        .vt-field-group-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .7px;
            text-transform: uppercase;
            color: var(--vt-text-muted);
            margin-bottom: 14px;
            margin-top: 4px;
        }

        /* ---- Champs de formulaire custom ---- */
        .vt-field {
            margin-bottom: 16px;
        }

        .vt-field label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: var(--vt-text-muted);
            margin-bottom: 5px;
        }

        .vt-input-wrap {
            position: relative;
        }

        .vt-input-wrap .vt-inp-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
            z-index: 1;
        }

        .vt-input-wrap .vt-inp-icon-select {
            /* pour les selects on laisse la place à droite aussi */
        }

        .vt-input {
            width: 100%;
            padding: 9px 12px 9px 36px;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            font-size: 13px;
            color: var(--vt-text-main);
            background: #fff;
            transition: border-color .15s;
        }

        .vt-input:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        .vt-select {
            width: 100%;
            padding: 9px 36px 9px 36px;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            font-size: 13px;
            color: var(--vt-text-main);
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center / 15px;
            appearance: none;
            cursor: pointer;
            transition: border-color .15s;
        }

        /* État erreur */
        .vt-input.is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15) !important;
        }

        /* Message d'erreur placé après .vt-input-wrap */
        .vt-input-wrap+.invalid-feedback,
        .vt-field .invalid-feedback {
            display: block !important;
            color: #dc3545;
            font-size: 11.5px;
            margin-top: 5px;
        }

        .vt-select:focus {
            outline: none;
            border-color: var(--vt-orange);
        }

        /* ---- Logo upload (onglet Entreprise) ---- */
        .vt-logo-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .vt-logo-avatar {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: #fde8cc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            color: var(--vt-orange);
            flex-shrink: 0;
            overflow: hidden;
            position: relative;
        }

        .vt-logo-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .vt-logo-info {
            flex: 1;
        }

        .vt-logo-name {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--vt-text-main);
        }

        .vt-logo-hint {
            font-size: 11px;
            color: var(--vt-text-muted);
        }

        .vt-logo-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .vt-btn-upload {
            background: #7c3aed;
            color: #fff;
            border: none;
            border-radius: var(--vt-radius-sm);
            padding: 8px 16px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            position: relative;
            overflow: hidden;
        }

        .vt-btn-upload:hover {
            background: #6d28d9;
        }

        .vt-btn-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .vt-btn-del-logo {
            width: 34px;
            height: 34px;
            border: 1px solid #fca5a5;
            border-radius: var(--vt-radius-sm);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #dc2626;
            cursor: pointer;
            transition: all .15s;
            flex-shrink: 0;
        }

        .vt-btn-del-logo:hover {
            background: #fff5f5;
        }

        /* Bouton Enregistrer orange */
        .vt-btn-save {
            background: var(--vt-orange);
            color: #fff;
            border: none;
            border-radius: var(--vt-radius-sm);
            padding: 10px 24px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
        }

        .vt-btn-save:hover {
            background: var(--vt-orange-hover);
        }

        /* ---- Comptes de retrait cards ---- */
        .vt-retrait-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .vt-retrait-list-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--vt-text-muted);
            margin-bottom: 14px;
        }

        .vt-comptes-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 16px;
        }

        .vt-compte-card {
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            padding: 12px 12px 10px;
            background: #fff;
            position: relative;
            transition: box-shadow .15s;
        }

        .vt-compte-card:hover {
            box-shadow: var(--vt-shadow);
        }

        .vt-compte-close {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 20px;
            height: 20px;
            font-size: 12px;
            color: #94a3b8;
            cursor: pointer;
            border: none;
            background: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color .15s;
        }

        .vt-compte-close:hover {
            color: #dc2626;
        }

        .vt-compte-top {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .vt-compte-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            overflow: hidden;
            flex-shrink: 0;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vt-compte-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .vt-compte-name {
            font-size: 12px;
            font-weight: 700;
            color: var(--vt-text-main);
            text-transform: uppercase;
        }

        .vt-compte-number {
            font-size: 13px;
            font-weight: 700;
            color: var(--vt-text-main);
            letter-spacing: .5px;
        }

        .vt-retrait-astuce {
            font-size: 12px;
            color: var(--vt-text-muted);
            font-style: italic;
            margin-top: 4px;
        }

        /* ---- Profil note ---- */
        .vt-profile-note {
            font-size: 12px;
            color: var(--vt-orange);
            margin: 8px 0 16px;
        }

        /* ---- Footer intérieur ---- */
        .vt-profile-inner-footer {
            border-top: 1px solid var(--vt-border);
            margin-top: 28px;
            padding-top: 14px;
            text-align: center;
            font-size: 11px;
            color: #cbd5e1;
        }

        @media (max-width: 700px) {
            .vt-profile-container {
                flex-direction: column;
            }

            .vt-profile-tabs {
                width: 100%;
                flex-direction: row;
                border-right: none;
                border-bottom: 1px solid var(--vt-border);
            }

            .vt-comptes-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .vt-profile-content {
                padding: 20px 16px;
            }
        }

        @media (max-width: 480px) {
            .vt-comptes-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ================================================================
           MODAL AJOUTER UN COMPTE RETRAIT — design "Demande de retrait"
           ================================================================ */
        #add_bank .modal-content {
            border: none; border-radius: 16px; overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,.18);
        }
        .vt-acr-header {
            display: flex; align-items: center; gap: 14px;
            padding: 22px 24px 18px;
            background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);
            border-bottom: 1px solid #f0e6d8;
        }
        .vt-acr-icon {
            width: 40px; height: 40px; flex-shrink: 0;
            background: var(--vt-orange-light); border: 1.5px solid var(--vt-orange-border);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--vt-orange); font-size: 18px;
        }
        .vt-acr-title {
            font-size: 17px; font-weight: 700; color: var(--vt-text-main);
            margin: 0; flex: 1;
        }
        .vt-acr-close {
            width: 30px; height: 30px; border-radius: 50%;
            border: 1.5px solid var(--vt-border); background: #fff;
            display: flex; align-items: center; justify-content: center;
            color: var(--vt-text-muted); font-size: 13px;
            cursor: pointer; transition: all .15s; flex-shrink: 0;
        }
        .vt-acr-close:hover { background: #f1f5f9; border-color: #94a3b8; color: var(--vt-text-main); }

        #add_bank .modal-body { padding: 20px 24px 4px; }

        .vt-acr-field { margin-bottom: 14px; }
        .vt-acr-label {
            font-size: 11px; font-weight: 600; color: var(--vt-text-muted);
            margin-bottom: 5px; display: block; letter-spacing: .3px;
        }
        .vt-acr-input-wrap { position: relative; }
        .vt-acr-field-icon {
            position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 14px; pointer-events: none; z-index: 1;
        }
        .vt-acr-input {
            width: 100%; padding: 9px 12px 9px 34px;
            border: 1.5px solid var(--vt-border); border-radius: var(--vt-radius-sm);
            font-size: 13px; color: var(--vt-text-main); background: #fafafa;
            transition: border-color .15s, background .15s;
        }
        .vt-acr-input:focus {
            outline: none; border-color: var(--vt-orange);
            background: #fff; box-shadow: 0 0 0 3px rgba(234,88,12,.07);
        }
        .vt-acr-input::placeholder { color: #b0bec5; }
        .vt-acr-select {
            width: 100%; padding: 9px 34px 9px 34px;
            border: 1.5px solid var(--vt-border); border-radius: var(--vt-radius-sm);
            font-size: 13px; color: var(--vt-text-main); background: #fafafa;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 10px center; background-size: 15px;
            appearance: none; cursor: pointer;
            transition: border-color .15s, background-color .15s;
        }
        .vt-acr-select:focus {
            outline: none; border-color: var(--vt-orange);
            background-color: #fff; box-shadow: 0 0 0 3px rgba(234,88,12,.07);
        }

        .vt-acr-footer {
            display: flex; align-items: center; justify-content: flex-end;
            gap: 10px; padding: 16px 24px 20px;
            border-top: 1px solid var(--vt-border); margin-top: 8px;
        }
        .vt-acr-btn-cancel {
            padding: 9px 22px; border-radius: var(--vt-radius-sm);
            border: 1.5px solid var(--vt-border); background: #fff;
            color: var(--vt-text-main); font-size: 13px; font-weight: 600;
            cursor: pointer; transition: all .15s;
        }
        .vt-acr-btn-cancel:hover { border-color: #94a3b8; background: #f8fafc; }
        .vt-acr-btn-submit {
            padding: 9px 22px; border-radius: var(--vt-radius-sm);
            background: var(--vt-orange); border: none;
            color: #fff; font-size: 13px; font-weight: 700;
            cursor: pointer; display: inline-flex; align-items: center;
            gap: 6px; transition: background .15s;
        }
        .vt-acr-btn-submit:hover { background: #c2560a; }
        .vt-acr-btn-submit:disabled { opacity: .65; cursor: not-allowed; }
    </style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    {{-- En-tête --}}
    <div class="vt-profile-header">
        <div>
            <h1 class="vt-profile-title">Paramètres du compte</h1>
            <p class="vt-profile-subtitle">Gérez votre entreprise, vos comptes de retrait et votre profil.</p>
        </div>
        <a href="{{ route('business.espace') }}" class="vt-btn-accueil">
            <i class="ti ti-home" style="font-size:13px;"></i> Accueil
        </a>
    </div>
    <div class="col-sm-12">@include('layout.status')</div>

    {{-- Conteneur tabs + contenu --}}
    <div class="vt-profile-container">

        {{-- =====================================================
             SIDEBAR TABS
             ===================================================== --}}
        <nav class="vt-profile-tabs">
            <button class="vt-tab-btn active" data-tab="tab-entreprise">
                <i class="ti ti-building"></i> Entreprise
            </button>
            <button class="vt-tab-btn" data-tab="tab-retrait">
                <i class="ti ti-credit-card"></i> Comptes de retrait
            </button>
            <button class="vt-tab-btn" data-tab="tab-profil">
                <i class="ti ti-user"></i> Profil
            </button>
        </nav>

        {{-- =====================================================
             ONGLET 1 — ENTREPRISE
             ===================================================== --}}
        <div class="vt-profile-content active" id="tab-entreprise">

            <h2 class="vt-section-title">Entreprise</h2>
            <p class="vt-section-desc">Mettez à jour les informations concernant votre organisation.</p>

            <form class="ajax-form" action="{{ route('business.update_customer') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">
                <input type="hidden" name="old_logo" value="{{ $customer->logo }}">

                {{-- Logo --}}
                <p class="vt-field-group-label">Dénomination</p>
                <div class="vt-logo-row">
                    <div class="vt-logo-avatar" id="logo-avatar-wrap">
                        @if ($customer->logo)
                            <img src="{{ asset(env('IMAGES_PATH') . '/' . $customer->logo) }}" id="logo-preview"
                                alt="logo">
                        @else
                            <span id="logo-letter">{{ strtoupper(substr($customer->entreprise ?? 'V', 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="vt-logo-info">
                        <div class="vt-logo-name">Logo / Image</div>
                        <div class="vt-logo-hint">PNG/JPG · recommandé 512×512</div>
                    </div>
                    <div class="vt-logo-actions">
                        <label class="vt-btn-upload">
                            <i class="ti ti-upload" style="font-size:13px;"></i>
                            Charger une image
                            <input type="file" name="logo" accept="image/*" onchange="handleLogoPreview(this)">
                        </label>
                        <button type="button" class="vt-btn-del-logo" id="logo-del-btn" onclick="handleLogoRemove()"
                            style="{{ $customer->logo ? '' : 'display:none;' }}">
                            <i class="ti ti-trash" style="font-size:14px;"></i>
                        </button>
                    </div>
                </div>

                {{-- Champs principaux --}}
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Nom de l'organisation</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-building vt-inp-icon"></i>
                                <input type="text" class="vt-input" name="entreprise"
                                    value="{{ $customer->entreprise }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Pays siège</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-map-pin vt-inp-icon"></i>
                                <input type="text" class="vt-input" name="pays_siege"
                                    value="{{ $customer->pays_siege }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Email de l'organisation</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-mail vt-inp-icon"></i>
                                <input type="email" class="vt-input" name="email" value="{{ $customer->email }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Téléphone</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-phone vt-inp-icon"></i>
                                <input type="text" class="vt-input phone" name="phonenumber"
                                    value="{{ $customer->phonenumber }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="vt-field">
                            <label>Adresse</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-map vt-inp-icon"></i>
                                <input type="text" class="vt-input" name="adresse" value="{{ $customer->adresse }}"
                                    placeholder="Siège social" required>
                            </div>
                        </div>
                    </div>

                    {{-- Réseaux sociaux --}}
                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Lien Facebook</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-brand-facebook vt-inp-icon"></i>
                                <input type="url" class="vt-input" name="link_facebook"
                                    value="{{ $customer->link_facebook }}" placeholder="Lien du profil facebook">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Lien Twitter / X</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-brand-x vt-inp-icon"></i>
                                <input type="url" class="vt-input" name="link_instagram"
                                    value="{{ $customer->link_instagram }}" placeholder="Lien du profil Twitter">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Lien LinkedIn</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-brand-linkedin vt-inp-icon"></i>
                                <input type="url" class="vt-input" name="link_linkedin"
                                    value="{{ $customer->link_linkedin }}" placeholder="Lien du profil LinkedIn">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Lien Youtube</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-brand-youtube vt-inp-icon"></i>
                                <input type="url" class="vt-input" name="link_youtube"
                                    value="{{ $customer->link_youtube }}" placeholder="Lien du profil Youtube">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Lien Tiktok</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-brand-tiktok vt-inp-icon"></i>
                                <input type="url" class="vt-input" name="link_tiktok"
                                    value="{{ $customer->link_tiktok }}" placeholder="Lien du profil Tiktok">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Site internet</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-world vt-inp-icon"></i>
                                <input type="url" class="vt-input" name="link_website"
                                    value="{{ $customer->link_website }}" placeholder="Lien du site web">
                            </div>
                        </div>
                    </div>

                </div>

                <button type="submit" class="vt-btn-save">Enregistrer</button>
            </form>


        </div>

        {{-- =====================================================
             ONGLET 2 — COMPTES DE RETRAIT
             ===================================================== --}}
        <div class="vt-profile-content" id="tab-retrait">

            <h2 class="vt-section-title">Comptes de retrait</h2>
            <p class="vt-section-desc">Ajoutez ou retirez des comptes sur lesquels effectuer vos futurs virements.</p>

            <div class="vt-retrait-header">
                <span class="vt-retrait-list-label">Liste des comptes</span>
                <button class="vt-btn-primary"
                    style="border-radius: var(--vt-radius-sm); padding: 8px 16px; font-size:12.5px;"
                    data-bs-toggle="modal" data-bs-target="#add_bank">
                    <i class="ti ti-plus" style="font-size:13px;"></i> Ajouter
                </button>
            </div>

            <div class="vt-comptes-grid">
                @foreach ($compteRetraits as $compte)
                    <div class="vt-compte-card">
                        <button class="vt-compte-close" data-bs-toggle="modal"
                            data-bs-target="#add_paypal{{ $compte->withdrawal_account_id }}"
                            title="Voir / gérer">×</button>
                        <div class="vt-compte-top">
                            <div class="vt-compte-icon">
                                @foreach ($paymentMethods as $method)
                                    @if ($method->value === $compte->payment_methode)
                                        <img src="{{ asset(env('IMAGES_PAYMENT') . '/' . $method->icon()) }}"
                                            alt="{{ $method->label() }}">
                                    @endif
                                @endforeach
                            </div>
                            <span class="vt-compte-name">{{ $compte->account_name }}</span>
                        </div>
                        <div class="vt-compte-number">
                            ••••••{{ substr($compte->phone_number, -4) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="vt-retrait-astuce">
                {{-- Astuce : en V1 (front-only) les comptes sont simulés. En PHP, on branchera la sauvegarde réelle. --}}
            </p>


        </div>

        {{-- =====================================================
             ONGLET 3 — PROFIL UTILISATEUR
             ===================================================== --}}
        <div class="vt-profile-content" id="tab-profil">

            <h2 class="vt-section-title">Profil</h2>
            <p class="vt-section-desc">Gérez vos informations personnelles et la sécurité du compte.</p>

            <form class="ajax-form" action="{{ route('business.update_profile') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                <input type="hidden" name="old_password" value="{{ $user->password }}">

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Nom</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-user vt-inp-icon"></i>
                                <input type="text" class="vt-input" name="name" value="{{ $user->name }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Numéro de téléphone</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-phone vt-inp-icon"></i>
                                <input type="tel" class="vt-input" name="phonenumber" value="{{ $user->phonenumber }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="vt-field">
                            <label>Email</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-mail vt-inp-icon"></i>
                                <input type="email" class="vt-input" name="email" value="{{ $user->email }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="vt-field">
                            <label>Sécurité</label>
                            <div class="vt-input-wrap">
                                <i class="ti ti-lock vt-inp-icon"></i>
                                <input type="password" class="vt-input" name="password" placeholder="Laisser vide pour conserver le mot de passe actuel">
                            </div>
                        </div>
                        <p class="vt-profile-note">
                            {{-- En V1 (front-only) : pas de vrai changement de mot de passe. En PHP, on branchera l'API +
                            hashing. --}}
                        </p>
                    </div>
                </div>

                <button type="submit" class="vt-btn-save">Enregistrer</button>
            </form>


        </div>

    </div>
    {{-- fin container --}}

@endsection

{{-- =====================================================
     MODALES
     ===================================================== --}}

{{-- Voir compte retrait --}}
@foreach ($compteRetraits as $compte)
    <div class="modal fade" id="add_paypal{{ $compte->withdrawal_account_id }}" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title">Détail du compte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Type de compte</label>
                        <div class="fw-semibold">
                            @foreach ($paymentMethods as $method)
                                @if ($method->value === $compte->payment_methode)
                                    {{ $method->label() }}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Nom du compte</label>
                        <div class="fw-semibold text-uppercase">{{ $compte->account_name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Numéro</label>
                        <div class="fw-semibold">{{ $compte->phone_number }}</div>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input switchCheckDefault" type="checkbox" role="switch"
                            data-id="{{ $compte->withdrawal_account_id }}" {{ $compte->is_active ? 'checked' : '' }}>
                        <label class="form-check-label">
                            {{ $compte->is_active ? 'Connecté' : 'Déconnecté' }}
                        </label>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Ajouter compte retrait --}}
<div class="modal fade" id="add_bank" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {{-- Header gradient --}}
            <div class="vt-acr-header">
                <div class="vt-acr-icon">
                    <i class="ti ti-plus"></i>
                </div>
                <h5 class="vt-acr-title">Ajouter un compte retrait</h5>
                <button type="button" class="vt-acr-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            <form class="ajax-form" action="{{ route('business.save_compte_retrait') }}" method="POST" id="form_add_bank">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">

                <div class="modal-body">

                    <div class="vt-acr-field">
                        <label class="vt-acr-label">Type de compte <span style="color:#ef4444;">*</span></label>
                        <div class="vt-acr-input-wrap">
                            <i class="ti ti-credit-card vt-acr-field-icon"></i>
                            <select class="vt-acr-select" name="payment_methode" required>
                                <option value="" disabled selected>Sélectionner un type</option>
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method->value }}">{{ $method->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="vt-acr-field">
                        <label class="vt-acr-label">Nom du compte <span style="color:#ef4444;">*</span></label>
                        <div class="vt-acr-input-wrap">
                            <i class="ti ti-user vt-acr-field-icon"></i>
                            <input type="text" class="vt-acr-input" name="account_name"
                                   placeholder="Ex : Jean Dupont" required>
                        </div>
                    </div>

                    <div class="vt-acr-field">
                        <label class="vt-acr-label">Numéro du compte <span style="color:#ef4444;">*</span></label>
                        <div class="vt-acr-input-wrap">
                            <i class="ti ti-phone vt-acr-field-icon"></i>
                            <input type="text" class="vt-acr-input" name="phone_number"
                                   placeholder="Ex : +225 07 00 00 00 00" required>
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="vt-acr-footer">
                    <button type="button" class="vt-acr-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="vt-acr-btn-submit">
                        <i class="ti ti-check" style="font-size:13px;"></i> Confirmer
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
    <script>
        $(document).ready(function() {

            /* -------------------------------------------------------
               Système de tabs custom
               ------------------------------------------------------- */
            $('.vt-tab-btn').on('click', function() {
                const target = $(this).data('tab');

                // Mettre à jour les boutons
                $('.vt-tab-btn').removeClass('active');
                $(this).addClass('active');

                // Afficher le bon panel
                $('.vt-profile-content').removeClass('active');
                $('#' + target).addClass('active');
            });

            /* -------------------------------------------------------
               Activer le bon onglet via hash URL (ex: #tab-retrait)
               ------------------------------------------------------- */
            const hash = window.location.hash.replace('#', '');
            if (hash && $('#' + hash).length) {
                $('.vt-tab-btn').removeClass('active');
                $('[data-tab="' + hash + '"]').addClass('active');
                $('.vt-profile-content').removeClass('active');
                $('#' + hash).addClass('active');
            }

            /* -------------------------------------------------------
               Toggle activation compte retrait
               ------------------------------------------------------- */
            $('.switchCheckDefault').on('change', function() {
                const $cb = $(this);
                const accountId = $cb.data('id');
                const isActive = $cb.is(':checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('business.delete_compte_retrait') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        account_id: accountId,
                        is_active: isActive
                    },
                    success: function(response) {
                        if (typeof showAjaxAlert === 'function')
                            showAjaxAlert('success', response.message);
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message || 'Erreur lors de la mise à jour.';
                        if (typeof showAjaxAlert === 'function') showAjaxAlert('danger', msg);
                        $cb.prop('checked', !isActive);
                    }
                });
            });

        });

        /* -------------------------------------------------------
           Prévisualisation du logo
           ------------------------------------------------------- */
        function handleLogoPreview(input) {
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const $wrap = $('#logo-avatar-wrap');
                $wrap.find('#logo-letter').hide();
                let $img = $wrap.find('#logo-preview');
                if (!$img.length) {
                    $img = $(
                        '<img id="logo-preview" alt="logo" style="width:100%;height:100%;object-fit:cover;position:absolute;top:0;left:0;">'
                    );
                    $wrap.append($img);
                }
                $img.attr('src', e.target.result).show();
                $('#logo-del-btn').show();
            };
            reader.readAsDataURL(input.files[0]);
        }

        function handleLogoRemove() {
            $('#logo-preview').attr('src', '#').hide();
            $('#logo-letter').show();
            $('#logo-del-btn').hide();
            $('input[name="logo"]').val('');
        }
    </script>
@endsection
