function ajaxBase(fichier) {
	if(window.XMLHttpRequest) // FIREFOX
		xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject) // IE
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else
		return(false);
	xhr_object.open("POST", fichier, false);
	xhr_object.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	return xhr_object;
}
function actu() {	
	nom = ajaxBase("Pages/recupbug.php");
	nom.send("name="+document.getElementById('bug').value+"&recup=nom");
	
	description = ajaxBase("Pages/recupbug.php");
	description.send("name="+document.getElementById('bug').value+"&recup=description");
	
	priorite = ajaxBase("Pages/recupbug.php");
	priorite.send("name="+document.getElementById('bug').value+"&recup=priorite");
	
	statut = ajaxBase("Pages/recupbug.php");
	statut.send("name="+document.getElementById('bug').value+"&recup=statut");
	
	realise = ajaxBase("Pages/recupbug.php");
	realise.send("name="+document.getElementById('bug').value+"&recup=realise");
	
	document.getElementById('nom').innerHTML = nom.responseText;
	document.getElementById('description').innerHTML = description.responseText;
	document.getElementById('priorite').value = priorite.responseText;
	document.getElementById('statut').value = statut.responseText;
	document.getElementById('realise').value = realise.responseText;
	
	document.getElementById('realise').removeAttribute('disabled');
	document.getElementById('statut').removeAttribute('disabled');
	document.getElementById('priorite').removeAttribute('disabled');
	document.getElementById('validerModif').removeAttribute('disabled');
	
	document.getElementById('content_form').style.color = "black";
}


function actuSupprAssign(){
	bug = ajaxBase("Pages/recupassigne.php");
	bug.send("name="+document.getElementById('compte').value);
	document.getElementById('bug').innerHTML = bug.responseText;
}

function actuEditBug() {
	nom = ajaxBase("Pages/recupbug.php");
	nom.send("name="+document.getElementById('bug').value+"&recup=nom");
	
	description = ajaxBase("Pages/recupbug.php");
	description.send("name="+document.getElementById('bug').value+"&recup=description");
	
	categorie = ajaxBase("Pages/recupbug.php");
	categorie.send("name="+document.getElementById('bug').value+"&recup=sujet");	

	document.getElementById('nom').innerHTML = nom.responseText;
	document.getElementById('description').value = description.responseText;
	document.getElementById('categorie').value = categorie.responseText;
	
	document.getElementById('description').removeAttribute('disabled');
	document.getElementById('resolu').removeAttribute('disabled');
	document.getElementById('categorie').removeAttribute('disabled');
	document.getElementById('validerModif').removeAttribute('disabled');
		
	document.getElementById('content_form').style.color = "black";
}
var id;
function actuLiage() {
	if(document.getElementById(id))
		document.getElementById(id).removeAttribute('disabled')
	id = document.getElementById('idBug1').value;
	document.getElementById('idBug2').removeAttribute('disabled');
	document.getElementById(id).setAttribute('disabled', "disabled");
}