
	<h3>Mettre à jour une entrée</h3>
	<form action="" method="post">

		<h4>"<?php echo $entry->name;?>"</h4>
		
			<label for="updatedPercentage">Désormais réalisé(e) à</label>
			<input type="number" name="updatedPercentage" id="updatedPercentage" value="<?php echo $entry->realisedPercentage; ?>" min="0" max="100" step="1" required/>
			
			<div id="realised-bar">
				<div style="width:<?php echo $entry->realisedPercentage;?>%;" id="already-realised"></div>
				<div style="width:<?php echo $entry->realisedPercentage;?>%;" id="realised"></div>
			</div>
			
			<label for="updateDescription">Courte description de la mise à jour :</label>
			<textarea name="updateDescription" id="updateDescription" rows="15" required></textarea><br />
			
		<input type="submit" value="Mettre à jour" name="updateSubmited"/>
	</form>
	
	<script>
		document.getElementById('updatedPercentage').onkeyup = function() {
			this.value = this.value.replace (/\D/, '');
			if(parseInt(this.value) > 100) this.value = "100";
			document.getElementById('realised').style.width = this.value + "%";
		}
		document.getElementById('updatedPercentage').onchange = function() {
			if(this.value == "") this.value = 0;
			document.getElementById('realised').style.width = this.value + "%";
		}
	</script>