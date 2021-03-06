<?php

    require_once('db.php');

    class Crew{

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


        public function loginForkindergartenTeacher(){
            if( isSet($_SESSION['token']) && isSet($_POST['token']) && $_SESSION['token'] == $_POST['token']){
                $this->allowSpecialCharacters($_POST);
                $sql = "SELECT kTeacherId, kindergartenid FROM crew WHERE kTeacherId='{$_POST['parentId']}' AND password ='{$_POST['password']}'";
                $result = $this->db->query($sql);
                if(mysqli_num_rows($result) > 0 ){
                    $row = $result->fetch_assoc();
                    $_SESSION['login'] = $_POST['token'];
                    $_SESSION['kTeacherId'] = $_POST['parentId'];
                    $kindergartenid = $row['kindergartenid'];
                    $_SESSION['kindergartenid'] = $kindergartenid;
                                        
                    // get and save the budget in session
                    $sql = "SELECT shoppingbudget FROM kindergarten WHERE kindergartenid=$kindergartenid";
                    $result = $this->db->query( $sql );
                    $row = $result->fetch_assoc();
                    $_SESSION['shoppingbudget'] = $row['shoppingbudget'];
                    //$_SESSION['cart_total'] = 0;
                    //$_SESSION['shopping_history_total'] = 0;
                    $_SESSION['shopping_cart_total'] = 0; // cart + shopping history

                    setcookie("loginType",'crew',time() + 86400000,"/"); 
                    header("Location: /Sadna/index.php");
                    
                }
                else{
                    header("Location: /Sadna/login_page.php?usertype=crew");
                }
            }
            else{
                header("Location: /Sadna/login_page.php?usertype=crew");
            }
        }

        public function isLogin() {
            if( !empty( $_SESSION['kTeacherId'] )) {
                return true;
            }
            return false;
        }


        public function __destruct(){
            $this->db->close();
        }
       
    }
    
?>