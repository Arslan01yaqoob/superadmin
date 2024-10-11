@extends('Layout.layout')
@section('main')
    <div class="container">

        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Category</h1>
                <p>On this page, you can add a new category.</p>
                
                
            </div>
            <div class="part2">
            </div>
        </div>

            <div class="form-div">
                <h2 class="mb-4 text-center">Add New Category</h2>
                <form method="POST" action="{{ route('addcategory') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="category_name">Category Name</label>
                            <input required class="form-control @error('category_name') is-invalid @enderror" name="category_name"
                                type="text" id="category_name" placeholder="Enter category name" maxlength="50">
                            @error('category_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="short_description">Sub Title (Optional):</label>
                            <input class="form-control @error('category_subtitle') is-invalid @enderror"
                                name="category_subtitle" type="text" placeholder="Enter sub title for category"
                                maxlength="100">

                            @error('category_subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="category_image">Category Image:</label>
                            <input required class="form-control @error('category_image') is-invalid @enderror" name="category_image"
                                onchange="validsize()" type="file" id="category_image" accept="image/*">
                            @error('category_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-12 imagecontainer">
                            <img id="image" src="" alt="">

                        </div>




                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>


    </div>
@endsection
@push('script')
    <script type="text/javascript">
    
        function validsize() {
            var image = $('#category_image')[0];
            var file = image.files[0];
            if (file) {
                var maxSize = 1 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('The file size exceeds the 1MB limit. Please choose a smaller image.');
                    $('#category_image').val('');
                } else {
                    var preview = document.getElementById('image');
                    var reader = new FileReader();

                    reader.onloadend = function() {
                        preview.src = reader.result;
                    }

                    if (file) {
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = "";
                    }
                }
            }
        }





    </script>
@endpush
