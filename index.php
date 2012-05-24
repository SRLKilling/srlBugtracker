<?php
//********************************************************************************/
// [FrameWork] srlBugtracker.
//********************************************************************************/

include("Classes/srlBugtracker.class.php");
$srlBugtracker = new srlBugtracker();

if(isset($_POST["userConnectionSubmited"]) && isset($_POST["userPseudo"]) && isset($_POST["userPassword"])) {
	$srlBugtracker->connect($_POST["userPseudo"], $_POST["userPassword"]);
}
else if(isset($_POST["userDeconnectionSubmited"])) {
	$srlBugtracker->deconnect();
}
if(isset($_SESSION["message"])) {
	echo $_SESSION["message"] == 0 ? "lol" : "0";
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>srlBugtracker</title>
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="Themes/designGris.css" />
		<script src="bugtracker.js"></script>
	</head>
	<body>
		<nav id="MainNaviguationBar">
			<ul>
				<li><a href="index.php">Accueil</a></li>
				
				<li><a href="index.php?p=addEntry">Ajouter une entrée</a></li>
				
			<?php if($srlBugtracker->user->isGuest()) { ?>
				<li><a href="index.php?p=inscription">S'inscrire</a></li>
			<?php } else { ?>
				<li><form action="" method="post"><input type="submit" name="userDeconnectionSubmited" value="Se deconnecter"/></form></li>
			<?php } ?>
				
			</ul>
		</nav>

		<header>
			<h1><?php echo $srlBugtracker->conf->projectName; ?></h1>
			<h2><?php echo $srlBugtracker->pages[$srlBugtracker->page]; ?></h1>
		</header>

		<section id="Body">
			<?php if($srlBugtracker->user->isGuest()) { ?>
			<nav id="RightNaviguation">
			
				<form method="post" id="connection" action="">
				<h2>Connexion</h2>
					<label for="userPseudo">Pseudo : </label>				<input type="text" name="userPseudo" id="userPseudo" tabindex="10" /><br />
					<label for="userPassword">Mot de passe : </label>		<input type="password" name="userPassword" id="userPassword" tabindex="20"/><br />
					<input type="submit" name="userConnectionSubmited" value="Connexion"/>
				</form>
					
			</nav>
			<?php } ?>
			
			<section id="MainContent" <?php if($srlBugtracker->user->isGuest()) echo 'class="withConnectionPanel"'; ?>>
				<?php if($srlBugtracker->includeError == 2) { ?>
					
					La page demandée n'existe pas.
					
				<?php } elseif($srlBugtracker->includeError == 1) { ?>
				
					Vous n'avez pas les droits requis.
				
				<?php } else { include("controllers/".$srlBugtracker->page.".php"); } ?>
				
			</section>

			
		</section>
	</body>
</html>
