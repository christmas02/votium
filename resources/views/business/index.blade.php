@push('styles')
    @include('layout.css.business')
@endpush
@extends('layout.app.business')

@section('content')
    <main class="shell">
        <div class="breadcrumb">🏠 <span>Accueil</span> <span>›</span> <b>Tableau de bord</b></div>

        <!-- Start Content -->
        <div class="grid">
            <!-- LEFT FILTER -->
            <section class="card">
                <div class="hd">
                    <h3>FILTRER</h3>
                    <span class="tag"><span class="live"></span>LIVE</span>
                </div>
                <div class="bd filter-box">
                    <div class="stack">
                        <div>
                            <label>Choisir la session</label>
                            <select id="sessionSelect">
                                <option value="">— Aucune session —</option>
                            </select>
                        </div>
                        <div>
                            <label>Choisir l'étape</label>
                            <select id="stepSelect">
                                <option value="">— Étape —</option>
                            </select>
                        </div>
                        <div class="note">
                            <b>Rappel :</b><br />
                            Commission : <b><span id="remCommission">—</span></b><br />
                            Prix unitaire : <b><span id="remUnitPrice">—</span></b>
                        </div>
                    </div>
                </div>
                <aside class="stack">
                    <section class="card">
                        <div class="right-top">

                            <div class="balance">
                                <div>
                                    <div class="t muted">Votre solde</div>
                                    <div class="v"><span id="balanceValue">0</span><span>FCFA</span></div>
                                </div>
                                <div class="money-ico">S</div>
                            </div>
                        </div>
                    </section>

                </aside>
            </section>
            <!-- CENTER MAIN -->
            <section class="stack">
                <div class="card">
                    <div class="bd">
                        <div class="page-title">
                            <div>
                                <h1>Tableau de bord</h1>
                                <div class="subtitle">Synthèse • performance • activité récente.</div>
                            </div>
                            <div
                                style="display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end;flex-direction: row-reverse;">
                                <button class="btn primary">Nouvelle session</button>
                                <button class="btn ghost">Gérer les sessions</button>
                            </div>
                        </div>
                        <div class="kpi-grid" role="list">
                            <div class="kpi" role="listitem">
                                <div class="label"><span class="dot"></span> N. d'étape</div>
                                <div class="value"><span id="kpiStep">—</span></div>
                            </div>
                            <div class="kpi" role="listitem">
                                <div class="label"><span class="dot"></span> N. de candidats</div>
                                <div class="value"><span id="kpiCandidates">0</span></div>
                            </div>
                            <div class="kpi" role="listitem">
                                <div class="label"><span class="dot"></span> N. de votants*</div>
                                <div class="value"><span id="kpiVoters">0</span></div>
                            </div>
                            <div class="kpi" role="listitem">
                                <div class="label"><span class="dot"></span> Montant des votes*</div>
                                <div class="value"><span id="kpiAmount">0</span><span class="unit">FCFA</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="charts" style="grid-template-columns: 1fr;">
                    <div class="card">
                        <div class="hd">
                            <h3>Votes par jour</h3>
                            <span class="pill">Sur 7 jours</span>
                        </div>
                        <div class="bd">
                            <div class="chart-wrap">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="charts">

                    <div class="card">
                        <div class="hd">
                            <h3>Montant des votes par jour*</h3>
                            <span class="pill">Auto</span>
                        </div>
                        <div class="bd">
                            <div class="chart-wrap">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="hd">
                            <h3>Votes par étapes</h3>
                            <span class="pill">ONE</span>
                        </div>
                        <div class="bd">
                            <div class="chart-wrap">
                                <canvas id="donutChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="hd">
                        <h3>Derniers votes</h3>
                        <a class="pill" href="#">Voir la liste</a>
                    </div>
                    <div class="bd" style="padding:0;">
                        <table aria-label="Derniers votes" class="table">
                            <thead>
                                <tr>
                                    <th style="width:30%;">Session</th>
                                    <th style="width:18%;">Étape</th>
                                    <th style="width:8%;">Qté</th>
                                    <th style="width:14%;">Montant</th>
                                    <th style="width:18%;">Candidat</th>
                                    <th style="width:10%;">Date</th>
                                    <th style="width:10%;">Status</th>
                                </tr>
                            </thead>
                            <tbody id="recentVotes"></tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
        <!-- End Content -->
    </main>
@endsection
<!-- section js -->
@section('extra-js')
@endsection
