<?php

if(!isset($srlBugtracker))
	Header("Location: ../index.php");
	
	
$entryList = new srlBtEntryList($srlBugtracker);
include ($srlBugtracker->utility->templateLocation());
?>