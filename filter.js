function filter_isSelected(obj, prefixe) {
	if(obj.checked == true)
		valeur = "block";
	else
		valeur = "none";
		
	document.getElementById('filter_'+prefixe+'_condition').style.display = valeur;
	document.getElementById('filter_'+prefixe+'_value').style.display = valeur;
}