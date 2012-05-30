<?php

if(!isset($showUserController))
	Header("Location: ../index.php");
	
if($srlBugtracker->can("editUserRights") && isset($_POST['editRightsSubmited'])) {
	$user->update->setRights(
}
	
?>