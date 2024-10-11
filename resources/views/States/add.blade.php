@extends('Layout.layout')
@section('main')

<div class="container">

    <div class="top-heading px-1 py-2 d-flex">
        <div class="part1">
            <h1>States</h1>
            <p>This page allows you to create States as needed.</p>
        </div>
        <div class="part2">
            <a href="{{ route('addnestatepage') }}">Add New</a>
        </div>
    </div>

        
        <div class="form-div">
            <h2 class="mb-4 text-center">Add New State</h2>
            <form method="POST" action="{{route('addstate')}}">
                @csrf
                <div class="row">
                    <!-- State Name Input -->
                    <div class="col-md-6 form-group mb-4">
                        <label class="form-label" for="state_name">State Name</label>
                        <input required class="form-control @error('state_name') is-invalid @enderror" name="state_name"
                            type="text" id="state_name" placeholder="Enter state name" maxlength="50">
                        @error('state_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Country Select Input -->
                    <div class="col-md-6 form-group mb-4">
                        <label class="form-label" for="country_id">Country</label>
                        <select required class="form-control @error('country_id') is-invalid @enderror" name="country_id" id="country_id">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

</div>

@endsection
