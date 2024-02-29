<div class="card">
    <div class="card-header">
        Title
    </div>
    <div class="card-body">
        <div class="chat-container">
            <div class="message-container">
            <?php
            // debug($messages);
                foreach($messages as $message):
            ?>
            <div class="pm-message <?= $message['User']['id'] == $userId ? 'sent' : 'received'?>">
            <?php
                $profilePicture = '/uploads/default.jpg';
                if(!empty($message['User']['profile_photo'])){
                    $profilePicture  = '/uploads/'.$message['User']['profile_photo'];
                }
            ?>
                <img src="<?= $profilePicture; ?>" alt="Avatar" class="avatar">
                <div class="message-bubble">
                 <span class="sender-name d-block"><?= $message['User']['fullname']; ?></span> <?= $message['Message']['content']; ?>
                <div class="message-info"><?= $this->Time->format($message['Message']['created_at'], '%B %e, %Y - %H:%M %p');?></div>
                </div>
            </div>
            <?php endforeach;?>
            </div>

                <form id="sendMessage">
                    <div class="input-group mb-3">
                        <input type="hidden" name="conId" value="<?= $conId; ?>">
                        <textarea class="form-control" name="content" placeholder="Type your message..." aria-label="Type your message..."></textarea>
                        <button class="btn btn-primary" type="submit" id="button-addon2">Send</button>
                    </div>
                </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#sendMessage').submit(function(e){
            e.preventDefault();
            var connectionId = $('input[name="conId"]').val();
            var content = $('textarea[name="content"]').val();
            $('textarea[name="content"]').val('');
            var currentDate = new Date();
            var formattedDate = formatDate(currentDate);
            $.ajax({
                url: '/users/api',
                type: 'POST',
                dataType: 'json',
                data: {
                    connectionId,content,
                    method: 'replyConversation'
                },
                success:function(response){
                    if(response != 1){
                        var profilePhoto = response.User.profile_photo
                        if (!profilePhoto) {
                            profilePhoto = "default.jpg";
                        }
                        var html = '';
                        html+='<div class="pm-message sent">';;
                        html+='<img src="/uploads/'+profilePhoto+'" alt="Avatar" class="avatar">';
                        html+='<div class="message-bubble">';
                        html+='<span class="sender-name d-block">'+response.User.fullname+'</span>'+content+'';
                        html+='<div class="message-info">'+formattedDate+'</div>';
                        html+='</div>';
                        html+='</div>';
                        $('.message-container').append(html);
                        $(".message-container").scrollTop($(".message-container")[0].scrollHeight);
                    }
                }
            })
        })

        function formatDate(date) {
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            
            var month = months[date.getMonth()];
            var day = date.getDate();
            var year = date.getFullYear();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            
            // Convert hours from 24-hour to 12-hour format
            hours = hours % 12;
            hours = hours ? hours : 12; // Handle midnight (0 hours)
            
            // Add leading zero if necessary
            if (minutes < 10) {
                minutes = '0' + minutes;
            }
            
            // Construct the formatted date string (e.g., February 29, 2024 - 11:59 AM)
            var formattedDate = month + ' ' + day + ', ' + year + ' - ' + hours + ':' + minutes + ' ' + ampm;
            
            return formattedDate;
        }
    })
</script>
