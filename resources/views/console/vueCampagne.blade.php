<!DOCTYPE html>
<html lang="fr">

<!-- Basé sur votre structure fournie -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Chooz | Zenitsu Concours</title>
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
            --primary-yellow: #fce300; /* Le jaune vif de Chooz */
            --dark-header: #0b0f19;    /* Le fond sombre du header */
            --hero-bg: #000000;        /* Fond noir du Hero */
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
            background-color: #e63946; /* Fond rouge/orange du logo */
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
            width: 50%;
            height: 100%;
            background-image: url('data:image/jpeg;base64,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'); /* Placeholder Zenitsu */
            background-size: contain;
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
            background-color: #e8e638; /* Jaune sombre */
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
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
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
            object-fit: cover; /* ou 'contain' selon le besoin */
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
            background: #ff5722; /* Orange share button */
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
            color: white; /* ou noir selon préférence */
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

        /* --- Countdown Circles (Capture 2 Header) --- */
        .countdown-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px 0;
            background: #eee;
            overflow: hidden;
            height: 60px; /* Simule la coupure de la capture */
        }
        .countdown-circle {
            width: 80px;
            height: 80px;
            border: 3px solid var(--primary-yellow);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            margin-top: 10px; /* Pour couper le haut */
        }

        /* Flag Icon */
        .flag-icon {
            width: 20px;
            margin-left: 15px;
        }
    </style>
</head>

<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-chooz">
        <div class="container">
            <a class="navbar-brand" href="#">Chooz</a>
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
                        <h1 class="hero-title">Zenitsu concours</h1>
                        <p class="hero-text">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                            <br><br>
                            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Search Bar Section -->
        <section class="search-section">
            <div class="container d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 fw-bold">ONE</h4>
                    <small class="text-muted">lorem</small>
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
            <!-- Simulated Countdown Header like Capture 2 -->
            <div class="d-none d-md-flex justify-content-center mb-4" style="opacity: 0.5;">
                <!-- Just visual representation of the circles at top of screen 2 -->
                <div style="border:2px solid #fce300; width:100px; height:100px; border-radius:50%; border-bottom:none;"></div>
                <div style="border:2px solid #ddd; width:100px; height:100px; border-radius:50%; border-bottom:none; margin: 0 20px;"></div>
                <div style="border:2px solid #fce300; width:100px; height:100px; border-radius:50%; border-bottom:none;"></div>
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
            With <i class="fa-regular fa-heart"></i> by Sarrux
        </div>

    </div>
    <!-- End Wrapper -->

    <!-- jQuery & Bootstrap Scripts (From your base code + CDN for functionality) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    

</body>
</html>