<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('dashboard')}}">
            <div class="logo-img">
                <img height="30" src="{{ asset('img/logo_white.png')}}" class="header-brand-img" title="RADMIN">
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ ($segment1 == 'dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}"><i class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard')}}</span></a>
                </div>
                <div class="nav-item {{ ($segment1 == 'users' || $segment1 == 'roles'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-user"></i><span>{{ __('Administration')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('users')}}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('Users')}}</a>
                        <a href="{{url('user/create')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add User')}}</a>
                         @endcan
                         <!-- only those have manage_role permission will get access -->
                        @can('manage_roles')
                        <a href="{{url('roles')}}" class="menu-item {{ ($segment1 == 'roles') ? 'active' : '' }}">{{ __('Roles')}}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->
                        @can('manage_permission')
                        <a href="{{url('permission')}}" class="menu-item {{ ($segment1 == 'permission') ? 'active' : '' }}">{{ __('Permission')}}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->
                        @can('manage_permission')
                        <a href="{{url('category')}}" class="menu-item {{ ($segment1 == 'category') ? 'active' : '' }}">{{ __('Category')}}</a>
                        @endcan
                    </div>
                </div>
                <div class="nav-item {{ ($segment1 == 'tenants') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-layout"></i><span>{{ __('Tenants')}}</span></a>
                    <div class="submenu-content">
                        <a href="{{url('tenant/create')}}" class="menu-item {{ ($segment1 == 'tenants' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add Tenant')}}</a>
                        <a href="{{url('tenants')}}" class="menu-item {{ ($segment1 == 'tenants' && $segment2 == '') ? 'active' : '' }}">{{ __('List Tenants')}}</a>
                    </div>
                </div>
                <div class="nav-item">
                    <a href="{{url('plans')}}"><i class="ik ik-airplay"></i><span>{{ __('Plans')}}</span></a>
                </div>
                <div class="nav-item">
                    <a href="#"><i class="ik ik-archive"></i><span>{{ __('Subscriptions')}}</span></a>
                </div>
                <div class="nav-item">
                    <a href="#"><i class="ik ik-file-text"></i><span>{{ __('Invoices')}}</span></a>
                </div>
                <div class="nav-item">
                    <a href="#"><i class="ik ik-credit-card"></i><span>{{ __('Transactions')}}</span></a>
                </div>
                <div class="nav-item">
                    <a href="#"><i class="ik ik-server"></i><span>{{ __('Gateways')}}</span></a>
                </div>
                <div class="nav-item">
                    <a href="{{url('logout')}}"><i class="ik ik-power"></i><span>{{ __('Logout')}}</span></a>
                </div>
            </nav>
        </div>
    </div>
</div>
