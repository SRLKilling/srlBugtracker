<?php
class srlBtEntry {


	function __construct($srlBugtracker) {
		$this->bt = $srlBugtracker;
	}
	
	static function construct($srlBugtracker, $id, $type, $author, $name, $description, $tags, $priority, $priority, $creationTime, $lastUpdateTime, $assignedTo, $realisedPercentage) {
		$entry = new srlBtEntry($srlBugtracker);
		$entry->id = $id;
		$entry->type = $type;
		$entry->author = $author;
		$entry->name = $name;
		$entry->description = $description;
		$entry->tags = $tags;
		$entry->priority = $priority;
		$entry->creationTime = $creationTime;
		$entry->lastUpdateTime = $lastUpdateTime;
		$entry->assignedTo = $assignedTo;
		$entry->realisedPercentage = $realisedPercentage;
		return $entry;
	}
	
	static function constructFromArray($srlBugtracker, $data) {
		if(!is_array($data) || count($data) != 11) return FALSE;
	
		$entry = new srlBtEntry($srlBugtracker);
		$entry->id = $data[0];
		$entry->type = $data[1];
		$entry->author = $data[2];
		$entry->name = $data[3];
		$entry->description = $data[4];
		$entry->tags = $data[5];
		$entry->priority = $data[6];
		$entry->creationTime = $data[7];
		$entry->lastUpdateTime = $data[8];
		$entry->assignedTo = $data[9];
		$entry->realisedPercentage = $data[10];
		return $entry;
	}
	
	static function getWithId($srlBugtracker, $id) {
		$res = mysql_query('SELECT * FROM '.$srlBugtracker->conf->dbPrefix.'Entries WHERE id='.$id);
		if(mysql_num_rows($res) == 0) { $srlBugtracker->utility->badLocationError(); }
		$data = mysql_fetch_row($res);
		return self::constructFromArray($srlBugtracker, $data);
	}
	
	
	
	function assignTo($user) {
		if(is_int($user))
			$user = new srlBtUser($user);
		
		mysql_query('UPDATE '.$this->bt->conf->dbPrefix.'Entries SET assignedTo='.$user->id.', update_time='.time().' WHERE id='.$this->id);
		$this->pushUpdate( $this->getFormattedType()." pris(e) en charge par ".$user->pseudo );
	}
	
	function abandon() {
		mysql_query('UPDATE '.$this->bt->conf->dbPrefix.'Entries SET assignedTo=0 WHERE id='.$this->id);
		$this->pushUpdate( $this->getFormattedType()." abandonné(e)");
	}
	
	
	
	function pushComment($content) {
		mysql_query('UPDATE '.$this->bt->conf->dbPrefix.'Entries SET update_time='.time().' WHERE id='.$this->id);
		mysql_query('INSERT INTO '.$this->bt->conf->dbPrefix.'Comments VALUES( "", '.$this->id.', '.$this->bt->user->id.', '.time().', "'.$this->bt->utility->encodeString($content).'" )');
	}
	
	function pushUpdate($description, $percentage=null) {
		mysql_query('UPDATE '.$this->bt->conf->dbPrefix.'Entries SET update_time='.time().' WHERE id='.$this->id);
		mysql_query('INSERT INTO '.$this->bt->conf->dbPrefix.'Updates VALUES( "", '.$this->id.', '.time().', "'.$this->bt->utility->encodeString($description).'" )');
		
		if($percentage != null){ mysql_query('UPDATE '.$this->bt->conf->dbPrefix.'Entries SET realisedPercentage='.$percentage.' WHERE id='.$this->id); }
	}
	
	
	
	
	function getCommentList() {
		return mysql_query('SELECT * FROM '.$this->bt->conf->dbPrefix.'Comments WHERE entry='.$this->id.' ORDER BY time DESC');
	}
	
	function getUpdateList() {
		return mysql_query('SELECT * FROM '.$this->bt->conf->dbPrefix.'Updates WHERE entry='.$this->id.' ORDER BY time DESC');
	}
	
	function getFormattedType() {
		$types = array("Bug", "Amélioration");
		return $types[$this->type];
	}
	
	function getStatus() {
		if($this->assignedTo == 0) return "Nouveau";
		else if($this->realisedPercentage != 100) return "Assigné et en cours";
		else return "Terminé";
	}
	
	function getFormattedPriority() {
		$priorities = array("Faible", "Normale", "Importante", "Urgente");
		return $priorities[$this->priority];
	}
	
	static function getTextPriority($priority) {
		$priorities = array("Faible", "Normale", "Importante", "Urgente");
		return $priorities[$priority];
	}
	
	function getAuthorObject() {
		if(!isset($this->authorObject)) $this->authorObject = new srlBtUser($this->bt, $this->author);
		return $this->authorObject;
	}
	
	function getAssignedToObject() {
		if(!isset($this->assignedToObject)) $this->assignedToObject = new srlBtUser($this->bt, $this->assignedTo);
		return $this->assignedToObject;
	}
	
}
?>