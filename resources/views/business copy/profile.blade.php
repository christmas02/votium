@extends('layout.header.business')

@section('content')

<!-- Start Content -->
<div class="content pb-0">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div class="row col-12">
            <div class="col-sm-6">
                <h4 class="mb-0">{{ $title }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ $link_back }}">{{ $title_back }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-6">@include('layout.status')</div>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- start row -->
    <div class="row">

        <!-- Contact Sidebar -->
        <div class="col-xl-3">
            <div class="card mb-3 mb-xl-0">
                <div class="card-body">
                    <div class="settings-sidebar" role="tablist" aria-orientation="vertical">
                        <h5 class="mb-3 fs-17">Paramètres compte</h5>
                        <div class="list-group list-group-flush settings-sidebar">
                            <a href="#tab_1" data-bs-toggle="tab" aria-expanded="false" aria-selected="true" role="tab" class="d-block p-2 fw-medium active"> <i class="ti ti-wallet me-1"></i>Entreprise</a>
                            <a href="#tab_5" data-bs-toggle="tab" aria-expanded="false" aria-selected="false" tabindex="-1" role="tab" class="d-block p-2 fw-medium"><i class="ti ti-wallet me-1"></i>Compte de retrait</a>
                            <a href="#tab_2" data-bs-toggle="tab" aria-expanded="true" aria-selected="false" role="tab" tabindex="-1" class="d-block p-2 fw-medium"><i class="ti ti-user me-1"></i>Profil</a>
                        </div>
                    </div>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div>
        <!-- /Contact Sidebar -->

        <!-- Contact Details -->
        <div class="col-xl-9">

            <!-- Tab Content -->
            <div class="tab-content pt-0">

                <!-- Activities -->
                <div class="tab-pane active show" id="tab_1">
                    <div class="card">
                        <div
                            class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <h5 class="fw-semibold mb-0">Entreprise</h5>
                            <div class="table-search" style="margin-bottom:0 !important;">
                                <div class="search-input">
                                    <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <form class="ajax-form" action="{{ route('business.update_customer') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                                    <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">
                                    <input type="hidden" name="old_logo" value="{{ $customer->logo }}">
                                    <!-- SECTION 2 : INFORMATIONS ENTREPRISE -->
                                    <div>
                                        <h6 class="mb-3 d-flex align-items-center text-dark">
                                            <i class="ti ti-building-skyscraper fs-5 me-2"></i> Informations de l'Entreprise
                                        </h6>

                                        <div class="row">
                                            <!-- Logo Upload avec Prévisualisation -->
                                            <div class="col-md-12 mb-3 image-upload-group">
                                                <div class="d-flex align-items-center bg-light p-2 rounded border {{ $customer->logo ? 'border-primary' : 'border-dashed' }}">

                                                    <!-- Zone de l'image (L'avatar doit rester visible pour afficher soit l'icône, soit l'image) -->
                                                    <div class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">

                                                        <!-- Placeholder : Caché si le logo existe -->
                                                        <i class="ti ti-photo text-muted fs-4 placeholder-target {{ $customer->logo ? 'd-none' : '' }}"></i>

                                                        <!-- Preview : Visible si le logo existe, src configuré avec le chemin env -->
                                                        <img src="{{ $customer->logo ? asset(env('IMAGES_PATH').'/'.$customer->logo) : '#' }}"
                                                            alt="Aperçu"
                                                            class="preview-target {{ $customer->logo ? '' : 'd-none' }} w-100 h-100 object-fit-cover">
                                                    </div>

                                                    <div class="d-flex flex-column">
                                                        <label class="form-label mb-1">Logo de l'entreprise</label>
                                                        <input type="file"
                                                            class="form-control form-control-sm"
                                                            name="logo"
                                                            accept="image/*"
                                                            onchange="handleImagePreview(this)">
                                                        <small class="text-muted">JPG, GIF ou PNG. Max 800K</small>

                                                        <!-- Bouton supprimer : Visible uniquement si un logo existe -->
                                                        <button type="button"
                                                            class="btn btn-sm btn-link text-danger p-0 remove-btn-target text-start {{ $customer->logo ? '' : 'd-none' }}"
                                                            onclick="handleImageRemove(this)">
                                                            Supprimer
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Nom Entreprise -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nom de l'organisation <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="entreprise" value="{{ $customer->entreprise }}" required>
                                            </div>

                                            <!-- Pays -->
                                            <div class="col-md-6 mb-4">
                                                <label class="form-label">Pays siège <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="pays_siege" value="{{ $customer->pays_siege }}" required>

                                            </div>

                                            <!-- NOUVEAU : Email de l'entreprise -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email de l'organisation</label>
                                                <!-- Nommé 'company_email' pour ne pas écraser l'email du User -->
                                                <input type="email" class="form-control" name="email" value="{{$customer->email}}">
                                            </div>

                                            <!-- Téléphone -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control phone" name="phonenumber" value="{{ $customer->phonenumber }}" required>
                                            </div>

                                            <!-- Adresse -->
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Adresse <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="adresse" value="{{ $customer->adresse }}" required>
                                            </div>
                                        </div>

                                        <!-- SECTION : RÉSEAUX SOCIAUX -->
                                        <div class="mt-3">

                                            <div class="row">
                                                <!-- Facebook -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light"><i class="ti ti-brand-facebook"></i></span>
                                                        <input type="url" class="form-control" name="link_facebook" value="{{ $customer->link_facebook }}">
                                                    </div>
                                                </div>

                                                <!-- Instagram -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light"><i class="ti ti-brand-instagram"></i></span>
                                                        <input type="url" class="form-control" name="link_instagram" value="{{ $customer->link_instagram }}">
                                                    </div>
                                                </div>

                                                <!-- LinkedIn -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light"><i class="ti ti-brand-linkedin"></i></span>
                                                        <input type="url" class="form-control" name="link_linkedin" value="{{ $customer->link_linkedin }}">
                                                    </div>
                                                </div>

                                                <!-- Lien youtube / X -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light"><i class="ti ti-brand-youtube"></i></span>
                                                        <input type="url" class="form-control" name="link_youtube" value="{{ $customer->link_youtube }}">
                                                    </div>
                                                </div>

                                                <!-- Lien Tiktok -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light"><i class="ti ti-brand-tiktok"></i></span>
                                                        <input type="url" class="form-control" name="link_tiktok" value="{{ $customer->link_tiktok }}">
                                                    </div>
                                                </div>

                                                <!-- Site Web -->
                                                <div class="col-md-6 mb-3">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light"><i class="ti ti-brand-telegram"></i></span>
                                                        <input type="url" class="form-control" name="link_website" value="{{ $customer->link_website }}">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Footer (Actions) -->
                                <div class="modal-footer border-top mt-4 pb-0 px-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Enregistrer</button>
                                </div>
                            </form>
                        </div><!-- end card body -->
                    </div>
                </div>
                <!-- /Activities -->

                <!-- Email -->
                <div class="tab-pane fade" id="tab_5">
                    <!-- Settings Info -->

                    <div class="card mb-0">
                        <div class="card-body">

                            <div class="border-bottom mb-3 pb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <h4 class="fs-17 mb-0">Compte de retrait</h4>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_bank"><i class="ti ti-square-rounded-plus-filled me-1"></i>Créer Compte</a>
                            </div>

                            <div class="row">

                                <!-- Email Wrap -->
                                <div class="col-md-12">
                                    @foreach($compteRetraits as $compte)
                                    <!-- Payment -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span>
                                                        @foreach($paymentMethods as $method)
                                                        @if($method->value === $compte->payment_methode)
                                                        <img src="{{ asset(env('IMAGES_PAYMENT') . '/' . $method->icon()) }}" alt="{{ $method->label() }}" class="me-2" style="width:50px; height:50px;">
                                                        @endif
                                                        @endforeach

                                                    </span>
                                                    <div class="ms-2">
                                                        <label class="form-label text-uppercase mb-0">
                                                            {{ $compte->account_name }}
                                                        </label>
                                                        <br>
                                                        <label class="form-label mt-0">
                                                            {{ $compte->phone_number }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#php-mail{{ $compte->withdrawal_account_id }}"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_paypal{{ $compte->withdrawal_account_id }}"><i
                                                                class="ti ti-tool me-1"></i>Voir</a>
                                                    </div>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag ms-2 {{ $compte->is_active ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                            {{ $compte->is_active ? 'Connecté' : 'Déconnecté' }}
                                                        </a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input
                                                                class="form-check-input switchCheckDefault ms-auto"
                                                                type="checkbox"
                                                                role="switch"
                                                                data-id="{{ $compte->withdrawal_account_id }}"
                                                                {{ $compte->is_active ? 'checked' : '' }}>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="php-mail{{ $compte->withdrawal_account_id }}">
                                            <div>
                                                <p class="mb-0">« Ce compte de retrait ne peut pas être supprimé. Vous pouvez toutefois le désactiver en cliquant sur le point rouge. »</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment -->
                                    @endforeach

                                </div>
                                <!-- /Email Wrap -->

                            </div>
                        </div>
                    </div>
                    <!-- /Settings Info -->
                </div>
                <!-- /Email -->

                <!-- Notes -->
                <div class="tab-pane fade" id="tab_2">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <div class="mb-0">
                                <h6 class="d-flex align-items-center text-primary">
                                    <i class="ti ti-user-shield fs-5 me-2"></i> Informations Utilisateur (Customer)
                                </h6>
                            </div>

                        </div>
                        <div class="card-body">

                            <form class="ajax-form" action="{{ route('business.update_profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                                <!-- SECTION 1 : INFORMATIONS UTILISATEUR (Compte de connexion) -->
                                <div class="bg-light p-3 rounded mb-4">

                                    <div class="row">
                                        <!-- Mapping: name (Schema users) -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                        </div>

                                        <!-- Mapping: password (Schema users) -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Numéro de téléphone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phonenumber" value="{{ $user->phonenumber }}" required>
                                        </div>

                                        <!-- Mapping: email (Schema users) -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email (Identifiant) <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                        </div>

                                        <!-- Mapping: password (Schema users) -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mot de passe</label>
                                            <input type="password" class="form-control" name="password" placeholder="Laisser vide pour conserver le mot de passe actuel">
                                            <input type="hidden" name="old_password" value="{{ $user->password }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- Bouton Soumettre -->
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
                                </div>
                            </form>

                        </div> <!-- end card body -->
                    </div>
                </div>
                <!-- /Notes -->

            </div>
            <!-- /Tab Content -->

        </div>
        <!-- /Contact Details -->

    </div>
    <!-- end row -->

</div>
<!-- End Content -->

<!-- Paypal -->
@foreach($compteRetraits as $compte)
<div class="modal fade" id="add_paypal{{ $compte->withdrawal_account_id }}" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Voir compte</h5>
                <button type="button"
                    class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="mb-3 ">
                        <label class="form-label">Type de compte <span class="text-danger">*</span></label>
                        <select class="select" name="payment_methode" readonly>
                            <option value="{{ $compte->payment_methode }}">
                                @foreach($paymentMethods as $method)
                                @if($method->value === $compte->payment_methode)
                                {{ $method->label() }}
                                @endif
                                @endforeach
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom du compte <span class="text-danger">*</span></label>
                        <input type="text" name="account_name" value="{{ $compte->account_name }}" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Numéro du compte <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone_number" value="{{ $compte->phone_number }}" readonly>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-end m-0">
                        <a href="#" class="btn btn-sm btn-light me-2" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-sm btn-primary">Enregistrer</button>
                    </div>
                </div> -->
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- /Paypal -->

<!-- Add Bank Account -->
<div class="modal fade" id="add_bank" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un compte retrait</h5>
                <button type="button"
                    class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="ti ti-x"></i>
                </button>
            </div>
            <form class="ajax-form" action="{{ route('business.save_compte_retrait') }}" method="POST">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">

                <div class="modal-body">
                    <div class="mb-3 ">
                        <label class="form-label">Type de compte <span class="text-danger">*</span></label>
                        <select class="select" name="payment_methode" required>
                            <option value="" disabled="disabled">Sélectionner</option>
                            @foreach($paymentMethods as $method)
                            <option value="{{ $method->value }}">
                                {{ $method->label() }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nom du compte <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="account_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Numéro du compte <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone_number">
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center justify-content-end m-0">
                        <a href="#" class="btn btn-sm btn-light me-2" data-bs-dismiss="modal">Annuler</a>
                        <button type="submit" class="btn btn-sm btn-primary">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Bank Account -->

<!-- Script JavaScript pour gérer l'affichage -->
<script>
    $(document).ready(function() {



        // Formulaire AJAX pour activer/désactiver un compte de retrait
        $('.switchCheckDefault').change(function() {
            let checkbox = $(this);
            let accountId = checkbox.data('id');
            let isActive = checkbox.is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('business.delete_compte_retrait') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    account_id: accountId,
                    is_active: isActive
                },
                success: function(response) {
                    showAjaxAlert('success', response.message);
                },
                error: function(xhr) {
                    let errorMessage = "Erreur lors de la mise à jour du compte";

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).flat().join("<br>");
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    showAjaxAlert('danger', errorMessage);
                    checkbox.prop('checked', !isActive); // revert en cas d'erreur
                }
            });
        });
    });
</script>

@endsection
<!-- section js -->
@section('extra-js')

@endsection