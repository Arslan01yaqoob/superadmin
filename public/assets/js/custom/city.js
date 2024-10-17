function getCities() {
    startLoading();
    let contentArea = $('#content-area');
    $.ajax({
        url: citiesUrl, // Make sure to define CitiesUrl to point to your API endpoint for fetching cities
        method: 'GET',
        success: function (response) {
            console.log(response);
            
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
                                <input onchange="updateStatus(${data.id})" ${data.status == 1 ? 'checked' : ''} type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <div class="button-container">
                                <a href="{{ route('cityupdatepage', ['id' => data.id]) }}" class="btn btn-info">
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
