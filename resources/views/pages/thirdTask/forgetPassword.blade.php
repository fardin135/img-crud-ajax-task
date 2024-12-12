@extends('layouts.app')
@section('title') {{ "Third Task" }}@endsection
@section('main')

<div class="container">
<h2 class="text-center mt-3">Enter Your Email</h2>
<form id="loginForm" method="POST" action="{{ route('sendOTPCode') }}">
    @csrf
  <!-- Email input -->
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" id="email" class="form-control" aria-describedby="emailHelp">
        <span class="error" id="email_error"></span>
    </div>

{{-- submit btn + registration link + forget password --}}
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary w-100 mt-5">Send Email</button>    
    </div>
</div>
@endsection


<script>
window.open('/enter-otp');
</script>
