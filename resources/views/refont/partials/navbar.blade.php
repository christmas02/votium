{{-- =====================================================
     REFONT NAVBAR - Barre de navigation horizontale Votium
     Usage : @include('refont.partials.navbar')
     Variables attendues : aucune (utilise Auth::user())
     ===================================================== --}}
<nav class="vt-navbar">
    <div class="vt-navbar-inner">

        {{-- Logo + Espace --}}
        <div class="vt-navbar-brand">
            <div class="vt-logo-circle">V</div>
            <div class="vt-brand-text">
                <span class="vt-brand-name">VOTIUM</span>
                <span class="vt-brand-sub">Espace promoteur</span>
            </div>
        </div>

        {{-- Navigation centrale --}}
        <ul class="vt-nav-links">
            <li class="{{ request()->routeIs('business.espace') ? 'active' : '' }}">
                <a href="{{ route('business.espace') }}">
                    <i class="ti ti-home"></i> Accueil
                </a>
            </li>
            <li class="{{ request()->routeIs('business.*_campagne') ? 'active' : '' }}">
                <a href="{{ route('business.list_campagne') }}">
                    <i class="ti ti-calendar-event"></i> Sessions
                </a>
            </li>
            <li class="{{ request()->routeIs('business.*_candidat') ? 'active' : '' }}">
                <a href="{{ route('business.list_candidat') }}">
                    <i class="ti ti-users"></i> Candidats
                </a>
            </li>
            <li class="{{ request()->routeIs('business.*_vote') ? 'active' : '' }}">
                <a href="{{ route('business.list_vote') }}">
                    <i class="ti ti-ticket"></i> Votes
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="vt-nav-disabled">
                    <i class="ti ti-building-store"></i> Billetterie
                </a>
            </li>
            <li class="{{ request()->routeIs('business.*_retrait') ? 'active' : '' }}">
                <a href="{{ route('business.list_retrait') }}">
                    <i class="ti ti-cash"></i> Retraits
                </a>
            </li>
            <li class="{{ request()->routeIs('business.profile') ? 'active' : '' }}">
                <a href="{{ route('business.profile') }}">
                    <i class="ti ti-settings"></i> Paramètres
                </a>
            </li>
        </ul>

        {{-- Bouton profil Promoteur --}}
        <div class="vt-navbar-right">
            <div class="dropdown">
                <button class="vt-promoteur-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name ?? 'Promoteur' }}
                    <img src="{{ asset(env('IMAGES_PATH') . '/' . (Auth::user()->customer->logo ?? 'default-logo.png')) }}"
                         class="vt-promoteur-avatar" alt="avatar">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('business.profile') }}">
                            <i class="ti ti-user-circle me-2"></i> Profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                            <i class="ti ti-logout me-2"></i> Se déconnecter
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>
