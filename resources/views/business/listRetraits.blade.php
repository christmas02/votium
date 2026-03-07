@push('styles')
    @include('layout.css.retrait')
@endpush
@extends('layout.app.business')
@section('content')
    <main class="page">
        <div class="crumbs">
            <span>🏠 Accueil</span> <span class="sep">›</span><b>Retraits</b>
        </div>
        <div class="page-title-row">
            <div>
                <h1>Retraits d'argent</h1>
            </div>
            <div class="cta">
                <button class="btn btn-primary" id="openWithdraw">
                    <svg fill="none" viewbox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" stroke="#0b1220" stroke-linecap="round" stroke-width="2.6"></path>
                    </svg>
                    Retirer de l'argent
                </button>
            </div>
        </div>
        <section class="grid">
            <!-- Sidebar -->
            <aside class="card pad">
                <h3>Filtrer</h3>
                <div class="label">Choisir la destination</div>
                <div class="field">
                    <svg class="icon" fill="none" viewbox="0 0 24 24">
                        <path d="M20 7H4M20 12H4M20 17H4" opacity=".55" stroke="#0b1220" stroke-linecap="round"
                            stroke-width="2"></path>
                    </svg>
                    <select id="dest">
                        <option value="">Choisir la destination</option>
                        <option>Mara</option>
                        <option>MARA MOMO</option>
                        <option>MARA WAVE</option>
                        <option>Mara Flooz</option>
                        <option>ARTHUR OM</option>
                    </select>
                </div>
                <div class="label">À partir du</div>
                <div class="field">
                    <svg class="icon" fill="none" viewbox="0 0 24 24">
                        <path d="M7 2v3M17 2v3" opacity=".55" stroke="#0b1220" stroke-linecap="round" stroke-width="2">
                        </path>
                        <path d="M3.5 9h17" opacity=".55" stroke="#0b1220" stroke-linecap="round" stroke-width="2">
                        </path>
                        <path d="M6 5h12a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z" opacity=".55"
                            stroke="#0b1220" stroke-width="2"></path>
                    </svg>
                    <input id="from" placeholder="jj/mm/aaaa" type="text" />
                </div>
                <div class="label">Jusqu'au</div>
                <div class="field">
                    <svg class="icon" fill="none" viewbox="0 0 24 24">
                        <path d="M7 2v3M17 2v3" opacity=".55" stroke="#0b1220" stroke-linecap="round" stroke-width="2">
                        </path>
                        <path d="M3.5 9h17" opacity=".55" stroke="#0b1220" stroke-linecap="round" stroke-width="2">
                        </path>
                        <path d="M6 5h12a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z" opacity=".55"
                            stroke="#0b1220" stroke-width="2"></path>
                    </svg>
                    <input id="to" placeholder="jj/mm/aaaa" type="text" />
                </div>
                <div class="mini-card green">
                    <div class="k">Solde disponible immédiatement</div>
                    <div class="money"><span class="amt" id="imm">0</span> <span class="ccy">FCFA</span></div>
                </div>
                <div class="mini-card">
                    <div class="k">Solde disponible sur demande</div>
                    <div class="money"><span class="amt" id="ond" style="font-size:34px">170</span> <span
                            class="ccy">FCFA</span></div>
                </div>
                <div class="mini-card dark">
                    <div class="k">Solde total</div>
                    <div class="money"><span class="amt" id="tot">170</span> <span class="ccy">FCFA</span>
                    </div>
                </div>
                <div class="note">Il vous reste <b id="left">10</b> retrait(s) possible(s) aujourd'hui.</div>
            </aside>
            <!-- Main table -->
            <section class="card table-card">
                <div class="table-head" style="flex-direction: column!important;">
                    <div class="title">Historique des retraits</div>
                    <div class="muted" id="count">10 opérations</div>
                    <div class="filters">
                        <div class="fitem">
                            <div class="flabel">Statut</div>
                            <select id="status">
                                <option value="">Tous</option>
                                <option value="PENDING">En attente</option>
                                <option value="PAID">Confirmé</option>
                                <option value="REJECTED">Rejeté</option>
                            </select>
                        </div>
                        <div class="fitem">
                            <div class="flabel">Destination</div>
                            <select id="destFilter">
                                <option value="">Toutes</option>
                            </select>
                        </div>
                        <div class="fitem">
                            <div class="flabel">Du</div>
                            <input id="fromFilter" type="date" />
                        </div>
                        <div class="fitem">
                            <div class="flabel">Au</div>
                            <input id="toFilter" type="date" />
                        </div>
                        <div class="fitem grow">
                            <div class="flabel">Recherche</div>
                            <input id="q" type="search" placeholder="Réf, destination, statut..." />
                        </div>
                    </div>

                </div>
                <div style="overflow:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th style="min-width:160px;">RÉFÉRENCE</th>
                                <th style="min-width:160px;">DESTINATION</th>
                                <th style="min-width:120px;">MONTANT</th>
                                <th style="min-width:140px;">INITIÉ LE</th>
                                <th style="min-width:160px;">TRAITÉ LE</th>
                                <th style="min-width:120px;">STATUT</th>
                            </tr>
                        </thead>
                        <tbody id="rows"></tbody>
                    </table>
                </div>
                <div style="padding:0 16px 16px;">
                    <button class="btn-more" id="more">Afficher plus</button>
                </div>
            </section>
        </section>
    </main>

    <!-- Modal -->

    <!-- Modal -->
<div class="modal-backdrop" id="modal">
    <div aria-labelledby="mTitle" aria-modal="true" class="modal" role="dialog">
        <div class="mhead">
            <div class="ttl" id="mTitle">
                <span style="width:34px;height:34px;border-radius:12px;background:rgba(255,127,0,.15);border:1px solid rgba(255,127,0,.35);display:grid;place-items:center;">
                    <svg fill="none" height="18" viewBox="0 0 24 24" width="18">
                        <path d="M12 5v14M5 12h14" stroke="#ff7f00" stroke-linecap="round" stroke-width="2.6"></path>
                    </svg>
                </span>
                Demande de retrait
            </div>
            <button aria-label="Fermer" class="xbtn" id="closeModal">
                <svg fill="none" height="18" viewBox="0 0 24 24" width="18">
                    <path d="M6 6l12 12M18 6 6 18" stroke="#0b1220" stroke-linecap="round" stroke-width="2.4"></path>
                </svg>
            </button>
        </div>

        <div class="mbody">
            <div>
                <div class="label" style="margin:0 0 8px;">Destination</div>
                <div class="field">
                    <svg class="icon" fill="none" viewBox="0 0 24 24">
                        <path d="M20 7H4M20 12H4M20 17H4" opacity=".55" stroke="#0b1220" stroke-linecap="round" stroke-width="2"></path>
                    </svg>
                    <select id="mDest">
                        <option>Mara</option>
                        <option>MARA MOMO</option>
                        <option>MARA WAVE</option>
                        <option>Mara Flooz</option>
                        <option>ARTHUR OM</option>
                    </select>
                </div>
                <div class="help">Choisissez le compte de retrait (Mobile Money, Wave, etc.).</div>
            </div>

            <div class="grid2">
                <div>
                    <div class="label" style="margin:0 0 8px;">Montant (FCFA)</div>
                    <div class="field">
                        <svg class="icon" fill="none" viewBox="0 0 24 24">
                            <path d="M12 1v22" opacity=".55" stroke="#0b1220" stroke-linecap="round" stroke-width="2"></path>
                            <path d="M17 5.2c0-1.77-2.24-3.2-5-3.2S7 3.43 7 5.2s2.24 3.2 5 3.2 5 1.43 5 3.2-2.24 3.2-5 3.2-5-1.43-5-3.2" opacity=".55" stroke="#0b1220" stroke-linecap="round" stroke-width="2"></path>
                        </svg>
                        <input id="mAmount" min="0" placeholder="Ex : 10000" type="number" />
                    </div>
                </div>
                <div>
                    <div class="label" style="margin:0 0 8px;">Motif (optionnel)</div>
                    <div class="field">
                        <svg class="icon" fill="none" viewBox="0 0 24 24">
                            <path d="M7 7h10M7 12h10M7 17h6" opacity=".55" stroke="#0b1220" stroke-linecap="round" stroke-width="2"></path>
                            <path d="M6 3h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" opacity=".55" stroke="#0b1220" stroke-width="2"></path>
                        </svg>
                        <input id="mNote" placeholder="Ex : Retrait campagne Zenitsu" type="text" />
                    </div>
                </div>
            </div>

            <div class="help">Vos demandes de retrait apparaissent ici.</div>
        </div>

        <div class="mfoot">
            <button class="btn btn-ghost" id="cancel">Annuler</button>
            <button class="btn btn-primary2" id="submit">
                <svg fill="none" viewBox="0 0 24 24">
                    <path d="M5 12l4 4L19 6" stroke="#0b1220" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.6"></path>
                </svg>
                Confirmer
            </button>
        </div>
    </div>
</div>

<script>
    /* ==============================
       Retraits Promoteur — données réelles
       Sources:
       - Sessions      : votium_sessions_v1
       - Transactions  : votium_votes_tx_v1 (SUCCESS)
       - Retraits      : votium_withdrawals_v1
       - Promoteurs    : votium_promoters_v1
    ================================ */

    const KEYS = {
        sessions:    'votium_sessions_v1',
        tx:          'votium_votes_tx_v1',
        withdrawals: 'votium_withdrawals_v1',
        promoters:   'votium_promoters_v1',
        auth:        'votium_auth'
    };

    function getList(key) {
        try { return JSON.parse(localStorage.getItem(key) || '[]'); }
        catch (_) { return []; }
    }

    function setList(key, list) {
        try { localStorage.setItem(key, JSON.stringify(list || [])); }
        catch (_) {}
    }

    function getCurrentPromoterId() {
        // 1) via votium_auth
        try {
            const a = JSON.parse(localStorage.getItem(KEYS.auth) || 'null');
            const id = a && (a.promoterId || a.promoteurId || a.id);
            if (id) return String(id);
        } catch (_) {}
        // 2) fallback : 1er promoteur si unique
        const ps = getList(KEYS.promoters);
        if (ps.length === 1) return String(ps[0].id);
        // 3) fallback : promoteurId trouvé sur une session créée
        const ss = getList(KEYS.sessions);
        const s = ss.find(x => x && (x.promoterId || x.promoteurId));
        if (s) return String(s.promoterId || s.promoteurId);
        return '';
    }

    function calcNetForSession(session, gross) {
        const commission = Number(session.commission ?? session.fee ?? 0);
        const rate = commission > 1 ? commission / 100 : commission;
        const votiumCut = Math.round(gross * (rate || 0));
        return { rate: rate || 0, votiumCut, net: gross - votiumCut };
    }

    function getSessionMap() {
        const map = {};
        getList(KEYS.sessions).forEach(s => {
            if (s && s.id != null) map[String(s.id)] = s;
        });
        return map;
    }

    function computePromoterBalances(promoterId) {
        const sMap = getSessionMap();
        const tx = getList(KEYS.tx).filter(t => String(t.status || '').toUpperCase() === 'SUCCESS');
        const w  = getList(KEYS.withdrawals);

        let grossTotal = 0, votiumTotal = 0, netTotal = 0;
        const bySession = {};

        tx.forEach(t => {
            const s = sMap[String(t.sessionId)];
            if (!s) return;
            const pid = String(s.promoterId || s.promoteurId || '');
            if (!pid || pid !== promoterId) return;

            const gross = Number(t.amount || 0);
            const { votiumCut, net } = calcNetForSession(s, gross);

            grossTotal  += gross;
            votiumTotal += votiumCut;
            netTotal    += net;

            const sid = String(s.id);
            if (!bySession[sid]) bySession[sid] = { session: s, gross: 0, votium: 0, net: 0 };
            bySession[sid].gross  += gross;
            bySession[sid].votium += votiumCut;
            bySession[sid].net    += net;
        });

        let paid = 0, pending = 0;
        w.forEach(x => {
            if (String(x.promoterId || '') !== promoterId) return;
            const amt = Number(x.amount || 0);
            const st  = String(x.status || '').toUpperCase();
            if (st === 'PAID')    paid    += amt;
            else if (st === 'PENDING') pending += amt;
        });

        return {
            grossTotal, votiumTotal, netTotal,
            paid, pending,
            available: Math.max(0, netTotal - paid - pending),
            bySession
        };
    }

    function formatMoney(n) {
        const v = Number(n || 0);
        try { return v.toLocaleString('fr-FR'); }
        catch (_) { return String(Math.round(v)); }
    }

    function escapeHtml(s) {
        return String(s ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function formatDate(iso) {
        if (!iso) return '';
        const d = new Date(iso);
        if (Number.isNaN(d.getTime())) return '';
        const dd = String(d.getDate()).padStart(2, '0');
        const mm = String(d.getMonth() + 1).padStart(2, '0');
        const hh = String(d.getHours()).padStart(2, '0');
        const mi = String(d.getMinutes()).padStart(2, '0');
        return `${dd}/${mm}/${d.getFullYear()} ${hh}:${mi}`;
    }

    /* ── Init ── */
    const promoterId = getCurrentPromoterId();

    const pidEl = document.querySelector('[data-promoter-id]');
    if (pidEl) pidEl.textContent = promoterId ? `#${promoterId}` : '—';

    // Remplir le select sessions dans la modal
    const sessionSelect = document.getElementById('mSession');
    if (sessionSelect) {
        const allSessions = Object.values(getSessionMap())
            .filter(s => String(s.promoterId || s.promoteurId || '') === promoterId)
            .sort((a, b) => String(b.createdAt || '').localeCompare(String(a.createdAt || '')));

        sessionSelect.innerHTML =
            '<option value="">Toutes les sessions</option>' +
            allSessions.map(s => {
                const label = s.title || s.name || `Session ${s.id}`;
                return `<option value="${String(s.id)}">${escapeHtml(label)}</option>`;
            }).join('');
    }

    function buildRows() {
        return getList(KEYS.withdrawals)
            .filter(w => String(w.promoterId || '') === promoterId)
            .sort((a, b) => String(b.createdAt || '').localeCompare(String(a.createdAt || '')))
            .map(w => {
                const st  = String(w.status || '').toUpperCase();
                const iso = w.createdAt || w.updatedAt || '';
                return {
                    id:        String(w.id  || ''),
                    ref:       String(w.ref || ''),
                    dest:      String(w.method || w.dest || '—'),
                    amount:    Number(w.amount || 0),
                    init:      formatDate(iso),
                    treated:   st === 'PAID' ? formatDate(w.updatedAt || w.paidAt || iso) : '—',
                    status:    st === 'PAID' ? 'Confirmé' : (st === 'PENDING' ? 'En attente' : 'Rejeté'),
                    rawStatus: st,
                    sessionId: String(w.sessionId || ''),
                    _iso:      String(iso)
                };
            });
    }

    let DATA    = buildRows();
    let visible = 10;

    function render() {
        DATA = buildRows();

        const bal = computePromoterBalances(promoterId);

        // KPI cards
        const ids = { kGross: bal.grossTotal, kVotium: bal.votiumTotal, kNet: bal.netTotal,
                      kAvail: bal.available,  kPaid:   bal.paid,        kPending: bal.pending };
        Object.entries(ids).forEach(([id, val]) => {
            const el = document.getElementById(id);
            if (el) el.textContent = formatMoney(val) + ' FCFA';
        });

        const tbody  = document.querySelector('tbody#rows');
        if (!tbody) return;

        const q      = String(document.getElementById('q')?.value        || '').trim().toLowerCase();
        const st     = String(document.getElementById('status')?.value   || '').trim().toUpperCase();
        const fDest  = String(document.getElementById('destFilter')?.value  || '').trim().toLowerCase();
        const fFrom  = String(document.getElementById('fromFilter')?.value  || '').trim();
        const fTo    = String(document.getElementById('toFilter')?.value    || '').trim();

        function inRange(iso) {
            if (!fFrom && !fTo) return true;
            const d = new Date(iso);
            if (Number.isNaN(d.getTime())) return false;
            if (fFrom && d < new Date(fFrom + 'T00:00:00')) return false;
            if (fTo   && d > new Date(fTo   + 'T23:59:59')) return false;
            return true;
        }

        // Alimenter le select destinations dynamiquement (une seule fois)
        const destEl = document.getElementById('destFilter');
        if (destEl && !destEl.dataset.built) {
            const uniq = Array.from(new Set(DATA.map(r => String(r.dest || '')).filter(Boolean)));
            destEl.innerHTML = '<option value="">Toutes</option>' +
                uniq.map(v => `<option value="${escapeHtml(v)}">${escapeHtml(v)}</option>`).join('');
            destEl.dataset.built = '1';
        }

        let rows = DATA
            .filter(r => !st    || r.rawStatus === st)
            .filter(r => !fDest || String(r.dest || '').toLowerCase() === fDest)
            .filter(r => inRange(r._iso || ''))
            .filter(r => !q     || (r.id + ' ' + r.ref + ' ' + r.dest + ' ' + r.status).toLowerCase().includes(q));

        const countEl = document.getElementById('count');
        if (countEl) countEl.textContent = rows.length + (rows.length > 1 ? ' opérations' : ' opération');

        tbody.innerHTML = rows.slice(0, visible).map(r => `
            <tr>
                <td class="mono">${escapeHtml(r.ref || r.id)}</td>
                <td>${escapeHtml(r.dest)}</td>
                <td class="right">${formatMoney(r.amount)} FCFA</td>
                <td>${escapeHtml(r.init    || '—')}</td>
                <td>${escapeHtml(r.treated || '—')}</td>
                <td>
                    <span class="badge ${r.rawStatus === 'PAID' ? 'ok' : (r.rawStatus === 'PENDING' ? 'wait' : 'bad')}">
                        ${escapeHtml(r.status)}
                    </span>
                </td>
            </tr>
        `).join('');

        const moreBtn = document.getElementById('more');
        if (moreBtn) moreBtn.style.display = visible < DATA.length ? 'inline-flex' : 'none';
    }

    /* ── Modal ── */
    const modal       = document.getElementById('modal');
    const openWithdraw = document.getElementById('openWithdraw');
    const closeModalBtn = document.getElementById('closeModal');
    const cancelBtn   = document.getElementById('cancel');

    const open  = () => modal.style.display = 'flex';
    const close = () => modal.style.display = 'none';

    openWithdraw?.addEventListener('click', open);
    closeModalBtn?.addEventListener('click', close);
    cancelBtn?.addEventListener('click', close);
    modal?.addEventListener('click', e => { if (e.target === modal) close(); });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modal?.style.display === 'flex') close();
    });

    /* ── Soumission du retrait ── */
    document.getElementById('submit')?.addEventListener('click', () => {
        const method    = String(document.getElementById('mDest')?.value    || 'WAVE').trim();
        const amount    = Number(document.getElementById('mAmount')?.value  || 0);
        const note      = String(document.getElementById('mNote')?.value    || '').trim();
        const sessionId = String(document.getElementById('mSession')?.value || '').trim();

        if (!promoterId)      { alert('Promoteur non identifié.'); return; }
        if (!amount || amount <= 0) { document.getElementById('mAmount')?.focus(); return; }

        const bal = computePromoterBalances(promoterId);
        if (amount > bal.available) { alert('Montant supérieur au disponible.'); return; }

        const now = new Date();
        const id  = 'W_' + Date.now();

        const list = getList(KEYS.withdrawals);
        list.unshift({
            id, ref: id, promoterId, sessionId,
            amount, method, note,
            status:    'PENDING',
            createdAt: now.toISOString(),
            updatedAt: now.toISOString()
        });
        setList(KEYS.withdrawals, list);

        visible = 10;
        close();
        render();

        if (openWithdraw) {
            openWithdraw.textContent = 'Demande envoyée ✓';
            setTimeout(() => {
                openWithdraw.innerHTML =
                    `<svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 5v14M5 12h14" stroke="#0b1220" stroke-width="2.6" stroke-linecap="round"/>
                    </svg>Retirer de l'argent`;
            }, 1200);
        }
    });

    /* ── Filtres ── */
    ['q', 'status', 'destFilter', 'fromFilter', 'toFilter'].forEach(id => {
        document.getElementById(id)?.addEventListener(id === 'q' ? 'input' : 'change', () => {
            visible = 10;
            render();
        });
    });

    document.getElementById('more')?.addEventListener('click', () => {
        visible += 8;
        render();
    });

    render();
</script>
@endsection
