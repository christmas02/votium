@extends('refont.layout.app')

@section('title', 'Tableau de bord')
@section('deco-line')@endsection

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
    <li class="active">Tableau de bord</li>
@endsection

{{-- ===== CONTENU ===== --}}
@section('content')

<div class="vt-two-col">

    {{-- =====================================================
         COLONNE GAUCHE — PANEL FILTRE
         ===================================================== --}}
    <div class="vt-filter-col">
        <div class="vt-filter-card">

            <div class="vt-filter-header">
                <span class="vt-filter-title">Filtrer</span>
                <span class="vt-badge-live">LIVE</span>
            </div>

            <p class="vt-filter-label">Choisir la session</p>
            <select class="vt-filter-select" id="filter-session">
                <option value="">— Aucune session —</option>
            </select>

            <p class="vt-filter-label">Choisir l'étape</p>
            <select class="vt-filter-select" id="filter-etape" disabled>
                <option value="">— Étape —</option>
            </select>

            <div class="vt-filter-info">
                <strong>Rappel :</strong><br>
                Commission : <span id="info-commission">—</span><br>
                Prix unitaire : <span id="info-prix">—</span>
            </div>

        </div>
    </div>
    {{-- fin colonne filtre --}}

    {{-- =====================================================
         COLONNE PRINCIPALE
         ===================================================== --}}
    <div class="vt-main-col">

        {{-- ----- CARD TABLEAU DE BORD (header + stats) ----- --}}
        <div class="vt-card vt-dash-card">

            <div class="vt-dash-top">
                <div>
                    <h1 class="vt-dash-title">Tableau de bord</h1>
                    <p class="vt-dash-subtitle">Synthèse &bull; performance &bull; activité récente.</p>
                </div>
                <a href="javascript:void(0);" class="vt-btn-primary"
                   data-bs-toggle="modal" data-bs-target="#modal_add_campaign">
                    Nouvelle session
                </a>
            </div>

            {{-- 4 stats --}}
            <div class="vt-stats-row">

                <div class="vt-stat-item">
                    <div class="vt-stat-label-row">
                        <span class="vt-stat-radio"></span>
                        N. d'étape
                    </div>
                    <div class="vt-stat-val" id="stat-etapes">—</div>
                </div>

                <div class="vt-stat-item">
                    <div class="vt-stat-label-row">
                        <span class="vt-stat-radio"></span>
                        N. de candidats
                    </div>
                    <div class="vt-stat-val" id="stat-candidats">0</div>
                </div>

                <div class="vt-stat-item">
                    <div class="vt-stat-label-row">
                        <span class="vt-stat-radio"></span>
                        N. de votants *
                    </div>
                    <div class="vt-stat-val" id="stat-votants">0</div>
                </div>

                <div class="vt-stat-item">
                    <div class="vt-stat-label-row">
                        <span class="vt-stat-radio"></span>
                        Montant des votes *
                    </div>
                    <div class="vt-stat-val" id="stat-montant">0</div>
                    <div class="vt-stat-sub">FCFA</div>
                </div>

            </div>
            {{-- fin stats --}}

        </div>
        {{-- fin dash card --}}

        {{-- ----- GRAPHIQUES (3 cartes) ----- --}}
        <div class="row g-3">

            {{-- Votes par jour --}}
            <div class="col-lg-5">
                <div class="vt-chart-card">
                    <div class="vt-chart-header">
                        <h6 class="vt-chart-title">Votes par jour</h6>
                        <span class="vt-chart-badge">Sur 7 jours</span>
                    </div>
                    <div id="chart-votes-jour"></div>
                </div>
            </div>

            {{-- Montant des votes par jour --}}
            <div class="col-lg-3">
                <div class="vt-chart-card">
                    <div class="vt-chart-header" style="align-items:flex-start;">
                        <h6 class="vt-chart-title" style="line-height:1.35; font-size:12.5px; max-width:100px;">
                            Montant des votes par jour *
                        </h6>
                        <span class="vt-chart-badge">Auto</span>
                    </div>
                    <div id="chart-montant-jour"></div>
                </div>
            </div>

            {{-- Votes par étapes (donut) --}}
            <div class="col-lg-4">
                <div class="vt-chart-card">
                    <div class="vt-chart-header">
                        <h6 class="vt-chart-title">Votes par étapes</h6>
                        <span class="vt-chart-badge">ONE</span>
                    </div>
                    <div id="chart-votes-etapes"></div>
                </div>
            </div>

        </div>
        {{-- fin row graphiques --}}

        {{-- ----- TABLEAU DERNIERS VOTES ----- --}}
        <div class="vt-card vt-table-card">

            <div class="vt-table-header">
                <h6 class="vt-table-title">Derniers votes</h6>
                <a href="{{ route('business.list_vote') }}" class="vt-table-link">Voir la liste</a>
            </div>

            <div class="vt-table-wrapper">
                <table class="vt-table">
                    <thead>
                        <tr>
                            <th>Session</th>
                            <th>Étape</th>
                            <th>Qté</th>
                            <th>Montant</th>
                            <th>Candidat</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="table-derniers-votes">
                        <tr>
                            <td colspan="7" class="vt-table-empty">
                                Aucune donnée de votes enregistrée pour cette sélection.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        {{-- fin table card --}}

    </div>
    {{-- fin colonne principale --}}

</div>
{{-- fin two-col --}}

@endsection

{{-- ===== SCRIPTS DASHBOARD ===== --}}
@section('extra-js')
<script>
$(document).ready(function () {

    /* -------------------------------------------------------
       Graphique 1 — Votes par jour (barres)
       ------------------------------------------------------- */
    new ApexCharts(document.querySelector('#chart-votes-jour'), {
        chart: {
            type: 'bar', height: 220,
            toolbar: { show: false },
            background: 'transparent'
        },
        series: [{ name: 'Votes', data: [0, 0, 0, 0, 0, 0, 0] }],
        xaxis: {
            categories: ['lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.', 'dim.'],
            axisBorder: { show: false }, axisTicks: { show: false },
            labels: { style: { fontSize: '11px', colors: '#94a3b8' } }
        },
        yaxis: {
            min: 0, max: 1, tickAmount: 1,
            labels: { style: { fontSize: '11px', colors: '#94a3b8' } }
        },
        colors: ['#60a5fa'],
        fill: { opacity: .75 },
        plotOptions: { bar: { borderRadius: 3, columnWidth: '52%' } },
        dataLabels: { enabled: false },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4, padding: { left: 4, right: 4 } },
        tooltip: { theme: 'light' }
    }).render();

    /* -------------------------------------------------------
       Graphique 2 — Montant des votes par jour (ligne)
       ------------------------------------------------------- */
    new ApexCharts(document.querySelector('#chart-montant-jour'), {
        chart: {
            type: 'line', height: 220,
            toolbar: { show: false },
            background: 'transparent'
        },
        series: [{ name: 'Montant (FCFA)', data: [0, 0, 0, 0] }],
        xaxis: {
            categories: ['lun.', 'mer.', 'ven.', 'dim.'],
            axisBorder: { show: false }, axisTicks: { show: false },
            labels: { style: { fontSize: '10px', colors: '#94a3b8' }, rotate: -30 }
        },
        yaxis: {
            min: 0, max: 1, tickAmount: 1,
            labels: { style: { fontSize: '10px', colors: '#94a3b8' } }
        },
        colors: ['#60a5fa'],
        stroke: { curve: 'smooth', width: 2 },
        markers: { size: 4, colors: ['#60a5fa'], strokeColors: '#fff', strokeWidth: 2 },
        dataLabels: { enabled: false },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4, padding: { left: 4, right: 4 } },
        tooltip: { theme: 'light' }
    }).render();

    /* -------------------------------------------------------
       Graphique 3 — Votes par étapes (donut)
       ------------------------------------------------------- */
    new ApexCharts(document.querySelector('#chart-votes-etapes'), {
        chart: { type: 'donut', height: 220 },
        series: [100],
        labels: ['Aucune étape'],
        colors: ['#60a5fa'],
        legend: { show: false },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: { donut: { size: '62%', labels: { show: false } } }
        },
        tooltip: { theme: 'light' }
    }).render();

    /* -------------------------------------------------------
       Filtres dynamiques
       ------------------------------------------------------- */
    $('#filter-session').on('change', function () {
        var sid = $(this).val();
        $('#filter-etape').html('<option value="">— Étape —</option>').prop('disabled', !sid);
        $('#info-commission, #info-prix').text('—');
        if (!sid) return;
        // TODO : charger les étapes
        // $.get('/business/api/session/' + sid + '/etapes', function(data) {
        //     data.forEach(e => $('#filter-etape').append(
        //         '<option value="'+e.id+'">'+e.nom+'</option>'
        //     ));
        //     $('#filter-etape').prop('disabled', false);
        // });
    });

    $('#filter-etape').on('change', function () {
        var eid = $(this).val();
        if (!eid) { $('#info-commission, #info-prix').text('—'); return; }
        // TODO : charger les infos étape
        // $.get('/business/api/etape/' + eid, function(data) {
        //     $('#info-commission').text(data.commission + ' %');
        //     $('#info-prix').text(data.prix_unitaire + ' FCFA');
        // });
    });

});
</script>
@endsection
