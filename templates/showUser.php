
	<h3>Utilisateur n°<?php echo $user->id; ?></h3>
	
		<h4><?php echo $user->pseudo; ?></h4>
		
		<div>
			<h6>Inscrit</h6>
			<p><?php echo $srlBugtracker->utility->beautifulDate( $user->inscription ); ?>
		</div>
		<div>
			<h6>Dernière connexion</h6>
			<p><?php echo $srlBugtracker->utility->beautifulDate( $user->lastAction ); ?>
		</div>
		<div>
			<h6>Droits</h6>
			<p><?php printf("%b", $user->rights); ?></p>
		</div>
		
		<h4>Modification des droits</h4>
	
		<form>
			<div>
				<label for="rightsEntryList">Voir la liste d'entrées</label>
				<input type="checkbox" name="rightsEntryList" id="rightsEntryList"/>
			</div>
			<div>
				<label for="rightsShowEntry">Voir le détail d'une entrée</label>
				<input type="checkbox" name="rightsShowEntry" id="rightsShowEntry"/>
			</div>
			<div>
				<label for="rightsShowUser">Voir la fiche d'un membre inscrit</label>
				<input type="checkbox" name="rightsShowUser" id="rightsShowUser"/>
			</div>
			<div>
				<label for="rightsAddEntry">Ajouter une entrée</label>
				<input type="checkbox" name="rightsAddEntry" id="rightsAddEntry" <?php if($user->can('addEntry')) { echo 'checked=""'; }?>/>
			</div>
		</form>