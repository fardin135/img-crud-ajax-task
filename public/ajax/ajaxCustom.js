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
                    // Function to generate pagination
                    const currentPage = response.data.current_page;  // Get the current page number
                    const lastPage = response.data.last_page;        // Get the total number of pages
                    let paginationContent = '';  // String to hold the pagination HTML

                    // 1. Previous button (Go to the previous page)
                    paginationContent += `<button class="btn ${currentPage > 1 ? 'btn-info' : 'btn-secondary disabled'} m-2 prevbtn" data-page="${currentPage - 1}">Previous</button>`;

                    // 2. First page button (Show the first page if we're more than 3 pages away)
                    if (currentPage > 3) {
                        paginationContent += `<button class="btn btn-secondary m-2 currentBtn" data-page="1">1</button>`;  // First page button
                        paginationContent += `<span class="m-2">...</span>`;  // Ellipsis to indicate skipped pages
                    }

                    // 3. Page buttons around the current page (Show pages before and after the current page)
                    for (let i = Math.max(1, currentPage - 2); i <= Math.min(lastPage, currentPage + 2); i++) {
                        // Display page numbers near the current page
                        paginationContent += `<button class="btn ${i === currentPage ? 'btn-primary' : 'btn-secondary'} m-2 currentBtn" data-page="${i}">${i}</button>`;
                    }

                    // 4. Last page button (Show the last page if we're more than 3 pages away)
                    if (currentPage < lastPage - 3) {
                        paginationContent += `<span class="m-2">...</span>`;  // Ellipsis to indicate skipped pages
                        paginationContent += `<button class="btn btn-secondary m-2 currentBtn" data-page="${lastPage}">${lastPage}</button>`;  // Last page button
                    }

                    // 5. Next button (Go to the next page)
                    paginationContent += `<button class="btn ${currentPage < lastPage ? 'btn-info' : 'btn-secondary disabled'} m-2 nextbtn" data-page="${currentPage + 1}">Next</button>`;

                    // Update the pagination container with the generated content
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