<?php

class Student
{
	public function __construct()
	{
		
	}
	
	// *****************************************************

	public function getID()
	{
		return $this->id;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getCode()
	{
		return $this->code;
	}
	
	public function getFirstName()
	{
		return $this->firstname;
	}
	
	public function getSurName()
	{
		return $this->surname;
	}
	
	// *****************************************************
	
	public function setID($id)
	{
		$this->id = $id;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setCode($code)
	{
		$this->code = $code;
	}
	
	public function setFirstName($firstname)
	{
		$this->firstname = $firstname;
	}
	
	public function setSurName($surname)
	{
		$this->surname = $surname;
	}
	
	// *****************************************************
	
	private $id;
	private $email;
	private $code;
	private $firstname;
	private $surname;
	 
}

?>
