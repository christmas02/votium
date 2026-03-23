@php
    $packages = isset($selectedEtape->package) ? json_decode($selectedEtape->package) : [];
    $modalId = 'voteModal-' . $candidat->candidat_id; // ID unique pour la modale
@endphp

{{-- 1. LA CARTE DU CANDIDAT --}}
<article class="card">
    <div class="coverimg">
        @if ($candidat->photo)
            <div class="thumb"
                style="background-image: url('{{ asset(env('IMAGES_PATH') . '/' . $candidat->photo) }}'); background-size: cover; background-position: center top;">
            </div>
        @else
            <div class="thumb" style="background: linear-gradient(135deg, var(--primary), #000);"></div>
        @endif
        <div class="tag"><span class="dot"></span>#{{ $candidat->numero_candidat }}</div>
    </div>

    <div class="body">
        <div class="name">{{ $candidat->name }}</div>
        <div class="sub">Candidat(e) / Nominé(e)</div>
        <div class="sub">Vote{{ $candidat->votes_count > 1 ? 's' : '' }}</div>
        <div class="form-check p-2 rounded d-flex align-items-center gap-2" style="background-color: rgba(0,0,0,0.03);">
            @if ($campagne->afficher_montant_pourcentage == 'pourcentage')
                {{ $candidat->vote_percentage }}%
            @elseif($campagne->afficher_montant_pourcentage == 'clair')
                {{ $candidat->votes_count }} vote{{ $candidat->votes_count > 1 ? 's' : '' }}
            @else
                {{ $candidat->votes_count }} vote{{ $candidat->votes_count > 1 ? 's' : '' }} /
                {{ $candidat->vote_percentage }}%
            @endif
        </div>

    </div>

    <div class="actions">
        <button class="iconbtn" type="button" aria-label="Partager"
            onclick="shareCandidate('{{ addslashes($candidat->name) }}', '{{ $candidat->numero_candidat }}', '{{ $candidat->candidat_id }}')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 12v8a2 2 0 002 2h12a2 2 0 002-2v-8m-4-6l-4-4-4 4m4-4v13" />
            </svg>
        </button>

        {{-- BOUTON VOTER : Ouvre la modale spécifique via son ID unique --}}
        <button class="vote" type="button" onclick="openSpecificModal('{{ $modalId }}')">
            Voter
        </button>
    </div>
</article>

{{-- 2. LA MODALE SPÉCIFIQUE AU CANDIDAT (Générée par Blade) --}}
<div aria-hidden="true" class="modal" id="{{ $modalId }}" data-candidat-id="{{ $candidat->candidat_id }}">
    <div class="modal__overlay"></div>
    <div class="modal__panel" role="dialog">
        <button class="modal__close" onclick="closeSpecificModal('{{ $modalId }}')">✕</button>

        <div class="voteModal__hero">
            <div class="voteModal__posterWrap">
                @if ($candidat->photo)
                    <img src="{{ asset(env('IMAGES_PATH') . '/' . $candidat->photo) }}" class="voteModal__poster"
                        alt="{{ $candidat->name }}">
                @else
                    <div style="width:100%;height:200px;background:linear-gradient(135deg, var(--primary), #000);">
                    </div>
                @endif
            </div>
        </div>

        <div class="voteModal__content">
            <div class="voteModal__meta">
                <h3 class="voteModal__name">{{ $candidat->name }}</h3>
                <div class="voteModal__sub">
                    <span id="voteModalRole">Candidat(e)</span>
                    <span class="dot">•</span>
                    <span>Numéro:</span> <strong> #{{ $candidat->numero_candidat }}</strong>
                </div>
            </div>

            {{-- Liste des packs générée par Blade --}}
            <div class="voteModal__packs">
                @forelse($packages as $index => $pack)
                    <button type="button" class="packRow {{ $index === 0 ? 'is-selected' : '' }}"
                        onclick="selectPackInModal('{{ $modalId }}', {{ $pack->vote }}, {{ $pack->montant }}, this)">
                        <span class="packRow__left"><strong>{{ $pack->vote }}</strong> Votes</span>
                        <span class="packRow__right">{{ number_format($pack->montant, 0, ',', ' ') }} <span
                                class="cur">Fcfa</span></span>
                    </button>
                @empty
                    <div class="text-center p-3 text-muted">Aucun pack disponible</div>
                @endforelse
            </div>

            <div class="voteModal__actions">
                <button class="iconbtn" type="button" aria-label="Partager"
                    onclick="shareCandidate('{{ addslashes($candidat->name) }}', '{{ $candidat->numero_candidat }}', '{{ $candidat->candidat_id }}')">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M18 8a3 3 0 1 0-2.8-4" stroke="var(--primary)" stroke-width="1.8"
                            stroke-linecap="round" />
                        <path d="M6 14a3 3 0 1 0 2.8 4" stroke="var(--primary)" stroke-width="1.8"
                            stroke-linecap="round" />
                        <path d="M8.5 13.2l7-3.7M8.5 14.8l7 3.7" stroke="var(--primary)" stroke-width="1.8"
                            stroke-linecap="round" />
                    </svg>
                </button>

                {{-- Le bouton stocke les infos du pack par défaut (le premier) --}}
                @php $firstPack = $packages[0] ?? null; @endphp
                <button class="primaryBtn btn-validate-vote" type="button" id="btn-{{ $modalId }}"
                    data-candidat-id="{{ $candidat->candidat_id }}" data-campagne-id="{{ $candidat->campagne_id }}"
                    data-etape-id="{{ $candidat->etape_id }}" data-candidat-nom="{{ $candidat->name }}"
                    data-candidat-num="{{ $candidat->numero_candidat }}"
                    data-pack-votes="{{ $firstPack ? $firstPack->vote : 0 }}"
                    data-pack-montant="{{ $firstPack ? $firstPack->montant : 0 }}" onclick="proceedToCheckout(this)"
                    {{ empty($packages) ? 'disabled' : '' }}>
                    Voter • {{ $firstPack ? number_format($firstPack->montant, 0, ',', ' ') : '0' }} Fcfa
                </button>
            </div>
        </div>
    </div>
</div>
