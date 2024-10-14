@extends('Layout.layout')
@section('main')
    <div class="container">
        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Services Names</h1>
                <p>Use this page to effortlessly create and manage service names.</p>
            </div>
            <div class="part2">
            </div>
        </div>



        <div class="form-div ">
            <h2 class="mb-4 text-center">Add New Service Name</h2>
            <form method="POST" action="{{route('addnewservicename')}}">

                @csrf
                <div class="row">
                    <div class="col-md-6 form-group mb-2">
                        <label class="form-label" for="service_name">Service Name</label>
                        <input required class="form-control @error('service_name') is-invalid @enderror" name="service_name"
                            type="text" id="service_name" placeholder="Enter service name" maxlength="50">
                        @error('service_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-6 form-group mb-2">
                        <label class="form-label" for="category_id">Category</label>
                        <select required class="form-control @error('category_id') is-invalid @enderror" name="category_id"
                            onchange="getniches()" id="category_id">
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $data)
                                <option value="{{ $data->id }}">{{ $data->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-6 form-group mb-2">
                        <label class="form-label" for="niche_id">Niche</label>
                        <select required class="form-control @error('niche_id') is-invalid @enderror" name="niche_id"
                            id="niche_id">
                            <option value="" disabled selected>Select the category first</option>

                        </select>
                        @error('niche_id')
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
@push('script')
    <script type="text/javascript">
        function getniches() {
            var cateid = $('#category_id').val();
            if (cateid) {
                $.ajax({
                    url: '{{ route('getniches', ':id') }}'.replace(':id', cateid),
                    type: 'GET',
                    success: function(response) {
                        $('#niche_id').empty();
                        $('#niche_id').append('<option value="" disabled selected>Select your Niche</option>');
                        $.each(response, function(index, nicehs) {
                            $('#niche_id').append('<option value="' + nicehs.id + '">' + nicehs
                                .niche_name +
                                '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })
            }
        }

    </script>
@endpush
