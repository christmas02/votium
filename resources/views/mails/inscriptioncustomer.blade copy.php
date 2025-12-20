<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Email de vérification | VOTIUM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestion de votre compte VOTIUM.">
    <meta name="author" content="Dreams Technologies">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="app-style">
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="overflow-hidden p-3 acc-vh">
            <div class="row vh-100 w-100 g-0">

                <div class="col-lg-6 vh-100 overflow-y-auto overflow-x-hidden">
                    <div class="row">
                        <div class="col-md-10 mx-auto">
                            <form class="vh-100 d-flex justify-content-between flex-column p-4 pb-0">
                                <div class="text-center mb-4 auth-logo">
                                    <img src="{{ asset('assets/img/logos/votium.png') }}" class="img-fluid" alt="Logo">
                                </div>

                                <div>
                                    <div class="text-center mb-3">
                                        <span class="avatar avatar-xl rounded-circle bg-success mb-4">
                                            <i class="ti ti-check fs-26"></i>
                                        </span>
                                        <h4 class="mb-2">Vérifiez votre e-mail</h4>
                                        <p class="mb-3">
                                            Nous avons envoyé un lien à votre adresse e-mail : 
                                            <strong>{{ $user->email }}</strong>.<br>
                                            Veuillez cliquer sur le lien pour continuer.
                                        </p>
                                        <p class="mb-3">
                                            Si vous n'avez pas reçu d'e-mail, cliquez sur le lien ci-dessous pour le renvoyer :
                                        </p>
                                        <p class="mb-3">
                                            <a href="{{ route('verification.resend') }}" class="link-indigo fw-bold link-hover">Renvoyer le lien</a>
                                        </p>
                                        <hr>
                                        <p class="mb-2">Vous souhaitez réinitialiser votre mot de passe ?</p>
                                        <a href="{{ route('password.reset', ['token' => $token]) }}" 
                                           class="btn btn-warning w-100 mb-3">
                                           Réinitialiser le mot de passe
                                        </a>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Ignorer pour l'instant</button>
                                    </div>
                                </div>

                                <div class="text-center pb-4">
                                    <p class="text-dark mb-0">
                                        Copyright &copy; {{ date('Y') }} - VOTIUM. Tous droits réservés.
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 account-bg-05"></div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

</body>
</html>
