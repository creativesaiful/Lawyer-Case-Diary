<div class="bg-light border-end vh-100 collapse d-md-block" id="sidebarCollapse" style="min-width: 220px;">
    <div class="list-group list-group-flush">
        @if(auth()->check())

            {{-- Admin Links --}}
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active bg-primary text-white' : 'bg-light' }}">
                   <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.lawyers') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('admin.lawyers*') ? 'active bg-primary text-white' : 'bg-light' }}">
                   <i class="bi bi-person-badge me-2"></i> Lawyers
                </a>
            @endif

            {{-- Lawyer / Staff Links --}}
            @if(auth()->user()->isLawyer() || auth()->user()->isStaff())
                <a href="{{ route('dashboard') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active bg-primary text-white' : 'bg-light' }}">
                   <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="{{ route('cases.index') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('cases.index') ? 'active bg-primary text-white' : 'bg-light' }}">
                   <i class="bi bi-journal-text me-2"></i> Case Diaries
                </a>
                <a href="{{ route('cases.create') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('cases.create') ? 'active bg-primary text-white' : 'bg-light' }}">
                   <i class="bi bi-plus-square me-2"></i> Create New Case
                </a>
            @endif

            {{-- Lawyer Only --}}
            @if(auth()->user()->isLawyer())
                <a href="{{ route('staff.index') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('staff.index') ? 'active bg-primary text-white' : 'bg-light' }}">
                   <i class="bi bi-people me-2"></i> Staff List
                </a>
                <a href="{{ route('staff.create') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('staff.create') ? 'active bg-primary text-white' : 'bg-light' }}">
                   <i class="bi bi-person-plus me-2"></i> Add Staff
                </a>
                <a href="{{ route('courts.index') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('courts.index') ? 'active bg-primary text-white' : 'bg-light' }}">
                   <i class="bi bi-building me-2"></i> Courts
                </a>
                <a href="{{ route('courts.create') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center {{ request()->routeIs('courts.create') ? 'active bg-primary text-white' : 'bg-light' }}">
                   <i class="bi bi-plus-square me-2"></i> Add Court
                </a>
            @endif

        @endif
    </div>
</div>

{{-- Add this CSS for hover & smooth active effect --}}
<style>
    #sidebarCollapse .list-group-item {
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }
    #sidebarCollapse .list-group-item:hover {
        background-color: #0d6efd;
        color: #686868;
    }
    #sidebarCollapse .list-group-item.active {
        font-weight: 500;
    }
</style>
