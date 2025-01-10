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
                $('#update_' + key + '_error').html(value).addClass('text-danger');
            });
          };
        },
        });
      });
}



function readDataAjax(url, data = {}, ...columns) {
    let content = '';
    $.ajax({
        type: 'GET',
        url: url,
        data: data,
        success: function (response) {
            console.log(response);
            let pagination = ''; // Initialize pagination
            // Generate table rows
            if (response.data.data.length > 0) {
                response.data.data.forEach((key, index) => {
                    content += `<tr>
                        <td>${index + 1}</td>`;
                    columns.forEach(column => {
                        content += `<td>${key[column] || '-'}</td>`;
                    });
                    content += `<td>
                        <button class="btn btn-success updateData" data-id="${key.id}" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>
                    </td>
                    <td>
                        <button class="btn btn-danger deleteData" data-id="${key.id}">Delete</button>
                    </td>
                </tr>`;
                });
                $('#users-table tbody').html(content);
                    let paginationContent = '';
                    let currentPage = response.data.current_page;
                    let lastPage = response.data.last_page;
                    if (currentPage > 1) {
                        paginationContent += `<button class="btn btn-info prevbtn m-2" data-page=${currentPage - 1}>Previous</button>`;
                    }
                    else {
                        paginationContent += `<button class="btn btn-secondary prevBtn m-2 disabled" data-page=${currentPage - 1}>Previous</button>`;
                    }
                    
                    for (let i = 1; i <= lastPage; i++) {
                        paginationContent += `<button class="btn ${i == currentPage ? 'btn-primary' : 'btn-secondary'} currentBtn m-2" data-page=${i}>${i}</button>`;
                    }
                    if (currentPage < lastPage) {
                        paginationContent += `<button class="btn btn-info nextBtn m-2" data-page=${currentPage + 1}>Next</button>`;
                    }
                    else {
                        paginationContent += `<button class="btn btn-secondary nextBtn m-2 disabled" data-page=${currentPage + 1}>Next</button>`;
                    }
                $('.pagination-container').html(paginationContent);
            } else {
                $('#users-table tbody').html("<tr><td colspan='6'>No Data Found</td></tr>");
            }
        },
        error: function (error) {
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


//common ajax code for deleting
// function deleteDataAjax(table,url) {
//         $(table).on('click','.deleteData',function(){
//         event.preventDefault();
//         var id = $(this).attr('data-id');
//             $.ajax({
//                     url: url+'/'+id,
//                     type:'GET',
//                     success:(response)=>{
//                         // alert(response.message);
//                         // alert(response.message);
//below method can be used to load the table after deleting data only in compact
//                         // $(table).load(location.href + ' '+table);
//                     },
//                     error:(error)=>{
//                         console.log(error.responseText);
//                         // alert(error);
//                     },
//                 });
//             });
// }