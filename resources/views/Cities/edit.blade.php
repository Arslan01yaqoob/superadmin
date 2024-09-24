@extends('Layout.layout')
@section('main')
    <div class="container">


        <div class="container mt-5">
            <h1>City</h1>
            <div class="form-div">
                <h2 class="mb-4 text-center">Edit City</h2>
                <form method="POST" action="{{ route('updatecity', ['id' => $city->id]) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="city_name">City Name</label>
                            <input required value="{{ $city->city_name }}"
                                class="form-control @error('city_name') is-invalid @enderror" name="city_name"
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
                                <option value="{{ $city->country->id }}" selected>{{ $city->country->country_name }}
                                </option>
                                @foreach ($countries as $country)
                                    @if ($country->id != $city->country->id)
                                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endif
                                @endforeach

                            </select>
                            @error('country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="state_id">State</label>
                            <select required class="form-control @error('state_id') is-invalid @enderror" name="state_id" id="state_id">
                                <option value="{{ $city->state->id }}" selected>{{ $city->state->state_name }}</option>
                                @foreach ($states as $data)
                                    @if ($data->id != $city->state->id)
                                        <option value="{{ $data->id }}">{{ $data->state_name }}</option>
                                    @endif
                                @endforeach

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


    </div>
@endsection
