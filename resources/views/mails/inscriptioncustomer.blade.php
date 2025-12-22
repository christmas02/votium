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
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
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

                <div class="col-lg-12 vh-100 overflow-y-auto overflow-x-hidden">
                    <div class="row">
                        <div class="col-md-10 mx-auto">
                            <form class="vh-100 d-flex justify-content-between flex-column p-4 pb-0">
                                <div class="text-center mb-4 auth-logo">
                                    <img src="{{ asset('assets/img/logos/votium.png') }}" class="img-fluid" alt="Logo">
                                </div>

                                <div>
                                    <div class="text-center mb-3">
                                        <h4 class="mb-2">Bonjour {{ $name }},</h4>
                                        <p class="mb-3">
                                            Votre compte a été créé avec succès sur notre plateforme.<br>
                                        </p>
                                        <p class="mb-3">
                                            Pour votre sécurité, nous vous invitons à mettre à jour votre mot de passe dès votre première connexion.
                                        </p>
                                        <p class="mb-3">
                                            <a href="{{ route('editpassword_customer', ['email' => $email]) }}" class="btn btn-primary">mettre à jour le mot de passe</a>
                                        </p>
                                        <hr>
                                        <div class="alert alert-info" role="alert">
                                            <strong>Note :</strong> Si vous n'êtes pas à l'origine de cette inscription, veuillez ignorer cet e-mail.
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

            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

</body>

</html>