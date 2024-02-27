<?php
    App::uses('AppController','Controller');

    class ApisController extends AppController{
        public function run(){
            $this->autoRender = false;
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
    }
?>