<!DOCTYPE html>
<html lang="en">


<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Réinitialiser le mot de passe | VOTIUM </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Streamline your business with our advanced CRM template. Easily integrate and customize to manage sales, support, and customer interactions efficiently. Perfect for any business size">
    <meta name="keywords" content="Advanced CRM template, customer relationship management, business CRM, sales optimization, customer support software, CRM integration, customizable CRM, business tools, enterprise CRM solutions">
    <meta name="author" content="Dreams Technologies">
    <meta name="robots" content="index, follow">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Apple Icon -->
    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-icon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body class="account-page">

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <div class="overflow-hidden p-3 acc-vh">

            <!-- start row -->
            <div class="row vh-100 w-100 g-0">

                <div class="col-lg-6 vh-100  overflow-y-auto overflow-x-hidden">

                    <!-- start row -->
                    <div class="row">

                        <div class="col-md-10 mx-auto">
                            <form id="registrationForm" action="{{ route('updatepassword_customer') }}" class=" vh-100 d-flex justify-content-between flex-column p-4 pb-0" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <div class="text-center mb-4 auth-logo">
                                    <img src="{{ asset('assets/img/logos/votium.png') }}" class="img-fluid" alt="Logo">
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <h3 class="mb-2">Réinitialiser le mot de passe ?</h3>
                                        <p class="mb-0">Entrez le nouveau mot de passe et confirmez-le pour accéder</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mot de passe</label>
                                        <div class="input-group input-group-flat pass-group">
                                            <input type="password" class="form-control pass-input" name="password" id="password">
                                            <span class="input-group-text toggle-password ">
                                                <i class="ti ti-eye-off"></i>
                                            </span>
                                        </div>
                                        <!-- Liste des critères -->
                                        <div id="password-constraints" class="mt-2" style="font-size: 0.8rem;">
                                            <div id="length" class="text-danger">✖ Au moins 8 caractères</div>
                                            <div id="uppercase" class="text-danger">✖ Au moins une majuscule</div>
                                            <div id="number" class="text-danger">✖ Au moins un chiffre</div>
                                            <div id="special" class="text-danger">✖ Au moins un caractère spécial (@$!%*?&)</div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirme Mot de passe</label>
                                        <div class="input-group input-group-flat pass-group">
                                            <input type="password" class="form-control pass-input" name="confirm_password" id="confirm_password">
                                            <span class="input-group-text toggle-password ">
                                                <i class="ti ti-eye-off"></i>
                                            </span>
                                        </div>
                                        <!-- Message d'erreur -->
                                        <div id="passwordError" style="color: red; font-size: 0.85rem; display: none; margin-top: 5px;">
                                            Les mots de passe ne correspondent pas.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Changer le mot de passe</button>
                                    </div>
                                    <div class="mb-3 text-center">
                                        <p class="mb-0">Retour à <a href="login.html" class="link-indigo fw-bold link-hover">Connexion</a></p>
                                    </div>
                                </div>
                                <div class="text-center pb-4">
                                    <p class="text-dark mb-0">Copyright &copy; <script type="dee056adfee14e8e8dd10e63-text/javascript">
                                            document.write(new Date().getFullYear())
                                        </script> - VOTIUM</p>
                                </div>
                            </form>

                        </div> <!-- end col -->

                    </div>
                    <!-- end row -->

                </div>

                <div class="col-lg-6 account-bg-04"></div> <!-- end col -->

                <!-- end row -->

            </div>
            <!-- end row -->

        </div>

    </div>
    <!-- End Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script src="https://crms.dreamstechnologies.com/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="dee056adfee14e8e8dd10e63-|49" defer></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"3ca157e612a14eccbb30cf6db6691c29","server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
    <script>
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirm_password');
        const form = document.getElementById('registrationForm');

        // Éléments de la liste des contraintes
        const constraints = {
            length: {
                regex: /.{8,}/,
                el: document.getElementById('length')
            },
            uppercase: {
                regex: /[A-Z]/,
                el: document.getElementById('uppercase')
            },
            number: {
                regex: /[0-9]/,
                el: document.getElementById('number')
            },
            special: {
                regex: /[@$!%*?&]/,
                el: document.getElementById('special')
            }
        };

        // 1. Vérification en temps réel de la force du mot de passe
        passwordInput.addEventListener('input', function() {
            const val = passwordInput.value;

            for (const key in constraints) {
                if (constraints[key].regex.test(val)) {
                    constraints[key].el.classList.replace('text-danger', 'text-success');
                    constraints[key].el.innerText = constraints[key].el.innerText.replace('✖', '✔');
                } else {
                    constraints[key].el.classList.replace('text-success', 'text-danger');
                    constraints[key].el.innerText = constraints[key].el.innerText.replace('✔', '✖');
                }
            }
        });

        // 2. Vérification à la soumission
        form.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = confirmInput.value;
            const errorDiv = document.getElementById('passwordError');

            // Vérifier si tous les critères de complexité sont OK
            const isComplex = Object.values(constraints).every(c => c.regex.test(password));

            // Vérifier si identique
            const isMatch = password === confirmPassword;

            if (!isComplex) {
                e.preventDefault();
                alert("Le mot de passe ne respecte pas les critères de sécurité.");
                return;
            }

            if (!isMatch) {
                e.preventDefault();
                errorDiv.style.display = 'block';
                confirmInput.classList.add('is-invalid');
            } else {
                errorDiv.style.display = 'none';
                confirmInput.classList.remove('is-invalid');
            }
        });
    </script>
</body>

</html>