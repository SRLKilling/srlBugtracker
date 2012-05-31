<?php include('installer.func.php'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>srlBugtracker - Installation</title>
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="installation.css" />
		<script type="text/javascript">
			function switchIntegration() {
				var enabled = document.getElementById("integrationEnabled").checked;
				document.getElementById("userPassword").disabled = enabled;
				document.getElementById("integrationUserDb").disabled = !enabled;
				document.getElementById("integrationUserTable").disabled = !enabled;
				document.getElementById("integrationUserId").disabled = !enabled;
				document.getElementById("integrationUserPseudo").disabled = !enabled;
				document.getElementById("integrationUserPassword").disabled = !enabled;
			}
		</script>
	</head>
	<body>
		
		<section id="maincontent"> <form method="post" action="">
		
			<header>
				<h1>srlBugtracker - Installation</h1>
			</header>
			
			<fieldset>
				<header>
					<h2><legend>Informations globales</legend></h2>
					<p>Le pseudonyme administrateur correspond au pseudonyme du superutilisateur (qui a tout les droits, vraiment tout) qui sera automatiquement ajouté à la base de donnée, ou d'un pseudonyme déjà existant dans la table donnée si l'intégration est activée.</p>
				</header>
					<div>
						<label for="projectName">Nom du projet&nbsp;:</label>
						<input type="text" name="projectName" id="projectName" value="<?php echo postVal('projectName')?>" <?php emptyMessageOrPlaceHolder('projectName', "Exemple: srlBugtracker"); ?> required="required"/>
					</div>
					<div>
						<label for="userName">Pseudonyme administrateur&nbsp;:</label>
						<input type="text" name="userName" id="userName" value="<?php echo postVal('userName')?>" <?php emptyMessageOrPlaceHolder('userName', "Exemple: root"); ?> required="required"/>
					</div>
					<div>
						<label for="userPassword">Mot de passe&nbsp;:</label>
						<input type="password" name="userPassword" id="userPassword" <?php if($integration) echo 'disabled=""'; ?> <?php emptyMessageOrPlaceHolder('userPassword'); ?> required="required"/>
					</div>
					<div>
						<label for="userEmail">Adresse email (adresse publique, optionelle)&nbsp;:</label>
						<input type="email" name="userEmail" id="userEmail" value="<?php echo postVal('userEmail')?>" placeholder="Exemple: contact@domain.tld"/>
					</div>
					
					<?php if(file_get_contents("http://127.0.0.1/".substr($_SERVER['PHP_SELF'], 0, strlen($_SERVER['PHP_SELF'])-9)."/urlrewriting.txt") == "enabled") { ?>
					<div>
						<label for="userEmail">Type d'url rewriting&nbsp;:</label>
						<select id="urlRewritingType" name="urlRewritingType">
							<option value="0">Pas d'url rewriting</option>
							<option value="1">Type : /id/page.html</option>
							<option value="2" selected="">Type : page-id.html</option>
						</select>
					</div>
					<?php } ?>
					
			</fieldset>
			
			<fieldset>
				<header>
					<h2><legend>Droits visiteurs</legend></h2>
					<p>Veuillez selectionner ci-dessous les actions que les visiteurs (= non-connectés) auront le droit de faire.</p>
					<div>
						<label for="guestShowEntryList">Voir la liste d'entrées</label>
						<input type="checkbox" name="guestShowEntryList" id="guestShowEntryList" <?php if($integration) echo 'checked=""';?>/>
					</div>
					<div>
						<label for="guestShowEntry">Voir le détail d'une entrée</label>
						<input type="checkbox" name="guestShowEntry" id="guestShowEntry" <?php if($integration) echo 'checked=""'; ?>/>
					</div>
					<div>
						<label for="guestShowUser">Voir la fiche d'un membre inscrit</label>
						<input type="checkbox" name="guestShowUser" id="guestShowUser" <?php if($integration) echo 'checked=""'; ?>/>
					</div>
					<div>
						<label for="guestAddEntry">Ajouter une entrée</label>
						<input type="checkbox" name="guestAddEntry" id="guestAddEntry" <?php if($integration) echo 'checked=""'; ?>/>
					</div>
				</header>
			</fieldset>
			
			<fieldset>
				<header>
					<h2><legend>Base de donnée</legend></h2>
					<p>Pour fonctionner, srlBugtracker a besoin d'un accès à votre base de données. Les identifiants resteront confidentiels et cachés. </p>
				</header>
					<div>
						<label for="bddServer">Serveur&nbsp;:</label>
						<input type="text" name="bddServer" id="bddServer" value="<?php echo postVal('bddServer')?>" <?php emptyMessageOrPlaceHolder('bddServer', "Exemple: localhost"); ?> required="required"/>
					</div>
					<div>
						<label for="bddUser">Utilisateur&nbsp;:</label>
						<input type="text" name="bddUser" id="bddUser" value="<?php echo postVal('bddUser')?>" <?php emptyMessageOrPlaceHolder('bddUser', "Exemple: root"); ?> required="required"/>
					</div>
					<div>
						<label for="bddPassword">Mot de passe&nbsp;:</label>
						<input type="password" name="bddPassword" id="bddPassword"/>
					</div>
					
					<div>
						<label for="bddName">Base de données&nbsp;:</label>
						<input type="text" name="bddName" id="bddName" value="<?php echo postVal('bddName')?>" <?php emptyMessageOrPlaceHolder('bddName', "Exemple: bugtracker"); ?> required="required"/>
					</div>
					<div>
						<label for="bddPrefix">Préfixe (sera placé devant le nom des tables)&nbsp;:</label>
						<input type="text" name="bddPrefix" id="bddPrefix" value="<?php echo postVal('bddPrefix', "srlBt_") ?>" placeholder="srlBt_"/>
					</div>
			</fieldset>
			
			<fieldset>
					<header>
						<h2><legend>Intégration</legend></h2>
						<p>Pour fonctionner, srlBugtracker a besoin d'un accès à votre base de données. Les identifiants resteront confidentiels et cachés. </p>
					</header>
					
						<div>
							<label for="sessionId">Clef de la session stockant l'identifiant de l'utilisateur connecté&nbsp;:</label>
							<input type="text" name="sessionId" id="sessionId" value="<?php echo postVal('sessionId')?>" <?php emptyMessageOrPlaceHolder('sessionId', "Exemple: id pour \$_SESSION['id']"); ?> required="required"/><br />
						</div>
						<div>
							<label for="integrationEnabled">Intégration SQL activée</label>
							<input type="checkbox" name="integrationEnabled" id="integrationEnabled" onclick="switchIntegration()" <?php if($integration) echo 'checked=""'; ?>/>
						</div>
						<div>
							<label for="integrationUserDb">Base de donnée contenant la table utilisateur&nbsp;:</label>
							<input type="text" name="integrationUserDb" id="integrationUserDb" value="<?php echo postVal('integrationUserDb')?>" <?php if(!$integration) echo 'disabled=""'; ?> <?php emptyMessageOrPlaceHolder('integrationUserDb', "Database"); ?> required="required"/>
						</div>
						<div>
							<label for="integrationUserTable">Nom de la table utilisateur&nbsp;:</label>
							<input type="text" name="integrationUserTable" id="integrationUserTable" value="<?php echo postVal('integrationUserTable')?>" <?php if(!$integration) echo 'disabled=""'; ?> <?php emptyMessageOrPlaceHolder('integrationUserTable', "Table utilisateurs"); ?> required="required"/>
						</div>
						<div>
							<label for="integrationUserId">Nom du champ contenant les IDs unique&nbsp;:</label>
							<input type="text" name="integrationUserId" id="integrationUserId" value="<?php echo postVal('integrationUserId')?>" <?php if(!$integration) echo 'disabled=""'; ?> <?php emptyMessageOrPlaceHolder('integrationUserId', "id"); ?> required="required"/>
						</div>
						<div>
							<label for="integrationUserPseudo">Nom du champ contenant les pseudonymes&nbsp;:</label>
							<input type="text" name="integrationUserPseudo" id="integrationUserPseudo" value="<?php echo postVal('integrationUserPseudo')?>" <?php if(!$integration) echo 'disabled=""'; ?> <?php emptyMessageOrPlaceHolder('integrationUserPseudo', "pseudo"); ?> required="required"/>
						</div>
						<div>
							<label for="integrationUserPassword">Nom du champ contenant les mots de passe&nbsp;:</label>
							<input type="text" name="integrationUserPassword" id="integrationUserPassword" value="<?php echo postVal('integrationUserPassword')?>" <?php if(!$integration) echo 'disabled=""'; ?> <?php emptyMessageOrPlaceHolder('integrationUserPassword', "password"); ?> required="required"/>
						</div>
			</fieldset>
			
			<footer>
				<input type="submit" name="submitButton" id="submitButton" value="Terminer l'installation"/>
			</footer>
			
		</form></section>

	</body>
</html>
