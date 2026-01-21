@extends('layout.header.console')

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

                            <div>

                                <div class="row">
                                    <!-- Logo Upload avec Prévisualisation -->
                                    <div class="col-md-12 mb-3">
                                        <div class="d-flex align-items-center bg-light p-2 rounded">
                                            <!-- Zone de l'image -->
                                            <div class="avatar avatar-xl border border-dashed me-3 flex-shrink-0 d-flex justify-content-center align-items-center bg-light position-relative overflow-hidden">
                                                <!-- Image de prévisualisation -->
                                                <img src="{{ env('IMAGES_PATH') }}/{{ $customer->logo }}" alt="Aperçu" class="w-100 h-100 object-fit-cover">
                                            </div>


                                        </div>
                                    </div>

                                    <!-- Nom Entreprise -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nom de l'organisation <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="entreprise" value="{{ $customer->entreprise }}" readonly>
                                    </div>

                                    <!-- Pays -->
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Pays siège <span class="text-danger">*</span></label>
                                        <select class="select form-control form-select" name="pays_siege" required readonly>
                                            <option value="{{ $customer->pays_siege }}">{{ $customer->pays_siege }}</option>
                                        </select>
                                    </div>

                                    <!-- NOUVEAU : Email de l'entreprise -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email de l'organisation</label>
                                        <input type="email" class="form-control" name="email" value="{{ $customer->email }}" readonly>
                                    </div>

                                    <!-- Téléphone -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control phone" name="phonenumber" value="{{ $customer->phonenumber }}" required readonly>
                                    </div>

                                    <!-- Adresse -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Adresse <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="adresse" value="{{ $customer->adresse }}" required readonly>
                                    </div>


                                </div>

                                <!-- SECTION : RÉSEAUX SOCIAUX -->
                                <div class="mt-3">

                                    <div class="row">
                                        <!-- Facebook -->
                                        <div class="col-md-6 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i class="ti ti-brand-facebook"></i></span>
                                                <input type="url" class="form-control" name="link_facebook" value="{{ $customer->link_facebook }}" readonly>
                                            </div>
                                        </div>

                                        <!-- Instagram -->
                                        <div class="col-md-6 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i class="ti ti-brand-instagram"></i></span>
                                                <input type="url" class="form-control" name="link_instagram" value="{{ $customer->link_instagram }}" readonly>
                                            </div>
                                        </div>

                                        <!-- LinkedIn -->
                                        <div class="col-md-6 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i class="ti ti-brand-linkedin"></i></span>
                                                <input type="url" class="form-control" name="link_linkedin" value="{{ $customer->link_linkedin }}" readonly>
                                            </div>
                                        </div>
                                        <!-- Lien youtube / X -->
                                        <div class="col-md-6 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i class="ti ti-brand-youtube"></i></span>
                                                <input type="url" class="form-control" name="link_youtube" value="{{ $customer->link_youtube }}" readonly>
                                            </div>
                                        </div>

                                        <!-- Lien Tiktok -->
                                        <div class="col-md-6 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i class="ti ti-brand-tiktok"></i></span>
                                                <input type="url" class="form-control" name="link_tiktok" value="{{ $customer->link_tiktok }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><i class="ti ti-brand-telegram"></i></span>
                                                <input type="url" class="form-control" value="{{ $customer->link_website }}" name="link_website" readonly>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div>
                <!-- /Activities -->

                <!-- Email -->
                <div class="tab-pane fade" id="tab_5">
                    <!-- Settings Info -->

                    <div class="card mb-0">
                        <div class="card-body">

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
                                                        <img src="{{ asset(env('IMAGES_PATH') . '/' . $method->icon()) }}" alt="{{ $method->label() }}" class="me-2" style="width:50px; height:50px;">
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

                            <form action="#" method="POST" enctype="multipart/form-data">
                                <!-- @csrf -->

                                <!-- SECTION 1 : INFORMATIONS UTILISATEUR (Compte de connexion) -->
                                <div class="bg-light p-3 rounded mb-4">

                                    <div class="row">
                                        <!-- Mapping: name (Schema users) -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required readonly>
                                        </div>

                                        <!-- Mapping: password (Schema users) -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Numéro de téléphone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phonenumber" value="{{ $user->phonenumber }}" required readonly>
                                        </div>

                                        <!-- Mapping: email (Schema users) -->
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Email (Identifiant) <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email_customer" value="{{ $user->email }}" readonly required>
                                        </div>
                                    </div>
                                </div>


                                <!-- ... -->
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


<!-- delete modal -->
<div class="modal fade" id="delete_contact" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm rounded-0">
        <div class="modal-content rounded-0">
            <div class="modal-body p-4 text-center position-relative">
                <div class="mb-3 position-relative z-1">
                    <span class="avatar avatar-xl badge-soft-danger border-0 text-danger rounded-circle"><i class="ti ti-trash fs-24"></i></span>
                </div>
                <h5 class="mb-1">Confirmer la suppression</h5>
                <p class="mb-3">Êtes-vous sûr de vouloir supprimer l'entreprise sélectionnée ?</p>
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-light position-relative z-1 me-2 w-100" data-bs-dismiss="modal">Annuler</a>
                    <a href="#" class="btn btn-primary position-relative z-1 w-100" data-bs-dismiss="modal">Oui, supprimer</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- delete modal -->


<script>
   
</script>
@endsection
<!-- section js -->
@section('extra-js')

@endsection