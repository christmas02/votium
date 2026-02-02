<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> -- -- </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <!-- Apple Icon -->
    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-icon.png') }}">
    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/theme-script.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/simplebar/simplebar.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/css/dataTables.bootstrap5.min.css') }}">
    <!-- Daterangepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="app-style">

</head>

<body>

    <!-- Begin Wrapper -->
    <div class="main-wrapper">

        <!-- Topbar Start -->
        <header class="navbar-header">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2">

                    <!-- Logo -->
                    <a href="index.html" class="logo">
                        <!-- Logo Normal -->
                        <span class="logo-light">
                            <span class="logo-lg"><img src="{{ asset('assets/img/logo.svg') }}" alt="logo"></span>
                            <span class="logo-sm"><img src="{{ asset('assets/img/logo-small.svg') }}" alt="small logo"></span>
                        </span>
                        <!-- Logo Dark -->
                        <span class="logo-dark">
                            <span class="logo-lg"><img src="{{ asset('assets/img/logo-white.svg') }}" alt="dark logo"></span>
                        </span>
                    </a>

                    <!-- Sidebar Mobile Button -->
                    <a id="mobile_btn" class="mobile-btn" href="#sidebar">
                        <i class="ti ti-menu-deep fs-24"></i>
                    </a>

                    <button class="sidenav-toggle-btn btn border-0 p-0" id="toggle_btn2">
                        <i class="ti ti-arrow-bar-to-right"></i>
                    </button>

                </div>

                <div class="d-flex align-items-center">
                    <div class="header-line"></div>
                    <!-- Notification Dropdown -->
                    <div class="header-item">
                        <div class="dropdown me-2">

                            <!-- <button class="topbar-link btn topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" data-bs-offset="0,24" type="button" aria-haspopup="false" aria-expanded="false">
                                <i class="ti ti-bell-check fs-16 animate-ring"></i>
                                <span class="badge rounded-pill">10</span>
                            </button> -->

                            <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg" style="min-height: 300px;">

                                <div class="p-2 border-bottom">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold"> Notifications</h6>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notification Body -->
                                <div class="notification-body position-relative z-2 rounded-0" data-simplebar>

                                    <!-- Item-->
                                    <div class="dropdown-item notification-item py-3 text-wrap border-bottom" id="notification-2">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="mb-0 fw-medium text-dark">Thomas William</p>
                                                <p class="mb-1 text-wrap">
                                                    “Oh, I finished de-bugging the phones, but the system's compiling for eighteen minutes, or twenty...”
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fs-12"><i class="ti ti-clock me-1"></i>8 min ago</span>
                                                    <div class="notification-action d-flex align-items-center float-end gap-2">
                                                        <a href="javascript:void(0);" class="notification-read rounded-circle bg-danger" data-bs-toggle="tooltip" title="" data-bs-original-title="Make as Read" aria-label="Make as Read"></a>
                                                        <button class="btn rounded-circle p-0" data-dismissible="#notification-2">
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- View All-->
                                <div class="p-2 rounded-bottom border-top text-center">
                                    <a href="" class="text-center text-decoration-underline fs-14 mb-0">
                                        Voir les notifications
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                   <!-- User Dropdown -->
                    <div class="dropdown profile-dropdown d-flex align-items-center justify-content-center">
                        <a href="javascript:void(0);" class="topbar-link dropdown-toggle drop-arrow-none position-relative" data-bs-toggle="dropdown" data-bs-offset="0,22" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset(env('IMAGES_PATH') . '/' . (Auth::user()->customer->logo ?? 'default-logo.png')) }}" width="38" class="rounded-1 d-flex" alt="user-image">
                            <span class="online text-success"><i class="ti ti-circle-filled d-flex bg-white rounded-circle border border-1 border-white"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">

                            <div class="d-flex align-items-center bg-light rounded-3 p-2 mb-2">
                                <img src="{{ asset(env('IMAGES_PATH') . '/' . (Auth::user()->customer->logo ?? 'default-logo.png')) }}" class="rounded-circle" width="42" height="42" alt="Img">
                                <div class="ms-2">
                                    <p class="fw-medium text-dark mb-0">{{ Auth::user()->name }}</p>
                                    <span class="d-block fs-13">{{ Auth::user()->role }}</span>
                                </div>
                            </div>

                            <!-- Item-->
                            <a href="{{ route('business.profile') }}" class="dropdown-item">
                                <i class="ti ti-user-circle me-1 align-middle"></i>
                                <span class="align-middle">Profile</span>
                            </a>

                            <!-- item -->
                            <!-- <div class="form-check form-switch form-check-reverse d-flex align-items-center justify-content-between dropdown-item mb-0">
                                <label class="form-check-label" for="notify"><i class="ti ti-bell"></i>Notifications</label>
                                <input class="form-check-input me-0" type="checkbox" role="switch" id="notify">
                            </div> -->

                            <!-- Item-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item">
                                <i class="ti ti-help-circle me-1 align-middle"></i>
                                <span class="align-middle">Help & Support</span>
                            </a> -->

                            <!-- Item-->
                            <!-- <a href="profile-settings.html" class="dropdown-item">
                                <i class="ti ti-settings me-1 align-middle"></i>
                                <span class="align-middle">Settings</span>
                            </a> -->

                            <!-- Item-->
                            <div class="pt-2 mt-2 border-top">
                                <a href="{{ route('logout') }}" class="dropdown-item text-danger">
                                    <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                                    <span class="align-middle">Se déconnecter</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- Topbar End -->



        <!-- Sidenav Menu Start -->
        @include('layout.sidebar.console');
        <!-- Sidenav Menu End -->

        <!-- ========================
        Start Page Content
    ========================= -->

        <div class="page-wrapper">

            <!-- Start Content -->
            @yield('content')
            <!-- End Content -->

            <!-- Start Footer -->
            @include('layout.footer.console')
            <!-- End Footer -->

        </div>

        <!-- ========================
        End Page Content
    ========================= -->

    </div>
    <!-- End Wrapper -->


    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('assets/plugins/simplebar/simplebar.min.js') }}"></script>

    <!-- Datatable JS -->
    <script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/js/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Daterangepicker JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- Profile Upload JS -->
    <script src="{{ asset('assets/js/profile-upload.js') }}" type="d22fd2b98b9057776904f99d-text/javascript"></script>

    <!-- Apexchart JS -->
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

    <!-- Custom Json Js -->
    <script src="{{ asset('assets/json/deals-project.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        // Gestion du chargement des formulaires avec jQuery
        $(document).on('submit', 'form', function() {
            // 1. On récupère le bouton de soumission
            var $form = $(this);
            var $btn = $form.find('button[type="submit"]');

            // 2. Vérification optionnelle : si le formulaire est invalide (HTML5), on ne bloque pas
            if (this.checkValidity()) {
                // 3. On désactive le bouton
                $btn.prop('disabled', true);

                // 4. Optionnel : on ajoute un petit indicateur de chargement
                var loadingText = '<i class="fa fa-spinner fa-spin"></i> Patientez...';
                if ($btn.html() !== loadingText) {
                    $btn.data('original-text', $btn.html()); // Sauvegarde du texte original
                    $btn.html(loadingText);
                }
            }
        });


        $(document).ready(function() {
            /**
             * Gestionnaire global pour tous les formulaires AJAX
             * Cible tous les formulaires ayant la classe .ajax-form
             */
            $(document).on('submit', '.ajax-form', function(e) {
                e.preventDefault();

                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');
                const formData = new FormData(this); // Gère Text + Fichiers (Logo)
                const originalBtnHtml = $submitBtn.html();

                // 1. Reset visuel : On efface les erreurs précédentes
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();

                // Désactiver le bouton et mettre un spinner
                $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Traitement...');

                $.ajax({
                    url: $form.attr('action'),
                    method: $form.attr('method'), // POST (Laravel gère le @method('PUT') via FormData)
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json' // FORCE Laravel à répondre en JSON et à respecter le FormRequest
                    },
                    success: function(response) {
                        // Utilisation de ton système d'alerte existant
                        if (typeof showAjaxAlert === 'function') {
                            showAjaxAlert('success', response.message || 'Action réussie !');
                        }

                        // Si le formulaire est dans une modale, on la ferme après un court délai
                        const $modal = $form.closest('.modal');
                        if ($modal.length) {
                            setTimeout(() => {
                                $modal.modal('hide');
                            }, 1000);
                        }

                        // Redirection ou Refresh selon le besoin (défini dans la réponse JSON ou par défaut)
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        $submitBtn.prop('disabled', false).html(originalBtnHtml);

                        if (xhr.status === 422) { // Erreur de validation Laravel
                            const errors = xhr.responseJSON.errors;

                            if (typeof showAjaxAlert === 'function') {
                                showAjaxAlert('danger', "Veuillez vérifier les champs du formulaire.");
                            }

                            // BOUCLE SCALABLE : Parcourt toutes les erreurs renvoyées par Laravel
                            $.each(errors, function(fieldName, messages) {
                                // On gère les noms de champs complexes (ex: 'logo.image' ou 'tags[]')
                                let $input = $form.find(`[name="${fieldName}"], [name="${fieldName}[]"]`).first();

                                if ($input.length > 0) {
                                    $input.addClass('is-invalid');
                                    let errorMsg = `<div class="invalid-feedback d-block">${messages[0]}</div>`;

                                    // Placement intelligent de l'erreur
                                    if ($input.closest('.input-group').length) {
                                        // Si c'est un input group (réseaux sociaux), on met l'erreur après le groupe
                                        $input.closest('.input-group').after(errorMsg);
                                    } else if ($input.attr('type') === 'file' && $input.closest('.image-upload-group').length) {
                                        // Cas spécifique de ton upload de logo
                                        $input.closest('.image-upload-group').after(errorMsg);
                                    } else {
                                        // Cas standard
                                        $input.after(errorMsg);
                                    }
                                }
                            });

                            // Focus sur le premier champ en erreur
                            $form.find('.is-invalid').first().focus();

                        } else {
                            // Autre erreur (500, 403, etc.)
                            const errorTxt = xhr.responseJSON?.message || "Une erreur est survenue.";
                            if (typeof showAjaxAlert === 'function') {
                                showAjaxAlert('danger', errorTxt);
                            }
                        }
                    }
                });
            });
        });
    </script>

</body>


</html>