	
	<h3>
		<?php echo $entry->getFormattedType()." n°".$entry->id;?>
		<?php if($srlBugtracker->user->id == $entry->assignedTo || ($entry->author == $srlBugtracker->user->id && $entry->realisedPercentage == 0 && $entry->assignedTo == 0)) {
			echo ' - <a href="'.$srlBugtracker->utility->getLocation("editEntry", $entry->id).'">Modifier l\'entrée</a>';
		} ?>
	</h3>
	
	
	<article>
		<h4>Informations</h4>
	
		<div>
			<h6><?php echo $entry->name; ?></h6>
			<p><?php echo $srlBugtracker->utility->decodeString($entry->description); ?></p>
		</div>
		<div>
			<h6>Auteur</h6>
			<p><a href="<?php echo $srlBugtracker->utility->getLocation("showUser", $entry->author); ?>"><?php echo $entry->getAuthorObject()->pseudo; ?></a></p>
		</div>
		<div>
			<h6>Posté </h6>
			<p><?php echo $srlBugtracker->utility->beautifulDate($entry->creationTime); ?></p>
		</div>
		<div>
			<?php if($entry->creationTime != $entry->lastUpdateTime) { ?>
				<h6>Dernière édition </h6>
				<p><?php echo $srlBugtracker->utility->beautifulDate($entry->lastUpdateTime); ?></p>
			<?php } ?>
		</div>
		<div>
			<h6>Statut</h6>
			<p><?php echo $entry->getStatus(); ?></p>
		</div>
		<div>
			<h6>Priorité</h6>
			<p><?php echo $entry->getFormattedPriority(); ?></p>
		</div>
		<div>
			<h6>Assigné à</h6>
			<p>
				<?php echo ($entry->assignedTo == 0) ? "Personne" : '<a href="'.$srlBugtracker->utility->getLocation("showUser", $entry->author).'">'.$entry->getAssignedToObject()->pseudo.'</a>'; ?>
				<?php if($srlBugtracker->can("assignEntry") && ($entry->assignedTo==0 || $entry->assignedTo==$srlBugtracker->user->id)) { echo ' - <a href="'.$srlBugtracker->utility->getLocation("assignEntry", $entry->id).'"> '.($srlBugtracker->user->id == $entry->assignedTo ? 'Abandonner' : 'Prendre en charge').'</a>'; }?>
			</p>
		</div>
		<div>
			<h6><?php if($entry->tags=="") echo "Aucun "; ?>Tags</h6>
			<p><?php echo $entry->tags;?></p>
		</div>
		
	</article>
	
	<article>
		<h4>Avancement</h4>
		
		<?php if($entry->type == 0) { ?>
		<div>
			<h6>Etat</h6>
			<p>
				<?php if($entry->realisedPercentage == 100) {echo "Fixé";} elseif($entry->realisedPercentage != 0) {echo "Non fixé (".$entry->realisedPercentage."%)";} else {echo "Non fixé";} ?>
				<?php if($srlBugtracker->user->id == $entry->assignedTo) { ?>- <a href="<?php echo $srlBugtracker->utility->getLocation("updateEntry", $entry->id);?>">Modifier l'avancement</a> <?php } ?>
			</p>
		</div>
		<?php } else { ?>
		<div>
			<h6>Réalisé à</h6>
			<p>
				<?php echo $entry->realisedPercentage;?>%
				<?php if($srlBugtracker->user->id == $entry->assignedTo) { ?>- <a href="<?php echo $srlBugtracker->utility->getLocation("updateEntry", $entry->id);?>">Modifier l'avancement</a> <?php } ?>
			</p>
		</div>
			
		<div id="realised-bar">
			<div style="width:<?php echo $entry->realisedPercentage;?>%;" id="<?php if($entry->realisedPercentage != 0 && $entry->assignedTo == 0) { echo "already-"; } ?>realised"></div>
		</div>
		<?php } ?>
		
		
		<?php $updateList = $entry->getUpdateList(); while($update = mysql_fetch_row($updateList)) { ?>
		<div>
			<h6><?php echo $srlBugtracker->utility->beautifulDate($update[2], true); ?></h6>
			<p><?php echo $srlBugtracker->utility->decodeString($update[3]); ?></p>
		</div>
		<?php } ?>
		
	</article>
	
	<article>
		<h4>Commentaires</h4>
		
		<?php $commentList = $entry->getCommentList(); while($comment = mysql_fetch_row($commentList)) { ?>
		<div>
			<h6><?php echo srlBtUser::getPseudo($srlBugtracker, $comment[2]); ?></h6>
			<p>
				<?php echo $srlBugtracker->utility->beautifulDate($comment[3], true); ?><br />
				<?php echo $srlBugtracker->utility->decodeString($comment[4]); ?>
			</p>
		</div>
		<?php } ?>
		
		
		<?php if( $srlBugtracker->can("addComment") ) { ?>
		<form method="post" action="">
			<div>
				<label for="commentContent">Ajouter une mise à jour ou un commentaire : </label>
				<textarea name="commentContent" id="commentContent" rows="10"></textarea>
			</div>
			<input type="submit" name="addCommentSubmited" value="Envoyer" />
		</form>
		<?php } ?>
	</article>