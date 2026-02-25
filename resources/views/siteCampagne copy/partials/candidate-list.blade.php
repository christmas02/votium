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
                            {{ $candidat->vote_percentage }}% <small>votes</small>
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
