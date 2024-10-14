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

    {{-- <script src="{{ asset('assets/js/vendors/color-modes.js') }}"></script> --}}
    <link href="{{ asset('assets/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />

    {{-- external link --}}
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />


</head>

<body>
    <div class="top-loader">
        <div class="progress-bar" id="progressBar"></div>
    </div>

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
                    class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['countries', 'addnewcountrypage', 'countryupdatepage', 'states', 'addnewstatepage', 'stateupdatepage', 'cities', 'addnewcitypage', 'cityupdatepage']) ? 'active' : '' }}">
                    <a class="menu-link side-menuitem" href="javascript:void(0);">
                        <img src="{{ asset('assets/imgs/icons/geograpy.png') }}" alt="">
                        <span class="text">Geography Management</span>
                    </a>

                    <!-- Submenu -->
                    <ul
                        class="submenu {{ in_array(Route::currentRouteName(), ['countries', 'addnewcountrypage', 'countryupdatepage', 'states', 'addnewstatepage', 'stateupdatepage', 'cities', 'addnewcitypage', 'cityupdatepage']) ? 'active' : '' }}">
                        <li>
                            <a class="submenuitem {{ in_array(Route::currentRouteName(), ['countries', 'addnewcountrypage', 'countryupdatepage']) ? 'active' : '' }}"
                                href="{{ route('countries') }}">
                                <img src="{{ asset('assets/imgs/icons/country.png') }}" alt="">
                                <span class="text">Countries</span>
                            </a>
                        </li>
                        <li>
                            <a class="submenuitem {{ in_array(Route::currentRouteName(), ['states', 'addnewstatepage', 'stateupdatepage']) ? 'active' : '' }}"
                                href="{{ route('states') }}">
                                <img src="{{ asset('assets/imgs/icons/state.png') }}" alt="">
                                <span class="text">States</span>
                            </a>
                        </li>
                        <li>
                            <a class="submenuitem {{ in_array(Route::currentRouteName(), ['cities', 'addnewcitypage', 'cityupdatepage']) ? 'active' : '' }}"
                                href="{{ route('cities') }}">
                                <img src="{{ asset('assets/imgs/icons/city.png') }}" alt="">
                                <span class="text">Cities</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li
                    class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['categories', 'addnewcatepage', 'categoryupdatepage', 'niches', 'nicheaddpage', 'nicheupdatepage', 'service.names', 'addservicenamepage', 'servicenameeditpage']) ? 'active' : '' }}">
                    <a class="menu-link side-menuitem" href="javascript:void(0);">
                        <img src="{{ asset('assets/imgs/icons/manegment.png') }}" alt="">
                        <span class="text">Services Management</span>
                    </a>

                    <!-- Submenu -->
                    <ul
                        class="submenu {{ in_array(Route::currentRouteName(), ['categories', 'addnewcatepage', 'categoryupdatepage', 'niches', 'nicheaddpage', 'nicheupdatepage', 'service.names', 'addservicenamepage', 'servicenameeditpage']) ? 'active' : '' }}">
                        <li>
                            <a class="submenuitem {{ in_array(Route::currentRouteName(), ['categories', 'addnewcatepage', 'categoryupdatepage']) ? 'active' : '' }}"
                                href="{{ route('categories') }}">
                                <img src="{{ asset('assets/imgs/icons/category.png') }}" alt="">
                                <span class="text">Categories</span>
                            </a>
                        </li>
                        <li>
                            <a class="submenuitem {{ in_array(Route::currentRouteName(), ['niches', 'nicheaddpage', 'nicheupdatepage']) ? 'active' : '' }}"
                                href="{{ route('niches') }}">
                                <img src="{{ asset('assets/imgs/icons/niche.png') }}" alt="">
                                <span class="text">Niches</span>
                            </a>
                        </li>

                        <li>
                            <a class="submenuitem {{ in_array(Route::currentRouteName(), ['addservicenamepage', 'service.names', 'addservicenamepage', 'servicenameeditpage']) ? 'active' : '' }}"
                                href="{{ route('service.names') }}">
                                <img src="{{ asset('assets/imgs/icons/Services.png') }}" alt="">
                                <span class="text">Services Names</span>
                            </a>
                        </li>

                    </ul>


                </li>


                <li class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }}">
                    <a class="menu-link side-menuitem" href="javascript:void(0);">
                        <img src="{{ asset('assets/imgs/icons/report.png') }}" alt="">
                        <span class="text position-relative">Approval Requests
                            <span class="badge-count translate-middle badge rounded-pill bg-danger">
                                99+
                            </span>
                        </span>
                    </a>

                    <!-- Submenu -->
                    <ul
                        class="submenu {{ in_array(Route::currentRouteName(), ['categories', 'addnewcatepage', 'categoryupdatepage', 'niches', 'nicheaddpage', 'nicheupdatepage', 'service.names']) ? 'active' : '' }}">


                        <li>
                            <a class="submenuitem {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }}"
                                href="{{ route('service.names') }}">
                                <img src="{{ asset('assets/imgs/icons/label.png') }}" alt="">
                                <span class="text">Services Names</span>
                            </a>
                        </li>
                        <li>
                            <a class="submenuitem {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }}"
                                href="{{ route('service.names') }}">
                                <img src="{{ asset('assets/imgs/icons/Services.png') }}" alt="">
                                <span class="text">Services</span>
                            </a>
                        </li>
                        <li>
                            <a class="submenuitem {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }}"
                                href="{{ route('service.names') }}">
                                <img src="{{ asset('assets/imgs/icons/niche.png') }}" alt="">
                                <span class="text">Niches </span>
                            </a>
                        </li>

                        <li>
                            <a class="submenuitem {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }}"
                                href="{{ route('service.names') }}">
                                <img src="{{ asset('assets/imgs/icons/clerk.png') }}" alt="">
                                <span class="text">Professionals</span>
                            </a>
                        </li>

                        <li>
                            <a class="submenuitem {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }}"
                                href="{{ route('service.names') }}">
                                <img src="{{ asset('assets/imgs/icons/expert.png') }}" alt="">
                                <span class="text">Specialists</span>
                            </a>
                        </li>






                    </ul>


                </li>
                <li
                    class="menu-item {{ in_array(Route::currentRouteName(), ['onboarding', 'addonboardingpage', 'onboardingupdatepage']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('onboarding') }}">
                        <img src="{{ asset('assets/imgs/icons/mentor.png') }}" alt="">
                        <span class="text">Onboarding ads</span>
                    </a>
                </li>
                <li class="menu-item {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('onboarding') }}">
                        <img src="{{ asset('assets/imgs/icons/notification.png') }}" alt="">
                        <span class="text">Notification Broadcasting</span>
                    </a>
                </li>



                <hr>
                <li
                    class="menu-item {{ in_array(Route::currentRouteName(), ['Professional', 'update.prof.page', 'professionaladdpage', 'professionaldetails']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('Professional') }}">
                        <img src="{{ asset('assets/imgs/icons/clerk.png') }}" alt="">
                        <span class="text">Professionals</span>
                    </a>
                </li>

                <li class="menu-item {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('Professional') }}">
                        <img src="{{ asset('assets/imgs/icons/Services.png') }}" alt="">
                        <span class="text">Services</span>
                    </a>
                </li>

                <li class="menu-item {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('Professional') }}">
                        <img src="{{ asset('assets/imgs/icons/booking.png') }}" alt="">
                        <span class="text">All Bookings</span>
                    </a>
                </li>

                <li class="menu-item {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('Professional') }}">
                        <img src="{{ asset('assets/imgs/icons/picture.png') }}" alt="">
                        <span class="text">Professional Posts</span>
                    </a>
                </li>

                <li class="menu-item {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('Professional') }}">
                        <img src="{{ asset('assets/imgs/icons/special-offer.png') }}" alt="">
                        <span class="text">Discount Deals</span>
                    </a>
                </li>


                <li class="menu-item {{ in_array(Route::currentRouteName(), ['']) ? 'active' : '' }} ">
                    <a class="menu-link side-menuitem" href="{{ route('Professional') }}">
                        <img src="{{ asset('assets/imgs/icons/expert.png') }}" alt="">
                        <span class="text">Specialists</span>
                    </a>
                </li>
                <hr>
                <li
                    class="menu-item  {{ in_array(Route::currentRouteName(), ['users', 'adduserpage', 'userdetails', 'userupdatepage']) ? 'active' : '' }}">
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
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i
                                    class="material-icons md-exit_to_app"></i>Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </header>

        @yield('main')
        <!-- Button to trigger toast manually (optional) -->
        <button type="button" hidden class="btn btn-primary" id="liveToastBtn">Show live toast</button>


        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="{{ asset('assets/imgs/theme/logo.png') }}" style="height: 1rem; width:1rem;"
                        class="rounded me-2" alt="...">
                    <strong class="me-auto">Notification</strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Hello Asad, this is a sample notification. How have you been?
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/chart.js') }}"></script>
    <!-- Load SweetAlert2 here -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/main.js?v=6.0') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom-chart.js') }}" type="text/javascript"></script>
    {{-- external link  --}}
    <script src="//cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script type="text/javascript">
        const toastTrigger = document.getElementById('liveToastBtn');
        const toastLiveExample = new bootstrap.Toast(document.getElementById('liveToast'));

        if (toastTrigger) {
            toastTrigger.addEventListener('click', () => {
                toastLiveExample.show();
            });
        }

        setInterval(() => {
            toastLiveExample.show();
        }, 10000);


// Select all elements with the class "menu-item"
document.querySelectorAll(".menu-item").forEach(item => {
    item.addEventListener("click", function() {
        const progressBar = document.getElementById("progressBar");
        let width = 0;

        // Start the progress bar animation
        const interval = setInterval(() => {
            if (width >= 100) {
                clearInterval(interval);
            } else {
                width++;
                progressBar.style.width = width + "%";
            }
        }, 50);
    });
});

    
    
    
    </script>

    @stack('script')

</body>

</html>
