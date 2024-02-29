<?php
            if(!$isEmpty):
        ?>
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
            <li class="list-group-item d-flex position-relative listMessage">
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
        <?php else:?>
            <ul class="list-group">
                <li class="list-group-item text-center">
                    <p class="mb-0">Message box is empty. Click <a href="<?php echo $this->Html->url(['controller' => 'messages', 'action' => 'new']); ?>">here</a> to create</p>
                </li>
            </ul>
        <?php endif;?>