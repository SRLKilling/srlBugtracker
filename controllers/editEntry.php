<?php

if(!isset($srlBugtracker))
	Header("Location: ../index.php");

if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])) {
	$srlBugtracker->utility->badLocationError();
}

$entry = srlBtEntry::getWithId($srlBugtracker, $_GET["id"]);

if($srlBugtracker->user->id != $entry->assignedTo && !($entry->author == $srlBugtracker->user->id && $entry->realisedPercentage == 0 && $entry->assignedTo == 0)) {
	$srlBugtracker->utility->badRightsError();
}

if(isset($_POST["editEntrySubmited"])) {
	
	switch($_POST['entryType']) {
		case  "0": $entryType = 0; break;
		case  "1": $entryType = 1; break;
		default: $entryType = 0; break;
	}
	switch($_POST['entryPriority']) {
		case  "0": $entryPriority = 0; break;
		case  "1": $entryPriority = 1; break;
		case  "2": $entryPriority = 2; break;
		case  "3": $entryPriority = 3; break;
		default: $entryPriority = 1; break;
	}
	
	$entryName = $srlBugtracker->utility->encodeString($_POST['entryName']);
	$entryDescription = $srlBugtracker->utility->encodeString($_POST['entryDescription']);
	$entryTags = $_POST["entryTags"];
	
	$query = 'UPDATE '.$srlBugtracker->conf->dbPrefix.'Entries SET ';
	if($entry->type != $entryType)
		$query .= 'type='.$entryType.', ';
	if($entry->name != $entryName)
		$query .= 'nom="'.$entryName.'", ';
	if($entry->description != $entryDescription)
		$query .= 'description="'.$entryDescription.'", ';
	if($entry->tags != $entryTags)
		$query .= 'tags="'.$entryTags.'", ';
	if($entry->priority != $entryPriority) {
		$query .= 'priorite='.$entryPriority.', ';
		$entry->pushUpdate('Priorité passée de '.$entry->getFormattedPriority().' à '.srlBtEntry::getTextPriority($entryPriority));
	}
	$query.= 'lastMajTime='.time().' WHERE id='.$entry->id;
	
	mysql_query($query) or die(mysql_error());
	header("location: ".$srlBugtracker->utility->getLocation("showEntry", $entry->id));	
}


include ($srlBugtracker->utility->templateLocation());
?>
