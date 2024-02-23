<?php
    App::uses('AppModel','Model');
    class Connection extends AppModel{
        public $name = 'Connection';
        public $useTable = 'connections';
        public $hasMany = [
            'ConnectionMember' => [
                'className' => 'ConnectionMember',
                'foreignKey' => 'connection_id'
            ]
        ];
    }
?>