	
	<h3>Ajouter une entrée</h3>
	<form action="" method="post">

		<label for="entryType">Type d'entrée : </label>
		<select name="entryType" id="entryType">
			<option value="0" selected="selected">Bug à corriger</option>
			<option value="1">Feature à implémenter</option>
		</select><br />

		<label for="entryName">Nom :</label>
		<input name="entryName" id="entryName" type="text" required/><br />

		<label for="entryPriority">Priorité :</label>
		<select name="entryPriority" id="priorite">
			<option value="0">Bas</option>
			<option value="1" selected="selected">Normal</option>
			<option value="2">Haut</option>
			<option value="3">Urgent</option>
		</select><br />
		
		<label for="entryTags">Liste de tags :</label>
		<input name="entryTags" id="entryTags" type="text" placeholder="Séparez les tags par un espace"/><br />
		
		<label for="entryDescription">Description :</label>
		<textarea name="entryDescription" id="entryDescription" rows="20" required></textarea><br />


		<input type="submit" value="Ajouter l'entrée" name="addEntrySubmited"/>
	</form>