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
            <div class="message <?= $message['User']['id'] == $userId ? 'sent' : 'received'?>">
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
            
            <!-- <div class="message received">
                <img src="https://via.placeholder.com/40" alt="Avatar" class="avatar">
                <div class="message-bubble">
                I'm doing fine, thank you!
                <div class="message-info">12:35 PM</div>
                </div>
            </div> -->
            <?php endforeach;?>
        <!-- Add more messages as needed -->

            </div>
                <?= $this->Form->create('Messages',['controller' => 'messages','url' => 'sendMessage']);?>
                    <div class="input-group mb-3">
                        <input type="hidden" name="conId" value="<?= $conId; ?>">
                        <textarea class="form-control" name="content" placeholder="Type your message..." aria-label="Type your message..."></textarea>
                        <button class="btn btn-primary" type="submit" id="button-addon2">Send</button>
                    </div>
                <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
