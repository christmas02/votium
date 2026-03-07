@push('styles')
    @include('layout.css.candidat')
@endpush
@extends('layout.app.business')
@section('content')
    <main class="container">
        <div class="page-head">
            <div>
                <div class="crumbs">
                    <span>🏠 Accueil</span> <span class="sep">›</span> <span>Sessions</span> <span class="sep">›</span>
                    <span>Candidats</span>
                </div>
                <h1>Candidats</h1>
            </div>
            <div class="actions">
                <button class="btn primary" id="btnCreate">
                    <svg fill="none" viewbox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                    </svg>
                    Créer
                </button>
                <button class="btn ghost" id="btnImport">
                    <svg fill="none" viewbox="0 0 24 24">
                        <path d="M12 3v12" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                        <path d="M7 8l5-5 5 5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"></path>
                        <path d="M5 21h14" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                    </svg>
                    Importer
                </button>
                <button class="btn outline" id="btnExport">
                    <svg fill="none" viewbox="0 0 24 24">
                        <path d="M12 21V9" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                        <path d="M17 14l-5 5-5-5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"></path>
                        <path d="M5 3h14" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                    </svg>
                    Exporter
                </button>
            </div>
        </div>
        <section aria-label="Candidats et filtres" class="grid">
            <!-- Sidebar -->
            <aside class="panel">
                <div class="pad">
                    <h3>Choisir la session</h3>
                    <div class="field select-wrap">
                        <label>Session</label>
                        <select id="sessionSel">
                            <option><span data-session-name="">FINALE CONCOURS NATIONAL DE COIFFURE 2025</span>
                            </option>
                            <option>MISS INTERCOMMUNE 2026</option>
                            <option>AWARDS CULTURELS 2026</option>
                        </select>
                    </div>
                    <div class="field select-wrap">
                        <label>Choisir la catégorie</label>
                        <select id="catSel">
                            <option>Toutes les catégories</option>
                            <option>Coiffure Homme</option>
                            <option>Coiffure Femme</option>
                            <option>Make-up</option>
                        </select>
                    </div>
                    <div class="field select-wrap">
                        <label>Choisir l'étape</label>
                        <select id="stepSel">
                            <option>Toutes les étapes</option>
                        </select>
                    </div>
                </div>
                <div class="cats-head">
                    <div>
                        <b>Catégories</b>
                        <div class="hint" style="margin:4px 0 0">Gérer les catégories de la session.</div>
                    </div>
                    <button class="icon-btn" id="btnAddCat" title="Ajouter une catégorie">
                        <svg fill="none" viewbox="0 0 24 24">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                            </path>
                        </svg>
                    </button>
                </div>
                <div class="cat-list" id="catList">
                </div>
                <div class="export">
                    <button class="btn primary" id="btnExport2">
                        <svg fill="none" viewbox="0 0 24 24">
                            <path d="M12 21V9" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                            <path d="M17 14l-5 5-5-5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"></path>
                            <path d="M5 3h14" stroke="currentColor" stroke-linecap="round" stroke-width="2"></path>
                        </svg>
                        Exporter
                    </button>
                </div>
            </aside>
            <!-- Main -->
            <section>
                <div class="main-top">
                    <div class="search">
                        <div class="searchbox">
                            <svg fill="none" viewbox="0 0 24 24">
                                <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor"
                                    stroke-width="2"></path>
                                <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                </path>
                            </svg>
                            <input autocomplete="off" id="q" placeholder="Rechercher un candidat …"
                                type="text" />
                        </div>
                    </div>
                </div>
                <div class="grid-cards" id="cards"></div>
                <div class="loadmore">
                    <button class="btn outline" id="btnMore">Charger plus (20 / 31)</button>
                </div>
            </section>
        </section>
    </main>
    <!-- Modal candidate -->
    <div aria-labelledby="modalTitle" aria-modal="true" class="overlay" id="overlay" role="dialog">
        <div class="modal">
            <div class="modal-head">
                <h2 id="modalTitle">Ajouter un candidat</h2>
                <button aria-label="Fermer" class="close" id="btnClose">
                    <svg fill="none" viewbox="0 0 24 24">
                        <path d="M6 6l12 12M18 6l-12 12" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div aria-label="Photos du candidat" class="upload-row">
                    <label class="uploader" title="Ajouter une image">
                        <input accept="image/*" type="file" />
                        <svg fill="none" viewbox="0 0 24 24">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                            </path>
                        </svg>
                    </label>
                    <label class="uploader" title="Ajouter une image">
                        <input accept="image/*" type="file" />
                        <svg fill="none" viewbox="0 0 24 24">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                            </path>
                        </svg>
                    </label>
                    <label class="uploader" title="Ajouter une image">
                        <input accept="image/*" type="file" />
                        <svg fill="none" viewbox="0 0 24 24">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                            </path>
                        </svg>
                    </label>
                    <label class="uploader" title="Ajouter une image">
                        <input accept="image/*" type="file" />
                        <svg fill="none" viewbox="0 0 24 24">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                            </path>
                        </svg>
                    </label>
                    <label class="uploader" title="Ajouter une image">
                        <input accept="image/*" type="file" />
                        <svg fill="none" viewbox="0 0 24 24">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                            </path>
                        </svg>
                    </label>
                </div>
                <div class="form-grid">
                    <div class="full">
                        <label>Numéro du candidat</label>
                        <input id="fNum" placeholder="Numéro du candidat." type="text" />
                    </div>
                    <div class="full">
                        <label>Nom du candidat</label>
                        <input id="fName" placeholder="Nom du candidat." type="text" />
                    </div>
                    <div>
                        <label>Date de naissance</label>
                        <input id="fDob" type="date" />
                    </div>
                    <div>
                        <label>Numéro de téléphone</label>
                        <input id="fPhone" placeholder="0123456789" type="tel" />
                    </div>
                    <div class="full">
                        <label>Email</label>
                        <input id="fEmail" placeholder="johndoe@email.com." type="email" />
                    </div>
                    <div class="full select-wrap">
                        <label>Catégorie</label>
                        <select id="fCat">
                            <option>Choisir une catégorie</option>
                            <option>COIFFURE HOMME</option>
                            <option>COIFFURE FEMME</option>
                            <option>MAKE-UP</option>
                        </select>
                    </div>
                </div>
                <div class="hint">Astuce : ceci est une maquette front-only (tout est fictif). On branchera ensuite
                    le PHP/DB.</div>
            </div>
            <div class="modal-foot">
                <button class="btn light" id="btnCancel">Annuler</button>
                <button class="btn primary" id="btnSave">Valider</button>
            </div>
        </div>
    </div>
    <div aria-label="Catégorie" aria-modal="true" class="overlay" id="catOverlay" role="dialog">
        <div class="modal" style="max-width:520px">
            <div class="modal-head">
                <h2 id="catModalTitle">Ajouter une catégorie</h2>
                <button aria-label="Fermer" class="close" id="catBtnClose">
                    <svg fill="none" viewbox="0 0 24 24">
                        <path d="M6 6l12 12M18 6l-12 12" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-grid">
                    <div class="full">
                        <label>Nom de la catégorie</label>
                        <input id="catName" placeholder="Ex: COIFFURE HOMME" type="text" />
                    </div>
                </div>
                <div class="hint">Astuce : tu peux renommer une catégorie. La suppression est bloquée si des
                    candidats y sont rattachés.</div>
            </div>
            <div class="modal-foot">
                <button class="btn light" id="catBtnCancel">Annuler</button>
                <button class="btn primary" id="catBtnSave">Valider</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            /**
             * VOTIUM — Candidats (front-only)
             * CRUD Candidats + CRUD Catégories (localStorage)
             * Objectif: page 100% fonctionnelle pour la démo, prête à être "branchée" ensuite.
             */

            const STORAGE = {
                candidates: 'votium_candidates_v1',
                categories: 'votium_categories_v1',
            };

            // --- Context session (via URL) ---
            const QS = new URLSearchParams(location.search);
            const SID = (QS.get('sid') || '').trim(); // id stable
            const URL_SESSION_NAME = (QS.get('session') || '').trim(); // fallback name
            function categoriesKey() {
                const sid = activeSessionId();
                return sid ? (STORAGE.categories + ':' + sid) : STORAGE.categories;
            }
            const $ = (sel, root = document) => root.querySelector(sel);
            const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

            function uid() {
                return Math.floor(Date.now() + Math.random() * 1000);
            }

            function normalizeCat(s) {
                return (s || '').trim().replace(/\s+/g, ' ').toUpperCase();
            }

            function safeText(s) {
                return String(s ?? '').replace(/[<>&"]/g, ch => ({
                    '<': '&lt;',
                    '>': '&gt;',
                    '&': '&amp;',
                    '"': '&quot;'
                } [ch]));
            }

            function computeAgeLabel(dob) {
                if (!dob) return '—';
                const d = new Date(dob);
                if (Number.isNaN(d.getTime())) return '—';
                const now = new Date();
                let age = now.getFullYear() - d.getFullYear();
                const m = now.getMonth() - d.getMonth();
                if (m < 0 || (m === 0 && now.getDate() < d.getDate())) age--;
                if (age < 0) age = 0;
                return age + ' an' + (age > 1 ? 's' : '');
            }

            function loadJSON(key, fallback) {
                try {
                    const raw = localStorage.getItem(key);
                    if (!raw) return fallback;
                    return JSON.parse(raw);
                } catch (e) {
                    console.warn('Storage parse error', key, e);
                    return fallback;
                }
            }

            function approxSize(str) {
                try {
                    return (str || '').length;
                } catch (_) {
                    return 0;
                }
            }

            // Clean-up: if stored candidates are huge (photos), prune them once on load to avoid quota issues.
            function ensureStorageHealth() {
                try {
                    const raw = localStorage.getItem(STORAGE.candidates) || '';
                    // If JSON is too large (> ~3MB), prune photos to 1 per candidate and cap length.
                    if (approxSize(raw) > 3_000_000) {
                        const arr = JSON.parse(raw);
                        if (Array.isArray(arr)) {
                            const pruned = arr.map(c => {
                                const copy = Object.assign({}, c);
                                if (Array.isArray(copy.photos) && copy.photos.length) {
                                    copy.photos = [copy.photos[0]];
                                }
                                if (Array.isArray(copy.photos)) {
                                    copy.photos = copy.photos.map(p => (typeof p === "string" && p.length >
                                        120000) ? "" : p).filter(Boolean);
                                }
                                return copy;
                            });
                            localStorage.setItem(STORAGE.candidates, JSON.stringify(pruned));
                            console.warn("Storage was large; photos pruned automatically to avoid quota.");
                        }
                    }
                } catch (e) {
                    console.warn("ensureStorageHealth failed", e);
                }
            }

            function saveJSON(key, value) {
                try {
                    localStorage.setItem(key, JSON.stringify(value));
                } catch (e) {
                    const msg = (e && e.name) ? e.name : String(e);
                    console.error("Storage write error", key, e);

                    // Try automatic pruning if storage quota is exceeded (mostly caused by large base64 images)
                    const isQuota = (msg === "QuotaExceededError") || /quota/i.test(String(e && e.message || e));
                    if (isQuota && key === "votium_candidates_v1" && Array.isArray(value)) {
                        // 1) keep only 1 compressed photo max per candidate
                        const pruned = value.map(c => {
                            const copy = Object.assign({}, c);
                            if (Array.isArray(copy.photos) && copy.photos.length) {
                                copy.photos = [copy.photos[0]];
                            }
                            // 2) hard cap each dataURL length (fallback)
                            if (Array.isArray(copy.photos)) {
                                copy.photos = copy.photos.map(p => (typeof p === "string" && p.length >
                                    120000) ? "" : p).filter(Boolean);
                            }
                            return copy;
                        });
                        try {
                            localStorage.setItem(key, JSON.stringify(pruned));
                            toast("Mémoire navigateur presque pleine : photos réduites automatiquement ✅");
                            return;
                        } catch (e2) {
                            console.error("Storage pruning retry failed", e2);
                        }
                    }

                    alert(
                        `Mémoire du navigateur pleine (Quota).\n\nSolution rapide : ouvre storage_reset.html pour vider la démo, puis réessaie.\nAstuce : utilise des petites images (ou 1 seule) pour les candidats.`
                    );
                }
            }

            const seedCandidates = [{
                    id: 1,
                    name: "Diomandé Souleymane",
                    num: "00015",
                    dob: "2000-01-20",
                    phone: "",
                    email: "",
                    cat: "COIFFURE HOMME",
                    photos: []
                },
                {
                    id: 2,
                    name: "Ayepa Laroche",
                    num: "00002",
                    dob: "2002-09-14",
                    phone: "",
                    email: "",
                    cat: "COIFFURE HOMME",
                    photos: []
                },
                {
                    id: 3,
                    name: "Guide Seri Pacôme",
                    num: "00007",
                    dob: "2001-07-05",
                    phone: "",
                    email: "",
                    cat: "COIFFURE HOMME",
                    photos: []
                },
                {
                    id: 4,
                    name: "Tchama Edmond",
                    num: "00016",
                    dob: "1999-11-02",
                    phone: "",
                    email: "",
                    cat: "COIFFURE HOMME",
                    photos: []
                },
                {
                    id: 5,
                    name: "N'guessan Nancy",
                    num: "00012",
                    dob: "2004-04-08",
                    phone: "",
                    email: "",
                    cat: "COIFFURE HOMME",
                    photos: []
                },
                {
                    id: 6,
                    name: "Yapo Marie Reine",
                    num: "00031",
                    dob: "2003-02-11",
                    phone: "",
                    email: "",
                    cat: "COIFFURE HOMME",
                    photos: []
                },
                {
                    id: 7,
                    name: "Hortense Kalou",
                    num: "00025",
                    dob: "2001-12-30",
                    phone: "",
                    email: "",
                    cat: "COIFFURE HOMME",
                    photos: []
                },
                {
                    id: 8,
                    name: "Koné Hermine",
                    num: "00028",
                    dob: "2002-05-17",
                    phone: "",
                    email: "",
                    cat: "COIFFURE HOMME",
                    photos: []
                },
                {
                    id: 9,
                    name: "Kouamé Akissi Marie",
                    num: "00029",
                    dob: "2000-06-22",
                    phone: "",
                    email: "",
                    cat: "COIFFURE HOMME",
                    photos: []
                },
                {
                    id: 10,
                    name: "N'guessan Franck",
                    num: "00013",
                    dob: "1998-03-01",
                    phone: "",
                    email: "",
                    cat: "COIFFURE HOMME",
                    photos: []
                },
                {
                    id: 11,
                    name: "Kanga Hortense",
                    num: "00026",
                    dob: "2005-08-09",
                    phone: "",
                    email: "",
                    cat: "COIFFURE HOMME",
                    photos: []
                },
                {
                    id: 12,
                    name: "Ashou Boutique",
                    num: "00021",
                    dob: "2001-10-10",
                    phone: "",
                    email: "",
                    cat: "COIFFURE FEMME",
                    photos: []
                },
            ];

            const seedCategories = ["COIFFURE HOMME", "COIFFURE FEMME", "MAKE-UP"];

            let categories = loadJSON(categoriesKey(), null);
            let candidates = loadJSON(STORAGE.candidates, null);

            if (!Array.isArray(categories) || categories.length === 0) {
                categories = (activeSessionId() ? [] : seedCategories.slice());
                saveJSON(categoriesKey(), categories);
            }
            if (!Array.isArray(candidates) || candidates.length === 0) {
                candidates = [];
                // IMPORTANT: no fictive seed candidates — show empty if none
                // Candidates must come from real saved data.
            }

            // --- Sessions (optionnel) : alimenter le select depuis sessions.html (localStorage) ---
            function loadSessions() {
                try {
                    const raw = localStorage.getItem('votium_sessions_v1');
                    const arr = raw ? JSON.parse(raw) : null;
                    return Array.isArray(arr) ? arr : [];
                } catch (e) {
                    return [];
                }
            }

            function getSessionById(id) {
                const ss = loadSessions();
                return ss.find(s => String(s.id) === String(id)) || null;
            }

            function currentSession() {
                if (SID) return getSessionById(SID);
                // fallback by selected name
                const nm = (() => {
                    const fromUrl = URL_SESSION_NAME;
                    if (fromUrl) return fromUrl;
                    if (sessionSel && sessionSel.selectedOptions && sessionSel.selectedOptions[0])
                        return sessionSel.selectedOptions[0].textContent.trim();
                    return '';
                })();
                const ss = loadSessions();
                return ss.find(s => (s.name || '') === nm) || null;
            }

            function activeSessionId() {
                // priorité: sid dans l'URL
                if (SID) return String(SID);
                // sinon: session passée en URL ou mémorisée (nom)
                const nm = (() => {
                    const fromUrl = URL_SESSION_NAME;
                    if (fromUrl) return fromUrl;
                    try {
                        return localStorage.getItem('votium_selected_session') || '';
                    } catch (_) {
                        return '';
                    }
                })();
                if (!nm) return '';
                const ss = loadSessions();
                const hit = ss.find(s => (s && (s.name || '') === nm));
                return hit ? String(hit.id) : '';
            }

            function isCustomIdsEnabled() {
                const s = currentSession();
                return !!(s && s.customIds);
            }

            function applyCustomIdsUI() {
                const s = currentSession();
                const enabled = !!(s && s.customIds);
                if (fNumWrap) {
                    fNumWrap.style.display = enabled ? '' : 'none';
                }
                if (fNum) {
                    if (!enabled) {
                        fNum.value = '';
                        fNum.setAttribute('disabled', 'disabled');
                    } else {
                        fNum.removeAttribute('disabled');
                    }
                }
            }

            function nextAutoNumForSession(sessionId) {
                const sid = String(sessionId || SID || '');
                const inSess = candidates.filter(c => {
                    const csid = (c.sessionId != null) ? String(c.sessionId) : '';
                    if (csid) return csid === sid;
                    // compat by name
                    return String(c.session || '') === String(URL_SESSION_NAME || '');
                });
                let maxN = 0;
                for (const c of inSess) {
                    const n = String(c.num || '').trim();
                    const m = n.match(/^VOT-(\d{4,})$/i);
                    if (m) {
                        maxN = Math.max(maxN, parseInt(m[1], 10));
                    }
                }
                const next = maxN + 1;
                return "VOT-" + String(next).padStart(4, '0');
            }

            function refreshSessionSelect() {
                if (!sessionSel) return;
                const urlSession = URL_SESSION_NAME;
                const stored = localStorage.getItem('votium_selected_session');
                let wanted = urlSession || stored || '';
                if (SID) {
                    const sById = loadSessions().find(s => String(s.id) === String(SID));
                    if (sById && sById.name) wanted = sById.name;
                }
                const list = loadSessions().map(s => s && s.name).filter(Boolean);

                const current = wanted || (sessionSel.selectedOptions && sessionSel.selectedOptions[0] ? sessionSel
                    .selectedOptions[0].textContent.trim() : '');
                sessionSel.innerHTML = `<option>${safeText(current || 'Toutes les sessions')}</option>` +
                    `<option>Toutes les sessions</option>` +
                    list.filter(n => n !== 'Toutes les sessions').map(n => `<option>${safeText(n)}</option>`).join(
                        '');

                // set to wanted if exists
                const options = Array.from(sessionSel.options);
                const match = options.find(o => (o.textContent || '').trim() === wanted);
                if (match) sessionSel.value = match.value;
            }


            function stepsForSession() {
                const ss = loadSessions();
                const sid = SID ? String(SID) : (() => {
                    const nm = (sessionSel && sessionSel.selectedOptions && sessionSel.selectedOptions[0]) ?
                        sessionSel.selectedOptions[0].textContent.trim() : '';
                    const hit = ss.find(s => (s.name || '') === nm);
                    return hit ? String(hit.id) : '';
                })();
                const s = ss.find(x => String(x.id) === String(sid));
                const steps = (s && Array.isArray(s.steps) && s.steps.length) ? s.steps : [{
                    id: 1,
                    name: 'ONE',
                    start: '',
                    end: '',
                    status: 'draft'
                }];
                return steps;
            }

            function refreshStepSelect() {
                if (!stepSel) return;
                const steps = stepsForSession();
                const current = stepSel.value || 'Toutes les étapes';
                stepSel.innerHTML = '<option>Toutes les étapes</option>' + steps.map(st =>
                    `<option value="${st.id}">${escapeHtml(st.name||'ONE')}</option>`).join('');
                // try restore
                const exists = Array.from(stepSel.options).some(o => o.value === current);
                if (exists) stepSel.value = current;
            }


            // Elements
            const cardsEl = $('#cards');
            const q = $('#q');
            const catSel = $('#catSel');
            const fCat = $('#fCat');
            const btnCreate = $('#btnCreate');
            const overlay = $('#overlay');
            const btnClose = $('#btnClose');
            const btnCancel = $('#btnCancel');
            const btnSave = $('#btnSave');
            const modalTitle = $('#modalTitle');

            const fNum = $('#fNum');
            const fNumWrap = fNum ? fNum.parentElement : null;

            const fName = $('#fName');
            const fDob = $('#fDob');
            const fPhone = $('#fPhone');
            const fEmail = $('#fEmail');

            const uploadInputs = $$('.upload-row input[type="file"]');

            const btnImport = $('#btnImport');
            const btnExport = $('#btnExport');
            const btnExport2 = $('#btnExport2');
            const btnMore = $('#btnMore');

            const catList = $('#catList');
            const btnAddCat = $('#btnAddCat');

            const sessionSel = $('#sessionSel');
            const stepSel = $('#stepSel');

            const catOverlay = $('#catOverlay');
            const catBtnClose = $('#catBtnClose');
            const catBtnCancel = $('#catBtnCancel');
            const catBtnSave = $('#catBtnSave');
            const catModalTitle = $('#catModalTitle');
            const catName = $('#catName');

            const icons = {
                user: `<svg viewBox="0 0 24 24" fill="none"><path d="M16 11a4 4 0 1 0-8 0v1a4 4 0 1 0 8 0v-1Z" stroke="currentColor" stroke-width="2"/><path d="M4 20c1.5-3.5 5-5 8-5s6.5 1.5 8 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>`,
                eye: `<svg viewBox="0 0 24 24" fill="none"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2"/><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2"/></svg>`,

                eyeOff: `<svg viewBox="0 0 24 24" fill="none"><path d="M3 3l18 18" stroke="currentColor" stroke-linecap="round" stroke-width="2"/><path d="M10.58 10.58A3 3 0 0012 15a3 3 0 002.42-4.42" stroke="currentColor" stroke-linecap="round" stroke-width="2"/><path d="M9.88 5.09A10.94 10.94 0 0112 5c5.5 0 9.5 4.5 10 7-.21 1.05-1.06 2.67-2.5 4.12M6.11 6.11C3.82 7.7 2.4 9.9 2 12c.5 2.5 4.5 7 10 7 1.03 0 2.01-.16 2.93-.44" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg>`,
                edit: `<svg viewBox="0 0 24 24" fill="none"><path d="M4 20h4l10-10-4-4L4 16v4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M13 7l4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>`,
                trash: `<svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M6 7l1 14h10l1-14" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M9 7V4h6v3" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>`,
                plus: `<svg fill="none" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg>`,
                check: `<svg viewBox="0 0 24 24" width="14" height="14" fill="none"><path d="M20 6 9 17l-5-5" stroke="#ff7f00" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>`
            };

            // Toast
            let toastTimer = null;

            function toast(msg) {
                clearTimeout(toastTimer);
                let t = $('#toast');
                if (!t) {
                    t = document.createElement('div');
                    t.id = 'toast';
                    t.style.position = 'fixed';
                    t.style.bottom = '18px';
                    t.style.left = '50%';
                    t.style.transform = 'translateX(-50%)';
                    t.style.padding = '12px 14px';
                    t.style.borderRadius = '999px';
                    t.style.background = 'rgba(1,35,63,.92)';
                    t.style.color = '#fff';
                    t.style.fontWeight = '900';
                    t.style.boxShadow = '0 20px 60px rgba(0,0,0,.25)';
                    t.style.border = '1px solid rgba(255,255,255,.10)';
                    t.style.zIndex = '2000';
                    t.style.maxWidth = '90vw';
                    t.style.textAlign = 'center';
                    t.style.opacity = '0';
                    t.style.transition = 'opacity .2s ease';
                    document.body.appendChild(t);
                }
                t.textContent = msg;
                t.style.opacity = '1';
                toastTimer = setTimeout(() => {
                    t.style.opacity = '0';
                }, 2200);
            }

            // State
            let editingId = null;
            let editingPhotos = []; // dataURLs
            let editingCat = null;

            // Helpers
            function refreshCategorySelects() {
                // Filter select
                const currentFilter = catSel.value;
                catSel.innerHTML = `<option>Toutes les catégories</option><option>Sans catégorie</option>` +
                    categories.map(c => `<option>${safeText(c)}</option>`).join('');
                if (categories.includes(currentFilter)) catSel.value = currentFilter;
                else catSel.value = "Toutes les catégories";

                // Form select
                const currentForm = fCat.value;
                fCat.innerHTML =
                    `<option>Sans catégorie (optionnel)</option><option>Choisir une catégorie</option>` + categories
                    .map(c => `<option>${safeText(c)}</option>`).join('');
                if (categories.includes(currentForm)) fCat.value = currentForm;
            }

            function countByCategory(cat) {
                return candidates.filter(x => x.cat === cat).length;
            }

            function renderCategories() {
                catList.innerHTML = categories.map(cat => {
                    const cnt = countByCategory(cat);
                    return `
                <div class="cat" data-cat="${safeText(cat)}">
                    <div class="left">
                    <div aria-hidden="true" class="badge">
                        <svg fill="none" viewBox="0 0 24 24"><path d="M12 4c3 0 5 2 5 5 0 2-1 4-3 4h-4c-2 0-3-2-3-4 0-3 2-5 5-5Z" stroke="currentColor" stroke-width="2"/><path d="M8 21v-3a4 4 0 0 1 4-4 4 4 0 0 1 4 4v3" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg>
                    </div>
                    <div style="min-width:0">
                        <div class="name">${safeText(cat)}</div>
                        <div class="mini">${cnt} candidat${cnt>1?'s':''}</div>
                    </div>
                    </div>
                    <div class="tools">
                    <button class="tiny catEdit" title="Éditer">${icons.edit}</button>
                    <button class="tiny catDel" title="Supprimer" style="color:var(--danger)">${icons.trash}</button>
                    </div>
                </div>
                `;
                }).join('');

                $$('.catEdit', catList).forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        const cat = e.currentTarget.closest('.cat').getAttribute('data-cat');
                        openCatModal('Modifier la catégorie', cat);
                    });
                });
                $$('.catDel', catList).forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const cat = e.currentTarget.closest('.cat').getAttribute('data-cat');
                        const cnt = countByCategory(cat);
                        if (cnt > 0) {
                            toast(
                                "Suppression impossible : des candidats utilisent cette catégorie."
                            );
                            return;
                        }
                        if (confirm(`Supprimer la catégorie "${cat}" ?`)) {
                            categories = categories.filter(c => c !== cat);
                            saveJSON(categoriesKey(), categories);
                            refreshSessionSelect();
                            refreshStepSelect();
                            applyCustomIdsUI();
                            refreshCategorySelects();
                            renderCategories();
                            renderCandidates();
                            if (btnMore) {
                                btnMore.style.display = "none";
                            }
                            toast("Catégorie supprimée");
                        }
                    });
                });
                // Click on category name => filter candidates list by this category
                $$('.cat', catList).forEach(el => {
                    el.addEventListener('click', (e) => {
                        // ignore clicks on tool buttons
                        if (e.target.closest('.tools')) return;
                        const cat = el.getAttribute('data-cat') || '';
                        // set dropdown filter
                        if (catSel) {
                            catSel.value = cat;
                        }
                        renderCandidates(true);
                    });
                });

            }

            function makeAvatar(c) {
                const name = c && c.name ? c.name : '—';
                const photo = (c && Array.isArray(c.photos) && c.photos[0]) ? c.photos[0] : '';
                if (photo) {
                    return `<div class="thumb" aria-hidden="true" title="${safeText(name)}" style="background-image:url('${photo}'); background-size:cover; background-position:center;"></div>`;
                }
                return `<div class="thumb" aria-hidden="true" title="${safeText(name)}">${icons.user}</div>`;
            }

            function cardTpl(c) {
                const ageLabel = computeAgeLabel(c.dob);
                return `
                <article class="card ${c.active===false ? "inactive" : ""}" data-id="${c.id}" data-name="${safeText((c.name||'').toLowerCase())}" data-cat="${safeText(c.cat||'')}">
                <div class="top">
                    <div class="chk" role="checkbox" aria-checked="false" tabindex="0" title="Sélectionner" data-on="0"></div>
                    ${makeAvatar(c)}
                    <div class="meta2">
                    <div class="name">${safeText(c.name)}</div>
                    <div class="sub">Num: <b>${safeText(c.num)}</b></div>
                    <div class="age">Âge: ${safeText(ageLabel)}</div>
                    </div>
                    <div class="tools2">
                    <button type="button" class="tool view" title="Activer / Désactiver">${c.active===false ? icons.eyeOff : icons.eye}</button>
                    <button type="button" class="tool edit" title="Modifier">${icons.edit}</button>
                    <button type="button" class="tool danger" title="Supprimer">${icons.trash}</button>
                    </div>
                </div>
                <div class="bottom">
                    <div class="name-inline">${safeText(c.name)}</div>
                    <div class="tag" title="${safeText(c.cat||"Sans catégorie")}"><span class="dot"></span>${safeText(c.cat||"Sans catégorie")}</div>
                    <div class="status-pill" title="Statut">${c.active===false ? "Désactivé" : "Actif"}</div>
                    <div class="badge-right">ID ${String(c.id).padStart(5,'0')}</div>
                </div>
                </article>
            `;
            }

            function renderCandidates() {
                const term = q.value.trim().toLowerCase();
                const sessionFilter = (!sessionSel || sessionSel.value === 'Toutes les sessions') ? '' : (sessionSel
                    .selectedOptions && sessionSel.selectedOptions[0] ? sessionSel.selectedOptions[0]
                    .textContent.trim() : sessionSel.value);
                const catFilter = (catSel.value === "Toutes les catégories") ? "" : (catSel.value ===
                    "Sans catégorie" ? "__NONE__" : normalizeCat(catSel.value));
                const stepFilter = (!stepSel || stepSel.value === 'Toutes les étapes') ? '' : String(stepSel.value);
                const list = candidates
                    .filter(c => (!term || (c.name || '').toLowerCase().includes(term) || (c.num || '').includes(
                        term) || (c.phone || '').includes(term)))
                    .filter(c => {
                        if (SID) {
                            // Mode session forcée (sid dans l'URL) : on accepte
                            // - les candidats liés par sessionId
                            // - et (compat) les anciens candidats sans sessionId mais avec le même nom de session
                            const cur = currentSession();
                            const curName = cur ? (cur.name || '') : (URL_SESSION_NAME || '');
                            return (!sessionFilter || (String(c.sessionId || '') === String(SID)) || (!c
                                .sessionId && curName && (c.session || '') === curName));
                        }
                        return (!sessionFilter || ((c.session || '') === sessionFilter));
                    })
                    .filter(c => {
                        if (!catFilter) return true;
                        if (catFilter === '__NONE__') return !normalizeCat(c.cat);
                        return normalizeCat(c.cat) === catFilter;
                    })
                    .filter(c => {
                        if (!stepFilter) return true;
                        return String(c.stepId || '') === stepFilter;
                    })
                    .sort((a, b) => String(a.num || '').localeCompare(String(b.num || '')));

                cardsEl.innerHTML = list.map(cardTpl).join('');

                // checkbox interactions
                $$('.chk', cardsEl).forEach(chk => {
                    chk.addEventListener('click', () => toggleChk(chk));
                    chk.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            toggleChk(chk);
                        }
                    });
                });

                // buttons
                $$('.tool.view', cardsEl).forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        const id = Number(e.currentTarget.closest('.card').getAttribute('data-id'));
                        const idx = candidates.findIndex(x => x.id === id);
                        if (idx < 0) return;
                        const cur = candidates[idx];
                        candidates[idx] = {
                            ...cur,
                            active: !(cur.active === false)
                        };
                        saveJSON(STORAGE.candidates, candidates);
                        renderCandidates();
                        toast(candidates[idx].active === false ? "Candidat désactivé" :
                            "Candidat activé");
                    });
                });
                $$('.tool.edit', cardsEl).forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        const id = Number(e.currentTarget.closest('.card').getAttribute('data-id'));
                        startEditCandidate(id);
                    });
                });
                $$('.tool.danger', cardsEl).forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const id = Number(e.currentTarget.closest('.card').getAttribute('data-id'));
                        deleteCandidate(id);
                    });
                });
            }

            function toggleChk(chk) {
                const on = chk.getAttribute('data-on') === '1';
                chk.setAttribute('data-on', on ? '0' : '1');
                chk.setAttribute('aria-checked', on ? 'false' : 'true');
                chk.innerHTML = (on ? '' : icons.check);
            }

            // Candidate modal
            function resetForm() {
                editingId = null;
                editingPhotos = [];
                uploadInputs.forEach(inp => {
                    inp.value = '';
                    inp.dataset.dataurl = '';
                    const lab = inp.closest('.uploader');
                    if (lab) {
                        lab.classList.remove('has');
                        lab.style.backgroundImage = '';
                        lab.style.outline = '';
                    }
                });
                fNum.value = '';
                fName.value = '';
                fDob.value = '';
                fPhone.value = '';
                fEmail.value = '';
                fCat.value = 'Choisir une catégorie';
                applyCustomIdsUI();
            }

            function openModal(title = "Ajouter un candidat") {
                modalTitle.textContent = title;
                overlay.classList.add('show');
                setTimeout(() => fNum.focus(), 50);
            }

            function closeModal() {
                overlay.classList.remove('show');
            }

            function startEditCandidate(id) {
                const c = candidates.find(x => x.id === id);
                if (!c) return;
                editingId = id;
                editingPhotos = Array.isArray(c.photos) ? c.photos.slice(0, 5) : [];
                modalTitle.textContent = "Modifier le candidat";
                fNum.value = c.num || '';
                fName.value = c.name || '';
                fDob.value = c.dob || '';
                fPhone.value = c.phone || '';
                fEmail.value = c.email || '';
                fCat.value = c.cat || 'Choisir une catégorie';

                // show "has image" state (optional)
                uploadInputs.forEach((inp, idx) => {
                    inp.value = '';
                    inp.dataset.dataurl = editingPhotos[idx] || '';
                    const lab = inp.closest('.uploader');
                    if (lab) {
                        if (inp.dataset.dataurl) {
                            lab.classList.add('has');
                            lab.style.backgroundImage = `url('${inp.dataset.dataurl}')`;
                            lab.style.outline = '';
                        } else {
                            lab.classList.remove('has');
                            lab.style.backgroundImage = '';
                            lab.style.outline = '';
                        }
                    }
                });

                openModal("Modifier le candidat");
            }

            async function fileToDataURL(file) {
                // Convert image to a SMALL compressed DataURL to avoid localStorage quota issues
                return new Promise((resolve, reject) => {
                    try {
                        const reader = new FileReader();
                        reader.onload = async () => {
                            try {
                                const dataUrl = String(reader.result || "");
                                // If already small, keep it
                                if (dataUrl.length < 250000) {
                                    resolve(dataUrl);
                                    return;
                                }

                                const img = new Image();
                                img.onload = () => {
                                    try {
                                        const maxSide = 700; // keep UI crisp but small
                                        let w = img.naturalWidth || img.width;
                                        let h = img.naturalHeight || img.height;
                                        const scale = Math.min(1, maxSide / Math.max(w, h));
                                        w = Math.max(1, Math.round(w * scale));
                                        h = Math.max(1, Math.round(h * scale));

                                        const canvas = document.createElement("canvas");
                                        canvas.width = w;
                                        canvas.height = h;
                                        const ctx = canvas.getContext("2d");
                                        ctx.drawImage(img, 0, 0, w, h);

                                        // JPEG compression
                                        const out = canvas.toDataURL("image/jpeg", 0.72);
                                        resolve(out);
                                    } catch (err) {
                                        resolve(dataUrl);
                                    }
                                };
                                img.onerror = () => resolve(dataUrl);
                                img.src = dataUrl;
                            } catch (err) {
                                resolve(String(reader.result || ""));
                            }
                        };
                        reader.onerror = reject;
                        reader.readAsDataURL(file);
                    } catch (e) {
                        reject(e);
                    }
                });
            }
            uploadInputs.forEach((inp) => {
                inp.addEventListener('change', async () => {
                    const file = inp.files && inp.files[0];
                    if (!file) return;
                    if (!file.type.startsWith('image/')) {
                        toast("Fichier non supporté");
                        inp.value = '';
                        return;
                    }
                    const dataUrl = await fileToDataURL(file);
                    if (dataUrl && dataUrl.length > 350000) {
                        toast(
                            'Image trop lourde : compressée, mais préfère une photo plus légère'
                        );
                    }
                    inp.dataset.dataurl = dataUrl;
                    const lab = inp.closest('.uploader');
                    if (lab) {
                        lab.classList.add('has');
                        lab.style.backgroundImage = `url('${dataUrl}')`;
                        lab.style.outline = '';
                    }
                });
            });

            function validateCandidatePayload(payload) {
                const errors = [];
                const needsNum = isCustomIdsEnabled();
                // Numéro: si vide, on auto-génère (même si customIds est activé) pour éviter de bloquer la démo.
                if (!payload.name || payload.name.trim().length < 2) errors.push("Nom requis");
                // Catégorie optionnelle (certains votes n'en ont pas)
                if (payload.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(payload.email)) errors.push(
                    "Email invalide");
                return errors;
            }

            function upsertCandidate() {
                const payload = {
                    id: editingId ?? uid(),
                    num: (fNum.value || '').trim(),
                    name: (fName.value || '').trim(),
                    dob: fDob.value || '',
                    phone: (fPhone.value || '').trim(),
                    email: (fEmail.value || '').trim(),
                    cat: (() => {
                        const v = (fCat.value || '').trim();
                        const n = normalizeCat(v);
                        if (!n) return '';
                        if (n === 'CHOISIR UNE CATÉGORIE' || n === 'CHOISIR UNE CATEGORIE') return '';
                        if (n.startsWith('SANS CATEGORIE') || n.startsWith('SANS CATÉGORIE')) return '';
                        return n;
                    })(),
                    photos: uploadInputs.map(i => i.dataset.dataurl || '').filter(Boolean).slice(0, 5),
                    stepId: (() => {
                        if (stepSel && stepSel.value && stepSel.value !== 'Toutes les étapes')
                            return String(stepSel.value);
                        const steps = stepsForSession();
                        const active = steps.find(s => s.status === 'active') || steps[0];
                        return String(active.id || 1);
                    })(),
                    step: (() => {
                        const steps = stepsForSession();
                        const sid = (stepSel && stepSel.value && stepSel.value !==
                            'Toutes les étapes') ? String(stepSel.value) : String((steps.find(s => s
                            .status === 'active') || steps[0]).id || 1);
                        const hit = steps.find(s => String(s.id) === sid);
                        return hit ? (hit.name || 'ONE') : 'ONE';
                    })(),
                    sessionId: (() => {
                        if (SID) return String(SID);
                        // fallback: find session id by selected name
                        const nm = (() => {
                            const fromUrl = URL_SESSION_NAME;
                            if (fromUrl) return fromUrl;
                            if (sessionSel && sessionSel.selectedOptions && sessionSel
                                .selectedOptions[0]) return sessionSel.selectedOptions[0]
                                .textContent.trim();
                            return '';
                        })();
                        const ss = loadSessions();
                        const hit = ss.find(s => (s.name || '') === nm);
                        return hit ? String(hit.id) : '';
                    })(),
                    session: (() => {
                        const fromUrl = new URLSearchParams(location.search).get('session');
                        if (fromUrl) return fromUrl;
                        if (sessionSel && sessionSel.selectedOptions && sessionSel.selectedOptions[0])
                            return sessionSel.selectedOptions[0].textContent.trim();
                        return '';
                    })(),
                    active: (editingId ? (((candidates.find(x => x.id === editingId)) || {}).active !== false) :
                        true),
                };
                // Numéro: obligatoire uniquement si "Identifiants candidats personnalisés" est activé sur la session
                const sess = currentSession();
                if (sess && !sess.customIds) {
                    if (!payload.num || !String(payload.num).trim()) {
                        payload.num = nextAutoNumForSession(payload.sessionId || SID);
                    }
                }



                // Numéro: si vide, on auto-génère toujours (démo) pour éviter de bloquer l'ajout.
                if (!payload.num || !String(payload.num).trim()) {
                    payload.num = nextAutoNumForSession(payload.sessionId || SID);
                }

                const errors = validateCandidatePayload(payload);
                if (errors.length) {
                    toast(errors[0]);
                    return;
                }

                // ensure category exists (auto-add)
                if (payload.cat && !categories.includes(payload.cat)) {
                    categories.push(payload.cat);
                    categories = Array.from(new Set(categories)).sort();
                    saveJSON(categoriesKey(), categories);
                    refreshCategorySelects();
                    renderCategories();
                }

                // prevent duplicate num (within same session)
                const dupe = candidates.find(c => c && c.num === payload.num && c.id !== payload.id && (c.session ||
                    '') === (payload.session || ''));
                if (dupe) {
                    toast("Numéro déjà utilisé par un autre candidat.");
                    return;
                }

                const idx = candidates.findIndex(c => c.id === payload.id);
                if (idx >= 0) candidates[idx] = payload;
                else candidates.push(payload);

                saveJSON(STORAGE.candidates, candidates);
                // S'assurer que l'UI affiche le nouveau candidat même si un filtre est actif
                try {
                    if (q) q.value = '';
                    if (sessionSel && payload.session) {
                        // si on est sans SID, on force la session sélectionnée sur celle du candidat
                        if (!SID) {
                            const opts = Array.from(sessionSel.options);
                            const m = opts.find(o => (o.textContent || '').trim() === (payload.session || '')
                                .trim());
                            if (m) sessionSel.value = m.value;
                            try {
                                localStorage.setItem('votium_selected_session', (payload.session || '').trim());
                            } catch (_) {}
                        }
                    }
                    if (catSel) catSel.value = "Toutes les catégories";
                    if (stepSel) stepSel.value = "Toutes les étapes";
                } catch (_) {}
                renderCandidates();
                renderCategories();
                toast(editingId ? "Candidat modifié" : "Candidat ajouté");
                closeModal();
            }

            function deleteCandidate(id) {
                const c = candidates.find(x => x.id === id);
                if (!c) return;
                if (!confirm(`Supprimer "${c.name}" (num ${c.num}) ?`)) return;
                candidates = candidates.filter(x => x.id !== id);
                saveJSON(STORAGE.candidates, candidates);
                renderCandidates();
                renderCategories();
                toast("Candidat supprimé");
            }

            // Categories modal
            function openCatModal(title, current = null) {
                catModalTitle.textContent = title;
                editingCat = current;
                catName.value = current || '';
                catOverlay.classList.add('show');
                setTimeout(() => catName.focus(), 50);
            }

            function closeCatModal() {
                catOverlay.classList.remove('show');
                editingCat = null;
                catName.value = '';
            }

            function saveCategory() {
                const name = normalizeCat(catName.value);
                if (!name) {
                    toast("Nom requis");
                    return;
                }

                // if edit
                if (editingCat) {
                    if (editingCat === name) {
                        closeCatModal();
                        return;
                    }
                    if (categories.includes(name)) {
                        toast("Cette catégorie existe déjà.");
                        return;
                    }
                    // rename in categories
                    categories = categories.map(c => c === editingCat ? name : c);
                    // rename in candidates
                    candidates = candidates.map(c => c.cat === editingCat ? ({
                        ...c,
                        cat: name
                    }) : c);
                    saveJSON(categoriesKey(), categories);
                    saveJSON(STORAGE.candidates, candidates);
                    refreshCategorySelects();
                    renderCategories();
                    renderCandidates();
                    toast("Catégorie modifiée");
                    closeCatModal();
                    return;
                }

                // add
                if (categories.includes(name)) {
                    toast("Cette catégorie existe déjà.");
                    return;
                }
                categories.push(name);
                categories = Array.from(new Set(categories)).sort();
                saveJSON(categoriesKey(), categories);
                refreshCategorySelects();
                renderCategories();
                toast("Catégorie ajoutée");
                closeCatModal();
            }

            // Import / Export
            function download(filename, text) {
                const blob = new Blob([text], {
                    type: 'application/json'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                setTimeout(() => URL.revokeObjectURL(url), 500);
            }

            function exportData() {
                const payload = {
                    exported_at: new Date().toISOString(),
                    categories,
                    candidates,
                };
                download('votium_candidats_export.json', JSON.stringify(payload, null, 2));
                toast("Export terminé");
            }

            function importData() {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'application/json';
                input.onchange = async () => {
                    const file = input.files && input.files[0];
                    if (!file) return;
                    const text = await file.text();
                    try {
                        const data = JSON.parse(text);
                        if (!data || !Array.isArray(data.candidates) || !Array.isArray(data.categories)) {
                            toast("Fichier invalide");
                            return;
                        }
                        categories = data.categories.map(normalizeCat).filter(Boolean);
                        candidates = data.candidates.map(c => ({
                            id: Number(c.id) || uid(),
                            num: String(c.num || '').trim(),
                            name: String(c.name || '').trim(),
                            dob: c.dob || '',
                            phone: String(c.phone || '').trim(),
                            email: String(c.email || '').trim(),
                            cat: normalizeCat(c.cat),
                            photos: Array.isArray(c.photos) ? c.photos.slice(0, 5) : [],
                        }));
                        // ensure unique categories
                        categories = Array.from(new Set(categories.concat(candidates.map(c => c.cat).filter(
                            Boolean)))).sort();
                        saveJSON(categoriesKey(), categories);
                        saveJSON(STORAGE.candidates, candidates);
                        refreshCategorySelects();
                        renderCategories();
                        renderCandidates();
                        toast("Import terminé");
                    } catch (e) {
                        toast("Erreur import JSON");
                    }
                };
                input.click();
            }

            // Wire events
            q.addEventListener('input', renderCandidates);
            catSel.addEventListener('change', renderCandidates);
            if (sessionSel) {
                sessionSel.addEventListener('change', () => {
                    try {
                        localStorage.setItem('votium_selected_session', sessionSel.selectedOptions[0]
                            .textContent.trim());
                    } catch (_) {}
                    refreshStepSelect();
                    applyCustomIdsUI();
                    renderCandidates();
                    renderCategories();
                });
            }

            btnCreate.addEventListener('click', () => {
                resetForm();
                applyCustomIdsUI();
                openModal("Ajouter un candidat");
            });
            btnClose.addEventListener('click', closeModal);
            btnCancel.addEventListener('click', closeModal);
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) closeModal();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && overlay.classList.contains('show')) closeModal();
            });

            btnSave.addEventListener('click', upsertCandidate);

            btnAddCat.addEventListener('click', () => openCatModal("Ajouter une catégorie"));
            catBtnClose.addEventListener('click', closeCatModal);
            catBtnCancel.addEventListener('click', closeCatModal);
            catOverlay.addEventListener('click', (e) => {
                if (e.target === catOverlay) closeCatModal();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && catOverlay.classList.contains('show')) closeCatModal();
            });
            catBtnSave.addEventListener('click', saveCategory);

            btnExport && btnExport.addEventListener('click', exportData);
            btnExport2 && btnExport2.addEventListener('click', exportData);
            btnImport && btnImport.addEventListener('click', importData);

            // init
            refreshCategorySelects();
            renderCategories();
            renderCandidates();
        });
    </script>
@endsection
<!-- section js -->
@section('extra-js')
@endsection
