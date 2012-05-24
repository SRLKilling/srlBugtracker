
	<table>
		<thead>
			<tr>
				<td>#</td>
				<td>Type</td>
				<td>Nom</td>
				<td>Auteur</td>
				<td>Priorité</td>
				<td>Crée</td>
				<td>Edité</td>
				<td>Assigné à</td>
				<td>Avancement</td>
			</tr>
		</thead>
		
		<tbody>
			<?php while($entry = $entryList->getNextEntry()) { ?>
			
			<tr class="<?php echo ($entry->realisedPercentage == 100 ? "resolved" : $entryList->getPriorityClass($entry->priority));?>">
				<td><?php echo $entry->id; ?></td>
				<td><?php echo $entry->getFormattedType(); ?></td>
				<td><a href="<?php echo $srlBugtracker->utility->getLocation("showEntry", $entry->id); ?>"><?php echo $entry->name; ?></a></td>
				<td><a href="<?php echo $srlBugtracker->utility->getLocation("showUser", $entry->author); ?>"><?php echo srlBtUser::getPseudo($srlBugtracker, $entry->author); ?></a></td>
				<td><?php echo $entry->getFormattedPriority(); ?></td>
				<td><?php echo date('d/m/Y à H:i', $entry->creationTime); ?></td>
				<td><?php echo date('d/m/Y à H:i', $entry->lastUpdateTime); ?></td>
				<td><?php echo ($entry->assignedTo == 0 ? "Personne" : '<a href="'.$srlBugtracker->utility->getLocation('showUser', $entry->assignedTo).'">'.srlBtUser::getPseudo($srlBugtracker, $entry->assignedTo)).'</a>'; ?></td>
				<td><?php echo $entry->realisedPercentage; ?>%</td>
			</tr>
			
			<?php } ?>
		</tbody>
		
		<tfoot>
			<tr>
				<td>#</td>
				<td>Type</td>
				<td>Nom</td>
				<td>Auteur</td>
				<td>Priorité</td>
				<td>Crée</td>
				<td>Edité</td>
				<td>Assigné à</td>
				<td>Avancement</td>
			</tr>
		</tfoot>
	</table>