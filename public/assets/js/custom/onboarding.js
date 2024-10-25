function getOnboardings() {
    startLoading(); // Start the loading animation
    let contentArea = $('#content-area'); // Define the content area where the HTML will be injected

    $.ajax({
        url: getOnboardingads,
        method: 'GET',
        success: function (response) {
            // Inject the new HTML content into the content area
            contentArea.html(`
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>Onboarding Advertisements</h1>
                            <p>Welcome to the Onboarding Ads management screen.</p>
                        </div>
                        <div class="part2">
                <a onclick="OboardingAddpage()">Add New</a>
                        </div>
                    </div>

                  

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Subtitle</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${response.map(ad => `
                                <tr>
                                    <td>${ad.id}</td>
                                    <td>
                                        <lottie-player id="animation" src="${ad.image_url}" background="transparent"
                                            speed="1" style="width: 100px; height: 100px;" loop autoplay>
                                        </lottie-player>
                                    </td>
                                    <td>${ad.title}</td>
                                    <td>${ad.subtitle}</td>
                                    <td>
                                        <label class="switch">
                                            <input onchange="updateOnboardingAdStatus(${ad.id})" ${ad.status == 1 ? 'checked' : ''} type="checkbox">
                                            <span class="slider"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="button-container">
                                            <a href="{{ route('onboardingupdatepage', ['id' => ${ad.id}]) }}" class="btn btn-info">
                                                <img src="${editIconUrl}" alt="">
                                            </a>
                                            <a onclick="deletead(${ad.id})" class="btn btn-danger">
                                                <img src="${deleteIconUrl}" alt="">
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `);
            stopLoading();
        },
        error: function (error) {
            console.error('Error fetching onboarding ads:', error);
            stopLoading();
        }
    });
}

function OboardingAddpage() {
    startLoading();
    let contentArea = $('#content-area');


    contentArea.html(`
        <div class="container">
            <div class="top-heading px-1 py-2 d-flex">
                <div class="part1">
                    <h1>Onboarding Advertisements</h1>
                    <p>On this page, you can add a new onboarding advertisement.</p>
                </div>
                <div class="part2"></div>
            </div>

            <div class="form-div">
                <h2 class="mb-4 text-center">Add New Onboarding Item</h2>
                <form id="onboardingaddform" >
             
                    <div class="row">
                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="title">Title</label>
                            <input required class="form-control" name="title"
                                type="text" id="title" placeholder="Enter title" maxlength="50">
                           
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="short_description">Sub Title (Optional):</label>
                            <input class="form-control "
                                name="category_subtitle" id="category_subtitle" type="text" placeholder="Enter sub title for onboarding"
                                maxlength="100">
                           
                        </div>

                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="onboarding_image">Onboarding Image:</label>
                            <input required class="form-control "
                                name="onboarding_image" type="file" id="onboarding_image"
                                accept="image/png, image/jpeg, application/json">
                            
                        </div>

                        <div class="col-md-12 imagecontainer">
                            <img id="image" src="" alt="">
                            <lottie-player id="animation" src="" background="transparent" speed="1"
                                style="width: 100px; height: 100px;" loop autoplay></lottie-player>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    `);

    stopLoading();
    // giving preview to lottiefiles icons
    document.getElementById('onboarding_image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const image = document.getElementById('image');
        const animation = document.getElementById('animation');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
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


    document.getElementById('onboardingaddform').addEventListener('submit', function (event) {
        event.preventDefault();


        let title = document.getElementById('title').value.trim();
        let subtitle = document.getElementById('category_subtitle').value.trim();
        let onboardingImage = document.getElementById('onboarding_image').files[0];

        if (title === '') {
            if (!titleError) {
                titleError = document.createElement('div');
                titleError.id = 'titleError';
                document.getElementById('title').parentElement.appendChild(titleError);
            }
            titleError.textContent = 'Title is required.';
            return;
        }

        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let formData = new FormData();
        formData.append('title', title);
        formData.append('subtitle', subtitle);
        formData.append('onboarding_image', onboardingImage);
        formData.append('_token', csrfToken);

        // AJAX request
        $.ajax({
            url: addnewonboardingad,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Onboarding item added successfully!',
                    });
                    document.getElementById('onboardingaddform').reset();
                    getOnboardings();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '',
                    });
                    getOnboardings();
                }
            },

            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add onboarding item. Only three advertisements are allowed at a time. ' + error,
                });

                getOnboardings();
            }
        });
    });





}
// update status of onboarding ad
function updateOnboardingAdStatus(id) {
    $.ajax({
        url: updateonboardingstatus,
        type: "Get",
        data: {
            _token: "{{ csrf_token() }}",
            id: id,
        },
        success: function (response) {
            if (response.success) {
                console.log("Status updated successfully!");
            } else {
                console.log("Failed to update status.");
            }
        },
    });
}

// delete onboarding add
function deletead(id) {
    let addid = id;

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: deleteonbaordingad,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    addid: addid,
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "The item has been successfully deleted.",
                            icon: "success",
                            confirmButtonText: "OK"
                        });

                        getOnboardings();
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "There was an issue deleting the item.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });

                        
                        getOnboardings();
                    }
                },
                error: function () {
                    Swal.fire({
                        title: "Error!",
                        text: "There was an error with the request.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    
                    getOnboardings();
                }
            });
        }
    });
}





// loading bars
function startLoading() {
    const loadingBar = document.getElementById('top-loader');
    loadingBar.style.backgroundColor = '#3498db';
    loadingBar.style.width = '70%';
}
function stopLoading() {
    const loadingBar = document.getElementById('top-loader');
    loadingBar.style.width = '100%';
    setTimeout(() => {
        loadingBar.style.backgroundColor = 'transparent';
        loadingBar.style.width = '0%';
    }, 300);
}