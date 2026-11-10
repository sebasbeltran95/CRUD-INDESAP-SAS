<!DOCTYPE html>
<html lang="es">
@include('layouts.comun.header')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#"> <img class="img-fluid img-roundered" width="20%" src="{{ asset('img/logo1.jpg') }}" alt=""></a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap mt-2 mb-2">
                @if (Auth()->user()->foto != null)
                    <img src="{{ asset(Auth()->user()->foto) }}" alt="avatar" class="rounded-circle img-fluid me-3"
                        width="50px" height="50px">
                @else
                    <img src="{{ asset('img/perfil_blanco.png') }}" alt="avatar" class="rounded-circle img-fluid me-3"
                    width="50px" height="50px">
                @endif
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-body-tertiary sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column mt-5">
                        <li class="nav-item">
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (Request::is('trabajador')) active @endif"
                                href="{{ route('trabajador') }}">
                                <i class="fas fa-address-card"></i>
                                Trabajador
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (Request::is('jornada')) active @endif"
                                href="{{ route('jornada') }}">
                                <i class="fas fa-address-book"></i>
                                Jornada
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> usuarios
                            </a>
                            <ul class="dropdown-menu w-100">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog"></i>Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @if (Auth()->user()->rol == 'Admon')
                                    <li><a class="dropdown-item" href="{{ route('usuarios') }}"><i class="fas fa-users"></i>Crear Usuarios</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                               <li class="text-center">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="btn btn-danger w-100" type="submit">Salir</button>
                                </form>
                              </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('contenido')
            </main>
        </div>
    </div>

    @include('layouts.comun.footer')
    @livewireScripts
    @stack('js')
</body>

</html>
