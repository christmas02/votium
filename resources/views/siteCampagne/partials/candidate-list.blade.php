<div class="row">
    @forelse($candidats as $candidat) {{-- LA BOUCLE EST ESSENTIELLE ICI --}}
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="candidate-card">
                <div class="candidate-img-wrapper">
                    {{-- Ici $candidat est maintenant un objet unique, donc photo fonctionne --}}
                    <img src="{{ $candidat->photo ? asset('uploads/' . $candidat->photo) : 'https://placehold.co/400x500?text=Sans+Photo' }}"
                        alt="{{ $candidat->name }}">
                </div>
                <div class="card-body-custom">
                    <h5 class="candidate-title">{{ $candidat->name }}</h5>
                    <div class="candidate-subtitle">Candidat(e) / Nominé(e)</div>

                    <div class="vote-row">
                        <div class="candidate-number">
                            <small>Numéro</small>
                            {{ sprintf('%03d', $loop->iteration) }}
                        </div>
                        <div class="vote-percent">
                            0.00% <small>votes</small>
                        </div>
                    </div>

                    <div class="vote-selection-wrapper" id="vote-{{ $candidat->candidat_id }}">
                        {{-- Vérifiez que $selectedEtape est bien passé au partial ou utilisez $candidat->etape --}}
                        @php $packages = json_decode($selectedEtape->package ?? '[]'); @endphp
                        @if ($packages)
                            @foreach ($packages as $p)
                                <div class="vote-item js-open-modal" style="cursor: pointer;"
                                    data-candidate-id="{{ $candidat->candidat_id }}" 
                                    data-campagne-id="{{ $campagne->campagne_id }}" 
                                    data-etape-id="{{ $selectedEtape->etape_id }}" 
                                    data-candidate="{{ $candidat->name }}" 
                                    data-votes="{{ $p->vote }}"
                                    data-amount="{{ $p->montant }}">
                                    <span>{{ $p->vote }} Votes</span>
                                    <span class="price text-primary fw-bold">{{ $p->montant }} Fcfa</span>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="action-row">
                        <button class="btn btn-share"><i class="fa-solid fa-share-nodes"></i></button>
                        <button class="btn btn-vote js-vote-trigger">Voter</button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Aucun candidat trouvé.</p>
        </div>
    @endforelse
</div>

<!-- Modal Paiement -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Payez avec</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-2">
                <p class="text-muted small mb-3">Par quel moyen de paiement voulez vous effectuer le paiement.</p>

                <!-- ÉTAPE 1 : CONDITIONS -->
                <div id="modal-step-1">
                    <div class="card bg-light border-0 mb-3">
                        <div class="card-body p-3" style="max-height: 200px; overflow-y: auto; font-size: 0.85rem;">
                            <strong>VOTIUM – Conditions Générales d’Utilisation</strong><br><br>
                            <!-- Contenu des CGU raccourci pour la lisibilité -->
                            En utilisant la plateforme Chooz, l’Utilisateur reconnaît avoir lu, compris et accepté les présentes Conditions Générales d’Utilisation.
                            En utilisant la plateforme Chooz, l’Utilisateur reconnaît avoir lu, compris et accepté les présentes Conditions Générales d’Utilisation.
                            En utilisant la plateforme Chooz, l’Utilisateur reconnaît avoir lu, compris et accepté les présentes Conditions Générales d’Utilisation.
                        </div>
                    </div>
                    <div class="form-check p-2 bg-light rounded d-flex align-items-center gap-2">
                        <input class="form-check-input mt-0" type="checkbox" id="acceptCGU_step1" style="margin-left: 0.2em;">
                        <label class="form-check-label small lh-1" for="acceptCGU_step1">
                            J'ai lu et j'accepte les termes et conditions d'utilisation de Chooz.
                        </label>
                    </div>
                </div>

                <!-- ÉTAPE 2 : FORMULAIRE -->
                <div id="modal-step-2" style="display: none;">
                    <div class="alert alert-warning p-2 mb-3 d-flex align-items-center">
                        <input class="form-check-input me-2 mt-0" type="checkbox" id="acceptCGU_step2" checked>
                        <label class="form-check-label small text-dark" for="acceptCGU_step2" style="cursor:pointer;">
                            J'ai lu et j'accepte les termes et conditions.
                        </label>
                    </div>

                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control bg-light border-0 py-2" placeholder="Nom et Prénoms *" id="payName">
                        </div>
                        <div class="mb-3">
                            <!-- Modification ici : Placeholder Optionnel -->
                            <input type="email" class="form-control bg-light border-0 py-2" placeholder="Email (Optionnel)" id="payEmail">
                        </div>

                        <div class="text-center mb-3">
                            <span class="badge bg-primary text-white" id="modal-summary-votes"></span>
                            <span class="badge bg-dark text-white" id="modal-summary-price"></span>
                        </div>

                        @php
                            $instructions = [
                                'orange_money' => "Code d'autorisation : Tapez le <strong>#144*82#</strong> puis option 2. Entrez le code obtenu ci-dessous.",
                                'mtn' => 'Veuillez valider le retrait en tapant <strong>*133#</strong> sur votre mobile après validation.',
                                'moov_money' => 'Un message push sera envoyé sur votre téléphone.',
                                'wave' => 'Entrez votre numéro Wave ci-dessous pour valider la transaction.',
                                'card' => 'Vous allez être redirigé vers la page de paiement sécurisée.',
                            ];
                        @endphp

                        <div class="row g-2 text-center">
                            @foreach ($paymentMethods as $method)
                                <x-payment-method-card :method="$method" :instruction="$instructions[$method->value] ?? 'Entrez le numéro pour valider la transaction.'" />
                            @endforeach
                        </div>
                    </form>
                </div>

                <!-- ÉTAPE 3 : FINALISATION -->
                <div id="modal-step-3" style="display: none;">

                    <div class="text-center mb-4 py-3 bg-light rounded-3 shadow-sm">
                        <img id="step3-logo" src="" alt="Payment" style="height: 70px; object-fit: contain;" class="mb-2">
                        <h5 class="fw-bold text-dark mb-0" id="step3-title"></h5>
                        <small class="text-muted">Paiement sécurisé</small>
                    </div>

                    <form id="otpForm">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted" id="step3-label-input">Numéro de téléphone</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                <input type="tel" class="form-control form-control-lg border-start-0 ps-0" id="payPhone" placeholder="Ex: 0707..." required>
                            </div>
                            
                            <!-- Zone d'instruction -->
                            <div class="form-text text-primary small mb-3" id="step3-help-text">
                                Entrez le numéro pour valider la transaction.
                            </div>

                            <!-- NOUVEAU : Zone Code OTP (Caché par défaut) -->
                            <div id="otp-section" style="display:none;" class="animate__animated animate__fadeIn">
                                <label class="form-label small fw-bold text-dark">Code OTP / Autorisation</label>
                                <input type="text" class="form-control form-control-lg text-center fw-bold letter-spacing-2" 
                                       id="otpCodeInput" 
                                       placeholder="X X X X" 
                                       maxlength="4"
                                       style="letter-spacing: 3px; font-size: 1.2rem;">
                                <div class="form-text small text-muted">Entrez le code reçu ou généré.</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light border px-3" id="btn-back-step2">
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                            <button type="button" class="btn btn-warning text-white w-100 fw-bold py-2 shadow-sm" id="btn-final-pay">
                                Confirmer le paiement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
