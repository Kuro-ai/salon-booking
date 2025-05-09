<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 -960 960 960"><defs>
                            <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#00d1b2;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#ff7f50;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <path fill="url(#gradient1)" d="M200-80 40-520l200-120v-240h160v240l200 120L440-80zm480 0q-17 0-28.5-11.5T640-120t11.5-28.5T680-160h120v-80H680q-17 0-28.5-11.5T640-280t11.5-28.5T680-320h120v-80H680q-17 0-28.5-11.5T640-440t11.5-28.5T680-480h120v-80H680q-17 0-28.5-11.5T640-600t11.5-28.5T680-640h120v-80H680q-17 0-28.5-11.5T640-760t11.5-28.5T680-800h160q33 0 56.5 23.5T920-720v560q0 33-23.5 56.5T840-80zm-424-80h128l118-326-124-74H262l-124 74zm64-200"/></svg>                        
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                
                    @if(auth()->user() && auth()->user()->role === 'admin')

                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('admin.categories') }}" :active="request()->routeIs('admin.categories')">
                            <span>{!! __('Category') !!}</span>
                        </x-nav-link>
                
                        <x-nav-link href="{{ route('admin.products') }}" :active="request()->routeIs('admin.products')">
                            <span>{!! __('Products') !!}</span>
                        </x-nav-link>
                
                        <x-nav-link href="{{ route('admin.orders') }}" :active="request()->routeIs('admin.orders')">
                            <span>{!! __('Orders') !!}</span>
                        </x-nav-link>
                
                        <x-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
                            <span>{!! __('Users') !!}</span>
                        </x-nav-link>
                
                        <x-nav-link href="{{ route('admin.coupons') }}" :active="request()->routeIs('admin.coupons')">
                            <span>{!! __('Coupons') !!}</span>
                        </x-nav-link>
                
                        <x-nav-link href="{{ route('admin.advertisements') }}" :active="request()->routeIs('admin.advertisements')">
                            <span>{!! __('Advertisement') !!}</span>
                        </x-nav-link>
                
                        <x-nav-link href="{{ route('admin.services') }}" :active="request()->routeIs('admin.services')">
                            <span>{!! __('Services') !!}</span>
                        </x-nav-link>

                        <x-nav-link href="{{ route('admin.bookings') }}" :active="request()->routeIs('admin.bookings')">
                            <span>{!! __('Bookings') !!}</span>
                        </x-nav-link>

                        <x-nav-link href="{{ route('admin.staff') }}" :active="request()->routeIs('admin.staff')">
                            <span>{!! __('Staff') !!}</span>
                        </x-nav-link>  
        
                        <x-nav-link href="{{ route('admin.staff-schedules') }}" :active="request()->routeIs('admin.staff-schedules')">
                            <span>{!! __('Schedules') !!}</span>
                        </x-nav-link>  
                    @endif

                    @if(auth()->user() && auth()->user()->role === 'customer')

                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('customer.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('order.history') }}" :active="request()->routeIs('order.history')">
                            {{ __('Order History') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('wishlist') }}" :active="request()->routeIs('wishlist')">
                            {{ __('Wishlist') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('service.list') }}" :active="request()->routeIs('service.list')">
                            {{ __('Service List') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('bookings') }}" :active="request()->routeIs('bookings')">
                            {{ __('Booking List') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('customer.privacy') }}" :active="request()->routeIs('customer.privacy')">
                            {{ __('Privacy Policy') }}
                        </x-nav-link>
                    
                        <div class="flex items-center space-x-4">
                            @livewire('customer.mini-cart')
                        </div>
                    @endif
                </div>
                
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            @if(auth()->user() && auth()->user()->role === 'admin')
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('admin.categories') }}" :active="request()->routeIs('admin.categories')">
                    <span>{!! __('Category') !!}</span>
                </x-responsive-nav-link>
        
                <x-responsive-nav-link href="{{ route('admin.products') }}" :active="request()->routeIs('admin.products')">
                    <span>{!! __('Products') !!}</span>
                </x-responsive-nav-link>
        
                <x-responsive-nav-link href="{{ route('admin.orders') }}" :active="request()->routeIs('admin.orders')">
                    <span>{!! __('Orders') !!}</span>
                </x-responsive-nav-link>
        
                <x-responsive-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
                    <span>{!! __('Users') !!}</span>
                </x-responsive-nav-link>
        
                <x-responsive-nav-link href="{{ route('admin.coupons') }}" :active="request()->routeIs('admin.coupons')">
                    <span>{!! __('Coupons') !!}</span>
                </x-responsive-nav-link>
        
                <x-responsive-nav-link href="{{ route('admin.advertisements') }}" :active="request()->routeIs('admin.advertisements')">
                    <span>{!! __('Advertisement') !!}</span>
                </x-responsive-nav-link>
        
                <x-responsive-nav-link href="{{ route('admin.services') }}" :active="request()->routeIs('admin.services')">
                    <span>{!! __('Services') !!}</span>
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('admin.bookings') }}" :active="request()->routeIs('admin.bookings')">
                    <span>{!! __('Bookings') !!}</span>
                </x-responsive-nav-link>   
                
                <x-responsive-nav-link href="{{ route('admin.staff') }}" :active="request()->routeIs('admin.staff')">
                    <span>{!! __('Staff') !!}</span>
                </x-responsive-nav-link>  

                <x-responsive-nav-link href="{{ route('admin.staff-schedules') }}" :active="request()->routeIs('admin.staff-schedules')">
                    <span>{!! __('Schedules') !!}</span>
                </x-responsive-nav-link>  
             @endif

            @if(auth()->user() && auth()->user()->role === 'customer')

                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('customer.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('order.history') }}" :active="request()->routeIs('order.history')">
                    {{ __('Order History') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('wishlist') }}" :active="request()->routeIs('wishlist')">
                    {{ __('Wishlist') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('service.list') }}" :active="request()->routeIs('service.list')">
                    {{ __('Service List') }}
                </x-responsive-nav-link>
                            
                <x-responsive-nav-link href="{{ route('bookings') }}" :active="request()->routeIs('bookings')">
                    {{ __('Booking List') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('customer.privacy') }}" :active="request()->routeIs('customer.privacy')">
                    {{ __('Privacy Policy') }}
                </x-responsive-nav-link>                

                <div class="flex items-center space-x-4">
                    @livewire('customer.mini-cart')
                </div>
                        
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
