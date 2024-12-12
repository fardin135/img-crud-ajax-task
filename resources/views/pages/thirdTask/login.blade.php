@extends('layouts.app')
@section('title') {{ "Third Task" }}@endsection
@section('main')

<div class="container">
<h2 class="text-center mt-3">Login Page</h2>
<form id="loginForm">
    @csrf
  <!-- Email input -->
    <div class="mb-3">
        <label for="login_email" class="form-label">Email address</label>
        <input type="email" name="login_email" id="login_email" class="form-control" aria-describedby="emailHelp">
        <span class="error" id="login_email_error"></span>
    </div>

  <!-- Password input -->
    <div class="mb-3">
        <label for="login_password" class="form-label">Password</label>
        <input type="password" name="login_password" id="login_password" class="form-control">
        <span class="error" id="login_password_error"></span>
    </div>
{{-- submit btn + registration link + forget password --}}
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary w-100 mt-5">Login Now</button>    
    </div>
    <div class="d-flex justify-content-between mt-5">
        <div class="div">
            <a href="/forget-password">Forgot password?</a>
        </div>
        <div class="div">
            <p>Don't Have a Account? <a href="/registration">Register</a></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
  <script>
    //ajax code for checking user credential
    $(document).ready(()=>{
      $('#loginForm').on('submit',(event)=>{
        $('.error').text('');
        //prevent from reload
        event.preventDefault();
        //getting the form data
        form= $('#loginForm')[0];
        data= new FormData(form);
        //ajax starts here
        $.ajax({
          type:"POST",
          url:"{{ route('userLogin') }}",
          data:data,
          processData:false,
          contentType:false,
          success: function (response){
            console.log(response);
              if (response.status== 'failed') {
                  alert(response.message);
                }else{
                form.reset();
                window.open('/home');
            }
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