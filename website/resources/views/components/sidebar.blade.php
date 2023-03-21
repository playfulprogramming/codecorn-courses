<nav class="relative z-10 flex flex-wrap items-center justify-between px-6 py-4 bg-white shadow-xl md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden md:w-64">
    <div class="flex flex-wrap items-center justify-between w-full px-0 mx-auto md:flex-col md:items-stretch md:min-h-full md:flex-nowrap">
        <button class="px-3 py-1 text-xl leading-none text-black bg-transparent border border-transparent border-solid rounded opacity-50 cursor-pointer md:hidden" type="button" onclick="toggleNavbar('example-collapse-sidebar')">
            <i class="fas fa-bars"></i>
        </button>
        <a class="inline-block p-4 px-0 mr-0 text-sm font-bold text-left uppercase md:block md:pb-2 text-slate-700 whitespace-nowrap" href="{{ route('admin.home') }}">
            {{ trans('panel.site_title') }}
        </a>
        <div class="absolute top-0 left-0 right-0 z-40 items-center flex-1 hidden h-auto overflow-x-hidden overflow-y-auto rounded shadow md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none" id="example-collapse-sidebar">
            <div class="block pb-4 mb-4 border-b border-solid md:min-w-full md:hidden border-slate-300">
                <div class="flex flex-wrap">
                    <div class="w-6/12">
                        <a class="inline-block p-4 px-0 mr-0 text-sm font-bold text-left uppercase md:block md:pb-2 text-slate-700 whitespace-nowrap" href="{{ route('admin.home') }}">
                            {{ trans('panel.site_title') }}
                        </a>
                    </div>
                    <div class="flex justify-end w-6/12">
                        <button type="button" class="px-3 py-1 text-xl leading-none text-black bg-transparent border border-transparent border-solid rounded opacity-50 cursor-pointer md:hidden" onclick="toggleNavbar('example-collapse-sidebar')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Divider -->
            <hr class="mb-6 md:min-w-full" />
            <!-- Heading -->

            <ul class="flex flex-col list-none md:flex-col md:min-w-full">
                <li class="items-center">
                    <a href="{{ route("admin.home") }}" class="{{ request()->is("admin") ? "sidebar-nav-active" : "sidebar-nav" }}">
                        <i class="fas fa-tv"></i>
                        {{ trans('global.dashboard') }}
                    </a>
                </li>

                @can('user_management_access')
                    <li class="items-center">
                        <a class="has-sub {{ request()->is("admin/permissions*")||request()->is("admin/roles*")||request()->is("admin/users*") ? "sidebar-nav-active" : "sidebar-nav" }}" href="#" onclick="window.openSubNav(this)">
                            <i class="fa-fw fas fa-users c-sidebar-nav-icon">
                            </i>
                            {{ trans('cruds.userManagement.title') }}
                        </a>
                        <ul class="hidden ml-4 subnav">
                            @can('permission_access')
                                <li class="items-center">
                                    <a class="{{ request()->is("admin/permissions*") ? "sidebar-nav-active" : "sidebar-nav" }}" href="{{ route("admin.permissions.index") }}">
                                        <i class="fa-fw c-sidebar-nav-icon fas fa-unlock-alt">
                                        </i>
                                        {{ trans('cruds.permission.title') }}
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="items-center">
                                    <a class="{{ request()->is("admin/roles*") ? "sidebar-nav-active" : "sidebar-nav" }}" href="{{ route("admin.roles.index") }}">
                                        <i class="fa-fw c-sidebar-nav-icon fas fa-briefcase">
                                        </i>
                                        {{ trans('cruds.role.title') }}
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="items-center">
                                    <a class="{{ request()->is("admin/users*") ? "sidebar-nav-active" : "sidebar-nav" }}" href="{{ route("admin.users.index") }}">
                                        <i class="fa-fw c-sidebar-nav-icon fas fa-user">
                                        </i>
                                        {{ trans('cruds.user.title') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('contact_management_access')
                    <li class="items-center">
                        <a class="has-sub {{ request()->is("admin/contact-companies*")||request()->is("admin/contact-contacts*") ? "sidebar-nav-active" : "sidebar-nav" }}" href="#" onclick="window.openSubNav(this)">
                            <i class="fa-fw fas fa-users c-sidebar-nav-icon">
                            </i>
                            {{ trans('cruds.contactManagement.title') }}
                        </a>
                        <ul class="hidden ml-4 subnav">
                            @can('contact_company_access')
                                <li class="items-center">
                                    <a class="{{ request()->is("admin/contact-companies*") ? "sidebar-nav-active" : "sidebar-nav" }}" href="{{ route("admin.contact-companies.index") }}">
                                        <i class="fa-fw c-sidebar-nav-icon fas fa-building">
                                        </i>
                                        {{ trans('cruds.contactCompany.title') }}
                                    </a>
                                </li>
                            @endcan
                            @can('contact_contact_access')
                                <li class="items-center">
                                    <a class="{{ request()->is("admin/contact-contacts*") ? "sidebar-nav-active" : "sidebar-nav" }}" href="{{ route("admin.contact-contacts.index") }}">
                                        <i class="fa-fw c-sidebar-nav-icon fas fa-user-plus">
                                        </i>
                                        {{ trans('cruds.contactContact.title') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('transaction_access')
                    <li class="items-center">
                        <a class="{{ request()->is("admin/transactions*") ? "sidebar-nav-active" : "sidebar-nav" }}" href="{{ route("admin.transactions.index") }}">
                            <i class="fa-fw c-sidebar-nav-icon fas fa-cogs">
                            </i>
                            {{ trans('cruds.transaction.title') }}
                        </a>
                    </li>
                @endcan

                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="items-center">
                            <a href="{{ route("profile.password.edit") }}" class="{{ request()->is("profile/password") || request()->is("profile/password/*") ? "sidebar-nav-active" : "sidebar-nav" }}">
                                <i class="fas fa-cogs"></i>
                                {{ trans('global.change_password') }}
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="items-center">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();" class="sidebar-nav">
                        <i class="fa-fw fas fa-sign-out-alt"></i>
                        {{ trans('global.logout') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
