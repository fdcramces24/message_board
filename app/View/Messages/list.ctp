<div class="card">
    <div class="card-header d-flex">
        Inbox <a href="<?php echo $this->Html->url(['controller' => 'messages', 'action' => 'new']); ?>" class="text-decoration-none ms-auto"><i class="bi bi-chat-right-text"></i> New Message</a>
    </div>
    <div class="card-body">
        <?php echo $this->Flash->render() ?>
        <form action="" class="my-2">
            <input type="text" class="form-control" placeholder="Search Message" id="searchMessage">
            <ul class="list-group" id="listMessage">
            </ul>
        </form>
        <div id="messageList">
            
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link pagedBtn" pageType="prev" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link pagedBtn" pageType="next">Next</a></li>
            </ul>
        </nav>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script>
function getUrlParameter(name) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}
function load(paged){
        $.ajax({
            url: '/users/api',
                type: 'POST',
                dataType: 'json',
                data: {
                    method: 'inbox',
                    paged
                },
                success:function(response){
                    console.log(response);
                    
                    html = '';
                    if(response.success){
                        if(response.paginate.limit > response.paginate.total){
                            $('.pagination').css('display','none');
                        }
                        html +=  '<ol class="list-group list-group-numbered">';
                        $.each(response.data,function(index,items){
                            html +=     '<li class="list-group-item d-flex position-relative listMessage">';
                            html +=        '<a href="/message/id:'+items.connection_id+'"';
                            html +=            'class="text-decoration-none d-block">';
                            html +=            '<div class="ms-2">';
                            html +=                '<div class="fw-bold">'+items.name+'';
                            html +=                        ' <span class="badge bg-primary rounded-pill">'+items.count+'</span> </div>';
                            html +=                '<div class="text-dark">'+items.content+'</div>';
                            html +=            '</div>';
                            html +=         '</a>';
                            html +=         '<button type="button" class="btn btn-success btn-sm btnRemoveMsg" connection_id="'+items.connection_id+'">';
                            html +=            '<i class="bi bi-trash"></i>';
                            html +=        '</button>';
                            html +=    '</li>';
                        });
                        html += '</ol>';
                    }
                    else{
                                html +=  '<ul class="list-group text-center">'
                                    html +=  '<li class="list-group-item text-center">'
                                    html +=       '<p class="mb-0">Message box is empty. Click <a href="/new-message">here</a> to create</p>'
                                    html +=   '</li>';
                                html +=  '</ul>';
                                $('.pagination').css('display','none');
                    }
                    $('#messageList').html(html);
                }
        })
}
var paged = getUrlParameter('paged');
load(paged);
$(document).ready(function() {
    $('#searchMessage').keyup(function() {
        var value = $(this).val();
        $('#listMessage').html('');
        $.ajax({
            url: '/users/api',
            type: 'POST',
            dataType: 'json',
            data: {
                value,
                method: 'findMessage'
            },
            success: function(response) {
                var html = '';
                $.each(response, function(index, items) {
                    html +=
                        "<li class='list-group-item'><a class='text-decoration-none' href='/message/id:" +
                        items.messages.connection_id + "'> You and '<strong>" +
                        items.users.fullname + "</strong>':  " + items.messages
                        .content + "<a></li>";
                })
                $('#listMessage').html(html);
            } //
        })
    })
    $(document).on('click','.btnRemoveMsg',function() {
        var parentClass = $(this).parent();
        var countMessages = $('.listMessage').length;
        // Use SweetAlert2 to confirm delete action
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var connectionId = $(this).attr('connection_id');
                $.ajax({
                    url: '/users/api',
                    type: 'POST',
                    // dataType: 'json',
                    data: {
                        connectionId,
                        method: 'deleteConnection'
                    },
                    success: function(response) {
                        $(parentClass).remove();
                        var countMessages = $('.listMessage').length;
                        if(countMessages == 0){
                            var html = '';
                                html +=  '<li class="list-group-item text-center">'
                                html +=       '<p class="mb-0">Message box is empty. Click <a href="/new-message">here</a> to create</p>'
                                html +=   '</li>';
                            $('.list-group-numbered').html(html);
                            $('.list-group-numbered').removeClass('list-group-numbered');
                        }
                        Swal.fire(
                            'Deleted!',
                            'Your item has been deleted.',
                            'success'
                        );
                    }
                })
            }
        });
    })
    $('.pagedBtn').click(function(){
        var type = $(this).attr('pageType');
        if(type == 'next'){
            paged = (paged)+1;
            alert(paged);
            load(paged);    
        }
    })
})
</script>