<?php

class ExamUnit
{
	public function __construct()
	{
		
	}
	
	// *****************************************************

	public function getID()
	{
		return $this->id;
	}
    
	public function getExamID ()
	{
		return $this->examid;
	}

	public function getDay()
	{
		return $this->day;
	}
	
	public function getTimeFrom()
	{
		return $this->timefrom;
	}
	
	public function getTimeTo()
	{
		return $this->timeto;
	}
	
	public function getState()
	{
		return $this->state;
	}

	// *****************************************************
	
	public function setID($id)
	{
		$this->id = $id;
	}
    
	public function setExamID($examid)
	{
		return $this->examid = $examid ;
	}
	
	public function setDay($day)
	{
		return $this->day = $day;
	}
	
	public function setTimeFrom($timefrom)
	{
		$this->timefrom = $timefrom;
	}
	
	public function setTimeTo($timeto)
	{
		$this->timeto = $timeto;
	}

	public function setState($state)
	{
		$this->state = $state;
	}
    
	// *****************************************************

	private $id;
	private $examid; 
	private $day;
	private $timefrom;
	private $timeto;
	private $state;
}

?>
