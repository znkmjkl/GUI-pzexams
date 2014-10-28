<?php

class Record
{
	public function __construct()
	{
		
	}
	
	// *****************************************************

	public function getID()
	{
		return $this->id;
	}
	
	public function getStudentID()
	{
		return $this->studentID;
	}
	
	public function getExamID()
	{
		return $this->examID;
	}
	
	public function getExamUnitID()
	{
		return $this->examUnitID;
	}

	public function getIsSent()
	{
		return $this->isSent;
	}
	
	// *****************************************************
	
	public function setID($id)
	{
		$this->id = $id;
	}
	
	public function setStudentID($studentID)
	{
		$this->studentID = $studentID;
	}

	public function setExamID($examID)
	{
		$this->examID = $examID;
	}
	
	public function setExamUnitID($examUnitID)
	{
		$this->examUnitID = $examUnitID;
	}

	public function setIsSent($isSent)
	{
		$this->isSent = $isSent;
	}
	
	
	// *****************************************************
	
	private $id;
	private $studentID;
	private $examID;
	private $examUnitID;
	private $isSent;
}

?>
