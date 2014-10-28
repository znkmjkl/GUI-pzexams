<?php

class Exam
{
	public function __construct()
	{
		$this->emailsPosted = false;
	}
	
	// *****************************************************

	public function getID()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getDuration ()
	{
		return $this->duration;
	}
    
	public function getUserID ()
	{
		return $this->userid;
	}
	
	public function getActivated()
	{
		return $this->activated;
	}
	
	public function getEmailsPosted()
	{
		return $this->emailsPosted;
	}
	
	// *****************************************************
	
	public function setID($id)
	{
		$this->id = $id;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}
	
	public function setDuration($durat)
	{
		$this->duration = $durat;
	}

	public function setUserID($userid)
	{
		return $this->userid = $userid ;
	}
	
	public function setActivated($activate)
	{
		return $this->activated = $activate;
	}
	
	public function setEmailsPosted($emailsPosted)
	{
		return $this->emailsPosted = $emailsPosted;
	}
	
	// *****************************************************
	
	private $id;
	private $name; 
	private $duration;
	private $userid;
	private $activated;
	private $emailsPosted; 
}

class ExamListElement
{
	public function __construct($exam, $examDates)
	{
		$this->exam = $exam;
		$this->examDates = $examDates;
	}
		
	public function getExam()
	{
		return $this->exam;
	}
		
	public function getExamDates()
	{
		return $this->examDates;
	}
		
	public function setExam($exam)
	{
		$this->exam = $exam;
	}
		
	public function setStartDate($examDates)
	{
		$this->examDates = $examDates;
	}
	
	public static function sortByStartDate(&$examList)
	{
		usort($examList, function($a, $b) {
			$startDateA_ = $a->getExamDates();
			$startDateB_ = $b->getExamDates();
			$startDateA  = $startDateA_[0];
			$startDateB  = $startDateB_[0];
			$nameA       = $a->getExam()->getName();
			$nameB       = $b->getExam()->getName();
			
			if ($startDateA == null && $startDateB == null) {
				return $nameA < $nameB ? -1 : 1;
			} else if ($startDateA == null && $startDateB != null) {
				return 1;
			} else if ($startDateA != null && $startDateB == null) {
				return -1;
			} else {
				return $startDateA < $startDateB ? -1 : 1;
			}
		});
	}
	
	private $exam;
	private $examDates;
}

?>
