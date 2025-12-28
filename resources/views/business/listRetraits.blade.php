@extends('layout.header.business')

@section('content')

<!-- Start Content -->
<div class="content pb-0">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
        <div class="row col-12">
            <div class="col-sm-6">
                <!-- Titre et Breadcrumb -->
                <h4 class="mb-0">{{ $title }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ $link_back }}">{{ $title_back }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <!-- Bouton Retirer de l'argent aligné à droite -->
            <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                <button type="button" class="btn text-white" style="background-color: #ff6633; border-color: #ff6633;" data-bs-toggle="modal" data-bs-target="#modalRetrait">
                    <i class="ti ti-plus me-1"></i> Retirer de l'argent
                </button>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Note: La barre de recherche "table header" du code original a été retirée 
         car elle n'apparait pas sous cette forme dans vos captures d'écran. -->

    <!-- Contact Grid -->
    <div class="row">
        <!-- Colonne Gauche : Filtres et Soldes -->
        <div class="col-xl-3">
            <div class="card card-body mb-4">
                <h6 class="fw-bold">Filtrer</h6>

                <form action="">
                    <div class="col-md-12 mb-3">
                        <label class="form-label text-muted small">Choisir la destination</label>
                        <select class="form-control form-select" name="destination">
                            <option value="">Choisir la destination</option>
                            <option value="mara">Mara</option>
                            <option value="orange">Orange Money</option>
                            <option value="mtn">MTN Money</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label text-muted small">À partir du</label>
                        <div class="input-icon position-relative">
                            <input type="date" class="form-control" name="date_debut" placeholder="jj/mm/aaaa">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label text-muted small">Jusqu'au</label>
                        <div class="input-icon position-relative">
                            <input type="date" class="form-control" name="date_fin" placeholder="jj/mm/aaaa">
                        </div>
                    </div>
                </form>

                <!-- Bloc Solde Disponible Immédiatement (Vert clair) -->
                <div class="mt-2 p-3 rounded mb-2" style="background-color: #e6fffa; border: 1px solid #b2f5ea;">
                    <div class="text-muted small mb-1">Solde disponible immediatement</div>
                    <h4 class="mb-0 fw-bold">0 Fcfa</h4>
                </div>

                <!-- Bloc Solde Disponible sur demande (Blanc borduré) -->
                <div class="p-3 rounded mb-2 border">
                    <div class="text-muted small mb-1">Solde disponible sur demande</div>
                    <h4 class="mb-0 fw-bold">170 Fcfa</h4>
                </div>

                <!-- Bloc Solde Total (Foncé) -->
                <div class="p-3 rounded mb-3 text-white" style="background-color: #2d3748;">
                    <div class="small mb-1" style="opacity: 0.8;">Solde total</div>
                    <h4 class="mb-0 fw-bold">170 <span class="fs-6 fw-normal">Fcfa</span></h4>
                </div>

                <div class="mt-2 text-muted small">
                    Il vous reste <strong class="text-danger">10</strong> retrait(s) possible(s) aujourd'hui.
                </div>
            </div>
        </div>

        <!-- Colonne Droite : Tableau -->
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>DESTINATION</th>
                                    <th>MONTANT</th>
                                    <th>INITIE LE</th>
                                    <th>TRAITÉ LE</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Item 1 -->
                                <tr>
                                    <td class="fw-bold">Mara</td>
                                    <td>850</td>
                                    <td>11/09/2025</td>
                                    <td class="text-muted">2025-09-11 11:35:30</td>
                                    <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Confirmé</span></td>
                                </tr>
                                <!-- Item 2 -->
                                <tr>
                                    <td class="fw-bold">MARA MOMO</td>
                                    <td>307020</td>
                                    <td>04/05/2025</td>
                                    <td class="text-muted">2025-05-04 23:37:20</td>
                                    <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Confirmé</span></td>
                                </tr>
                                <!-- Item 3 -->
                                <tr>
                                    <td class="fw-bold">MARA MOMO</td>
                                    <td>553350</td>
                                    <td>04/05/2025</td>
                                    <td class="text-muted">2025-05-04 17:20:47</td>
                                    <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Confirmé</span></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>

    </div>
    <!-- /Contact Grid -->

</div>
<!-- End Content -->

<!-- Modal: Effectuer un retrait -->
<div class="modal fade" id="modalRetrait" tabindex="-1" aria-labelledby="modalRetraitLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalRetraitLabel">Effectuer un retrait</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
                    <!-- Info Box -->
                    <div class="alert mb-3" style="background-color: #e6fffa; color: #2c7a7b; border: 0;">
                        <small class="d-block text-muted">Montant maximum de retrait</small>
                        <span class="fw-bold fs-5 text-dark">0 <span class="fs-6">Fcfa</span></span>
                    </div>

                    <p class="small text-muted mb-3">Il vous reste <strong class="text-danger">10</strong> retrait(s) possible(s) aujourd'hui.</p>

                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant du retrait</label>
                        <!-- Exemple avec valeur et message d'erreur comme sur la capture -->
                        <input type="number" class="form-control bg-light border-danger text-danger" id="montant" value="200000" placeholder="Entrez le montant">
                        <div class="text-danger small mt-1">Solde insuffisant.</div>
                    </div>

                    <div class="mb-4">
                        <label for="destinationRetrait" class="form-label">Le compte de destination</label>
                        <select class="form-select" id="destinationRetrait">
                            <option selected>Choisir la destination</option>
                            <option value="1">Mobile Money</option>
                            <option value="2">Virement Bancaire</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn text-white w-50" style="background-color: #ff6633;">Valider</button>
                        <button type="button" class="btn btn-light w-50 border" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- section js -->
@section('extra-js')
<script>
    // Initialisation optionnelle des tooltips ou autre logique JS
</script>
@endsection