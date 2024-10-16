@extends('Layout.layout')
@section('main')



    <div class="container">
        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Countries</h1>
                <p>Here, you can easily add country as needed.</p>
            </div>
            <div class="part2">
            </div>
        </div>  
        <div class="form-div">
            <h2 class="mb-4 text-center">Add New Country</h2>
            <form method="POST" action="{{ route('addcountry') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group mb-4">
                        <label class="form-label" for="country_name">Country Name</label>
                        <input required class="form-control @error('country_name') is-invalid @enderror" name="country_name"
                            type="text" id="country_name" placeholder="Enter country name" maxlength="50">
                        @error('country_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>




    
@endsection
