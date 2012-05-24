
	<h3>Utilisateur n°<?php echo $user->id; ?></h3>
	
		<h4><?php echo $user->pseudo; ?></h4>
	
		<h6>Inscrit</h6>
		<p><?php echo $srlBugtracker->utility->beautifulDate( $user->inscription ); ?>
		
		<h6>Dernière connexion</h6>
		<p><?php echo $srlBugtracker->utility->beautifulDate( $user->lastAction ); ?>
		
		
		<h6>Droits</h6>
		<p><?php printf("%b", $user->rights); ?>