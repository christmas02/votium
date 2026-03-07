@push('styles')
    @include('layout.css.vote')
@endpush
@extends('layout.app.business')
@section('content')
    <div class="page">
        <div class="container">
            <div class="crumbs">
                <span>🏠 Accueil</span> <span class="sep">›</span> <span>Sessions</span> <span class="sep">›</span>
                    <span>Candidats</span> <span class="sep">›</span> <b>Votes</b>
                
            </div>
            <div class="headrow">
                <div>
                    <h1>Votes</h1>
                </div>
                <div aria-label="Synthèse" class="kpis" style="grid-template-columns: repeat(2, minmax(0, 1fr))!important;">
                    <div class="kpi">
                        <div>
                            <div class="label">Nbre votes</div>
                            <div class="value mono" id="kpiVotes">—</div>
                        </div>
                        <div class="badge">LIVE</div>
                    </div>
                    <div class="kpi">
                        <div>
                            <div class="label">Total</div>
                            <div class="value mono money" id="kpiTotal">—</div>
                        </div>
                        <div class="badge">FCFA</div>
                    </div>
                </div>
            </div>
            <div class="layout">
                <!-- Filter -->
                <aside aria-label="Filtrer" class="card">
                    <div class="card-h">Filtrer</div>
                    <div class="card-b">
                        <div class="field">
                            <div class="label">Choisir la session</div>
                            <div class="control">
                                <svg fill="none" viewbox="0 0 24 24">
                                    <path d="M6 7h12M6 12h12M6 17h12" opacity=".65" stroke="var(--primary)"
                                        stroke-linecap="round" stroke-width="2"></path>
                                </svg>
                                <select id="fSession"></select>
                            </div>
                        </div>
                        <div class="field">
                            <div class="label">Choisir l'étape</div>
                            <div class="control">
                                <svg fill="none" viewbox="0 0 24 24">
                                    <path d="M7 4h10v16H7z" opacity=".65" stroke="var(--primary)" stroke-width="2">
                                    </path>
                                    <path d="M9 8h6" opacity=".65" stroke="var(--primary)" stroke-linecap="round"
                                        stroke-width="2"></path>
                                </svg>
                                <select id="fStep"></select>
                            </div>
                        </div>
                        <div class="field">
                            <div class="label">À partir du</div>
                            <div class="control">
                                <svg fill="none" viewbox="0 0 24 24">
                                    <path
                                        d="M7 3v3M17 3v3M5 8h14M6 21h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z"
                                        opacity=".65" stroke="var(--primary)" stroke-linecap="round" stroke-width="2">
                                    </path>
                                </svg>
                                <input id="fFrom" type="date" />
                            </div>
                        </div>
                        <div class="field">
                            <div class="label">Jusqu'au</div>
                            <div class="control">
                                <svg fill="none" viewbox="0 0 24 24">
                                    <path
                                        d="M7 3v3M17 3v3M5 8h14M6 21h12a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z"
                                        opacity=".65" stroke="var(--primary)" stroke-linecap="round" stroke-width="2">
                                    </path>
                                </svg>
                                <input id="fTo" type="date" />
                            </div>
                        </div>
                        <div class="field" style="margin-bottom:0">
                            <div class="label">Statut</div>
                            <div class="control">
                                <svg fill="none" viewbox="0 0 24 24">
                                    <path d="M12 2l7 4v6c0 6-4 9.7-7 10.8C9 21.7 5 18 5 12V6l7-4Z" opacity=".65"
                                        stroke="var(--primary)" stroke-width="2"></path>
                                    <path d="M8.5 12.2l2.2 2.2L15.8 9.3" opacity=".65" stroke="var(--primary)"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                </svg>
                                <select id="fStatus">
                                    <option value="">Tous</option>
                                    <option selected="" value="confirmé">Confirmé</option>
                                    <option value="en attente">En attente</option>
                                    <option value="échoué">Échoué</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn" id="apply" type="button">Appliquer</button>
                        <button class="btn secondary" id="reset" type="button">Réinitialiser</button>
                        <div class="hint">
                            Rappel : <b>Commission</b> = 30% • <b>Prix unitaire</b> = 200 FCFA<br />
                            (démo front-only : données fictives)
                        </div>
                    </div>
                </aside>
                <!-- Table -->
                <section aria-label="Liste des votes" class="card tableWrap">
                    <div class="card-h" style="justify-content:space-between;">
                        <div>Historique des votes</div>
                        <div style="display:flex;gap:10px;align-items:center;">
                            <span class="meta" id="rangeInfo">—</span>
                        </div>
                    </div>
                    <div style="overflow:auto;">
                        <table aria-label="Table votes">
                            <thead>
                                <tr>
                                    <th style="min-width:320px;">SESSION</th>
                                    <th style="min-width:190px;">ÉTAPE</th>
                                    <th>QTE</th>
                                    <th class="money">MONTANT</th>
                                    <th style="min-width:200px;">CANDIDAT</th>
                                    <th style="min-width:110px;">DATE</th>
                                    <th style="min-width:120px;">STATUS</th>
                                </tr>
                            </thead>
                            <tbody id="rows"></tbody>
                        </table>
                    </div>
                    <div class="tableFooter">
                        <button class="ghost" id="more" type="button">Afficher plus</button>
                        <div class="meta"><span id="countInfo">—</span></div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script>
        // --- DATA (fictif, crédible) ---
        const UNIT_PRICE = 200;
        const DATA = [{
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 2,
                candidate: "Yapo Marie Reine (00031)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 100,
                candidate: "Kone Hermine (00028)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 10,
                candidate: "Ayepa Laroche (00002)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 5,
                candidate: "Kone Hermine (00028)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 20,
                candidate: "Yapo Marie Reine (00031)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 20,
                candidate: "Diomandé Souleymane (00015)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 20,
                candidate: "Kouassi Isaac (00011)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 2,
                candidate: "Ayepa Laroche (00002)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 10,
                candidate: "Yapo Marie Reine (00031)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 20,
                candidate: "Kone Hermine (00028)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 5,
                candidate: "Diomandé Souleymane (00015)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 2,
                candidate: "Diomandé Souleymane (00015)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 5,
                candidate: "Kouame Akissi Marie (00029)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 5,
                candidate: "Ayepa Laroche (00002)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 2,
                candidate: "Kouame Akissi Marie (00029)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 5,
                candidate: "Ayepa Laroche (00002)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 2,
                candidate: "Diomandé Souleymane (00015)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 5,
                candidate: "Tchama Edmond (00016)",
                date: "2025-05-04",
                status: "confirmé"
            },
            {
                session: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                step: "<span data-session-name>FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>",
                qty: 50,
                candidate: "Ayepa Laroche (00002)",
                date: "2025-05-04",
                status: "confirmé"
            },
        ];

        // Unique filter values
        const fSession = document.getElementById('fSession');
        const fStep = document.getElementById('fStep');
        const fFrom = document.getElementById('fFrom');
        const fTo = document.getElementById('fTo');
        const fStatus = document.getElementById('fStatus');
        const rows = document.getElementById('rows');

        function uniq(arr) {
            return [...new Set(arr)];
        }

        function money(n) {
            return String(n).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }

        function formatDate(iso) {
            const [y, m, d] = iso.split('-');
            return `${d}/${m}/${y}`;
        }

        function opt(select, value, label) {
            const o = document.createElement('option');
            o.value = value;
            o.textContent = label;
            select.appendChild(o);
        }

        function initFilters() {
            fSession.innerHTML = "";
            fStep.innerHTML = "";
            opt(fSession, "", "Tous");
            uniq(DATA.map(d => d.session)).forEach(s => opt(fSession, s, s.length > 30 ? s.slice(0, 30) + "…" : s));
            // Default like capture (first session)
            fSession.value = DATA[0].session;

            opt(fStep, "", "Tous");
            uniq(DATA.map(d => d.step)).forEach(s => opt(fStep, s, s.length > 30 ? s.slice(0, 30) + "…" : s));
            fStep.value = DATA[0].step;

            // Date inputs left blank like capture placeholders
            fFrom.value = "";
            fTo.value = "";
        }

        // Pagination
        let pageSize = 12;
        let shown = 0;
        let current = [];

        function passes(d) {
            if (fSession.value && d.session !== fSession.value) return false;
            if (fStep.value && d.step !== fStep.value) return false;
            if (fStatus.value && d.status !== fStatus.value) return false;

            if (fFrom.value) {
                if (d.date < fFrom.value) return false;
            }
            if (fTo.value) {
                if (d.date > fTo.value) return false;
            }
            return true;
        }

        function computeKpis(list) {
            const votes = list.reduce((a, x) => a + x.qty, 0);
            const total = list.reduce((a, x) => a + (x.qty * UNIT_PRICE), 0);
            document.getElementById('kpiVotes').textContent = money(votes);
            document.getElementById('kpiTotal').textContent = money(total) + " FCFA";
            document.getElementById('rangeInfo').textContent = (list.length ? "Résultats filtrés" : "Aucun résultat");
        }

        function rowTpl(d) {
            const amount = d.qty * UNIT_PRICE;
            return `
        <tr>
          <td data-label="SESSION">
            <div class="session">${escapeHtml(d.session)}</div>
          </td>
          <td data-label="ÉTAPE">
            <div>${escapeHtml(d.step)}</div>
          </td>
          <td data-label="QTE" class="mono">${d.qty}</td>
          <td data-label="MONTANT" class="money mono">${money(amount)}</td>
          <td data-label="CANDIDAT">
            <div>${escapeHtml(d.candidate)}</div>
          </td>
          <td data-label="DATE" class="mono">${formatDate(d.date)}</td>
          <td data-label="STATUS">
            <span class="status"><span class="dot"></span> Confirmé</span>
          </td>
        </tr>
      `;
        }

        function escapeHtml(s) {
            return String(s).replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            } [m]));
        }

        function render(reset = false) {
            if (reset) {
                rows.innerHTML = "";
                shown = 0;
            }
            const slice = current.slice(shown, shown + pageSize);
            slice.forEach(d => rows.insertAdjacentHTML('beforeend', rowTpl(d)));
            shown += slice.length;

            document.getElementById('countInfo').textContent = `${shown} / ${current.length}`;
            document.getElementById('more').style.display = shown < current.length ? "inline-flex" : "none";
        }

        function apply() {
            current = DATA.filter(passes);
            computeKpis(current);
            render(true);
        }

        document.getElementById('apply').addEventListener('click', apply);
        document.getElementById('reset').addEventListener('click', () => {
            initFilters();
            apply();
        });
        document.getElementById('more').addEventListener('click', () => render(false));

        // Init
        initFilters();
        apply();
    </script>
@endsection
