<?php
App::uses('AppController','Controller');

class UsersController extends AppController{
    public $helpers = array('Html','Form');
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('new');   
    }
    public function edit(){
        $authData = $this->Auth->user();
        $userId  = $authData['id'];
        $userData = $this->User->findById($userId);
        if($this->request->is(array('post','put'))){
              //check if user update profile picture
              $profilePhoto = "";
            if(!empty($this->request->data['Users']['image']['name'])){
                $file = $this->request->data['Users']['image'];
                $uploadPath = WWW_ROOT.'uploads';

                //check if file exists
                if(!file_exists($uploadPath)){
                    mkdir($uploadPath);
                }

                $filename = uniqid().'-'.$file['name'];
                if(in_array($file['type'], ['image/jpeg','image/jpg','image/png','image/gif'])){
                    if(move_uploaded_file($file['tmp_name'], $uploadPath . DS . $filename)){
                        $profilePhoto = $filename;
                    }else{
                        $this->Flash->set('Failed to upload image. Please try again', array(
                            'element' => 'error'
                        )); 
                    }

                }else{
                    $this->Flash->set('Invalid extension', array(
                        'element' => 'error'
                    )); 
                }
            }
            $this->User->id = $userId;
            $data = [
                'fullname' => $this->request->data['fullname'],
                'gender' => $this->request->data['gender'],
                'birthdate' => $this->request->data['birthdate'],
                'hubby' => $this->request->data['User']['hubby'],
                'profile_photo' => $profilePhoto
            ];
            if($this->User->save($data)){
                $userData = $this->User->findById($userId);
                // $this->Flash->success('The user has been saved!');
                $this->Flash->success('<strong>The user has been saved!</strong>', ['element' => 'success']);

                $this->redirect(['controller' => 'messages', 'action' => 'index']);
            }
        }
        $this->set('userData',$userData['User']);
    }
    public function new(){
        $this->autoRender = false;
        if($this->request->is('post')){
            $fullname = $this->request->data['Users']['fullname'];
            $email = $this->request->data['Users']['email'];
            $password= $this->request->data['Users']['password'];
            $confirm_password= $this->request->data['Users']['confirm_password'];
            $data = [
                "fullname" => $fullname,
                "email" => $email,
                "confirm_password" => $confirm_password,
                "password" => $password
            ];
            if($this->User->save($data)){
                $dbUserData = $this->User->read(null,$this->User->id);
                if($this->Auth->login($dbUserData['User'])){
                    $this->redirect(['controller' => 'users', 'action' => 'welcome']);
                }
            }
        }
        $this->layout = 'auth';
        $this->render('/Users/Auth/registration');
    }
    public function welcome(){
        $authData = $this->Auth->user();
        $lastLoggedIn  = $authData['last_logged_in'];
        if(empty($lastLoggedIn)){
            $userId = $authData['id'];
            $userData = $this->User->findById($userId);
            if(empty($userData['last_logged_in'])){
                $data = [
                    'id' => $userId,
                    'last_logged_in' => date('Y-m-d H:i:s')
                ];
                $this->User->save($data);
            }else{
                $this->redirect(['controller' => 'users', 'action' => 'index']);
            }
        }
        $this->layout = 'auth';
        $this->render('/Users/Auth/welcome');
    }
    public function login(){
        if($this->request->is('post')){
            if($this->Auth->login()){
                $datenow = date("Y-m-d H:i:s");
                $data = array(
					'id' => $this->Auth->user('id'),
					'last_logged_in' => $datenow
				);
                if($this->User->save($data)){
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }else{
                $this->Flash->set('Invalid username or password, please try again.',array('element' => 'error'));
            }
        }
        $this->layout =  'auth';
        $this->render('/Users/Auth/login');
    }
    public function index(){
        $authData = $this->Auth->user();
        $userId = $authData['id'];
        $userData = $this->User->findById($userId);
        $this->set('userData',$userData['User']);
    }
    public function logout(){
        $this->Auth->logout();
        $this->redirect(['controller' => 'users', 'action' => 'login']);
    }
}

?>