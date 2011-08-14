<?php

//All the classes in the networks folder must inherit this base class
abstract class Network{
	
	/**
	parameters are unix timestamp dates
	**/
	protected $username = "";
	protected $password = "";
	
	function __construct($username, $password){
			$this->username = $username;
			$this->password = $password;
	}
	
	protected function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}
	public function setUsername($username){
		$this->username = $username;		
	}
	public function setPassword($password){
		$this->password = $password;		
	}
	public function getUsername($username){
		return $username;		
	}
	public function getPassword($password){
		return $password;		
	}
	
	
	public function getEarnings($startDate, $stopDate){
		
	}
	

}

?>