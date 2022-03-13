<div>
    <a href="#" class="nav_logo">
        <i class='bx bx-store-alt nav_logo-icon'></i>
        <span class="nav_logo-name">
            {{-- {{Str::title(config('app.name'))}} --}}
            {{Str::ucfirst(config('app.name'))}}
        </span>
    </a>
    <div class="nav_list">    
        
        @if (session("user_id") != null)
            <a href="{{route("superadmin.dashboard")}}" class="nav_link"> 
                <i class='bx bx-grid-alt nav_icon'></i> 
                <span class="nav_name">
                    Admin
                </span>
            </a>
        @endif
        
        <a href="{{route('merchant.dashboard')}}" class="nav_link"> 
            <i class='bx bx-grid-alt nav_icon'></i> 
            <span class="nav_name">
                Dashboard
            </span>
        </a>
        
        <a href="{{route('merchant.catalog')}}" class="nav_link">
            <i class='bx bx-user-check nav_icon'></i>
            <span class="nav_name">
               Catalog
            </span>
        </a>

        <a href="{{route('merchant.invoices')}}" class="nav_link">
            <i class='bx bx-money nav_icon'></i>
            <span class="nav_name">
                Invoices
            </span>
        </a>

        {{-- <a href="{{route('merchant.transactions')}}" class="nav_link">
            <i class='bx bx-money nav_icon'></i>
            <span class="nav_name">
                Transactions
            </span>
        </a> --}}

        <a href="#" class="nav_link">
            <i class='fas fa-tachometer-alt nav_icon'></i>
            <span class="nav_name">
                Notifications
            </span>
        </a>

        <a href="#" class="nav_link"> 
            <i class='bx bx-log-out nav_icon'></i> 
            <span class="nav_name">
                Sign Out
            </span> 
        </a>
    </div>
</div>