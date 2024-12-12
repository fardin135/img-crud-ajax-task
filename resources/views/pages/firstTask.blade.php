@extends('layouts.app')
@section('title') {{ "First Task" }}@endsection
@section('main')

<div class="container mt-5">
    <h2 class="text-center">Upload Multiple Images</h2>
    <form id="multipleImageUploadForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="images" class="form-label">Select Multiple Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
            <span id="image_error" class="mt-2"></span>
        </div>
        <div class="d-flex justify-content-center mt-5">
            <button type="submit" id="submit_btn" class="btn btn-primary">Upload</button>
        </div>
    </form>
        <span id="message" class="mt-3"></span>
</div>
@endsection

@push('scripts')
<script>
    //ajax codes to insert data into database without refresh
    $(document).ready(function () {
        $('#multipleImageUploadForm').on('submit', function (event) {
            $('#message').text('');
            $('#image_error').text('');
            event.preventDefault();
            //get the form data
            let form =$('#multipleImageUploadForm')[0];
            let data = new FormData(form);
            // ajax for sending data starts here
            $.ajax({
                url: "/multiple-image-upload",
                method: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    // console.log(response.message);
                    $('#message').text(response.message).addClass('text-success');
                    form.reset();
                },
                error: function (error) {
                    // console.log(error.responseJSON.errors.images);
                    $('#message').text(error.message);
                    $('#image_error').html(error.responseJSON.errors.images).addClass('text-danger');
                }
            });
        });
    });
</script>
@endpush