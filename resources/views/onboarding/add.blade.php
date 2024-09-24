@extends('Layout.layout')
@section('main')
<div class="container">

    
    <div class="container mt-5">
        <h1 >Onboarding</h1>

        <div class="form-div">
            <h2 class="mb-4 text-center">Add New Onboarding Item</h2>
            <form method="POST" action="{{ route('addcategory') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group mb-2">
                        <label class="form-label" for="title">Title</label>
                        <input required class="form-control @error('title') is-invalid @enderror" 
                               name="title" type="text" id="title" 
                               placeholder="Enter title" maxlength="50">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 form-group mb-2">
                        <label class="form-label" for="short_description">Sub Title (Optional):</label>
                        <input class="form-control @error('category_subtitle') is-invalid @enderror"
                               name="category_subtitle" type="text" 
                               placeholder="Enter sub title for onboarding" maxlength="100">
                        @error('category_subtitle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="col-md-6 form-group mb-2">
                        <label class="form-label" for="onboarding_image">Onboarding Image:</label>
                        <input required class="form-control @error('onboarding_image') is-invalid @enderror" 
                               name="onboarding_image" onchange="validsize()" 
                               type="file" id="onboarding_image" accept="image/png, image/jpeg, application/json">
                        @error('onboarding_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-12 imagecontainer">
                        <img id="image" src="" alt="" class="image-preview">
                        <div id="json-preview" class="json-preview" ></div>
                    </div>
                    

                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>    
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js"></script>
<script type="text/javascript">

document.addEventListener("DOMContentLoaded", function() {
    var animationData = {
      "v": "5.5.2",
      "fr": 50,
      "ip": 0,
      "op": 155,
      "w": 500,
      "h": 500,
      "nm": "Logo Animation",
      "ddd": 0,
      "assets": [],
      "layers": [
        // ... include all the layers from your JSON here
      ],
      "markers": []
    };

    var animation = lottie.loadAnimation({
      container: document.getElementById('lottie-animation'),
      renderer: 'svg',
      loop: true,
      autoplay: true,
      animationData: animationData
    });
  });

function validsize() {
      var imageInput = document.getElementById('onboarding_image');
      var file = imageInput.files[0];
      var previewImage = document.getElementById('image');
      var jsonPreview = document.getElementById('json-preview');
      var lottieContainer = document.getElementById('lottie-animation');
  
      if (file) {
        var reader = new FileReader();
  
        // Check if the selected file is an image
        if (file.type.startsWith('image/')) {
          reader.onloadend = function() {
            previewImage.src = reader.result;
            previewImage.classList.add('show'); // Show the image with animation
            jsonPreview.classList.remove('show'); // Hide JSON preview
            jsonPreview.style.display = 'none';   // Ensure JSON preview is hidden
            lottieContainer.style.display = 'none'; // Hide Lottie animation
          }
          reader.readAsDataURL(file);
        } 
        // Check if the selected file is a JSON file
        else if (file.type === 'application/json') {
          reader.onloadend = function() {
            try {
              var jsonData = JSON.parse(reader.result);
              jsonPreview.textContent = JSON.stringify(jsonData, null, 2); // Pretty-print JSON
              jsonPreview.classList.add('show');  // Show the JSON preview with animation
              previewImage.classList.remove('show');   // Hide image preview
              previewImage.style.display = 'none';   // Ensure image preview is hidden
              lottieContainer.style.display = 'block'; // Show Lottie animation
  
              // Show Lottie animation
              var animation = lottie.loadAnimation({
                container: lottieContainer, // the DOM element
                renderer: 'svg', // render as SVG
                loop: true, // loop the animation
                autoplay: true, // start playing the animation automatically
                animationData: animationData // your animation data
              });
  
            } catch (error) {
              jsonPreview.textContent = "Invalid JSON file.";
              jsonPreview.classList.add('show');  // Show error message with animation
              previewImage.classList.remove('show');   // Hide image preview
              previewImage.style.display = 'none';   // Ensure image preview is hidden
              lottieContainer.style.display = 'none'; // Hide Lottie animation
            }
          }
          reader.readAsText(file); // Read as text for JSON
        } else {
          previewImage.src = "";
          previewImage.classList.remove('show');   // Hide image preview
          jsonPreview.classList.remove('show');     // Hide JSON preview
          jsonPreview.style.display = 'none';         // Ensure JSON preview is hidden
          lottieContainer.style.display = 'none'; // Hide Lottie animation
        }
      } else {
        previewImage.src = "";
        previewImage.classList.remove('show');       // Hide image preview
        jsonPreview.classList.remove('show');         // Hide JSON preview
        jsonPreview.style.display = 'none';            // Ensure JSON preview is hidden
        lottieContainer.style.display = 'none'; // Hide Lottie animation
      }
    }
  </script>
  

@endpush