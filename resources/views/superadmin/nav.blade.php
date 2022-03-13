<div>
    <a href="#" class="nav_logo">
        <i class='bx bx-store-alt nav_logo-icon'></i>
        <span class="nav_logo-name">
            {{-- {{Str::title(config('app.name'))}} --}}
            {{Str::ucfirst(config('app.name'))}}
        </span>
    </a>
    <div class="nav_list">                    
        <a href="{{route('superadmin.dashboard')}}" class="nav_link"> 
            <i class='bx bx-grid-alt nav_icon'></i> 
            <span class="nav_name">
                Dashboard
            </span>
        </a>
        
        <a href="{{route('superadmin.assetprovider')}}" class="nav_link">
            <i class='bx bx-user-check nav_icon'></i>
            <span class="nav_name">
               Asset Providers
            </span>
        </a>

        <a href="{{route('superadmin.categories')}}" class="nav_link">
            <i class='bx bx-list-check nav_icon'></i>
            <span class="nav_name">
                Categories
            </span>
        </a>
        
        <a href="{{route('superadmin.assets')}}" class="nav_link">
            <i class='bx bx-server nav_icon'></i>
            <span class="nav_name">
                Assets
            </span>
        </a>

        <a href="{{route('superadmin.productcatalog')}}" class="nav_link">
            <i class='bx bx-server nav_icon'></i>
            <span class="nav_name">
                Product Catalog
            </span>
        </a>


        <a href="{{route('superadmin.payments')}}" class="nav_link">
            <i class='bx bx-money nav_icon'></i>
            <span class="nav_name">
                Payments
            </span>
        </a>

        <a href="{{route('superadmin.invoices')}}" class="nav_link">
            <i class='bx bx-money nav_icon'></i>
            <span class="nav_name">
                Invoices
            </span>
        </a>


        <a href="{{route('superadmin.performance')}}" class="nav_link">
            <i class='fas fa-tachometer-alt nav_icon'></i>
            <span class="nav_name">
                Performance
            </span>
        </a>

        <a class="nav_link" data-toggle="collapse" href="#menuCollapse" role="button" aria-expanded="false" aria-controls="menuCollapse">
            <i class='bx bx-dots-horizontal nav_icon'></i>
            <span class="nav_name">
                More
            </span>
        </a>
        <div class="collapse" id="menuCollapse">
            <div class="">
                <a href="{{route('superadmin.locations')}}" class="nav_link">
                    <i class='bx bx-map nav_icon'></i>
                    <span class="nav_name">
                        Locations
                    </span>
                </a>
                <a href="{{route('superadmin.faqs')}}" class="nav_link">
                    <i class='bx bx-question-mark nav_icon'></i>
                    <span class="nav_name">
                        FAQ's
                    </span>
                </a>
                <a href="{{route('superadmin.announcements')}}" class="nav_link">
                    <i class='bx bx-user-voice nav_icon'></i>
                    <span class="nav_name">
                        Announcements
                    </span>
                </a>
            </div>
        </div>
        <a href="{{route("superadmin.logout")}}" class="nav_link"> 
            <i class='bx bx-log-out nav_icon'></i> 
            <span class="nav_name">
                Sign Out
            </span> 
        </a>
    </div>
</div>