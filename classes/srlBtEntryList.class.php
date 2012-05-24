<?php
class srlBtEntryList {
	
	function __construct($bt) {
		$this->bt = $bt;
		$this->priorityClasses = array("low", "normal", "high", "urgent");
		$this->res = mysql_query('SELECT * FROM '.$this->bt->conf->dbPrefix.'Entries ORDER BY update_time DESC');
	}
	
	function getNextEntry() {
		return srlBtEntry::constructFromArray( $this->bt, mysql_fetch_row($this->res) );
	}
	
	function getPriorityClass($priority) {
		if(!is_int($priority)) $priority = intval($priority);
		return $this->priorityClasses[$priority];
	}
	
}
?>