// getting all states
function getStates() {
    startLoading();
    let contentArea = $('#content-area');
    $.ajax({
        url: StatesUrl,
        method: 'GET',
        success: function (response) {
            let statesTable = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>States</h1>
                            <p>Manage states by adding, updating, or removing them on this screen.</p>
                        </div>
                        <div class="part2">
                            <a onclick="statesAddPage()">Add New</a>
                        </div>
                    </div>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">State Name</th>
                                <th scope="col">Country</th>
                                <th scope="col">Active Cities</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            response.forEach(function (data, index) {
                statesTable += `
                    <tr>
                        <td>${data.id}</td>
                        <td>${data.state_name}</td>
                        <td>${data.country.country_name}</td>
                        <td>${data.active_cities_count} Cities</td>
                        <td>
                            <label class="switch">
                                <input onchange="updateStateStatus(${data.id})" ${data.status == 1 ? 'checked' : ''} type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <div class="button-container">
                                <a onclick="stateEditPage(${data.id})" class="btn btn-info">
                                    <img src="${editIconUrl}" alt="">
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            });

            statesTable += `
                        </tbody>
                    </table>
                </div>
            `;

            contentArea.html(statesTable);
            $('#datatable').DataTable();
            stopLoading();
        },
        error: function (error) {
            console.error('Error fetching states:', error);
            stopLoading();
        }
    });
}
// satest add page
function statesAddPage() {
    startLoading();
    let contentArea = $('#content-area');
    $.ajax({
        url: stateaddpage, 
        method: 'GET',
        success: function (response) {
            // Assuming response contains an array of countries
            const countries = response; // The response is already an array of country objects

            let stateaddpage = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>States</h1>
                            <p>This page allows you to create States as needed.</p>
                        </div>
                        <div class="part2">
                            <a href="{{ route('addnestatepage') }}">Add New</a>
                        </div>
                    </div>
                    
                    <div class="form-div">
                        <h2 class="mb-4 text-center">Add New State</h2>
                        <form id="submitState" >
                            <div class="row">
                                <!-- State Name Input -->
                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="state_name">State Name</label>
                                    <input required class="form-control " name="state_name"
                                        type="text" id="state_name" placeholder="Enter state name" maxlength="50">
                              <p id="stateNameError"></p>
                            
                                        </div>

                                <!-- Country Select Input -->
                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="country_id">Country</label>
                                    <select required class="form-control" name="country_id" id="country_id">
                                        <option value="">Select Country</option>
                                        ${countries.map(country => `<option value="${country.id}">${country.country_name}</option>`).join('')}
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            `;

            contentArea.html(stateaddpage);
            stopLoading();


            document.getElementById('submitState').addEventListener('submit', function (event) {
                event.preventDefault();
            
                // Clear previous errors
                let stateNameError = document.getElementById('stateNameError');
                stateNameError.textContent = '';
            
                let stateName = document.getElementById('state_name').value;
                let countryId = document.getElementById('country_id').value;
            
                // Basic validation
                if (stateName.trim() === '') {
                    stateNameError.textContent = 'State name is required.';
                    return;
                }
            
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
                let formData = new FormData();
                formData.append('state_name', stateName);
                formData.append('country_id', countryId);
                formData.append('_token', csrfToken);
            
                $.ajax({
                    url: addnewstate, // URL for adding a new state
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'State added successfully!',
                            });
                            document.getElementById('submitState').reset();
                            // Uncomment this if you have a function to fetch and display states
                            getStates(); 
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to add state. Please try again.',
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred: ' + error,
                        });
                    }
                });
            });
            



        },
        error: function (error) {
            console.error('Error fetching countries:', error);
            stopLoading();
        }
    });
   
    stopLoading();
}

function updateStateStatus(id){

    startLoading();
    $.ajax({
        url: statestatusupdate,
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
    stopLoading();

}

function stateEditPage(id) {
    let contentArea = $('#content-area');
    startLoading();

    $.ajax({
        url: stateupdatepage, // Define the URL for fetching state data
        method: 'GET',
        data: { id: id },
        success: function (response) {
            // Validate response structure
            if (!response || !response.state || !response.countries) {
                console.error('Invalid response:', response);
                stopLoading();
                return;
            }
        
            // Extract state data and countries
            const state = response.state;
            const countries = response.countries;
        
            let statesUpdatePage = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>States</h1>
                            <p>Use this page to modify or update State information as required.</p>
                        </div>
                        <div class="part2"></div>
                    </div>
                    <div class="form-div">
                        <h2 class="mb-4 text-center">Edit State</h2>
                        <form id="updatestateform" method="POST" action="{{ route('stateupdatepage', ['id' => state.id]) }}">
                            <div class="row">
                                <!-- State Name Input -->
                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="state_name">State Name</label>
                                    <input id="stateid" name="stateid" hidden required value="${state.id}" >
                                    <input required value="${state.state_name}"
                                        class="form-control" name="state_name"
                                        type="text" id="state_name" placeholder="Enter state name" maxlength="50">
                                    <div id="stateNameError" class="invalid-feedback"></div>
                                </div>
        
                                <!-- Country Select Input -->
                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="country_id">Country</label>
                                    <select required class="form-control" name="country_id" id="country_id">
                                        <option value="${state.country.id}" selected>${state.country.country_name}</option>
                                        <!-- Add other countries dynamically -->
                                        ${countries.map(country => 
                                            country.id !== state.country.id ? 
                                            `<option value="${country.id}">${country.country_name}</option>` : ''
                                        ).join('')}
                                    </select>
                                    <div id="countryIdError" class="invalid-feedback"></div>
                                </div>
                            </div>
        
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            `;
        
            contentArea.html(statesUpdatePage);
            stopLoading();
        
            // Add submit event listener for the form
            document.getElementById('updatestateform').addEventListener('submit', function (event) {
                event.preventDefault();
        
                let stateNameError = document.getElementById('stateNameError');
                stateNameError.textContent = '';
        
                let stateName = document.getElementById('state_name').value;
                let countryId = document.getElementById('country_id').value;
                let stateid = document.getElementById('stateid').value;

                if (stateName.trim() === '') {
                    stateNameError.textContent = 'State name is required.';
                    return;
                }
        
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
                // Construct the update URL with the state ID
                let formData = new FormData();
                formData.append('state_name', stateName);
                formData.append('country_id', countryId);
                formData.append('state_id', stateid);
                
                formData.append('_token', csrfToken);
        
                $.ajax({
                    url: updatestateinfo, 
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'State updated successfully!',
                            });
                            document.getElementById('updatestateform').reset();
                            getStates(); // Reload the states list if necessary
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update state. Please try again.',
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred: ' + error,
                        });
                    }
                });
            });
        },
    
        error: function (error) {
            console.error('Error fetching states:', error);
            stopLoading();
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
