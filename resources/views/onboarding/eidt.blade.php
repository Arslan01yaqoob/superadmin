@extends('Layout.layout')
@section('main')
    <div class="container">

        <div class="top-heading px-1 py-2 d-flex">
            <div class="part1">
                <h1>Onboarding Advertisements</h1>
                <p>On this page, you can edit an existing onboarding advertisement.</p>
                
                
            </div>
            <div class="part2">
            </div>
        </div>
            <div class="form-div">
                <h2 class="mb-4 text-center">Add New Onboarding Item</h2>
                <form method="POST" action="{{ route('updateonboarding',['id'=>$onboarding->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="title">Title</label>
                            <input required class="form-control @error('title') is-invalid @enderror" name="title"
                                type="text" value="{{$onboarding->title}}" id="title" placeholder="Enter title" maxlength="50">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="short_description">Sub Title (Optional):</label>
                            <input class="form-control @error('category_subtitle') is-invalid @enderror"
                                name="category_subtitle" value="{{$onboarding->subtitle}}" type="text" placeholder="Enter sub title for onboarding"
                                maxlength="100">
                            @error('category_subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="onboarding_image">Onboarding Image:</label>
                            <input  class="form-control @error('onboarding_image') is-invalid @enderror"
                                name="onboarding_image" type="file" id="onboarding_image"
                                accept="image/png, image/jpeg, application/json">
                            @error('onboarding_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 imagecontainer">
                            <img  id="image" src="{{asset($onboarding->image_url)}}" alt="">
                            <lottie-player id="animation" src="{{asset($onboarding->image_url)}}" background="transparent" speed="1"
                                style="width: 100px; height: 100px;" loop autoplay>
                        </div>



                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

    </div>
@endsection
@push('script')

    <script type="text/javascript">
        document.getElementById('onboarding_image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const image = document.getElementById('image');
            const animation = document.getElementById('animation');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const fileType = file.type;

                    if (fileType.startsWith('image/')) {
                        image.src = e.target.result;
                        image.style.display = 'block';
                        animation.style.display = 'none';
                    } else if (fileType === 'application/json') {
                        animation.load(e.target.result);
                        animation.style.display = 'block';
                        image.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
            }
        });


    </script>
@endpush
