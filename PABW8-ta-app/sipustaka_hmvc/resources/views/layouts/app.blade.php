<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-white border-bottom py-2">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold"
                href="{{ route('dashboard') }}">

                <span class="logo">
                    <i class="bi bi-book-half"></i>
                </span>

                SiPustaka
            </a>

            <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNavbar">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">

                <ul class="navbar-nav me-auto ms-lg-4 gap-lg-1">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="bi bi-house me-1"></i>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('buku.*') ? 'active' : '' }}"
                            href="{{ route('buku.index') }}">

                            <i class="bi bi-book me-1"></i>
                            Data Buku

                        </a>
                    </li>

                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('usermanagement.*') ? 'active' : '' }}"
                                href="{{ route('usermanagement.index') }}">
                                <i class="bi bi-people me-1"></i>
                                Kelola User
                            </a>
                        </li>
                    @endif

                </ul>

                <div class="dropdown">

                    <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2"
                        type="button" data-bs-toggle="dropdown">

                        <i class="bi bi-person-circle"></i>
                        <span>{{ auth()->user()->name }}</span>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <span class="dropdown-item-text small text-muted">
                                Role: {{ auth()->user()->role->label() }}
                            </span>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>

                    </ul>

                </div>

            </div>
        </div>
    </nav>

    <main class="container py-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-autohide">
                {{ session('success') }}

                <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}

                <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')

    </main>

    @include('layouts.partials.scripts')

</body>
</html>
