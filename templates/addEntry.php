	
	<h3>Ajouter une entrée</h3>
	<form action="" method="post">

		<div>
			<label for="entryType">Type d'entréen&nbsp;:</label>
			<select name="entryType" id="entryType">
				<option value="0" selected="selected">Bug à corriger</option>
				<option value="1">Feature à implémenter</option>
			</select>
		</div>
		<div>
			<label for="entryName">Nom&nbsp;:</label>
			<input name="entryName" id="entryName" type="text" required/>
		</div>
		<div>
			<label for="entryPriority">Priorité&nbsp;:</label>
			<select name="entryPriority" id="priorite">
				<option value="0">Bas</option>
				<option value="1" selected="selected">Normal</option>
				<option value="2">Haut</option>
				<option value="3">Urgent</option>
			</select>
		</div>
		<div>
			<label for="entryTags">Liste de tags&nbsp;:</label>
			<input name="entryTags" id="entryTags" type="text" placeholder="Séparez les tags par un espace"/><br />
		</div>
		<div>
			<label for="entryDescription">Description&nbsp;:</label>
			<textarea name="entryDescription" id="entryDescription" rows="20" required></textarea><br />
		</div>

		<input type="submit" value="Ajouter l'entrée" name="addEntrySubmited"/>
	</form>