<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show" style="background-color: #00174d;">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('package_access')
            <li class="c-sidebar-nav-dropdown  {{ request()->is("admin/packages*") ? "c-show" : "" }} {{ request()->is("admin/package-items*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fas fa-box c-sidebar-nav-icon">

                    </i>
                    PACKAGE MANAGEMENT
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('package_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.packages.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/packages") || request()->is("admin/packages/*") ? "c-active" : "" }}">
                                <i class="fas fa-box-open c-sidebar-nav-icon">

                                </i>
                                MANAJEMEN PAKET
                            </a>
                        </li>
                    @endcan
                    @can('package_item_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.package-items.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/package-items") || request()->is("admin/package-items/*") ? "c-active" : "" }}">
                                <i class="fas fa-list c-sidebar-nav-icon"></i>
                                ITEM PAKET
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('addon_access')
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/addons*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fas fa-plus-square c-sidebar-nav-icon"></i>
                ADDON MANAGEMENT
            </a>

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.addons.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/addons") || request()->is("admin/addons/*") ? "c-active" : "" }}">
                        <i class="fas fa-puzzle-piece c-sidebar-nav-icon"></i>
                        MANAJEMEN ADDON
                    </a>
                </li>
            </ul>
        </li>
    @endcan
    @can('custom_item_access')
    <li class="c-sidebar-nav-dropdown {{ request()->is("admin/custom-items*") ? "c-show" : "" }}">
        <a class="c-sidebar-nav-dropdown-toggle" href="#">
            <i class="fas fa-th-large c-sidebar-nav-icon"></i>
            CUSTOM ITEM<br>MANAGEMENT
        </a>

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.custom-items.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/custom-items") || request()->is("admin/custom-items/*") ? "c-active" : "" }}">
                        <i class="fas fa-cubes c-sidebar-nav-icon"></i>
                        MANAJEMEN CUSTOM ITEM
                    </a>
                </li>
            </ul>
        </li>
        @endcan
        @if(Gate::allows('order_access') || Gate::allows('order_addon_access') || Gate::allows('order_item_access'))
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/orders*") || request()->is("admin/order-addons*") || request()->is("admin/order-items*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fas fa-shopping-cart c-sidebar-nav-icon"></i>
                    ORDER MANAGEMENT
                </a>

                <ul class="c-sidebar-nav-dropdown-items">
                    @can('order_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.orders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/orders") || request()->is("admin/orders/*") ? "c-active" : "" }}">
                                <i class="fas fa-receipt c-sidebar-nav-icon"></i>
                                MANAJEMEN ORDER
                            </a>
                        </li>
                    @endcan

                    @can('order_addon_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.order-addons.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/order-addons") || request()->is("admin/order-addons/*") ? "c-active" : "" }}">
                                <i class="fas fa-cart-plus c-sidebar-nav-icon"></i>
                                ORDER ADDON
                            </a>
                        </li>
                    @endcan

                    @can('order_item_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.order-items.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/order-items") || request()->is("admin/order-items/*") ? "c-active" : "" }}">
                                <i class="fas fa-clipboard-list c-sidebar-nav-icon"></i>
                                ORDER ITEM
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif
        @if(Gate::allows('beranda_access'))
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/berandas*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fas fa-desktop c-sidebar-nav-icon"></i>
                    FRONTEND MANAGEMENT
                </a>

                <ul class="c-sidebar-nav-dropdown-items">
                    @can('beranda_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.berandas.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/berandas") || request()->is("admin/berandas/*") ? "c-active" : "" }}">
                                <i class="fas fa-home c-sidebar-nav-icon"></i>
                                BERANDA
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>