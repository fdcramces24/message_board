<?php
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
        public function inbox($postData){
            $offset = isset($postData['paged']) ? $postData['paged'] : 0;
            $limit = 2;
            $authData = $this->Auth->user();
            $userId  = $authData['id'];
            $this->loadModel('Connection');
            $this->loadModel('Message');
            $this->loadModel('ConnectionMember');
            $this->loadModel('User');
            $returnVal = [
                "success" => true
            ];
            $sql = $this->ConnectionMember->query("SELECT * FROM connection_members WHERE user_id = '$userId'");
            if(!empty($sql)){
                $connectionIds = [];
                $recieverIds = [];
                foreach ($sql as $row) {
                    $connectionIds[] = $row['connection_members']['connection_id'];
                }

                $connectionIdsString = implode(', ', $connectionIds);
                $offsetString = $offset > 0 ? 'OFFSET '.$offset : '';
                $connections = $this->Connection->query("SELECT * FROM connections WHERE id IN ($connectionIdsString) LIMIT $limit $offsetString");
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
                $countConnections = 0;
                foreach($connections as $connection){
                    $name = "";
                    $content = "";
                    $count = 0;
                    foreach($connection_members as $connection_member){
                        if($connection_member['connection_members']['connection_id'] == $connection['connections']['id'] && $connection_member['connection_members']['user_id'] != $userId){
                            $name = $simplifiedUser[$connection_member['connection_members']['user_id']]['users']['fullname'];
                        }
                    }
                    foreach($messages as $message){
                        if($connection['connections']['id'] === $message['messages']['connection_id']){
                            $count++;
                            $content = $message['messages']['content'];
                        }
                    }
                    $countConnections++;
                    $returnVal['data'][] = ["name" => $name, "content" => $content, "count" => $count,"connection_id" => $connection['connections']['id']];
                }
                $returnVal['paginate'] = ["limit" => $limit, "page" => $offset,'total'=>$countConnections];
            }else{
                $returnVal["success"] = false;
            }
            echo json_encode($returnVal);
        }
        public function replyConversation($postData){
            $connectionId = $postData['connectionId'];
            $content = $postData['content'];
            $userId = $this->Auth->user()['id'];
            // $myProfile = $this->User->findById($userId);
            $this->loadModel('Message');
            $this->loadModel('User');
            $myProfile = $this->User->findById($userId);
            $data = [
                'connection_id' => $connectionId,
                'content' => $content,
                'user_id' => $userId
            ];
            if($this->Message->save($data)){
                echo json_encode($myProfile);
            }
            else{
                echo 1;
            }
        }
    }
?>