<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Yoneti Superadmin</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/theme/logo.png') }}" />
    @stack('style')

    <!-- Template CSS -->
    {{-- <script src="{{ asset('assets/js/vendors/color-modes.js') }}"></script> --}}
    <link href="{{ asset('assets/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />

    {{-- external link --}}
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />


</head>

<body>
    <div class="screen-overlay"></div>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="" class="brand-wrap dashboard-logo">
                <img src="{{ asset('assets/imgs/theme/logo.png') }}" class="logo" alt="Nest Dashboard" />

                <h4>Dashboard</h4>

            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize"><i
                        class="text-muted material-icons md-menu_open"></i></button>
            </div>
        </div>
        <nav>
            <ul class="menu-aside">
                <li class="menu-item {{ in_array(Route::currentRouteName(), ['dashboard']) ? 'active' : '' }}">

                    <a class="menu-link side-menuitem" href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/imgs/icons/home.png') }}" alt="">
                        <span class="text">Dashboard</span>
                    </a>
                </li>

                <li
                    class="menu-item {{ in_array(Route::currentRouteName(), ['categories', 'addnewcatepage', 'categoryupdatepage']) ? 'active' : '' }}">
                    <a class="menu-link side-menuitem" href="{{ route('categories') }}">
                        <img src="{{ asset('assets/imgs/icons/category.png') }}" alt="">
                        <span class="text">Categories</span>
                    </a>
                </li>


                <li
                    class="menu-item {{ in_array(Route::currentRouteName(), ['countries', 'addnewcountrypage', 'countryupdatepage']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('countries') }}">
                        <img src="{{ asset('assets/imgs/icons/country.png') }}" alt="">
                        <span class="text">Countries</span>
                    </a>
                </li>

                <li class="menu-item {{ in_array(Route::currentRouteName(), ['states','addnestatepage','stateupdatepage']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('states') }}">
                        <img src="{{ asset('assets/imgs/icons/state.png') }}" alt="">
                        <span class="text">States</span>
                    </a>
                </li>

                <li class="menu-item {{ in_array(Route::currentRouteName(), ['cities','addnewcitypage','cityupdatepage']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('cities') }}">
                        <img src="{{ asset('assets/imgs/icons/city.png') }}" alt="">
                        <span class="text">Cities</span>
                    </a>
                </li>

                <li class="menu-item {{ in_array(Route::currentRouteName(), ['onboarding']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('onboarding') }}">
                        <img src="{{ asset('assets/imgs/icons/mentor.png') }}" alt="">
                        <span class="text">Onboarding ads</span>
                    </a>
                </li>

                <li class="menu-item ">
                    <a class="menu-link side-menuitem" href="">
                        <img src="{{ asset('assets/imgs/icons/clerk.png') }}" alt="">
                        <span class="text">Merchats</span>
                    </a>
                </li>

                <li class="menu-item  {{ in_array(Route::currentRouteName(), ['users', 'adduserpage', 'userdetails', 'userupdatepage']) ? 'active' : '' }}">
                    <a class="menu-link side-menuitem" href="{{ route('users') }}">
                        <img src="{{ asset('assets/imgs/icons/account.png') }}" alt="">
                        <span class="text">Users</span>
                    </a>
                </li>






            </ul>


        </nav>
    </aside>
    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
                <form class="searchform">
                    <div class="input-group">
                        <input list="search_terms" type="text" class="form-control" placeholder="Search term" />
                        <button class="btn btn-light bg" type="button"><i
                                class="material-icons md-search"></i></button>
                    </div>
                    <datalist id="search_terms">
                        <option value="Products"></option>
                        <option value="New orders"></option>
                        <option value="Apple iphone"></option>
                        <option value="Ahmed Hassan"></option>
                    </datalist>
                </form>
            </div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i
                        class="material-icons md-apps"></i></button>
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link btn-icon" href="#">
                            <i class="material-icons md-notifications animation-shake"></i>
                            <span class="badge rounded-pill">3</span>
                        </a>
                    </li>

                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount"
                            aria-expanded="false"> <img class="img-xs rounded-circle"
                                src="{{ asset('assets/imgs/theme/logo.png') }}" alt="User" /></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">


                            <a class="dropdown-item" href="#"><i
                                    class="material-icons md-receipt"></i>Billing</a>

                            <a class="dropdown-item" href="#"><i
                                    class="material-icons md-help_outline"></i>Help center</a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#"><i
                                    class="material-icons md-exit_to_app"></i>Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </header>

        @yield('main')

    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/chart.js') }}"></script>

    <!-- Load SweetAlert2 here -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="{{ asset('assets/js/main.js?v=6.0') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom-chart.js') }}" type="text/javascript"></script>


    {{-- external link  --}}

    <script src="//cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>

    @stack('script')


</body>

</html>
