@push('styles')
    @include('layout.css.session')
@endpush
@extends('layout.app.business')
@section('content')
    <main class="wrap shell">
        <div class="pagehead">
            <div>
                <div class="breadcrumb">🏠 <span>Accueil</span> <span>›</span> <b>Sessions</b></div>
                <h1 class="title">Sessions de votes</h1>
                <p class="subtitle">Gérez vos campagnes : étapes, candidats, inscriptions, packs de votes et affichage
                    (pourcentage / clair). Tout est modifiable par session.</p>
            </div>
            <div class="tools">
                <div class="kpi"><span class="dot"></span> <span id="kpiCount">6</span> sessions</div>
                <div class="search">
                    <svg viewbox="0 0 24 24">
                        <path
                            d="M10 4a6 6 0 1 1 0 12A6 6 0 0 1 10 4zm0 2a4 4 0 1 0 0 8 4 4 0 0 0 0-8zm9.7 13.3-3.2-3.2 1.4-1.4 3.2 3.2-1.4 1.4z"
                            fill="currentColor"></path>
                    </svg>
                    <input autocomplete="off" id="q" placeholder="Rechercher une session..." />
                </div>
                <button class="btn secondary" id="btnCreate">
                    <svg viewbox="0 0 24 24">
                        <path d="M19 11H13V5h-2v6H5v2h6v6h2v-6h6v-2z" fill="currentColor"></path>
                    </svg>
                    Nouvelle session
                </button>
            </div>
        </div>
        <section aria-label="Liste des sessions" class="card">
            <div class="scroll">
                <table class="table" id="tbl">
                    <thead>
                        <tr>
                            <th style="width:42%">Nom de session</th>
                            <th style="width:12%">Nbre d'étapes</th>
                            <th style="width:14%">Nbre de candidats</th>
                            <th style="width:14%">Créée le</th>
                            <th style="width:12%">Inscriptions</th>
                            <th style="width:6%;text-align:right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="rows"></tbody>
                </table>
            </div>
            <div class="foot">
                <div><b id="shown">6</b> affichée(s) • Données fictives (front-only)</div>
                <div class="pager">
                    <button class="mini" id="prev">‹</button>
                    <span class="muted">Page <b id="page">1</b>/<b id="pages">1</b></span>
                    <button class="mini" id="next">›</button>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal -->
    <div aria-hidden="true" class="overlay" id="overlay">
        <div aria-labelledby="mtitle" aria-modal="true" class="modal" role="dialog">
            <div class="mhead">
                <div>
                    <h3 id="mtitle">Nouvelle session</h3>
                    <p>Paramétrez la session : cover, inscriptions, affichage des votes, packs visibles, couleurs.</p>
                </div>
                <button aria-label="Fermer" class="close" id="close">
                    <svg viewbox="0 0 24 24">
                        <path
                            d="M18.3 5.7 12 12l6.3 6.3-1.4 1.4L10.6 13.4 4.3 19.7 2.9 18.3 9.2 12 2.9 5.7 4.3 4.3l6.3 6.3 6.3-6.3 1.4 1.4z"
                            fill="currentColor"></path>
                    </svg>
                </button>
            </div>
            <div class="mbody">
                <div class="grid">
                    <div class="field">
                        <label>Nom de la session</label>
                        <input class="inp" id="fName" placeholder="Ex: Finale CNC 2026" />
                    </div>
                    <div class="field">
                        <label>Inscriptions</label>
                        <select class="sel" id="fIns">
                            <option value="Autorisees">Autorisées</option>
                            <option value="Non-autorisee">Non-autorisée</option>
                        </select>
                    </div>
                    <div class="field" style="grid-column:1/-1">
                        <label>Décrivez la session</label>
                        <textarea class="ta" id="fDesc" placeholder="But, durée, règles, infos utiles..."></textarea>
                    </div>
                    <div class="field" style="grid-column:1/-1">
                        <label>Image de couverture</label>
                        <div class="upload" id="coverUpload">
                            <div class="hint">Glissez une image ici (démo) • ou cliquez sur “Choisir”</div>
                            <button class="btn ghost" id="fakeUpload" type="button">
                                <svg viewbox="0 0 24 24">
                                    <path d="M19 9a4 4 0 0 0-7.9-1A4 4 0 0 0 5 12a4 4 0 0 0 4 4h9a3 3 0 0 0 1-7z"
                                        fill="currentColor"></path>
                                </svg>
                                Choisir
                            </button>
                            <input id="fCoverFile" type="file" accept="image/*"
                                style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div>
                        <b>Texte sur le cover</b>
                        <small>Afficher un titre/infos au-dessus de l’image de couverture.</small>
                    </div>
                    <input id="fCoverText" type="checkbox" />
                </div>
                <div class="row">
                    <div>
                        <b>Identifiants candidats personnalisés</b>
                        <small>Permet d’imposer des numéros / codes (ex: 0001…)</small>
                    </div>
                    <input id="fCustomIds" type="checkbox" />
                </div>
                <div class="row">
                    <div>
                        <b>Affichage des votes</b>
                        <small>Choix visible côté public (selon la session).</small>
                    </div>
                    <div aria-label="Affichage" class="seg" role="tablist">
                        <button class="active" data-mode="Clair" type="button">Clair</button>
                        <button data-mode="Pourcentage" type="button">Pourcentage</button>
                        <button data-mode="Les deux" type="button">Les deux</button>
                    </div>
                </div>
                <div class="row">
                    <div>
                        <b>Ordonner les candidats par votes décroissants</b>
                        <small>Recommandé pour afficher un classement.</small>
                    </div>
                    <input checked="" id="fSort" type="checkbox" />
                </div>
                <div class="grid" style="margin-top:12px">
                    <div class="field" style="grid-column:1/-1">
                        <label>Quantité de votes visibles</label>
                        <input class="inp" id="fPacks" placeholder="Ex: 2,5,10,20,50,100,500" />
                        <div class="note">Astuce : les packs &lt; 200 FCFA seront ignorés (démo). Prix du vote défini
                            à l’étape.</div>
                    </div>

                    <div class="field" style="grid-column:1/-1;margin-top:6px">
                        <label>Étape active (pour démarrer/arrêter les votes)</label>
                        <div class="note">Exemples : Présélection, Demi-finale, Finale. Cette étape pilote l’état
                            "Votes en cours" / "Fin des votes" côté public.</div>
                        <div class="grid" style="margin-top:10px">
                            <div class="field">
                                <label>Nom de l’étape</label>
                                <input class="inp" id="fStepName" placeholder="Ex: Présélection" />
                            </div>
                            <div class="field">
                                <label>Début</label>
                                <input class="inp" id="fStepStart" type="datetime-local" />
                            </div>
                            <div class="field">
                                <label>Fin</label>
                                <input class="inp" id="fStepEnd" type="datetime-local" />
                            </div>
                            <div class="field">
                                <label>Statut</label>
                                <select class="inp" id="fStepStatus">
                                    <option value="draft">Brouillon</option>
                                    <option value="active">Votes en cours</option>
                                    <option value="ended">Fin des votes</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label>Couleur primaire</label>
                        <div style="display:flex;gap:10px;align-items:center"><input class="inp" id="fPrimary"
                                value="#01233f" />
                            <input id="fPrimaryPicker" type="color" value=""
                                style="width:44px;height:44px;border:1px solid var(--line);border-radius:12px;padding:0;background:#fff;cursor:pointer" />
                        </div>
                    </div>
                    <div class="field">
                        <label>Couleur secondaire</label>
                        <div style="display:flex;gap:10px;align-items:center"><input class="inp" id="fSecondary"
                                value="#ff7f00" />
                            <input id="fSecondaryPicker" type="color" value=""
                                style="width:44px;height:44px;border:1px solid var(--line);border-radius:12px;padding:0;background:#fff;cursor:pointer" />
                        </div>
                    </div>
                </div>
                <div class="field" style="margin-top:12px">
                    <label>Conditions de participation (document)</label>
                    <input id="fDocFile" type="file" accept="application/pdf" style="display:none" />
                    <div class="upload">
                        <div class="hint">Ajoutez un PDF (démo) — Conditions de vote / participation.</div>
                        <div id="docName" class="tag" style="margin:6px 0 10px 0;display:inline-flex">Aucun
                            document</div>
                        <button id="docBtn" class="btn ghost" type="button">
                            <svg viewbox="0 0 24 24">
                                <path d="M12 3l4 4h-3v7h-2V7H8l4-4zm-7 14h14v2H5v-2z" fill="currentColor"></path>
                            </svg>
                            Importer
                        </button>
                    </div>
                </div>
                <div class="footbtns">
                    <button class="btn secondary" id="cancel" type="button">Annuler</button>
                    <button class="btn" id="save" type="button">
                        <svg viewbox="0 0 24 24">
                            <path
                                d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7l-4-4zM7 5h8v4H7V5zm5 14a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"
                                fill="currentColor"></path>
                        </svg>
                        Valider
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Safe storage for file:// contexts (some browsers block localStorage)
            const StorageSafe = (() => {
                let mem = {};
                const ok = (() => {
                    try {
                        const k = '__votium_test__';
                        window.localStorage.setItem(k, '1');
                        window.localStorage.removeItem(k);
                        return true;
                    } catch (e) {
                        return false;
                    }
                })();
                const store = ok ? window.localStorage : {
                    getItem: (k) => (k in mem ? mem[k] : null),
                    setItem: (k, v) => {
                        mem[k] = String(v);
                    },
                    removeItem: (k) => {
                        delete mem[k];
                    }
                };
                return {
                    ok,
                    getJSON: (k, fallback) => {
                        try {
                            const v = store.getItem(k);
                            return v ? JSON.parse(v) : fallback;
                        } catch (e) {
                            return fallback;
                        }
                    },
                    setJSON: (k, val) => {
                        try {
                            store.setItem(k, JSON.stringify(val));
                        } catch (e) {}
                    },
                    get: (k, fallback = null) => {
                        try {
                            const v = store.getItem(k);
                            return v === null ? fallback : v;
                        } catch (e) {
                            return fallback;
                        }
                    },
                    set: (k, val) => {
                        try {
                            store.setItem(k, String(val));
                        } catch (e) {}
                    },
                    remove: (k) => {
                        try {
                            store.removeItem(k);
                        } catch (e) {}
                    },
                };
            })();


            const SESS_KEY = 'votium_sessions_v1';
            const SELECT_KEY = 'votium_selected_session';

            const $ = (s, r = document) => r.querySelector(s);

            const rows = $('#rows');
            const q = $('#q');
            const kpiCount = $('#kpiCount');

            const overlay = $('#overlay');
            const mtitle = $('#mtitle');
            const saveBtn = $('#save');
            const closeBtn = $('#close');
            const cancelBtn = $('#cancel');

            const fName = $('#fName');
            const fIns = $('#fIns');
            const coverUpload = $('#coverUpload');
            const fakeUpload = $('#fakeUpload');
            const fCoverFile = $('#fCoverFile');
            let coverDataUrl = null;

            const fDesc = $('#fDesc');
            const fCoverText = $('#fCoverText');
            const fCustomIds = $('#fCustomIds');
            const fSort = $('#fSort');
            const fPacks = $('#fPacks');
            const fStepName = $('#fStepName');
            const fStepStart = $('#fStepStart');
            const fStepEnd = $('#fStepEnd');
            const fStepStatus = $('#fStepStatus');
            const fPrimary = $('#fPrimary');
            const fSecondary = $('#fSecondary');
            const fPrimaryPicker = $('#fPrimaryPicker');
            const fSecondaryPicker = $('#fSecondaryPicker');
            const fDocFile = $('#fDocFile');
            const docBtn = $('#docBtn');
            const docName = $('#docName');
            const seg = document.querySelector('.seg');
            const modeBtns = seg ? Array.from(seg.querySelectorAll('button[data-mode]')) : [];
            let displayMode = 'Clair';
            let docDataUrl = null;
            let docFileName = '';

            const btnCreate = $('#btnCreate');
            const prev = $('#prev');
            const next = $('#next');
            const pageEl = $('#page');
            const pagesEl = $('#pages');
            const shownEl = $('#shown');

            let state = {
                editingId: null,
                page: 1,
                perPage: 6
            };

            function load() {
                try {
                    const raw = (StorageSafe.ok ? window.localStorage.getItem(SESS_KEY) : StorageSafe.get(
                        SESS_KEY));
                    if (!raw) return null;
                    const arr = JSON.parse(raw);
                    return Array.isArray(arr) ? arr : null;
                } catch (e) {
                    return null;
                }
            }

            function save(arr) {
                const stringify = (data) => JSON.stringify(data);
                const persist = (str) => {
                    if (StorageSafe.ok) {
                        window.localStorage.setItem(SESS_KEY, str);
                        return true;
                    } else {
                        // fallback memory only
                        StorageSafe.set(SESS_KEY, str);
                        return false;
                    }
                };

                try {
                    const str = stringify(arr);
                    return persist(str);
                } catch (e) {
                    // Most likely quota exceeded because of cover/doc base64.
                    try {
                        const lite = arr.map(s => ({
                            ...s,
                            cover: null,
                            docDataUrl: null
                        }));
                        const str2 = stringify(lite);
                        const ok = persist(str2);
                        // reflect in current array too
                        for (let i = 0; i < arr.length; i++) {
                            arr[i].cover = null;
                            arr[i].docDataUrl = null;
                        }
                        toast('Fichiers trop lourds: session enregistrée sans cover/PDF.');
                        return ok;
                    } catch (e2) {
                        toast('Impossible de sauvegarder (stockage plein / bloqué).');
                        return false;
                    }
                }
            }

            function seed() {
                const today = new Date().toLocaleDateString('fr-FR');
                return [{
                        id: 1,
                        name: "Awards Culture 2026",
                        created: today,
                        ins: "Autorisees"
                    },
                    {
                        id: 2,
                        name: "MISS INTERCOMMUNE 2026",
                        created: today,
                        ins: "Autorisees"
                    },
                ];
            }

            let sessions = load();
            // IMPORTANT: no fictive seed sessions — show empty if none
            if (!Array.isArray(sessions)) sessions = [];

            function toast(msg) {
                let t = document.getElementById('toast');
                if (!t) {
                    t = document.createElement('div');
                    t.id = 'toast';
                    t.style.position = 'fixed';
                    t.style.left = '50%';
                    t.style.bottom = '18px';
                    t.style.transform = 'translateX(-50%)';
                    t.style.background = 'rgba(1,35,63,.92)';
                    t.style.color = '#fff';
                    t.style.padding = '12px 14px';
                    t.style.borderRadius = '14px';
                    t.style.border = '1px solid rgba(255,255,255,.18)';
                    t.style.boxShadow = '0 24px 70px rgba(1,35,63,.35)';
                    t.style.fontWeight = '800';
                    t.style.fontSize = '13px';
                    t.style.zIndex = '999';
                    t.style.maxWidth = 'calc(100% - 30px)';
                    t.style.textAlign = 'center';
                    document.body.appendChild(t);
                }
                t.textContent = msg;
                t.style.opacity = '1';
                clearTimeout(window.__toastTimer);
                window.__toastTimer = setTimeout(() => {
                    t.style.opacity = '0';
                }, 1800);
            }

            // Segmented control (Affichage des votes)
            function setMode(mode) {
                displayMode = mode || 'Clair';
                modeBtns.forEach(b => b.classList.toggle('active', b.dataset.mode === displayMode));
            }
            modeBtns.forEach(b => b.addEventListener('click', () => setMode(b.dataset.mode)));

            // Color pickers sync
            function syncPickerFromText() {
                if (fPrimaryPicker && fPrimary && /^#([0-9a-f]{6})$/i.test(fPrimary.value)) fPrimaryPicker.value =
                    fPrimary.value;
                if (fSecondaryPicker && fSecondary && /^#([0-9a-f]{6})$/i.test(fSecondary.value)) fSecondaryPicker
                    .value = fSecondary.value;
            }
            if (fPrimaryPicker && fPrimary) {
                fPrimaryPicker.addEventListener('input', () => {
                    fPrimary.value = fPrimaryPicker.value;
                });
                fPrimary.addEventListener('input', syncPickerFromText);
            }
            if (fSecondaryPicker && fSecondary) {
                fSecondaryPicker.addEventListener('input', () => {
                    fSecondary.value = fSecondaryPicker.value;
                });
                fSecondary.addEventListener('input', syncPickerFromText);
            }

            // Conditions document upload (PDF demo)
            function setDocLabel() {
                if (!docName) return;
                docName.textContent = docFileName ? docFileName : 'Aucun document';
            }
            if (docBtn && fDocFile) {
                docBtn.addEventListener('click', () => fDocFile.click());
                fDocFile.addEventListener('change', () => {
                    const file = fDocFile.files && fDocFile.files[0];
                    if (!file) return;
                    docFileName = file.name || 'document.pdf';
                    setDocLabel();
                    // store DataURL only if not too large (demo)
                    if (file.size <= 800 * 1024) {
                        const r = new FileReader();
                        r.onload = () => {
                            docDataUrl = String(r.result || '');
                            toast('Document ajouté');
                        };
                        r.readAsDataURL(file);
                    } else {
                        docDataUrl = null;
                        toast('Document ajouté (poids élevé, stockage léger)');
                    }
                });
            }
            setDocLabel();


            function openModal(editId = null) {
                state.editingId = editId;
                const s = editId ? sessions.find(x => x.id === editId) : null;

                mtitle.textContent = editId ? "Modifier une session" : "Nouvelle session";

                // basics
                fName.value = s ? (s.name || '') : '';
                fIns.value = s ? ((s.ins === "Autorisees") ? "Autorisees" : "Non-autorisee") : "Autorisees";

                // description & options
                if (fDesc) fDesc.value = s ? (s.desc || '') : '';
                if (fCoverText) fCoverText.checked = !!(s && s.coverText);
                if (fCustomIds) fCustomIds.checked = !!(s && s.customIds);
                if (fSort) fSort.checked = !!(s && s.sortDesc);

                // packs & colors
                if (fPacks) fPacks.value = s ? (s.packs || '') : "1,2,5,10,20,50";
                // step (single active step for now)
                const step = (s && Array.isArray(s.steps) && s.steps[0]) ? s.steps[0] : {
                    id: 1,
                    name: 'ONE',
                    start: '',
                    end: '',
                    status: 'draft'
                };
                if (fStepName) fStepName.value = step.name || 'ONE';
                if (fStepStart) fStepStart.value = step.start || '';
                if (fStepEnd) fStepEnd.value = step.end || '';
                if (fStepStatus) fStepStatus.value = step.status || 'draft';
                if (fPrimary) fPrimary.value = s ? (s.primary || '#01233f') : '#01233f';
                if (fSecondary) fSecondary.value = s ? (s.secondary || '#ff7f00') : '#ff7f00';
                syncPickerFromText();

                // display mode
                setMode(s ? (s.displayMode || 'Clair') : 'Clair');

                // cover
                coverDataUrl = s ? (s.cover || null) : null;
                if (coverUpload) {
                    coverUpload.style.backgroundImage = coverDataUrl ? `url(${coverDataUrl})` : "none";
                    coverUpload.classList.toggle("hasimg", !!coverDataUrl);
                }
                if (fCoverFile) fCoverFile.value = "";

                // document
                docDataUrl = s ? (s.docDataUrl || null) : null;
                docFileName = s ? (s.docName || '') : '';
                if (fDocFile) fDocFile.value = "";
                setDocLabel();

                overlay.style.display = '';
                overlay.setAttribute('aria-hidden', 'false');
                overlay.classList.add('show');
                const mb = document.querySelector('.mbody');
                if (mb) mb.scrollTop = 0;
                setTimeout(() => fName && fName.focus(), 50);
            }

            function closeModal() {
                overlay.classList.remove('show');
                overlay.setAttribute('aria-hidden', 'true');
                // Hard fallback for any CSS issues
                overlay.style.display = 'none';
                requestAnimationFrame(() => {
                    overlay.style.display = '';
                });
                state.editingId = null;
                // reset temp file buffers
                coverDataUrl = null;
                docDataUrl = null;
                docFileName = '';
            }

            function esc(s) {
                return String(s || '').replace(/[&<>"']/g, m => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                } [m]));
            }

            function countCandidatesFor(session) {
                try {
                    const raw = localStorage.getItem('votium_candidates_v1');
                    const arr = raw ? JSON.parse(raw) : [];
                    if (!Array.isArray(arr)) return 0;
                    const sid = session && session.id != null ? String(session.id) : '';
                    const sname = session && session.name ? String(session.name) : '';
                    return arr.filter(c => {
                        if (!c) return false;
                        if (sid && String(c.sessionId || '') === sid) return true;
                        if (sname && String(c.session || '') === sname && (!sid || !c.sessionId))
                            return true;
                        return false;
                    }).length;
                } catch (e) {
                    return 0;
                }
            }

            function goVote(session) {
                if (!session) return;
                const sid = session.id != null ? String(session.id) : '';
                const name = session.name || '';
                localStorage.setItem(SELECT_KEY, name);
                const qs = new URLSearchParams();
                if (sid) qs.set('sid', sid);
                if (name) qs.set('session', name);
                location.href = 'votes.html?' + qs.toString();
            }

            function goCands(session) {
                if (!session) return;
                const sid = session.id != null ? String(session.id) : '';
                const name = session.name || '';
                localStorage.setItem(SELECT_KEY, name);
                const qs = new URLSearchParams();
                if (sid) qs.set('sid', sid);
                if (name) qs.set('session', name);
                location.href = 'candidats.html?' + qs.toString();
            }

            function filtered() {
                const term = (q && q.value || '').trim().toLowerCase();
                let arr = sessions.slice();
                if (term) arr = arr.filter(s => (s.name || '').toLowerCase().includes(term));
                return arr;
            }

            function render() {
                const arr = filtered();
                const total = arr.length;
                const pages = Math.max(1, Math.ceil(total / state.perPage));
                state.page = Math.min(state.page, pages);

                if (kpiCount) kpiCount.textContent = total;
                if (pagesEl) pagesEl.textContent = pages;
                if (pageEl) pageEl.textContent = state.page;
                if (shownEl) shownEl.textContent = total;

                const start = (state.page - 1) * state.perPage;
                const slice = arr.slice(start, start + state.perPage);

                rows.innerHTML = slice.map(s => {
                    const cands = countCandidatesFor(s);
                    const insPill = (s.ins === "Autorisees") ?
                        '<span class="pill ok">Autorisées</span>' :
                        '<span class="pill no">Bloquées</span>';

                    return `
        <tr data-id="${s.id}">
          <td>
            <div class="name">${esc(s.name)}</div>
            <div class="name"><span class="tag">Créée le ${esc(s.created||'—')}</span></div>
          </td>
          <td class="muted"><b>${Array.isArray(s.steps)?s.steps.length:0}</b></td>
          <td><b>${cands}</b></td>
          <td class="muted">${esc(s.created||'—')}</td>
          <td>${insPill}</td>
          <td>
            <div class="actions">
              <button class="iconbtn primary" type="button" data-act="vote" title="Voir vote">
                <svg viewBox="0 0 24 24"><path d="M12 5c5.05 0 9.27 3.11 11 7-1.73 3.89-5.95 7-11 7S2.73 15.89 1 12c1.73-3.89 5.95-7 11-7Zm0 2C7.92 7 4.44 9.43 3.07 12 4.44 14.57 7.92 17 12 17s7.56-2.43 8.93-5C19.56 9.43 16.08 7 12 7Zm0 2.5A2.5 2.5 0 1 1 9.5 12 2.5 2.5 0 0 1 12 9.5Z"/></svg>
              </button>
              <button class="iconbtn purple" type="button" data-act="cands" title="Candidats">
                <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3ZM8 11c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3Zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13Zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5C23 14.17 18.33 13 16 13Z"/></svg>
              </button>
              <button class="iconbtn" type="button" data-act="edit" title="Modifier">
                <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25ZM20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82Z"/></svg>
              </button>
              <button class="iconbtn danger" type="button" data-act="del" title="Supprimer">
                <svg viewBox="0 0 24 24"><path d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6v12Zm3.5-9h1v8h-1v-8Zm4 0h1v8h-1v-8ZM15.5 10h1v8h-1v-8ZM15 4l-1-1h-4l-1 1H5v2h14V4h-4Z"/></svg>
              </button>
            </div>
          </td>
        </tr>
      `;
                }).join('');

                prev.disabled = state.page <= 1;
                next.disabled = state.page >= pages;
            }

            // actions
            btnCreate && btnCreate.addEventListener('click', () => openModal(null));
            closeBtn && closeBtn.addEventListener('click', closeModal);
            cancelBtn && cancelBtn.addEventListener('click', closeModal);
            overlay && overlay.addEventListener('click', (e) => {
                if (e.target === overlay) closeModal();
            });
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && overlay.classList.contains('show')) closeModal();
            });

            q && q.addEventListener('input', () => {
                state.page = 1;
                render();
            });


            // Cover upload (demo): store as DataURL in localStorage with the session
            if (fakeUpload && fCoverFile) {
                fakeUpload.addEventListener('click', () => fCoverFile.click());
                fCoverFile.addEventListener('change', () => {
                    const file = fCoverFile.files && fCoverFile.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = () => {
                        coverDataUrl = String(reader.result || "");
                        if (coverUpload) {
                            coverUpload.style.backgroundImage = coverDataUrl ? `url(${coverDataUrl})` :
                                "none";
                            coverUpload.classList.toggle("hasimg", !!coverDataUrl);
                        }
                        toast("Cover ajouté");
                    };
                    reader.readAsDataURL(file);
                });
            }

            saveBtn && saveBtn.addEventListener('click', () => {
                const name = (fName.value || '').trim();
                if (!name) {
                    toast('Nom de session requis.');
                    fName.focus();
                    const mb = document.querySelector('.mbody');
                    if (mb) mb.scrollTop = 0;
                    return;
                }

                const exists = sessions.find(s => (s.name || '').toLowerCase() === name.toLowerCase() && s
                    .id !== state.editingId);
                if (exists) {
                    toast('Une session avec ce nom existe déjà.');
                    fName.focus();
                    const mb = document.querySelector('.mbody');
                    if (mb) mb.scrollTop = 0;
                    return;
                }

                const payload = {
                    name,
                    steps: (() => {
                        const nm = (fStepName && (fStepName.value || '').trim()) || 'ONE';
                        const st = fStepStart ? (fStepStart.value || '') : '';
                        const en = fStepEnd ? (fStepEnd.value || '') : '';
                        const status = fStepStatus ? (fStepStatus.value || 'draft') : 'draft';
                        return [{
                            id: 1,
                            name: nm,
                            start: st,
                            end: en,
                            status: status
                        }];
                    })(),
                    activeStepId: 1,
                    ins: (fIns.value === 'Autorisees') ? 'Autorisees' : 'Non-autorisee',
                    desc: fDesc ? (fDesc.value || '').trim() : '',
                    cover: coverDataUrl || null,
                    coverText: !!(fCoverText && fCoverText.checked),
                    customIds: !!(fCustomIds && fCustomIds.checked),
                    displayMode: displayMode || 'Clair',
                    sortDesc: !!(fSort && fSort.checked),
                    packs: (fPacks && (fPacks.value || '').trim()) || '',
                    primary: (fPrimary && fPrimary.value) ? fPrimary.value.trim() : '#01233f',
                    secondary: (fSecondary && fSecondary.value) ? fSecondary.value.trim() : '#ff7f00',
                    docName: docFileName || '',
                    docDataUrl: docDataUrl || null
                };

                if (state.editingId) {
                    const s = sessions.find(x => x.id === state.editingId);
                    if (s) {
                        Object.assign(s, payload);
                    }
                    toast('Session mise à jour');
                } else {
                    const nextId = Math.max(0, ...sessions.map(x => x.id || 0)) + 1;
                    sessions.unshift({
                        id: nextId,
                        created: new Date().toLocaleDateString('fr-FR'),
                        ...payload
                    });
                    toast('Session créée');
                }

                save(sessions);
                render();
                closeModal();
            });

            rows && rows.addEventListener('click', (e) => {
                const btn = e.target.closest('button[data-act]');
                if (!btn) return;
                const tr = btn.closest('tr[data-id]');
                if (!tr) return;
                const id = Number(tr.dataset.id);
                const s = sessions.find(x => x.id === id);
                if (!s) return;

                const act = btn.dataset.act;
                if (act === 'vote') return goVote(s);
                if (act === 'cands') return goCands(s);
                if (act === 'edit') return openModal(id);
                if (act === 'del') {
                    if (confirm(`Supprimer la session "${s.name}" ?`)) {
                        sessions = sessions.filter(x => x.id !== id);
                        save(sessions);
                        toast('Session supprimée');
                        render();
                    }
                }
            });

            prev && prev.addEventListener('click', () => {
                state.page = Math.max(1, state.page - 1);
                render();
            });
            next && next.addEventListener('click', () => {
                state.page = state.page + 1;
                render();
            });

            render();
        });
    </script>


    <div class="toast" id="toast" role="status" aria-live="polite"></div>
@endsection
<!-- section js -->
@section('extra-js')
@endsection
