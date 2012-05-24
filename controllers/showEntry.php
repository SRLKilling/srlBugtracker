<?php

if(!isset($srlBugtracker))
	Header("Location: ../index.php");

if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])) {
	$srlBugtracker->utility->badLocationError();
}

$entry = srlBtEntry::getWithId($srlBugtracker, $_GET["id"]);

if( $srlBugtracker->can("addComment") && isset($_POST['addCommentSubmited']) && isset($_POST['commentContent'])) {
	$entry->pushComment($_POST['commentContent']);
}

include ($srlBugtracker->utility->templateLocation());
?>