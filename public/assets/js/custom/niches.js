//  all niches 
function getNiches() {
    startLoading(); // Start the loading animation
    let contentArea = $('#content-area'); // Define the content area where the HTML will be injected

    $.ajax({
        url: nichesUrl, // Make sure this URL points to your API endpoint for fetching niches
        method: 'GET',
        success: function (response) {


            let nichesTable = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">                
                            <h1>Niches</h1>
                            <p>On this screen, you can create, add, or delete Niches.</p>
                        </div>
                        <div class="part2">
                            <a onclick="nicheAddPage()">Add New</a>
                        </div>
                    </div>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Niche Name</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Active Services</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            response.forEach(function (data, index) {
                nichesTable += `
                    <tr>
                        <td>${data.id}</td>
                        <td>${data.niche_name}</td>
                        <td>${data.category.category_name}</td>
                        <td>${data.servicesname_count} Active Services</td> <!-- Random number for Active Services -->
                        <td>
                            <label class="switch">
                                <input onchange="updateNicheStatus(${data.id})" ${data.status == 1 ? 'checked' : ''} type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <div class="button-container">
                                <a onclick="nicheEditPage(${data.id})" class="btn btn-info">
                                    <img src="${editIconUrl}" alt="Edit">
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            });

            nichesTable += `
                        </tbody>
                    </table>
                </div>
            `;

            contentArea.html(nichesTable);
            $('#datatable').DataTable();
            stopLoading();
        },
        error: function (error) {
            console.error('Error fetching niches:', error);
            stopLoading();
        }
    });
}
// niche edit page 
function nicheEditPage(id) {


    startLoading(); // Start the loading animation
    let contentArea = $('#content-area');

    $.ajax({
        url: nichesUpdatePage,
        method: 'get',
        data: { id: id },
        success: function (response) {
            let niche = response.Niche;
            let categories = response.Categories;

            let nicheEditPage = `
            <div class="container">
                <div class="top-heading px-1 py-2 d-flex">
                    <div class="part1">
                        <h1>Niches</h1>
                        <p>This page allows you to create new Niches</p>
                    </div>
                    <div class="part2"></div>
                </div>

                <div class="form-div">
                    <h2 class="mb-4 text-center">Edit Niche</h2>
                    <form id="nicheEditForm">
                        <div class="row">
                            <input hidden value="${niche.id}" id="niche_id" name="niche_id">
                            <div class="col-md-6 form-group mb-2">
                                <label class="form-label" for="niche_name">Niche Name</label>
                                <input required class="form-control" name="niche_name"
                                    type="text" value="${niche.niche_name}" id="niche_name" placeholder="Enter niche name" maxlength="50">
                            </div>
                            <div class="col-md-6 form-group mb-2">
                                <label class="form-label" for="niche_category_id">Niche Category</label>
                                <select required class="form-control" name="niche_category_id" id="niche_category_id">
                                    <option value="${niche.category.id}" selected>${niche.category.category_name}</option>`;

                                        categories.forEach(category => {
                                            if (category.id !== niche.category.id) {
                                                nicheEditPage += `<option value="${category.id}">${category.category_name}</option>`;
                                            }
                                        });

                                        nicheEditPage += `
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-2">
                                <label class="form-label" for="niche_description">Niche Description</label>
                                <textarea class="form-control" name="niche_description"
                                    id="niche_description" placeholder="Enter niche description" rows="3" maxlength="255">${niche.niche_description}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-2">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>`;

            contentArea.html(nicheEditPage);
            stopLoading(); // Stop loading animation

            document.getElementById('nicheEditForm').addEventListener('submit', function (event) {
                event.preventDefault();

                let nicheId = document.getElementById('niche_id').value.trim();
                let nicheName = document.getElementById('niche_name').value.trim();
                let nicheCategory = document.getElementById('niche_category_id').value.trim();
                let valid = true;

                // Validate fields
                if (nicheName === '') {
                    Swal.fire({ icon: 'warning', title: 'Validation Error', text: 'Niche name is required.' });
                    valid = false;
                }
                if (nicheCategory === '') {
                    Swal.fire({ icon: 'warning', title: 'Validation Error', text: 'Niche category is required.' });
                    valid = false;
                }
                if (!valid) return;

                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let formData = new FormData();
                formData.append('id', nicheId);
                formData.append('niche_name', nicheName);
                formData.append('niche_category_id', nicheCategory);
                formData.append('niche_description', document.getElementById('niche_description').value.trim());
                formData.append('_token', csrfToken);

                $.ajax({
                    url: nichesUpdateInfo,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({ icon: 'success', title: 'Success', text: 'Niche updated successfully!' });
                            document.getElementById('nicheEditForm').reset();
                            getNiches();
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update niche. Please try again.' });
                            getNiches();
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred: ' + error });
                        getNiches();
                    }
                });
            });
        },
        error: function (xhr, status, error) {
            console.error(error);
            stopLoading();
        }
    });
}

// niche add page 
function nicheAddPage() {
    startLoading(); // Start the loading animation
    let contentArea = $('#content-area'); // Define the content area where the HTML will be injected

    $.ajax({
        url: nichesAddPage, // URL for the 'Add New Niche' page
        method: 'GET',
        success: function (response) {

            let nicheAddForm = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>Niches</h1>
                            <p>This page allows you to create new Niches</p>
                        </div>
                        <div class="part2">
                            <!-- Option to Add New Niche -->
                        </div>
                    </div>

                    <div class="form-div ">
                        <h2 class="mb-4 text-center">Add New Niche</h2>
                        <form id="nicheaddform" >
                           
                            
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="form-label" for="niche_name">Niche Name</label>
                                    <input required class="form-control" name="niche_name"
                                        type="text" id="niche_name" placeholder="Enter niche name" maxlength="50">
                                </div>

                                <div class="col-md-6 form-group mb-2">
                                    <label class="form-label" for="niche_category_id">Niche Category</label>
                                    <select required class="form-control" name="niche_category_id" id="niche_category_id">
                                        <option value="" disabled selected>Select Category</option>
                                        ${response.map(category => `
                                            <option value="${category.id}">${category.category_name}</option>
                                        `).join('')}
                                    </select>
                                </div>

                                <div class="col-md-6 form-group mb-2">
                                    <label class="form-label" for="niche_description">Niche Description</label>
                                    <textarea class="form-control" name="niche_description"
                                        id="niche_description" placeholder="Enter niche description" rows="3" maxlength="255"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            `;
            contentArea.html(nicheAddForm);
            stopLoading();


            document.getElementById('nicheaddform').addEventListener('submit', function (event) {
                event.preventDefault();


                let nicheName = document.getElementById('niche_name').value.trim();
                let nicheCategory = document.getElementById('niche_category_id').value.trim();
                let valid = true;

                if (nicheName === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Niche name is required.',
                    });
                    nicheNameError.textContent = 'Niche name is required.';
                    valid = false;
                }

                if (nicheCategory === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Niche category is required.',
                    });
                    nicheCategoryError.textContent = 'Niche category is required.';
                    valid = false;
                }

                if (!valid) {
                    return; // Stop form submission if validation fails
                }

                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                let formData = new FormData();
                formData.append('niche_name', nicheName);
                formData.append('niche_category_id', nicheCategory);
                formData.append('niche_description', document.getElementById('niche_description').value.trim());
                formData.append('_token', csrfToken);

                $.ajax({
                    url: addNewNiches, // Insert the route here when provided
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Niche added successfully!',
                            });
                            document.getElementById('nicheaddform').reset();
                            getNiches(); // Refresh the niches list if needed
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to add niche. Please try again.',
                            });
                            getNiches();
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred: ' + error,
                        });
                        getNiches();
                    }
                });
            });






        },
        error: function (error) {
            console.error('Error fetching data:', error);
            stopLoading();
        }
    });
}

// 
function updateNicheStatus(id) {
    $.ajax({
        url: nichesStatusUpdate,
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