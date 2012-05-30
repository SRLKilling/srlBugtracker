<?php

class srlBtUserToUpdate {
	function __construct($baseUser) {
		$this->baseUser = $baseUser;
	}
	function setRight($right, $state) {
		if(!isset($this->rights)) { $this->rights = $this->baseUser->rights; }
		$this->rights = $this->baseUser->bt->utility->setBit($this->rights, $this->baseUser->bt->rightsArray[$right], $state);
	}
	
	function setRightByBit($bit, $state) {
		if(!isset($this->rights)) { $this->rights = $this->baseUser->rights; }
		$this->rights = $this->baseUser->bt->utility->setBit($this->rights, $bit, $state);
	}
	
	function update() {
		$query = 'UPDATE '.$this->baseUser->bt->conf->dbPrefix.'Users SET ';
		
		if(isset($this->rights)) {
			$query .= 'rights='.$this->rights;
			$this->baseUser->rights = $this->rights;
		}
		
		$query .= ' WHERE id='.$this->baseUser->id;
		mysql_query($query);
	}
}

class srlBtUser {

	function __construct($bt, $id=0) {
		$this->bt = $bt;
		$this->conf = $bt->conf;
		$this->updateUserData($id);
		$this->toUpdate = new srlBtUserToUpdate($this);
	}
	
	function isGuest() {
		return $this->id == 0;
	}
	function isAdmin() {
		return $this->rights == 65535;
	}
	
	function hasRight($bit) {
		return ($this->isAdmin() || (($this->rights & $bit) == $bit));
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
	
	function updateLastSeen() {
		mysql_query('UPDATE '.$this->conf->dbPrefix.'Users SET last_seen='.time().' WHERE id='.$this->id);
	}
	
	function update() {
		$this->toUpdate->update();
	}
	
	function can($right) {
		return $this->hasRight($this->bt->rightsArray[$right]);
	}
	
	static function getPseudo($bt, $id) {
		$pseudoRes = mysql_fetch_row(mysql_query("SELECT ".$bt->conf->dbUserPseudo." FROM ".$bt->conf->dbUserDb.".".$bt->conf->dbUserTable." WHERE ".$bt->conf->dbUserId."=".$id));
		return  $pseudoRes[0];
	}
	
};

?>