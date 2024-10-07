@extends('Layout.layout')
@section('main')
    <div class="container">
        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Professional Details</h1>
                <p>Here you can view all the information related to the professional</p>
            </div>
            <div class="part2">
            </div>
        </div>


        <div class="card p-4">

            <div class="row">

                <div class="col-md-6">
                    <h4>Personal Details:</h4>

                    <table class="detailstable table table-bordered table-striped">
                        <thead class="thead-dark border">
                            <tr>
                                <th scope="col">Fields</th>
                                <th scope="col">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Id</td>
                                <td>{{ $professional->id }}</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>{{ $professional->name }}</td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>{{ $professional->username }}</td>
                            </tr>
                            <tr>
                                <td>E-mail</td>
                                <td>{{ $professional->email ?: '' }}</td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td>{{ $professional->phone_number ?: '' }}</td>
                            </tr>
                            <tr>
                                <td>Profile Picture</td>
                                <td>
                                    <img class="profile-image" src="{{ asset($professional->logo_url) }}"
                                        alt="Profile Picture">
                                </td>
                            </tr>
                            <tr>
                                <td>Cover Image</td>
                                <td>
                                    <img class="profile-image" src="{{ asset($professional->cover_image_url) }}"
                                        alt="Cover Image">
                                </td>
                            </tr>
                        </tbody>
                    </table>


                </div>
                <div class="col-md-6">
                    <h4>Business Details:</h4>

                    <table class="detailstable table table-bordered table-striped">
                        <thead class="thead-dark border">
                            <tr>
                                <th scope="col">Fields</th>
                                <th scope="col">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Business type</td>
                                <td>{{ $professional->business_type }}</td>
                            </tr>
                            <tr>
                                <td>Business Category</td>
                                <td>{{ $professional->category->category_name }}</td>
                            </tr>
                            <tr>
                                <td>Business Category image</td>
                                <td>
                                    <img class="profile-image" src="{{ asset($professional->category->category_image) }}"
                                        alt="Cover Image">
                                </td>
                            </tr>
                            <tr>
                                <td>Working Rnage</td>
                                <td>{{ $professional->working_range }} km</td>
                            </tr>

                            <tr>
                                <td>Working Hours</td>
                                <td>{{ $professional->working_time_start }} to {{ $professional->working_time_end }}</td>
                            </tr>
                            <tr>
                                <td>Working Days </td>
                                <td>{{ $professional->working_days }}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{{ $professional->description }}</td>
                            </tr>



                        </tbody>
                    </table>


                </div>


                <h3>Address Details:</h3>

                {{-- country --}}
                <div class="col-md-6 form-group mb-4">
                    <label class="form-label" for="country_id">Country</label>
                    <input class="form-control" value="{{$professional->country->country_name}}" type="text" readonly>

                </div>
                {{-- state --}}
                <div class="col-md-6 form-group mb-4">
                    <label class="form-label" for="state_id">State</label>
                    <input class="form-control" value="{{$professional->state->state_name}}" type="text" readonly>
                  
                </div>
                {{-- city_id --}}
                <div class="col-md-6 form-group mb-4">
                    <label class="form-label" for="city_id">City</label>
                    <input class="form-control" value="{{$professional->city->city_name}}" type="text" readonly>

                </div>
                {{-- Address --}}
                <div class="col-md-6 form-group mb-4">
                    <label class="form-label" for="address">Address</label>
                    <input class="form-control" value="{{$professional->address}}" type="text" readonly>
                </div>
                {{-- area name --}}
                <div class="col-md-6 form-group mb-4">
                    <label class="form-label" for="area">Area name</label>
                    <input class="form-control" value="{{$professional->area_name}}" id="area" name="area" class="form-control" type="text">
                </div>

                {{-- Map --}}
                <div class="col-12">
                    <div id="map"></div>
                </div>
                {{-- latitude --}}
                <div class="col-md-6 form-group mb-4">
                    <label class="form-label" for="latitude">Latitude</label>
                    <input class="form-control" id="latitude" value="{{$professional->latitude}}" name="latitude" class="form-control" type="text" readonly>
                </div>
                {{-- longitude --}}
                <div class="col-md-6 form-group mb-4">
                    <label class="form-label" for="longitude">Longitude</label>
                    <input class="form-control" id="longitude" value="{{$professional->logitude}}" name="longitude" class="form-control" type="text" readonly>
                </div>


            </div>


        </div>




    </div>
@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmqWGU9Ivs-0c77WGc74OPmo_hxTRPkRc&libraries=places">
    </script>
    
<script type="text/javascript">

$(document).ready(function(){
 
    initMap();
});

function initMap() {
        // Get the latitude and longitude from the input fields
        const latitude = parseFloat(document.getElementById('latitude').value);
        const longitude = parseFloat(document.getElementById('longitude').value);
        
        // Create a map centered at the latitude and longitude
        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: latitude, lng: longitude },
            zoom: 15, // Adjust the zoom level as needed
        });

        // Add a marker at the latitude and longitude
        new google.maps.Marker({
            position: { lat: latitude, lng: longitude },
            map: map,
            title: "Professional's Location",
        });
    }
    
    // Load the map once the window has finished loading

</script>
@endpush




















    </div>
@endsection
