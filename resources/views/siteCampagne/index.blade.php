@extends('siteCampagne.layouts.app')

@section('title', $title ?? 'Accueil')


@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        @if ($campagne->image_couverture)
            <div class="hero-image-container"
                style="--campagne-bg: url('{{ asset('uploads/' . $campagne->image_couverture) }}')"></div>
        @else
            <div class="hero-image-container"></div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-lg-7 position-relative">
                    <h1 class="hero-title">{{ $campagne->name }}</h1>
                    <p class="hero-text">{!! $campagne->description !!}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Navigation Etapes -->
    <nav class="bg-white border-bottom sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <ul class="nav nav-pills py-3 gap-2">
                @foreach ($campagne->etapes as $etape)
                    <li class="nav-item">
                        <a class="nav-link etape {{ $selectedEtapeId == $etape->etape_id ? 'active bg-light' : 'text-dark border' }}"
                            href="?etape_id={{ $etape->etape_id }}">
                            {{ $etape->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="search-input-group">
                <i class="fa fa-search"></i>
                <input type="text" id="candidatSearch" class="form-control" placeholder="Rechercher..."
                    style="width: 250px;">
            </div>
        </div>
    </nav>

    <main class="container mt-5 mb-5">
        @if ($selectedEtape)

            {{-- CAS 1 : Etape à venir --}}
            @if ($selectedEtape->is_upcoming)
                <div class="text-center mb-5">
                    <h2 class="fw-bold">L'étape "{{ $selectedEtape->name }}" ouvrira dans :</h2>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-4 mb-5">
                    <div class="countdown-item">
                        <div class="countdown-circle primary">
                            <span class="countdown-value">{{ sprintf('%02d', $selectedEtape->countdown['days']) }}</span>
                        </div>
                        <span class="countdown-label">Jours</span>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-circle secondary">
                            <span class="countdown-value">{{ sprintf('%02d', $selectedEtape->countdown['hours']) }}</span>
                        </div>
                        <span class="countdown-label">Heures</span>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-circle primary">
                            <span class="countdown-value">{{ sprintf('%02d', $selectedEtape->countdown['minutes']) }}</span>
                        </div>
                        <span class="countdown-label">Minutes</span>
                    </div>
                </div>

                {{-- CAS 2 : Etape en cours --}}
            @elseif($selectedEtape->is_active_now)
                @php
                    $categoriesActives = $campagne->categories->filter(function ($cat) use ($selectedEtapeId) {
                        return $cat->candidats->where('etape_id', $selectedEtapeId)->count() > 0;
                    });
                @endphp

                @if ($categoriesActives->count() > 0)
                    <section class="mb-5">
                        <h3 class="section-title">Catégories</h3>
                        <div class="row">
                            @foreach ($categoriesActives as $category)
                                <div class="col-md-6 mb-3">
                                    <a href="?etape_id={{ $selectedEtapeId }}&category_id={{ $category->category_id }}"
                                        class="text-decoration-none text-dark">
                                        <div
                                            class="category-card {{ $selectedCategoryId == $category->category_id ? 'border-warning border-2 shadow' : '' }}">
                                            <div class="category-icon">
                                                <i
                                                    class="fa-solid {{ $category->icon == 'femme' ? 'fa-child-dress' : 'fa-child' }}"></i>
                                            </div>
                                            <div class="category-info">
                                                <h5>{{ $category->name }}</h5>
                                                <small>{{ $category->candidats->where('etape_id', $selectedEtapeId)->count() }}
                                                    Candidat.e(s)</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                    <hr class="my-5">

                    @if ($selectedCategoryId)
                        @php
                            $candidatsToDisplay = $selectedEtape->candidats->where('category_id', $selectedCategoryId);
                            $catName = $categoriesActives->firstWhere('category_id', $selectedCategoryId)->name ?? '';
                        @endphp
                        <h4 class="mb-4">Candidats : {{ $catName }}</h4>
                        @include('siteCampagne.partials.candidate-list', [
                            'candidats' => $candidatsToDisplay,
                            'selectedEtape' => $selectedEtape,
                            'paymentMethods' => $paymentMethods,
                            'compteRetraits' => $compteRetraits,
                            'campagne' => $campagne,
                        ])
                    @else
                        <div class="alert alert-info text-center shadow-sm">
                            <i class="fa-solid fa-arrow-up me-2"></i> Sélectionnez une catégorie.
                        </div>
                    @endif
                @else
                    <h3 class="section-title">Candidats de l'étape</h3>
                    @if ($selectedEtape->candidats->count() > 0)
                        @include('siteCampagne.partials.candidate-list', [
                            'candidats' => $selectedEtape->candidats,
                            'selectedEtape' => $selectedEtape,
                            'paymentMethods' => $paymentMethods,
                            'compteRetraits' => $compteRetraits,
                        ])
                    @else
                        <div class="alert alert-warning text-center">Aucun candidat n'est inscrit.</div>
                    @endif
                @endif

                {{-- CAS 3 : Terminé --}}
            @else
                <div class="text-center py-5">
                    <i class="fa-solid fa-calendar-check fa-3x text-muted mb-3"></i>
                    <h3 class="text-muted">Cette étape est terminée.</h3>
                </div>
            @endif
        @else
            <div class="alert alert-danger text-center">Campagne non configurée.</div>
        @endif
    </main>

    <!-- INCLUSION DU SYSTÈME DE PAIEMENT (Overlay + Scripts JS) -->
    <!-- Assure-toi que le HTML du Modal (#paymentModal) est présent soit ici, soit dans candidate-list -->
    @include('siteCampagne.partials.payment-system')

@endsection

@push('scripts')
    <script>
        // Script simple pour la recherche et l'UI des votes (hors paiement)
        $(document).ready(function() {
            $("#candidatSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".candidate-card").each(function() {
                    var text = $(this).text().toLowerCase();
                    $(this).closest('.col-md-4').toggle(text.indexOf(value) > -1);
                });
            });
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('js-vote-trigger')) {
                const card = e.target.closest('.candidate-card');
                const menu = card.querySelector('.vote-selection-wrapper');
                document.querySelectorAll('.vote-selection-wrapper.show').forEach(m => {
                    if (m !== menu) m.classList.remove('show');
                });
                menu.classList.toggle('show');
            }
            if (e.target.closest('.vote-item')) {
                const item = e.target.closest('.vote-item');
                item.closest('.vote-selection-wrapper').classList.remove('show');
            }
        });
    </script>
@endpush
