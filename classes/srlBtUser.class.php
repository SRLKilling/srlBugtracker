<?php
class srlBtUserToUpdate {
	function __construct($baseUser) {
		$this->baseUser = $baseUser;
	}
	function setRight($right, $state) {
		if(!isset($this->rights)) $this->rights = $this-baseUser->rigths;
		if($state) {
			$this->right = $this->right | $right;
		} else if(($this->right & $right) == $right) {
			$this->right = $this->right ^ $right
		} else {
			$this->right = ~($this->right ^ ~$right);
		}
	}
}

class srlBtUser {

	function __construct($bt, $id=0) {
		$this->bt = $bt;
		$this->conf = $bt->conf;
		$this->updateUserData($id);
		$this->update = new srlBtUserToUpdate($this);
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
	
	function updateLastAction() {
		mysql_query('UPDATE '.$this->conf->dbPrefix.'Users SET last_seen='.time().' WHERE id='.$this->id);
	}
	
	function can($right) {
		return $this->hasRight($this->bt->rigthsArray[$right]);
	}
	
	static function getPseudo($bt, $id) {
		$pseudoRes = mysql_fetch_row(mysql_query("SELECT ".$bt->conf->dbUserPseudo." FROM ".$bt->conf->dbUserDb.".".$bt->conf->dbUserTable." WHERE ".$bt->conf->dbUserId."=".$id));
		return  $pseudoRes[0];
	}
	
};

?>