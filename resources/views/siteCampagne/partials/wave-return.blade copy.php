@extends('layouts.app') 

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
    
    <!-- Carte Centrée -->
    <div class="card shadow-lg border-0 rounded-4 text-center p-5" style="max-width: 500px; width: 100%;">
        
        <!-- Zone de Statut Dynamique -->
        <div id="status-icon" class="mb-4">
            <!-- Spinner par défaut -->
            <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status"></div>
        </div>

        <h2 id="status-title" class="fw-bold mb-3">Vérification en cours...</h2>
        <p id="status-message" class="text-muted mb-4">
            Nous attendons la confirmation de Wave.<br>Ne fermez pas cette page.
        </p>
        
        <!-- Zone Boutons (Cachée au début) -->
        <div id="action-buttons" class="d-grid gap-2 d-none">
            <a id="btn-receipt" href="#" target="_blank" class="btn btn-outline-primary btn-lg d-none">
                <i class="fas fa-file-pdf me-2"></i> Télécharger le reçu
            </a>
            <a id="btn-back" href="#" class="btn btn-dark btn-lg">
                Retour à la campagne
            </a>
        </div>

    </div>
</div>

<!-- SCRIPT DE POLLING -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const transactionId = "{{ $transactionId }}";
    const checkUrl = "{{ route('business.verifyPaymentVote', ['transactionId' => ':id']) }}".replace(':id', transactionId);
    
    // Éléments du DOM
    const iconDiv = document.getElementById('status-icon');
    const titleDiv = document.getElementById('status-title');
    const msgDiv = document.getElementById('status-message');
    const btnContainer = document.getElementById('action-buttons');
    const btnReceipt = document.getElementById('btn-receipt');
    const btnBack = document.getElementById('btn-back');

    // Configuration Polling
    let attempts = 0;
    const maxAttempts = 10; // On insiste plus longtemps au retour de Wave (ex: 30-40 sec)
    const intervalTime = 4000; // 4 secondes

    function pollStatus() {
        attempts++;
        console.log(`Tentative ${attempts}...`);

        fetch(checkUrl)
            .then(response => response.json())
            .then(data => {
                
                if (data.status === 'completed') {
                    // --- SUCCÈS ---
                    showSuccess(data);
                } 
                else if (data.status === 'failed') {
                    // --- ÉCHEC ---
                    showFailure("La transaction a été refusée ou annulée.");
                } 
                else {
                    // --- PENDING ---
                    if (attempts < maxAttempts) {
                        setTimeout(pollStatus, intervalTime);
                    } else {
                        // Timeout
                        showFailure("Délai d'attente dépassé. Si vous avez été débité, contactez le support.");
                    }
                }
            })
            .catch(error => {
                console.error("Erreur réseau:", error);
                if (attempts < maxAttempts) setTimeout(pollStatus, intervalTime);
                else showFailure("Erreur de connexion serveur.");
            });
    }

    function showSuccess(data) {
        // Icone Vert
        iconDiv.innerHTML = `<div class="text-success animate__animated animate__bounceIn"><i class="fas fa-check-circle fa-6x"></i></div>`;
        titleDiv.textContent = "Paiement Réussi !";
        msgDiv.textContent = "Merci pour votre vote. Transaction validée.";
        
        // Boutons
        btnContainer.classList.remove('d-none');
        btnBack.href = data.campagne_url;
        
        if(data.receipt_url) {
            btnReceipt.href = data.receipt_url;
            btnReceipt.classList.remove('d-none');
            // Ouverture auto du PDF (optionnel)
            // window.open(data.receipt_url, '_blank');
        }

        // Redirection auto après 3 secondes
        setTimeout(() => {
            window.location.href = data.campagne_url;
        }, 3000);
    }

    function showFailure(message) {
        // Icone Rouge
        iconDiv.innerHTML = `<div class="text-danger animate__animated animate__shakeX"><i class="fas fa-times-circle fa-6x"></i></div>`;
        titleDiv.textContent = "Paiement Échoué";
        msgDiv.textContent = message;
        
        // Bouton Retour
        btnContainer.classList.remove('d-none');
        // On redirige vers l'accueil ou la campagne par défaut si on l'a
        btnBack.href = "{{ url('/') }}"; 
        btnBack.textContent = "Réessayer";
    }

    // Lancement immédiat
    pollStatus();
});
</script>
@endsection