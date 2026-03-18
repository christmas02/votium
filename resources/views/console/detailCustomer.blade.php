@extends('refont.layout.console')

@section('title', 'Détail client')

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li>
        <a href="{{ route('console.espace') }}"><i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil</a>
    </li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li>
        <a href="{{ route('console.list_customer') }}">Clients</a>
    </li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li class="active">{{ $customer->entreprise }}</li>
@endsection

{{-- ===== CSS ===== --}}
@section('extra-css')
<style>
    /* ================================================================
       LAYOUT PAGE
       ================================================================ */
    .vt-dc-layout {
        display: grid; grid-template-columns: 220px 1fr; gap: 18px;
        align-items: flex-start;
    }
    @media (max-width: 768px) { .vt-dc-layout { grid-template-columns: 1fr; } }

    /* Titre page */
    .vt-dc-header { margin-bottom: 22px; }
    .vt-dc-title { font-size: 34px; font-weight: 800; color: var(--vt-text-main); margin: 0 0 2px; letter-spacing: -.5px; }
    .vt-dc-sub { font-size: 13px; color: var(--vt-text-muted); margin: 0; }

    /* ================================================================
       SIDEBAR TABS
       ================================================================ */
    .vt-tab-item {
        display: flex; align-items: center; gap: 10px;
        padding: 11px 16px; font-size: 13px; font-weight: 500;
        color: var(--vt-text-muted); text-decoration: none;
        border-left: 3px solid transparent; cursor: pointer;
        transition: all .15s; background: none; border-top: none;
        border-right: none; border-bottom: 1px solid var(--vt-border);
        width: 100%; text-align: left;
    }
    .vt-tab-item:last-child { border-bottom: none; }
    .vt-tab-item:hover { background: #fafbfc; color: var(--vt-text-main); }
    .vt-tab-item.active {
        border-left-color: var(--vt-orange); color: var(--vt-orange);
        background: var(--vt-orange-light); font-weight: 600;
    }
    .vt-tab-item i { font-size: 16px; flex-shrink: 0; }

    /* ================================================================
       CONTENU TABS
       ================================================================ */
    .vt-tab-pane { display: none; }
    .vt-tab-pane.active { display: block; }

    /* Section head */
    .vt-section-head {
        display: flex; align-items: center; gap: 12px;
        padding: 18px 22px 16px; border-bottom: 1px solid var(--vt-border);
    }
    .vt-section-icon {
        width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
        background: var(--vt-orange-light); border: 1.5px solid var(--vt-orange-border);
        display: flex; align-items: center; justify-content: center;
        color: var(--vt-orange); font-size: 16px;
    }
    .vt-section-title { font-size: 14.5px; font-weight: 700; color: var(--vt-text-main); margin: 0; }

    /* Champs lecture seule */
    .vt-ro-body { padding: 20px 22px; }
    .vt-ro-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
    .vt-ro-row.full { grid-template-columns: 1fr; }
    @media (max-width: 600px) { .vt-ro-row { grid-template-columns: 1fr; } }
    .vt-ro-group { margin-bottom: 0; }
    .vt-ro-label {
        font-size: 10.5px; font-weight: 700; color: var(--vt-text-muted);
        letter-spacing: .6px; text-transform: uppercase; margin-bottom: 4px; display: block;
    }
    .vt-ro-wrap { position: relative; }
    .vt-ro-icon {
        position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 14px; pointer-events: none;
    }
    .vt-ro-input {
        width: 100%; padding: 9px 12px 9px 34px;
        border: 1.5px solid var(--vt-border); border-radius: var(--vt-radius-sm);
        font-size: 13px; color: var(--vt-text-main); background: #f8fafc;
        cursor: default;
    }
    .vt-ro-input:focus { outline: none; }

    /* Zone logo */
    .vt-dc-logo-zone {
        display: flex; align-items: center; gap: 14px;
        padding: 14px; border: 1.5px solid var(--vt-border);
        border-radius: var(--vt-radius-sm); background: #fafafa; margin-bottom: 18px;
    }
    .vt-dc-logo {
        width: 60px; height: 60px; border-radius: 12px; flex-shrink: 0;
        background: var(--vt-orange-light); color: var(--vt-orange);
        font-size: 24px; font-weight: 700;
        display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .vt-dc-logo img { width: 100%; height: 100%; object-fit: cover; }
    .vt-dc-logo-name { font-size: 15px; font-weight: 700; color: var(--vt-text-main); margin: 0 0 2px; }
    .vt-dc-logo-pays { font-size: 12px; color: var(--vt-text-muted); margin: 0; }

    /* Réseaux sociaux */
    .vt-social-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .vt-social-item { display: flex; }
    .vt-social-prefix {
        padding: 9px 10px; background: #f1f5f9;
        border: 1.5px solid var(--vt-border); border-right: none;
        border-radius: var(--vt-radius-sm) 0 0 var(--vt-radius-sm);
        color: #94a3b8; font-size: 14px;
        display: flex; align-items: center;
    }
    .vt-social-value {
        flex: 1; padding: 9px 10px;
        border: 1.5px solid var(--vt-border); border-left: none;
        border-radius: 0 var(--vt-radius-sm) var(--vt-radius-sm) 0;
        font-size: 12px; color: var(--vt-text-main); background: #f8fafc;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    /* Section divider */
    .vt-ro-sect {
        display: flex; align-items: center; gap: 10px;
        margin: 20px 0 16px;
    }
    .vt-ro-sect::before, .vt-ro-sect::after { content: ''; flex: 1; height: 1px; background: var(--vt-border); }
    .vt-ro-sect span {
        font-size: 10px; font-weight: 700; letter-spacing: .8px;
        text-transform: uppercase; color: var(--vt-text-muted); white-space: nowrap;
    }

    /* ================================================================
       TAB COMPTES DE RETRAIT
       ================================================================ */
    .vt-cr-list { padding: 16px 22px; display: flex; flex-direction: column; gap: 10px; }
    .vt-cr-item {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 16px; border: 1.5px solid var(--vt-border);
        border-radius: var(--vt-radius-sm); background: #fafafa;
        transition: border-color .15s;
    }
    .vt-cr-item:hover { border-color: #cbd5e1; background: #fff; }
    .vt-cr-img {
        width: 44px; height: 44px; flex-shrink: 0; border-radius: 8px;
        background: #f1f5f9; display: flex; align-items: center; justify-content: center;
        overflow: hidden;
    }
    .vt-cr-img img { width: 100%; height: 100%; object-fit: contain; padding: 4px; }
    .vt-cr-info { flex: 1; min-width: 0; }
    .vt-cr-name { font-size: 13px; font-weight: 700; color: var(--vt-text-main); text-transform: uppercase; }
    .vt-cr-num  { font-size: 12px; color: var(--vt-text-muted); margin-top: 1px; }
    .vt-cr-badge-on  {
        background: var(--vt-green-light); color: var(--vt-green);
        font-size: 10.5px; font-weight: 700; padding: 3px 10px;
        border-radius: 50px; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;
    }
    .vt-cr-badge-off {
        background: #f1f5f9; color: var(--vt-text-muted);
        font-size: 10.5px; font-weight: 600; padding: 3px 10px; border-radius: 50px; white-space: nowrap;
    }
    .vt-cr-actions { display: flex; align-items: center; gap: 8px; }
    .vt-cr-btn {
        width: 30px; height: 30px; border-radius: 7px;
        border: 1px solid var(--vt-border); background: #fff; color: var(--vt-text-muted);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 13px; cursor: pointer; text-decoration: none; transition: all .15s;
    }
    .vt-cr-btn:hover { border-color: #93c5fd; color: #2563eb; background: #eff6ff; }
    .vt-cr-empty { padding: 32px 22px; text-align: center; color: var(--vt-text-muted); font-size: 13px; }

    /* ================================================================
       MODAUX
       ================================================================ */
    .vt-view-modal .modal-content,
    .vt-delete-modal .modal-content {
        border: none; border-radius: 16px; overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,.18);
    }
    .vt-mhg {
        display: flex; align-items: center; gap: 14px;
        padding: 22px 24px 18px;
        background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);
        border-bottom: 1px solid #f0e6d8;
    }
    .vt-mhg-icon {
        width: 40px; height: 40px; flex-shrink: 0;
        background: var(--vt-orange-light); border: 1.5px solid var(--vt-orange-border);
        border-radius: 10px; display: flex; align-items: center;
        justify-content: center; color: var(--vt-orange); font-size: 18px;
    }
    .vt-mhg-title { font-size: 17px; font-weight: 700; color: var(--vt-text-main); margin: 0; flex: 1; }
    .vt-mhg-close {
        width: 30px; height: 30px; border-radius: 50%;
        border: 1.5px solid var(--vt-border); background: #fff;
        display: flex; align-items: center; justify-content: center;
        color: var(--vt-text-muted); font-size: 13px;
        cursor: pointer; transition: all .15s; flex-shrink: 0;
    }
    .vt-mhg-close:hover { background: #f1f5f9; border-color: #94a3b8; }
    .vt-mbody { padding: 20px 24px 4px; }
    .vt-mf { margin-bottom: 12px; }
    .vt-mf-label { font-size: 11px; font-weight: 600; color: var(--vt-text-muted); margin-bottom: 5px; display: block; }
    .vt-mf-wrap { position: relative; }
    .vt-mf-icon {
        position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 14px; pointer-events: none; z-index: 1;
    }
    .vt-mf-input {
        width: 100%; padding: 9px 12px 9px 34px;
        border: 1.5px solid var(--vt-border); border-radius: var(--vt-radius-sm);
        font-size: 13px; color: var(--vt-text-main); background: #f8fafc;
        cursor: default;
    }
    .vt-mf-input:focus { outline: none; }
    .vt-mf-select {
        width: 100%; padding: 9px 34px 9px 34px;
        border: 1.5px solid var(--vt-border); border-radius: var(--vt-radius-sm);
        font-size: 13px; color: var(--vt-text-main); background: #f8fafc;
        appearance: none; cursor: default;
    }
    .vt-mfooter {
        display: flex; align-items: center; justify-content: flex-end;
        gap: 10px; padding: 14px 24px 18px;
        border-top: 1px solid var(--vt-border); margin-top: 8px;
    }
    .vt-mfooter-cancel {
        padding: 9px 22px; border-radius: var(--vt-radius-sm);
        border: 1.5px solid var(--vt-border); background: #fff;
        color: var(--vt-text-main); font-size: 13px; font-weight: 600;
        cursor: pointer; transition: all .15s;
    }
    .vt-mfooter-cancel:hover { border-color: #94a3b8; background: #f8fafc; }

    /* Modal suppression */
    .vt-del-body { padding: 28px 24px 8px; text-align: center; }
    .vt-del-icon {
        width: 52px; height: 52px; border-radius: 50%;
        background: #fff5f5; border: 1.5px solid #fca5a5; color: #dc2626;
        font-size: 22px; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    .vt-del-title { font-size: 17px; font-weight: 700; margin: 0 0 8px; color: var(--vt-text-main); }
    .vt-del-desc  { font-size: 13px; color: var(--vt-text-muted); margin: 0 0 4px; }
    .vt-del-footer { display: flex; gap: 10px; padding: 0 24px 24px; }
    .vt-mfooter-danger {
        flex: 1; padding: 9px 22px; border-radius: var(--vt-radius-sm);
        background: #dc2626; border: none; color: #fff;
        font-size: 13px; font-weight: 700; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        gap: 6px; transition: background .15s;
    }
    .vt-mfooter-danger:hover { background: #b91c1c; }
</style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    <div class="vt-dc-header">
        <h1 class="vt-dc-title">{{ $customer->entreprise }}</h1>
        <p class="vt-dc-sub">Détail du compte client</p>
    </div>

    <div class="col-sm-12">@include('layout.status')</div>

    <div class="vt-dc-layout">

        {{-- ========================
             SIDEBAR TABS
             ======================== --}}
        <div class="vt-card" style="overflow:hidden;">
            <button type="button" class="vt-tab-item active" data-tab="tab-entreprise">
                <i class="ti ti-building"></i> Entreprise
            </button>
            <button type="button" class="vt-tab-item" data-tab="tab-retraits">
                <i class="ti ti-wallet"></i> Comptes de retrait
            </button>
            <button type="button" class="vt-tab-item" data-tab="tab-profil">
                <i class="ti ti-user"></i> Profil utilisateur
            </button>
        </div>

        {{-- ========================
             CONTENU TABS
             ======================== --}}
        <div>

            {{-- ---- TAB : ENTREPRISE ---- --}}
            <div class="vt-tab-pane active vt-card" id="tab-entreprise" style="overflow:hidden;">

                <div class="vt-section-head">
                    <div class="vt-section-icon"><i class="ti ti-building"></i></div>
                    <div>
                        <p class="vt-section-title">Informations entreprise</p>
                    </div>
                </div>

                <div class="vt-ro-body">

                    {{-- Logo + nom --}}
                    <div class="vt-dc-logo-zone">
                        <div class="vt-dc-logo">
                            @if($customer->logo && $customer->logo !== 'default_logo.png')
                                <img src="{{ asset(env('IMAGES_PATH') . '/' . $customer->logo) }}" alt="{{ $customer->entreprise }}">
                            @else
                                {{ strtoupper(substr($customer->entreprise ?? 'C', 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <p class="vt-dc-logo-name">{{ $customer->entreprise }}</p>
                            <p class="vt-dc-logo-pays"><i class="ti ti-map-pin" style="font-size:12px;"></i> {{ $customer->pays_siege }}</p>
                        </div>
                    </div>

                    <div class="vt-ro-row">
                        <div class="vt-ro-group">
                            <label class="vt-ro-label">Nom de l'organisation</label>
                            <div class="vt-ro-wrap">
                                <i class="ti ti-building vt-ro-icon"></i>
                                <input type="text" class="vt-ro-input" value="{{ $customer->entreprise }}" readonly>
                            </div>
                        </div>
                        <div class="vt-ro-group">
                            <label class="vt-ro-label">Pays siège</label>
                            <div class="vt-ro-wrap">
                                <i class="ti ti-map-pin vt-ro-icon"></i>
                                <input type="text" class="vt-ro-input" value="{{ $customer->pays_siege }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="vt-ro-row">
                        <div class="vt-ro-group">
                            <label class="vt-ro-label">Email de l'organisation</label>
                            <div class="vt-ro-wrap">
                                <i class="ti ti-mail vt-ro-icon"></i>
                                <input type="text" class="vt-ro-input" value="{{ $customer->email }}" readonly>
                            </div>
                        </div>
                        <div class="vt-ro-group">
                            <label class="vt-ro-label">Téléphone</label>
                            <div class="vt-ro-wrap">
                                <i class="ti ti-phone vt-ro-icon"></i>
                                <input type="text" class="vt-ro-input" value="{{ $customer->phonenumber }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="vt-ro-row full">
                        <div class="vt-ro-group">
                            <label class="vt-ro-label">Adresse</label>
                            <div class="vt-ro-wrap">
                                <i class="ti ti-map vt-ro-icon"></i>
                                <input type="text" class="vt-ro-input" value="{{ $customer->adresse }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="vt-ro-sect"><span>Réseaux sociaux</span></div>

                    <div class="vt-social-grid">
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-brand-facebook"></i></span>
                            <span class="vt-social-value">{{ $customer->link_facebook ?: '—' }}</span>
                        </div>
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-brand-instagram"></i></span>
                            <span class="vt-social-value">{{ $customer->link_instagram ?: '—' }}</span>
                        </div>
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-brand-linkedin"></i></span>
                            <span class="vt-social-value">{{ $customer->link_linkedin ?: '—' }}</span>
                        </div>
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-brand-youtube"></i></span>
                            <span class="vt-social-value">{{ $customer->link_youtube ?: '—' }}</span>
                        </div>
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-brand-tiktok"></i></span>
                            <span class="vt-social-value">{{ $customer->link_tiktok ?: '—' }}</span>
                        </div>
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-world"></i></span>
                            <span class="vt-social-value">{{ $customer->link_website ?: '—' }}</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ---- TAB : COMPTES DE RETRAIT ---- --}}
            <div class="vt-tab-pane vt-card" id="tab-retraits" style="overflow:hidden;">

                <div class="vt-section-head">
                    <div class="vt-section-icon"><i class="ti ti-wallet"></i></div>
                    <div>
                        <p class="vt-section-title">Comptes de retrait</p>
                    </div>
                </div>

                <div class="vt-cr-list">
                    @forelse($compteRetraits as $compte)
                    <div class="vt-cr-item">
                        <div class="vt-cr-img">
                            @foreach($paymentMethods as $method)
                                @if($method->value === $compte->payment_methode)
                                    <img src="{{ asset(env('IMAGES_PAYMENT') . '/' . $method->icon()) }}" alt="{{ $method->label() }}">
                                @endif
                            @endforeach
                        </div>
                        <div class="vt-cr-info">
                            <div class="vt-cr-name">{{ $compte->account_name }}</div>
                            <div class="vt-cr-num">{{ $compte->phone_number }}</div>
                        </div>
                        <div class="vt-cr-actions">
                            @if($compte->is_active)
                                <span class="vt-cr-badge-on"><i class="ti ti-check" style="font-size:10px;"></i> Actif</span>
                            @else
                                <span class="vt-cr-badge-off">Inactif</span>
                            @endif
                            <div class="form-check form-switch mb-0" style="padding-left:0;">
                                <input class="form-check-input switchCheckDefault" type="checkbox" role="switch"
                                       data-id="{{ $compte->withdrawal_account_id }}"
                                       {{ $compte->is_active ? 'checked' : '' }}
                                       style="cursor:pointer; width:36px; height:20px;">
                            </div>
                            <button type="button" class="vt-cr-btn" title="Voir les détails"
                                    data-bs-toggle="modal" data-bs-target="#modal_compte_{{ $compte->withdrawal_account_id }}">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="vt-cr-empty">Aucun compte de retrait enregistré.</div>
                    @endforelse
                </div>

            </div>

            {{-- ---- TAB : PROFIL UTILISATEUR ---- --}}
            <div class="vt-tab-pane vt-card" id="tab-profil" style="overflow:hidden;">

                <div class="vt-section-head">
                    <div class="vt-section-icon"><i class="ti ti-user-shield"></i></div>
                    <div>
                        <p class="vt-section-title">Informations utilisateur</p>
                    </div>
                </div>

                <div class="vt-ro-body">
                    <div class="vt-ro-row">
                        <div class="vt-ro-group">
                            <label class="vt-ro-label">Nom complet</label>
                            <div class="vt-ro-wrap">
                                <i class="ti ti-user vt-ro-icon"></i>
                                <input type="text" class="vt-ro-input" value="{{ $user->name }}" readonly>
                            </div>
                        </div>
                        <div class="vt-ro-group">
                            <label class="vt-ro-label">Téléphone</label>
                            <div class="vt-ro-wrap">
                                <i class="ti ti-phone vt-ro-icon"></i>
                                <input type="text" class="vt-ro-input" value="{{ $user->phonenumber }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="vt-ro-row full">
                        <div class="vt-ro-group">
                            <label class="vt-ro-label">Email — identifiant</label>
                            <div class="vt-ro-wrap">
                                <i class="ti ti-mail vt-ro-icon"></i>
                                <input type="text" class="vt-ro-input" value="{{ $user->email }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        {{-- fin contenu tabs --}}

    </div>

@endsection

{{-- =====================================================
     MODALS
     ===================================================== --}}
@section('modals')

{{-- Modals — Voir compte de retrait --}}
@foreach($compteRetraits as $compte)
<div class="modal fade vt-view-modal" id="modal_compte_{{ $compte->withdrawal_account_id }}"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="vt-mhg">
                <div class="vt-mhg-icon"><i class="ti ti-wallet"></i></div>
                <h5 class="vt-mhg-title">Détail du compte</h5>
                <button type="button" class="vt-mhg-close" data-bs-dismiss="modal"><i class="ti ti-x"></i></button>
            </div>

            <div class="vt-mbody">

                <div class="vt-mf">
                    <label class="vt-mf-label">Type de compte</label>
                    <div class="vt-mf-wrap">
                        <i class="ti ti-credit-card vt-mf-icon"></i>
                        <select class="vt-mf-select" disabled>
                            <option>
                                @foreach($paymentMethods as $method)
                                    @if($method->value === $compte->payment_methode)
                                        {{ $method->label() }}
                                    @endif
                                @endforeach
                            </option>
                        </select>
                    </div>
                </div>

                <div class="vt-mf">
                    <label class="vt-mf-label">Nom du compte</label>
                    <div class="vt-mf-wrap">
                        <i class="ti ti-user vt-mf-icon"></i>
                        <input type="text" class="vt-mf-input" value="{{ $compte->account_name }}" readonly>
                    </div>
                </div>

                <div class="vt-mf">
                    <label class="vt-mf-label">Numéro</label>
                    <div class="vt-mf-wrap">
                        <i class="ti ti-phone vt-mf-icon"></i>
                        <input type="text" class="vt-mf-input" value="{{ $compte->phone_number }}" readonly>
                    </div>
                </div>

            </div>

            <div class="vt-mfooter">
                <button type="button" class="vt-mfooter-cancel" data-bs-dismiss="modal">Fermer</button>
            </div>

        </div>
    </div>
</div>
@endforeach

{{-- Modal — Supprimer --}}
<div class="modal fade vt-delete-modal" id="delete_contact" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="vt-del-body">
                <div class="vt-del-icon"><i class="ti ti-trash"></i></div>
                <h5 class="vt-del-title">Supprimer le client</h5>
                <p class="vt-del-desc">
                    Confirmer la suppression de <strong>{{ $customer->entreprise }}</strong> ?<br>
                    <span style="font-size:11.5px;">Cette action est irréversible.</span>
                </p>
            </div>
            <div class="vt-del-footer">
                <button type="button" class="vt-mfooter-cancel" data-bs-dismiss="modal"
                        style="flex:1;justify-content:center;display:flex;">Annuler</button>
                <button type="button" class="vt-mfooter-danger">
                    <i class="ti ti-trash" style="font-size:13px;"></i> Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
<script>
/* Tabs sidebar */
document.querySelectorAll('.vt-tab-item').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.vt-tab-item').forEach(function (b) { b.classList.remove('active'); });
        document.querySelectorAll('.vt-tab-pane').forEach(function (p) { p.classList.remove('active'); });
        this.classList.add('active');
        var target = document.getElementById(this.dataset.tab);
        if (target) target.classList.add('active');
    });
});
</script>
@endsection
