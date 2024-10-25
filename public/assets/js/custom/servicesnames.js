function getServicesName() {
    startLoading();
    let contentArea = $('#content-area');

    $.ajax({
        url: serviceNameUrl,
        method: 'GET',
        success: function (response) {


            let servicesData = response;  // Assuming the response is an array of services
            let html = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>Services Names</h1>
                            <p>Use this screen to create, modify, or delete service names easily.</p>
                        </div>
                        <div class="part2">
                            <a onclick="serviceNameAddPageform()" >Add New</a>
                        </div>
                    </div>

                    <table class="table" id="datatabel">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Service Name</th>
                                <th scope="col">Niche</th>
                                <th scope="col">Category</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>`;

            servicesData.forEach(function (data, index) {
                html += `
                    <tr>
                        <td>${data.id}</td>
                        <td>${data.service_name}</td>
                        <td>${data.niche.niche_name}</td>
                        <td>${data.category.category_name}</td>
                        <td>
                            <label class="switch">
                                <input onchange="updateStatus(${data.id})" 
                                       ${data.status == 1 ? 'checked' : ''} 
                                       type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <div class="button-container">
                                <a onclick="serviceNameEditPageform()"  class="btn btn-info">
                                    <img src="${editIconUrl}" alt="">
                                </a>
                            </div>
                        </td>
                    </tr>`;
            });

            html += `</tbody></table></div>`;

            // Insert the generated HTML into the content area
            contentArea.html(html);
            $('#datatabel').DataTable();
            stopLoading();
        },
        error: function (error) {
            console.error('Error fetching services:', error);
            stopLoading();
        }
    });
}
function serviceNameAddPageform() {
    startLoading();
    let contentArea = $('#content-area');
    $.ajax({
        url: serviceNameAddPage,  // Make sure serviceNameUrl is the correct endpoint returning category data
        method: 'GET',
        success: function (response) {
     
          
            
            let categoryOptions = '<option value="" disabled selected>Select Category</option>';

     
            response.forEach(function (response) {
                categoryOptions += `<option value="${response.id}">${response.category_name}</option>`;
            });

                contentArea.html(`
                    <div class="container">
                        <div class="top-heading px-1 py-2 d-flex">
                            <div class="part1">
                                <h1>Service Names</h1>
                                <p>Use this page to effortlessly create and manage service names.</p>
                            </div>
                            <div class="part2"></div>
                        </div>

                        <div class="form-div">
                            <h2 class="mb-4 text-center">Add New Service Name</h2>
                            <form id="serviceNameAddForm" >
                        
                                <div class="row">
                                    <div class="col-md-6 form-group mb-2">
                                        <label class="form-label" for="service_name">Service Name</label>
                                        <input required class="form-control" 
                                            name="service_name" type="text" id="service_name" placeholder="Enter service name" maxlength="50">
                                    
                                    </div>

                                    <div class="col-md-6 form-group mb-2">
                                        <label class="form-label" for="category_id">Category</label>
                                        <select required class="form-control " 
                                            name="category_id" onchange="getNichesDetails()" id="category_id">
                                            ${categoryOptions} <!-- Inject category options here -->
                                        </select>
                                    
                                    </div>

                                    <div class="col-md-6 form-group mb-2">
                                        <label class="form-label" for="niche_id">Niche</label>
                                        <select required class="form-control " 
                                            name="niche_id" id="niche_id">
                                            <option value="" disabled selected>Select the category first</option>
                                        </select>
                                    
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-2">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                `);


                document.getElementById('serviceNameAddForm').addEventListener('submit', function (event) {
                    event.preventDefault();
                
                    // Get form values
                    let serviceName = document.getElementById('service_name').value.trim();
                    let categoryId = document.getElementById('category_id').value.trim();
                    let nicheId = document.getElementById('niche_id').value.trim();
                    let valid = true;
                
                    // Validation for Service Name
                    if (serviceName === '') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validation Error',
                            text: 'Service name is required.',
                        });
                        valid = false;
                    }
                
                    // Validation for Category ID
                    if (categoryId === '') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validation Error',
                            text: 'Category is required.',
                        });
                        valid = false;
                    }
                
                    // Validation for Niche ID
                    if (nicheId === '') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validation Error',
                            text: 'Niche is required.',
                        });
                        valid = false;
                    }
                
                    if (!valid) {
                        return; // Stop form submission if validation fails
                    }
                
                    // Get CSRF token
                    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                    // Prepare form data
                    let formData = new FormData();
                    formData.append('service_name', serviceName);
                    formData.append('category_id', categoryId);
                    formData.append('niche_id', nicheId);
                    formData.append('_token', csrfToken);
                
                    // Submit form via AJAX
                    $.ajax({
                        url: addNewServiceName, // Replace this with the actual route
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Service name added successfully!',
                                });
                                document.getElementById('serviceNameAddForm').reset(); // Reset the form
                                getServicesName();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to add service name. Please try again.',
                                });
                                getServicesName();
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred: ' + error,
                            });
                            getServicesName();
                        }
                    });
                });
                


        }
    });
}

function serviceNameEditPageform(id) {
    startLoading();
    let contentArea = $('#content-area');
    
    $.ajax({
        url: serviceNameUpdatePage, 
        method: 'GET',
        data: {id: id},
        success: function(response) {
           
            contentArea.html(`
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>Services Names</h1>
                            <p>Use this page to effortlessly Edit and manage service names.</p>
                        </div>
                        <div class="part2"></div>
                    </div>

                    <div class="form-div">
                        <h2 class="mb-4 text-center">Edit Service Name</h2>
                        <form id="ServiceNameEditpage">
                       
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="form-label" for="service_name">Service Name</label>
                                   <input hidden id="servicenameid" name="servicenameid" value="${response.servicename.id}">
                                    <input required value="${response.servicename.service_name}" 
                                           class="form-control " 
                                           name="service_name" type="text" id="service_name" 
                                           placeholder="Enter service name" maxlength="50">
                                  
                                </div>

                                <div class="col-md-6 form-group mb-2">
                                    <label class="form-label" for="category_id">Category</label>
                                    <select required class="form-control " 
                                            name="category_id" onchange="getNichesDetails()" id="category_id">
                                        <option value="${response.servicename.category.id}" selected>
                                            ${response.servicename.category.category_name}
                                        </option>
                                        ${response.categories.map(category => 
                                            category.id !== response.servicename.category.id ? 
                                            `<option value="${category.id}">${category.category_name}</option>` : ''
                                        ).join('')}
                                    </select>
                                   
                                </div>

                                <div class="col-md-6 form-group mb-2">
                                    <label class="form-label" for="niche_id">Niche</label>
                                    <select required class="form-control " 
                                            name="niche_id" id="niche_id">
                                        <option value="${response.servicename.niche.id}" selected>
                                            ${response.servicename.niche.niche_name}
                                        </option>
                                        ${response.niches.map(niche => 
                                            niche.id !== response.servicename.niche.id ? 
                                            `<option value="${niche.id}">${niche.niche_name}</option>` : ''
                                        ).join('')}
                                    </select>
                                   
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            `);
            stopLoading(); // Optionally stop loading animation here



            document.getElementById('ServiceNameEditpage').addEventListener('submit', function (event) {
                event.preventDefault();
            
                // Get form values
                let servicenameid  = document.getElementById('servicenameid').value.trim();
                let serviceName = document.getElementById('service_name').value.trim();
                let categoryId = document.getElementById('category_id').value.trim();
                let nicheId = document.getElementById('niche_id').value.trim();
                let valid = true;
            
         
                if (serviceName === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Service name is required.',
                    });
                    valid = false;
                }
            
              
                if (categoryId === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Category is required.',
                    });
                    valid = false;
                }
            
               
                if (nicheId === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Niche is required.',
                    });
                    valid = false;
                }
            
                if (!valid) {
                    return; 
                }
            
             
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
             
                let formData = new FormData();
                formData.append('id', servicenameid);
                formData.append('service_name', serviceName);
                formData.append('category_id', categoryId);
                formData.append('niche_id', nicheId);
                formData.append('_token', csrfToken);
            
                
                $.ajax({
                    url: serviceNameUpdateInfo, 
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Service name Updated successfully!',
                            });
                            document.getElementById('ServiceNameEditpage').reset(); // Reset the form
                            getServicesName();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to Updated service name. Please try again.',
                            });
                            getServicesName();
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred: ' + error,
                        });
                        getServicesName();
                    }
                });
            });





        },
        error: function(err) {
            console.error('Error fetching service name details', err);
            stopLoading(); // Handle errors and stop loading animation here
        }
    });
}



function getNichesDetails() {
    var cateid = $('#category_id').val();
    if (cateid) {
        $.ajax({
            url: getNichesbycategory,
            data: { id: cateid },
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

// updating category status
function updateStatus(id) {
    $.ajax({
        url: servicenameStatusUpdate,
        type: "Get",
        data: {
            _token: "{{ csrf_token() }}",
            id: id,
        },
        success: function(response) {
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