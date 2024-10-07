<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Only Offers</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link href="{{ asset('assets/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/style/css/loginpage.css') }}" rel="stylesheet">




    <style>
        .login-btn {
            display: flex;
            justify-content: center;
        }


        .logo {
            display: flex;
            justify-content: center;
        }

        .logo img {
            height: 14vh;
            width: auto
        }
    </style>

</head>

<body>
    <main>

        <div class="container logo pt-70 mb-10">
            <img class="" src="{{ asset('assets/imgs/theme/logo.png') }}" alt="">

        </div>



        <section class="content-main">
            <div class="card mx-auto card-login">
                <div class="card-body">
                    <h4 class="card-title mb-2 text-center">Login to Admin Panel</h4>

                    <form method="get" action="{{ route('dashboard') }}">
                        @csrf
                        <label for="Username or email" class="form-label">Username or email:</label>
                        <input value="{{ old('Email') }}"
                            class="form-control @error('Email') is-invalid @enderror  @error('login_error') is-invalid @enderror"
                            placeholder="Username or email" name="Email" type="text" />
                        @error('Email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <label for="password" class="form-label">Password:</label>
                        <div class="input-group mb-2">
                            <input value="{{ old('Password') }}"
                                class="form-control @error('Password') is-invalid @enderror @error('login_error') is-invalid @enderror"
                                id="password" placeholder="Password" name="Password" type="password" />


                        </div>

                        <div class="p-2">
                            <input type="checkbox" id="showPassword" />
                            <label for="showPassword" class="ms-2">Show Password</label>
                        </div>

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @error('login_error')
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @enderror



                        <button type="submit" class="btn btn-primary w-100 login-btn">Login</button>
                    </form>

                </div>

            </div>
        </section>

    </main>
    <script src="{{ asset('assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/chart.js') }}"></script>
    <!-- Main Script -->
    <script src="{{ asset('assets/js/main.js?v=6.0') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom-chart.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        document.getElementById('showPassword').addEventListener('change', function() {
            const passwordField = document.getElementById('password');
            passwordField.type = this.checked ? 'text' : 'password';
        });
    </script>


</body>

</html>
