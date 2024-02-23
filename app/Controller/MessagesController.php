<?php
    App::uses('AppController','Controller');
    class MessagesController extends AppController{
        public function beforeFilter(){
            parent::beforeFilter();
        }
        public function new(){
            if($this->request->is('post')){
                $authData = $this->Auth->user();
                $userId  = $authData['User']['id'];
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
        public function list(){
            $authData = $this->Auth->user();
            $userId  = $authData['User']['id'];

            $this->loadModel('ConnectionMember');
            $result = $this->ConnectionMember->find('all',[
                'conditions' => ['ConnectionMember.user_id' => $userId],
                'contain' => ['Connections']
            ]);
            debug($result);
        }
    }
?>