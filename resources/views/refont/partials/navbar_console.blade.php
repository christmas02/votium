{{-- =====================================================
     REFONT NAVBAR CONSOLE — Administration Votium
     Usage : @include('refont.partials.navbar_console')
     ===================================================== --}}
<nav class="vt-navbar">
    <div class="vt-navbar-inner">

        {{-- Logo + Espace --}}
        <div class="vt-navbar-brand">
            <div class="vt-logo-circle">V</div>
            <div class="vt-brand-text">
                <span class="vt-brand-name">VOTIUM</span>
                <span class="vt-brand-sub">Espace admin</span>
            </div>
        </div>

        {{-- Navigation centrale --}}
        <ul class="vt-nav-links">
            <li class="{{ request()->routeIs('console.espace') ? 'active' : '' }}">
                <a href="{{ route('console.espace') }}">
                    <i class="ti ti-home"></i> Accueil
                </a>
            </li>
            <li class="{{ request()->routeIs('console.list_customer') || request()->routeIs('console.detail_customer') ? 'active' : '' }}">
                <a href="{{ route('console.list_customer') }}">
                    <i class="ti ti-users"></i> Clients
                </a>
            </li>
            <li class="{{ request()->routeIs('console.list_campagne') ? 'active' : '' }}">
                <a href="{{ route('console.list_campagne') }}">
                    <i class="ti ti-calendar-event"></i> Sessions
                </a>
            </li>
            <li class="{{ request()->routeIs('console.profile') ? 'active' : '' }}">
                <a href="{{ route('console.profile') }}">
                    <i class="ti ti-settings"></i> Paramètres
                </a>
            </li>
        </ul>

        {{-- Bouton profil Admin --}}
        <div class="vt-navbar-right">
            <div class="dropdown">
                <button class="vt-promoteur-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name ?? 'Admin' }}
                    <span class="vt-promoteur-avatar"
                          style="background:#fff2e0; color:var(--vt-orange); font-weight:700; font-size:12px;
                                 display:inline-flex; align-items:center; justify-content:center;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('console.profile') }}">
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
