<?php
class srlBtUtility {

	function __construct($bugtracker) {
		$this->bt = $bugtracker;
	}

	function beautifulDate($date, $uppercase=false) {
		$diff = time() - $date;
		if($diff < 60) {
			$newdate = "il y a ".$diff." secondes";
		}
		else if($diff < 3600) {
			$newdate = "il y a ".floor($diff/60)." minutes";
		}
		else if($diff < 86400) {
			$newdate = "il y a ".floor($diff/3600)." heures";
		}
		else if($diff < 172800) {
			$newdate = "hier à ".date('H:i', $date);
		}
		else {
			$newdate = "le ".date('d/m/Y à H:i', $date);
		}
		
		return ($uppercase) ? ucfirst($newdate) : $newdate;
	}
	
	function getLocation($page, $id=0) {
		return "index.php?p=".$page. ($id!=0 ? "&id=".$id : "");
		// return ($id!=0 ? $id."/" : "").$page.".html";
	}
	
	function templateLocation() {
		return "templates/".$this->bt->page.".php";
	}
	
	function encodeString($str) {
		return mysql_real_escape_string(htmlspecialchars($str));
	}
	
	function decodeString($str) {
		return nl2br($str);
	}
	
	function badLocationError() {
		exit("La page demandée n'existe pas");
	}
	
	function badRightsError() {
		exit("Vous n'avez pas les droits requis");
	}
	
}
?>