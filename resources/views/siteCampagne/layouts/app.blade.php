<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Campagne | @yield('title', 'Votium')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Votez pour le meilleur dessin')">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- VOTRE FICHIER CSS PERSO -->
    <link href="{{ asset('assets/css/style-campagne.css') }}" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Zone pour injecter le CSS spécifique à la page index -->
    @stack('styles')
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

    <!-- Contenu Principal -->
    <div class="main-wrapper">
        @yield('content')
    </div>

    <!-- Footer -->
    <div class="text-center pb-4 pt-4 text-muted small">
        With <i class="fa-regular fa-heart"></i> by VOTIUM
    </div>

    <!-- Scripts Globaux -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Zone pour injecter le JS spécifique -->
    @stack('scripts')
</body>

</html>
