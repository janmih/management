<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('profile.edit', Auth::user()->id) }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <x-nav-link :route="route('home')" icon="fas fa-th" color="#795458">{{ __('Dashboard') }} </x-nav-link>
            <x-nav-link-dropdown title="Ressource Humaine" icon="fa-solid fa-people-roof" color="#F7C566"
                :route="[
                    route('services.index'),
                    route('personnels.index'),
                    route('conge-cumules.index'),
                    route('repos-medicals.index'),
                    route('missions.index'),
                    route('conge-prises.index'),
                    route('autorisation-absences.index'),
                ]">
                <x-nav-link :route="route('services.index')" icon="fas fa-layer-group" color="#F7C566">{{ __('Services') }}
                </x-nav-link>
                <x-nav-link :route="route('personnels.index')" icon="fas fa-users-gear" color="#F7C566">{{ __('Personnels') }}
                </x-nav-link>
                <x-nav-link :route="route('conge-cumules.index')" icon="fas fa-clipboard"
                    color="#F7C566">{{ __('Congés cumulé par année') }}
                </x-nav-link>
                <x-nav-link :route="route('repos-medicals.index')" icon="fas fa-notes-medical" color="#F7C566">{{ __('Repos médical') }}
                </x-nav-link>
                <x-nav-link :route="route('missions.index')" icon="fas fa-paper-plane" color="#F7C566">{{ __('Missions') }}
                </x-nav-link>

                <x-nav-link :route="route('conge-prises.index')" icon="fa-brands fa-squarespace" color="#F7C566">{{ __('Congé') }}
                </x-nav-link>
                <x-nav-link :route="route('autorisation-absences.index')" icon="fa-solid fa-school"
                    color="#F7C566">{{ __('Autorisation d\'absence') }}
                </x-nav-link>
            </x-nav-link-dropdown>

            <x-nav-link-dropdown icon="fas fa-toolbox nav-icon" color="#E59BE9" :route="[
                route('articles.index'),
                route('etat-stocks.index'),
                route('demande-articles.index'),
                route('sortie-articles.index'),
                route('liste-bons.index'),
            ]"
                title="Gestion de stock">
                <x-nav-link :route="route('articles.index')" icon="fa-solid fa-shapes"
                    color="#E59BE9">{{ __('Stock materiel') }}</x-nav-link>
                <x-nav-link :route="route('etat-stocks.index')" icon="fa-solid  fa-square-poll-horizontal"
                    color="#E59BE9">{{ __('Etat stock') }}</x-nav-link>
                <x-nav-link :route="route('demande-articles.index')" icon="fa-solid  fa-boxes-stacked"
                    color="#E59BE9">{{ __('Demande articles') }}</x-nav-link>
                {{-- <x-nav-link :route="route('sortie-articles.index')" icon="fa-solid  fa-boxes-stacked"
                    color="#E59BE9">{{ __('Sortie articles') }}</x-nav-link> --}}
                <x-nav-link :route="route('liste-bons.index')" icon="fa-solid  fa-cubes"
                    color="#E59BE9">{{ __('Liste des bons') }}</x-nav-link>
            </x-nav-link-dropdown>
            @hasrole('Super Admin')
                <x-nav-link-dropdown icon="fas fa-toolbox nav-icon" color="#D862BC" :route="[
                    route('users.index'),
                    route('roles.index'),
                    route('permissions.index'),
                    route('model-has-roles.index'),
                ]" title="Admin">
                    <x-nav-link :route="route('users.index')" icon="fa-solid fa-users-viewfinder"
                        color="#D862BC">{{ __('Utilisateurs') }}
                    </x-nav-link>
                    <x-nav-link :route="route('roles.index')" icon="fa-solid fa-user-lock"
                        color="#D862BC">{{ __('Gestion des roles') }}
                    </x-nav-link>
                    <x-nav-link :route="route('permissions.index')" icon="fa-solid fa-user-gear"
                        color="#D862BC">{{ __('Gestion des permissions') }}
                    </x-nav-link>
                    <x-nav-link :route="route('model-has-roles.index')" icon="fa-solid fa-people-arrows"
                        color="#D862BC">{{ __('Roles des utilisateurs') }}
                    </x-nav-link>
                </x-nav-link-dropdown>
            @endhasrole
            <x-nav-link :route="route('cotisation-socials.index')" icon="fa-solid fa-money-bill-alt" color="#8644A2">{{ __('Cotisations') }}
            </x-nav-link>
            <x-nav-link :route="route('cotisation-social-mensuels.index')" icon="fa-solid fa-cash-register"
                color="#90D26D">{{ __('Cotisations mensuels') }}
            </x-nav-link>
            <x-nav-link :route="route('contacts.index')" icon="fa-solid fa-envelope-open"
                color="#2C7865">{{ __('Envoyer un email') }}
            </x-nav-link>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
