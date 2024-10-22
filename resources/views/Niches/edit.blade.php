@extends('Layout.layout')
@section('main')

    <div class="container">
        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Niches</h1>
                <p>This page allows you to create new Niches</p>
            </div>
            <div class="part2">
             
            </div>

        </div>

        <div class="form-div ">
            <h2 class="mb-4 text-center">Add New Niche</h2>
            <form method="POST" action="{{ route('updateniche',['id'=>$niche->id]) }}">

                @csrf
                <div class="row">
                    <div class="col-md-6 form-group mb-2">
                        <label class="form-label" for="niche_name">Niche Name</label>
                        <input required class="form-control @error('niche_name') is-invalid @enderror" name="niche_name"
                            type="text" value="{{$niche->niche_name}}" id="niche_name" placeholder="Enter niche name" maxlength="50">
                        @error('niche_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-2">
                        <label class="form-label" for="niche_category_id">Niche Category</label>
                        <select required class="form-control @error('niche_category_id') is-invalid @enderror"
                            name="niche_category_id" id="niche_category_id">

                            <option value="{{ $niche->category->id }}" selected>{{ $niche->category->category_name }}</option>

                            @foreach ($categories as $data)
                                @if ($data->id != $niche->category->id)
                                    <option value="{{ $data->id }}">{{ $data->category_name }}</option>
                                @endif
                            @endforeach
                            
                            </select>
                        @error('niche_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-2">
                        <label class="form-label" for="niche_description">Niche Description</label>
                        <textarea class="form-control @error('niche_description') is-invalid @enderror" name="niche_description"
                            id="niche_description" placeholder="Enter niche description" rows="3" maxlength="255"></textarea>
                        @error('niche_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6 form-group mb-2">
                        <button class="btn btn-primary">submit</button>
                        </div>
    
                </div>
            </form>
        </div>






    </div>


    
@endsection
