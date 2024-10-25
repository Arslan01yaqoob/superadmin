function getCities() {
    startLoading();
    let contentArea = $('#content-area');
    $.ajax({
        url: citiesUrl, // Make sure to define CitiesUrl to point to your API endpoint for fetching cities
        method: 'GET',
        success: function (response) {

            // Construct the HTML for the cities table
            let citiesTable = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>Cities</h1>
                            <p>On this screen, you can create, add, or delete cities.</p>
                        </div>
                        <div class="part2">
                            <a onclick="addCityPage()" >Add New</a>
                        </div>
                    </div>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">City Name</th>
                                <th scope="col">Country Name</th>
                                <th scope="col">State Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            response.forEach(function (data) {
                citiesTable += `
                    <tr>
                        <td>${data.id}</td>
                        <td>${data.city_name}</td>
                        <td>${data.country.country_name}</td>
                        <td>${data.state.state_name}</td>
                        <td>
                            <label class="switch">
                                <input onchange="updatecitystatus(${data.id})" ${data.status == 1 ? 'checked' : ''} type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <div class="button-container">
                                <a onclick="cityEditpage(${data.id})" class="btn btn-info">
                                    <img src="${editIconUrl}" alt="">
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            });

            citiesTable += `
                        </tbody>
                    </table>
                </div>
            `;

            contentArea.html(citiesTable);
            $('#datatable').DataTable(); // Initialize DataTable
            stopLoading();
        },
        error: function (error) {
            console.error('Error fetching cities:', error);
            stopLoading();
        }
    });
}
// city add page and adding city
function addCityPage() {
    startLoading();
    let contentArea = $('#content-area');
    $.ajax({
        url: cityaddpage, // Use the defined citiesUrl
        method: 'GET',
        success: function (response) {

            // Prepare the cities add page HTML
            let citiesaddpage = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>City</h1>
                            <p>On this page, you can add a new city.</p>
                        </div>
                        <div class="part2"></div>
                    </div>

                    <div class="form-div">
                        <h2 class="mb-4 text-center">Add New City</h2>
                        <form id="addCityForm" method="POST" action="{{ route('addcountry') }}">
                            <div class="row">
                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="city_name">City Name</label>
                                    <input required class="form-control" name="city_name"
                                        type="text" id="city_name" placeholder="Enter city name" maxlength="50">
                                </div>
                                <!-- Country Select Input -->
                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="country_id">Country</label>
                                    <select required onchange="getcities()" class="form-control" name="country_id" id="country_id">
                                        <option value="" disabled selected>Select Country</option>
                                        ${response.map(country => `
                                            <option value="${country.id}">${country.country_name}</option>
                                        `).join('')}
                                    </select>
                                 
                                </div>

                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="state_id">State</label>
                                    <select required class="form-control " name="state_id" id="state_id">
                                        <option value="" selected disabled>Select the country first</option>
                                    </select>
                              
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            `;

            // Update the content area with the cities add page HTML
            contentArea.html(citiesaddpage);
            stopLoading();



            document.getElementById('addCityForm').addEventListener('submit', function (event) {
                event.preventDefault();

                let cityName = document.getElementById('city_name').value;
                let countryId = document.getElementById('country_id').value;
                let stateId = document.getElementById('state_id').value;
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Validate input
                if (cityName.trim() === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'City name is required.',
                    });
                    return;
                }

                // Create FormData object
                let formData = new FormData();
                formData.append('city_name', cityName);
                formData.append('country_id', countryId);
                formData.append('state_id', stateId);
                formData.append('_token', csrfToken);

                // AJAX request to submit the form
                $.ajax({
                    url: addnewcity, // Make sure to define this endpoint correctly
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'City added successfully!',
                            });
                            document.getElementById('addCityForm').reset();
                            getCities();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to add city. Please try again.',
                            });
                            getCities();
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred: ' + error,
                        });
                        getCities();
                    }
                });
            });


        },
        error: function (error) {
            console.error('Error fetching cities:', error);
            stopLoading();
        }
    });
}
// city edit page
function cityEditpage(id) {
    let contentArea = $('#content-area');
    startLoading();

    $.ajax({
        url: cityupdatepage, // Define the URL for fetching city data
        method: 'GET',
        data: { id: id },
        success: function (response) {
            // Validate response structure
            if (!response.city || !response.countries || !response.states) {
                console.error('Invalid response structure:', response);
                stopLoading();
                return;
            }
            // Extract city data, states, and countries
            const city = response.city;
            const countries = response.countries;
            const states = response.states;

            let CityUpdatePage = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>City</h1>
                            <p>On this page, you can update the details of an existing city.</p>
                        </div>
                        <div class="part2"></div>
                    </div>
                    <div class="form-div">
                        <h2 class="mb-4 text-center">Edit City</h2>
                        <form id="cityeditform">
                            <input type="hidden" id="city_id" value="${city.id}" />
                            <div class="row">
                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="city_name">City Name</label>
                                    <input required value="${city.city_name}"
                                        class="form-control" name="city_name"
                                        type="text" id="city_name" placeholder="Enter city name" maxlength="50">
                                    <div id="cityNameError" class="invalid-feedback"></div>
                                </div>

                                <!-- Country Select Input -->
                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="country_id">Country</label>
                                    <select required onchange="getcities()"
                                        class="form-control" name="country_id" id="country_id">
                                        <option value="${city.country.id}" selected>${city.country.country_name}</option>
                                        ${countries.map(country => 
                                            country.id !== city.country.id ? 
                                            `<option value="${country.id}">${country.country_name}</option>` : ''
                                        ).join('')}
                                    </select>
                                    <div id="countryIdError" class="invalid-feedback"></div>
                                </div>

                                <!-- State Select Input -->
                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="state_id">State</label>
                                    <select required class="form-control" name="state_id" id="state_id">
                                        <option value="${city.state.id}" selected>${city.state.state_name}</option>
                                        ${states.map(state => 
                                            state.id !== city.state.id ? 
                                            `<option value="${state.id}">${state.state_name}</option>` : ''
                                        ).join('')}
                                    </select>
                                    <div id="stateIdError" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            `;

            contentArea.html(CityUpdatePage);
            stopLoading();

            // Add submit event listener for the form
            document.getElementById('cityeditform').addEventListener('submit', function (event) {
                event.preventDefault();
            
                let cityNameError = document.getElementById('cityNameError');
                let stateIdError = document.getElementById('stateIdError');
                let countryIdError = document.getElementById('countryIdError');
            
                // Clear previous error messages
                cityNameError.textContent = '';
                stateIdError.textContent = '';
                countryIdError.textContent = '';
            
                let cityName = document.getElementById('city_name').value;
                let cityId = document.getElementById('city_id').value;
                let stateId = document.getElementById('state_id').value;
                let countryID = document.getElementById('country_id').value;
            
                // Validation checks
                if (cityName.trim() === '') {
                    cityNameError.textContent = 'City name is required.';
                    return;
                }
            
                if (stateId.trim() === '') {
                    stateIdError.textContent = 'State is required.';
                    return;
                }
            
                if (countryID.trim() === '') {
                    countryIdError.textContent = 'Country is required.';
                    return;
                }
            
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
                let formData = new FormData();
                formData.append('name', cityName);
                formData.append('id', cityId);
                formData.append('state_id', stateId);
                formData.append('country_id', countryID);
                formData.append('_token', csrfToken);
            
                $.ajax({
                    url: updatecityinfo, // Make sure updatecityinfo is defined
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'City updated successfully!',
                            });
                            document.getElementById('cityeditform').reset();
                            getCities();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update city. Please try again.',
                            });
                            getCities();
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred: ' + error,
                        });
                        getCities();
                    }
                });
            });

            
            
        },

        error: function (error) {
            console.error('Error fetching city data:', error);
            stopLoading();
        }
    });
}

// update city status
function updatecitystatus(id) {
    startLoading();
    $.ajax({
        url: citystatusupdate,
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




function getcities() {
    let countryid = $('#country_id').val();

    if (countryid) {
        $.ajax({
            url: getstates, // Make sure this variable points to your API endpoint for fetching states
            type: 'GET',
            data: { country_id: countryid }, // Pass the country ID as data
            success: function (response) {

                $('#state_id').empty();
                $('#state_id').append('<option value="" disabled selected>Select your states</option>');
                $.each(response, function (index, state) {
                    $('#state_id').append('<option value="' + state.id + '">' + state.state_name + '</option>');
                });

            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
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
