@extends('siteCampagne.layouts.app')

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
    
    <div class="card shadow-lg border-0 rounded-4 text-center p-5" style="max-width: 500px; width: 100%;">
        
        <div id="status-icon" class="mb-4">
            <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status"></div>
        </div>

        <h2 id="status-title" class="fw-bold mb-3">Vérification en cours...</h2>
        <p id="status-message" class="text-muted mb-4">
            Nous attendons la confirmation de Wave.<br>Ne fermez pas cette page.
        </p>
        
        <div id="action-buttons" class="d-grid gap-2 d-none">
            <a id="btn-receipt" href="#" target="_blank" class="btn btn-outline-primary btn-lg d-none">
                <i class="fas fa-file-pdf me-2"></i> Télécharger le reçu
            </a>
            <a id="btn-back" href="{{ url('/business/site_campagne/'.$idCampagne) }}" class="btn btn-dark btn-lg">
                Retour à la campagne
            </a>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Récupération de l'ID passé par le contrôleur
    const transactionId = "{{ $transactionId }}";
    
    // URL pour vérifier le statut (Adapte la route si besoin)
    // Assure-toi que cette route existe : Route::get('/paiement/verifier_statut/{transactionId}'...)
    const checkUrl = `/business/paiement/verifier_statut/${transactionId}`;
    
    const iconDiv = document.getElementById('status-icon');
    const titleDiv = document.getElementById('status-title');
    const msgDiv = document.getElementById('status-message');
    const btnContainer = document.getElementById('action-buttons');
    const btnReceipt = document.getElementById('btn-receipt');
    const btnBack = document.getElementById('btn-back');

    let attempts = 0;
    const maxAttempts = 100; // Beaucoup de tentatives pour te laisser le temps de changer le statut en BDD
    const intervalTime = 3000; // 3 secondes

    function pollStatus() {
        attempts++;
        console.log(`Polling tentative ${attempts}... ID: ${transactionId}`);

        fetch(checkUrl)
            .then(response => response.json())
            .then(data => {
                console.log("Statut reçu:", data.status);

                if (data.status === 'completed') {
                    showSuccess(data);
                } 
                else if (data.status === 'failed') {
                    showFailure("La transaction a été refusée ou annulée.");
                } 
                else {
                    // PENDING
                    if (attempts < maxAttempts) {
                        setTimeout(pollStatus, intervalTime);
                    } else {
                        showFailure("Délai d'attente dépassé.");
                    }
                }
            })
            .catch(error => {
                console.error("Erreur réseau:", error);
                setTimeout(pollStatus, intervalTime); // On continue même si erreur réseau temporaire
            });
    }

    function showSuccess(data) {
        iconDiv.innerHTML = `<div class="text-success animate__animated animate__bounceIn"><i class="fas fa-check-circle fa-6x"></i></div>`;
        titleDiv.textContent = "Paiement Réussi !";
        msgDiv.textContent = "Merci pour votre vote. Transaction validée.";
        
        btnContainer.classList.remove('d-none');
        // btnBack.href = data.campagne_url;
        
        if(data.receipt_url) {
            btnReceipt.href = data.receipt_url;
            btnReceipt.classList.remove('d-none');
        }
        
        // // Redirection auto optionnelle
        // setTimeout(() => window.location.href = data.campagne_url, 3000);
    }

    function showFailure(message) {
        iconDiv.innerHTML = `<div class="text-danger animate__animated animate__shakeX"><i class="fas fa-times-circle fa-6x"></i></div>`;
        titleDiv.textContent = "Paiement Échoué";
        msgDiv.textContent = message;
        
        btnContainer.classList.remove('d-none');
        btnBack.href = "{{ url('/business/site_campagne/'.$idCampagne) }}"; 
        btnBack.textContent = "Retour à la campagne";
    }

    // Lancement
    pollStatus();
});
</script>
@endsection