<?php
include("baseConfig.php");
include("srlBtUser.class.php");
include("srlBtUtility.class.php");
include("srlBtEntry.class.php");
include("srlBtEntryList.class.php");

class srlBugtracker {

	function __construct() {
		global $srlConfig;
		$this->conf = $srlConfig;
		$this->utility = new srlBtUtility($this);
		$this->user = new srlBtUser($this, isset($_SESSION[$this->conf->sessId]) ? $_SESSION[$this->conf->sessId] : 0);
		$this->user->updateLastSeen();
		
		$this->rigthsArray = array(
			"showEntryList" 		=> 0b000000001,
			"addEntry"				=> 0b000000010,
			"showEntry" 			=> 0b000000100,
			"assignEntry" 			=> 0b000001000,
			"updateEntry" 			=> 0b000010000,
			"editEntry"				=> 0b000100000,
			"showUser"				=> 0b001000000,
			"addComment"			=> 0b010000000,
			"editUserRights"		=> 0b10000000
		);
		
		$this->pages = array(
			"showEntryList" 		=> "Accueil",
			"addEntry"				=> "Entrée",
			"showEntry" 			=> "Entrée",
			"assignEntry" 			=> "Entrée",
			"updateEntry" 			=> "Entrée",
			"editEntry"				=> "Entrée",
			"showUser"				=> "Utilisateur"
		);
		
		if(!isset($_GET["p"])) $_GET["p"] = "showEntryList";
		$this->page = $_GET["p"];
		
		if(!array_key_exists($this->page, $this->pages)) {
			$this->includeError = 2;
		} elseif( !$this->can($this->page) ) {
			$this->includeError = 1;
		} else {
			$this->includeError = 0;
		}
	}
	
	// Return true if the user has right to do $right, false otherwise
	function can($right) {
		return $this->user->hasRight($this->rigthsArray[$right]);
	}
	
	// Try to connect the user with a given pseudo and password.
	function connect($pseudo, $password) {
		$hashedPassword = md5($password);
		$query = mysql_query('SELECT '.$this->conf->dbUserId.' FROM '.$this->conf->dbUserDb.'.'.$this->conf->dbUserTable.' WHERE '.$this->conf->dbUserPseudo.'="'.$pseudo.'" AND '.$this->conf->dbUserPassword.'="'.$hashedPassword.'"');
		$data = mysql_fetch_row($query);
		
		if($data === false) return false;
		$_SESSION[$this->conf->sessId] = $data[0];
		header("location: index.php?p=".$this->page);
	}
	
	// Deconnect the user by unseting the ID session
	function deconnect() {
		unset($_SESSION[$this->conf->sessId]);
		header("location: index.php?p=".$this->page);
	}
	
}
?>