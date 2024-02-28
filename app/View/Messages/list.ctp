<div class="card">
    <div class="card-header">
        Inbox
    </div>
    <div class="card-body">
        <?php echo $this->Flash->render() ?>
        <form action="" class="my-2">
            <input type="text" class="form-control" placeholder="Search Message" id="searchMessage">
            <ul class="list-group" id="listMessage">
            </ul>
        </form>
        <ol class="list-group list-group-numbered">
            <?php
          foreach($connections as $connection):
        ?>
            <?php
              $name = "";
              $content = "";
              $count = 0;
              foreach($connection_members as $connection_member){
                if($connection_member['connection_members']['connection_id'] == $connection['connections']['id'] && $connection_member['connection_members']['user_id'] != $userId){
                    $name = $users[$connection_member['connection_members']['user_id']]['users']['fullname'];
                }
              }
              foreach($messages as $message){
                  if($connection['connections']['id'] === $message['messages']['connection_id']){
                    $count++;
                    $content = $message['messages']['content'];
                  }
              }
            ?>
            <li class="list-group-item d-flex position-relative">
                <a href="<?= $this->Html->url(array('controller' => 'messages','action' => 'message', 'id'=>$connection['connections']['id']))?>"
                    class="text-decoration-none d-block">
                    <div class="ms-2">
                        <div class="fw-bold"><?= $name?> <span
                                class="badge bg-primary rounded-pill"><?= $count++ ?></span> </div>
                        <div class="text-dark"><?= $content; ?></div>
                    </div>
                </a>
                <button type="button" class="btn btn-success btn-sm btnRemoveMsg"
                    connection_id="<?= $connection['connections']['id']?>">
                    <i class="bi bi-trash"></i>
                </button>
            </li>
            <?php 
            $topMsg = "";
            endforeach;
        ?>
        </ol>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script>
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
    $('.btnRemoveMsg').click(function() {
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
                    dataType: 'json',
                    data: {
                        connectionId,
                        method: 'deleteConnection'
                    },
                    success: function(response) {
                        console.log(response);
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

})
</script>