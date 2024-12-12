<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userUpdate">Update New User</button> --}}
<!-- Modal -->
<div class="modal fade" id="userUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateUser">
          @csrf
              <input type="hidden" name="update_id" id="update_id">
              <div class="mb-3">
                <label for="update_name" class="form-label">Name</label>
                <input type="text" name="name" id="update_name" class="form-control" aria-describedby="name">
                <span class="error" id="update_name_error"></span>
              </div>
              <div class="mb-3">
                <label for="update_email" class="form-label">Email address</label>
                <input type="email" name="email" id="update_email" class="form-control" aria-describedby="emailHelp">
                <span class="error" id="update_email_error"></span>
              </div>
              <div class="mb-3">
                <label for="update_password" class="form-label">Password</label>
                <input type="password" name="password" id="update_password" class="form-control">
                <span class="error" id="update_password_error"></span>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
    </div>
  </div>
</div>
@push('scripts')
  <script>
    $(document).ready(()=>{
      $('#users-table').on('click', '.updateData', function () {
        let id = $(this).attr('data-id'); // Correctly get the data-id attribute
          // Fetch user data using AJAX
              $.ajax({
                  type: 'GET',
                  url: '/update-user/' + id,
                  success: (response) => {
                      // Fill modal fields with data from the response
                      // console.log(response);
                      $('#update_id').val(response.users.id);
                      $('#update_name').val(response.users.name);
                      $('#update_email').val(response.users.email);
                      $('#update_password').val(response.users.password);
                      // Show the modal
                    },
                    error: (error) => {
                      console.log(error.responseText);
                    },
              });
      });
        $('#updateUser').on('submit',(event)=>{
          $('.error').text('');
          event.preventDefault();
          var form = $('#updateUser')[0];
          var data = new FormData(form);
            $.ajax({
              type:'POST',
              url:"{{ route('updateUserPost') }}",
              data:data,
              processData:false,
              contentType:false,
              success:(response)=>{
                // console.log(response);
                $('#userUpdate').modal('hide');
                loadUserData();
              },
              error:(error)=>{
                if (error.responseJSON.errors) {
                  $.each(error.responseJSON.errors,function(key,value){
                    $('#update_'+key+'_error').text(value).addClass('text-danger');
                  });
                };
                // console.log(error);
              },
            });
        });
      });
  </script>
@endpush
