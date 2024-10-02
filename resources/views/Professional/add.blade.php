@extends('Layout.layout')
@section('main')
    <div class="container">
        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Professional</h1>
                <p>On this screen, you can create Professional.</p>
            </div>
            <div class="part2">
            </div>
        </div>
        <div class="container mt-5">
            <div class="form-div">

                <form action="{{ route('createprofessional') }}" id="form" method="POST" enctype="multipart/form-data">
@csrf
                    <h2 class="mb-4 text-center">Add New Professional</h2>
                    <div id="coverimage"
                        style="background-image: url('{{ asset('assets/imgs/placeholders/cover_p.jpg') }}') "
                        class="coverimage">
                        <div class="coverpicinput" onclick="openimagesbg()">
                            <img src="{{ asset('assets/imgs/icons/pen.png') }}" alt="">
                        </div>
                    </div>
                    <div id="profilepic"
                        style="background-image: url('{{ asset('assets/imgs/placeholders/avatar_p.jpg') }}') "
                        class="profilepic">
                        <div class="profilepicinput" onclick="openimagespp()">
                            <img src="{{ asset('assets/imgs/icons/camera.png') }}" alt="">
                        </div>
                    </div>

                    <div class="row">
                        <input type="file" hidden id="backgrounpic" name="backgrounpic" accept="image/*"
                            onchange="backgroundpic()">
                        <input type="file" hidden id="profilepicinput" name="profilepicinput" accept="image/*"
                            onchange="profilepic()">

                        <!-- *********************************************
                                                       *            Merchant Details Section         *
                                                       ********************************************* -->

                        <h5>Professional Details:<Details: class="lead">(required)</Details:>
                        </h5>
                        {{-- name --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="name">Name</label>
                            <input required class="form-control @error('name') is-invalid @enderror" name="name"
                                type="text" id="name" placeholder="Enter your name" maxlength="50">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- username --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="username">Username</label>
                            <input required class="form-control @error('username') is-invalid @enderror" name="username"
                                id="username" type="text" placeholder="Enter your username" maxlength="50">
                            <div id="username-feedback" class="invalid-feedback"></div>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- email --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="email">Email</label>
                            <input required class="form-control @error('email') is-invalid @enderror" name="email"
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
                                <input required class="form-control @error('phone_num') is-invalid @enderror"
                                    name="phone_num" type="tel" id="phone_num" placeholder="Enter phone number"
                                    maxlength="15">
                                @error('phone_num')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="phone_num_feedback" class="invalid-feedback"></div> <!-- Feedback div -->
                            </div>
                        </div>

                        {{-- password --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="password">Password</label>
                            <input required class="form-control @error('password') is-invalid @enderror" name="password"
                                type="password" id="password" placeholder="Enter your password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <!-- *********************************************
                                            *            Merchant Address Details Section         *
                                            ********************************************* -->
                    <h5>Address Details:<Details: class="lead">(required)</Details:>
                    </h5>
                    <div class="row">


                        {{-- country --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="country_id">Country</label>
                            <select onchange="getstates()" required
                                class="form-control @error('country_id') is-invalid @enderror" name="country_id"
                                id="country_id">
                                <option value="" disabled selected>Select your country</option>
                                @foreach ($country as $data)
                                    <option value="{{ $data->id }}">{{ $data->country_name }}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- state --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="state_id">State</label>
                            <select onchange="getcities()" required
                                class="form-control @error('state_id') is-invalid @enderror" name="state_id"
                                id="state_id">
                                <option value="" disabled selected>Select country first</option>
                                @foreach ($country as $data)
                                    <option value="{{ $data->id }}">{{ $data->country_name }}</option>
                                @endforeach
                            </select>
                            @error('state_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- city_id --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="city_id">City</label>
                            <select required class="form-control @error('city_id') is-invalid @enderror" name="city_id"
                                id="city_id">
                                <option value="" disabled selected>Select the state first</option>
                            </select>
                            @error('city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Address --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="address">Address</label>
                            <input required class="form-control @error('address') is-invalid @enderror" name="address"
                                id="address" type="text" placeholder="Enter your address">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Map --}}
                        <div class="col-12">
                            <div id="map"></div>
                        </div>
                        {{-- latitude --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="latitude">Latitude</label>
                            <input id="latitude" name="latitude" class="form-control" type="text" readonly>
                        </div>
                        {{-- longitude --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="longitude">Longitude</label>
                            <input id="longitude" name="longitude" class="form-control" type="text" readonly>
                        </div>
                        {{-- area name --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="area">Area name</label>
                            <input id="area" name="area" class="form-control" type="text">
                        </div>
                        {{-- working range --}}
                        <div class="col-md-6 form-group mb-4">
                            <label for="working_range" class="form-label">Working Range (km)</label>
                            <input type="number" class="form-control" id="working_range" name="working_range" min="1" max="15" step="1" placeholder="Enter working range in km">
                            <div class="invalid-feedback" id="rangeError" style="display: none;">The working range must not exceed 15 km.</div>
                            @error('working_range')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        
                    </div>
                    <!-- *********************************************
                                            *            Business  Details Section         *
                                            ********************************************* -->
                    <h5>Business Details:<Details: class="lead">(required)</Details:>
                    </h5>
                    <div class="row">

                        {{-- category --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="category_id">Category</label>
                            <select required class="form-control @error('category_id') is-invalid @enderror"
                                name="category_id" id="category_id">
                                <option value="" disabled selected>Select the category of your business</option>
                                @foreach ($categories as $data)
                                    <option value="{{ $data->id }}">{{ $data->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- Business Type --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="bussnies_type">Business Type</label>
                            <select required class="form-control @error('bussnies_type') is-invalid @enderror"
                                name="bussnies_type" id="bussnies_type">
                                <option value="" disabled selected>Select the type of your Business</option>
                                <option value="on_site">On-site</option>
                                <option value="home_service">Home Service Only</option>
                                <option value="both">Both</option>
                            </select>
                            @error('bussnies_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        {{-- Working Hours --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="working_hours_start">Working Hours <Details: class="lead">
                                    (Start)</Details:></label>
                            <input required class="form-control @error('working_hours_start') is-invalid @enderror"
                                type="time" id="working_hours_start" name="working_hours_start">
                            @error('working_hours_start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="working_hours_end">Working Hours <Details: class="lead">
                                    (End)
                                </Details:></label>
                            <input required class="form-control @error('working_hours_end') is-invalid @enderror"
                                type="time" id="working_hours_end" name="working_hours_end">
                            @error('working_hours_end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Working Days --}}
                        <div class="col-md-12 form-group mb-4">
                            
                            <label class="form-label">Working Days</label>
                            <div>
                                <div class="form-check d-inline-block me-3">
                                    <input class="check-input" type="checkbox" id="monday" name="working_days[]"
                                        value="Monday">
                                    <label class="form-check-label" for="monday">Monday</label>
                                </div>
                                <div class="form-check d-inline-block me-3">
                                    <input class="check-input" type="checkbox" id="tuesday" name="working_days[]"
                                        value="Tuesday">
                                    <label class="form-check-label" for="tuesday">Tuesday</label>
                                </div>
                                <div class="form-check d-inline-block me-3">
                                    <input class="check-input" type="checkbox" id="wednesday" name="working_days[]"
                                        value="Wednesday">
                                    <label class="form-check-label" for="wednesday">Wednesday</label>
                                </div>
                                <div class="form-check d-inline-block me-3">
                                    <input class="check-input" type="checkbox" id="thursday" name="working_days[]"
                                        value="Thursday">
                                    <label class="form-check-label" for="thursday">Thursday</label>
                                </div>
                                <div class="form-check d-inline-block me-3">
                                    <input class="check-input" type="checkbox" id="friday" name="working_days[]"
                                        value="Friday">
                                    <label class="form-check-label" for="friday">Friday</label>
                                </div>
                                <div class="form-check d-inline-block me-3">
                                    <input class="check-input" type="checkbox" id="saturday" name="working_days[]"
                                        value="Saturday">
                                    <label class="form-check-label" for="saturday">Saturday</label>
                                </div>
                                <div class="form-check d-inline-block me-3">
                                    <input class="check-input" type="checkbox" id="sunday" name="working_days[]"
                                        value="Sunday">
                                    <label class="form-check-label" for="sunday">Sunday</label>
                                </div>

                            </div>
                            @error('working_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 form-group mb-4">
                            <label class="form-label" for="description">Description:<Details: class="lead">(optional)
                                </Details:></label>
                            <textarea class="form-control" name="description" id="" rows="3"></textarea>
                            <button type="submit" class="btn btn-primary m-2">Submit</button>
                        </div>

                    </div>

                </form>

            </div>
        </div>











    </div>
@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmqWGU9Ivs-0c77WGc74OPmo_hxTRPkRc&libraries=places">
    </script>

    <script type="text/javascript">
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
                    url: '{{ route('check.username.proffessional') }}',
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
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector("#phone_num");
            var iti = window.intlTelInput(input, {
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            });

            input.addEventListener("blur", function() {
                var errorMsg = document.querySelector("#phone_num_feedback");

                // Step 1: Check phone number format
                if (!iti.isValidNumber()) {
                    errorMsg.textContent = "Invalid phone number.";
                    input.classList.add("is-invalid");
                } else {
                    input.classList.remove("is-invalid");
                    errorMsg.textContent = "";

                    // Step 2: If valid format, check if the number is unique
                    var phone_num = input.value;
                    if (phone_num.length > 0) { // Ensure there is a phone number entered
                        $.ajax({
                            url: '{{ route('check.phone.professional') }}',
                            type: 'GET',
                            data: {
                                phone_num: phone_num
                            },
                            success: function(response) {
                                if (response.available) {
                                    $('#phone_num').removeClass('is-invalid').addClass(
                                        'is-valid');
                                    $('#phone_num_feedback').text('');
                                } else {
                                    $('#phone_num').removeClass('is-valid').addClass(
                                        'is-invalid');
                                    $('#phone_num_feedback').text(
                                        'Phone number is already taken.');
                                }
                            },
                            error: function(xhr) {
                                var errors = xhr.responseJSON.errors;
                                if (errors.phone_num) {
                                    $('#phone_num').removeClass('is-valid').addClass(
                                        'is-invalid');
                                    $('#phone_num_feedback').text(errors.phone_num[0]);
                                }
                            }
                        });
                    } else {
                        $('#phone_num').removeClass('is-valid is-invalid');
                        $('#phone_num_feedback').text('');
                    }
                }
            });
        });
        /**
         * ========================================
         * Fetch States And Cities Based on Country
         * ========================================
         * Load States And Cities options dynamically based on the selected .
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
                            $('#state_id').append('<option value="' + state.id + '">' + state
                                .state_name +
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

        $('#form').on('keydown', function(event) {
            if (event.key === 'Enter' && event.target.type !== 'textarea') {
                event.preventDefault();
            }
        });
        function initMap() {
            var initialLocation = {
                lat: -34.397,
                lng: 150.644
            };

            var map = new google.maps.Map(document.getElementById('map'), {
                center: initialLocation,
                zoom: 8,
            });

            // Create the marker and make it draggable
            var marker = new google.maps.Marker({
                position: initialLocation,
                map: map,
                draggable: true
            });

            var geocoder = new google.maps.Geocoder();

            function updateLocationFields(latLng) {
                document.getElementById('latitude').value = latLng.lat();
                document.getElementById('longitude').value = latLng.lng();

                // Reverse geocoding to get the address and area
                geocoder.geocode({
                    'location': latLng
                }, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            // Get the full formatted address
                            document.getElementById('address').value = results[0].formatted_address;

                            // Extract the area from the address components
                            var addressComponents = results[0].address_components;
                            var area = '';

                            // Loop through the address components to find a suitable area name (locality, sublocality, neighborhood, etc.)
                            for (var i = 0; i < addressComponents.length; i++) {
                                var types = addressComponents[i].types;
                                if (types.includes('sublocality') || types.includes('locality') || types.includes(
                                        'neighborhood')) {
                                    area = addressComponents[i].long_name;
                                    break;
                                }
                            }

                            // Set the area name input field
                            document.getElementById('area').value = area;
                        }
                    }
                });
            }


            // Add an event listener to update the latitude, longitude, and address when the marker is dragged
            marker.addListener('dragend', function() {
                var newLatLng = marker.getPosition();
                updateLocationFields(newLatLng);
            });

            // Initialize the autocomplete functionality for address input
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            // When a user selects an address from the dropdown, move the marker to that location
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }

                // Move the map and marker to the selected place
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                updateLocationFields(place.geometry.location);
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
    const inputField = document.getElementById('working_range');
    const errorMessage = document.getElementById('rangeError');

    // Add an event listener to the input field
    inputField.addEventListener('input', function() {
        const value = parseInt(inputField.value, 10);

        // Check if the value is greater than 15
        if (value > 15) {
            inputField.classList.add('is-invalid');
            errorMessage.style.display = 'block';
        } else {
            inputField.classList.remove('is-invalid');
            errorMessage.style.display = 'none';
        }
    });
});

        // Initialize the map when the window loads
        window.onload = initMap;
    </script>
@endpush
