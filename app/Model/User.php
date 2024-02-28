<?php
    App::uses('AppModel','Model');
    App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');


    class User extends AppModel{
        public $name = 'User';
        public $useTable = 'users';
        public $virtualFields = array(
            'gender_label' => 'CASE WHEN gender = 1 THEN "Male" ELSE "Female" END'
        );
        public $validate = [
            'content' => [
                'required' => [
                    'rule' => 'notBlank',
                    'message' => 'Content is required'
                ]   
            ],
            'fullname' => [
                'required' => [
                    'rule' => 'notBlank',
                    'message' => 'Fullname is required'
                ],
                'minLength' => [
                    'rule' => ['minLength',6],
                    'message' => '5 - 20 characters long'
                ],
                'maxLength' => [
                    'rule' => ['maxLength',20],
                    'message' => '5 - 20 characters long'
                ],
            ],
            'email' => [
                'required' => [
                    'rule' => 'notBlank',
                    'message' => 'Email is required'
                ],
                'unique' => [
                    'rule' => 'isUnique',
                    'message' => 'This email is already registered'
                ],
                'email' => [
                    'rule' => 'email',
                    'message' => 'Please enter a valid email address'
                ]
            ],
            'password' => [
                'required' => [
                    'rule' => 'notBlank',
                    'message' => 'Password is required' 
                ],
                'minLength' => [
                    'rule' => ['minLength',6],
                    'message' => 'Password must be at least 6 character long'
                ],
                'match passwords' => [
                    'rule' => 'matchPasswords',
                    'message' => 'Password dont match'
                ]
            ],
            'confirm_password' => [
                'required' => [
                    'rule' => 'notBlank',
                    'message' => 'Please confirm your password'
                ]
            ],
                
        ];
        public function matchPasswords($data){
            if(isset($this->data['User']['confirm_password'])){
                if($data['password'] == $this->data['User']['confirm_password']){
                    return true;
                }
                $this->invalidate('confirm_password','Password dont match');
                return false;
            }
        }
        public function beforeSave($options = array()){
            if(isset($this->data['User']['password'])){
                $passwordHasher = new BlowfishPasswordHasher();
                $this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
            }
            if(!empty($this->data['User']['id'])){
                $this->data['User']['updated_at'] = date('Y-m-d H:i:s');
            }
            return true;
        }
    }
?>
