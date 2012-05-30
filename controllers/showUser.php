<?php

if(!isset($srlBugtracker))
	Header("Location: ../index.php");

if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])) {
	$srlBugtracker->utility->badLocationError();
}

$showUserController = true;
$user = new srlBtUser($srlBugtracker, $_GET["id"]);

include ("controllers/editUserRights.php");
include ($srlBugtracker->utility->templateLocation());
?>