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
<div class="pagination-container d-flex justify-content-center bg-light p-3">
    <!-- Pagination buttons -->
</div>


@push('scripts')
<script>
    // console.log(window.location.href);
    $(document).ready(()=>{
        
        readDataAjax('/read-user', { page: 1 }, 'name', 'email');

        deleteDataAjax('#users-table','/delete-user',()=>{readDataAjax('/read-user',{},'name','email')});


    // Attach search event
    $('#search').on('keyup', function () {
        const search = $(this).val();
        clearTimeout(window.debounceTimeout);
        window.debounceTimeout = setTimeout(()=>{readDataAjax('/read-user', { search: search, page: 1 }, 'name', 'email')},1000);
    });

    // $('.prevbtn','.currentBtn','.nextBtn').on('click',()=>{
    //     let page = $(this).attr(data-page);
    //     readDataAjax('/read-user', { page: page }, 'name', 'email');
    // });

$(document).on('click', '.prevbtn, .currentBtn, .nextBtn', function () {
    let page = $(this).attr('data-page'); // Correct attribute retrieval
    readDataAjax('/read-user', { page: page }, 'name', 'email');
});


    // Attach pagination event dynamically
    // $(document).on('click', '.pagination-link', function (e) {
    //     e.preventDefault();
    //     const page = $(this).data('page');
    //     readDataAjax('/read-user', { page: page }, 'name', 'email');
    // });

    });
</script>
@endpush
@endsection
