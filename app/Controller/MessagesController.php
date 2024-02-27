<?php
    App::uses('AppController','Controller');
    class MessagesController extends AppController{
        public function beforeFilter(){
            parent::beforeFilter();
        }
        public function new(){
            if($this->request->is('post')){
                $authData = $this->Auth->user();
                $userId  = $authData['id'];
                $usersInChannel = [$userId,$this->request->data['recipientId']];
                $this->loadModel('ConnectionMember');
                $this->loadModel('Connection');
                $result = $this->ConnectionMember->find('all',array(
                    'conditions' => [
                        'user_id IN' => $usersInChannel
                    ],
                    'fields' => array('connection_id', 'COUNT(*) AS count'),
                    'group' => 'connection_id',
                    'having' => array('count' => 2)
                ));
                if(empty($result)){
                    $this->Connection->save([
                        'name' => '_',
                    ]);
                    $connectionId  = $this->Connection->id;
                    $saveMany = [];
                    foreach($usersInChannel as $id){
                        $saveMany[] = [
                                'connection_id' => $connectionId,
                                'user_id' =>$id
                        ];
                    }
                    $this->ConnectionMember->saveMany($saveMany);
                    $this->Message->save([
                        'connection_id' => $connectionId,
                        'user_id' => $userId,
                        'content' => $this->request->data['content']
                    ]);
                }else{
                    $connectionId = $result[0]['ConnectionMember']['connection_id'];
                    $this->Message->save([
                        'connection_id' => $connectionId,
                        'user_id' => $userId,
                        'content' => $this->request->data['content']
                    ]);
                }
            }
        }
        public function sendMessage(){
            $authData = $this->Auth->user();
            $userId  = $authData['id'];
            $this->autoRender = false;
            if($this->request->is('post')){
                $conId = $this->request->data('conId');
                $content = $this->request->data('content');
                $data = [
                    'connection_id' => $conId,
                    'content' => $content,
                    'user_id' => $userId
                ];
                if($this->Message->save($data)){
                   $this->redirect($this->referer());
                }
            }
            
        }
        public function message(){
            $connectionId = $this->request->params['named']['id'];
            $messages = $this->Message->find('all',[
                'conditions' => ['Message.connection_id' => $connectionId]
            ]);
            $authData = $this->Auth->user();
            $userId  = $authData['id'];
            $this->set('userId',$userId);
            $this->set('conId',$connectionId);
            $this->set('messages',$messages);
        }
        public function list(){
            $authData = $this->Auth->user();
            $userId  = $authData['id'];
            $this->loadModel('Connection');
            $this->loadModel('Message');
            $this->loadModel('ConnectionMember');


            $connectionMember  = $this->ConnectionMember->find('all',[
                'conditions' => ['ConnectionMember.user_id',$userId],
                'fields' => ['*'], 
                // 'group' => ['connection_id'],
            ]);
            $sql = $this->ConnectionMember->query("SELECT * FROM connection_members WHERE user_id = '$userId'");

            $connectionIds = [];
            $recieverIds = [];
            foreach ($sql as $row) {
                $connectionIds[] = $row['connection_members']['connection_id'];
            }

            $connectionIdsString = implode(', ', $connectionIds);

            $connections = $this->Connection->query("SELECT * FROM connections WHERE id IN ($connectionIdsString)");
            $messages = $this->Message->query("SELECT * FROM messages WHERE connection_id IN ($connectionIdsString)");
            $connection_members = $this->ConnectionMember->query("SELECT * FROM connection_members WHERE connection_id IN ($connectionIdsString)");
            $recieverIds = [];
            foreach($connection_members as $member){
                if($userId != $member['connection_members']['user_id']){
                    $recieverIds[] = $member['connection_members']['user_id'];
                }
            }
            $recieverIdsString = implode(', ', $recieverIds);
            $users = $this->User->query("SELECT * FROM users WHERE id IN ($recieverIdsString)");
            $simplifiedUser = [];
            foreach($users as $user){
                $simplifiedUser[$user['users']['id']] = $user;
            }
            $this->set('users',$simplifiedUser);
            $this->set('connections',$connections);
            $this->set('connection_members',$connection_members);
            $this->set('messages',$messages);
            $this->set('userId',$userId);
        }
    }
?>