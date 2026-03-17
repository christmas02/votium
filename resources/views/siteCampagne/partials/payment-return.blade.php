@extends('siteCampagne.layouts.app-wave-return')

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card shadow-lg border-0 rounded-4 text-center p-5" style="max-width: 500px; width: 100%;">

        <div id="status-icon" class="mb-4">
            <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status"></div>
        </div>

        <h2 id="status-title" class="fw-bold mb-3">Vérification en cours...</h2>
        <p id="status-message" class="text-muted mb-4">
            Nous vérifions votre paiement.<br>Ne fermez pas cette page.
        </p>

        <div id="action-buttons" class="d-grid gap-2 d-none">
            <a id="btn-receipt" href="#" target="_blank" class="btn btn-outline-primary btn-lg d-none">
                <i class="fas fa-file-pdf me-2"></i> Télécharger le reçu
            </a>
            <a id="btn-back"
               href="{{ route('business.site_campagne', ['idCampagne' => $idCampagne]) }}"
               class="btn btn-dark btn-lg">
                Retour à la campagne
            </a>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    //Routes Blade de vérification de paiement (API)
    const checkUrl = "{{ route('business.paymentVerify', ['transactionId' => $transactionId]) }}";

    const iconDiv      = document.getElementById('status-icon');
    const titleDiv     = document.getElementById('status-title');
    const msgDiv       = document.getElementById('status-message');
    const btnContainer = document.getElementById('action-buttons');
    const btnReceipt   = document.getElementById('btn-receipt');

    const maxAttempts = 3;
    const intervalTime = 15000; // 15s
    let attempts = 0;

    function pollStatus() {
        attempts++;
        console.log(`Polling tentative ${attempts} — Transaction : {{ $transactionId }}`);

        fetch(checkUrl)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.status === 'completed') {
                    showSuccess(data);
                } else if (data.status === 'failed') {
                    showFailure("La transaction a été refusée ou annulée.");
                } else {
                    // PENDING
                    if (attempts < maxAttempts) {
                        setTimeout(pollStatus, intervalTime);
                    } else {
                        showFailure("Délai d'attente dépassé. Vérifiez votre solde ou contactez le support.");
                    }
                }
            })
            .catch(error => {
                console.error("Erreur réseau :", error);
                //attempts est bien incrémenté → pas de boucle infinie
                if (attempts < maxAttempts) {
                    setTimeout(pollStatus, intervalTime);
                } else {
                    showFailure("Erreur de connexion lors de la vérification.");
                }
            });
    }

    function showSuccess(data) {
        iconDiv.innerHTML = `
            <div class="text-success animate__animated animate__bounceIn">
                <i class="fas fa-check-circle fa-6x"></i>
            </div>`;
        titleDiv.textContent = "Paiement Réussi !";
        msgDiv.textContent   = "Merci pour votre vote. Transaction validée.";

        if (data.receipt_url) {
            btnReceipt.href = data.receipt_url;
            btnReceipt.classList.remove('d-none');
        }

        btnContainer.classList.remove('d-none');
    }

    function showFailure(message) {
        iconDiv.innerHTML = `
            <div class="text-danger animate__animated animate__shakeX">
                <i class="fas fa-times-circle fa-6x"></i>
            </div>`;
        titleDiv.textContent = "Paiement Échoué";
        msgDiv.textContent   = message;

        btnContainer.classList.remove('d-none');
    }

    pollStatus();
});
</script>
@endsection