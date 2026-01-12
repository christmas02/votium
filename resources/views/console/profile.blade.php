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
                            <a href="#tab_2" data-bs-toggle="tab" aria-expanded="true" aria-selected="true" role="tab" tabindex="-1" class="d-block p-2 fw-medium active"><i class="ti ti-user me-1"></i>Profil</a>
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

                <!-- Notes -->
                <div class="tab-pane active show" id="tab_2">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                            <div class="mb-0">
                                <h6 class="d-flex align-items-center text-primary">
                                    <i class="ti ti-user-shield fs-5 me-2"></i> Informations Utilisateur (Customer)
                                </h6>
                            </div>

                        </div>
                        <div class="card-body">

                            <form class="ajax-form" action="{{ route('console.update_profile') }}" method="POST" enctype="multipart/form-data">
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

@endsection
<!-- section js -->
@section('extra-js')

@endsection