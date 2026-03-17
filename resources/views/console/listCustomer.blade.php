@extends('refont.layout.console')

@section('title', 'Clients')

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li>
        <a href="{{ route('console.espace') }}"><i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil</a>
    </li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li class="active">Clients</li>
@endsection

{{-- ===== CSS ===== --}}
@section('extra-css')
<style>
    /* ================================================================
       PAGE HEADER & TOOLBAR
       ================================================================ */
    .vt-lc-header {
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px; margin-bottom: 22px; flex-wrap: wrap;
    }
    .vt-lc-title {
        font-size: 34px; font-weight: 800; color: var(--vt-text-main);
        margin: 0; letter-spacing: -.5px;
    }
    .vt-lc-toolbar {
        display: flex; align-items: center; gap: 10px;
        padding: 14px 20px; border-bottom: 1px solid var(--vt-border); flex-wrap: wrap;
    }
    .vt-lc-count { font-size: 13px; color: var(--vt-text-muted); font-weight: 500; flex: 1; min-width: 80px; }
    .vt-lc-count strong { color: var(--vt-orange); font-weight: 700; }

    .vt-lc-search-wrap { position: relative; }
    .vt-lc-search-icon {
        position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 14px; pointer-events: none;
    }
    .vt-lc-search {
        padding: 8px 12px 8px 32px; width: 220px;
        border: 1.5px solid var(--vt-border); border-radius: var(--vt-radius-sm);
        font-size: 13px; color: var(--vt-text-main); background: #fafafa;
        transition: border-color .15s;
    }
    .vt-lc-search:focus { outline: none; border-color: var(--vt-orange); background: #fff; }
    .vt-lc-search::placeholder { color: #b0bec5; }

    /* ================================================================
       TABLE
       ================================================================ */
    .vt-lc-table { width: 100%; border-collapse: collapse; font-size: 12.5px; }
    .vt-lc-table thead th {
        padding: 11px 16px; font-size: 11px; font-weight: 700;
        letter-spacing: .6px; text-transform: uppercase;
        color: var(--vt-text-muted); border-bottom: 1px solid var(--vt-border); white-space: nowrap;
    }
    .vt-lc-table tbody td {
        padding: 13px 16px; border-bottom: 1px solid var(--vt-border);
        color: var(--vt-text-main); vertical-align: middle;
    }
    .vt-lc-table tbody tr:last-child td { border-bottom: none; }
    .vt-lc-table tbody tr:hover td { background: #fafbfc; }

    /* Cellule organisation */
    .vt-lc-org-cell { display: flex; align-items: center; gap: 10px; }
    .vt-lc-logo {
        width: 36px; height: 36px; border-radius: 8px; flex-shrink: 0;
        background: var(--vt-orange-light); color: var(--vt-orange);
        font-size: 13px; font-weight: 700;
        display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .vt-lc-logo img { width: 100%; height: 100%; object-fit: cover; }
    .vt-lc-org-name  { font-weight: 700; font-size: 13px; }
    .vt-lc-org-email { font-size: 11px; color: var(--vt-text-muted); }

    /* Badges */
    .vt-lc-badge-actif {
        background: var(--vt-green-light); color: var(--vt-green);
        font-size: 10.5px; font-weight: 700; padding: 3px 10px;
        border-radius: 50px; display: inline-flex; align-items: center; gap: 4px;
    }
    .vt-lc-badge-inactif {
        background: #f1f5f9; color: var(--vt-text-muted);
        font-size: 10.5px; font-weight: 600; padding: 3px 10px; border-radius: 50px;
    }

    /* Boutons action */
    .vt-lc-actions { display: flex; gap: 5px; align-items: center; }
    .vt-lc-btn {
        width: 30px; height: 30px; border-radius: 7px;
        border: 1px solid var(--vt-border); background: #fff; color: var(--vt-text-muted);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 13px; cursor: pointer; text-decoration: none; transition: all .15s;
    }
    .vt-lc-btn.view:hover { border-color: #93c5fd; color: #2563eb; background: #eff6ff; }
    .vt-lc-btn.del:hover  { border-color: #fca5a5; color: #dc2626; background: #fff5f5; }
    .vt-lc-btn-session {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: var(--vt-radius-sm);
        background: var(--vt-orange-light); border: 1.5px solid var(--vt-orange-border);
        color: var(--vt-orange); font-size: 12px; font-weight: 600;
        cursor: pointer; transition: all .15s;
    }
    .vt-lc-btn-session:hover { background: #fed7aa40; border-color: var(--vt-orange); }

    /* Empty */
    .vt-lc-empty { padding: 32px 16px; text-align: center; color: var(--vt-text-muted); font-size: 13px; }

    /* ================================================================
       MODAUX — BASE COMMUNE
       ================================================================ */
    #modal_add_client .modal-content,
    .vt-campaign-modal .modal-content,
    .vt-delete-modal .modal-content {
        border: none; border-radius: 16px; overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,.18);
    }

    /* Header gradient */
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
    .vt-mhg-icon.danger { background: #fff5f5; border-color: #fca5a5; color: #dc2626; }
    .vt-mhg-title { font-size: 17px; font-weight: 700; color: var(--vt-text-main); margin: 0; flex: 1; }
    .vt-mhg-close {
        width: 30px; height: 30px; border-radius: 50%;
        border: 1.5px solid var(--vt-border); background: #fff;
        display: flex; align-items: center; justify-content: center;
        color: var(--vt-text-muted); font-size: 13px;
        cursor: pointer; transition: all .15s; flex-shrink: 0;
    }
    .vt-mhg-close:hover { background: #f1f5f9; border-color: #94a3b8; }

    /* Body + section */
    .vt-mbody { padding: 20px 24px 4px; }
    .vt-msect {
        display: flex; align-items: center; gap: 10px;
        margin: 18px 0 14px;
    }
    .vt-msect::before, .vt-msect::after { content: ''; flex: 1; height: 1px; background: var(--vt-border); }
    .vt-msect span {
        font-size: 10px; font-weight: 700; letter-spacing: .8px;
        text-transform: uppercase; color: var(--vt-text-muted); white-space: nowrap;
    }

    /* Champ */
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
        font-size: 13px; color: var(--vt-text-main); background: #fafafa;
        transition: border-color .15s, background .15s;
    }
    .vt-mf-input:focus { outline: none; border-color: var(--vt-orange); background: #fff; box-shadow: 0 0 0 3px rgba(234,88,12,.07); }
    .vt-mf-input::placeholder { color: #b0bec5; }
    textarea.vt-mf-input { padding-top: 9px; resize: vertical; min-height: 80px; }
    input[type="file"].vt-mf-input { cursor: pointer; }
    .vt-mf-select {
        width: 100%; padding: 9px 34px 9px 34px;
        border: 1.5px solid var(--vt-border); border-radius: var(--vt-radius-sm);
        font-size: 13px; color: var(--vt-text-main); background: #fafafa;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 10px center; background-size: 15px;
        appearance: none; cursor: pointer; transition: border-color .15s;
    }
    .vt-mf-select:focus { outline: none; border-color: var(--vt-orange); background-color: #fff; box-shadow: 0 0 0 3px rgba(234,88,12,.07); }
    .vt-mf-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    @media (max-width: 500px) { .vt-mf-row { grid-template-columns: 1fr; } }

    /* Zone logo (add client) */
    .vt-ac-logo-zone {
        display: flex; align-items: center; gap: 14px;
        padding: 14px; border: 1.5px dashed var(--vt-border);
        border-radius: var(--vt-radius-sm); background: #fafafa; margin-bottom: 12px;
    }
    .vt-ac-logo-preview {
        width: 52px; height: 52px; border-radius: 10px; flex-shrink: 0;
        background: var(--vt-orange-light); color: var(--vt-orange);
        font-size: 22px; display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .vt-ac-logo-preview img { width: 100%; height: 100%; object-fit: cover; }
    .vt-ac-logo-info { flex: 1; }
    .vt-ac-logo-name { font-size: 13px; font-weight: 600; margin: 0 0 2px; }
    .vt-ac-logo-hint { font-size: 11px; color: var(--vt-text-muted); margin: 0 0 6px; }
    .vt-ac-btn-choose {
        position: relative; overflow: hidden;
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px; border-radius: var(--vt-radius-sm);
        background: #fff; border: 1.5px solid var(--vt-border);
        font-size: 12px; font-weight: 600; color: var(--vt-text-main);
        cursor: pointer; transition: all .15s;
    }
    .vt-ac-btn-choose input[type="file"] { position: absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer; }
    .vt-ac-btn-choose:hover { border-color: #94a3b8; background: #f8fafc; }

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
    .vt-social-input {
        flex: 1; padding: 9px 10px;
        border: 1.5px solid var(--vt-border); border-left: none;
        border-radius: 0 var(--vt-radius-sm) var(--vt-radius-sm) 0;
        font-size: 12px; color: var(--vt-text-main); background: #fafafa;
        transition: border-color .15s;
    }
    .vt-social-input:focus { outline: none; border-color: var(--vt-orange); background: #fff; }
    .vt-social-input::placeholder { color: #b0bec5; }

    /* Toggle row */
    .vt-toggle-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 11px 14px; border-radius: var(--vt-radius-sm);
        background: #f8fafc; border: 1px solid var(--vt-border); margin-bottom: 8px;
    }
    .vt-toggle-label { font-size: 13px; font-weight: 500; color: var(--vt-text-main); }

    /* Zone image couverture */
    .vt-nc-cover-zone {
        position: relative; width: 100%; height: 160px;
        border: 2px dashed var(--vt-border); border-radius: var(--vt-radius-sm);
        background: #f8fafc; display: flex; align-items: center; justify-content: center;
        overflow: hidden; transition: border-color .15s; cursor: pointer;
    }
    .vt-nc-cover-zone:hover { border-color: var(--vt-orange); }
    .vt-nc-cover-placeholder { text-align: center; pointer-events: none; }
    .vt-nc-cover-placeholder i { font-size: 30px; color: #cbd5e1; }
    .vt-nc-cover-placeholder p { font-size: 11.5px; color: var(--vt-text-muted); margin: 6px 0 0; }
    .vt-nc-cover-preview { position: absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; display:none; }
    .vt-nc-cover-input { position: absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer; }
    .vt-nc-cover-del {
        display: none; margin-top: 6px;
        font-size: 11.5px; color: #dc2626; font-weight: 600;
        background: none; border: none; cursor: pointer;
        align-items: center; gap: 4px;
    }
    .vt-nc-cover-del.visible { display: inline-flex; }

    /* Radio pills */
    .vt-radio-pills { display: flex; }
    .vt-radio-pills input[type="radio"] { display: none; }
    .vt-radio-pills label {
        flex: 1; text-align: center; padding: 8px 0;
        font-size: 12.5px; font-weight: 600;
        border: 1.5px solid var(--vt-border); color: var(--vt-text-muted);
        cursor: pointer; transition: all .15s; background: #fafafa;
    }
    .vt-radio-pills label:first-of-type { border-radius: var(--vt-radius-sm) 0 0 var(--vt-radius-sm); }
    .vt-radio-pills label:last-of-type  { border-radius: 0 var(--vt-radius-sm) var(--vt-radius-sm) 0; }
    .vt-radio-pills input[type="radio"]:checked + label { background: var(--vt-orange-light); border-color: var(--vt-orange); color: var(--vt-orange); }

    /* Couleurs */
    .vt-color-wrap { display: flex; align-items: center; gap: 8px; }
    .vt-color-text {
        flex: 1; padding: 8px 10px; border: 1.5px solid var(--vt-border);
        border-radius: var(--vt-radius-sm); font-size: 12.5px; font-family: monospace;
        color: var(--vt-text-main); background: #fafafa;
    }
    .vt-color-text:focus { outline: none; border-color: var(--vt-orange); }
    .vt-color-swatch { width: 34px; height: 34px; border-radius: 7px; cursor: pointer; border: 1.5px solid var(--vt-border); padding: 2px; flex-shrink: 0; }

    /* Bloc dates inscriptions */
    .vt-insc-bloc {
        padding: 12px 14px; background: #f8fafc;
        border: 1px solid var(--vt-border); border-radius: var(--vt-radius-sm);
        margin-top: -4px; margin-bottom: 8px;
        display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
    }

    /* Footer modal */
    .vt-mfooter {
        display: flex; align-items: center; justify-content: flex-end;
        gap: 10px; padding: 16px 24px 20px;
        border-top: 1px solid var(--vt-border); margin-top: 8px;
        position: sticky; bottom: 0; background: #fff; z-index: 10;
    }
    .vt-mfooter-cancel {
        padding: 9px 22px; border-radius: var(--vt-radius-sm);
        border: 1.5px solid var(--vt-border); background: #fff;
        color: var(--vt-text-main); font-size: 13px; font-weight: 600;
        cursor: pointer; transition: all .15s;
    }
    .vt-mfooter-cancel:hover { border-color: #94a3b8; background: #f8fafc; }
    .vt-mfooter-submit {
        padding: 9px 22px; border-radius: var(--vt-radius-sm);
        background: var(--vt-orange); border: none; color: #fff;
        font-size: 13px; font-weight: 700; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px; transition: background .15s;
    }
    .vt-mfooter-submit:hover { background: #c2560a; }
    .vt-mfooter-submit:disabled { opacity: .65; cursor: not-allowed; }
    .vt-mfooter-danger {
        padding: 9px 22px; border-radius: var(--vt-radius-sm);
        background: #dc2626; border: none; color: #fff;
        font-size: 13px; font-weight: 700; cursor: pointer; flex: 1;
        display: inline-flex; align-items: center; justify-content: center;
        gap: 6px; transition: background .15s;
    }
    .vt-mfooter-danger:hover { background: #b91c1c; }

    /* Modal suppression — contenu centré */
    .vt-del-body { padding: 28px 24px 8px; text-align: center; }
    .vt-del-icon {
        width: 52px; height: 52px; border-radius: 50%;
        background: #fff5f5; border: 1.5px solid #fca5a5; color: #dc2626;
        font-size: 22px; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    .vt-del-title { font-size: 17px; font-weight: 700; margin: 0 0 8px; color: var(--vt-text-main); }
    .vt-del-desc { font-size: 13px; color: var(--vt-text-muted); margin: 0 0 4px; }
    .vt-del-footer { display: flex; gap: 10px; padding: 0 24px 24px; }
    .vt-del-footer .vt-mfooter-cancel { flex: 1; text-align: center; justify-content: center; display: flex; }
</style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    <div class="vt-lc-header">
        <h1 class="vt-lc-title">Clients</h1>
    </div>

    <div class="col-sm-12">@include('layout.status')</div>

    <div class="vt-card vt-lc-table-card" style="overflow:hidden;">

        {{-- Toolbar --}}
        <div class="vt-lc-toolbar">
            <span class="vt-lc-count"><strong>{{ $customers->count() }}</strong> client(s)</span>
            <div class="vt-lc-search-wrap">
                <i class="ti ti-search vt-lc-search-icon"></i>
                <input type="text" class="vt-lc-search" id="lc-search" placeholder="Rechercher...">
            </div>
            <button class="vt-btn-primary"
                    style="border-radius:var(--vt-radius-sm); padding:8px 18px; font-size:13px;"
                    data-bs-toggle="modal" data-bs-target="#modal_add_client">
                <i class="ti ti-plus" style="font-size:13px;"></i> Créer un client
            </button>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table class="vt-lc-table">
                <thead>
                    <tr>
                        <th>Organisation</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="lc-tbody">
                    @forelse ($customers as $customer)
                    <tr class="lc-row" data-search="{{ strtolower($customer->entreprise . ' ' . $customer->email . ' ' . $customer->phonenumber) }}">
                        <td>
                            <div class="vt-lc-org-cell">
                                <div class="vt-lc-logo">
                                    @if($customer->logo && $customer->logo !== 'default_logo.png')
                                        <img src="{{ asset(env('IMAGES_PATH') . '/' . $customer->logo) }}" alt="{{ $customer->entreprise }}">
                                    @else
                                        {{ strtoupper(substr($customer->entreprise ?? 'C', 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="vt-lc-org-name">{{ $customer->entreprise }}</div>
                                    <div class="vt-lc-org-email">{{ $customer->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $customer->phonenumber }}</td>
                        <td>{{ $customer->adresse }}</td>
                        <td>
                            @if($customer->is_active)
                                <span class="vt-lc-badge-actif"><i class="ti ti-check" style="font-size:10px;"></i> Actif</span>
                            @else
                                <span class="vt-lc-badge-inactif">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <div class="vt-lc-actions">
                                <a href="{{ route('console.detail_customer', $customer->customer_id) }}"
                                   class="vt-lc-btn view" title="Voir le détail">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <button type="button" class="vt-lc-btn del" title="Supprimer"
                                        data-bs-toggle="modal" data-bs-target="#delete_contact_{{ $customer->customer_id }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                                <button type="button" class="vt-lc-btn-session"
                                        data-bs-toggle="modal" data-bs-target="#modal_add_campaign_{{ $customer->customer_id }}">
                                    <i class="ti ti-plus" style="font-size:11px;"></i> Session
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="vt-lc-empty">Aucun client enregistré.</td>
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

{{-- MODAL — AJOUTER UN CLIENT --}}
<div class="modal fade" id="modal_add_client" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="vt-mhg">
                <div class="vt-mhg-icon"><i class="ti ti-user-plus"></i></div>
                <h5 class="vt-mhg-title">Ajouter un client</h5>
                <button type="button" class="vt-mhg-close" data-bs-dismiss="modal"><i class="ti ti-x"></i></button>
            </div>

            <form class="ajax-form" id="form_add_client"
                  action="{{ route('console.save_customer') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="role" value="customer">
                <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">

                <div class="vt-mbody">

                    {{-- SECTION : COMPTE --}}
                    <div class="vt-msect"><span>Compte de connexion</span></div>

                    <div class="vt-mf-row">
                        <div class="vt-mf">
                            <label class="vt-mf-label">Nom complet <span style="color:#ef4444;">*</span></label>
                            <div class="vt-mf-wrap">
                                <i class="ti ti-user vt-mf-icon"></i>
                                <input type="text" class="vt-mf-input" name="name" placeholder="Ex : Jean Dupont" required>
                            </div>
                        </div>
                        <div class="vt-mf">
                            <label class="vt-mf-label">Téléphone <span style="color:#ef4444;">*</span></label>
                            <div class="vt-mf-wrap">
                                <i class="ti ti-phone vt-mf-icon"></i>
                                <input type="text" class="vt-mf-input" name="phonenumber" placeholder="+225 07 00 00 00 00" required>
                            </div>
                        </div>
                    </div>

                    <div class="vt-mf">
                        <label class="vt-mf-label">Email — identifiant de connexion <span style="color:#ef4444;">*</span></label>
                        <div class="vt-mf-wrap">
                            <i class="ti ti-mail vt-mf-icon"></i>
                            <input type="email" class="vt-mf-input" name="email_customer" placeholder="jean@entreprise.com" required>
                        </div>
                    </div>

                    {{-- SECTION : ENTREPRISE --}}
                    <div class="vt-msect"><span>Informations entreprise</span></div>

                    {{-- Logo --}}
                    <div class="vt-ac-logo-zone">
                        <div class="vt-ac-logo-preview" id="ac-logo-preview">
                            <i class="ti ti-building"></i>
                        </div>
                        <div class="vt-ac-logo-info">
                            <p class="vt-ac-logo-name">Logo de l'organisation</p>
                            <p class="vt-ac-logo-hint">PNG / JPG · recommandé 512×512</p>
                            <label class="vt-ac-btn-choose">
                                <i class="ti ti-upload" style="font-size:12px;"></i> Choisir
                                <input type="file" name="logo" accept="image/*" onchange="handleAcLogoPreview(this)">
                            </label>
                        </div>
                    </div>

                    <div class="vt-mf-row">
                        <div class="vt-mf">
                            <label class="vt-mf-label">Nom de l'organisation <span style="color:#ef4444;">*</span></label>
                            <div class="vt-mf-wrap">
                                <i class="ti ti-building vt-mf-icon"></i>
                                <input type="text" class="vt-mf-input" name="entreprise" required>
                            </div>
                        </div>
                        <div class="vt-mf">
                            <label class="vt-mf-label">Pays siège <span style="color:#ef4444;">*</span></label>
                            <div class="vt-mf-wrap">
                                <i class="ti ti-map-pin vt-mf-icon"></i>
                                <select class="vt-mf-select" name="pays_siege" required>
                                    <option value="">Sélectionner</option>
                                    <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                    <option value="Senegal">Sénégal</option>
                                    <option value="France">France</option>
                                    <option value="USA">USA</option>
                                    <option value="Canada">Canada</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="vt-mf-row">
                        <div class="vt-mf">
                            <label class="vt-mf-label">Email de l'organisation</label>
                            <div class="vt-mf-wrap">
                                <i class="ti ti-mail vt-mf-icon"></i>
                                <input type="email" class="vt-mf-input" name="email" placeholder="contact@entreprise.com">
                            </div>
                        </div>
                        <div class="vt-mf">
                            <label class="vt-mf-label">Téléphone entreprise <span style="color:#ef4444;">*</span></label>
                            <div class="vt-mf-wrap">
                                <i class="ti ti-phone vt-mf-icon"></i>
                                <input type="text" class="vt-mf-input phone" name="phonenumber_entreprise" required>
                            </div>
                        </div>
                    </div>

                    <div class="vt-mf">
                        <label class="vt-mf-label">Adresse <span style="color:#ef4444;">*</span></label>
                        <div class="vt-mf-wrap">
                            <i class="ti ti-map vt-mf-icon"></i>
                            <input type="text" class="vt-mf-input" name="adresse" placeholder="Siège social" required>
                        </div>
                    </div>

                    {{-- SECTION : RÉSEAUX SOCIAUX --}}
                    <div class="vt-msect"><span>Réseaux sociaux</span></div>

                    <div class="vt-social-grid">
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-brand-facebook"></i></span>
                            <input type="url" class="vt-social-input" name="link_facebook" placeholder="Facebook URL">
                        </div>
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-brand-instagram"></i></span>
                            <input type="url" class="vt-social-input" name="link_instagram" placeholder="Instagram URL">
                        </div>
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-brand-linkedin"></i></span>
                            <input type="url" class="vt-social-input" name="link_linkedin" placeholder="LinkedIn URL">
                        </div>
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-brand-youtube"></i></span>
                            <input type="url" class="vt-social-input" name="link_youtube" placeholder="Youtube URL">
                        </div>
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-brand-tiktok"></i></span>
                            <input type="url" class="vt-social-input" name="link_tiktok" placeholder="Tiktok URL">
                        </div>
                        <div class="vt-social-item">
                            <span class="vt-social-prefix"><i class="ti ti-world"></i></span>
                            <input type="url" class="vt-social-input" name="link_website" placeholder="Site web">
                        </div>
                    </div>

                </div>

                <div class="vt-mfooter">
                    <button type="button" class="vt-mfooter-cancel" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="vt-mfooter-submit">
                        <i class="ti ti-check" style="font-size:13px;"></i> Confirmer
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- =====================================================
     MODALS — SUPPRIMER CLIENT
     ===================================================== --}}
@foreach($customers as $customer)
<div class="modal fade vt-delete-modal" id="delete_contact_{{ $customer->customer_id }}"
     data-bs-backdrop="static" data-bs-keyboard="false">
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
            <form method="POST" action="{{ route('console.delete_customer') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">
                <div class="vt-del-footer">
                    <button type="button" class="vt-mfooter-cancel" data-bs-dismiss="modal" style="flex:1;justify-content:center;display:flex;">Annuler</button>
                    <button type="submit" class="vt-mfooter-danger">
                        <i class="ti ti-trash" style="font-size:13px;"></i> Supprimer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- =====================================================
     MODALS — CRÉER UNE SESSION (par client)
     ===================================================== --}}
@foreach($customers as $customer)
<div class="modal fade vt-campaign-modal" id="modal_add_campaign_{{ $customer->customer_id }}"
     tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="vt-mhg">
                <div class="vt-mhg-icon"><i class="ti ti-calendar-plus"></i></div>
                <h5 class="vt-mhg-title">Nouvelle session — {{ $customer->entreprise }}</h5>
                <button type="button" class="vt-mhg-close" data-bs-dismiss="modal"><i class="ti ti-x"></i></button>
            </div>

            <form class="ajax-form" action="{{ route('console.save_campagne') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="vt-mbody">

                    {{-- SECTION : INFORMATIONS --}}
                    <div class="vt-msect"><span>Informations</span></div>

                    <div class="vt-mf">
                        <label class="vt-mf-label">Nom de la session <span style="color:#ef4444;">*</span></label>
                        <div class="vt-mf-wrap">
                            <i class="ti ti-calendar-event vt-mf-icon"></i>
                            <input type="text" class="vt-mf-input" name="name" placeholder="Ex : Élection Miss 2025" required>
                        </div>
                    </div>

                    <div class="vt-mf">
                        <label class="vt-mf-label">Promoteur</label>
                        <div class="vt-mf-wrap">
                            <i class="ti ti-building vt-mf-icon"></i>
                            <select class="vt-mf-select" name="customer_id" required>
                                <option value="{{ $customer->customer_id }}">{{ $customer->entreprise }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="vt-mf">
                        <label class="vt-mf-label">Description <span style="color:#ef4444;">*</span></label>
                        <div class="vt-mf-wrap">
                            <i class="ti ti-align-left vt-mf-icon" style="top:14px;transform:none;"></i>
                            <textarea class="vt-mf-input" name="description" rows="3" required></textarea>
                        </div>
                    </div>

                    {{-- SECTION : COUVERTURE --}}
                    <div class="vt-msect"><span>Image de couverture</span></div>

                    <div class="vt-nc-cover-zone" id="cover-zone-{{ $customer->customer_id }}">
                        <div class="vt-nc-cover-placeholder">
                            <i class="ti ti-cloud-upload"></i>
                            <p>Glissez une image ou cliquez &bull; 1920×1080 recommandé</p>
                        </div>
                        <img src="#" class="vt-nc-cover-preview" id="cover-preview-{{ $customer->customer_id }}" alt="">
                        <input type="file" name="image_couverture" class="vt-nc-cover-input"
                               accept="image/*"
                               onchange="handleNcCover(this, '{{ $customer->customer_id }}')">
                    </div>
                    <button type="button" class="vt-nc-cover-del" id="cover-del-{{ $customer->customer_id }}"
                            onclick="handleNcCoverRemove('{{ $customer->customer_id }}')">
                        <i class="ti ti-trash" style="font-size:12px;"></i> Supprimer l'image
                    </button>

                    {{-- SECTION : OPTIONS --}}
                    <div class="vt-msect"><span>Options</span></div>

                    <div class="vt-toggle-row">
                        <span class="vt-toggle-label">Texte sur le cover</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="text_cover_isActive" value="1">
                        </div>
                    </div>
                    <div class="vt-toggle-row">
                        <span class="vt-toggle-label">Identifiants candidats personnalisés</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="identifiants_personnalises_isActive" value="1">
                        </div>
                    </div>
                    <div class="vt-toggle-row">
                        <span class="vt-toggle-label">Ordonner les candidats par votes décroissants</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="ordonner_candidats_votes_decroissants" value="1">
                        </div>
                    </div>

                    {{-- Inscriptions --}}
                    <div class="vt-toggle-row">
                        <span class="vt-toggle-label">Autoriser les inscriptions</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input inscriptionSwitch" type="checkbox" name="inscription_isActive" value="1">
                        </div>
                    </div>
                    <div class="blocDates d-none">
                        <div class="vt-insc-bloc">
                            <div class="vt-mf">
                                <label class="vt-mf-label">Date début inscription</label>
                                <div class="vt-mf-wrap">
                                    <i class="ti ti-calendar vt-mf-icon"></i>
                                    <input type="date" class="vt-mf-input" name="inscription_date_debut">
                                </div>
                            </div>
                            <div class="vt-mf">
                                <label class="vt-mf-label">Heure début</label>
                                <div class="vt-mf-wrap">
                                    <i class="ti ti-clock vt-mf-icon"></i>
                                    <input type="time" class="vt-mf-input" name="heure_debut_inscription">
                                </div>
                            </div>
                            <div class="vt-mf">
                                <label class="vt-mf-label">Date fin inscription</label>
                                <div class="vt-mf-wrap">
                                    <i class="ti ti-calendar-off vt-mf-icon"></i>
                                    <input type="date" class="vt-mf-input" name="inscription_date_fin">
                                </div>
                            </div>
                            <div class="vt-mf">
                                <label class="vt-mf-label">Heure fin</label>
                                <div class="vt-mf-wrap">
                                    <i class="ti ti-clock-off vt-mf-icon"></i>
                                    <input type="time" class="vt-mf-input" name="heure_fin_inscription">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION : APPARENCE --}}
                    <div class="vt-msect"><span>Apparence</span></div>

                    <div class="vt-mf">
                        <label class="vt-mf-label">Affichage des votes</label>
                        <div class="vt-radio-pills">
                            <input type="radio" name="afficher_montant_pourcentage"
                                   id="opt_clair_{{ $customer->customer_id }}" value="clair" checked>
                            <label for="opt_clair_{{ $customer->customer_id }}">Clair</label>

                            <input type="radio" name="afficher_montant_pourcentage"
                                   id="opt_pct_{{ $customer->customer_id }}" value="pourcentage">
                            <label for="opt_pct_{{ $customer->customer_id }}">Pourcentage</label>

                            <input type="radio" name="afficher_montant_pourcentage"
                                   id="opt_deux_{{ $customer->customer_id }}" value="les_deux">
                            <label for="opt_deux_{{ $customer->customer_id }}">Les deux</label>
                        </div>
                    </div>

                    <div class="vt-mf-row">
                        <div class="vt-mf">
                            <label class="vt-mf-label">Couleur primaire</label>
                            <div class="vt-color-wrap">
                                <input type="text" class="vt-color-text" id="cp-{{ $customer->customer_id }}" value="#000000">
                                <input type="color" class="vt-color-swatch" name="color_primaire" value="#000000"
                                       oninput="document.getElementById('cp-{{ $customer->customer_id }}').value=this.value">
                            </div>
                        </div>
                        <div class="vt-mf">
                            <label class="vt-mf-label">Couleur secondaire</label>
                            <div class="vt-color-wrap">
                                <input type="text" class="vt-color-text" id="cs-{{ $customer->customer_id }}" value="#000000">
                                <input type="color" class="vt-color-swatch" name="color_secondaire" value="#000000"
                                       oninput="document.getElementById('cs-{{ $customer->customer_id }}').value=this.value">
                            </div>
                        </div>
                    </div>

                    {{-- SECTION : DOCUMENT --}}
                    <div class="vt-msect"><span>Document</span></div>

                    <div class="vt-mf">
                        <label class="vt-mf-label">Conditions de participation (PDF) <span style="color:#ef4444;">*</span></label>
                        <div class="vt-mf-wrap">
                            <i class="ti ti-file-text vt-mf-icon"></i>
                            <input type="file" class="vt-mf-input" name="condition_participation"
                                   accept=".pdf" style="padding-top:8px; cursor:pointer;">
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
@endforeach

@endsection

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
<script>
    /* ----- Recherche côté client ----- */
    document.getElementById('lc-search').addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('.lc-row').forEach(function (row) {
            row.style.display = row.dataset.search.includes(q) ? '' : 'none';
        });
    });

    /* ----- Toggle inscriptions ----- */
    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('inscriptionSwitch')) return;
        const bloc = e.target.closest('.modal-body, .vt-mbody')
                              .querySelector('.blocDates');
        if (bloc) bloc.classList.toggle('d-none', !e.target.checked);
    });

    /* ----- Logo aperçu (add client) ----- */
    function handleAcLogoPreview(input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            const $wrap = document.getElementById('ac-logo-preview');
            $wrap.innerHTML = '<img src="' + e.target.result + '" alt="">';
        };
        reader.readAsDataURL(input.files[0]);
    }

    /* ----- Image couverture campagne ----- */
    function handleNcCover(input, cid) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('cover-preview-' + cid);
            preview.src = e.target.result;
            preview.style.display = 'block';
            document.getElementById('cover-zone-' + cid).querySelector('.vt-nc-cover-placeholder').style.display = 'none';
            const del = document.getElementById('cover-del-' + cid);
            if (del) del.classList.add('visible');
        };
        reader.readAsDataURL(input.files[0]);
    }

    function handleNcCoverRemove(cid) {
        const preview = document.getElementById('cover-preview-' + cid);
        preview.src = '#';
        preview.style.display = 'none';
        document.getElementById('cover-zone-' + cid).querySelector('.vt-nc-cover-placeholder').style.display = '';
        const del = document.getElementById('cover-del-' + cid);
        if (del) del.classList.remove('visible');
        const input = document.getElementById('cover-zone-' + cid).querySelector('input[type="file"]');
        if (input) input.value = '';
    }
</script>
@endsection
