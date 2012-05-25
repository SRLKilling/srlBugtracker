
	<h3>Modifier une entrée</h3>
	<form action="" method="post">
		
		<div>
			<label for="entryType">Type d'entrée&nbsp;:</label>
			<select name="entryType" id="entryType">
				<option value="0" <?php if($entry->type == 0) echo "selected"; ?>>Bug à corriger</option>
				<option value="1" <?php if($entry->type == 1) echo "selected"; ?>>Feature à implémenter</option>
			</select>
		</div>
		<div>
			<label for="entryName">Nom&nbsp;:</label>
			<input name="entryName" id="entryName" type="text" value="<?php echo $entry->name; ?>" required/>
		</div>
		<div>
			<label for="entryPriority">Priorité&nbsp;:</label>
			<select name="entryPriority" id="priorite">
				<option value="0" <?php if($entry->priority == 0) echo "selected"; ?>>Bas</option>
				<option value="1" <?php if($entry->priority == 1) echo "selected"; ?>>Normal</option>
				<option value="2" <?php if($entry->priority == 2) echo "selected"; ?>>Haut</option>
				<option value="3" <?php if($entry->priority == 3) echo "selected"; ?>>Urgent</option>
			</select>
		</div>
		<div>
			<label for="entryTags">Liste de tags&nbsp;:</label>
			<input name="entryTags" id="entryTags" type="text" value="<?php echo $entry->tags; ?>" placeholder="Séparez les tags par un espace"/>
		</div>
		<div>
			<label for="entryDescription">Description&nbsp;:</label>
			<textarea name="entryDescription" id="entryDescription" rows="20" required><?php echo $entry->description; ?></textarea><br />
		</div>

		<input type="submit" value="Modifier l'entrée" name="editEntrySubmited"/>
	</form>