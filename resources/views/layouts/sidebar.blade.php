 
<div class="bg-light border-right collapse d-md-block" id="sidebarCollapse">
    <div class="list-group list-group-flush">
        @if(auth()->check())
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-light">Dashboard</a>

            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-light">Dashboard</a>
                <a href="{{ route('admin.pending.lawyers') }}" class="list-group-item list-group-item-action bg-light">Pending Lawyers</a>
            @endif
            
            @if(auth()->user()->isLawyer() || auth()->user()->isStaff())
                <a href="{{ route('cases.index') }}" class="list-group-item list-group-item-action bg-light">Case Diaries</a>
                <a href="{{ route('cases.create') }}" class="list-group-item list-group-item-action bg-light">Create New Case</a>
            @endif
            
             
            @if(auth()->user()->isLawyer())
                            <a href="{{ route('staff.index') }}" class="list-group-item list-group-item-action bg-light">Staff List</a>
                <a href="{{ route('staff.create') }}" class="list-group-item list-group-item-action bg-light">Add Staff</a>

                <a href="{{ route('courts.index') }}" class="list-group-item list-group-item-action bg-light">Courts</a>
                <a href="{{ route('courts.create') }}" class="list-group-item list-group-item-action bg-light">Add Court</a>
 

            @endif
        @endif
    </div>
</div>