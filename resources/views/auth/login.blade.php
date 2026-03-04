<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="VOTIUM vous aide à créer, gérer et suivre vos campagnes de votes en toute simplicité.">
    <title>VOTIUM — Connexion</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('asset/app.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/login.css') }}">
</head>
<body class="public auth-page">
<header class="topbar" role="banner">
    <div class="topbar-inner container">
        <a class="brand" href="{{ route('home') }}">
            <div aria-hidden="true" class="brandmark"><svg fill="none" viewbox="0 0 24 24">
                    <path d="M5 6.2c4.6-5 14-3.2 14 4.2 0 6.8-6.6 10.7-7 10.9-.4-.2-7-4.1-7-10.9 0-1.6.4-3.1 1-4.2z"
                          fill="rgba(255,255,255,.16)"></path>
                    <path d="M9 8.5l3.1 7.5L15 9.7" stroke="white" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.2"></path>
                </svg></div>
            <div class="brandtext">
                <strong>VOTIUM</strong>
                <span>Vote & Campagne</span>
            </div>
        </a>

        <nav class="public-links" aria-label="Navigation publique">
            <a href="{{ route('home') }}#pourquoi">Pourquoi VOTIUM</a>
            <a href="{{ route('home') }}#confiance">Ils nous font confiance</a>
            <a href="{{ route('home') }}#contacts">Contacts</a>
        </nav>

        <div class="topbar-right">
            <button class="pill role-pill" id="rolePill" type="button" aria-haspopup="menu" aria-expanded="false">
                <span class="pill-label">Espace membre</span>
                <span class="dot" aria-hidden="true"></span>
            </button>

            <div class="menu" id="roleMenu" role="menu" aria-label="Menu Promoteur" hidden>
                <div class="menu-inner" id="roleMenuInner">
                    <!-- rempli par app.js -->
                </div>
            </div>
        </div>
    </div>
</header>

<main class="auth-main">
    <div class="container auth-grid">
        <section class="auth-left">
            <div class="auth-badge">Espace promoteur</div>
            <h1>Connexion</h1>
            <p class="muted">Accédez à votre espace promoteur VOTIUM.</p>

            <div class="auth-perks">
                <div class="perk">
                    <span class="perk-ico">⚡</span>
                    <div>
                        <strong>Rapide</strong>
                        <small>Créez une session en quelques minutes.</small>
                    </div>
                </div>
                <div class="perk">
                    <span class="perk-ico">🧾</span>
                    <div>
                        <strong>Packs & billetterie</strong>
                        <small>Votes et tickets, selon vos règles.</small>
                    </div>
                </div>
                <div class="perk">
                    <span class="perk-ico">🔒</span>
                    <div>
                        <strong>Sécurisé</strong>
                        <small>Suivi clair, retraits organisés.</small>
                    </div>
                </div>
            </div>

            <div class="auth-back">
                <a class="link" href="{{ route('home') }}">← Retour au site</a>
            </div>
        </section>

        <section class="auth-card">
            <div class="card">
                <h2>Connexion</h2>
                <p class="muted">Accédez à votre espace promoteur VOTIUM.</p>

                <div class="mb-3">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Erreurs :</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form" action="{{ route('login') }}" method="POST" autocomplete="on">

                    @csrf

                    <label class="field">
                        <span>Email</span>
                        <input
                            type="email"
                            name="email"
                            placeholder="ex: contact@domaine.com"
                            value="{{ old('email') }}"
                            required
                            autofocus>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="field">
                        <span>Mot de passe</span>
                        <input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>

                    <button class="btn primary w100" type="submit">Se connecter</button>

                    <div class="form-row">
                        <a class="muted link" href=" ">Mot de passe oublié ?</a>
                    </div>
                </form>

                <p class="small muted" style="margin-top: 14px;">
                    Pas encore de compte ?
                    <a class="link" href="{{ route('register') }}">Créer un compte</a>
                </p>
            </div>
        </section>
    </div>
</main>

<script src="{{ asset('asset/app.js') }}"></script>
</body>

</html>