<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <!-- Sidebar toggle button for mobile -->
        <button class="btn btn-primary d-md-none me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse">
            <i class="bi bi-list"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand fw-bold text-primary" href="#">Lawyer Case Diary</a>

        <!-- Toggler for mobile collapse -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Right side content -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            @auth
            <ul class="navbar-nav align-items-center">
                <li class="nav-item me-3">
                    <span class="navbar-text fw-medium">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }} ({{ Auth::user()->role }})
                    </span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-flex">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
            @else
            <ul class="navbar-nav">
                <li class="nav-item me-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square me-1"></i> Register
                    </a>
                </li>
            </ul>
            @endauth
        </div>
    </div>
</nav>
