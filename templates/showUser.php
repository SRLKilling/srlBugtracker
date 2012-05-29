
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
		
		<?php if($srlBugtracker->can("editUserRights")) { ?>
		
		<h4>Modification des droits</h4>
	
		<form>
			<div>
				<label for="rightsEntryList">Voir la liste d'entrées</label>
				<input type="checkbox" name="rightsEntryList" id="rightsEntryList" <?php if($user->can('showEntryList')) { echo 'checked=""'; }?>/>
			</div>
			<div>
				<label for="rightsShowEntry">Voir le détail d'une entrée</label>
				<input type="checkbox" name="rightsShowEntry" id="rightsShowEntry" <?php if($user->can('showEntry')) { echo 'checked=""'; }?>/>
			</div>
			<div>
				<label for="rightsShowUser">Voir la fiche d'un membre inscrit</label>
				<input type="checkbox" name="rightsShowUser" id="rightsShowUser" <?php if($user->can('showUser')) { echo 'checked=""'; }?>/>
			</div>
			<div>
				<label for="rightsAddEntry">Ajouter une entrée</label>
				<input type="checkbox" name="rightsAddEntry" id="rightsAddEntry" <?php if($user->can('addEntry')) { echo 'checked=""'; }?>/>
			</div>
			<div>
				<label for="rightsAssignEntry">S'assigner une entrée</label>
				<input type="checkbox" name="rightsAssignEntry" id="rightsAssignEntry" <?php if($user->can('assignEntry')) { echo 'checked=""'; }?>/>
			</div>
			<div>
				<label for="rightsUpdateEntry">Mettre à jour une entrée</label>
				<input type="checkbox" name="rightsUpdateEntry" id="rightsUpdateEntry" <?php if($user->can('updateEntry')) { echo 'checked=""'; }?>/>
			</div>
			<div>
				<label for="rightsEditEntry">Modifier les données d'une entrée</label>
				<input type="checkbox" name="rightsEditEntry" id="rightsEditEntry" <?php if($user->can('editEntry')) { echo 'checked=""'; }?>/>
			</div>
			<div>
				<label for="rightsAddComment">Poster un commentaire</label>
				<input type="checkbox" name="rightsAddComment" id="rightsAddComment" <?php if($user->can('addComment')) { echo 'checked=""'; }?>/>
			</div>
			<div>
				<label for="rightsEditUserRights">Modifier les droits d'un utilisateur</label>
				<input type="checkbox" name="rightsEditUserRights" id="rightsEditUserRights" <?php if($user->can('editUserRights')) { echo 'checked=""'; }?>/>
			</div>
			<input type="submit" name="editRightsSubmited" id="editRightsSubmitButton" value="Modifier les droits"/>
		</form>
		
		<?php } ?>