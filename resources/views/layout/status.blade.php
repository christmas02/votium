@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    <strong>Succès — </strong> {{ Session::get('success') }}
</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    <strong>Erreur — </strong> {{ Session::get('error') }}
</div>
@endif

@if(Session::has('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    <strong>Attention — </strong> {{ Session::get('warning') }}
</div>
@endif