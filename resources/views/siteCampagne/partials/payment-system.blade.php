<!-- Checkout modal -->
<div aria-hidden="true" class="modal" id="checkoutModal">
    <div class="modal__overlay"></div>
    <div aria-labelledby="checkoutTitle" aria-modal="true" class="modal__panel modal__panel--wide" role="dialog">
        <button aria-label="Fermer" class="modal__close" data-close="1">✕</button>

        <div class="checkout">
            {{-- EN-TÊTE FIXE --}}
            <div class="checkout__head">
                <div>
                    <div class="kicker">Guichet de paiement</div>
                    <h3 id="checkoutTitle">Valider votre vote</h3>
                    <div class="sub" id="checkoutSub">-</div>
                </div>
                <div class="checkout__amount">
                    <div class="label">Montant</div>
                    <div class="value" id="checkoutAmount">0 FCFA</div>
                </div>
            </div>

            <div class="checkout__body" id="checkoutBody">

                {{-- ÉTAPE 1 : CGU --}}
                <div id="step-cgu">
                    <div class="bg-light border rounded p-3 mb-3"
                        style="max-height: 200px; overflow-y: auto; font-size: 0.85rem; background-color: #f8f9fa;">
                        <strong>VOTIUM – Conditions Générales de Participation et de Vote</strong><br><br>
                        <p>Version de test — à ne pas utiliser en production

                            Article 1 — Objet
                            Les présentes conditions générales régissent la participation aux campagnes de vote
                            organisées sur la plateforme. En participant, l'utilisateur accepte sans réserve l'ensemble
                            des présentes conditions.
                            Article 2 — Participation

                            La participation est ouverte à toute personne physique majeure disposant d'un moyen de
                            paiement valide.
                            Chaque participant peut voter autant de fois qu'il le souhaite dans la limite des votes
                            disponibles à l'achat.
                            Toute tentative de fraude, de manipulation ou d'utilisation de moyens automatisés est
                            strictement interdite et entraîne la disqualification immédiate.

                            Article 3 — Paiement

                            Les votes sont payants. Le prix par vote est affiché clairement avant toute confirmation
                            d'achat.
                            Le paiement est effectué via les opérateurs de paiement mobile disponibles sur la plateforme
                            (Wave, Orange Money, MTN Money, etc.).
                            Tout paiement validé est définitif et ne peut faire l'objet d'aucun remboursement, sauf en
                            cas d'erreur technique avérée imputable à la plateforme.

                            Article 4 — Résultats

                            Les votes sont comptabilisés en temps réel. Les résultats affichés sont indicatifs et
                            peuvent faire l'objet d'une vérification finale par l'organisateur.
                            L'organisateur se réserve le droit d'annuler des votes en cas de fraude détectée, sans
                            préavis ni remboursement.
                            Les résultats définitifs sont proclamés par l'organisateur à l'issue de la campagne selon
                            les modalités prévues.

                            Article 5 — Données personnelles

                            Les données collectées (nom, téléphone, email) sont utilisées uniquement dans le cadre du
                            traitement du paiement et de la participation au vote.
                            Elles ne sont ni revendues ni transmises à des tiers en dehors des prestataires de paiement
                            nécessaires à l'exécution de la transaction.
                            Conformément à la réglementation en vigueur, l'utilisateur dispose d'un droit d'accès, de
                            rectification et de suppression de ses données.

                            Article 6 — Responsabilité

                            La plateforme ne saurait être tenue responsable des interruptions de service liées aux
                            opérateurs de paiement tiers.
                            En cas d'incident technique, la plateforme s'engage à faire ses meilleurs efforts pour
                            rétablir le service dans les meilleurs délais.

                            Article 7 — Acceptation
                            En cochant la case d'acceptation lors du paiement, le participant reconnaît avoir lu,
                            compris et accepté l'intégralité des présentes conditions générales.

                            Ces conditions sont fournies à titre de test. Elles devront être adaptées et validées par un
                            juriste avant toute mise en production.</p>
                    </div>
                    <div class="form-check p-2 rounded d-flex align-items-center gap-2"
                        style="background-color: rgba(0,0,0,0.03);">
                        <input class="form-check-input mt-0" type="checkbox" id="acceptCGU">
                        <label class="form-check-label small" for="acceptCGU" style="cursor:pointer;">
                            J'ai lu et j'accepte les termes et conditions.
                        </label>
                    </div>
                    <div class="mt-3 text-end">
                        <button class="btn btn--primary" id="btn-next-details" disabled>Continuer</button>
                    </div>
                </div>

                {{-- ÉTAPE 2 : DÉTAILS & MOYENS DE PAIEMENT --}}
                <div id="step-details" style="display: none;">

                    <div class="row">
                        <div class="col-6">
                            {{-- Formulaire Info --}}
                            <div class="checkout__form mb-4">
                                <div class="sectionTitle">Vos informations</div>
                                <div class="field">
                                    <label>Nom & Prénoms<span class="text-danger">*</span></label>
                                    <input type="text" id="payName" placeholder="Ex: John Doe">
                                    {{-- Ajout du message d'erreur caché par défaut --}}
                                    <span id="error-payName" class="text-danger small mt-1"
                                        style="display: none;">Veuillez entrer votre nom.</span>
                                </div>
                                <div class="field">
                                    <label>Email (Optionnel)</label>
                                    <input type="email" id="payEmail" placeholder="Ex: john@example.com">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            {{-- Grille Moyens de Paiement --}}
                            <div class="checkout__methods">
                                <div class="sectionTitle">Moyens de paiement</div>
                                <div class="methods-grid" style="display: grid; grid-template-columns: 1fr; gap: 10px;">
                                    @php
                                        $instructions = [
                                            'orange_money' =>
                                                "Code d'autorisation : Tapez le <strong>#144*82#</strong> puis option 2.",
                                            'mtn' => 'Validez le retrait en tapant <strong>*133#</strong>.',
                                            'moov_money' => 'Un message push sera envoyé.',
                                            'wave' => 'Entrez votre numéro Wave.',
                                            'card' => 'Redirection sécurisée.',
                                        ];
                                    @endphp

                                    @foreach ($paymentMethods as $method)
                                        @if ($method->value === 'orange_money' || $method->value === 'wave')
                                            <button type="button" class="methodBtn js-select-method"
                                                data-name="{{ str_replace(['-', '_'], ' ', $method->value) }}"
                                                data-slug="{{ $method->value }}"
                                                data-icon="{{ asset(env('IMAGES_PAYMENT') . '/' . $method->icon()) }}"
                                                data-instruction="{{ $instructions[$method->value] ?? '' }}">

                                                <div class="top">
                                                    <div class="left">
                                                        <img src="{{ asset(env('IMAGES_PAYMENT') . '/' . $method->icon()) }}"
                                                            class="methodIcon" alt="{{ $method->label() }}">
                                                        <div class="name" style="text-transform: capitalize;">
                                                            {{ str_replace(['-', '_'], ' ', $method->value) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="actions mt-3">
                        <button class="btn btn--ghost" id="btn-back-cgu">Retour</button>
                    </div>
                </div>

                {{-- ÉTAPE 3 : VALIDATION (Numéro + OTP) --}}
                <div id="step-validation" style="display: none;">
                    <div class="text-center mb-0">
                        <img id="selected-method-icon" src="" style="height: 50px; margin-bottom: 5px;">
                        <h4 id="selected-method-name">Moyen de paiement</h4>
                        <p class="small text-muted" id="selected-method-instruction"></p>
                    </div>

                    <div class="checkout__form">
                        <div class="field">
                            <label>Numéro de téléphone</label>
                            <input type="tel" id="payPhone" placeholder="Ex: 07 07 00 00 00">
                        </div>

                        {{-- Zone OTP (affichée dynamiquement via JS) --}}
                        <div id="otp-section" style="display:none;" class="mt-3 field">
                            <label class="small fw-bold">Code OTP / Autorisation</label>
                            <input type="text" id="otpCodeInput" class="text-center fw-bold" placeholder="X X X X"
                                maxlength="4" style="letter-spacing: 3px; font-size: 1.2rem;">
                        </div>

                        <div class="actions mt-0">
                            <button class="btn btn--ghost" id="btn-back-details">Retour</button>
                            <button class="btn btn--primary" id="btn-confirm-payment">Payer</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast" id="toast" role="status" aria-live="polite"></div>

<!-- Overlay de Traitement -->
<div id="processing-overlay"
    style="display: none; position: fixed; inset: 0; background: rgba(255,255,255,0.95); z-index: 10000; flex-direction: column; align-items: center; justify-content: center;">
    <div class="spinner"
        style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid var(--primary); border-radius: 50%; animation: spin 1s linear infinite;">
    </div>
    <h3 class="mt-3">Traitement en cours...</h3>
    <p id="processing-message">Veuillez patienter...</p>
</div>

<style>
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>


<!-- SCRIPT DE PAIEMENT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- VARIABLES GLOBALES ---
        let checkoutState = {
            candidatId: null,
            votes: 0,
            amount: 0,
            provider: null,
            providerSlug: null,
            campagneId: null,
            etapeId: null
        };

        // --- DOM ELEMENTS ---
        const modal = document.getElementById('checkoutModal');
        const stepCgu = document.getElementById('step-cgu');
        const stepDetails = document.getElementById('step-details');
        const stepValidation = document.getElementById('step-validation');

        const btnNextDetails = document.getElementById('btn-next-details');
        const btnBackCgu = document.getElementById('btn-back-cgu');
        const btnBackDetails = document.getElementById('btn-back-details');
        const btnConfirmPay = document.getElementById('btn-confirm-payment');
        const acceptCGU = document.getElementById('acceptCGU');

        const inputName = document.getElementById('payName');
        const errorPayName = document.getElementById('error-payName'); // Ajouté dans le HTML précédent
        const inputEmail = document.getElementById('payEmail');
        const inputPhone = document.getElementById('payPhone');
        const inputOtp = document.getElementById('otpCodeInput');
        const otpSection = document.getElementById('otp-section');

        // Elements Overlay
        const overlay = document.getElementById('processing-overlay');
        const processingMsg = document.getElementById('processing-message');

        // --- 1. FONCTIONS DE NAVIGATION ---

        function showStep(stepName) {
            stepCgu.style.display = 'none';
            stepDetails.style.display = 'none';
            stepValidation.style.display = 'none';
            document.getElementById(stepName).style.display = 'block';
        }

        // --- 2. OUVERTURE MODALE (Appelée depuis l'extérieur) ---
        window.openCheckoutModal = function(target, pack) {
            // target = {id, name, num, campagneId, etapeId}
            // pack = {vote, montant}

            checkoutState.candidatId = target.id;
            // On récupère campagneId et etapeId (s'ils sont passés dans l'objet target depuis proceedToCheckout)
            checkoutState.campagneId = target.campagneId || 1;
            checkoutState.etapeId = target.etapeId || 1;

            checkoutState.votes = pack.vote;
            checkoutState.amount = pack.montant;

            // Update UI
            document.getElementById('checkoutSub').textContent = `${target.name} • ${pack.vote} Votes`;
            // Formatage propre du montant
            const formattedAmount = String(pack.montant).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            document.getElementById('checkoutAmount').textContent = `${formattedAmount} FCFA`;

            // Reset Form
            inputName.value = '';
            inputEmail.value = '';
            inputPhone.value = '';
            inputOtp.value = '';

            // Reset Validations
            inputName.classList.remove('is-invalid');
            if (errorPayName) errorPayName.style.display = 'none';
            inputPhone.classList.remove('is-invalid');
            inputOtp.classList.remove('is-invalid');

            acceptCGU.checked = false;
            btnNextDetails.disabled = true;

            showStep('step-cgu');

            // Ouvrir modale (gestion classe CSS)
            modal.classList.add('is-open');
            document.body.classList.add('modal-open');
        };

        window.closeCheckoutModal = function() {
            modal.classList.remove('is-open');
            document.body.classList.remove('modal-open');
        };

        // --- 3. EVENT LISTENERS ---

        // Fermeture
        document.querySelectorAll('[data-close]').forEach(el => {
            el.addEventListener('click', window.closeCheckoutModal);
        });

        // CGU Checkbox
        acceptCGU.addEventListener('change', function() {
            btnNextDetails.disabled = !this.checked;
        });

        // Navigation Boutons
        btnNextDetails.addEventListener('click', () => showStep('step-details'));
        btnBackCgu.addEventListener('click', () => showStep('step-cgu'));
        btnBackDetails.addEventListener('click', () => showStep('step-details'));

        // --- VALIDATION NOM ---
        function validateName() {
            if (!inputName.value.trim()) {
                inputName.classList.add('is-invalid');
                inputName.style.borderColor = 'red';
                if (errorPayName) errorPayName.style.display = 'block';
                return false;
            } else {
                inputName.classList.remove('is-invalid');
                inputName.style.borderColor = '';
                if (errorPayName) errorPayName.style.display = 'none';
                return true;
            }
        }

        // Retirer l'erreur dès la saisie
        inputName.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
                this.style.borderColor = '';
                if (errorPayName) errorPayName.style.display = 'none';
            }
        });

        // --- SÉLECTION MÉTHODE PAIEMENT ---
        document.querySelectorAll('.js-select-method').forEach(btn => {
            btn.addEventListener('click', function() {

                // 1. Validation du nom
                if (!validateName()) return;

                // 2. Configuration méthode
                const slug = this.dataset.slug;
                checkoutState.providerSlug = slug;

                // Update UI Validation Step
                document.getElementById('selected-method-icon').src = this.dataset.icon;
                document.getElementById('selected-method-name').textContent = this.dataset.name;
                document.getElementById('selected-method-instruction').innerHTML = this.dataset
                    .instruction;

                // Gestion OTP / Placeholders
                if (slug === 'orange_money') {
                    otpSection.style.display = 'block';
                    inputPhone.placeholder = "07 07 00 00 00";
                } else {
                    otpSection.style.display = 'none';
                    if (slug === 'mtn') inputPhone.placeholder = "05 05 00 00 00";
                    else if (slug === 'wave') inputPhone.placeholder = "01 02 00 00 00";
                    else inputPhone.placeholder = "Numéro de téléphone";
                }

                showStep('step-validation');
            });
        });

        // --- 4. LOGIQUE PAIEMENT AJAX & POLLING ---
        btnConfirmPay.addEventListener('click', function() {
            // Validation Champs
            let hasError = false;
            if (!inputPhone.value.trim()) {
                inputPhone.classList.add('is-invalid');
                // Optionnel : afficher msg erreur phone
                hasError = true;
            } else {
                inputPhone.classList.remove('is-invalid');
            }

            if (otpSection.style.display !== 'none' && !inputOtp.value.trim()) {
                inputOtp.classList.add('is-invalid');
                // alert("Veuillez entrer le code OTP / Autorisation.");
                swal.fire({
                    icon: 'error',
                    title: 'Champ manquant',
                    text: "Veuillez entrer le code OTP / Autorisation.",
                });
                hasError = true;
            } else {
                inputOtp.classList.remove('is-invalid');
            }

            if (hasError) return;

            // UI Loading & Disable Button
            const originalBtnText = btnConfirmPay.innerHTML;
            btnConfirmPay.disabled = true;
            btnConfirmPay.innerHTML =
                '<div class="spinner" style="width:20px;height:20px;border:3px solid #fff;border-top:3px solid transparent;border-radius:50%;animation:spin 1s linear infinite;display:inline-block;vertical-align:middle;margin-right:8px;"></div> Traitement...';

            try {
                // Préparation Payload
                const payload = {
                    candidat_id: checkoutState.candidatId,
                    etate_id: checkoutState.etapeId,
                    campagne_id: checkoutState.campagneId,
                    quantity: checkoutState.votes,
                    amount: checkoutState.amount,
                    provider: checkoutState.providerSlug,
                    name: inputName.value,
                    email: inputEmail.value,
                    phoneNumber: inputPhone.value,
                    otpCode: inputOtp.value
                };

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                    'content');

                fetch("{{ route('business.paiementVote') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(async response => {
                        const contentType = response.headers.get("content-type");
                        if (!contentType || !contentType.includes("application/json"))
                            throw new Error("Erreur Serveur (HTML reçu au lieu de JSON)");
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            window.closeCheckoutModal();
                            //Toujours rediriger vers la page de vérification, peu importe le provider
                            window.location.href = data.redirect_url;
                        } else {
                            swal.fire({
                                icon: 'error',
                                title: 'Paiement échoué',
                                text: 'Une erreur est survenue lors du paiement. Veuillez réessayer ou contacter le support si le problème persiste.',
                            });
                            btnConfirmPay.disabled = false;
                            btnConfirmPay.innerHTML = originalBtnText;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        swal.fire({
                            icon: 'error',
                            title: 'Erreur de connexion',
                            text: 'Impossible de contacter le service de paiement. Vérifiez votre connexion et réessayez.',
                        });
                        btnConfirmPay.disabled = false;
                        btnConfirmPay.innerHTML = originalBtnText;
                    });

            } catch (e) {
                btnConfirmPay.disabled = false;
                btnConfirmPay.innerHTML = originalBtnText;
                // alert("Erreur Script : " + e.message);
                swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: e.message || 'Une erreur est survenue. Veuillez réessayer.',
                });
            }
        });

    });
</script>
