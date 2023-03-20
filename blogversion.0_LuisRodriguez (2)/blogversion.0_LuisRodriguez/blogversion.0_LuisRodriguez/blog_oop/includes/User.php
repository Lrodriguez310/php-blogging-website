<?php

class User{
	private $id;
	
	private $username;
	
	private $password;
	
	public static function auth($username, $password){
		global $dbc;
		$sql = "SELECT * FROM `logins` WHERE username = ;username LIMIT 1;";
		$bindVal = ['username' => $username];
		$userRecord = $dbc->fetchArray($sql, $bindVal);
		
	if($userRecord) {
		$userRecord = array_shift($userRecord);
		if(password_verify($password, $userRecord['password'])) {
			return new self($userRecord['id'], $userRecord['username'],
							$userRecord['password']);
	                }
	       }
		   return false;
	
    
     }
	 
	 public function getId() {
		 return $this->id;
	 }
	 
	 public function setID($id) {
		 $this->id = $id;
		 
		 return $this;
	 }
}