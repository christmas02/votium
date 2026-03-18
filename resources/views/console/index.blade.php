@extends('refont.layout.console')

@section('title', 'Console d\'administration')
@section('deco-line')@endsection

{{-- ===== BREADCRUMB ===== --}}
@section('breadcrumb')
    <li>
        <a href="{{ route('console.espace') }}">
            <i class="ti ti-home" style="font-size:13px;"></i>&nbsp;Accueil
        </a>
    </li>
    <li class="vt-breadcrumb-sep"><i class="ti ti-chevron-right" style="font-size:11px;"></i></li>
    <li class="active">Tableau de bord</li>
@endsection

{{-- ===== CSS SPÉCIFIQUE ===== --}}
@section('extra-css')
<style>
    /* Badges statut dans le tableau */
    .vt-badge-actif {
        background: var(--vt-green-light); color: var(--vt-green);
        font-size: 10.5px; font-weight: 700; padding: 3px 10px;
        border-radius: 50px; display: inline-flex; align-items: center; gap: 4px;
    }
    .vt-badge-inactif {
        background: #f1f5f9; color: var(--vt-text-muted);
        font-size: 10.5px; font-weight: 600; padding: 3px 10px; border-radius: 50px;
    }
    .vt-badge-pending {
        background: #fef9c3; color: #a16207;
        font-size: 10.5px; font-weight: 600; padding: 3px 10px; border-radius: 50px;
    }

    /* Cellule client avec avatar */
    .vt-cell-client {
        display: flex; align-items: center; gap: 10px;
    }
    .vt-cell-avatar {
        width: 30px; height: 30px; border-radius: 7px;
        background: var(--vt-orange-light); color: var(--vt-orange);
        font-size: 12px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; overflow: hidden;
    }
    .vt-cell-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .vt-cell-name { font-weight: 600; font-size: 12.5px; }
    .vt-cell-sub  { font-size: 11px; color: var(--vt-text-muted); }

    /* Lien tableau orange */
    .vt-table-link-orange {
        color: var(--vt-orange); text-decoration: none; font-weight: 600; font-size: 12px;
    }
    .vt-table-link-orange:hover { text-decoration: underline; }
</style>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

<div class="vt-two-col">

    {{-- =====================================================
         COLONNE GAUCHE — FILTRE
         ===================================================== --}}
    <div class="vt-filter-col">
        <div class="vt-filter-card">

            <div class="vt-filter-header">
                <span class="vt-filter-title">Filtrer</span>
                <span class="vt-badge-live">LIVE</span>
            </div>

            <p class="vt-filter-label">Statut client</p>
            <select class="vt-filter-select" id="filter-statut">
                <option value="">— Tous —</option>
                <option value="1">Actifs</option>
                <option value="0">Inactifs</option>
            </select>

            <p class="vt-filter-label">Choisir un client</p>
            <select class="vt-filter-select" id="filter-client">
                <option value="">— Tous les clients —</option>
            </select>

            <div class="vt-filter-info">
                <strong>Admin :</strong><br>
                Clients actifs : <span id="info-clients-actifs">—</span><br>
                Sessions totales : <span id="info-sessions">—</span>
            </div>

        </div>
    </div>

    {{-- =====================================================
         COLONNE PRINCIPALE
         ===================================================== --}}
    <div class="vt-main-col">

        {{-- CARD DASHBOARD (titre + stats) --}}
        <div class="vt-card vt-dash-card">
            <div class="vt-dash-top">
                <div>
                    <h1 class="vt-dash-title">Console d'administration</h1>
                    <p class="vt-dash-subtitle">Vue d'ensemble &bull; clients &bull; sessions &bull; activité.</p>
                </div>
                <a href="{{ route('console.list_customer') }}" class="vt-btn-primary">
                    <i class="ti ti-users" style="font-size:13px;"></i> Gérer les clients
                </a>
            </div>

            {{-- 4 stats --}}
            <div class="vt-stats-row">
                <div class="vt-stat-item">
                    <div class="vt-stat-label-row">
                        <span class="vt-stat-radio"></span>
                        Clients
                    </div>
                    <div class="vt-stat-val" id="stat-clients">—</div>
                    <div class="vt-stat-sub">enregistrés</div>
                </div>
                <div class="vt-stat-item">
                    <div class="vt-stat-label-row">
                        <span class="vt-stat-radio"></span>
                        Sessions
                    </div>
                    <div class="vt-stat-val" id="stat-sessions">—</div>
                    <div class="vt-stat-sub">au total</div>
                </div>
                <div class="vt-stat-item">
                    <div class="vt-stat-label-row">
                        <span class="vt-stat-radio"></span>
                        Candidats
                    </div>
                    <div class="vt-stat-val" id="stat-candidats">—</div>
                    <div class="vt-stat-sub">inscrits</div>
                </div>
                <div class="vt-stat-item">
                    <div class="vt-stat-label-row">
                        <span class="vt-stat-radio"></span>
                        Votes
                    </div>
                    <div class="vt-stat-val" id="stat-votes">—</div>
                    <div class="vt-stat-sub">au total</div>
                </div>
            </div>
        </div>

        {{-- GRAPHIQUES --}}
        <div class="row g-3">

            <div class="col-lg-5">
                <div class="vt-chart-card">
                    <div class="vt-chart-header">
                        <h6 class="vt-chart-title">Sessions par mois</h6>
                        <span class="vt-chart-badge">12 mois</span>
                    </div>
                    <div id="chart-sessions-mois"></div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="vt-chart-card">
                    <div class="vt-chart-header" style="align-items:flex-start;">
                        <h6 class="vt-chart-title" style="line-height:1.35;font-size:12.5px;max-width:100px;">
                            Clients actifs / inactifs
                        </h6>
                        <span class="vt-chart-badge">Ratio</span>
                    </div>
                    <div id="chart-clients-ratio"></div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="vt-chart-card">
                    <div class="vt-chart-header">
                        <h6 class="vt-chart-title">Votes par session</h6>
                        <span class="vt-chart-badge">TOP 5</span>
                    </div>
                    <div id="chart-votes-sessions"></div>
                </div>
            </div>

        </div>

        {{-- TABLEAU DERNIERS CLIENTS --}}
        <div class="vt-card vt-table-card">

            <div class="vt-table-header">
                <h6 class="vt-table-title">Derniers clients enregistrés</h6>
                <a href="{{ route('console.list_customer') }}" class="vt-table-link">Voir tous</a>
            </div>

            <div class="vt-table-wrapper">
                <table class="vt-table">
                    <thead>
                        <tr>
                            <th>Client / Organisation</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Sessions</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-derniers-clients">
                        <tr>
                            <td colspan="6" class="vt-table-empty">
                                Aucune donnée disponible.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    {{-- fin colonne principale --}}

</div>

@endsection

{{-- ===== SCRIPTS ===== --}}
@section('extra-js')
<script>
$(document).ready(function () {

    /* -------------------------------------------------------
       Graphique 1 — Sessions par mois (barres)
       ------------------------------------------------------- */
    new ApexCharts(document.querySelector('#chart-sessions-mois'), {
        chart: { type: 'bar', height: 220, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Sessions', data: [0,0,0,0,0,0,0,0,0,0,0,0] }],
        xaxis: {
            categories: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
            axisBorder: { show: false }, axisTicks: { show: false },
            labels: { style: { fontSize: '10px', colors: '#94a3b8' } }
        },
        yaxis: { min: 0, max: 1, tickAmount: 1, labels: { style: { fontSize: '11px', colors: '#94a3b8' } } },
        colors: ['#f97316'],
        fill: { opacity: .75 },
        plotOptions: { bar: { borderRadius: 3, columnWidth: '52%' } },
        dataLabels: { enabled: false },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4, padding: { left: 4, right: 4 } },
        tooltip: { theme: 'light' }
    }).render();

    /* -------------------------------------------------------
       Graphique 2 — Clients actifs / inactifs (donut)
       ------------------------------------------------------- */
    new ApexCharts(document.querySelector('#chart-clients-ratio'), {
        chart: { type: 'donut', height: 220 },
        series: [1, 0],
        labels: ['Actifs', 'Inactifs'],
        colors: ['#16a34a', '#e2e8f0'],
        legend: { show: false },
        dataLabels: { enabled: false },
        plotOptions: { pie: { donut: { size: '62%', labels: { show: false } } } },
        tooltip: { theme: 'light' }
    }).render();

    /* -------------------------------------------------------
       Graphique 3 — Votes par session (barres horizontales)
       ------------------------------------------------------- */
    new ApexCharts(document.querySelector('#chart-votes-sessions'), {
        chart: { type: 'bar', height: 220, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Votes', data: [0,0,0,0,0] }],
        xaxis: {
            categories: ['S1','S2','S3','S4','S5'],
            axisBorder: { show: false }, axisTicks: { show: false },
            labels: { style: { fontSize: '11px', colors: '#94a3b8' } }
        },
        yaxis: { min: 0, max: 1, tickAmount: 1, labels: { style: { fontSize: '11px', colors: '#94a3b8' } } },
        colors: ['#60a5fa'],
        fill: { opacity: .8 },
        plotOptions: { bar: { borderRadius: 3, columnWidth: '50%' } },
        dataLabels: { enabled: false },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4, padding: { left: 4, right: 4 } },
        tooltip: { theme: 'light' }
    }).render();

});
</script>
@endsection
