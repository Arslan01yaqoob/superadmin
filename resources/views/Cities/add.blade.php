@extends('Layout.layout')
@section('main')
    <div class="container">

        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>City</h1>
                <p>On this page, you can add a new city.</p>
                
                
            </div>
            <div class="part2">
            </div>
        </div>

           
            <div class="form-div">
                <h2 class="mb-4 text-center">Add New City</h2>
                <form method="POST" action="{{ route('addcountry') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="city_name">City Name</label>
                            <input required class="form-control @error('city_name') is-invalid @enderror" name="city_name"
                                type="text" id="city_name" placeholder="Enter city name" maxlength="50">
                            @error('city_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Country Select Input -->
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="country_id">Country</label>
                            <select required onchange="getcities()"
                                class="form-control @error('country_id') is-invalid @enderror" name="country_id"
                                id="country_id">
                                <option value="" disabled selected>Select Country</option>
                                
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                @endforeach

                            </select>
                            @error('country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="state_id">State</label>
                            <select required class="form-control @error('state_id') is-invalid @enderror" name="state_id"
                                id="state_id">
                                <option value="" selected disabled>Select the country first</option>
                            </select>
                            @error('state_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            
            </div>


    </div>
    
@endsection
@push('script')
    <script type="text/javascript">
        
        function getcities() {
            let countryid = $('#country_id').val()

            if (countryid) {
                $.ajax({
                    url: '{{ route('getstates', ':id') }}'.replace(':id', countryid),
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        
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


    </script>
@endpush
