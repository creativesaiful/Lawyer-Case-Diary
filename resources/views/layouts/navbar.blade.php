<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse">
            <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand ms-3" href="#">Lawyer Case Diary</a>
        <div class="ms-auto">
            {{-- Check if a user is logged in --}}
            @auth
            <span class="navbar-text me-3">
                {{ Auth::user()->name }} ({{ Auth::user()->role }})
            </span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
            @else
            {{-- Display login/register links for guests --}}
            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @endauth
        </div>
    </div>
</nav>