<?php

    require_once('db.php');
    session_start();

    class Users{

        function __construct() {
            $db =  DB::getInstance();
            $this->db = $db->getConnection();
        }

        private function allowSpecialCharacters($method){
            foreach( $method as $key => $value ) {
                     $method[$key] = strip_tags($this->db->real_escape_string($value));
            }
        }

        private function error(){
            echo json_encode((object) [
                'error'=>true
            ]);
        }

        private  function deleteKid($kidId){
            $sql = "DELETE FROM kids WHERE kidId={$kidId}";
            $result = $this->db->query($sql);
        }
       
        public function createUser(){
            
            $this->allowSpecialCharacters($_POST);
                 
            if(!empty($_POST['kindergartenid']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) &&
            !empty($_POST['parentId']) && !empty($_POST['password']) && !empty($_POST['email']) && 
            !empty($_POST['mobilephone']) && !empty($_POST['familyMember']) && !empty($_POST['anothercontact']) &&
            !empty($_POST['relationship']) && !empty($_POST['mobilephone2']) ){

              

                $values = "'{$_POST['kindergartenid']}','{$_POST['firstname']}','{$_POST['lastname']}',{$_POST['parentId']},'{$_POST['password']}',
                '{$_POST['addressuser']}','{$_POST['city']}','{$_POST['email']}','{$_POST['phone']}','{$_POST['mobilephone']}','{$_POST['familyMember']}',
                '{$_POST['anothercontact']}','{$_POST['relationship']}','{$_POST['mobilephone2']}'";

                $sql = "INSERT INTO users (kindergartenid,firstname,lastname,parentId,password,
                addressuser,city,email,phone,mobilephone,familyMember,anothercontact,relationship,mobilephone2) VALUES ($values)";
            
                $result =$this->db->query($sql);
                if($result){
                    $id = $this->db->insert_id;
                     echo json_encode((object) [
                        'id' => $id,
                         'success'=>true
                    ]);
                }
                else{
                    $this->deleteKid($_POST['kidId']);
                    $this->error();
                }
            } 
            else{
                $this->deleteKid($_POST['kidId']);
                $this->error();
            }
        }

      
        public function getAll(){
            $sql = "SELECT * FROM users";
            $result =$this->db->query($sql); 
            if($result){
               $data= [];
             while($row = mysqli_fetch_array($result)){
                 array_push($data, (object) [
                     'firstname' => $row['firstname'],
                     'familyMember' => $row['familyMember'],
                     'mobilephone' => $row['mobilephone'],
                     'email' => $row['email'],
                     'parentId' => $row['parentId']
                ]);
             }

                echo json_encode((object) [
                    'data' => $data,
                    'success'=>true
                ]);
            }
            else{
                 echo json_encode((object) [
                    'error'=>true
                ]);
             }
        }
    


         public function login(){
            if( isSet($_SESSION['token']) && isSet($_POST['token']) && $_SESSION['token'] == $_POST['token']){
                $this->allowSpecialCharacters($_POST);
                $sql = "SELECT parentId FROM users WHERE parentId='{$_POST['parentId']}' AND password ='{$_POST['password']}'";
                $result = $this->db->query($sql);
                if(mysqli_num_rows($result) > 0 ){
                    $_SESSION['login'] = $_POST['token'];
                    $_SESSION['parentId'] = $_POST['parentId'];
                    setcookie("loginType",'parent',time() + 86400000,"/"); 
                    header("Location: /Sadna/index.php");
                    
                }
                else{
                    header("Location: /Sadna/login_page.php?usertype=parent");
                }
            }
            else{
                header("Location: /Sadna/login_page.php?usertype=parent");
            }
        } 
        
        public function isLogin() {
            if( !empty( $_SESSION['parentId'] )) {
                return true;
            }
            return false;
        }

        public function __destruct(){
            $this->db->close();
       }
       
    }
    
?>

