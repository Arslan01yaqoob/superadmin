@extends('Layout.layout')
@section('main')
    <div class="container">
        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Merchant</h1>
                <p>On this screen, you can create Merchants.</p>
            </div>
            <div class="part2">
            </div>
        </div>
        <div class="container mt-5">
            <div class="form-div">
                <h2 class="mb-4 text-center">Add New Merchant</h2>
                <div id="coverimage" style="background-image: url('{{ asset('assets/imgs/placeholders/cover.jpg') }}') "
                    class="coverimage">
                    <div class="coverpicinput" onclick="openimagesbg()">
                        <img src="{{ asset('assets/imgs/icons/pen.png') }}" alt="">
                    </div>
                </div>
                <div id="profilepic" style="background-image: url('{{ asset('assets/imgs/placeholders/avatar.jpg') }}') "
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

                    <h5>Merchant:<Details: class="lead">(required)</Details:>
                    </h5>
                    {{-- name --}}
                    <div class="col-md-6 form-group mb-4">
                        <label class="form-label" for="name">Name</label>
                        <input required class="form-control @error('name') is-invalid @enderror" name="name"
                            type="text" id="name" placeholder="Enter city name" maxlength="50">
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
                            <input required class="form-control @error('phone_num') is-invalid @enderror" name="phone_num"
                                type="tel" id="phone_num" placeholder="Enter phone number" maxlength="15">
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
                    {{-- confirm_password --}}
                    <div class="col-md-6 form-group mb-4">
                        <label class="form-label" for="confirm_password">Confirm Password</label>
                        <input required class="form-control @error('confirm_password') is-invalid @enderror"
                            name="confirm_password" type="password" id="confirm_password"
                            placeholder="Confirm your password">
                        @error('confirm_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="confirm_password_feedback" class="invalid-feedback"></div> <!-- Feedback div -->
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
                            class="form-control @error('state_id') is-invalid @enderror" name="state_id" id="state_id">
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

                </div>
                <!-- *********************************************
                                    *            Business  Details Section         *
                                    ********************************************* -->
                <h5>Business Details:<Details: class="lead">(required)</Details:></h5>
                    <div class="row">

                        {{-- country --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="country_id">Country</label>
                            <select required class="form-control @error('country_id') is-invalid @enderror"
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


                        {{-- Working Hours --}}
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="working_hours_start">Working Hours <Details: class="lead">(Start)</Details:></label>
                            <input required class="form-control @error('working_hours_start') is-invalid @enderror"
                                type="time" id="working_hours_start" name="working_hours_start">
                            @error('working_hours_start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="working_hours_end">Working Hours <Details: class="lead">(End)</Details:></label>
                            <input required class="form-control @error('working_hours_end') is-invalid @enderror"
                                type="time" id="working_hours_end" name="working_hours_end">
                            @error('working_hours_end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 form-group mb-4">
                            <label class="form-label" for="description">Description:<Details: class="lead">(optional)</Details:></label>
                            <textarea class="form-control" name="description" id=""  rows="3"></textarea>

                        </div>





                        
                    </div>




            </div>


        </div>











    </div>
@endsection
@push('script')
    <script type="text/javascript">
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

        // Initialize the map when the window loads
        window.onload = initMap;
    </script>
@endpush
