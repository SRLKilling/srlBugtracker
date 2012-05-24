<?php
class srlBtUser {

	function __construct($bt, $id=0) {
		$this->bt = $bt;
		$this->conf = $bt->conf;
		$this->updateUserData($id);
	}
	
	function isGuest() {
		return $this->id == 0;
	}
	function isAdmin() {
		return $this->rights == 65535;
	}
	
	function hasRight($bit) {
		return ($this->rights & $bit) == $bit;
	}
	
	function updateUserData($id) {
		if($id != 0) {
			$userQuery = mysql_query("SELECT rights, time, last_seen FROM ".$this->conf->dbPrefix."Users WHERE id=".$id);
			$userData = mysql_fetch_row($userQuery);
			
			$this->id = $id;
			$this->pseudo = self::getPseudo($this->bt, $this->id);
			$this->rights = $userData[0];
			$this->inscription = $userData[1];
			$this->lastAction = $userData[2];
		}
		else {
			$this->id = 0;
			$this->pseudo = "Visiteur";
			$this->rights = $this->conf->guestRights;
		}
	}
	
	function updateLastAction() {
		mysql_query('UPDATE '.$this->conf->dbPrefix.'Users SET last_seen='.time().' WHERE id='.$this->id);
	}
	
	static function getPseudo($bt, $id) {
		$pseudoRes = mysql_fetch_row(mysql_query("SELECT ".$bt->conf->dbUserPseudo." FROM ".$bt->conf->dbUserDb.".".$bt->conf->dbUserTable." WHERE ".$bt->conf->dbUserId."=".$id));
		return  $pseudoRes[0];
	}
	
};

?>