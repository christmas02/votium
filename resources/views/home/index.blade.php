@extends('layout.header.home')

@section('content')
    <section class="hero">
        <div class="blob b1"></div>
        <div class="blob b2"></div>
        <div class="blob b3"></div>

        <div class="hero-grid">
            <div>
                <div class="badge reveal">
                    <span class="spark">⚡</span>
                    Expérience premium • rapide • temps réel
                </div>

                <h1 class="reveal">
                    Quand on arrive sur VOTIUM, <span class="accent">on vote</span>… ou on
                    <span class="accent">lance une campagne</span>.
                </h1>

                <p class="sub reveal">
                    Une interface moderne qui donne envie d’agir : voter en quelques secondes,
                    ou créer une campagne claire et pro, prête pour l’intégration paiement.
                </p>

                <div class="cta reveal">
                    <a class="btn primary" href="votes.html">
                        <span class="ic">🗳️</span> Je vote maintenant
                    </a>
                    <a class="btn ghost" href="inscription.html">
                        <span class="ic">🚀</span> Créer une campagne
                    </a>
                </div>

                <div class="proof">
                    <div class="kpi reveal">
                        <b><span data-count="3">0</span>s</b>
                        <p>Pour arriver au vote. Parcours simple, sans friction.</p>
                    </div>
                    <div class="kpi reveal">
                        <b>Temps réel</b>
                        <p>Suivi, progression, confirmation, reçu.</p>
                    </div>
                    <div class="kpi reveal">
                        <b>Multi-paiement</b>
                        <p>Wave • Orange • MTN • Moov • Carte bancaire.</p>
                    </div>
                </div>
            </div>

            <aside class="preview reveal" aria-label="Aperçu campagnes">
                <div class="bar">
                    <div class="dots">
                        <span class="dot o"></span><span class="dot b"></span><span class="dot g"></span>
                    </div>
                    <div class="mini-nav">
                        <a class="chip" href="votes.html">Voter</a>
                        <a class="chip" href="login.html">Accéder</a>
                    </div>
                </div>

                <div class="content">
                    <div
                        style="display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:10px">
                        <div>
                            <b style="display:block; font-size:14px">Campagnes en direct</b>
                            <span style="display:block; color:var(--muted); font-size:12.5px; margin-top:4px">Clique
                                → vote instant</span>
                        </div>
                        <span class="glow">LIVE</span>
                    </div>

                    <div class="live-grid" id="liveGrid">
                        <!-- rempli par JS -->
                    </div>

                    <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap">
                        <a class="btn primary" href="votes.html"
                            style="height:44px; border-radius:14px; flex:1; min-width:200px">
                            <span class="ic">⚡</span> Ouvrir la page de vote
                        </a>
                        <a class="btn ghost" href="inscription.html"
                            style="height:44px; border-radius:14px; flex:1; min-width:200px">
                            <span class="ic">✨</span> Lancer ma campagne
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
    <section class="section reveal" id="trending">
        <div class="sec-head">
            <h2>Campagnes récentes en cours</h2>
            <p class="lead">Fais défiler, choisis une campagne, et passe au vote en 1 clic.</p>
        </div>

        <div class="carousel">
            <button class="car-btn prev" type="button" aria-label="Campagnes précédentes">‹</button>
            <div class="car-viewport" id="carViewport">
                <div class="car-track" id="carTrack" aria-live="polite"></div>
            </div>
            <button class="car-btn next" type="button" aria-label="Campagnes suivantes">›</button>
        </div>
    </section>


    <section class="section">
        <div class="split">
            <div class="panel reveal">
                <div style="display:flex; align-items:center; justify-content:space-between; gap:12px">
                    <div>
                        <b style="font-size:16px">Je suis votant</b>
                        <span style="display:block; margin-top:6px; color:var(--muted); line-height:1.55">
                            Tu arrives, tu choisis ton candidat, tu prends ton pack et tu valides.
                            C’est rapide, propre, premium.
                        </span>
                    </div>
                    <div
                        style="width:54px; height:54px; border-radius:18px; display:flex; align-items:center; justify-content:center; background:rgba(255,127,0,.12); border:1px solid rgba(255,127,0,.24)">
                        🗳️</div>
                </div>
                <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap">
                    <a class="btn primary" href="votes.html" style="height:44px; border-radius:14px"><span
                            class="ic">⚡</span> Voter maintenant</a>
                </div>
            </div>

            <div class="panel reveal">
                <div style="display:flex; align-items:center; justify-content:space-between; gap:12px">
                    <div>
                        <b style="font-size:16px">Je suis promoteur</b>
                        <span style="display:block; margin-top:6px; color:var(--muted); line-height:1.55">
                            Crée ta campagne, ajoute tes candidats, suis la performance.
                            Le design est validé, la logique est stable.
                        </span>
                    </div>
                    <div
                        style="width:54px; height:54px; border-radius:18px; display:flex; align-items:center; justify-content:center; background:rgba(0,174,255,.12); border:1px solid rgba(0,174,255,.24)">
                        📣</div>
                </div>
                <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap">
                    <a class="btn primary" href="inscription.html" style="height:44px; border-radius:14px"><span
                            class="ic">🚀</span> Créer une campagne</a>
                    <a class="btn ghost" href="login.html" style="height:44px; border-radius:14px"><span
                            class="ic">🔐</span> Connexion</a>
                </div>
            </div>
        </div>
    </section>
@endsection
