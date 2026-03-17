@extends('refont.layout.console')

@section('title', 'Paramètres')

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li>
        <a href="{{ route('console.espace') }}"><i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil</a>
    </li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li class="active">Paramètres</li>
@endsection

{{-- ===== CSS ===== --}}
@section('extra-css')
<style>
    /* ================================================================
       LAYOUT PAGE
       ================================================================ */
    .vt-prof-header {
        display: flex; align-items: center; justify-content: space-between;
        gap: 16px; margin-bottom: 22px; flex-wrap: wrap;
    }
    .vt-prof-title {
        font-size: 34px; font-weight: 800; color: var(--vt-text-main);
        margin: 0; letter-spacing: -.5px;
    }

    .vt-prof-layout {
        display: grid; grid-template-columns: 220px 1fr; gap: 18px;
        align-items: flex-start;
    }
    @media (max-width: 768px) { .vt-prof-layout { grid-template-columns: 1fr; } }

    /* ================================================================
       SIDEBAR TABS
       ================================================================ */
    .vt-tabs-card { overflow: hidden; }
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
       CONTENU
       ================================================================ */
    .vt-tab-pane { display: none; }
    .vt-tab-pane.active { display: block; }

    /* Section card header */
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
    .vt-section-sub { font-size: 11.5px; color: var(--vt-text-muted); margin: 0; }

    /* Champs formulaire */
    .vt-form-body { padding: 20px 22px; }
    .vt-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
    @media (max-width: 600px) { .vt-form-row { grid-template-columns: 1fr; } }
    .vt-form-group { margin-bottom: 0; }
    .vt-form-label {
        font-size: 11px; font-weight: 700; color: var(--vt-text-muted);
        letter-spacing: .5px; text-transform: uppercase; margin-bottom: 5px; display: block;
    }
    .vt-form-wrap { position: relative; }
    .vt-form-icon {
        position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 14px; pointer-events: none;
    }
    .vt-form-input {
        width: 100%; padding: 9px 12px 9px 34px;
        border: 1.5px solid var(--vt-border); border-radius: var(--vt-radius-sm);
        font-size: 13px; color: var(--vt-text-main); background: #fafafa;
        transition: border-color .15s;
    }
    .vt-form-input:focus { outline: none; border-color: var(--vt-orange); background: #fff; box-shadow: 0 0 0 3px rgba(249,115,22,.07); }
    .vt-form-input::placeholder { color: #b0bec5; }
    .vt-form-hint { font-size: 11px; color: var(--vt-text-muted); margin-top: 4px; }

    /* Footer formulaire */
    .vt-form-footer {
        display: flex; justify-content: flex-end;
        padding: 14px 22px 18px; border-top: 1px solid var(--vt-border); margin-top: 4px;
    }
    .vt-form-submit {
        padding: 9px 24px; border-radius: var(--vt-radius-sm);
        background: var(--vt-orange); border: none; color: #fff;
        font-size: 13px; font-weight: 700; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px; transition: background .15s;
    }
    .vt-form-submit:hover { background: #c2560a; }
</style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

    <div class="vt-prof-header">
        <h1 class="vt-prof-title">Paramètres</h1>
    </div>

    <div class="col-sm-12">@include('layout.status')</div>

    <div class="vt-prof-layout">

        {{-- ========================
             SIDEBAR TABS
             ======================== --}}
        <div class="vt-card vt-tabs-card">
            <button type="button" class="vt-tab-item active" data-tab="tab-profil">
                <i class="ti ti-user-circle"></i> Profil admin
            </button>
        </div>

        {{-- ========================
             CONTENU TABS
             ======================== --}}
        <div>

            {{-- TAB : PROFIL --}}
            <div class="vt-tab-pane active vt-card" id="tab-profil" style="overflow:hidden;">

                <div class="vt-section-head">
                    <div class="vt-section-icon"><i class="ti ti-user-shield"></i></div>
                    <div>
                        <p class="vt-section-title">Informations du compte admin</p>
                        <p class="vt-section-sub">Nom, email, téléphone et mot de passe</p>
                    </div>
                </div>

                <form class="ajax-form" action="{{ route('console.update_profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->user_id }}">

                    <div class="vt-form-body">

                        <div class="vt-form-row">
                            <div class="vt-form-group">
                                <label class="vt-form-label">Nom complet <span style="color:#ef4444;">*</span></label>
                                <div class="vt-form-wrap">
                                    <i class="ti ti-user vt-form-icon"></i>
                                    <input type="text" class="vt-form-input" name="name"
                                           value="{{ $user->name }}" required>
                                </div>
                            </div>
                            <div class="vt-form-group">
                                <label class="vt-form-label">Téléphone <span style="color:#ef4444;">*</span></label>
                                <div class="vt-form-wrap">
                                    <i class="ti ti-phone vt-form-icon"></i>
                                    <input type="text" class="vt-form-input" name="phonenumber"
                                           value="{{ $user->phonenumber }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="vt-form-row">
                            <div class="vt-form-group">
                                <label class="vt-form-label">Email — identifiant <span style="color:#ef4444;">*</span></label>
                                <div class="vt-form-wrap">
                                    <i class="ti ti-mail vt-form-icon"></i>
                                    <input type="email" class="vt-form-input" name="email"
                                           value="{{ $user->email }}" required>
                                </div>
                            </div>
                            <div class="vt-form-group">
                                <label class="vt-form-label">Nouveau mot de passe</label>
                                <div class="vt-form-wrap">
                                    <i class="ti ti-lock vt-form-icon"></i>
                                    <input type="password" class="vt-form-input" name="password"
                                           placeholder="Laisser vide pour conserver">
                                </div>
                                <p class="vt-form-hint">Laisser vide pour ne pas modifier.</p>
                            </div>
                        </div>

                    </div>

                    <div class="vt-form-footer">
                        <button type="submit" class="vt-form-submit">
                            <i class="ti ti-device-floppy" style="font-size:13px;"></i> Mettre à jour
                        </button>
                    </div>

                </form>
            </div>

        </div>
        {{-- fin contenu tabs --}}

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
