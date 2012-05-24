
	<h3>Modifier une entrée</h3>
	<form action="" method="post">

		<label for="entryType">Type d'entrée : </label>
		<select name="entryType" id="entryType">
			<option value="0" <?php if($entry->type == 0) echo "selected"; ?>>Bug à corriger</option>
			<option value="1" <?php if($entry->type == 1) echo "selected"; ?>>Feature à implémenter</option>
		</select><br />

		<label for="entryName">Nom :</label>
		<input name="entryName" id="entryName" type="text" value="<?php echo $entry->name; ?>" required/><br />

		<label for="entryPriority">Priorité :</label>
		<select name="entryPriority" id="priorite">
			<option value="0" <?php if($entry->priority == 0) echo "selected"; ?>>Bas</option>
			<option value="1" <?php if($entry->priority == 1) echo "selected"; ?>>Normal</option>
			<option value="2" <?php if($entry->priority == 2) echo "selected"; ?>>Haut</option>
			<option value="3" <?php if($entry->priority == 3) echo "selected"; ?>>Urgent</option>
		</select><br />
		
		<label for="entryTags">Liste de tags :</label>
		<input name="entryTags" id="entryTags" type="text" value="<?php echo $entry->tags; ?>" placeholder="Séparez les tags par un espace"/><br />
		
		<label for="entryDescription">Description :</label>
		<textarea name="entryDescription" id="entryDescription" rows="20" required><?php echo $entry->description; ?></textarea><br />


		<input type="submit" value="Modifier l'entrée" name="editEntrySubmited"/>
	</form>