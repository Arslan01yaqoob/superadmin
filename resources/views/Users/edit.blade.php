@extends('Layout.layout')
@section('main')
    <div class="container">

        <div class="container mt-5">
            <h1>User</h1>
            <div class="form-div">
                <h2 class="mb-4 text-center">Update User Details</h2>
                <div id="coverimage" style="background-image: url('{{asset($user->cover_image_url)}}') " class="coverimage">
                    <div class="coverpicinput" onclick="openimagesbg()">
                        <img src="{{ asset('assets/imgs/icons/pen.png') }}" alt="">
                    </div>
                </div>
                <div id="profilepic" style="background-image: url('{{asset($user->image_url)}}') "
                    class="profilepic">
                    <div class="profilepicinput" onclick="openimagespp()">
                        <img src="{{ asset('assets/imgs/icons/camera.png') }}" alt="">
                    </div>
                </div>

                <form method="POST" action="{{ route('user.upate',['id'=>$user->id]) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <input type="file" hidden id="backgrounpic" name="backgrounpic" accept="image/*"
                            onchange="backgroundpic()">

                        <input type="file" hidden id="profilepicinput" name="profilepicinput" accept="image/*"
                            onchange="profilepic()">

                        {{-- name --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="name">Name</label>
                            <input value="{{$user->name}}" required class="form-control @error('name') is-invalid @enderror" name="name"
                                type="text" id="name" placeholder="Enter city name" maxlength="50">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- username --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="username">Username</label>
                            <input value="{{$user->username}}" required class="form-control @error('username') is-invalid @enderror" name="username"
                                id="username" type="text" placeholder="Enter your username" maxlength="50">
                            <div id="username-feedback" class="invalid-feedback"></div>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- gendar --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="gender">Gender</label>
                            <select required class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                                <option value="{{ $user->gendar }}" selected>{{ ucfirst($user->gendar) }}</option>
                                
                                @if($user->gendar !== 'male')
                                    <option value="male">Male</option>
                                @endif
                            
                                @if($user->gendar !== 'female')
                                    <option value="female">Female</option>
                                @endif
                            
                                @if($user->gendar !== 'other')
                                    <option value="other">Other</option>
                                @endif
                            </select>
                            
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- email --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="email">Email</label>
                            <input value="{{$user->email}}"  class="form-control @error('email') is-invalid @enderror" name="email"
                                type="email" id="email" placeholder="Enter email address" maxlength="100">
                            <div id="email-feedback" class="invalid-feedback"></div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- phone_num --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="phone_num">Phone Number</label>
                            <div>
                                <input  class="form-control @error('phone_num') is-invalid @enderror"
                                   value="{{$user->phone_num}}" name="phone_num" type="tel" id="phone_num" placeholder="Enter phone number"
                                    maxlength="15">
                                @error('phone_num')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="phone_num_feedback" class="invalid-feedback"></div> <!-- Feedback div -->
                            </div>
                        </div>

                        {{-- country --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="country_id">Country</label>
                            <select onchange="getstates()" required
                                class="form-control @error('country_id') is-invalid @enderror" name="country_id"
                                id="country_id">
                                <option value="{{ $user->country->id }}" selected>{{ $user->country->country_name }}</option>
                                @foreach ($countries as $data)
                                    @if ($data->id !== $user->country->id)
                                        <option value="{{ $data->id }}">{{ $data->country_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('country_id') 
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- city_id --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="state_id">State</label>
                            <select required onchange="getcities()" class="form-control @error('city_id') is-invalid @enderror" name="state_id"
                                id="state_id">
                                <option value="{{$user->state->id}}" selected>{{$user->state->state_name}}</option>

                                @foreach ($sates as $data)
                                @if ($data->id !== $user->state->id)
                                    <option value="{{ $data->id }}">{{ $data->state_name }}</option>
                                @endif
                            @endforeach

                            </select>
                            @error('city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        {{-- city_id --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="city_id">City</label>
                            <select required class="form-control @error('city_id') is-invalid @enderror" name="city_id"
                                id="city_id">
                                <option value="{{$user->city->id}}" selected>{{$user->city->city_name}}</option>

                                @foreach ($cities as $data)
                                @if ($data->id !== $user->city->id)
                                    <option value="{{ $data->id }}">{{ $data->city_name }}</option>
                                @endif
                            @endforeach

                            </select>
                            @error('city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- date_of_birth --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="date_of_birth">Date of Birth</label>
                            <input value="{{$user->date_of_birth}}" required class="form-control @error('date_of_birth') is-invalid @enderror"
                                name="date_of_birth" type="date" onchange="validateDateOfBirth()" id="date_of_birth"
                                max="{{ date('Y-m-d') }}">
                            <div class="invalid-feedback" id="date_of_birth_feedback"></div>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- address --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="address">Address</label>
                            <input value="{{$user->address}}" required class="form-control @error('address') is-invalid @enderror" name="address"
                                id="address" type="text" placeholder="Enter your address">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- description --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="description">Description</label>
                            <textarea required class="form-control @error('description') is-invalid @enderror" name="description"
                                id="description" rows="4" placeholder="Enter a short description or bio"> value="{{$user->description}}"</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>





                    </div>
                    <button type="submit" class="btn btn-primary">Update user</button>
                </form>
            </div>
        </div>

    </div>
@endsection
@push('script')
    <script>
        /**
         * ========================================
         * Image Preview Functions
         * ========================================
         */
        // Trigger background image upload
        function openimagesbg() {
            $('#backgrounpic').click();
        }
        // Preview background image and validate size (max 1MB)
        function backgroundpic() {
            var image = $('#backgrounpic')[0];
            var file = image.files[0];
            if (file) {
                var maxSize = 1 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('The file size exceeds the 1MB limit. Please choose a smaller image.');
                    $('#category_image').val('');
                } else {
                    var preview = document.getElementById('coverimage');
                    var reader = new FileReader();

                    reader.onloadend = function() {

                        preview.style.backgroundImage = 'url(' + reader.result + ')';
                    }

                    if (file) {
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = "";
                    }
                }
            }
        }
        // Trigger profile image upload
        function openimagespp() {
            $('#profilepicinput').click();
        }
        // Preview profileic image and validate size (max 1MB)
        function profilepic() {
            var image = $('#profilepicinput')[0];
            var file = image.files[0];
            if (file) {
                var maxSize = 1 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('The file size exceeds the 1MB limit. Please choose a smaller image.');
                    $('#category_image').val('');
                } else {
                    var preview = document.getElementById('profilepic');
                    var reader = new FileReader();

                    reader.onloadend = function() {

                        preview.style.backgroundImage = 'url(' + reader.result + ')';
                    }

                    if (file) {
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = "";
                    }
                }
            }
        }
        /**
         * ========================================
         * Username Validation
         * ========================================
         * Check if the entered username is available by 
         * making an AJAX request. Add feedback based on the response.
         */
        $('#username').on('blur', function() {
            var username = $(this).val();
            if (username.length > 2) { // Optional: Start checking after 3 characters
                $.ajax({
                    url: '{{ route('check.username') }}',
                    type: 'GET',
                    data: {
                        username: username
                    },
                    success: function(response) {
                        if (response.available) {
                            $('#username').removeClass('is-invalid').addClass('is-valid');
                            $('#username-feedback').text('');
                        } else {
                            $('#username').removeClass('is-valid').addClass('is-invalid');
                            $('#username-feedback').text('Username is already taken.');
                        }
                    }
                });
            } else {
                $('#username').removeClass('is-valid is-invalid');
                $('#username-feedback').text('');
            }
        });
        /**
         * ========================================
         * Email Validation
         * ========================================
         * Validate email by checking if it is already registered.
         */
        $('#email').on('blur', function() {
            var email = $(this).val();
            if (email.length > 0) { // Ensure there is an email entered
                $.ajax({
                    url: '{{ route('check.email.user') }}',
                    type: 'GET',
                    data: {
                        email: email
                    },
                    success: function(response) {
                        if (response.available) {
                            $('#email').removeClass('is-invalid').addClass('is-valid');
                            $('#email-feedback').text('');
                        } else {
                            $('#email').removeClass('is-valid').addClass('is-invalid');
                            $('#email-feedback').text('Email is already taken.');
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.email) {
                            $('#email').removeClass('is-valid').addClass('is-invalid');
                            $('#email-feedback').text(errors.email[0]);
                        }
                    }
                });
            } else {
                $('#email').removeClass('is-valid is-invalid');
                $('#email-feedback').text('');
            }
        });
        /**
         * ========================================
         * Phone Number Validation
         * ========================================
         * Validate phone number by checking if it is already registered.
         */
        $('#phone_num').on('blur', function() {
            var phone_num = $(this).val();
            if (phone_num.length > 0) { // Ensure there is a phone number entered
                $.ajax({
                    url: '{{ route('check.phone.user') }}',
                    type: 'GET',
                    data: {
                        phone_num: phone_num
                    },
                    success: function(response) {
                        if (response.available) {
                            $('#phone_num').removeClass('is-invalid').addClass('is-valid');
                            $('#phone_num_feedback').text('');
                        } else {
                            $('#phone_num').removeClass('is-valid').addClass('is-invalid');

                            $('#phone_num_feedback').text('Phone number is already taken.');
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.phone_num) {
                            $('#phone_num').removeClass('is-valid').addClass('is-invalid');
                            $('#phone_num_feedback').text(errors.phone_num[0]);
                        }
                    }
                });
            } else {
                $('#phone_num').removeClass('is-valid is-invalid');
                $('#phone_num_feedback').text('');
            }
        });
        /**
         * ========================================
         * Phone Number Input Formatting (IntlTelInput)
         * ========================================
         * Automatically set country based on user IP for phone input.
         */
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.querySelector("#phone_num");
            window.intlTelInput(input, {
                initialCountry: "auto",
                geoIpLookup: function(callback) {
                    fetch('https://ipinfo.io/json')
                        .then(response => response.json())
                        .then(data => callback(data.country))
                        .catch(() => callback('us'));
                },
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            });
        });


                /**
         * ========================================
         * Fetch States And Cities Based on Country Selection
         * ========================================
         * Load city options dynamically based on the selected country.
         */

         function getstates() {
            let countryid = $('#country_id').val()

            if (countryid) {
                $.ajax({
                    url: '{{ route('getstates', ':id') }}'.replace(':id', countryid),
                    type: 'GET',
                    success: function(response) {
                        
                        $('#state_id').empty();
                        $('#state_id').append('<option value="" disabled selected>Select your sates</option>');
                        $.each(response, function(index, state) {
                            $('#state_id').append('<option value="' + state.id + '">' + state.state_name +
                                '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }




        }

        function getcities() {
            let stateid = $('#state_id').val()

            if (stateid) {
                $.ajax({
                    url: '{{ route('getcities', ':id') }}'.replace(':id', stateid),
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        
                        $('#city_id').empty();
                        $('#city_id').append('<option value="" disabled selected>Select your city</option>');
                        $.each(response, function(index, city) {
                            $('#city_id').append('<option value="' + city.id + '">' + city.city_name +
                                '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }




        }

        /**
         * ========================================
         * Date of Birth Validation (At Least 18 Years)
         * ========================================
         * Ensure the user is at least 18 years old based on the selected date of birth.
         */
        function validateDateOfBirth() {
            var today = new Date();
            var minDate = new Date(today.setFullYear(today.getFullYear() - 18));
            var minDateString = minDate.toISOString().split('T')[0];
            var selectedDate = $('#date_of_birth').val();

            if (selectedDate > minDateString) {
                $('#date_of_birth').addClass('is-invalid');
                $('#date_of_birth_feedback').text('You must be at least 18 years old.');
            } else {
                $('#date_of_birth').removeClass('is-invalid');
                $('#date_of_birth_feedback').text('');
            }
        }
        // Optional: Validate on form submission
        $('form').on('submit', function(e) {
            validateDateOfBirth();
            if ($('#date_of_birth').hasClass('is-invalid')) {
                e.preventDefault(); // Prevent form submission if invalid
            }
        });
    </script>
@endpush
