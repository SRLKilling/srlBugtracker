<?php

if(!isset($showUserController))
	Header("Location: ../index.php");
	
if($srlBugtracker->can("editUserRights") && isset($_POST['editRightsSubmited'])) {
	$user->toUpdate->setRight("showEntryList",	isset($_POST["rightsEntryList"]));
	$user->toUpdate->setRight("addEntry",		isset($_POST["rightsAddEntry"]));
	$user->toUpdate->setRight("showEntry",		isset($_POST["rightsShowEntry"]));
	$user->toUpdate->setRight("assignEntry",	isset($_POST["rightsAssignEntry"]));
	$user->toUpdate->setRight("updateEntry",	isset($_POST["rightsUpdateEntry"]));
	$user->toUpdate->setRight("editEntry",		isset($_POST["rightsEditEntry"]));
	$user->toUpdate->setRight("showUser",		isset($_POST["rightsShowUser"]));
	$user->toUpdate->setRight("addComment",		isset($_POST["rightsAddComment"]));
	$user->toUpdate->setRight("editUserRights",	isset($_POST["rightsEditUserRights"]));
	$user->update();
}
	
?>