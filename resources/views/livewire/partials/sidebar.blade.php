
<div class="vertical-menu">

    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">                
                <li class="menu-title">Menu</li>
                <li class="active">
                    <a href="{{ route('resto.home') }}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-home"></i></div>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('resto.user') }}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-user"></i></div>
                        <span>My Profile</span>
                    </a>
                </li>
                @can('admin-users')
                <li>
                    <a href="{{ route('resto.kategori') }}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-box    "></i> </div>
                        <span>Kategori</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('resto.sub-kategori') }}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-box    "></i> </div>
                        <span>Sub Kategori</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('resto.menupesanan') }}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-box    "></i> </div>
                        <span>Menu Restaurant</span>
                    </a>
                </li>
                @endcan
               @can('manage-pos')
                <li>
                    <a href="{{ route('resto.pos') }}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-money-bill-alt"></i></div>
                        <span>Pos</span>
                    </a>
                </li>
                @endcan
                @can('manage-koki')
                <li>
                    <a href="{{ route('resto.koki') }}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-cookie-bite"></i></div>
                        <span>Koki</span>
                        <small class="float-right badge badge-warning">
                            {{HelperFunction::count_cook()}}
                        </small>
                    </a>
                </li>
                @endcan
                @can('manage-kasir')
                <li>
                    <a href="{{ route('resto.kasir') }}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-receipt"></i></div>
                        <span>Kasir</span>
                        <small class="float-right badge badge-warning">  {{HelperFunction::count_cashier()}}</small>
                    </a>
                </li>
                @endcan
                @can('admin-users')
                <li>
                    <a href="{{ route('resto.laporan') }}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-book    "></i> </div>
                        <span>Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('resto.users-management') }}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-lock"></i></div>
                        <span>Users Management</span>
                    </a>
                </li>
                @endcan
                {{-- <li>
                    <a href="#" class="has-arrow waves-effect" aria-expanded="false">
                        <div class="d-inline-block icons-sm mr-1"><span class="uim-svg" style=""><i class="fas fa-list text-primary"></i></span></div>
                        <span>Management Menu</span>
                    </a>
                    <ul class="sub-menu mm-collapse" style="height: 0px;">
                        <li><a href="{{ route('resto.kategori') }}">Kategori</a></li>
                        <li><a href="{{ route('resto.sub-kategori') }}">Sub Kategori</a></li>
                        <li><a href="{{ route('resto.menupesanan') }}">Menu Restaurant</a></li>
                    </ul>
                </li> --}}
                <li class="pl-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                    <button type="submit" class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> <span class="logout">Logout</span> </button>
                    </form>
                </li>                
            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>
@push('script')
    <script>
        $(document).on('click','#vertical-menu-btn',function(e){
            e.preventDefault();
            $('li form button span.logout').hide();
            $(this).addClass('showLogo');
        })
        $(document).on('click','#vertical-menu-btn.showLogo',function(e){
            e.preventDefault();
            $('li form button span.logout').show();
            $(this).removeClass('showLogo');
        })

    </script>
@endpush