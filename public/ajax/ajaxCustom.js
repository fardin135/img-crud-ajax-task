//common ajax code for creating
function createDataAjax(modalId,formId,url,loadData) {
    $(formId).on('submit',(event)=>{
        $('.error').text('');
        //prevent from reload
        event.preventDefault();
        //getting the form data
        form= $(formId)[0];
        data= new FormData(form);
        //ajax starts here
        $.ajax({
          type:"POST",
          url:url,
          data:data,
          processData:false,
          contentType:false,
          success: function (response){
            form.reset();
            $(modalId).modal('hide');
            loadData();
            // console.log(response.message);
        },
        error:function (error){
          console.log(error);
          if (error.responseJSON.errors) {
            $.each(error.responseJSON.errors,function(key,value){
              $('#'+key+'_error').html(value).addClass('text-danger');
            });
          };
        },
        });
      });
}



//common ajax code for reading
function readDataAjax(url,data = {}, ...columns) {
    let content = '';
    $.ajax({
        type: 'GET',
        url: url,
        data:data,
        success: function (response) {
            // console.log(response.users);
            if (response.data.length>0) {
                for (let i = response.data.length-1 ; i >= 0; i--) {
                    let key = response.data[i];
                    // let content = '';
                        content +=
                            `<tr>
                                <td>${i + 1}</td>`
                                columns.forEach(column => {
                                    content += `<td>${key[column]}</td>`
                                });
                                // <td>${users['name']}</td>
                                // <td>${users['email']}</td>
                         content +=
                                `<td><button class="btn btn-success updateData" data-id="${key.id}" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button></td>
                                <td><button class=" btn btn-danger deleteData" data-id="${key.id}">Delete</button></td>
                            </tr>`
                }
                    $('#users-table tbody').html(content);
            } else {
                $('#users-table tbody').html("<tr><td colspan='6'>No Data Found</td></tr>");
            }
        },
        error:function (error) {
            console.log(error);
        },
    });
}



//common ajax code for updating
function updateDataAjax(table,url,...columns) {
    $(table).on('click', '.updateData', function () {
    let id = $(this).attr('data-id'); // Correctly get the data-id attribute
        // Fetch user data using AJAX
            $.ajax({
                type: 'GET',
                url: url+'/'+id,
                success: (response) => {
                    // Fill modal fields with data from the response
                    // console.log(response);
                    columns.forEach(column => {
                        $('#update_'+column).val(response.data[column]); 
                    });
                },
                error: (error) => {
                    console.log(error.responseText);
                },
            });
    });
}



//common ajax code for deleting
function deleteDataAjax(table,url,loadData) {
        $(table).on('click','.deleteData',function(){
        event.preventDefault();
        var id = $(this).attr('data-id');
            $.ajax({
                    url: url+'/'+id,
                    type:'GET',
                    success:(response)=>{
                        // alert(response.message);
                        // alert(response.message);
                        loadData();
                    },
                    error:(error)=>{
                        console.log(error.responseText);
                        // alert(error);
                    },
                });
            });
}