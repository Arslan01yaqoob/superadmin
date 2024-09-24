@extends('Layout.layout')
@section('main')
    <div class="container">


        <div class="container mt-5">
            <h1>Onboarding</h1>

            <div class="form-div">
                <h2 class="mb-4 text-center">Add New Onboarding Item</h2>
                <form method="POST" action="{{ route('addonboarding') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="title">Title</label>
                            <input required class="form-control @error('title') is-invalid @enderror" name="title"
                                type="text" id="title" placeholder="Enter title" maxlength="50">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="short_description">Sub Title (Optional):</label>
                            <input class="form-control @error('category_subtitle') is-invalid @enderror"
                                name="category_subtitle" type="text" placeholder="Enter sub title for onboarding"
                                maxlength="100">
                            @error('category_subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="onboarding_image">Onboarding Image:</label>
                            <input required class="form-control @error('onboarding_image') is-invalid @enderror"
                                name="onboarding_image" onchange="showImagePreview()" type="file" id="onboarding_image"
                                accept="image/png, image/jpeg, application/json">
                            @error('onboarding_image')
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

    </div>
@endsection
@push('script')
    <script type="text/javascript">
        function showImagePreview() {
            var image = $('#addonboarding')[0];
            var file = image.files[0];

            if (file) {
                var preview = document.getElementById('image');
                var reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                }

                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
@endpush
