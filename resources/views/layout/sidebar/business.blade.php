<div class="sidebar" id="sidebar">
    <!-- Start Logo -->
    <div class="sidebar-logo">
        <div>
            <!-- Logo Normal -->
            <a href="/" class="logo logo-normal">
                <img src="{{ asset('assets/img/logos/votium.png') }}" width="150" alt="Logo">
            </a>

            <!-- Logo Small -->
            <a href="index.html" class="logo-small">
                <img src="{{ asset('assets/img/logo-small.svg') }}" alt="Logo">
            </a>

            <!-- Logo Dark -->
            <a href="index.html" class="dark-logo">
                <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Logo">
            </a>
        </div>
        <button class="sidenav-toggle-btn btn border-0 p-0 active" id="toggle_btn">
            <i class="ti ti-arrow-bar-to-left"></i>
        </button>

        <!-- Sidebar Menu Close -->
        <button class="sidebar-close">
            <i class="ti ti-x align-middle"></i>
        </button>
    </div>
    <!-- End Logo -->

    <!-- Sidenav Menu -->
    <div class="sidebar-inner" data-simplebar>
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"><span>Navigations</span></li>
                <li>
                    <ul>
                        <li class="{{ request()->routeIs('espace') ? 'active' : '' }}">

                            <a href="{{ route('business.espace') }}">
                                <i class="ti ti-dashboard"></i><span>Tableau de bord</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('*_campagne') ? 'active' : '' }}">
                            <a href="{{ route('business.list_campagne') }}">
                                <i class="ti ti-brand-campaignmonitor"></i><span>Campagnes</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('*_candidat') ? 'active' : '' }}">
                            <a href="{{ route('business.list_candidat') }}">
                                <i class="ti ti-user-up"></i><span>Candidats</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('*_vote') ? 'active' : '' }}">
                            <a href="{{ route('business.list_vote') }}">
                                <i class="ti ti-ticket"></i><span>Votes</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('*_retrait') ? 'active' : '' }}">
                            <a href="{{ route('business.list_retrait') }}">
                                <i class="ti ti-report-money"></i><span>Retraits</span>
                            </a>
                        </li>
                        
                        <!-- <li><a href="tickets.html"><i class="ti ti-ticket"></i><span>Billeterie</span></a></li> -->

                    </ul>
                </li>
            </ul>
        </div>
    </div>

</div>