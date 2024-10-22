// getting all categories
function getCategories() {
    startLoading(); // Start the loading animation
    let contentArea = $('#content-area'); // Define the content area where the HTML will be injected
    $.ajax({
        url: categoriesUrl, // Make sure this URL points to your API endpoint for fetching categories
        method: 'GET',
        success: function (response) {
            let categoriesTable = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>Categories</h1>
                            <p>On this screen, you can create, add, or delete categories.</p>
                        </div>
                        <div class="part2">
                            <a onclick="categoriesAddPage()">Add New</a>
                        </div>
                    </div>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category Image</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Niches</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            response.forEach(function (data, index) {
                categoriesTable += `
                    <tr>
                        <td>${data.id}</td>
                        <td><img class="tableimg" src="${data.category_image}" alt="Category Image"></td>
                        <td>${data.category_name}</td>
                        <td>${data.niches_count} Niches</td>
                        <td>
                            <label class="switch">
                                <input onchange="updateCategoryStatus(${data.id})" ${data.status == 1 ? 'checked' : ''} type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
                            <div class="button-container">
                                <a onclick="categoryEditPage(${data.id})" class="btn btn-info">
                                    <img src="${editIconUrl}" alt="">
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            });

            categoriesTable += `
                        </tbody>
                    </table>
                </div>
            `;

            contentArea.html(categoriesTable); // Inject the HTML into the content area
            $('#datatable').DataTable(); // Initialize the DataTables plugin
            stopLoading(); // Stop the loading animation
        },
        error: function (error) {
            console.error('Error fetching categories:', error);
            stopLoading(); // Stop the loading animation on error
        }
    });
}
// categories add page

// categories add page
function categoriesAddPage() {
    startLoading(); // Start the loading animation
    let contentArea = $('#content-area');
    let formHtml = `
        <div class="container">
            <div class="top-heading px-1 py-2 d-flex">
                <div class="part1">
                    <h1>Category</h1>
                    <p>On this page, you can add a new category.</p>
                </div>
                <div class="part2"></div>
            </div>
            <div class="form-div">
                <h2 class="mb-4 text-center">Add New Category</h2>
                <form id="categoryAddForm">
                    <div class="row">
                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="category_name">Category Name</label>
                            <input required class="form-control"
                                name="category_name" type="text" id="category_name" placeholder="Enter category name"
                                maxlength="50">
                            <div id="categoryNameError" class="invalid-feedback"></div> <!-- Error display -->
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="short_description">Sub Title (Optional):</label>
                            <input class="form-control"
                                name="category_subtitle" id="category_subtitle" type="text" placeholder="Enter sub title for category"
                                maxlength="100">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label class="form-label" for="category_image">Category Image:</label>
                            <input required class="form-control"
                                name="category_image" onchange="validsize()" type="file" id="category_image"
                                accept="image/*">
                            <div id="categoryImageError" class="invalid-feedback"></div> <!-- Error display -->
                        </div>
                        <div class="col-md-12 imagecontainer">
                            <img id="image" src="" alt="">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    `;
    contentArea.html(formHtml);
    stopLoading();

    document.getElementById('categoryAddForm').addEventListener('submit', function (event) {
        event.preventDefault();

        let categoryNameError = document.getElementById('categoryNameError');
        let categoryImageError = document.getElementById('categoryImageError');

        categoryNameError.textContent = '';
        categoryImageError.textContent = '';

        let categoryName = document.getElementById('category_name').value.trim();
        let subtitle = document.getElementById('category_subtitle').value.trim();
        let categoryImage = document.getElementById('category_image').files[0];

        if (categoryName === '') {
            categoryNameError.textContent = 'Category name is required.';
            return;
        }

        if (!categoryImage) {
            categoryImageError.textContent = 'Category image is required.';
            return;
        }

        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let formData = new FormData();
        formData.append('category_name', categoryName);
        formData.append('category_subtitle', subtitle);
        formData.append('category_image', categoryImage);
        formData.append('_token', csrfToken);

        $.ajax({
            url: addnewcategories, // Make sure to define the correct route
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Category added successfully!',
                    });
                    document.getElementById('categoryAddForm').reset();
                    getCategories(); // Refresh the categories list if needed
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to add category. Please try again.',
                    });
                    getCategories();
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred: ' + error,
                });
                getCategories();
            }
        });
    });


}

// categories edit page
function categoryEditPage(id) {
    startLoading(); // Start the loading animation
    let contentArea = $('#content-area');

    $.ajax({
        url: categoriesupdatepage, // Define the URL for fetching category data
        method: 'GET',
        data: { id: id },
        success: function (response) {

            let imageUrl = `${baseUrl}${response.category_image}`;
            let shortDescription = response.short_description !== null ? response.short_description : '';
            let formHtml = `
                <div class="container">
                    <div class="top-heading px-1 py-2 d-flex">
                        <div class="part1">
                            <h1>Category</h1>
                            <p>On this page, you can edit the details of an existing category.</p>
                        </div>
                        <div class="part2"></div>
                    </div>
                    <div class="form-div">
                        <h2 class="mb-4 text-center">Edit Category</h2>
                        <form id="categoryEditForm" >
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="form-label" for="category_name">Category Name</label>
                                    <input type="hidden" name="category_id" id="category_id" value="${response.id}">
                                    <input required class="form-control" name="category_name" value="${response.category_name}" type="text" id="category_name" placeholder="Enter category name" maxlength="50">
                                    <div class="invalid-feedback" id="categoryNameError"></div>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label class="form-label" for="short_description">Sub Title (Optional):</label>
                                    <input class="form-control" name="category_subtitle" value="${shortDescription}" type="text" id="category_subtitle" placeholder="Enter sub title for category" maxlength="100">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label class="form-label" for="category_image">Category Image:</label>
                                    <input class="form-control" name="category_image" onchange="validsize()" type="file" id="category_image" accept="image/*">
                                    <div class="invalid-feedback" id="categoryImageError"></div>
                                </div>
                                <div class="col-md-12 imagecontainer">
                                    <img id="image" src="${imageUrl}" alt="Category Image">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            `;

            // Update the content area with the new form HTML
            contentArea.html(formHtml);
            stopLoading(); // Stop the loading animation

            // Handle the form submission
            document.getElementById('categoryEditForm').addEventListener('submit', function (event) {
                event.preventDefault();


                let categoryNameError = document.getElementById('categoryNameError');
                let categoryImageError = document.getElementById('categoryImageError');
                
                categoryNameError.textContent = '';
                categoryImageError.textContent = '';
                
                let categoryId = document.getElementById('category_id').value;
                let categoryName = document.getElementById('category_name').value.trim();
                let subtitle = document.getElementById('category_subtitle').value.trim();
                let categoryImage = document.getElementById('category_image').files[0];
           
                if (categoryName === '') {
                    categoryNameError.textContent = 'Category name is required.';
                    return;
                }
             
            
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                let formData = new FormData();
                formData.append('category_id', categoryId);
                formData.append('category_name', categoryName);
                formData.append('category_subtitle', subtitle);
                if (categoryImage) {
                    formData.append('category_image', categoryImage);
                }
                formData.append('_token', csrfToken);
                
             

                $.ajax({
                    url: updatecategoriesinfo, // Define the correct route for category update
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Category updated successfully!',
                            });
                            document.getElementById('categoryEditForm').reset();
                            getCategories(); // Refresh the categories list if needed
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update category. Please try again.',
                            });
                            getCategories();
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred: ' + error,
                        });
                        getCategories();
                    }
                });
            });





        },

        error: function (xhr, status, error) {
            console.error('Error fetching category data:', error);
            stopLoading(); // Stop the loading animation
        }
    });
}

  // updating category status
  function updateCategoryStatus(id) {
    startLoading();

    $.ajax({
        url: categoriesstatusupdate,
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
    stopLoading();
}


function validsize() {
    var image = $('#category_image')[0];
    var file = image.files[0];
    if (file) {
        var maxSize = 1 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('The file size exceeds the 1MB limit. Please choose a smaller image.');
            $('#category_image').val('');
        } else {
            var preview = document.getElementById('image');
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
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