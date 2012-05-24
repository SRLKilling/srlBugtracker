<?php

if(!isset($srlBugtracker))
	Header("Location: ../index.php");
	
if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])) {
	$srlBugtracker->utility->badLocationError();
}


$entry = srlBtEntry::getWithId($srlBugtracker, $_GET["id"]);

if($entry->assignedTo == 0) {
	$entry->assignTo($srlBugtracker->user);
}
else {
	$entry->abandon();
}

header("location: ".$srlBugtracker->utility->getLocation("showEntry", $entry->id));
?>