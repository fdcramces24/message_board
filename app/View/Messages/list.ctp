<div class="card">
  <div class="card-header">
    Inbox
  </div>
  <div class="card-body">
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
            <li class="list-group-item ">
              <a href="<?= $this->Html->url(array('controller' => 'messages','action' => 'message', 'id'=>$connection['connections']['id']))?>" class="text-decoration-none d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                  <div class="fw-bold"><?= $name?></div>
                   <div class="text-dark">
                      <?= $content; ?>
                   </div>
                </div>
                <span class="badge bg-primary rounded-pill"><?= $count++ ?></span>
              </a>
              
            </li>
        <?php 
            $topMsg = "";
            endforeach;
        ?>
    </ol>
  </div>
</div>