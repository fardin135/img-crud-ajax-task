// Create new user ajax
    $(document).ready(()=>{
      $('#newUser').on('submit',(event)=>{
        $('.error').text('');
        event.preventDefault();
        form= $('#newUser')[0];
        data= new FormData(form);
        $.ajax({
          type:"POST",
          url:'/insert-users-data',
          data:data,
          processData:false,
          contentType:false,
          success: function (response){
            form.reset();
            $('#userCreate').modal('hide');
            loadUserData();
            // console.log(response.message);
            // alert(response.message);
        },
        error:function (error){
          // console.log(error);
          // alert(error.message);
          if (error.responseJSON.errors) {
            $.each(error.responseJSON.errors,function(key,value){
              $('#'+key+'_error').html(value).addClass('text-danger');
            });
          };
        },
        });
      });
    });
// read users ajax

    function loadUserData(data = {}) {
        var data = '';
            $.ajax({
                type: 'GET',
                url: '/api/get-users-data',
                data:data,
                success: function (response) {
                    if (response.users.length>0) {
                        $.each(response.users, function (key, value) {
                            data +=
                                // <td>+(key+1)+</td>
                                // <a class="updateData" href='#' data-id="`+ value.id +`">Update</a>
                                // <a class="deleteData" href='#' data-id="`+ value.id +`">Delete</a>
                                `<tr>
                                <td>`+value.id+`</td>
                                <td>`+value.name+`</td>
                                <td>`+value.email+`</td>
                                <td>`+value.password+`</td>
                                <td><button class=" btn btn-success updateData" data-id="`+ value.id +`" data-bs-toggle="modal" data-bs-target="#userUpdate">Update</button></td>
                                <button type="button" class="btn btn-success" >Update New User</button>
                                <td><button class=" btn btn-danger deleteData" data-id="`+ value.id +`">Delete</button></td>
                                <tr>`
                            });
                            $('#users-table tbody').html(data);
                    } else {
                        $('#users-table tbody').html("<tr><td colspan='6'>No Data Found</td></tr>");
                    }
                },
                error: function (error) {
                    console.log(error);
                },
            });
};
    
//Update user ajax //get data then update
    $(document).ready(()=>{
      $('#users-table').on('click', '.updateData', function () {
        let id = $(this).attr('data-id'); // Correctly get the data-id attribute
          // Fetch user data using AJAX
              $.ajax({
                  type: 'GET',
                  url: '/update-users-data/' + id,
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
              url:'/update-users-data',
              data:data,
              processData:false,
              contentType:false,
              success:(response)=>{
                console.log(response);
                $('#userUpdate').modal('hide');
                loadUserData();
              },
              error:(error)=>{
                if (error.responseJSON.errors) {
                  $.each(error.responseJSON.errors,function(key,value){
                    $('#update_'+key+'_error').text(value).addClass('text-danger');
                  });
                };
                console.log(error);
              },
            });
        });
      });

//delete user ajax
$(document).ready(()=>{
        loadUserData();
        $('#users-table').on('click','.deleteData',function(){
            // event.preventDefault();
            var id = $(this).attr('data-id');
            // alert(id);
                $.ajax({
                    url:'/delete-users-data/'+id,
                    type:'GET',
                    success:(response)=>{
                        // response.preventDefault();
                        console.log(response.message);
                        // alert(response.message);
                        // window.open('/users');
                        loadUserData();
                    },
                    error:(error)=>{
                        console.log(error);
                        // alert(error);
                    },
                });
            });
        });