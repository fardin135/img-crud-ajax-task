<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userCreate">Create New User</button>
<!-- Modal -->
<div class="modal fade" id="userCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Create New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="newUser">
          @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" aria-describedby="name">
                <span class="error" id="name_error"></span>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" id="email" class="form-control" aria-describedby="emailHelp">
                <span class="error" id="email_error"></span>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <span class="error" id="password_error"></span>
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
          createDataAjax('#userCreate','#newUser',"{{ route('createUser') }}",()=>{readDataAjax('/read-user',{},'name','email')});
    });
  </script>
@endpush
