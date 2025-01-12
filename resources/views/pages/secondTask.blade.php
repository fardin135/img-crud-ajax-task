@extends('layouts.app')
@section('title') {{ "Second Task" }}@endsection
@section('main')
  <style>
    .table td, .table th {
      word-wrap: break-word;
      /* overflow: hidden; */
      /* text-overflow: ellipsis; Add ellipsis (...) for long text */
        max-width: 150px;
    }
  </style>
<div class="container mt-5">
    <h1 class="text-center">Crud Operation Using Ajax</h1>
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <div>
                <input type="search" name="search" id="search" class="form-control mb-3" style="width: 500px;" placeholder="Search Name Or Email...">
            </div>
            <div>
                @include('components.createModal')
                @include('components.updateModal')
            </div>
        </div>
        <table class="table table-striped table-hover text-center" id="users-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-between align-items-center bg-light p-3 mt-5">
    <div class="pagination-status"></div>
    <div class="pagination-container"></div>
    <!-- Pagination buttons -->
</div>


@push('scripts')
<script>
$(document).ready(() => {
    // Initial page load
    const loadPage = (page, search) => {
        const params = { page, search };
        readDataAjax('/read-user', params, 'name', 'email');
    };
    
    if (history.state && (history.state.page || history.state.search)) {
        const savedPage = history.state.page || 1;
        const savedSearch = history.state.search || '';
        $('#search').val(savedSearch); // Populate the search box
        loadPage(savedPage, savedSearch);
    } else {
        loadPage(1, ''); // Default initial load
    }

    // Search functionality with debounce
    $('#search').on('input', function () {
        const search = $(this).val();
        clearTimeout(window.debounceTimeout);
        window.debounceTimeout = setTimeout(() => {
            const currentPage = 1;
            loadPage(currentPage, search);
            history.pushState({ search, page: currentPage }, '', `/task-2?search=${search}&page=${currentPage}`);
        }, 1000);
    });
    
    // Pagination functionality
    $(document).on('click', '.prevbtn, .currentBtn, .nextBtn', function () {
        const page = $(this).attr('data-page');
        const search = $('#search').val();
        loadPage(page, search);
        history.pushState({ search, page }, '', `/task-2?search=${search}&page=${page}`);
    });

    // Delete action with callback
    deleteDataAjax('#users-table', '/delete-user', () => {
        const search = $('#search').val();
        const page = 1; // or maintain current page, as necessary
        loadPage(page, search);
    });
});



// $(document).ready(() => {
//     // Function to get search and page parameters from the URL
//     function getParams() {
//         const search = getParameterByName('search') || '';  // Get 'search' from URL, or default to empty string
//         const page = getParameterByName('page') || 1;  // Get 'page' from URL, or default to 1
//         return { search, page };
//     }

//     // Function to extract a query parameter from the URL
//     function getParameterByName(name) {
//         const url = new URL(window.location.href);
//         return url.searchParams.get(name);
//     }

//     // Function to update the URL without reloading the page
//     function updateURL(search, page) {
//         const newURL = `/task-2?search=${search}&page=${page}`;
//         history.pushState({}, '', newURL);  // Change the URL in the browser
//     }

//     // Function to fetch data based on the current search and page
//     function fetchData(search, page) {
//         // Call the server to get data based on search and page
//         readDataAjax('/read-user', { search, page }, 'name', 'email');
//     }

//     // Get the current parameters from the URL
//     const { search, page } = getParams();
    
//     // Set the initial search value in the search input
//     $('#search').val(search);

//     // Fetch data when the page loads
//     fetchData(search, page);

//     // Event: When the user types in the search box
//     $('#search').on('input', function () {
//         const search = $(this).val();  // Get the current value in the search box
//         updateURL(search, 1);  // Change the URL to reflect the new search (reset to page 1)
//         fetchData(search, 1);  // Fetch data based on the new search (page 1)
//     });

//     // Event: When the user clicks on pagination buttons (prev, next, or a specific page)
//     $(document).on('click', '.prevbtn, .currentBtn, .nextBtn', function () {
//         const page = $(this).data('page');  // Get the new page number
//         const search = $('#search').val();  // Get the current search value
//         updateURL(search, page);  // Update the URL with the new page
//         fetchData(search, page);  // Fetch data for the new page
//     });

//     // Handle browser back and forward buttons
//     window.onpopstate = function () {
//         const { search, page } = getParams();  // Get parameters from the updated URL
//         $('#search').val(search);  // Update the search input
//         fetchData(search, page);  // Fetch the data based on the updated parameters
//     };
// });

</script>
@endpush
@endsection
