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


    <div class="row">
        <!-- Colonne Gauche : Choisir la session -->
        <div class="col-xl-3">
            <div class="card border shadow-none">
                <div class="card-body">
                    <label class="form-label text-muted fs-12">Choisir la session</label>
                    <select class="form-select mb-4">
                        <option selected>Zenitsu concours</option>
                    </select>

                    <p class="text-muted small mb-0">Session</p>
                    <h3 class="fw-bold" style="color: #f3613c;">Zenitsu concours</h3>
                </div>
            </div>
        </div>

        <!-- Colonne Droite : Liste des étapes -->
        <div class="col-xl-9">
            <div class="card border shadow-none">
                <div class="card-header d-flex align-items-center justify-content-between bg-transparent border-0">
                    <div class="search-input">
                        <input type="text" class="form-control" placeholder="Rechercher ...">
                    </div>
                    <button class="btn btn-primary d-flex align-items-center" style="background-color: #f3613c; border:none;" data-bs-toggle="modal" data-bs-target="#modal_add_step_">
                        <i class="ti ti-circle-plus me-1"></i> Créer
                    </button>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr class="text-muted fs-11 text-uppercase">
                                    <th>Nom de l'étape</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Prix du vote</th>
                                    <th>Nbre de votes</th>
                                    <th>Etat</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($etapes as $etape)
                                <tr>
                                    <td class="fw-bold">{{ $etape->name }}</td>
                                    <td>{{ $etape->date_debut }}</td>
                                    <td>{{ $etape->date_fin }}</td>
                                    <td>{{ $etape->prix_vote }}</td>
                                    <td>0 votes</td>
                                    <td><span class="text-muted">No</span></td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-2">
                                            <button class="btn btn-sm btn-light border"><i class="ti ti-edit fs-16"></i></button>
                                            <button class="btn btn-sm btn-danger"><i class="ti ti-trash fs-16"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- End Content -->

<!-- Modal Nouvelle Étape -->

<div class="modal fade" id="modal_add_step_" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h4 class="modal-title fw-bold" style="color: #2d3748;">Nouvelle étape</h4>
                <button type="button" class="btn-close bg-light rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('business.save_etape') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="campagne_id" value="">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom de l'étape</label>
                        <input type="text" class="form-control bg-light border-0" name="name" placeholder="Attribuez un nom à cette étape.">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Date de début</label>
                            <input type="date" class="form-control bg-light border-0" name="date_debut">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Heure de début</label>
                            <input type="time" class="form-control bg-light border-0" name="heure_debut">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Date de fin</label>
                            <input type="date" class="form-control bg-light border-0" name="date_fin">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Heure de fin</label>
                            <input type="time" class="form-control bg-light border-0" name="heure_fin">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Décrivez l'étape</label>
                        <textarea class="form-control bg-light border-0" rows="4" name="description" placeholder="Décrivez l'étape ..."></textarea>
                    </div>

                    <!-- <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Type d'éligibilité</label>
                            <select class="form-select bg-light border-0" name="type_eligibility">
                                <option>Choisir</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Seuil de sélection</label>
                            <input type="number" class="form-control bg-light border-0" name="seuil_selection" placeholder="Ex: 1000">
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <div class="col-md-12 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="reinitialisation" name="reinitialisation" value="1">
                                <label class="form-check-label" for="reinitialisation">Réinitialisation</label>
                            </div>
                        </div>
                    </div> -->

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Prix d'un vote</label>
                        <input type="text" class="form-control bg-light border-0" name="prix_vote" placeholder="Ex: 500">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Packages de vote</label>

                        <div class="packages-wrapper">
                            <div class="packages-container" data-index="1" id="packages_container">

                                <!-- Package par défaut -->
                                <div class="row g-2 align-items-end package-item mb-2">
                                    <div class="col-5">
                                        <input type="number" name="packages[0][votes]" class="form-control bg-light border-0" placeholder="Nombre de votes" required>
                                    </div>

                                    <div class="col-5">
                                        <input type="number" name="packages[0][montant]" class="form-control bg-light border-0" placeholder="Prix (FCFA)" readonly required>
                                    </div>

                                    <div class="col-2 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-package d-none">✕</button>
                                    </div>
                                </div>

                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm mt-2 add-package" id="addPackage">
                                + Ajouter un package
                            </button>
                        </div>
                    </div>


                    <!-- Le bouton de validation n'est pas visible sur votre capture, mais voici le style habituel -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background-color: #f3613c; border:none;">Enregistrer l'étape</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script JavaScript pour gérer l'affichage -->
<script>
    document.addEventListener('change', function(e) {

        // Vérifie si l'élément déclencheur est un toggle inscription
        if (!e.target.classList.contains('inscriptionSwitch')) return;

        // On travaille dans la modale courante
        const modalBody = e.target.closest('.modal-body');
        if (!modalBody) return;

        const blocDates = modalBody.querySelector('.blocDates');

        if (!blocDates) return;

        blocDates.classList.toggle('d-none', !e.target.checked);

    });

    // Fonction pour gérer le package des votes
    document.addEventListener('click', function(e) {

        // Ajouter un package
        if (e.target.classList.contains('add-package')) {

            const wrapper = e.target.closest('.packages-wrapper');
            const container = wrapper.querySelector('.packages-container');

            let index = parseInt(container.dataset.index);

            const html = `
        <div class="row g-2 align-items-end package-item mb-2">
            <div class="col-5">
                <input type="number" name="packages[${index}][votes]" class="form-control bg-light border-0" placeholder="Nombre de votes" required>
            </div>
            <div class="col-5">
                <input type="number" name="packages[${index}][montant]" class="form-control bg-light border-0" placeholder="Prix (FCFA)" readonly required>
            </div>
            <div class="col-2 text-end">
                <button type="button" class="btn btn-danger btn-sm remove-package">✕</button>
            </div>
        </div>
        `;

            container.insertAdjacentHTML('beforeend', html);
            container.dataset.index = index + 1;
        }

        // Supprimer un package
        if (e.target.classList.contains('remove-package')) {
            e.target.closest('.package-item').remove();
        }

    });

    // Quand on change le prix du vote
    document.addEventListener('input', function(e) {
        if (e.target.name === 'prix_vote' || e.target.name.includes('[votes]')) {
            calculerMontants();
        }
    });

    // Calculer les montants en fonction du prix par vote
    function calculerMontants() {
        const prixVote = parseFloat(document.querySelector('input[name="prix_vote"]').value) || 0;

        document.querySelectorAll('.package-item').forEach(package => {
            const votesInput = package.querySelector('input[name*="[votes]"]');
            const montantInput = package.querySelector('input[name*="[montant]"]');

            const votes = parseFloat(votesInput.value) || 0;

            const montant = prixVote * votes;

            montantInput.value = montant > 0 ? montant : '';
        });
    }
</script>
@endsection
<!-- section js -->
@section('extra-js')

@endsection