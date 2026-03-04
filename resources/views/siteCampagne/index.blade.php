@extends('siteCampagne.layouts.app')

@section('title', $title ?? 'Accueil')


@section('content')

    <section class="cover">
        <div class="container">
            <div class="grid">
                <div class="event-title">
                    <h1><span data-session-name>{{ $campagne->name }}</span></h1>
                    <p>{!! $campagne->description !!}</p>
                </div>
                <aside aria-label="Organisation" class="org-card">
                    <div class="org-row">
                        <div class="org">
                            <div class="org-badge" title="Organisateur">
                                <img src="{{ $customer->logo ? asset(env('IMAGES_PATH') . '/' . $customer->logo) : '#' }}"
                                    alt="" height="50" width="50">
                            </div>
                            <div>
                                <div>{{ $customer->user?->name }}</div>
                                <small>{{ $customer->entreprise }}</small>
                            </div>
                        </div>
                        <div aria-label="Raccourcis" class="org-links">
                            <div class="chip" title="Partager">
                                <svg aria-hidden="true" fill="none" viewbox="0 0 24 24">
                                    <path d="M18 8a3 3 0 1 0-2.8-4" opacity=".9" stroke="white" stroke-linecap="round"
                                        stroke-width="1.8"></path>
                                    <path d="M6 14a3 3 0 1 0 2.8 4" opacity=".9" stroke="white" stroke-linecap="round"
                                        stroke-width="1.8"></path>
                                    <path d="M8.5 13.2l7-3.7M8.5 14.8l7 3.7" opacity=".9" stroke="white"
                                        stroke-linecap="round" stroke-width="1.8"></path>
                                </svg>
                            </div>
                            <div class="chip" title="Infos">
                                <svg aria-hidden="true" fill="none" viewbox="0 0 24 24">
                                    <path d="M12 22A10 10 0 1 0 12 2a10 10 0 0 0 0 20Z" opacity=".9" stroke="white"
                                        stroke-width="1.8"></path>
                                    <path d="M12 10.7v6" opacity=".9" stroke="white" stroke-linecap="round"
                                        stroke-width="1.8"></path>
                                    <path d="M12 7.3h.01" opacity=".9" stroke="white" stroke-linecap="round"
                                        stroke-width="2.6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Navigation Etapes -->
    <div class="statusbar" role="status">
        <div class="container">

            <div class="inner">
                @foreach ($campagne->etapes as $etape)
                    <span class="badge">
                        <span class="ring"></span>
                        <span id="voteStateText">
                            <a href="?etape_id={{ $etape->etape_id }}">
                                {{ $etape->name }}
                            </a>
                        </span>
                    </span>
                @endforeach
            </div>

        </div>
    </div>

    <main>
        <div class="container">
            <!-- Toolbar (Toujours visible pour le bouton retour) -->
            <div class="toolbar">

                <div class="lefttools">
                    @if (!empty($showBackButton))
                        <button aria-label="Retour" class="backbtn" onclick="history.back()" type="button">
                            <svg aria-hidden="true" fill="none" viewbox="0 0 24 24">
                                <path d="M14.5 6.5L9 12l5.5 5.5" stroke="var(--primary)" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </button>
                    @endif
                    <div class="catpill" title="Contexte">
                        <span class="mini"></span>
                        <span>{{ $selectedEtape->name }}</span>
                    </div>
                </div>


                <!-- La recherche ne s'affiche que si l'étape est active -->
                @if ($selectedEtape && $selectedEtape->is_active_now)
                    <div aria-label="Rechercher un candidat" class="search" role="search">
                        <svg aria-hidden="true" fill="none" viewbox="0 0 24 24">
                            <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" opacity=".75" stroke="var(--primary)"
                                stroke-width="2"></path>
                            <path d="M16.8 16.8 21 21" opacity=".75" stroke="var(--primary)" stroke-linecap="round"
                                stroke-width="2"></path>
                        </svg>
                        <!-- Note: Pour une recherche JS sur le DOM généré par Blade, gardez l'ID 'q' -->
                        <input autocomplete="off" id="q" placeholder="Rechercher un candidat..." />
                    </div>
                @endif
            </div>

            {{-- DÉBUT LOGIQUE BLADE --}}
            @if ($selectedEtape)

                {{-- CAS 1 : Etape à venir --}}
                @if ($selectedEtape->is_upcoming)
                    <div class="state-message">
                        <h2 style="color:var(--ink); margin-bottom:10px;">Bientôt disponible</h2>
                        <p>L'étape "{{ $selectedEtape->name }}" ouvrira dans :</p>

                        <div class="countdown-wrapper">
                            <div class="countdown-item">
                                <span
                                    class="countdown-value">{{ sprintf('%02d', $selectedEtape->countdown['days']) }}</span>
                                <span class="countdown-label">Jours</span>
                            </div>
                            <div class="countdown-item">
                                <span
                                    class="countdown-value">{{ sprintf('%02d', $selectedEtape->countdown['hours']) }}</span>
                                <span class="countdown-label">Heures</span>
                            </div>
                            <div class="countdown-item">
                                <span
                                    class="countdown-value">{{ sprintf('%02d', $selectedEtape->countdown['minutes']) }}</span>
                                <span class="countdown-label">Minutes</span>
                            </div>
                        </div>
                    </div>

                    {{-- CAS 2 : Etape en cours --}}
                @elseif($selectedEtape->is_active_now)
                    @php
                        $categoriesActives = $campagne->categories->filter(function ($cat) use ($selectedEtapeId) {
                            return $cat->candidats->where('etape_id', $selectedEtapeId)->count() > 0;
                        });
                    @endphp

                    {{-- SOUS-CAS 2.1 : Affichage des Catégories --}}
                    @if ($categoriesActives->count() > 0)
                        <div class="section-label">Filtrer par catégorie</div>
                        <div class="cat-grid">
                            @foreach ($categoriesActives as $category)
                                <a href="?etape_id={{ $selectedEtapeId }}&category_id={{ $category->category_id }}"
                                    style="display:block">
                                    <div
                                        class="cat-card {{ $selectedCategoryId == $category->category_id ? 'active' : '' }}">
                                        <div class="cat-icon">
                                            <!-- Utilisation de FontAwesome conservée mais stylisée -->
                                            <i
                                                class="fa-solid {{ $category->icon == 'femme' ? 'fa-child-dress' : 'fa-child' }}"></i>
                                        </div>
                                        <div class="cat-info">
                                            <h5>{{ $category->name }}</h5>
                                            <small>{{ $category->candidats->where('etape_id', $selectedEtapeId)->count() }}
                                                Candidat(s)</small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        {{-- SOUS-CAS 2.2 : Liste des Candidats (Si catégorie choisie) --}}
                        @if ($selectedCategoryId)
                            @php
                                $candidatsToDisplay = $selectedEtape->candidats->where(
                                    'category_id',
                                    $selectedCategoryId,
                                );
                            @endphp
                            {{-- @dd($candidatsToDisplay); --}}
                            <div class="section-label">Liste des candidats</div>
                            <section class="gridcards" id="cards">
                                @foreach ($candidatsToDisplay as $candidat)
                                    @include('siteCampagne.partials.candidate-card', [
                                        'candidat' => $candidat,
                                    ])
                                @endforeach
                            </section>
                        @else
                            {{-- Message si aucune catégorie sélectionnée --}}
                            <div class="state-message">

                                <h3>Sélectionnez une catégorie</h3>
                                <p>Veuillez choisir une catégorie ci-dessus pour voir les candidats.</p>
                            </div>
                        @endif
                    @else
                        {{-- SOUS-CAS 2.3 : Liste des Candidats (Direct, sans catégories) --}}
                        @if ($selectedEtape->candidats->count() > 0)
                            <section class="gridcards" id="cards">
                                @foreach ($selectedEtape->candidats as $candidat)
                                    @include('siteCampagne.partials.candidate-card', [
                                        'candidat' => $candidat,
                                    ])
                                @endforeach
                            </section>
                        @else
                            <div class="state-message">
                                <h3>Aucun candidat</h3>
                                <p>Il n'y a pas encore de candidats inscrits à cette étape.</p>
                            </div>
                        @endif
                    @endif

                    {{-- CAS 3 : Terminé --}}
                @else
                    <div class="state-message">
                        <div class="state-icon">🏁</div>
                        <h3 style="color:var(--ink)">L'étape est terminée</h3>
                        <p>Les votes pour "{{ $selectedEtape->name }}" sont clos.</p>
                    </div>
                @endif
            @else
                {{-- CAS 4 : Erreur config --}}
                <div class="state-message">
                    <h3>Campagne non configurée</h3>
                    <p>Aucune étape active n'a été trouvée.</p>
                </div>
            @endif

            <!-- Pagination ou bouton Voir plus (Optionnel selon ton backend) -->
            <div class="bottomrow">
                {{-- Si tu utilises la pagination Laravel standard --}}
                {{-- {{ $candidatsToDisplay->links() }} --}}

                {{-- Sinon, le bouton statique --}}
                <!-- <button class="more" id="more" type="button">Voir plus …</button> -->
            </div>

        </div>
    </main>

    @include('siteCampagne.partials.payment-system')

@endsection

@push('scripts')

    <script>
        // 1. Ouvrir une modale spécifique
        function openSpecificModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add("is-open");
                modal.setAttribute("aria-hidden", "false");
                document.body.classList.add("modal-open");
            }
        }

        // 2. Fermer une modale spécifique
        function closeSpecificModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove("is-open");
                modal.setAttribute("aria-hidden", "true");
                document.body.classList.remove("modal-open");
            }
        }

        // 3. Sélectionner un pack (Optimisé avec querySelector scoped)
        function selectPackInModal(modalId, votes, montant, clickedBtn) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            // On ne cherche que les boutons À L'INTÉRIEUR de cette modale précise
            const allPacks = modal.querySelectorAll('.packRow');
            allPacks.forEach(btn => btn.classList.remove('is-selected'));

            // On active celui cliqué
            clickedBtn.classList.add('is-selected');

            // Mise à jour du bouton Valider
            const submitBtn = document.getElementById('btn-' + modalId);
            if (submitBtn) {
                // Formatage propre du prix (1000 -> 1 000)
                const formattedPrice = String(montant).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                submitBtn.textContent = `Voter • ${formattedPrice} Fcfa`;

                // Mise à jour des données pour le checkout
                submitBtn.dataset.packVotes = votes;
                submitBtn.dataset.packMontant = montant;
            }
        }

        // 4. Passer au checkout (Transition entre modales)
        function proceedToCheckout(btn) {
            // Récupération sécurisée des données
            const data = btn.dataset;

            // 1. Fermer la modale actuelle
            const currentModal = btn.closest('.modal');
            if (currentModal) {
                closeSpecificModal(currentModal.id);
            }

            // 2. Préparer les données cible
            const target = {
                id: data.candidatId,
                name: data.candidatNom,
                num: data.candidatNum,
                campagneId: data.campagneId,
                etapeId: data.etapeId
            };

            const pack = {
                vote: parseInt(data.packVotes) || 0,
                montant: parseInt(data.packMontant) || 0
            };

            // 3. Ouvrir le checkout (si la fonction existe)
            if (typeof openCheckoutModal === 'function') {
                openCheckoutModal(target, pack);
            } else {
                console.error("Erreur : La fonction openCheckoutModal n'est pas chargée.");
            }
        }
    </script>
@endpush
