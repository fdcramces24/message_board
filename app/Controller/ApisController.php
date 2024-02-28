<?php

use function PHPSTORM_META\map;

    App::uses('AppController','Controller');

    class ApisController extends AppController{
        public function beforeFilter(){
            $this->autoRender = false;
        }
        public function run(){
            if($this->request->is('ajax')){
                $method = $this->request->data['method'];
                $postData = $this->request->data;
                //Call method when calling specific function
                $this->$method($postData);
            }
        }
        public function findRecipient($postData){
            $this->loadModel('User');
            $results = $this->User->find('all', [
                'fields' => ['User.fullname','User.id','User.profile_photo'], 
                'conditions' => [
                   'User.fullname LIKE' => '%'.$postData["name"].'%'
                ]
            ]);
            echo json_encode($results);
        }
        public function findMessage($postData){
            $userId = $this->Auth->user()['id'];
            $this->loadModel('Message');
            $this->loadModel('ConnectionMember');
            $content = $postData['value'];
            $sqlGetConnectionMember = $this->ConnectionMember->query("SELECT * FROM messages JOIN users ON users.id = messages.user_id WHERE connection_id IN (SELECT connection_id FROM connection_members WHERE user_id = '$userId' GROUP BY connection_id) AND messages.content LIKE '%$content%' GROUP BY messages.connection_id");
            echo json_encode($sqlGetConnectionMember);
        }
        public function deleteConnection($postData){
            $connectionId = $postData['connectionId'];
            $this->loadModel('Message');
            $this->loadModel('ConnectionMember');
            $this->loadModel('Connection');

            $this->Connection->deleteAll(['id' => $connectionId ]);
            $this->Message->deleteAll(['connection_id' => $connectionId ]);
            $this->ConnectionMember->deleteAll(['connection_id' => $connectionId ]);
        }
    }
?>