<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin <sup></sup></div>
    </a>

    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ (request()->is('admin')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.dashboard')}}">
            <span>{{__('Dashboard')}}</span></a>
    </li>
    <li class="nav-item  {{ (request()->is('admin/users*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.users.index')}}">
            <span>{{__('Users')}}</span></a>
    </li>


    <hr class="sidebar-divider d-none d-md-block">

</ul>
