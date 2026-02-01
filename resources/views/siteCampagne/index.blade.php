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
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

        .etape {
            color: #000 !important;
        }

        .nav-link {
            /* color: white !important; */
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
            background-image: url('{{ $campagne->image_couverture ? asset('uploads/' . $campagne->image_couverture) : '' }}');
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

        .is-invalid {
            border: 1px solid #dc3545 !important;
            background-image: none !important;
            /* Enlève l'icône par défaut de bootstrap si gênant */
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            50% {
                transform: translateX(5px);
            }

            75% {
                transform: translateX(-5px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .shake-animation {
            animation: shake 0.3s;
        }
    </style>
    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <!-- BARRE DE NAVIGATION DES ÉTAPES (Crucial pour la règle 1 & 2) -->
        <nav class="bg-white border-bottom sticky-top">
            <div class="container d-flex justify-content-between align-items-center">
                <ul class="nav nav-pills py-3 gap-2">
                    @foreach ($campagne->etapes as $etape)
                        <li class="nav-item">
                            <a class="nav-link etape {{ $selectedEtapeId == $etape->etape_id ? 'active bg-light' : 'text-dark border' }}"
                                href="?etape_id={{ $etape->etape_id }}">
                                {{ $etape->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="search-input-group">
                    <i class="fa fa-search"></i>
                    <input type="text" id="candidatSearch" class="form-control"
                        placeholder="Rechercher un candidat..." style="width: 250px;">
                </div>
            </div>
        </nav>

        <main class="container mt-5 mb-5">
            @if ($selectedEtape)

                {{-- 1. CAS : L'étape n'est pas encore ouverte (is_upcoming) --}}
                @if ($selectedEtape->is_upcoming)
                    <div class="text-center mb-5">
                        <h2 class="fw-bold">L'étape "{{ $selectedEtape->name }}" ouvrira dans :</h2>
                    </div>

                    <div class="d-flex justify-content-center align-items-center gap-4 mb-5">
                        <div class="countdown-item">
                            <div class="countdown-circle primary">
                                <span
                                    class="countdown-value">{{ sprintf('%02d', $selectedEtape->countdown['days']) }}</span>
                            </div>
                            <span class="countdown-label">Jours</span>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-circle secondary">
                                <span
                                    class="countdown-value">{{ sprintf('%02d', $selectedEtape->countdown['hours']) }}</span>
                            </div>
                            <span class="countdown-label">Heures</span>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-circle primary">
                                <span
                                    class="countdown-value">{{ sprintf('%02d', $selectedEtape->countdown['minutes']) }}</span>
                            </div>
                            <span class="countdown-label">Minutes</span>
                        </div>
                    </div>

                    {{-- 2. CAS : L'étape est en cours (is_active_now) --}}
                @elseif($selectedEtape->is_active_now)
                    @php
                        // On filtre les catégories de la campagne qui ont des candidats liés à CETTE étape
                        $categoriesActives = $campagne->categories->filter(function ($cat) use ($selectedEtapeId) {
                            return $cat->candidats->where('etape_id', $selectedEtapeId)->count() > 0;
                        });
                    @endphp

                    {{-- REGLE 4.1 : Des catégories existent pour cette étape --}}
                    @if ($categoriesActives->count() > 0)
                        <section class="mb-5">
                            <h3 class="section-title">Catégories</h3>
                            <div class="row">
                                @foreach ($categoriesActives as $category)
                                    <div class="col-md-6 mb-3">
                                        <a href="?etape_id={{ $selectedEtapeId }}&category_id={{ $category->category_id }}"
                                            class="text-decoration-none text-dark">
                                            <div
                                                class="category-card {{ $selectedCategoryId == $category->category_id ? 'border-warning border-2 shadow' : '' }}">
                                                <div class="category-icon">
                                                    <i
                                                        class="fa-solid {{ $category->icon == 'femme' ? 'fa-child-dress' : 'fa-child' }}"></i>
                                                </div>
                                                <div class="category-info">
                                                    <h5>{{ $category->name }}</h5>
                                                    <small>{{ $category->candidats->where('etape_id', $selectedEtapeId)->count() }}
                                                        Candidat.e(s)</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <hr class="my-5">

                        {{-- Affichage des candidats si une catégorie est sélectionnée --}}
                        @if ($selectedCategoryId)
                            @php
                                $candidatsToDisplay = $selectedEtape->candidats->where(
                                    'category_id',
                                    $selectedCategoryId,
                                );
                                $catName =
                                    $categoriesActives->firstWhere('category_id', $selectedCategoryId)->name ?? '';
                            @endphp

                            <h4 class="mb-4">Candidats : {{ $catName }}</h4>
                            @include('siteCampagne.partials.candidate-list', [
                                'candidats' => $candidatsToDisplay,
                                'selectedEtape' => $selectedEtape,
                                'paymentMethods' => $paymentMethods,
                                'compteRetraits' => $compteRetraits,
                                'campagne' => $campagne,
                            ])
                        @else
                            <div class="alert alert-info text-center shadow-sm">
                                <i class="fa-solid fa-arrow-up me-2"></i> Sélectionnez une catégorie pour voir les
                                candidats.
                            </div>
                        @endif

                        {{-- REGLE 4.2 : Aucune catégorie n'existe pour cette étape --}}
                    @else
                        <h3 class="section-title">Candidats de l'étape</h3>
                        @if ($selectedEtape->candidats->count() > 0)
                            {{-- On affiche tous les candidats de l'étape directement --}}
                            @include('siteCampagne.partials.candidate-list', [
                                'candidats' => $selectedEtape->candidats,
                                'selectedEtape' => $selectedEtape,
                                'paymentMethods' => $paymentMethods,
                                'compteRetraits' => $compteRetraits,
                            ])
                        @else
                            <div class="alert alert-warning text-center">Aucun candidat n'est inscrit pour cette étape.
                            </div>
                        @endif
                    @endif

                    {{-- 3. CAS : L'étape est terminée (date de fin dépassée) --}}
                @else
                    <div class="text-center py-5">
                        <i class="fa-solid fa-calendar-check fa-3x text-muted mb-3"></i>
                        <h3 class="text-muted">Cette étape est désormais terminée.</h3>
                        <p>Les votes ne sont plus disponibles pour cette phase.</p>
                    </div>
                @endif
            @else
                {{-- Cas critique : pas d'étape du tout --}}
                <div class="alert alert-danger text-center">
                    Campagne non configurée ou aucune étape disponible.
                </div>
            @endif
        </main>
    </div>

    <div class="text-center pb-4 text-muted small">
        With <i class="fa-regular fa-heart"></i> by VOTIUM
    </div>

    </div>
    <!-- End Wrapper -->

    <!-- jQuery & Bootstrap Scripts (From your base code + CDN for functionality) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        //
        $(document).ready(function() {
            $("#candidatSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                // On cible le parent col-md-4 pour masquer toute la carte
                $(".candidate-card").each(function() {
                    var text = $(this).text().toLowerCase();
                    $(this).closest('.col-md-4').toggle(text.indexOf(value) > -1);
                });
            });
        });
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

        //Ce script gère tout le flux : sélection du package -> ouverture du modal -> validation CGU -> affichage paiement.
        document.addEventListener('DOMContentLoaded', function() {

            // ==========================================
            // 1. VARIABLES & ÉTAT INITIAL
            // ==========================================
            let currentTransaction = {
                candidatId: null,
                votes: 0,
                amount: 0,
                provider: null,
                providerSlug: null
            };

            const modalElement = document.getElementById('paymentModal');
            const bsModal = new bootstrap.Modal(modalElement);
            const step1 = document.getElementById('modal-step-1');
            const step2 = document.getElementById('modal-step-2');
            const step3 = document.getElementById('modal-step-3');
            const checkStep1 = document.getElementById('acceptCGU_step1');
            const checkStep2 = document.getElementById('acceptCGU_step2');

            const inputName = document.getElementById('payName');
            const inputEmail = document.getElementById('payEmail');
            const inputPhone = document.getElementById('payPhone');

            // Variables OTP
            const otpSection = document.getElementById('otp-section');
            const inputOtp = document.getElementById('otpCodeInput');

            const s3Logo = document.getElementById('step3-logo');
            const s3Title = document.getElementById('step3-title');
            const s3HelpText = document.getElementById('step3-help-text');
            const s3Label = document.getElementById('step3-label-input');
            const btnPay = document.getElementById('btn-final-pay');


            // ==========================================
            // 2. FONCTIONS UTILITAIRES
            // ==========================================

            function validateStep2() {
                let isValid = true;

                // Validation Nom (Toujours obligatoire)
                if (inputName.value.trim() === '') {
                    inputName.classList.add('is-invalid');
                    isValid = false;
                } else {
                    inputName.classList.remove('is-invalid');
                }

                // Validation Email (OPTIONNEL)
                // On ne met en erreur que si le champ n'est PAS vide ET qu'il est mal formé
                if (inputEmail.value.trim() !== '' && !inputEmail.value.includes('@')) {
                    inputEmail.classList.add('is-invalid');
                    isValid = false;
                } else {
                    inputEmail.classList.remove('is-invalid');
                }

                return isValid;
            }


            // ==========================================
            // 3. OUVERTURE ET NAVIGATION
            // ==========================================
            document.querySelectorAll('.js-open-modal').forEach(item => {
                item.addEventListener('click', function() {
                    const parentCard = this.closest('.candidate-card');
                    const candidatId = this.getAttribute('data-candidate-id') || (parentCard ?
                        parentCard.getAttribute('data-id') : null);

                    currentTransaction.campagneId = this.getAttribute('data-campagne-id');
                    currentTransaction.etapeId = this.getAttribute('data-etape-id');

                    currentTransaction.candidatId = candidatId;
                    currentTransaction.votes = this.getAttribute('data-votes');
                    currentTransaction.amount = this.getAttribute('data-amount');

                    document.getElementById('modal-summary-votes').textContent = currentTransaction
                        .votes + ' Votes';
                    document.getElementById('modal-summary-price').textContent = currentTransaction
                        .amount + ' Fcfa';

                    step1.style.display = 'block';
                    step2.style.display = 'none';
                    step3.style.display = 'none';

                    checkStep1.checked = false;
                    checkStep2.checked = true;

                    inputName.value = '';
                    inputEmail.value = '';
                    inputPhone.value = '';
                    inputOtp.value = ''; // Reset OTP
                    inputName.classList.remove('is-invalid');
                    inputEmail.classList.remove('is-invalid');
                    inputPhone.classList.remove('is-invalid');

                    bsModal.show();
                });
            });

            checkStep1.addEventListener('change', function() {
                if (this.checked) {
                    setTimeout(() => {
                        step1.style.display = 'none';
                        step2.style.display = 'block';
                        checkStep2.checked = true;
                    }, 200);
                }
            });

            checkStep2.addEventListener('change', function() {
                if (!this.checked) {
                    step2.style.display = 'none';
                    step1.style.display = 'block';
                    checkStep1.checked = false;
                }
            });


            // ==========================================
            // 4. SÉLECTION DU PAIEMENT (Step 2 -> Step 3)
            // ==========================================
            document.querySelectorAll('.js-select-method').forEach(btn => {
                btn.addEventListener('click', function() {

                    if (!validateStep2()) return;

                    const name = this.getAttribute('data-name');
                    const icon = this.getAttribute('data-icon');
                    const instruction = this.getAttribute('data-instruction');
                    const slug = this.getAttribute('data-slug'); // ex: orange_money, mtn, wave

                    currentTransaction.provider = name;
                    currentTransaction.providerSlug = slug;

                    s3Logo.src = icon;
                    s3Title.textContent = name;
                    s3HelpText.innerHTML = instruction;

                    // GESTION DU CHAMP OTP
                    // Si le slug contient "orange", on affiche le champ OTP
                    if (slug.includes('orange')) {
                        otpSection.style.display = 'block';
                        inputOtp.setAttribute('required', 'required'); // On le rend requis
                        inputPhone.placeholder = "07 07 00 00 00";
                    } else {
                        otpSection.style.display = 'none';
                        inputOtp.removeAttribute('required'); // On enlève le requis
                        inputOtp.value = ''; // On vide le champ au cas où

                        if (slug.includes('wave')) {
                            inputPhone.placeholder = "07 07 00 00 00";
                        } else if (slug.includes('mtn')) {
                            inputPhone.placeholder = "05 05 00 00 00";
                        } else {
                            inputPhone.placeholder = "Numéro de téléphone";
                        }
                    }

                    step2.style.display = 'none';
                    step3.style.display = 'block';
                });
            });

            document.getElementById('btn-back-step2').addEventListener('click', function() {
                step3.style.display = 'none';
                step2.style.display = 'block';
            });


            // ==========================================
            // 5. PAIEMENT FINAL
            // ==========================================
            // ==========================================
            // 5. PAIEMENT FINAL (CORRIGÉ & SÉCURISÉ)
            // ==========================================
            btnPay.addEventListener('click', function() {

                // 1. Validation du téléphone
                const phoneNumber = inputPhone.value.trim();
                if (phoneNumber === '') {
                    inputPhone.classList.add('is-invalid');
                    return;
                } else {
                    inputPhone.classList.remove('is-invalid');
                }

                // 2. Validation OTP si visible
                let otpValue = '0000';
                if (otpSection.style.display !== 'none') {
                    if (inputOtp.value.trim() === '') {
                        inputOtp.classList.add('is-invalid');
                        alert("Veuillez entrer le code OTP / Autorisation.");
                        return;
                    }
                    inputOtp.classList.remove('is-invalid');
                    otpValue = inputOtp.value.trim();
                }

                // --- DÉBUT DU BLOC SÉCURISÉ ---

                // UI : On lance le chargement
                const originalBtnText = btnPay.innerHTML;
                btnPay.disabled = true;
                btnPay.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';

                try {
                    // A. Vérification de sécurité : Montant
                    // On s'assure que amount n'est pas null avant de faire toString()
                    let amountSafe = currentTransaction.amount ? currentTransaction.amount : '0';
                    let rawAmount = amountSafe.toString().replace(/[^0-9]/g, '');

                    // B. Vérification de sécurité : Token CSRF
                    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfMeta) {
                        throw new Error(
                            "ERREUR TECHNIQUE : La balise meta csrf-token est absente du fichier HTML.");
                    }
                    const csrfToken = csrfMeta.getAttribute('content');

                    // C. Construction du Payload
                    const payload = {
                        candidat_id: currentTransaction.candidatId,

                        // Récupération dynamique ou fallback sur 1
                        campagne_id: currentTransaction.campagneId || 1,
                        etate_id: currentTransaction.etapeId || 1,

                        quantity: currentTransaction.votes,
                        otpCode: otpValue,
                        email: inputEmail.value,
                        name: inputName.value,
                        amount: parseInt(rawAmount),
                        phoneNumber: phoneNumber,
                        provider: currentTransaction.providerSlug
                    };

                    // D. Envoi de la requête
                    fetch("{{route('business.paiementVote')}}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(async response => {
                            // Si le serveur renvoie une erreur HTML (500) au lieu de JSON
                            const contentType = response.headers.get("content-type");
                            if (!contentType || !contentType.includes("application/json")) {
                                const text = await response.text();
                                console.error("Erreur HTML Serveur:", text);
                                throw new Error(
                                    "Une erreur technique est survenue. Veuillez réessayer plus tard ou contacter le support si le problème persiste."
                                    );
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Succès de la communication avec le serveur
                            bsModal.hide();

                            if (data.success) {
                                if (data.status === 'pending' || data.status === 'pending_validation') {
                                    Swal.fire({
                                        title: 'Vérifiez votre téléphone',
                                        text: data.message,
                                        icon: 'info',
                                        timer: 15000, // 15 secondes
                                        showConfirmButton: true
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Paiement Réussi !',
                                        text: 'Merci pour votre vote.',
                                        icon: 'success'
                                    }).then(() => {
                                        if (data.redirect_url) window.location.href = data
                                            .redirect_url;
                                        else window.location.reload();
                                    });
                                }
                            } else {
                                // Erreur métier (ex: solde insuffisant)
                                Swal.fire({
                                    title: 'Échec',
                                    text: data.message,
                                    icon: 'error'
                                }).then(() => bsModal.show());
                            }
                        })
                        .catch(error => {
                            // Erreur Réseau ou JSON invalide
                            console.error('Erreur Fetch:', error);
                            bsModal.hide();
                            Swal.fire('Erreur', error.message, 'error');
                        })
                        .finally(() => {
                            // Quoi qu'il arrive, on réactive le bouton
                            btnPay.disabled = false;
                            btnPay.innerHTML = originalBtnText;
                        });

                } catch (e) {
                    // Ce bloc attrape les erreurs synchrones (CSRF manquant, variable null, etc.)
                    // C'est ce qui manquait dans votre code précédent
                    console.error("Crash JS avant envoi:", e);
                    alert("Erreur Script : " + e.message);

                    // On réactive le bouton pour ne pas bloquer l'utilisateur
                    btnPay.disabled = false;
                    btnPay.innerHTML = originalBtnText;
                }
            });

            // UX : Enlever le rouge quand on écrit
            [inputName, inputEmail, inputPhone, inputOtp].forEach(input => {
                if (input) {
                    input.addEventListener('input', function() {
                        if (this.value.trim() !== '') {
                            this.classList.remove('is-invalid');
                        }
                    });
                }
            });

        });
    </script>

</body>

</html>
