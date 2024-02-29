<div class="card">
  <div class="card-header">
    New Message
  </div>
  <div class="card-body">
     <?= $this->Form->create('Messages',['controller' => 'messages','url' => 'new']);?>
     <div class="row">
        <div class="col">
            <?= $this->Flash->render();?>
        </div>
     </div>
     <div class="row">
        <div class="col">
            <?php
                echo $this->Form->input('recipientId', [
                    'class' => 'form-control select2',
                    'label' => 'To',
                    'empty' => 'Select recipient',
                    'options' => $users
                ]);
            ?>
            <!-- <input type="text" class="form-control" id="recipient"> -->
            <input type="text" hidden name = "recipientId">
            <div class="table">
            <ul class="list-group" id = "listContacts">
            </ul>
            </div>
        </div>
     </div>
     <div class="row mt-2">
        <div class="col">
            <label for="content">Content:</label>
            <textarea name="content" class="form-control" id="content " cols="30" rows="10"></textarea>
        </div>
     </div>
     <div class="row mt-4">
        <div class="col">
             <button class="btn btn-success">Send</button>
        </div>
     </div>
  </div>
</div>
<script>
    $(document).ready(function(){
        $('#recipient').keyup(function(){
            var name = $(this).val();
            $.ajax({
                url:'/users/api',
                type:'POST',
                dataType:'json',
                data:{name,method:'findRecipient'},
                success:function(response){
                    var htmlDisplay = '';
                    $.each(response, function(index,items){
                        htmlDisplay += "<li class='list-group-item userDiv' name='"+items.User.fullname+"' uID="+items.User.id+">"+items.User.fullname+"</li>";
                    })
                    $('#listContacts').html(htmlDisplay);
                }
            })

        })
        $(document).on('click','.userDiv',function(){
            $('#recipient').val($(this).attr('name'));
            $("input[name='recipientId']").val($(this).attr('uID'));
            $('#listContacts').html('');
        })
        $('.select2').select2();
        // $('.select2').addClass('form-control');
        // $('.mySelect').select2({
        //     ajax: {
        //     url: 'your_endpoint_url', // URL to fetch data from
        //     dataType: 'json',
        //     delay: 250, // Delay in milliseconds before sending the query
        //     processResults: function(data) {
        //         // Process the fetched data and return an array of objects in the required format
        //         return {
        //         results: data // Assuming the data is already in the correct format
        //         };
        //     },
        //     cache: true // Cache the AJAX results to improve performance
        //     }
        // });
        // $('#recipient').blur(function() {
        //     $('#listContacts').html('');
        // });
        
    })
</script>