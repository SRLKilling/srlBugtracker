<?php session_start();


// Instanciation de la classe noyau
include("Classes/srlBugger.class.php");
$srlBugger = new srlBugger("config.ini");
	
// Fonctions utiles
include("Classes/srlBuggerUtilities.class.php");
$srlUtility = new srlBuggerUtilities;

// Connexion
if(!empty($_POST["submit_connexion"]) && !$srlBugger->isAnyoneConnected() ) {
	if(empty($_POST["pseudo"]) || empty($_POST["mdp"]))
		echo '<script> alert("Veuillez remplir tous les champs"); </script>';
	else {
		if($srlBugger->conf->Integration->Mode == "API") {
			$srlBugger->API->Connect($_POST['pseudo'], $_POST['mdp']);
			Header("Location: index.php");
		}
		else {
			if($srlBugger->conf->Integration->Mode == "SQL") {
				$table_users = $srlBugger->conf->Integration->UserTable;
				$pseudo_users = $srlBugger->conf->Integration->UserPseudo;
				$password_users = $srlBugger->conf->Integration->UserPassword;
				$id_users = $srlBugger->conf->Integration->UserId;
			} else {
				$table_users = $srlBugger->conf->Sql->Prefixe."Users_Ext";
				$pseudo_users = "pseudo";
				$password_users = "password";
				$id_users = "id";
			}	
			$donnees = mysql_fetch_assoc(mysql_query("SELECT $id_users, $password_users, $pseudo_users FROM $table_users WHERE $pseudo_users='". $_POST['pseudo']. "'")) or die (mysql_error());
			$mdp = md5($_POST['mdp']);
			if(!count($donnees))
				echo '<script> alert("Pseudo et mdp incorrects"); </script>';	
			elseif($donnees[$password_users] != $mdp)
				echo '<script> alert("Mot de passe incorect"); </script>'; 
			else {
				$srlBugger->Connect($donnees[$id_users], $donnees[$pseudo_users]);
				Header("Location: index.php");
			}
		}
	}
}

// Déconnexion
if(isset($_GET['deconnectMe'])) {
	if($conf->Integration->Mode == "API")
		$srlBugger->API->Deconnect();
	else
		$srlBugger->Deconnect();
		
	Header("Location: index.php");
}

?>