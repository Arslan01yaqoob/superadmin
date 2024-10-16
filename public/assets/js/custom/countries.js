// showing all countries
function getcountries(event) {
    startLoading();
    let contentArea = $('#content-area');
    $.ajax({
        url: countriesUrl,
        method: 'GET',
        success: function (response) {
            let countriesTable = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>Countries</h1>
                            <p>Manage countries by adding, updating, or removing them on this screen.</p>
                        </div>
                        <div class="part2">
                            <a onclick="countriesaddpage()">Add New</a>
                        </div>
                    </div>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Country Name</th>
                                <th scope="col">Active States</th>
                                <th scope="col">Active Cities</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            response.forEach(function (data, index) {
                countriesTable += `
                    <tr>
                        <td>${data.id}</td>
                        <td>${data.country_name}</td>
                        <td>${data.active_states_count} States</td>
                        <td>${data.active_cities_count} Cities</td>
                        <td>
                            <label class="switch">
                                <input onchange="updatecountryStatus(${data.id})" ${data.status == 1 ? 'checked' : ''} type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <div class="button-container">
                                <a onclick="countryeditpage(${data.id})" class="btn btn-info">
                                    <img src="${editIconUrl}" alt="">
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            });
            countriesTable += `
                        </tbody>
                    </table>
                </div>
            `;

            contentArea.html(countriesTable);
            $('#datatable').DataTable();
            stopLoading();
        },
        error: function (error) {
            console.error('Error fetching countries:', error);
            stopLoading();
        }
    });
}
// updating countries status 
function updatecountryStatus(id) {
    startLoading();
    $.ajax({
        url: countrystatusupdate,
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
// creating country adding page 
function countriesaddpage() {
    startLoading();
    let contentArea = $('#content-area');
    $.ajax({
        url: countriesUrl,
        method: 'GET',
        success: function (response) {
            let countriesaddpage = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>Countries</h1>
                            <p>Here, you can easily add country as needed.</p>
                        </div>
                        <div class="part2">
                        </div>
                    </div>  
                    <div class="form-div">
                        <h2 class="mb-4 text-center">Add New Country</h2>
                        <form id="addCountryForm">
                            <div class="row">
                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="country_name">Country Name</label>
                                    <input required class="form-control" name="country_name"
                                        type="text" id="country_name" placeholder="Enter country name" maxlength="50">
                                    <div id="countryNameError" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            `;


            contentArea.html(countriesaddpage);


        },
        error: function (error) {
            console.error('Error fetching countries page:', error);
        }
    });
    stopLoading();

}

// country edit page
function countryeditpage(id) {
    let contentArea = $('#content-area');
    startLoading();

    $.ajax({
        url: updateCountryUrl,
        method: 'GET',
        data: { id: id }, // Sending the id as data
        success: function (response) {
            let Countriesaddpage = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>Countries</h1>
                            <p>You can update country on this page.</p>
                        </div>
                        <div class="part2">
                        </div>
                    </div>
                    <div class="form-div">
                        <h2 class="mb-4 text-center">Edit Country</h2>
                        <form method="POST" action="{{ route('updatecountry', ['id'=> ${response.id}]) }}">
                         
                            <div class="row">
                                <div class="col-md-6 form-group mb-4">
                                    <label class="form-label" for="country_name">Country Name</label>
                                    <input required class="form-control"
                                        name="country_name" type="text" value="${response.country_name}" 
                                        id="country_name" placeholder="Enter country name" maxlength="50">
                                   
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            `;

            contentArea.html(Countriesaddpage);
            stopLoading();
        },
        error: function (error) {
            console.error('Error fetching countries:', error);
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

// Submitting the adding page
$('#addCountryForm').on('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Clear previous errors
    let countryNameError = $('#countryNameError');
    countryNameError.text(''); // Clear the error message
    $('#country_name').removeClass('is-invalid'); // Remove invalid class

    // Get form data
    let countryName = $('#country_name').val();

    // Basic validation
    if (countryName.trim() === '') {
        countryNameError.text('Country name is required.');
        $('#country_name').addClass('is-invalid');
        return;
    }

    // Send AJAX request
    $.ajax({
        url: "{{ route('updatecitystatus') }}",
        method: 'get',
        data: {
            country_name: countryName,
            _token: '{{ csrf_token() }}' // CSRF token for security
        },
        success: function (data) {
            if (data.success) {
                alert('Country added successfully!');
        
                $('#addCountryForm')[0].reset(); 
               
            } else if (data.errors) {
            
                if (data.errors.country_name) {
                    countryNameError.text(data.errors.country_name[0]);
                    $('#country_name').addClass('is-invalid');
                }
            } else {
                countryNameError.text(data.message || 'An error occurred.');
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                if (errors.country_name) {
                    countryNameError.text(errors.country_name[0]);
                    $('#country_name').addClass('is-invalid');
                }
            } else {
                countryNameError.text('An error occurred while adding the country.');
                console.error('Error:', xhr);
            }
        }
    });
});
