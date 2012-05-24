<?php

if(!isset($srlBugtracker))
	Header("Location: ../index.php");

if(isset($_POST["addEntrySubmited"])) {
	
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
	$entryAuthor = $srlBugtracker->user->id;
	$entryDescription = $srlBugtracker->utility->encodeString($_POST['entryDescription']);
	$entryTags = $_POST["entryTags"];
	$time = time();
	
	mysql_query('INSERT INTO '.$srlBugtracker->conf->dbPrefix."Entries VALUES('', $entryType, $entryAuthor, \"$entryName\", \"$entryDescription\", \"$entryTags\", $entryPriority, $time, $time, 0 , 0)") or die(mysql_error());
	
	header("location: ".$srlBugtracker->utility->getLocation("showEntry", mysql_insert_id()));	
}


include ($srlBugtracker->utility->templateLocation());
?>