@extends('layouts.app')
@section('title') {{ "Third Task" }}@endsection
@section('main')

<div class="container">
<h2 class="text-center mt-3">Registration Page</h2>
<form id="registerForm">
    @csrf
      <!-- Name input -->
    <div class="mb-3">
        <label for="reg_name" class="form-label">Name</label>
        <input type="text" name="name" id="reg_name" class="form-control" aria-describedby="emailHelp">
        <span class="error" id="name_error"></span>
    </div>
  <!-- Email input -->
    <div class="mb-3">
        <label for="reg_email" class="form-label">Email address</label>
        <input type="email" name="email" id="reg_email" class="form-control" aria-describedby="emailHelp">
        <span class="error" id="email_error"></span>
    </div>

  <!-- Password input -->
    <div class="mb-3">
        <label for="reg_password" class="form-label">Password</label>
        <input type="password" name="password" id="reg_password" class="form-control">
        <span class="error" id="password_error"></span>
    </div>
      <!-- Password confirmation input -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        <span class="error" id="password_confirmation_error"></span>
    </div>
{{-- submit btn + registration link + forget password --}}
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary w-100 mt-5">Register Now</button>    
    </div>
    <div class="d-flex justify-content-end mt-5">
        <div class="div">
            <p>Already Have a Account? <a href="/login">Login</a></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
  <script>
    //ajax code for creatinng new user
    $(document).ready(()=>{
      $('#registerForm').on('submit',(event)=>{
        $('.error').text('');
        //prevent from reload
        event.preventDefault();
        //getting the form data
        form= $('#registerForm')[0];
        data= new FormData(form);
        //ajax starts here
        $.ajax({
          type:"POST",
          url:"{{ route('userRegistration') }}",
          data:data,
          processData:false,
          contentType:false,
          success: function (response){
            form.reset();
            window.open('/home');
            // console.log(response.message);
        },
        error:function (error){
          console.log(error.responseJSON.errors);
          if (error.responseJSON.errors) {
            $.each(error.responseJSON.errors,function(key,value){
              $('#'+key+'_error').html(value).addClass('text-danger');
            });
          };
        },
        });
      });
    });
  </script>
@endpush