<?php

class Session{
	
	
	
	private $user;
    public function __construct(){
        session_start();
        if(isset($_SESSION['user'])){
            $this->user = $_SESSION['user'];
        }
    }
    public function isLoggedIn(){
        if($this->user){
            return $this->user;
        }else{
            return false;
        }
    }
    public function getUser(){
        return $this->user;
    }
    public function login($userObj){
        $this->user = $userObj;
        $_SESSION['user'] = $userObj;
    }
    public function logout(){
        $_SESSION=[];
        session_destroy();
    }
}
$session = new Session();
    


?>