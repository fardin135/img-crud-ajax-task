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
            // Generate table rows
            if (response.data.data.length > 0) {
                response.data.data.forEach((key, index) => {
                    console.log(`key ${key}`);
                    console.log(`index  ${index}`);
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
                    const currentPage = response.data.current_page;
                    const lastPage = response.data.last_page;
                    let paginationContent = '';
                    // Previous button
                    paginationContent += `<button class="btn ${currentPage > 1 ? 'btn-info' : 'btn-secondary disabled'} m-2 prevbtn" data-page="${currentPage - 1}">Previous</button>`;
                        // current page with side two buttons
                        for (let i = 1; i <= lastPage; i++) {
                            //show first and last button with current page between two buttons(-2,-1,currentPage-i = 0,1,2)
                            if (i === 1 || i === lastPage || Math.abs(currentPage - i) <= 2) {
                                // console.log(`currentPage - i = ${currentPage - i}`);
                                paginationContent += `<button class="btn ${i === currentPage ? 'btn-primary' : 'btn-secondary'} m-2 currentBtn" data-page="${i}">${i}</button>`;
                            //ingore the rest of the buttons with a eclipse 
                            } else if (Math.abs(currentPage - i) === 3) {
                                paginationContent += `<span class="m-2">...</span>`;
                            }
                        }
                    // Next button
                    paginationContent += `<button class="btn ${currentPage < lastPage ? 'btn-info' : 'btn-secondary disabled'} m-2 nextbtn" data-page="${currentPage + 1}">Next</button>`;
                    //showing the total items like data tables
                    $('.pagination-status').html(`<p class="m-2">Showing ${response.data.from} to ${response.data.to} of ${response.data.total} records</p>`);
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