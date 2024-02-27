<?php
    App::uses('AppModel','Model');
    class Message extends AppModel{
        public $name = 'Message';
        public $useTable = 'messages';
        public $validate = [
            'content' => [
                'required' => [
                    'rule' => 'notBlank',
                    'messsage' => 'Enter your message'
                ]
            ],
            'recipient' => [
                'required' => [
                    'rule' => 'notBlank',
                    'message' => 'Select recipient'
                ]
            ]
            
        ];
        public $belongsTo = [
            'Connection' => [
                'className' => 'Connection',
                'foreignKey' => 'connection_id'
            ],
            'User' => [
                'className' => 'User',
                'foreignKey' => 'user_id'
            ]
        ];
    }
?>