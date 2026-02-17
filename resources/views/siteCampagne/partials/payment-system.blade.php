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
                            En utilisant la plateforme Chooz, l’Utilisateur reconnaît avoir lu, compris et accepté les
                            présentes Conditions Générales d’Utilisation.
                            En utilisant la plateforme Chooz, l’Utilisateur reconnaît avoir lu, compris et accepté les
                            présentes Conditions Générales d’Utilisation.
                            En utilisant la plateforme Chooz, l’Utilisateur reconnaît avoir lu, compris et accepté les
                            présentes Conditions Générales d’Utilisation.
                        </div>
                    </div>
                    <div class="form-check p-2 bg-light rounded d-flex align-items-center gap-2">
                        <input class="form-check-input mt-0" type="checkbox" id="acceptCGU_step1"
                            style="margin-left: 0.2em;">
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
                            <input type="text" class="form-control bg-light border-0 py-2"
                                placeholder="Nom et Prénoms *" id="payName">
                        </div>
                        <div class="mb-3">
                            <!-- Modification ici : Placeholder Optionnel -->
                            <input type="email" class="form-control bg-light border-0 py-2"
                                placeholder="Email (Optionnel)" id="payEmail">
                        </div>

                        <div class="text-center mb-3">
                            <span class="badge bg-primary text-white" id="modal-summary-votes"></span>
                            <span class="badge bg-dark text-white" id="modal-summary-price"></span>
                        </div>

                        @php
                            $instructions = [
                                'orange_money' =>
                                    "Code d'autorisation : Tapez le <strong>#144*82#</strong> puis option 2. Entrez le code obtenu ci-dessous.",
                                'mtn' =>
                                    'Veuillez valider le retrait en tapant <strong>*133#</strong> sur votre mobile après validation.',
                                'moov_money' => 'Un message push sera envoyé sur votre téléphone.',
                                'wave' => 'Entrez votre numéro Wave ci-dessous pour valider la transaction.',
                                'card' => 'Vous allez être redirigé vers la page de paiement sécurisée.',
                            ];
                        @endphp

                        <div class="row g-2 text-center">
                            @foreach ($paymentMethods as $method)
                                @if ($method->value === 'orange_money' || $method->value === 'wave')
                                    <div class="col-4">

                                        {{-- // Exemple de méthode nécessitant une instruction spécifique orange --}}
                                        <button type="button"
                                            class="btn btn-outline-light text-dark border w-100 py-3 payment-btn js-select-method position-relative"
                                            {{-- Données pour le JS --}}
                                            data-name="{{ str_replace(['-', '_'], ' ', $method->value) }}"
                                            data-slug="{{ $method->value }}"
                                            data-icon="{{ asset(env('IMAGES_PAYMENT') . '/' . $method->icon()) }}"
                                            data-instruction="{{ $instructions[$method->value] ?? 'Entrez le numéro pour valider la transaction.' }}">
                                            {{-- ICI: Le message dynamique --}}


                                            <img src="{{ asset(env('IMAGES_PAYMENT') . '/' . $method->icon()) }}"
                                                alt="{{ $method->label() }}" class="me-2"
                                                style="width:50px; height:50px; object-fit: contain;">

                                            <div class="small fw-bold mt-1">
                                                {{ str_replace(['-', '_'], ' ', $method->value) }}
                                            </div>

                                        </button>

                                    </div>
                                @endif
                                {{-- <x-payment-method-card :method="$method" :instruction="$instructions[$method->value] ?? 'Entrez le numéro pour valider la transaction.'" /> --}}
                            @endforeach
                        </div>
                    </form>
                </div>

                <!-- ÉTAPE 3 : FINALISATION -->
                <div id="modal-step-3" style="display: none;">

                    <div class="text-center mb-4 py-3 bg-light rounded-3 shadow-sm">
                        <img id="step3-logo" src="" alt="Payment" style="height: 70px; object-fit: contain;"
                            class="mb-2">
                        <h5 class="fw-bold text-dark mb-0" id="step3-title"></h5>
                        <small class="text-muted">Paiement sécurisé</small>
                    </div>

                    <form id="otpForm">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted" id="step3-label-input">Numéro de
                                téléphone</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="fa-solid fa-phone text-muted"></i></span>
                                <input type="tel" class="form-control form-control-lg border-start-0 ps-0"
                                    id="payPhone" placeholder="Ex: 0707..." required>
                            </div>

                            <!-- Zone d'instruction -->
                            <div class="form-text text-primary small mb-3" id="step3-help-text">
                                Entrez le numéro pour valider la transaction.
                            </div>

                            <!-- NOUVEAU : Zone Code OTP (Caché par défaut) -->
                            <div id="otp-section" style="display:none;" class="animate__animated animate__fadeIn">
                                <label class="form-label small fw-bold text-dark">Code OTP / Autorisation</label>
                                <input type="text"
                                    class="form-control form-control-lg text-center fw-bold letter-spacing-2"
                                    id="otpCodeInput" placeholder="X X X X" maxlength="4"
                                    style="letter-spacing: 3px; font-size: 1.2rem;">
                                <div class="form-text small text-muted">Entrez le code reçu ou généré.</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light border px-3" id="btn-back-step2">
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                            <button type="button" class="btn btn-warning text-white w-100 fw-bold py-2 shadow-sm"
                                id="btn-final-pay">
                                Confirmer le paiement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- OVERLAY DE TRAITEMENT -->
<div id="processing-overlay"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.98); z-index: 9999; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
    <div class="loader-container mb-4">
        <div class="spinner-ring"></div>
    </div>
    <h3 class="fw-bold text-dark mb-2">Traitement en cours...</h3>
    <p class="text-muted" id="processing-message">Veuillez patienter, nous vérifions votre transaction.</p>
</div>

<!-- SCRIPT DE PAIEMENT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. VARIABLES & ÉTAT INITIAL ---
        let currentTransaction = {
            candidatId: null,
            votes: 0,
            amount: 0,
            provider: null,
            providerSlug: null,
            campagneId: null,
            etapeId: null
        };

        const modalElement = document.getElementById('paymentModal');
        // Sécurité : si le modal n'est pas dans la page, on arrête pour éviter les erreurs JS console
        if (!modalElement) return;

        const bsModal = new bootstrap.Modal(modalElement);
        const step1 = document.getElementById('modal-step-1');
        const step2 = document.getElementById('modal-step-2');
        const step3 = document.getElementById('modal-step-3');
        const checkStep1 = document.getElementById('acceptCGU_step1');
        const checkStep2 = document.getElementById('acceptCGU_step2');

        const inputName = document.getElementById('payName');
        const inputEmail = document.getElementById('payEmail');
        const inputPhone = document.getElementById('payPhone');

        // Variables OTP
        const otpSection = document.getElementById('otp-section');
        const inputOtp = document.getElementById('otpCodeInput');

        const s3Logo = document.getElementById('step3-logo');
        const s3Title = document.getElementById('step3-title');
        const s3HelpText = document.getElementById('step3-help-text');
        const btnPay = document.getElementById('btn-final-pay');

        // --- 2. FONCTIONS UTILITAIRES ---
        function validateStep2() {
            let isValid = true;
            if (inputName.value.trim() === '') {
                inputName.classList.add('is-invalid');
                isValid = false;
            } else {
                inputName.classList.remove('is-invalid');
            }
            if (inputEmail.value.trim() !== '' && !inputEmail.value.includes('@')) {
                inputEmail.classList.add('is-invalid');
                isValid = false;
            } else {
                inputEmail.classList.remove('is-invalid');
            }
            return isValid;
        }

        // --- 3. OUVERTURE ET NAVIGATION ---
        document.querySelectorAll('.js-open-modal').forEach(item => {
            item.addEventListener('click', function() {
                const parentCard = this.closest('.candidate-card');
                const candidatId = this.getAttribute('data-candidate-id') || (parentCard ?
                    parentCard.getAttribute('data-id') : null);

                currentTransaction.campagneId = this.getAttribute('data-campagne-id');
                currentTransaction.etapeId = this.getAttribute('data-etape-id');
                currentTransaction.candidatId = candidatId;
                currentTransaction.votes = this.getAttribute('data-votes');
                currentTransaction.amount = this.getAttribute('data-amount');

                document.getElementById('modal-summary-votes').textContent = currentTransaction
                    .votes + ' Votes';
                document.getElementById('modal-summary-price').textContent = currentTransaction
                    .amount + ' Fcfa';

                step1.style.display = 'block';
                step2.style.display = 'none';
                step3.style.display = 'none';
                checkStep1.checked = false;
                checkStep2.checked = true;

                inputName.value = '';
                inputEmail.value = '';
                inputPhone.value = '';
                inputOtp.value = '';
                inputName.classList.remove('is-invalid');
                inputEmail.classList.remove('is-invalid');
                inputPhone.classList.remove('is-invalid');

                bsModal.show();
            });
        });

        checkStep1.addEventListener('change', function() {
            if (this.checked) {
                setTimeout(() => {
                    step1.style.display = 'none';
                    step2.style.display = 'block';
                    checkStep2.checked = true;
                }, 200);
            }
        });

        checkStep2.addEventListener('change', function() {
            if (!this.checked) {
                step2.style.display = 'none';
                step1.style.display = 'block';
                checkStep1.checked = false;
            }
        });

        // --- 4. SÉLECTION DU PAIEMENT ---
        document.querySelectorAll('.js-select-method').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!validateStep2()) return;
                const name = this.getAttribute('data-name');
                const icon = this.getAttribute('data-icon');
                const instruction = this.getAttribute('data-instruction');
                const slug = this.getAttribute('data-slug');

                currentTransaction.provider = name;
                currentTransaction.providerSlug = slug;

                s3Logo.src = icon;
                s3Title.textContent = name;
                s3HelpText.innerHTML = instruction;

                if (slug.includes('orange')) {
                    otpSection.style.display = 'block';
                    inputOtp.setAttribute('required', 'required');
                    inputPhone.placeholder = "07 07 00 00 00";
                } else {
                    otpSection.style.display = 'none';
                    inputOtp.removeAttribute('required');
                    inputOtp.value = '';
                    if (slug.includes('wave')) inputPhone.placeholder = "07 07 00 00 00";
                    else if (slug.includes('mtn')) inputPhone.placeholder = "05 05 00 00 00";
                    else inputPhone.placeholder = "Numéro de téléphone";
                }
                step2.style.display = 'none';
                step3.style.display = 'block';
            });
        });

        document.getElementById('btn-back-step2').addEventListener('click', function() {
            step3.style.display = 'none';
            step2.style.display = 'block';
        });

        // --- 5. PAIEMENT FINAL ---
        btnPay.addEventListener('click', function() {
            const phoneNumber = inputPhone.value.trim();
            if (phoneNumber === '') {
                inputPhone.classList.add('is-invalid');
                return;
            } else {
                inputPhone.classList.remove('is-invalid');
            }

            let otpValue = '0000';
            if (otpSection.style.display !== 'none') {
                if (inputOtp.value.trim() === '') {
                    inputOtp.classList.add('is-invalid');
                    alert("Veuillez entrer le code OTP / Autorisation.");
                    return;
                }
                inputOtp.classList.remove('is-invalid');
                otpValue = inputOtp.value.trim();
            }

            const originalBtnText = btnPay.innerHTML;
            btnPay.disabled = true;
            btnPay.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';

            try {
                let amountSafe = currentTransaction.amount ? currentTransaction.amount : '0';
                let rawAmount = amountSafe.toString().replace(/[^0-9]/g, '');
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                if (!csrfMeta) throw new Error("Erreur CSRF Token manquant.");
                const csrfToken = csrfMeta.getAttribute('content');

                const payload = {
                    candidat_id: currentTransaction.candidatId,
                    campagne_id: currentTransaction.campagneId || 1,
                    etate_id: currentTransaction.etapeId || 1,
                    quantity: currentTransaction.votes,
                    otpCode: otpValue,
                    email: inputEmail.value,
                    name: inputName.value,
                    amount: parseInt(rawAmount),
                    phoneNumber: phoneNumber,
                    provider: currentTransaction.providerSlug
                };

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
                            throw new Error("Erreur Serveur HTML");
                        return response.json();
                    })
                    .then(data => {
                        bsModal.hide();
                        if (data.success) {
                            // --- DEBUT NOUVELLE LOGIQUE WAVE ---
                            // Si on a une URL de redirection ET que le provider est Wave
                            if (data.redirect_url && currentTransaction.providerSlug === 'wave') {

                                // Afficher un petit message avant de partir (Optionnel mais sympa)
                                const overlay = document.getElementById('processing-overlay');
                                if (overlay) {
                                    overlay.style.display = 'flex';
                                    document.getElementById('processing-message').innerHTML =
                                        "Redirection vers Wave...<br>Veuillez scanner le QR Code.";
                                }

                                // REDIRECTION VERS L'URL EXTERNE WAVE
                                setTimeout(() => {
                                    window.location.href = data.redirect_url;
                                }, 1000); // Petit délai d'1 seconde

                                return; 
                            }// --- FIN NOUVELLE LOGIQUE WAVE ---

                            const overlay = document.getElementById('processing-overlay');
                            const processingMsg = document.getElementById('processing-message');
                            if (overlay) overlay.style.display = 'flex';

                            const maxAttempts = 3;
                            const intervalTime = 30000;
                            let attempts = 0;
                            const transactionId = data.transaction_id;

                            const checkStatus = () => {
                                attempts++;
                                fetch(`/business/paiement/verifier_statut/${transactionId}`)
                                    .then(res => res.json())
                                    .then(statusData => {
                                        if (statusData.status === 'completed') {
                                            processingMsg.textContent = "Paiement validé !";
                                            setTimeout(() => {
                                                if (overlay) {
                                                    const downloadBtn = statusData
                                                        .receipt_url ?
                                                        `<a href="${statusData.receipt_url}" target="_blank" class="btn btn-outline-primary mb-2 w-100" download><i class="fas fa-file-pdf"></i> Reçu</a>` :
                                                        '';

                                                    overlay.innerHTML = `
                                                    <div class="text-success mb-3 animate__animated animate__bounceIn"><i class="fas fa-check-circle fa-5x"></i></div>
                                                    <h3 class="fw-bold text-dark mb-4">Paiement Réussi !</h3>
                                                    <div class="d-flex flex-column align-items-center justify-content-center" style="max-width: 300px; margin: 0 auto;">
                                                        ${downloadBtn}
                                                        <button id="btn-reload-page" class="btn btn-light w-100 fw-bold"><i class="fas fa-arrow-left"></i> Retour au site</button>
                                                    </div>`;

                                                    setTimeout(() => {
                                                        document
                                                            .getElementById(
                                                                'btn-reload-page'
                                                            )
                                                            ?.addEventListener(
                                                                'click',
                                                                () => window
                                                                .location
                                                                .reload());
                                                    }, 100);
                                                }
                                            }, 1000);
                                        } else if (statusData.status === 'failed') {
                                            handleFailure(
                                                "La transaction a été refusée par l'opérateur."
                                            );
                                        } else {
                                            if (attempts < maxAttempts) setTimeout(
                                                checkStatus, intervalTime);
                                            else handleFailure(
                                                "Délai d'attente dépassé. Vérifiez votre solde."
                                            );
                                        }
                                    })
                                    .catch(() => {
                                        if (attempts < maxAttempts) setTimeout(checkStatus,
                                            intervalTime);
                                        else handleFailure("Erreur de connexion.");
                                    });
                            };

                            const handleFailure = (message) => {
                                if (overlay) {
                                    overlay.innerHTML =
                                        `
                                <div class="text-danger mb-4 animate__animated animate__shakeX"><i class="fas fa-times-circle fa-5x"></i></div>
                                <h3 class="fw-bold text-dark">Échec</h3>
                                <p class="text-muted px-3 mx-auto">${message}</p>
                                <button class="btn btn-dark mt-4 px-4 py-2 rounded-pill" onclick="window.location.reload()">Fermer</button>`;
                                } else {
                                    Swal.fire('Échec', message, 'error');
                                }
                            };

                            checkStatus();
                        } else {
                            Swal.fire({
                                title: 'Attention',
                                text: data.message,
                                icon: 'warning'
                            }).then(() => bsModal.show());
                        }
                    })
                    .catch(error => {
                        bsModal.hide();
                        Swal.fire('Erreur technique', "Erreur survenue.", 'error');
                    })
                    .finally(() => {
                        btnPay.disabled = false;
                        btnPay.innerHTML = originalBtnText;
                    });
            } catch (e) {
                btnPay.disabled = false;
                btnPay.innerHTML = originalBtnText;
                alert("Erreur Script : " + e.message);
            }
        });

        // UX validation input
        [inputName, inputEmail, inputPhone, inputOtp].forEach(input => {
            if (input) input.addEventListener('input', function() {
                if (this.value.trim() !== '') this.classList.remove('is-invalid');
            });
        });
    });
</script>
