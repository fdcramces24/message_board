<?php
    App::uses('AppModel','Model');
    class ConnectionMember extends AppModel{
        public $name = 'ConnectionMember';
        public $useTable = 'connection_members';
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