<?php

if(!isset($srlBugtracker))
	Header("Location: ../index.php");
	
if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])) {
	$srlBugtracker->utility->badLocationError();
}

$entry = srlBtEntry::getWithId($srlBugtracker, $_GET["id"]);

if($srlBugtracker->user->id != $entry->assignedTo) {
	$srlBugtracker->utility->badRightsError();
}


if(isset($_POST['updateSubmited'])) {
	$entry->pushUpdate($_POST['updateDescription'], intval($_POST['updatedPercentage']));
	header("location: ".$srlBugtracker->utility->getLocation("showEntry", $entry->id));
}

include ($srlBugtracker->utility->templateLocation());
?>