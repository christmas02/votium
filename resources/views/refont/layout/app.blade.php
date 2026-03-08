<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Votium') — Espace Promoteur</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    {{-- CSS existants du projet --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/css/dataTables.bootstrap5.min.css') }}">

    {{-- ================================================
         VOTIUM REFONT — Design System v1
         Variables & composants CSS réutilisables
         ================================================ --}}
    <style>
        /* ---- Variables ---- */
        :root {
            --vt-navy:          #1a2535;
            --vt-navy-dark:     #111c2d;
            --vt-orange:        #f97316;
            --vt-orange-hover:  #ea6c0a;
            --vt-orange-light:  #fff7ed;
            --vt-orange-border: #fed7aa;
            --vt-green:         #16a34a;
            --vt-green-light:   #dcfce7;
            --vt-blue-chart:    #60a5fa;
            --vt-page-bg:       #eef0f3;
            --vt-card-bg:       #ffffff;
            --vt-text-main:     #1e293b;
            --vt-text-muted:    #64748b;
            --vt-border:        #e2e8f0;
            --vt-navbar-h:      52px;
            --vt-radius:        14px;
            --vt-radius-sm:     8px;
            --vt-shadow:        0 1px 4px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.05);
            --vt-shadow-md:     0 4px 12px rgba(0,0,0,.08);
        }

        /* ---- Reset & base ---- */
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--vt-page-bg);
            color: var(--vt-text-main);
            font-size: 13.5px;
            line-height: 1.5;
        }

        /* ================================================
           NAVBAR HORIZONTALE
           ================================================ */
        .vt-navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--vt-navbar-h);
            background: var(--vt-navy);
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,.3);
        }
        .vt-navbar-inner {
            display: flex;
            align-items: center;
            height: 100%;
            padding: 0 28px;
            gap: 20px;
        }
        .vt-navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .vt-logo-circle {
            width: 34px; height: 34px;
            background: var(--vt-orange);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 15px; color: #fff;
        }
        .vt-brand-text { display: flex; flex-direction: column; line-height: 1.2; }
        .vt-brand-name  { font-size: 12.5px; font-weight: 700; color: #fff; letter-spacing: .4px; }
        .vt-brand-sub   { font-size: 10.5px; color: rgba(255,255,255,.45); }

        /* Nav links centrés */
        .vt-nav-links {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0; padding: 0;
            gap: 2px;
            flex: 1;
            justify-content: center;
        }
        .vt-nav-links li a {
            display: flex; align-items: center; gap: 5px;
            padding: 6px 12px;
            border-radius: 7px;
            color: rgba(255,255,255,.6);
            text-decoration: none;
            font-size: 12.5px; font-weight: 500;
            transition: all .15s;
            white-space: nowrap;
        }
        .vt-nav-links li a i { font-size: 14px; }
        .vt-nav-links li a:hover          { color: #fff; background: rgba(255,255,255,.09); }
        .vt-nav-links li.active a         { color: #fff; background: rgba(255,255,255,.13); }
        .vt-nav-links li a.vt-nav-disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }

        /* Bouton Promoteur */
        .vt-navbar-right { flex-shrink: 0; }
        .vt-promoteur-btn {
            display: flex; align-items: center; gap: 10px;
            background: var(--vt-orange);
            border: none; border-radius: 50px;
            padding: 5px 14px 5px 8px;
            color: #fff; font-size: 12.5px; font-weight: 600;
            cursor: pointer; transition: background .15s;
        }
        .vt-promoteur-btn:hover, .vt-promoteur-btn:focus { background: var(--vt-orange-hover); }
        .vt-promoteur-btn::after { display: none; }
        .vt-promoteur-avatar {
            width: 26px; height: 26px;
            border-radius: 50%; object-fit: cover;
            border: 2px solid rgba(255,255,255,.35);
        }

        /* ================================================
           BREADCRUMB BAR
           ================================================ */
        .vt-breadcrumb-bar {
            margin-top: var(--vt-navbar-h);
            padding: 10px 28px;
            background: transparent;
        }
        .vt-breadcrumb {
            display: flex; align-items: center; gap: 6px;
            font-size: 12.5px; color: var(--vt-text-muted);
            list-style: none; margin: 0; padding: 0;
        }
        .vt-breadcrumb li a {
            color: var(--vt-text-muted); text-decoration: none;
            display: flex; align-items: center; gap: 4px;
        }
        .vt-breadcrumb li a:hover { color: var(--vt-text-main); }
        .vt-breadcrumb li.active  { color: var(--vt-text-main); font-weight: 600; }
        .vt-breadcrumb-sep        { color: #b0bac7; font-size: 11px; }

        /* ================================================
           DÉCORATION (ligne orange)
           ================================================ */
        .vt-deco-line {
            width: 32px; height: 3px;
            background: var(--vt-orange);
            border-radius: 2px;
            margin: 4px auto 16px;
        }

        /* ================================================
           PAGE BODY (zone contenu sous breadcrumb)
           ================================================ */
        .vt-page-body {
            padding: 0 28px 32px;
        }

        /* ================================================
           DEUX COLONNES
           ================================================ */
        .vt-two-col {
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }

        /* ---- Colonne filtre ---- */
        .vt-filter-col {
            width: 248px;
            flex-shrink: 0;
        }
        .vt-filter-card {
            background: var(--vt-card-bg);
            border-radius: var(--vt-radius);
            padding: 20px 18px;
            box-shadow: var(--vt-shadow);
        }
        .vt-filter-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 18px;
        }
        .vt-filter-title {
            font-size: 11px; font-weight: 700; letter-spacing: 1.2px;
            color: var(--vt-text-main); text-transform: uppercase;
        }
        .vt-badge-live {
            background: var(--vt-green-light); color: var(--vt-green);
            font-size: 10.5px; font-weight: 700;
            padding: 3px 10px; border-radius: 50px;
            display: flex; align-items: center; gap: 5px;
        }
        .vt-badge-live::before {
            content: ''; width: 6px; height: 6px;
            background: var(--vt-green); border-radius: 50%;
            animation: vt-pulse 1.5s infinite;
        }
        @keyframes vt-pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: .4; }
        }
        .vt-filter-label {
            font-size: 11.5px; color: var(--vt-orange);
            font-weight: 600; margin-bottom: 6px;
        }
        .vt-filter-select {
            width: 100%;
            padding: 8px 30px 8px 11px;
            border: 1px solid var(--vt-border);
            border-radius: var(--vt-radius-sm);
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 9px center / 15px;
            appearance: none;
            font-size: 12.5px; color: var(--vt-text-main);
            cursor: pointer; transition: border-color .15s;
            margin-bottom: 14px;
        }
        .vt-filter-select:focus { outline: none; border-color: var(--vt-orange); }
        .vt-filter-info {
            background: var(--vt-orange-light);
            border: 1px solid var(--vt-orange-border);
            border-radius: var(--vt-radius-sm);
            padding: 12px 13px;
            font-size: 12px; color: #92400e; line-height: 1.9;
        }
        .vt-filter-info strong { color: #c2410c; }

        /* ---- Colonne principale ---- */
        .vt-main-col {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* ================================================
           COMPOSANTS RÉUTILISABLES
           ================================================ */

        /* Carte générique */
        .vt-card {
            background: var(--vt-card-bg);
            border-radius: var(--vt-radius);
            box-shadow: var(--vt-shadow);
        }

        /* --- Dashboard header card --- */
        .vt-dash-card { padding: 24px 24px 18px; }
        .vt-dash-top {
            display: flex; align-items: flex-start; justify-content: space-between;
            margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
        }
        .vt-dash-title   { font-size: 26px; font-weight: 700; color: var(--vt-text-main); margin: 0 0 3px; }
        .vt-dash-subtitle { font-size: 12.5px; color: var(--vt-text-muted); margin: 0; }

        /* Stat items dans la dash card */
        .vt-stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: var(--vt-border);
            border-radius: 10px;
            overflow: hidden;
        }
        .vt-stat-item {
            background: #fff;
            padding: 14px 16px;
        }
        .vt-stat-item:first-child { border-radius: 10px 0 0 10px; }
        .vt-stat-item:last-child  { border-radius: 0 10px 10px 0; }
        .vt-stat-label-row {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; color: var(--vt-text-muted); margin-bottom: 6px;
        }
        .vt-stat-radio {
            width: 13px; height: 13px; border-radius: 50%;
            border: 2px solid var(--vt-border); flex-shrink: 0;
        }
        .vt-stat-val  { font-size: 20px; font-weight: 700; color: var(--vt-text-main); line-height: 1; }
        .vt-stat-sub  { font-size: 11px; color: var(--vt-text-muted); margin-top: 3px; }

        /* --- Bouton principal --- */
        .vt-btn-primary {
            background: var(--vt-orange); color: #fff;
            border: none; border-radius: 50px;
            padding: 9px 20px;
            font-size: 13px; font-weight: 600;
            cursor: pointer; transition: background .15s;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
            white-space: nowrap;
        }
        .vt-btn-primary:hover { background: var(--vt-orange-hover); color: #fff; }

        /* --- Chart card --- */
        .vt-chart-card {
            background: var(--vt-card-bg);
            border-radius: var(--vt-radius);
            padding: 18px 18px 10px;
            box-shadow: var(--vt-shadow);
            height: 100%;
        }
        .vt-chart-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            margin-bottom: 4px;
        }
        .vt-chart-title {
            font-size: 13.5px; font-weight: 600; color: var(--vt-text-main); margin: 0;
        }
        .vt-chart-badge {
            font-size: 10.5px; font-weight: 600; color: var(--vt-text-muted);
            background: var(--vt-page-bg);
            padding: 2px 8px; border-radius: 4px; flex-shrink: 0;
        }

        /* --- Table card --- */
        .vt-table-card { overflow: hidden; }
        .vt-table-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--vt-border);
        }
        .vt-table-title { font-size: 14px; font-weight: 600; color: var(--vt-text-main); margin: 0; }
        .vt-table-link  {
            font-size: 12px; color: var(--vt-text-muted);
            text-decoration: none; font-weight: 500;
        }
        .vt-table-link:hover { color: var(--vt-orange); }
        .vt-table-wrapper { overflow-x: auto; }
        .vt-table {
            width: 100%; border-collapse: collapse; font-size: 12px;
        }
        .vt-table thead th {
            padding: 10px 16px;
            text-transform: uppercase; font-size: 10.5px; letter-spacing: .5px;
            color: var(--vt-text-muted);
            border-bottom: 1px solid var(--vt-border); font-weight: 600;
            white-space: nowrap;
        }
        .vt-table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--vt-border);
            color: var(--vt-text-main);
        }
        .vt-table tbody tr:last-child td { border-bottom: none; }
        .vt-table-empty {
            padding: 24px 16px;
            color: var(--vt-text-muted); font-size: 12.5px;
        }

        /* --- Footer --- */
        .vt-footer {
            text-align: center; padding: 20px 0;
            font-size: 11.5px; color: #94a3b8;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .vt-two-col { flex-direction: column; }
            .vt-filter-col { width: 100%; }
            .vt-stats-row { grid-template-columns: repeat(2, 1fr); }
            .vt-nav-links { display: none; }
        }
        @media (max-width: 600px) {
            .vt-stats-row { grid-template-columns: 1fr 1fr; }
            .vt-page-body { padding: 0 12px 24px; }
        }
    </style>

    @yield('extra-css')
</head>
<body>

    {{-- Navbar --}}
    @include('refont.partials.navbar')

    {{-- Breadcrumb --}}
    <div class="vt-breadcrumb-bar">
        <ol class="vt-breadcrumb">
            @yield('breadcrumb')
        </ol>
    </div>

    {{-- Décoration ligne orange centrée --}}
    @hasSection('deco-line')
        <div class="vt-deco-line"></div>
    @endif

    {{-- Contenu --}}
    <div class="vt-page-body">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="vt-footer">
        With ❤️ by VOTIUM &bull; Prototype dashboard (front-only)
    </footer>

    {{-- Scripts --}}
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    {{-- Gestionnaire global AJAX --}}
    <script>
        $(document).on('submit', 'form', function() {
            var $form = $(this);
            var $btn = $form.find('button[type="submit"]');
            if (this.checkValidity()) {
                $btn.prop('disabled', true);
                var loadingText = '<i class="ti ti-loader-2 ti-spin"></i> Patientez...';
                if ($btn.html() !== loadingText) {
                    $btn.data('original-text', $btn.html());
                    $btn.html(loadingText);
                }
            }
        });
        $(document).ready(function() {
            $(document).on('submit', '.ajax-form', function(e) {
                e.preventDefault();
                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');
                const formData = new FormData(this);
                const originalBtnHtml = $submitBtn.html();
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();
                $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Traitement...');
                $.ajax({
                    url: $form.attr('action'), method: $form.attr('method'),
                    data: formData, processData: false, contentType: false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Accept': 'application/json' },
                    success: function(response) {
                        if (typeof showAjaxAlert === 'function') showAjaxAlert('success', response.message || 'Action réussie !');
                        const $modal = $form.closest('.modal');
                        if ($modal.length) setTimeout(() => $modal.modal('hide'), 1000);
                        if (response.redirect) window.location.href = response.redirect;
                        else setTimeout(() => location.reload(), 1500);
                    },
                    error: function(xhr) {
                        $submitBtn.prop('disabled', false).html(originalBtnHtml);
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (typeof showAjaxAlert === 'function') showAjaxAlert('danger', "Veuillez vérifier les champs du formulaire.");
                            $.each(errors, function(fieldName, messages) {
                                let $input = $form.find(`[name="${fieldName}"], [name="${fieldName}[]"]`).first();
                                if ($input.length) {
                                    $input.addClass('is-invalid');
                                    let msg = `<div class="invalid-feedback d-block">${messages[0]}</div>`;
                                    if ($input.closest('.input-group').length) $input.closest('.input-group').after(msg);
                                    else $input.after(msg);
                                }
                            });
                            $form.find('.is-invalid').first().focus();
                        } else {
                            const errorTxt = xhr.responseJSON?.message || "Une erreur est survenue.";
                            if (typeof showAjaxAlert === 'function') showAjaxAlert('danger', errorTxt);
                        }
                    }
                });
            });
        });
    </script>

    @yield('extra-js')
</body>
</html>
