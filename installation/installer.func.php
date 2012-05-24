<?php
session_start();

function postVal($postId, $defaultVal="") {
	if(isset($_POST[$postId])) {
		return $_POST[$postId];
	} else {
		return $defaultVal;
	}
}

function emptyPost($postId) {
	return isset($_POST[$postId]) && empty($_POST[$postId]);
}

function emptyMessageOrPlaceHolder($post, $placeholder=null) {
	if(isset($_POST[$post]) && empty($_POST[$post])) {
		echo 'class="empty" placeholder="Vous devez remplir ce champ"';
	} elseif($placeholder != null) {
		echo 'placeholder="'.$placeholder.'"';
	}
}

if(isset($_POST['integrationEnabled']) && !empty($_POST['integrationEnabled'])) $integration = true;
else $integration = false;

if(isset($_POST['submitButton']) &&
		(isset($_POST['bddServer']) && !empty($_POST['bddServer'])	) &&
		(isset($_POST['bddUser']) 	&& !empty($_POST['bddUser'])	) &&
		(isset($_POST['bddName'])	&& !empty($_POST['bddName'])	) &&
		(isset($_POST['userName']) 	&& !empty($_POST['userName'])	) &&
		(( $integration && (isset($_POST['integrationUserDb'])			&& !empty($_POST['integrationUserDb'])		) &&
						   (isset($_POST['integrationUserTable'])		&& !empty($_POST['integrationUserTable'])	) &&
						   (isset($_POST['integrationUserId'])			&& !empty($_POST['integrationUserId'])		) &&
						   (isset($_POST['integrationUserPseudo'])		&& !empty($_POST['integrationUserPseudo'])	) &&
						   (isset($_POST['integrationUserPassword'])	&& !empty($_POST['integrationUserPassword']) )) ||
		 (!$integration && (isset($_POST['userPassword']) 				&& !empty($_POST['userPassword']))) )
  ) {
	
		$guestRights = ((isset($_POST['guestShowEntryList']) && !empty($_POST['guestShowEntryList'])) ? 0b00000001 : 0) |
					   ((isset($_POST['guestShowEntry']) && !empty($_POST['guestShowEntry'])) ? 0b00000100 : 0)  |
					   ((isset($_POST['guestShowUser']) && !empty($_POST['guestShowUser'])) ? 0b01000000 : 0) |
					   ((isset($_POST['guestAddEntry']) && !empty($_POST['guestAddEntry'])) ? 0b00000010 : 0);
		
		if($integration) { $userDb=$_POST['integrationUserDb'];	$userTable=$_POST['integrationUserTable']; 				$userId=$_POST['integrationUserId'];	$userPseudo=$_POST['integrationUserPseudo'];	$userPassword=$_POST['integrationUserPseudo'];}
		else { 			   $userDb=$_POST['bddName']; 			$userTable=$_POST['bddPrefix']."Users_PseudoAndPass"; 	$userId="id";							$userPseudo="pseudo";							$userPassword="password";}
		
		$dbFileContent =
"<?php
session_start();
	
class srlConfig {
	function __construct() {
	
		\$this->projectName = '".$_POST['projectName']."';
		\$this->sessId = '".$_POST['sessionId']."';
		\$this->guestRights = ".$guestRights.";
		
		\$this->dbServer       = '".$_POST['bddServer']."';
		\$this->dbUser         = '".$_POST['bddUser']."';
		\$this->dbPassword     = '".$_POST['bddPassword']."';
		\$this->dbBDD          = '".$_POST['bddName']."';
		\$this->dbPrefix       = '".$_POST['bddPrefix']."';
		\$this->dbUserDb       = '".$userDb."';
		\$this->dbUserTable    = '".$userTable."';
		\$this->dbUserId       = '".$userId."';
		\$this->dbUserPseudo   = '".$userPseudo."';
		\$this->dbUserPassword = '".$userPassword."';
		
		mysql_connect(\$this->dbServer, \$this->dbUser, \$this->dbPassword);
		mysql_select_db(\$this->dbBDD);
	}
};

\$srlConfig = new srlConfig();
?>";

		$databaseFile = fopen("../baseConfig.php", "w+");
		fputs($databaseFile, $dbFileContent);
		
		mysql_connect($_POST['bddServer'], $_POST['bddUser'], $_POST['bddPassword']);
		mysql_select_db($_POST['bddName']);
							
		if($integration) {
			mysql_query('CREATE TABLE IF NOT EXISTS '.$_POST['bddPrefix'].'Users  (`id` int(11) NOT NULL, rights int(11) NOT NULL, `time` int(11) NOT NULL, `last_seen` int(11) NOT NULL, FOREIGN KEY (`id`) REFERENCES '.$userDb.'.'.$userTable.' ( `id` ) ) ');
			$query = mysql_query('SELECT '.$userId.', '.$userPseudo.' FROM '.$userDb.'.'.$userTable);
			while($data = mysql_fetch_row($query)) {
				mysql_query('INSERT INTO '.$_POST['bddPrefix'].'Users VALUES ( '.$data[0].', '. ($data[1] == $_POST['userName'] ? "65535" : "00" ).', '.time().', '.time().' ) ');
			}
		} else {
			mysql_query('CREATE TABLE IF NOT EXISTS '.$userTable.' ( `id` int(11) UNIQUE AUTO_INCREMENT, pseudo TEXT NOT NULL, password TEXT NOT NULL ) ');
			mysql_query('INSERT INTO '.$userTable.' VALUES( 0, "'.$_POST['userName'].'", "'.md5($_POST['userPassword']).'") ');
			mysql_query('CREATE TABLE IF NOT EXISTS '.$_POST['bddPrefix'].'Users  (`id` int(11) NOT NULL, rights int(11) NOT NULL, `time` int(11) NOT NULL, `last_seen` int(11) NOT NULL, FOREIGN KEY (`id`) REFERENCES '.$userDb.'.'.$userTable.' ( `id` ) ) ');
			mysql_query('INSERT INTO '.$_POST['bddPrefix'].'Users VALUES ( 1, 65535, '.time().', '.time().' ) ');
		}
		
		mysql_query('CREATE TABLE IF NOT EXISTS `'.$_POST['bddPrefix'].'Entries`  (`id` int(11) NOT NULL AUTO_INCREMENT, `type` tinyint(4) NOT NULL, `author` int(11) NOT NULL, `name` tinytext NOT NULL, `description` text NOT NULL, `tags` text NOT NULL, `priority` tinyint(4) NOT NULL, `time` int(11) NOT NULL, `update_time` int(11) NOT NULL, `assignedTo` int(11) NOT NULL, `realisedPercentage` int(11) NOT NULL, PRIMARY KEY (`id`), FOREIGN KEY (author) REFERENCES `'.$_POST['bddPrefix'].'Users`(id) ) DEFAULT CHARSET=utf8');
		mysql_query('CREATE TABLE IF NOT EXISTS `'.$_POST['bddPrefix'].'Updates`  (`id` int(11) NOT NULL AUTO_INCREMENT, `entry` int(11) NOT NULL, `time` int(11) NOT NULL, `description` text NOT NULL, PRIMARY KEY (`id`), FOREIGN KEY (entry) REFERENCES `'.$_POST['bddPrefix'].'Entries`(id) ) DEFAULT CHARSET=utf8');
		mysql_query('CREATE TABLE IF NOT EXISTS `'.$_POST['bddPrefix'].'Comments` (`id` int(11) NOT NULL AUTO_INCREMENT, `entry` int(11) NOT NULL, `author` int(11) NOT NULL, `time` int(11) NOT NULL, `content` text NOT NULL, PRIMARY KEY `id` (`id`), FOREIGN KEY (entry) REFERENCES `'.$_POST['bddPrefix'].'Entries`(id), FOREIGN KEY (author) REFERENCES `'.$_POST['bddPrefix'].'Users`(id) ) DEFAULT CHARSET=utf8');
		
		
		unlink("index.php");
		unlink("installer.func.php");
		unlink("installation.css");
		unlink("success.html");
		rmdir("./");
		
		if(file_exists("success.html")) {
			header("location: success.html");
		} else {
			$_SESSION['message'] = 0;
			header("location: ../");
		}
		
}

?>