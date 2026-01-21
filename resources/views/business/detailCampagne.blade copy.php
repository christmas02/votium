<!DOCTYPE html>
<html lang="fr">

<!-- Basé sur votre structure fournie -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Campgane | {{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Votez pour le meilleur dessin">
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.png">

    <!-- Bootstrap CSS (CDN pour l'exemple si vous n'avez pas les fichiers locaux, sinon gardez vos liens) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tabler Icon CSS & FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts (Pour ressembler à la typo de l'image) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-yellow: #fce300;
            /* Le jaune vif de Chooz */
            --dark-header: #0b0f19;
            /* Le fond sombre du header */
            --hero-bg: #000000;
            /* Fond noir du Hero */
            --text-grey: #a0a0a0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* --- Navbar --- */
        .navbar-chooz {
            background-color: var(--dark-header);
            padding: 15px 0;
        }

        .navbar-brand {
            background-color: #e63946;
            /* Fond rouge/orange du logo */
            color: white !important;
            font-weight: 800;
            padding: 5px 15px;
            font-size: 1.5rem;
            text-transform: uppercase;
        }

        .nav-link {
            color: white !important;
            margin-left: 20px;
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--primary-yellow) !important;
        }

        /* --- Hero Section --- */
        .hero-section {
            background-color: var(--hero-bg);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
            min-height: 500px;
            display: flex;
            align-items: center;
        }

        .hero-title {
            color: var(--primary-yellow);
            font-weight: 800;
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .hero-text {
            color: #fff;
            font-size: 0.95rem;
            line-height: 1.6;
            max-width: 600px;
        }

        /* Simulation de l'image de Zenitsu en background à droite */
        .hero-image-container {
            position: absolute;
            right: 0;
            bottom: 0;
            width: 70%;
            height: 100%;
            background-image: url('{{ $campagne->image_couverture ? asset("uploads/" . $campagne->image_couverture) : "" }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: bottom right;
            opacity: 1;
            mask-image: linear-gradient(to right, transparent, black 20%);
            -webkit-mask-image: linear-gradient(to right, transparent, black 20%);
        }

        /* --- Search Bar Section --- */
        .search-section {
            background: white;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .search-input-group {
            position: relative;
        }

        .search-input-group input {
            border-radius: 50px;
            padding-left: 40px;
            border: 1px solid #ddd;
        }

        .search-input-group .fa-search {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            z-index: 5;
        }

        /* --- Categories --- */
        .section-title {
            font-weight: 700;
            margin: 40px 0 20px;
            color: #2c3e50;
        }

        .category-card {
            background: white;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            align-items: center;
            transition: transform 0.2s;
            margin-bottom: 20px;
        }

        .category-icon {
            width: 50px;
            height: 50px;
            background-color: #e8e638;
            /* Jaune sombre */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 1.2rem;
        }

        .category-info h5 {
            margin: 0;
            font-weight: 600;
            text-transform: capitalize;
        }

        .category-info small {
            color: #888;
        }

        /* --- Candidate Card (Capture 2) --- */
        .candidate-card {
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .candidate-img-wrapper {
            height: 250px;
            overflow: hidden;
            position: relative;
            background: #f0f0f0;
        }

        .candidate-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* ou 'contain' selon le besoin */
        }

        .card-body-custom {
            padding: 20px;
        }

        .candidate-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .candidate-subtitle {
            color: #888;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .vote-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .candidate-number {
            font-weight: 700;
            font-size: 1.2rem;
            color: #333;
        }

        .candidate-number small {
            font-size: 0.7rem;
            font-weight: 400;
            color: #888;
            display: block;
        }

        .vote-percent {
            color: var(--primary-yellow);
            font-weight: 800;
            font-size: 1.2rem;
            text-align: right;
        }

        .vote-percent small {
            color: #ccc;
            font-size: 0.7rem;
            display: block;
            font-weight: 400;
        }

        .action-row {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-share {
            background: #ff5722;
            /* Orange share button */
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-vote {
            background-color: var(--primary-yellow);
            color: white;
            /* ou noir selon préférence */
            border: none;
            flex-grow: 1;
            border-radius: 8px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .btn-vote:hover {
            background-color: #e6ce00;
            color: white;
        }

        /* Style du conteneur d'unité */
        .countdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        /* Le Cercle */
        .countdown-circle {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            /* Ombre légère pour le relief */
            transition: transform 0.3s ease;
        }

        .countdown-circle:hover {
            transform: translateY(-5px);
        }

        /* Effet de bordure partielle (Ring effect) */
        .countdown-circle::before {
            content: "";
            position: absolute;
            inset: -2px;
            /* Épaisseur de la bordure */
            border-radius: 50%;
            padding: 2px;
            background: linear-gradient(135deg, var(--circle-color) 70%, transparent 30%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        /* Couleurs personnalisées */
        .countdown-circle.primary {
            --circle-color: #fce300;
        }

        /* Jaune vif */
        .countdown-circle.secondary {
            --circle-color: #dee2e6;
        }

        /* Gris doux */

        /* Style du chiffre (La valeur) */
        .countdown-value {
            font-family: 'Inter', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: #2d3436;
            letter-spacing: -1px;
        }

        /* Style du texte (Le label) */
        .countdown-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #636e72;
            letter-spacing: 1px;
        }

        /* Flag Icon */
        .flag-icon {
            width: 20px;
            margin-left: 15px;
        }

        /* Conteneur de sélection */
        .vote-selection-wrapper {
            display: none;
            /* Masqué par défaut */
            border-top: 1px solid #eee;
            margin-bottom: 10px;
            max-height: 200px;
            overflow-y: auto;
            animation: slideIn 0.3s ease-out;
        }

        /* Classe ajoutée par JS pour afficher */
        .vote-selection-wrapper.show {
            display: block;
        }

        .vote-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.2s;
            border-bottom: 1px solid #f9f9f9;
        }

        .vote-item:hover {
            background-color: #f8f9fa;
            color: #f37021;
            /* Orange au survol */
        }

        .vote-item .price {
            color: #888;
            font-size: 0.85rem;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Styles pour vos boutons existants (rappel) */
        .action-row {
            display: flex;
            gap: 5px;
        }

        .btn-vote {
            background: #000;
            color: #fff;
            flex-grow: 1;
            border: none;
            padding: 10px;
            border-radius: 5px;
        }

        .btn-share {
            background: #f37021;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            width: 45px;
        }
    </style>
</head>

<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-chooz">
        <div class="container">
            <a class="navbar-brand" href="#">VOTIUM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Inscription</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">|</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Voter</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Site Web</a></li>
                    <li class="nav-item">
                        <!-- Simple CSS France Flag -->
                        <div class="d-flex border border-light ms-3" style="width:24px; height:16px;">
                            <div style="background:#0055A4; width:33%;"></div>
                            <div style="background:#FFFFFF; width:33%;"></div>
                            <div style="background:#EF4135; width:33%;"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-image-container"></div> <!-- Image Background -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 position-relative">
                        <h1 class="hero-title">{{ $campagne->name }}</h1>
                        <p class="hero-text">
                            {!! $campagne->description !!}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Etapes Bar Section -->
        <section class="search-section">
            <div class="container d-flex justify-content-between align-items-center">
                <div>
                    <img src="{{ env('IMAGES_PATH') }}/{{ $customer->logo }}" width="38" class="rounded-1 d-flex" alt="user-image">
                </div>
                <div class="search-input-group">
                    <i class="fa fa-search"></i>
                    <input type="text" class="form-control" placeholder="Rechercher un candidat" style="width: 250px;">
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="container mt-5">
            <h3 class="section-title">Catégories</h3>
            <div class="row">
                <!-- Category 1 -->
                <div class="col-md-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fa-solid fa-child-reaching"></i>
                        </div>
                        <div class="category-info">
                            <h5>dessin</h5>
                            <small>1 Candidat.e(s) / Nominé.e(s)</small>
                        </div>
                    </div>
                </div>
                <!-- Category 2 -->
                <div class="col-md-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fa-solid fa-child"></i>
                        </div>
                        <div class="category-info">
                            <h5>dessin anime</h5>
                            <small>0 Candidat.e(s) / Nominé.e(s)</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Candidates Section (Reproduction Capture 2) -->
        <section class="container mt-5 mb-5">
            <!-- Countdown Container -->
            <div class="d-none d-md-flex justify-content-center align-items-center gap-4 mb-5">

                <!-- Unité: Jours -->
                <div class="countdown-item">
                    <div class="countdown-circle primary">
                        <span class="countdown-value">08</span>
                    </div>
                    <span class="countdown-label">Jours</span>
                </div>

                <!-- Unité: Heures -->
                <div class="countdown-item">
                    <div class="countdown-circle secondary">
                        <span class="countdown-value">12</span>
                    </div>
                    <span class="countdown-label">Heures</span>
                </div>

                <!-- Unité: Minutes -->
                <div class="countdown-item">
                    <div class="countdown-circle primary">
                        <span class="countdown-value">45</span>
                    </div>
                    <span class="countdown-label">Minutes</span>
                </div>

                <!-- Unité: Secondes -->
                <div class="countdown-item">
                    <div class="countdown-circle secondary">
                        <span class="countdown-value">30</span>
                    </div>
                    <span class="countdown-label">Secondes</span>
                </div>

            </div>

            <div class="row">
                <!-- Card 002 -->
                <div class="col-md-4 col-lg-3">
                    <div class="candidate-card">
                        <div class="candidate-img-wrapper">
                            <!-- Placeholder image replicating the sketch style -->
                            <img src="https://placehold.co/400x500/e0e0e0/555?text=Sketch+Image" alt="Zenitsu Sketch">

                            <!-- Note: Pour avoir exactement l'image, remplacez le src par votre fichier local -->
                        </div>
                        <div class="card-body-custom">
                            <h5 class="candidate-title">Zenitsu christmas</h5>
                            <div class="candidate-subtitle">Candidat(e) / Nominé(e)</div>

                            <div class="vote-row">
                                <div class="candidate-number">
                                    <small>Numéro</small>
                                    002
                                </div>
                                <div class="vote-percent">
                                    0.00%
                                    <small>votes</small>
                                </div>
                            </div>

                            <!-- MENU DE SÉLECTION (Masqué par défaut) -->
                            <div class="vote-selection-wrapper">
                                <div class="vote-item" data-price="500">
                                    <span>1 Votes</span> <span class="price">500 Fcfa</span>
                                </div>
                                <div class="vote-item" data-price="2500">
                                    <span>5 Votes</span> <span class="price">2500 Fcfa</span>
                                </div>
                                <div class="vote-item" data-price="5000">
                                    <span>10 Votes</span> <span class="price">5000 Fcfa</span>
                                </div>
                                <div class="vote-item" data-price="10000">
                                    <span>20 Votes</span> <span class="price">10000 Fcfa</span>
                                </div>
                            </div>

                            <div class="action-row">
                                <button class="btn btn-share">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </button>
                                <button class="btn btn-vote js-vote-trigger">Voter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="candidate-card">
                        <div class="candidate-img-wrapper">
                            <!-- Placeholder image replicating the sketch style -->
                            <img src="https://placehold.co/400x500/e0e0e0/555?text=Sketch+Image" alt="Zenitsu Sketch">

                            <!-- Note: Pour avoir exactement l'image, remplacez le src par votre fichier local -->
                        </div>
                        <div class="card-body-custom">
                            <h5 class="candidate-title">Zenitsu christmas</h5>
                            <div class="candidate-subtitle">Candidat(e) / Nominé(e)</div>

                            <div class="vote-row">
                                <div class="candidate-number">
                                    <small>Numéro</small>
                                    002
                                </div>
                                <div class="vote-percent">
                                    0.00%
                                    <small>votes</small>
                                </div>
                            </div>

                            <!-- MENU DE SÉLECTION (Masqué par défaut) -->
                            <div class="vote-selection-wrapper">
                                <div class="vote-item" data-price="500">
                                    <span>1 Votes</span> <span class="price">500 Fcfa</span>
                                </div>
                                <div class="vote-item" data-price="2500">
                                    <span>5 Votes</span> <span class="price">2500 Fcfa</span>
                                </div>
                                <div class="vote-item" data-price="5000">
                                    <span>10 Votes</span> <span class="price">5000 Fcfa</span>
                                </div>
                                <div class="vote-item" data-price="10000">
                                    <span>20 Votes</span> <span class="price">10000 Fcfa</span>
                                </div>
                            </div>

                            <div class="action-row">
                                <button class="btn btn-share">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </button>
                                <button class="btn btn-vote js-vote-trigger">Voter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="candidate-card">
                        <div class="candidate-img-wrapper">
                            <!-- Placeholder image replicating the sketch style -->
                            <img src="https://placehold.co/400x500/e0e0e0/555?text=Sketch+Image" alt="Zenitsu Sketch">

                            <!-- Note: Pour avoir exactement l'image, remplacez le src par votre fichier local -->
                        </div>
                        <div class="card-body-custom">
                            <h5 class="candidate-title">Zenitsu christmas</h5>
                            <div class="candidate-subtitle">Candidat(e) / Nominé(e)</div>

                            <div class="vote-row">
                                <div class="candidate-number">
                                    <small>Numéro</small>
                                    002
                                </div>
                                <div class="vote-percent">
                                    0.00%
                                    <small>votes</small>
                                </div>
                            </div>

                           

                            <div class="action-row">
                                <button class="btn btn-share">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </button>
                                <button class="btn btn-vote">Voter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="candidate-card">
                        <div class="candidate-img-wrapper">
                            <!-- Placeholder image replicating the sketch style -->
                            <img src="https://placehold.co/400x500/e0e0e0/555?text=Sketch+Image" alt="Zenitsu Sketch">

                            <!-- Note: Pour avoir exactement l'image, remplacez le src par votre fichier local -->
                        </div>
                        <div class="card-body-custom">
                            <h5 class="candidate-title">Zenitsu christmas</h5>
                            <div class="candidate-subtitle">Candidat(e) / Nominé(e)</div>

                            <div class="vote-row">
                                <div class="candidate-number">
                                    <small>Numéro</small>
                                    002
                                </div>
                                <div class="vote-percent">
                                    0.00%
                                    <small>votes</small>
                                </div>
                            </div>

                            <div class="action-row">
                                <button class="btn btn-share">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </button>
                                <button class="btn btn-vote">Voter</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Placeholder for layout balance -->
                <div class="col-md-4 col-lg-3"></div>
                <div class="col-md-4 col-lg-3"></div>
            </div>
        </section>

        <div class="text-center pb-4 text-muted small">
            With <i class="fa-regular fa-heart"></i> by VOTIUM
        </div>

    </div>
    <!-- End Wrapper -->

    <!-- jQuery & Bootstrap Scripts (From your base code + CDN for functionality) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('click', function(e) {
            // 1. Gérer le clic sur le bouton "Voter"
            if (e.target.classList.contains('js-vote-trigger')) {
                const card = e.target.closest('.candidate-card');
                const menu = card.querySelector('.vote-selection-wrapper');

                // Fermer les autres menus ouverts (optionnel pour la propreté)
                document.querySelectorAll('.vote-selection-wrapper.show').forEach(m => {
                    if (m !== menu) m.classList.remove('show');
                });

                // Basculer (Toggle) le menu actuel
                menu.classList.toggle('show');
            }

            // 2. Gérer le clic sur une option de vote
            if (e.target.closest('.vote-item')) {
                const item = e.target.closest('.vote-item');
                const value = item.querySelector('span').innerText;
                console.log("Option choisie : " + value);

                // Logique de redirection ou de paiement ici...

                // Fermer le menu après sélection
                item.closest('.vote-selection-wrapper').classList.remove('show');
            }
        });
    </script>

</body>

</html>