@extends('layouts.app')
@section('title') {{ "Second Task" }}@endsection
@section('main')

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
@push('scripts')
<script>
    //making a function to load users data from data
    function loadUserData(data = {}) {
        var content = '';
            $.ajax({
                type: 'GET',
                url: "{{ route('readUser') }}",
                data:data,
                success: function (response) {
                    // console.log(response.users);
                    if (response.users.length>0) {
                        for (let i = response.users.length - 1; i >= 0; i--) {
                            let users = response.users[i];
                            content +=
                                `<tr>
                                <td>${i+1}</td>
                                <td>${users['name']}</td>
                                <td>${users['email']}</td>
                                <td><button class="btn btn-success updateData" data-id="${users.id}" data-bs-toggle="modal" data-bs-target="#userUpdate">Update</button></td>
                                <button type="button" class="btn btn-success" >Update New User</button>
                                <td><button class=" btn btn-danger deleteData" data-id="${users.id}">Delete</button></td>
                                <tr>`
                            }
                            $('#users-table tbody').html(content);
                    } else {
                        $('#users-table tbody').html("<tr><td colspan='6'>No Data Found</td></tr>");
                    }
                },
                error: function (error) {
                    console.log(error);
                },
            });
    };

    $(document).ready(()=>{
        //call the function to load the table data
        loadUserData();

        //search option table manipulation DOM
        $('#search').on('keyup',function(){
            search = $('#search').val();
            loadUserData({search});
        });

        //delete operation using ajax
        $('#users-table').on('click','.deleteData',function(){
            event.preventDefault();
            var id = $(this).attr('data-id');
                $.ajax({
                    url: '/delete-user/'+id,
                    type:'GET',
                    success:(response)=>{
                        // alert(response.message);
                        // alert(response.message);
                        loadUserData();
                    },
                    error:(error)=>{
                        console.log(error);
                        // alert(error);
                    },
                });
            });
    });
</script>
@endpush
@endsection
