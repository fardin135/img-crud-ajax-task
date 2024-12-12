
@extends('layouts.app')
@section('title') {{ "Third Task" }}@endsection
@section('main')

<div class="container">
<h2 class="text-center mt-3">Enter Your Otp Code</h2>
<form id="loginForm" method="POST" action="{{ route('sendOTPCode') }}">
    @csrf
  <!-- Email input -->
    <div class="mb-3">
        <label for="otp" class="form-label">Enter Otp</label>
        <input type="number" name="otp" id="otp" class="form-control" aria-describedby="emailHelp">
        <span class="error" id="otp_error"></span>
    </div>

{{-- submit btn + registration link + forget password --}}
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary w-100 mt-5">Enter OTP</button>    
    </div>
</div>
@endsection
@push('scripts')
<script>
window.open(/);
</script>
@endpush