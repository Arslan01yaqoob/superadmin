@extends('Layout.layout')
@section('main')
    <div class="container">

        <div class="container mt-5">
            <h1>State</h1>
        
            <div class="form-div">
                <h2 class="mb-4 text-center">Add New State</h2>
                <form method="POST" action="{{ route('updatestate',['id'=>$state->id]) }}">
                    @csrf
                    <div class="row">
                        <!-- State Name Input -->
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="state_name">State Name</label>
                            <input required value="{{ $state->state_name }}"
                                class="form-control @error('state_name') is-invalid @enderror" name="state_name"
                                type="text" id="state_name" placeholder="Enter state name" maxlength="50">
                            @error('state_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Country Select Input -->
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="country_id">Country</label>
                            <select required class="form-control @error('country_id') is-invalid @enderror"
                                name="country_id" id="country_id">
                                <option value="{{ $state->country->id }}" selected>{{ $state->country->country_name }}
                                </option>
                                @foreach ($countries as $data)
                                    @if ($data->id != $state->country->id)
                                        <option value="{{ $data->id }}">{{ $data->country_name }}</option>
                                    @endif
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

    </div>
@endsection
