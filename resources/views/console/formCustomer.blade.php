@php
/**
 * Formulaire de création / édition d'un `customer`.
 * Usage: inclure cette vue dans un layout qui charge Bootstrap 5 & jQuery.
 * - Attendre une variable `$customer` pour l'édition (ou null pour création)
 * - Assurez-vous que la route de soumission existe et accepte `multipart/form-data` pour le `logo`.
 */
@endphp

@extends('layout.header.console')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-3">{{ isset($customer) ? 'Modifier le client' : 'Créer un client' }}</h4>

            <form action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($customer))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">ID client</label>
                        <input type="text" name="customer_id" class="form-control @error('customer_id') is-invalid @enderror" value="{{ old('customer_id', $customer->customer_id ?? '') }}" placeholder="Ex: CUST-001">
                        @error('customer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Entreprise</label>
                        <input type="text" name="entreprise" class="form-control @error('entreprise') is-invalid @enderror" value="{{ old('entreprise', $customer->entreprise ?? '') }}" placeholder="Nom de l'entreprise">
                        @error('entreprise')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Pays (siège)</label>
                        <input type="text" name="pays_siege" class="form-control @error('pays_siege') is-invalid @enderror" value="{{ old('pays_siege', $customer->pays_siege ?? '') }}" placeholder="France">
                        @error('pays_siege')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $customer->email ?? '') }}" placeholder="contact@entreprise.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="phonenumber" class="form-control @error('phonenumber') is-invalid @enderror" value="{{ old('phonenumber', $customer->phonenumber ?? '') }}" placeholder="+33 6 12 34 56 78">
                        @error('phonenumber')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Adresse</label>
                        <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror" value="{{ old('adresse', $customer->adresse ?? '') }}" placeholder="Adresse complète">
                        @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Site web</label>
                        <input type="url" name="link_website" class="form-control @error('link_website') is-invalid @enderror" value="{{ old('link_website', $customer->link_website ?? '') }}" placeholder="https://example.com">
                        @error('link_website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">LinkedIn</label>
                        <input type="url" name="link_linkedin" class="form-control @error('link_linkedin') is-invalid @enderror" value="{{ old('link_linkedin', $customer->link_linkedin ?? '') }}" placeholder="https://www.linkedin.com/company/...">
                        @error('link_linkedin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Réseaux sociaux</label>
                        <div class="row g-2">
                            <div class="col-12 col-sm-6 col-md-3">
                                <input type="url" name="link_facebook" class="form-control @error('link_facebook') is-invalid @enderror" value="{{ old('link_facebook', $customer->link_facebook ?? '') }}" placeholder="Facebook">
                                @error('link_facebook')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <input type="url" name="link_instagram" class="form-control @error('link_instagram') is-invalid @enderror" value="{{ old('link_instagram', $customer->link_instagram ?? '') }}" placeholder="Instagram">
                                @error('link_instagram')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <input type="url" name="link_twitter" class="form-control @error('link_twitter') is-invalid @enderror" value="{{ old('link_twitter', $customer->link_twitter ?? '') }}" placeholder="Twitter">
                                @error('link_twitter')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <input type="url" name="link_youtube" class="form-control @error('link_youtube') is-invalid @enderror" value="{{ old('link_youtube', $customer->link_youtube ?? '') }}" placeholder="YouTube">
                                @error('link_youtube')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Logo</label>
                        <div class="d-flex align-items-center gap-3">
                            <div>
                                <img id="logoPreview" src="{{ isset($customer) && $customer->logo ? asset('storage/' . $customer->logo) : asset('assets/img/logo.png') }}" alt="logo" class="rounded border" style="width:80px;height:80px;object-fit:cover">
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="logo" id="logoInput" accept="image/*" class="form-control @error('logo') is-invalid @enderror">
                                @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="text-muted">Taille recommandée 400x400px — formats: jpg, png</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Données supplémentaires</label>
                        <textarea name="data" rows="4" class="form-control @error('data') is-invalid @enderror" placeholder='JSON ou texte libre'>{{ old('data', $customer->data ?? '') }}</textarea>
                        @error('data')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-4 d-flex align-items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', isset($customer) ? ($customer->is_active ? 'checked' : '') : 'checked') ? 'checked' : '' }}>
                            <label class="form-check-label ms-2" for="is_active">Actif</label>
                        </div>
                    </div>

                    <div class="col-12 text-end">
                        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary">{{ isset($customer) ? 'Mettre à jour' : 'Enregistrer' }}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Aperçu logo & petit init JS pour Select2 si présent --}}
@push('scripts')
<script>
    (function(){
        // Aperçu logo
        const logoInput = document.getElementById('logoInput');
        const logoPreview = document.getElementById('logoPreview');
        if (logoInput && logoPreview) {
            logoInput.addEventListener('change', function(e){
                const file = e.target.files && e.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function(ev){
                    logoPreview.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        // Init Select2 fallback (si le template charge select2)
        if (window.jQuery && jQuery().select2) {
            jQuery(document).ready(function(){
                jQuery('.select').each(function(){
                    if (!jQuery(this).hasClass('select2-initialized')){
                        try { jQuery(this).select2({ minimumResultsForSearch: -1, width: '100%' }); jQuery(this).addClass('select2-initialized'); } catch(e){}
                    }
                });
            });
        }
    })();
</script>
@endpush

@endsection
