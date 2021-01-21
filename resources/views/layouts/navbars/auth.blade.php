<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="{{ route('page.index', 'dashboard') }}" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="{{ asset('paper') }}/img/logo-small.png">
            </div>
        </a>
        <a href="{{ route('page.index', 'dashboard') }}" class="simple-text logo-normal">
            {{ __('HelloCoop') }} 
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">

        @forelse (\App\Helper\Helper::getMenuList() as $menu)
            <li class="{{ $elementActive == $menu->element_name ? 'active' : '' }}">
                <a href="{{ $menu->link }}">
                    <i class="{{ $menu->icon_class }}"></i>
                    <p>{{ $menu->display_name }}</p>
                </a>
            </li>
        @empty
            <li class="{{ $elementActive == 'setup_menu' ? 'active' : '' }}">
                <a href="{{ route('menu.setup_view') }}">
                    <i class="nc-icon nc-lock-circle-open"></i>
                    <p>{{ __('Setup Menu') }}</p>
                </a>
            </li>

        @endforelse

            <hr>

            <li class="{{ $elementActive == 'loans' ? 'active' : '' }}">
                <a href="{{ route('loan.index') }}">
                <i class="nc-icon nc-single-02"></i>
                    <p>{{ __('Users') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'loans' ? 'active' : '' }}">
                <a href="{{ route('loan.index') }}">
                <i class="nc-icon nc-single-copy-04"></i>
                    <p>{{ __('Menu') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'loans' ? 'active' : '' }}">
                <a href="{{ route('loan.index') }}">
                <i class="nc-icon nc-align-left-2"></i>
                    <p>{{ __('Reports') }}</p>
                </a>
            </li>


            <hr>
            <hr>

            <li class="{{ $elementActive == 'setup_menu' ? 'active' : '' }}">
                <a href="{{ route('menu.setup_view') }}">
                    <i class="nc-icon nc-lock-circle-open"></i>
                    <p>{{ __('Setup Menu') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }} {{ auth()->user()->is_master_account }} {{ $key ?? 'key' }} {{ $romel ?? 'romel' }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'company' ? 'active' : '' }}">
                <a href="{{ route('company.index') }}">
                    <i class="nc-icon nc-shop"></i>
                    <p>{{ __('Company') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'members' ? 'active' : '' }}">
                <a href="{{ route('member.index') }}">
                    <i class="nc-icon nc-layout-11"></i>
                    <p>{{ __('Members') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'borrowers' ? 'active' : '' }}">
                <a href="{{ route('borrower.index') }}">
                    <i class="nc-icon nc-badge"></i>
                    <p>{{ __('Borrowers') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'contributions' ? 'active' : '' }}">
                <a href="{{ route('contribution.index') }}">
                <i class="nc-icon nc-chart-pie-36"></i>
                    <p>{{ __('Contributions') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'loans' ? 'active' : '' }}">
                <a href="{{ route('loan.index') }}">
                <i class="nc-icon nc-money-coins"></i>
                    <p>{{ __('Loans') }}</p>
                </a>
            </li>

            <hr>






            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#laravelExamples">
                    <i class="nc-icon"><img src="{{ asset('paper/img/laravel.svg') }}"></i>
                    <p>
                            {{ __('Laravel examples') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExamples">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'profile' ? 'active' : '' }}">
                            <a href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini-icon">{{ __('UP') }}</span>
                                <span class="sidebar-normal">{{ __(' User Profile ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon">{{ __('U') }}</span>
                                <span class="sidebar-normal">{{ __(' User Management ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ $elementActive == 'icons' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'icons') }}">
                    <i class="nc-icon nc-diamond"></i>
                    <p>{{ __('Icons') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'map' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'map') }}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>{{ __('Maps') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'notifications' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'notifications') }}">
                    <i class="nc-icon nc-bell-55"></i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'tables' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'tables') }}">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>{{ __('Table List') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'typography' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'typography') }}">
                    <i class="nc-icon nc-caps-small"></i>
                    <p>{{ __('Typography') }}</p>
                </a>
            </li>

            
            <!-- <li class="active-pro {{ $elementActive == 'upgrade' ? 'active' : '' }} bg-danger">
                <a href="{{ route('page.index', 'upgrade') }}">
                    <i class="nc-icon nc-spaceship text-white"></i>
                    <p class="text-white">{{ __('Logout') }}</p>
                </a>
            </li> -->
        </ul>
    </div>
</div>