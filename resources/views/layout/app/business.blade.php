<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width,initial-scale=1" name="viewport" />
    <title>VOTIUM — Dashboard (Promoteur)</title>
    <link rel="icon" href="{{ asset('asset/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('asset/favicon.png') }}">
    <meta content="#01233f" name="theme-color" />

    {{-- Style spécifique injecté par chaque page --}}
    @stack('styles')

    <link href="{{ asset('asset/app.css') }}" rel="stylesheet" />

    <script defer="True" src="{{ asset('asset/app.js') }}"></script>
</head>

<body class="has-topbar" data-role="Promoteur">

    @include('layout.header.business')


    @yield('content')

    <div class="foot">With ❤️ by VOTIUM • Expérience premium</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function() {
            const SESS_KEY = 'votium_sessions_v1';
            const CAND_KEY = 'votium_candidates_v1';
            const SELECT_KEY = 'votium_selected_session';

            const $ = (s, r = document) => r.querySelector(s);

            const sessionSelect = $('#sessionSelect');
            const stepSelect = $('#stepSelect');

            const kpiStep = $('#kpiStep');
            const kpiCandidates = $('#kpiCandidates');
            const kpiVoters = $('#kpiVoters');
            const kpiAmount = $('#kpiAmount');

            const recentTbody = $('#recentVotes');
            const leadersBox = $('#leaders');

            const currentSessionName = $('#currentSessionName');
            const sessionTitle = $('#sessionTitle');
            const balanceValue = $('#balanceValue');

            const DEFAULT_UNIT_PRICE = 200; // FCFA par vote (fallback)
            const TX_KEY = "votium_votes_tx_v1";
            let CURRENT_UNIT_PRICE = DEFAULT_UNIT_PRICE;
            let CURRENT_COMMISSION_RATE = 0;

            function safeJsonParse(v, fallback) {
                try {
                    return JSON.parse(v);
                } catch (e) {
                    return fallback;
                }
            }

            function getVoteTx() {
                const raw = localStorage.getItem(TX_KEY);
                const arr = safeJsonParse(raw, []);
                return Array.isArray(arr) ? arr : [];
            }

            function normalizeCommissionRate(s) {
                const v = (s && (s.commissionRate ?? s.commission ?? s.feeRate ?? s.fee)) ?? null;
                if (v === null || v === undefined) return 0;
                const n = Number(v);
                if (!isFinite(n)) return 0;
                return n > 1 ? (n / 100) : Math.max(0, Math.min(1, n));
            }

            function getUnitPriceForSession(s) {
                const v = (s && (s.unitPrice ?? s.votePrice ?? s.pricePerVote ?? s.prixVote ?? s.prix_unitaire)) ??
                    null;
                const n = Number(v);
                return isFinite(n) && n > 0 ? n : DEFAULT_UNIT_PRICE;
            }

            function getSessionBalance(s) {
                const v = (s && (s.balance ?? s.solde ?? s.wallet ?? s.walletBalance)) ?? null;
                const n = Number(v);
                return isFinite(n) ? n : null;
            }

            function filterTx(sessionId, stepId) {
                const list = getVoteTx();
                return list.filter(tx => {
                    if (String(tx.sessionId || "") !== String(sessionId || "")) return false;
                    if (stepId && String(tx.stepId || "") !== String(stepId)) return false;
                    return String(tx.status || "").toUpperCase() === "SUCCESS";
                });
            }

            function sumVotes(txList) {
                return txList.reduce((acc, tx) => acc + Number(tx.votesCount || 0), 0);
            }

            function sumAmount(txList, unitPrice) {
                return txList.reduce((acc, tx) => {
                    const a = Number(tx.amount);
                    if (isFinite(a) && a > 0) return acc + a;
                    return acc + (Number(tx.votesCount || 0) * Number(unitPrice || 0));
                }, 0);
            }

            function votesByCandidate(txList) {
                const map = {};
                txList.forEach(tx => {
                    const cid = String(tx.candidateId || "");
                    map[cid] = (map[cid] || 0) + Number(tx.votesCount || 0);
                });
                return map;
            }

            function votesByDay(txList) {
                const map = {};
                txList.forEach(tx => {
                    const d = (tx.createdAt ? new Date(tx.createdAt) : new Date());
                    const key = d.toISOString().slice(0, 10); // YYYY-MM-DD
                    map[key] = (map[key] || 0) + Number(tx.votesCount || 0);
                });
                return map;
            }

            function amountByDay(txList, unitPrice) {
                const map = {};
                txList.forEach(tx => {
                    const d = (tx.createdAt ? new Date(tx.createdAt) : new Date());
                    const key = d.toISOString().slice(0, 10);
                    const a = (isFinite(Number(tx.amount)) && Number(tx.amount) > 0) ? Number(tx.amount) : (
                        Number(tx.votesCount || 0) * Number(unitPrice || 0));
                    map[key] = (map[key] || 0) + a;
                });
                return map;
            }

            function votesByStep(txList) {
                const map = {};
                txList.forEach(tx => {
                    const sid = String(tx.stepId || "");
                    map[sid] = (map[sid] || 0) + Number(tx.votesCount || 0);
                });
                return map;
            }

            function loadSessions() {
                const raw = localStorage.getItem(SESS_KEY);
                const arr = safeJsonParse(raw, []);
                return Array.isArray(arr) ? arr : [];
            }

            function loadCandidates() {
                const raw = localStorage.getItem(CAND_KEY);
                const arr = safeJsonParse(raw, []);
                return Array.isArray(arr) ? arr : [];
            }

            function formatMoney(n) {
                const x = Number(n || 0);
                return x.toLocaleString('fr-FR');
            }

            function sessionLooksReal(s) {
                // On ignore les "démos" (anciennes seeds) qui n'ont pas d'étapes configurées
                return s && Array.isArray(s.steps) && s.steps.length > 0;
            }

            function getSessionsForUi() {
                const all = loadSessions().filter(sessionLooksReal);
                // tri: plus récent en premier si possible
                return all.slice().sort((a, b) => (Number(b.id || 0) - Number(a.id || 0)));
            }

            function getSelectedSessionId() {
                const v = sessionSelect && sessionSelect.value;
                if (v) return String(v);
                return '';
            }

            function getSessionById(id, sessions) {
                return (sessions || []).find(s => String(s.id) === String(id)) || null;
            }

            function getStepsForSession(session) {
                if (!session || !Array.isArray(session.steps)) return [];
                return session.steps.map(st => ({
                    id: String(st.id ?? st.stepId ?? st.name ?? ''),
                    name: String(st.name ?? st.title ?? st.id ?? 'Étape')
                })).filter(x => x.id || x.name);
            }

            function getSelectedStepId() {
                const v = stepSelect && stepSelect.value;
                return v ? String(v) : '';
            }

            function candidatesForSelection(sessionId, stepId) {
                const cands = loadCandidates();
                let out = cands.filter(c => String(c.sessionId || '') === String(sessionId));
                if (stepId) {
                    out = out.filter(c => String(c.stepId || '') === String(stepId));
                }
                return out;
            }

            function votesForCandidates(cands) {
                return cands.reduce((acc, c) => acc + Number((c._votes ?? c.votes) || 0), 0);
            }

            function votersEstimate(totalVotes) {
                // IMPORTANT: On n'a pas une vraie table "votants/transactions" en HTML.
                // Donc on affiche juste 0 si on n'a pas de data fiable.
                return 0;
            }

            // ===== Charts =====
            const DAYS = (() => {
                const labels = [];
                const now = new Date();
                for (let i = 6; i >= 0; i--) {
                    const d = new Date(now);
                    d.setDate(now.getDate() - i);
                    labels.push(d.toLocaleDateString('fr-FR', {
                        weekday: 'short'
                    }));
                }
                return labels;
            })();

            const barCtx = $('#barChart');
            const lineCtx = $('#lineChart');
            const donutCtx = $('#donutChart');

            let barChart, lineChart, donutChart;

            function initCharts() {
                if (window.Chart) {
                    if (barCtx) {
                        barChart = new Chart(barCtx, {
                            type: 'bar',
                            data: {
                                labels: DAYS,
                                datasets: [{
                                    data: [0, 0, 0, 0, 0, 0, 0]
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        enabled: true
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                }
                            }
                        });
                    }
                    if (lineCtx) {
                        lineChart = new Chart(lineCtx, {
                            type: 'line',
                            data: {
                                labels: DAYS,
                                datasets: [{
                                    data: [0, 0, 0, 0, 0, 0, 0],
                                    tension: .35,
                                    fill: false
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        enabled: true
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                }
                            }
                        });
                    }
                    if (donutCtx) {
                        donutChart = new Chart(donutCtx, {
                            type: 'doughnut',
                            data: {
                                labels: ["—"],
                                datasets: [{
                                    data: [1],
                                    borderWidth: 0,
                                    cutout: "68%"
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        enabled: true
                                    }
                                }
                            }
                        });
                    }
                }
            }

            function updateDonutBySteps(sessionId) {
                if (!donutChart) return;
                const sessions = getSessionsForUi();
                const session = getSessionById(sessionId, sessions);
                const steps = getStepsForSession(session);

                if (steps.length === 0) {
                    donutChart.data.labels = ["—"];
                    donutChart.data.datasets[0].data = [1];
                    donutChart.update();
                    return;
                }

                const allCands = loadCandidates().filter(c => String(c.sessionId || '') === String(sessionId));
                const byStep = steps.map(st => {
                    const cands = allCands.filter(c => String(c.stepId || '') === String(st.id));
                    return votesForCandidates(cands);
                });

                // si tout à 0, Chart.js affiche quand même; ok.
                donutChart.data.labels = steps.map(s => s.name);
                donutChart.data.datasets[0].data = byStep.map(v => Number(v || 0));
                donutChart.update();
            }

            function renderLeaders(cands) {
                if (!leadersBox) return;
                const top = cands.slice()
                    .sort((a, b) => Number((b._votes ?? b.votes) || 0) - Number((a._votes ?? a.votes) || 0))
                    .slice(0, 5);

                if (top.length === 0) {
                    leadersBox.innerHTML = '<div class="note">Aucun candidat pour cette sélection.</div>';
                    return;
                }

                leadersBox.innerHTML = top.map((c, idx) => {
                    const name = (c.name || 'Candidat').toString();
                    const num = (c.num || '').toString();
                    const v = Number((c._votes ?? c.votes) || 0);
                    const amount = v * CURRENT_UNIT_PRICE;
                    return `
        <div class="leader">
          <div class="rank">${String(idx+1).padStart(2,'0')}</div>
          <div class="who">
            <div class="nm">${escapeHtml(name)} ${num?`<span class="pill">#${escapeHtml(num)}</span>`:''}</div>
            <div class="sub">${formatMoney(v)} votes • ${formatMoney(amount)} FCFA</div>
          </div>
        </div>
      `;
                }).join('');
            }

            function renderRecent(cands, sessionName, stepName) {
                if (!recentTbody) return;
                const top = cands.slice()
                    .sort((a, b) => Number((b._votes ?? b.votes) || 0) - Number((a._votes ?? a.votes) || 0))
                    .slice(0, 10);

                if (top.length === 0) {
                    recentTbody.innerHTML =
                        `<tr><td colspan="7" style="color:#6b7280;font-weight:700;padding:14px;">Aucune donnée de votes enregistrée pour cette sélection.</td></tr>`;
                    return;
                }

                recentTbody.innerHTML = top.map(c => {
                    const v = Number((c._votes ?? c.votes) || 0);
                    const amount = v * CURRENT_UNIT_PRICE;
                    const candidateLabel =
                        `${escapeHtml((c.name||'Candidat').toString())}${c.num?` (${escapeHtml(String(c.num))})`:''}`;
                    const date = c.lastVoteAt ? escapeHtml(String(c.lastVoteAt)) : '—';
                    const status = c.lastVoteAt ? 'Confirmé' : '—';
                    return `
        <tr>
          <td>${escapeHtml(sessionName||'—')}</td>
          <td>${escapeHtml(stepName||'—')}</td>
          <td>${formatMoney(v)}</td>
          <td>${formatMoney(amount)}</td>
          <td>${candidateLabel}</td>
          <td>${date}</td>
          <td><span class="tag ok">${status}</span></td>
        </tr>
      `;
                }).join('');
            }

            function escapeHtml(str) {
                return String(str)
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", "&#039;");
            }

            function populateSessionSelect() {
                const sessions = getSessionsForUi();
                if (!sessionSelect) return;

                if (sessions.length === 0) {
                    sessionSelect.innerHTML = '<option value="">— Aucune session —</option>';
                    stepSelect && (stepSelect.innerHTML = '<option value="">— Étape —</option>');
                    return;
                }

                sessionSelect.innerHTML = sessions.map(s =>
                    `<option value="${escapeHtml(String(s.id))}">${escapeHtml(String(s.name||('Session '+s.id)))}</option>`
                ).join('');

                // restore selected session
                const saved = localStorage.getItem(SELECT_KEY);
                const savedId = sessions.find(s => String(s.id) === String(saved)) ? String(saved) : String(sessions[0]
                    .id);
                sessionSelect.value = savedId;

                populateStepSelect(savedId);
            }

            function populateStepSelect(sessionId) {
                if (!stepSelect) return;
                const sessions = getSessionsForUi();
                const s = getSessionById(sessionId, sessions);
                const steps = getStepsForSession(s);

                if (steps.length === 0) {
                    stepSelect.innerHTML = '<option value="">— Étape —</option>';
                    stepSelect.value = '';
                    return;
                }

                stepSelect.innerHTML =
                    '<option value="">Toutes les étapes</option>' +
                    steps.map(st => `<option value="${escapeHtml(st.id)}">${escapeHtml(st.name)}</option>`).join('');

                // default: active step if present
                const active = (s && (s.activeStepId != null)) ? String(s.activeStepId) : '';
                const canUse = steps.some(x => String(x.id) === active);
                stepSelect.value = canUse ? active : '';
            }

            function updateUi() {
                const sessions = getSessionsForUi();
                const sid = getSelectedSessionId();
                const s = getSessionById(sid, sessions);

                if (!s) {
                    // reset
                    kpiStep && (kpiStep.textContent = '—');
                    kpiCandidates && (kpiCandidates.textContent = '0');
                    kpiVoters && (kpiVoters.textContent = '0');
                    kpiAmount && (kpiAmount.textContent = '0');
                    renderLeaders([]);
                    renderRecent([], '—', '—');
                    updateDonutBySteps('');
                    currentSessionName && (currentSessionName.textContent = '—');
                    sessionTitle && (sessionTitle.textContent = '—');
                    balanceValue && (balanceValue.textContent = '0');
                    return;
                }

                localStorage.setItem(SELECT_KEY, String(s.id));
                currentSessionName && (currentSessionName.textContent = String(s.name || ('Session ' + s.id)));
                sessionTitle && (sessionTitle.textContent = String(s.name || ('Session ' + s.id)));
                // Solde: calculé plus bas
                balanceValue && (balanceValue.textContent = '0');

                const stepId = getSelectedStepId();
                const steps = getStepsForSession(s);
                const stepName = stepId ? ((steps.find(x => String(x.id) === String(stepId)) || {}).name || '—') :
                    'Toutes';

                const candsRaw = candidatesForSelection(s.id, stepId);
                const unitPrice = getUnitPriceForSession(s);
                const commissionRate = normalizeCommissionRate(s);
                CURRENT_UNIT_PRICE = unitPrice;
                CURRENT_COMMISSION_RATE = commissionRate;
                const txList = filterTx(s.id, stepId);
                const byCand = votesByCandidate(txList);
                const cands = candsRaw.map(c => ({
                    ...c,
                    _votes: (byCand[String(c.id)] || 0)
                }));
                const totalVotes = sumVotes(txList);
                const totalAmount = sumAmount(txList, unitPrice);

                // Solde + rappel (réels)
                const bal = getSessionBalance(s);
                const net = totalAmount * (1 - commissionRate);
                balanceValue && (balanceValue.textContent = formatMoney((bal !== null) ? bal : net));

                const remCommission = document.getElementById('remCommission');
                const remUnitPrice = document.getElementById('remUnitPrice');
                remCommission && (remCommission.textContent = String(Math.round(commissionRate * 100)) + '%');
                remUnitPrice && (remUnitPrice.textContent = formatMoney(unitPrice) + ' FCFA');

                // KPI
                if (kpiStep) {
                    if (stepId) {
                        const idx = steps.findIndex(x => String(x.id) === String(stepId));
                        kpiStep.textContent = (idx >= 0) ? String(idx + 1).padStart(2, '0') : '—';
                    } else {
                        kpiStep.textContent = '—';
                    }
                }
                kpiCandidates && (kpiCandidates.textContent = String(cands.length));
                kpiVoters && (kpiVoters.textContent = String(txList.length));
                kpiAmount && (kpiAmount.textContent = formatMoney(totalAmount));

                // Charts
                updateChartsFromTx(txList, unitPrice);
                updateDonutBySteps(String(s.id));

                // transactions table = top candidats (données réelles)
                renderRecent(cands, s.name || ('Session ' + s.id), stepName);

                // leaders
                renderLeaders(cands);
            }



            function updateChartsFromTx(txList, unitPrice) {
                if (!window.Chart) return;

                const byDayVotes = votesByDay(txList);
                const byDayAmount = amountByDay(txList, unitPrice);

                // build last 7 days keys corresponding to DAYS labels (which are dd/mmm)
                const now = new Date();
                const keys = [];
                for (let i = 6; i >= 0; i--) {
                    const d = new Date(now);
                    d.setDate(now.getDate() - i);
                    keys.push(d.toISOString().slice(0, 10));
                }
                const votesArr = keys.map(k => byDayVotes[k] || 0);
                const amtArr = keys.map(k => Math.round(byDayAmount[k] || 0));

                if (barChart) {
                    barChart.data.labels = DAYS;
                    barChart.data.datasets[0].data = votesArr;
                    barChart.update();
                }
                if (lineChart) {
                    lineChart.data.labels = DAYS;
                    lineChart.data.datasets[0].data = amtArr;
                    lineChart.update();
                }
            }

            function bind() {
                if (sessionSelect) {
                    sessionSelect.addEventListener('change', () => {
                        const sid = getSelectedSessionId();
                        populateStepSelect(sid);
                        updateUi();
                    });
                }
                if (stepSelect) {
                    stepSelect.addEventListener('change', () => {
                        updateUi();
                    });
                }
                window.addEventListener('storage', (e) => {
                    if ([SESS_KEY, CAND_KEY, SELECT_KEY].includes(e.key)) {
                        populateSessionSelect();
                        updateUi();
                    }
                });
            }

            initCharts();
            populateSessionSelect();
            bind();
            updateUi();
        })();
    </script>
</body>

</html>
