<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            {{-- <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="nav-icon fas fa-th" style="color: #AE445A"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li> --}}
            <x-nav-link :route="route('home')" icon="fas fa-th" color="#AE445A">{{ __('Dashboard') }} </x-nav-link>
            @can('services.manage')
                <x-nav-link :route="route('services.index')" icon="fas fa-layer-group" color="#F39F5A">{{ __('Services') }} </x-nav-link>
            @endcan
            @can('personnels.manage')
                <x-nav-link :route="route('personnels.index')" icon="fas fa-users-gear" color="#756AB6">{{ __('Personnels') }}
                </x-nav-link>
                <x-nav-link :route="route('conge-cumules.index')" icon="fas fa-clipboard" color="#AC87C5">{{ __('Congés cumulé par année') }}
                </x-nav-link>
                <x-nav-link :route="route('repos-medicals.index')" icon="fas fa-notes-medical" color="#E0AED0">{{ __('Repos médical') }}
                </x-nav-link>
                <x-nav-link :route="route('missions.index')" icon="fas fa-paper-plane" color="#FFE5E5">{{ __('Missions') }}
                </x-nav-link>
                <x-nav-link :route="route('cotisation-socials.index')" icon="fa-solid fa-wallet" color="#7ED7C1">{{ __('Cotisations') }}
                </x-nav-link>
                <x-nav-link :route="route('conge-prises.index')" icon="fa-brands fa-squarespace" color="#65B741">{{ __('Congé') }}
                </x-nav-link>
                <x-nav-link :route="route('autorisation-absences.index')" icon="fa-solid fa-school" color="#F3B95F">{{ __('Autorisation d\'absence') }}
                </x-nav-link>
            @endcan
            <x-nav-link :route="route('users.index')" icon="fa-regular fa-folder-open" color="#FFF8C9">{{ __('Utilisateurs') }}
            </x-nav-link>
            <x-nav-link-dropdown :route="[route('articles.index'), route('etat-stocks.index')]">
                <x-nav-link :route="route('articles.index')" icon="fa-solid fa-shapes"
                    color="#FE7A36">{{ __('Stock materiel') }}</x-nav-link>
                <x-nav-link :route="route('etat-stocks.index')" icon="fa-solid  fa-square-poll-horizontal"
                    color="#FF9BD2">{{ __('Etat stock') }}</x-nav-link>
                <x-nav-link :route="route('demande-articles.index')" icon="fa-solid  fa-square-poll-horizontal"
                    color="#FF9BD2">{{ __('Demande articles') }}</x-nav-link>
                {{-- <x-nav-link :route="route('sortie-articles.index')" icon="fa-solid  fa-square-poll-horizontal"
                    color="#FF9BD2">{{ __('Sortie articles') }}</x-nav-link> --}}
                @can('article.manage')
                    <x-nav-link :route="route('liste-bons.index')" icon="fa-solid  fa-square-poll-horizontal"
                        color="#FF9BD2">{{ __('Liste des bons') }}</x-nav-link>
                @endcan
            </x-nav-link-dropdown>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
