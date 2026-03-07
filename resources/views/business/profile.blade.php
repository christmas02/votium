@push('styles')
    @include('layout.css.profil')
@endpush
@extends('layout.app.business')
@section('content')
    <main class="page">
        <div class="container">
            <div class="crumbs">
                <span>🏠 Accueil</span> <span class="sep">›</span><b>Paramètres</b>
            </div>
            <div class="titleRow">
                <div>
                    <h1>Paramètres du compte</h1>
                    <div class="hint">Gérez votre entreprise, vos comptes de retrait et votre profil.</div>
                </div>
                
            </div>
            <section aria-label="Paramètres" class="shell">
                <div class="shellGrid">
                    <aside aria-label="Menu paramètres" class="side">
                        <button class="tab active" data-tab="entreprise" type="button">
                            <span aria-hidden="true" class="tabIcon">
                                <!-- building -->
                                <svg class="ic" fill="none" viewbox="0 0 24 24">
                                    <path d="M4 20V6a2 2 0 0 1 2-2h6v16H4Z" stroke="currentColor" stroke-linejoin="round"
                                        stroke-width="2"></path>
                                    <path d="M12 20V9a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v11H12Z" stroke="currentColor"
                                        stroke-linejoin="round" stroke-width="2"></path>
                                    <path d="M7 8h2M7 11h2M7 14h2M16 11h2M16 14h2" stroke="currentColor"
                                        stroke-linecap="round" stroke-width="2"></path>
                                </svg>
                            </span>
                            Entreprise
                        </button>
                        <button class="tab" data-tab="comptes" type="button">
                            <span aria-hidden="true" class="tabIcon">
                                <!-- bank -->
                                <svg class="ic" fill="none" viewbox="0 0 24 24">
                                    <path d="M3 10h18" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                    </path>
                                    <path d="M5 10V19M9 10V19M15 10V19M19 10V19" stroke="currentColor"
                                        stroke-linecap="round" stroke-width="2"></path>
                                    <path d="M4 10l8-5 8 5" stroke="currentColor" stroke-linejoin="round" stroke-width="2">
                                    </path>
                                    <path d="M4 19h16" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                    </path>
                                </svg>
                            </span>
                            Comptes de retrait
                        </button>
                        <button class="tab" data-tab="profil" type="button">
                            <span aria-hidden="true" class="tabIcon">
                                <!-- user -->
                                <svg class="ic" fill="none" viewbox="0 0 24 24">
                                    <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" stroke="currentColor" stroke-width="2">
                                    </path>
                                    <path d="M4 20a8 8 0 0 1 16 0" stroke="currentColor" stroke-linecap="round"
                                        stroke-width="2"></path>
                                </svg>
                            </span>
                            Profil
                        </button>
                    </aside>
                    <div class="main">
                        <!-- ENTREPRISE -->
                        <div class="panel" id="panel-entreprise">
                            <h2 class="sectionTitle">Entreprise</h2>
                            <p class="sectionSub">Mettez à jour les informations concernant votre organisation.</p>
                            <div class="divider"></div>
                            <div class="field span2">
                                <div class="label">Dénomination</div>
                                <div class="uploadRow">
                                    <div style="display:flex; align-items:center; gap:12px;">
                                        <div class="logoPreview" id="logoPreview" title="Logo entreprise">
                                            <span style="font-weight:1000; color:#0b2440;">V</span>
                                        </div>
                                        <div>
                                            <div style="font-weight:950; letter-spacing:-.2px">Logo / Image</div>
                                            <div
                                                style="color:var(--muted); font-weight:700; font-size:12px; margin-top:2px;">
                                                PNG/JPG • recommandé 512×512
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <input accept="image/*" hidden="" id="logoInput" type="file" />
                                        <button class="uploadBtn" id="btnUpload" type="button">
                                            <span aria-hidden="true">☁</span> Charger une image
                                        </button>
                                        <button class="trashBtn" id="btnRemove" title="Supprimer" type="button">
                                            <!-- trash -->
                                            <svg aria-hidden="true" fill="none" height="18" viewbox="0 0 24 24"
                                                width="18">
                                                <path d="M4 7h16" stroke="#dc2626" stroke-linecap="round"
                                                    stroke-width="2"></path>
                                                <path d="M10 11v7M14 11v7" stroke="#dc2626" stroke-linecap="round"
                                                    stroke-width="2"></path>
                                                <path d="M6 7l1 14h10l1-14" stroke="#dc2626" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                                <path d="M9 7V4h6v3" stroke="#dc2626" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <form id="entrepriseForm">
                                <div class="formGrid" style="margin-top:16px;">
                                    <div class="field">
                                        <div class="label">Nom de l'organisation</div>
                                        <div class="control">
                                            <svg aria-hidden="true" class="ic" fill="none" viewbox="0 0 24 24">
                                                <path d="M4 20V6a2 2 0 0 1 2-2h6v16H4Z" stroke="#01233f"
                                                    stroke-linejoin="round" stroke-width="2"></path>
                                                <path d="M12 20V9a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v11H12Z" stroke="#01233f"
                                                    stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <input name="org_name" placeholder="Ex: COMICO" type="text"
                                                value="COMICO">
                                            </input>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="label">Pays siège</div>
                                        <div class="control">
                                            <svg aria-hidden="true" class="ic" fill="none" viewbox="0 0 24 24">
                                                <path d="M12 22s8-4 8-12A8 8 0 1 0 4 10c0 8 8 12 8 12Z" stroke="#01233f"
                                                    stroke-linejoin="round" stroke-width="2"></path>
                                                <path d="M12 10a2.5 2.5 0 1 0-2.5-2.5A2.5 2.5 0 0 0 12 10Z" fill="#ff7f00">
                                                </path>
                                            </svg>
                                            <select name="country">
                                                <option>Côte d'Ivoire</option>
                                                <option>Sénégal</option>
                                                <option>Mali</option>
                                                <option>Burkina Faso</option>
                                                <option>France</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="label">Email de l'organisation</div>
                                        <div class="control">
                                            <svg aria-hidden="true" class="ic" fill="none" viewbox="0 0 24 24">
                                                <path d="M4 6h16v12H4V6Z" stroke="#01233f" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                                <path d="M4 7l8 6 8-6" stroke="#01233f" stroke-linejoin="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <input name="org_email" placeholder="contact@votium.com" type="email"
                                                value="intercommunem@gmail.com" />
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="label">Téléphone</div>
                                        <div class="control">
                                            <svg aria-hidden="true" class="ic" fill="none" viewbox="0 0 24 24">
                                                <path
                                                    d="M7 3h4l2 5-3 2c1 3 3 5 6 6l2-3 5 2v4c0 1-1 2-2 2C10 21 3 14 3 5c0-1 1-2 2-2h2Z"
                                                    stroke="#01233f" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <input name="org_phone" placeholder="+225 07 00 00 00 00" type="tel" />
                                        </div>
                                    </div>
                                    <div class="field span2">
                                        <div class="label">Adresse</div>
                                        <div class="control">
                                            <svg aria-hidden="true" class="ic" fill="none" viewbox="0 0 24 24">
                                                <path d="M12 22s8-4 8-12A8 8 0 1 0 4 10c0 8 8 12 8 12Z" stroke="#01233f"
                                                    stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <input name="org_address" placeholder="Siège social" type="text" />
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="label">Lien Facebook</div>
                                        <div class="control">
                                            <svg aria-hidden="true" class="ic" fill="none" viewbox="0 0 24 24">
                                                <path d="M14 9h3V6h-3c-2 0-4 2-4 4v3H7v3h3v6h3v-6h3l1-3h-4v-3c0-1 .6-1 1-1Z"
                                                    fill="#01233f"></path>
                                            </svg>
                                            <input name="facebook" placeholder="Lien du profil facebook"
                                                type="url" />
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="label">Lien Twitter / X</div>
                                        <div class="control">
                                            <svg aria-hidden="true" class="ic" fill="none" viewbox="0 0 24 24">
                                                <path d="M6 6l12 12M18 6L6 18" stroke="#01233f" stroke-linecap="round"
                                                    stroke-width="2"></path>
                                            </svg>
                                            <input name="x" placeholder="Lien du profil Twitter" type="url" />
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="label">Lien Linkedin</div>
                                        <div class="control">
                                            <svg aria-hidden="true" class="ic" fill="none" viewbox="0 0 24 24">
                                                <path
                                                    d="M6 9h3v11H6V9Zm1.5-5A1.8 1.8 0 1 0 7.5 7 1.8 1.8 0 0 0 7.5 4ZM11 9h3v2c.7-1.4 2-2.3 3.8-2.3 3 0 4.2 1.8 4.2 5V20h-3v-5.4c0-2.1-.7-3-2.2-3s-2.8 1-2.8 3.2V20h-3V9Z"
                                                    fill="#01233f"></path>
                                            </svg>
                                            <input name="linkedin" placeholder="Lien du profil Linkedin"
                                                type="url" />
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="label">Lien Youtube</div>
                                        <div class="control">
                                            <svg aria-hidden="true" class="ic" fill="none" viewbox="0 0 24 24">
                                                <path
                                                    d="M21 12s0-3.3-.4-4.7a3 3 0 0 0-2.1-2.1C17.1 4.8 12 4.8 12 4.8s-5.1 0-6.5.4A3 3 0 0 0 3.4 7.3C3 8.7 3 12 3 12s0 3.3.4 4.7a3 3 0 0 0 2.1 2.1c1.4.4 6.5.4 6.5.4s5.1 0 6.5-.4a3 3 0 0 0 2.1-2.1C21 15.3 21 12 21 12Z"
                                                    fill="#01233f" opacity=".92"></path>
                                                <path d="M10 9.5v5l5-2.5-5-2.5Z" fill="#ff7f00"></path>
                                            </svg>
                                            <input name="youtube" placeholder="Lien du profil Youtube" type="url" />
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="label">Lien Tiktok</div>
                                        <div class="control">
                                            <svg aria-hidden="true" class="ic" fill="none" viewbox="0 0 24 24">
                                                <path
                                                    d="M14 4c.6 3 2.4 5 6 5v3c-2.1 0-4-.7-6-2v6.4c0 3-2.4 5.6-5.4 5.6A5.6 5.6 0 0 1 3 16.4c0-3 2.4-5.4 5.4-5.4.5 0 1 .1 1.6.2v3.2c-.5-.3-1-.5-1.6-.5-1.2 0-2.2 1-2.2 2.2 0 1.3 1 2.4 2.4 2.4 1.3 0 2.4-1.1 2.4-2.4V4h3Z"
                                                    fill="#01233f"></path>
                                                <circle cx="18.3" cy="7.7" fill="#ff7f00" r="1.4">
                                                </circle>
                                            </svg>
                                            <input name="tiktok" placeholder="Lien du profil Tiktok" type="url" />
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="label">Site internet</div>
                                        <div class="control">
                                            <svg aria-hidden="true" class="ic" fill="none" viewbox="0 0 24 24">
                                                <path d="M4 12a8 8 0 1 0 8-8" stroke="#01233f" stroke-linecap="round"
                                                    stroke-width="2"></path>
                                                <path d="M4 12h16" stroke="#01233f" stroke-linecap="round"
                                                    stroke-width="2"></path>
                                                <path d="M12 4c2.5 2 4 5 4 8s-1.5 6-4 8c-2.5-2-4-5-4-8s1.5-6 4-8Z"
                                                    stroke="#01233f" stroke-linejoin="round" stroke-width="2"></path>
                                            </svg>
                                            <input name="website" placeholder="Lien du site web" type="url" />
                                        </div>
                                    </div>
                                </div>
                                <div class="actions">
                                    <button class="save" type="submit">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                        <!-- COMPTES -->
                        <div class="panel" id="panel-comptes" style="display:none;">
                            <h2 class="sectionTitle">Comptes de retrait</h2>
                            <p class="sectionSub">Ajoutez ou retirez des comptes sur lesquels effectuer vos futurs
                                virements.</p>
                            <div class="divider"></div>
                            <div
                                style="display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;">
                                <div style="color:var(--muted); font-weight:700;">Liste des comptes (démo)</div>
                                <button class="btnTop" id="btnAddAccount" style="padding:10px 12px; border-radius:14px;"
                                    type="button">
                                    <span aria-hidden="true">＋</span> Ajouter
                                </button>
                            </div>
                            <div id="accountsGrid"
                                style="display:grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap:14px; margin-top:14px;">
                            </div>
                            <div style="margin-top:16px; color:var(--muted); font-weight:700; font-size:12px;">
                                Astuce : en V1 (front-only) les comptes sont simulés. En PHP, on branchera la sauvegarde
                                réelle.
                            </div>
                        </div>
                        <!-- PROFIL -->
                        <div class="panel" id="panel-profil" style="display:none;">
                            <h2 class="sectionTitle">Profil</h2>
                            <p class="sectionSub">Gérez vos informations personnelles et la sécurité du compte.</p>
                            <div class="divider"></div>
                            <div class="formGrid">
                                <div class="field">
                                    <div class="label">Nom</div>
                                    <div class="control">
                                        <input type="text" value="Florent" />
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="label">Email</div>
                                    <div class="control">
                                        <input type="email" value="promoteur@votium.example" />
                                    </div>
                                </div>
                                <div class="field span2">
                                    <div class="label">Sécurité</div>
                                    <div class="control">
                                        <input type="password" value="••••••••••••" />
                                    </div>
                                    <div style="color:var(--muted); font-weight:700; font-size:12px; margin-top:6px;">
                                        En V1 (front-only) : pas de vrai changement de mot de passe. En PHP, on
                                        branchera l’API + hashing.
                                    </div>
                                </div>
                            </div>
                            <div class="actions">
                                <button class="save" id="btnSaveProfile" type="button">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
           
        </div>
    </main>
    <div aria-live="polite" class="toast" id="toast" role="status">
        <div aria-hidden="true" class="dot"></div>
        <div>
            <strong id="toastTitle">Enregistré</strong>
            <small id="toastMsg">Vos informations ont été sauvegardées (démo).</small>
        </div>
    </div>
    <script>
        // --- Tabs
        const tabs = document.querySelectorAll('.tab');
        const panels = {
            entreprise: document.getElementById('panel-entreprise'),
            comptes: document.getElementById('panel-comptes'),
            profil: document.getElementById('panel-profil'),
        };

        function showTab(key) {
            tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === key));
            Object.entries(panels).forEach(([k, el]) => el.style.display = (k === key) ? '' : 'none');
        }
        tabs.forEach(t => t.addEventListener('click', () => showTab(t.dataset.tab)));

        // --- Toast
        const toast = document.getElementById('toast');
        const toastTitle = document.getElementById('toastTitle');
        const toastMsg = document.getElementById('toastMsg');
        let toastTimer = null;

        function notify(title, msg) {
            toastTitle.textContent = title;
            toastMsg.textContent = msg;
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 2600);
        }

        // --- Upload preview
        const logoInput = document.getElementById('logoInput');
        const btnUpload = document.getElementById('btnUpload');
        const btnRemove = document.getElementById('btnRemove');
        const logoPreview = document.getElementById('logoPreview');

        btnUpload.addEventListener('click', () => logoInput.click());

        logoInput.addEventListener('change', (e) => {
            const file = e.target.files?.[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            logoPreview.innerHTML = `<img alt="Logo" src="${url}">`;
            notify("Logo mis à jour", "Image chargée (aperçu).");
        });

        btnRemove.addEventListener('click', () => {
            logoInput.value = '';
            logoPreview.innerHTML = `<span style="font-weight:1000; color:#0b2440;">V</span>`;
            notify("Logo supprimé", "Le logo a été retiré (démo).");
        });

        // --- Save entreprise (demo)
        document.getElementById('entrepriseForm').addEventListener('submit', (e) => {
            e.preventDefault();
            notify("Enregistré", "Vos informations entreprise ont été sauvegardées (démo).");
        });

        document.getElementById('btnSaveProfile').addEventListener('click', () => {
            notify("Profil enregistré", "Vos informations profil ont été sauvegardées (démo).");
        });

        // --- Demo accounts
        const accounts = [{
                name: "Mara",
                provider: "Wave",
                mask: "******8163"
            },
            {
                name: "MARA WAVE",
                provider: "Wave",
                mask: "******1591"
            },
            {
                name: "Mara Flooz",
                provider: "Flooz",
                mask: "******8355"
            },
            {
                name: "MARA MOMO",
                provider: "MTN MoMo",
                mask: "******1591"
            },
            {
                name: "ARTHUR OM",
                provider: "Orange Money",
                mask: "******3065"
            },
        ];
        const accountsGrid = document.getElementById('accountsGrid');

        function cardHTML(a) {
            const badge = `<span style="display:inline-flex;align-items:center;gap:8px;font-weight:900;color:#0b2440;">
        <span style="width:38px;height:38px;border-radius:14px;display:grid;place-items:center;background:#eef3ff;border:1px solid #e3ebff;color:var(--p);">
          ${a.provider.includes('Wave')?'🐧':a.provider.includes('MTN')?'📱':a.provider.includes('Flooz')?'💠':'🟧'}
        </span>
        ${a.name}
      </span>`;
            return `
        <div style="border:1px solid var(--line); background:#fff; border-radius:18px; padding:14px; box-shadow:0 10px 24px rgba(1,35,63,.06); position:relative;">
          <button type="button" title="Retirer" style="position:absolute; top:10px; right:10px; width:28px; height:28px; border-radius:10px; border:1px solid #e6ebf3; background:#fff; cursor:pointer; font-weight:1000;"
            onclick="this.closest('div').remove(); window.__notify('Compte retiré', 'Le compte a été supprimé (démo).');">×</button>
          <div style="display:flex; align-items:center; justify-content:space-between; gap:10px;">
            ${badge}
          </div>
          <div style="margin-top:8px; color:var(--muted); font-weight:800;">${a.mask}</div>
        </div>
      `;
        }
        accountsGrid.innerHTML = accounts.map(cardHTML).join('');

        // expose notify to inline buttons
        window.__notify = notify;

        document.getElementById('btnAddAccount').addEventListener('click', () => {
            const n = Math.floor(Math.random() * 9000) + 1000;
            accountsGrid.insertAdjacentHTML('afterbegin', cardHTML({
                name: 'Nouveau compte',
                provider: 'Wave',
                mask: `******${n}`
            }));
            notify("Compte ajouté", "Un compte fictif a été ajouté (démo).");
        });

        // Accueil button demo
        document.getElementById('btnAccueil').addEventListener('click', () => {
            notify("Navigation", "Bouton Accueil (démo).");
        });
    </script>
@endsection
