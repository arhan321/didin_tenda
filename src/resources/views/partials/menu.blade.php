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
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/tests*") ? "c-show" : "" }}">
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
                    @can('test_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.tests.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tests") || request()->is("admin/tests/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                test
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
       

        @can('monitoringproduct_access')
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/monitoringlaptops*") ? "c-show" : "" }} {{ request()->is("admin/monitorings*") ? "c-show" : "" }} ">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fas fa-chart-bar fa-fw c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.monitoringproduct.title') }}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('monitoring_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.monitorings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/monitorings") || request()->is("admin/monitorings/*") ? "c-active" : "" }}">
                        <i class="fas fa-chart-line fa-fw c-sidebar-nav-icon"></i>
                        {{ trans('cruds.monitoring.title') }}
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('productmanagement_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/deliveryorders*") ? "c-show" : "" }} {{ request()->is("admin/deliveryorderbarang*") ? "c-show" : "" }} {{ request()->is("admin/orderbarangs*") ? "c-show" : "" }} {{ request()->is("admin/productbarangs*") ? "c-show" : "" }} {{ request()->is("admin/products*") ? "c-show" : "" }} {{ request()->is("admin/categoryproducts") ? "c-show" : "" }} {{ request()->is("admin/vendors*") ? "c-show" : "" }} {{ request()->is("admin/orders*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-boxes c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.productmanagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('vendor_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.vendors.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/vendors") || request()->is("admin/vendors/*") ? "c-active" : "" }}">
                            <i class="fas fa-landmark fa-fw c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.vendor.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('categoryproduct_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.categoryproducts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/categoryproducts") || request()->is("admin/categoryproducts/*") ? "c-active" : "" }}">
                            <i class="fas fa-list fa-fw c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.categoryproduct.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('product_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.products.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/products") || request()->is("admin/products/*") ? "c-active" : "" }}">
                                <i class="fa-fw fab fa-product-hunt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.product.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('order_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.orders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/orders") || request()->is("admin/orders/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-book c-sidebar-nav-icon">

                            </i>
                            {!! trans('cruds.order.title') !!}
                        </a>
                    </li>
                @endcan
                @can('deliveryorder_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.deliveryorders.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/deliveryorders") || request()->is("admin/deliveryorders/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-truck c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.deliveryorder.title') }}
                    </a>
                </li>
                @endcan
                @can('productbarang_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.productbarangs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/productbarangs") || request()->is("admin/productbarangs/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-box c-sidebar-nav-icon">
        
                        </i>
                        {{ trans('cruds.productbarang.title') }}
                    </a>
                </li>
                @endcan
                @can('orderbarang_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.orderbarangs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/orderbarangs") || request()->is("admin/orderbarangs/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-book c-sidebar-nav-icon">

                        </i>
                        {!! trans('cruds.orderbarangs.title') !!}
                    </a>
                </li>
                @endcan
                @can('deliveryorderbarang_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.deliveryorderbarang.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/deliveryorderbarang") || request()->is("admin/deliveryorderbarang/*") ? "c-active" : "" }}">
                        <i class="fa-fw fas fa-truck c-sidebar-nav-icon">

                        </i>
                        {!! trans('cruds.deliveryorderbarang.title') !!}
                    </a>
                </li>
                @endcan
                </ul>
            </li>
        @endcan
        @can('reimburs_access')
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/reimburs*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw fas fa-handshake c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.reimburs.title') }}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('reimburs_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route("admin.reimburs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/reimburs") || request()->is("admin/reimburs/*") ? "c-active" : "" }}">
                        <i class="fas fa-dollar-sign fa-fw c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.reimburs.title') }}
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
     
        
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