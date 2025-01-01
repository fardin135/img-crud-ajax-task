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
    $(document).ready(()=>{
        // render the data in the table
         readDataAjax('/read-user',{},'name','email');

        //search option table manipulation DOM
        $('#search').on('input',function(){
            search = $('#search').val();
            console.log(search);
            readDataAjax('/read-user',{search},'name','email');
        });

        // delete the data in the table
        deleteDataAjax('#users-table','/delete-user',()=>{readDataAjax('/read-user',{},'name','email')});
    });
</script>
@endpush
@endsection
