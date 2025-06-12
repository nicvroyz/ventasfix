<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item"><a class="navbar-brand" href="{{ route('dashboard') }}"><h2 class="brand-text">Mi App</h2></a></li>
        </ul>
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main">
            <li class="nav-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i><span class="menu-title">Dashboard</span></a></li>
            <li class="nav-item"><a href="{{ route('usuarios.index') }}"><i class="feather icon-users"></i><span class="menu-title">Usuarios</span></a></li>
            <li class="nav-item"><a href="{{ route('clientes.index') }}"><i class="feather icon-user-check"></i><span class="menu-title">Clientes</span></a></li>
            <li class="nav-item"><a href="{{ route('productos.index') }}"><i class="feather icon-package"></i><span class="menu-title">Productos</span></a></li>
            <li class="nav-item"><a href="{{ route('ventas.index') }}"><i class="feather icon-shopping-cart"></i><span class="menu-title">Ventas</span></a></li>
        </ul>
    </div>
</div>
