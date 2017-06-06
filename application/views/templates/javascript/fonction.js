//Verifie la validité des informations saisi dans lesdifférents champs du tableau des frais forfaitisés et calcul le total de chaque lignede frais
//Empeche la validation si incorrecte
function calculForfait (idFrais){
	var id = idFrais.id;//id de la ligne du frais
	var quantite = document.getElementById(id).value;//recupere la quantite de la ligne de frais
	var montant = document.getElementById("input"+id).value;//recupere le montant de la ligne de frais
	
	
		//Vérifie le contenu des input contenant la quantité et le montant de l'input utilisé
		if(isNaN(quantite)||isNaN(montant)){
			
			alert("Valeur numérique attendue");
			document.getElementById("ok").style.visibility = "hidden";
		}
		else{
			//appel la fonction pour calculer les valeurs du tableau
			calculMontantsFrais();
		}
	
	
	//recupère les quantité et montant de tout le tableau
	var quantite1 = document.getElementById("ETP").value;
	var quantite2 = document.getElementById("KM").value;
	var quantite3 = document.getElementById("NUI").value;
	var quantite4 = document.getElementById("REP").value;
	var montant1 = document.getElementById("inputETP").value;
	var montant2 = document.getElementById("inputKM").value;
	var montant3 = document.getElementById("inputNUI").value;
	var montant4 = document.getElementById("inputREP").value;
	
	
	/*//Verifie si tout les champs du tableau contiennent des nombres valident ne contenant pas de caractères texte ou spéciaux
	if(isNaN(quantite1) || isNaN(quantite2) || isNaN(quantite3) || isNaN(quantite4) || isNaN(montant1) || isNaN(montant2) || isNaN(montant3) || isNaN(montant4) ){
		document.getElementById("erreurSaisi").innerHTML ="Caractère(s) non valide(s) pour la quantité !";
		document.getElementById("ok").style.visibility = "hidden";
	}
	//Verifie si tout les champs du tableau ne sont pas vides
	else if(quantite1 ==="" || quantite2 ==="" || quantite3 ==="" || quantite4 ==="" || montant1===""  || montant2 ==="" || montant3 ==="" || montant4 ===""){
		document.getElementById("erreurSaisi").innerHTML ="Champ(s) vide(s) !";
		document.getElementById("ok").style.visibility = "hidden";
	}
	*/
}


//Calcul le total de tout les frais du taleau
	function calculMontantsFrais(){
				
		//recup quantite de chaque lignes
		var quantite1 = document.getElementById("ETP").value;
		var quantite2 = document.getElementById("KM").value;
		var quantite3 = document.getElementById("NUI").value;
		var quantite4 = document.getElementById("REP").value;
		
		//recup montant de chaque lignes
		var montant1 = document.getElementById("inputETP").value;
		var montant2 = document.getElementById("inputKM").value;
		var montant3 = document.getElementById("inputNUI").value;
		var montant4 = document.getElementById("inputREP").value;
				
		//calcul total de chaque ligne et l'ajout dans la colonne total arrondi au centieme
		var total1 = parseFloat(quantite1)*parseFloat(montant1);
		document.getElementById("totalETP").innerHTML = total1.toFixed(2); 
		var total2 = parseFloat(quantite2)*parseFloat(montant2);
		document.getElementById("totalKM").innerHTML = total2.toFixed(2);
		var total3 = parseFloat(quantite3)*parseFloat(montant3);
		document.getElementById("totalNUI").innerHTML = total3.toFixed(2);
		var total4 = parseFloat(quantite4)*parseFloat(montant4);
		document.getElementById("totalREP").innerHTML = total4.toFixed(2);
		
		//totalise les frais 
		var total = total1 + total2 + total3 + total4;
		document.getElementById("eltotal").innerHTML = total.toFixed(2)+" €";
		
		//rend visible le bouton de validation
		document.getElementById("ok").style.visibility = "visible";
	}
	
	

//Verifie si le champ de la quantite des elements Hors Forfait est valide
//Empeche la validation si incorrecte
function verifElementHorsForfait(){
	var quantite = document.getElementById("txtMontantHF").value;
	
	//Verifie si le champ contient bien un nombre et non des caractères texte ou spéciaux
	if(isNaN(quantite)){
		document.getElementById("ajouter").style.visibility = "hidden";
		alert("Valeur numérique attendue");
	}
	//Si le contenant du champ est valide
	else{
		
		document.getElementById("ajouter").style.visibility = "visible";
	}
	
}

