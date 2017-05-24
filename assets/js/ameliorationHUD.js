
function calculTotal(idFrais){
	var id = idFrais.id; 
	
	var qte = document.getElementById(id).value;
	
	var montant = document.getElementById("montant"+id).value;
	
	if (isNaN(montant) || isNaN(qte)) 
	{
		
			alert("Valeur numérique attendue");
		
	}else{
		var total = qte*montant;
					
		document.getElementById("total"+id).innerHTML = parseFloat(total).toFixed(2);
		
		
		var t1 = document.getElementById("totalETP").innerHTML;
		if(isNaN(t1)){
			t1 = 0;
		}
		var t2 = document.getElementById("totalKM").innerHTML;
		if(isNaN(t2)){
			t2 = 0;
		}
		var t3 = document.getElementById("totalNUI").innerHTML;
		if(isNaN(t3)){
			t3 = 0;
		}
		var t4 = document.getElementById("totalREP").innerHTML;
		if(isNaN(t4)){
			t4 = 0;
		}
		
		var totalfinal = parseFloat(t1)+parseFloat(t2)+parseFloat(t3)+parseFloat(t4);
		document.getElementById("totalfinal").innerHTML = totalfinal+"€";
	}
}


function calculTotalOnLoad()
{
	
	//recherche les quantites
	var qte1 = document.getElementById("ETP").value;
	var qte2 = document.getElementById("KM").value;
	var qte3 = document.getElementById("NUI").value;
	var qte4 = document.getElementById("REP").value;
	
	//recherche les montant
	var montant1 = document.getElementById("montantETP").value;
	var montant2 = document.getElementById("montantKM").value;
	var montant3 = document.getElementById("montantNUI").value;
	var montant4 = document.getElementById("montantREP").value;
	
	//total de chaque lignes
	var t1 = parseFloat(qte1)*parseFloat(montant1);
	document.getElementById("totalETP").innerHTML = t1.toFixed(2);
	var t2 = parseFloat(qte2)*parseFloat(montant2);
	document.getElementById("totalKM").innerHTML = t2.toFixed(2);
	var t3 = parseFloat(qte3)*parseFloat(montant3);
	document.getElementById("totalNUI").innerHTML = t3.toFixed(2);
	var t4 = parseFloat(qte4)*parseFloat(montant4);
	document.getElementById("totalREP").innerHTML = t4.toFixed(2);
	
	//totalfinal
	var totalfinal = parseFloat(t1)+parseFloat(t2)+parseFloat(t3)+parseFloat(t4);
	totalfinal = totalfinal.toFixed(2)
document.getElementById("totalfinal").innerHTML = totalfinal+"€";
}

function alerteRefus() {
    var txt;
    var commentaire = prompt("Voulez-vous vraiment refuser cette fiche ?","Saisissez la raison ce de refus");
    if (commentaire == null || commentaire == "") {
        txt = "Pas de commentaire";
    } else {
    	
            txt = commentaire;
    
    }
    
    return txt;
    
}




function autoload(){
	
	
	setTimeout(hideNotify,7000);
}