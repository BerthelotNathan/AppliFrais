<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modèle qui implémente les fonctions d'accès aux données 
*/
class DataAccess extends CI_Model {
// TODO : Transformer toutes les requêtes en requêtes paramétrées

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
	 * Retourne les informations d'un visiteur
	 * 
	 * @param $login 
	 * @param $mdp
	 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
	*/
	public function getInfosVisiteur($login, $mdp){
		$req = "select af_visiteur.id as id, af_visiteur.nom as nom, af_visiteur.prenom as prenom
				from af_visiteur 
				where af_visiteur.login=? and af_visiteur.mdp=?";
		$rs = $this->db->query($req, array ($login, $mdp));
		$ligne = $rs->first_row('array'); 
		return $ligne;
	}
	
	/** Retourne les infos d'un Comptable */
	
	public function getInfosComptable($login, $mdp){
		$req = "select af_visiteur.profil as type
				from af_visiteur
				where af_visiteur.login=? and af_visiteur.mdp=?";
		$rs = $this->db->query($req, array ($login, $mdp));
		$ligne = $rs->first_row('array');
		return $ligne;
	}
	

	/**
	 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
	 * concernées par les deux arguments
	 * La boucle foreach ne peut être utilisée ici car on procède
	 * à une modification de la structure itérée - transformation du champ date-
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
	*/
	public function getLesLignesHorsForfait($idVisiteur,$mois){
		$this->load->model('functionsLib');

		$req = "select * 
				from af_lignefraishorsforfait 
				where af_lignefraishorsforfait.idvisiteur ='$idVisiteur' 
					and af_lignefraishorsforfait.mois = '$mois' ";	
		$rs = $this->db->query($req);
		$lesLignes = $rs->result_array();
		$nbLignes = $rs->num_rows();
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['dateFrais'];
			$lesLignes[$i]['dateFrais'] =  $this->functionsLib->dateAnglaisVersFrancais($date);
		}
		return $lesLignes; 
	}
		
	/**
	 * Retourne le nombre de justificatif d'un visiteur pour un mois donné
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return le nombre entier de justificatifs 
	*/
	public function getNbjustificatifs($idVisiteur, $mois){
		$req = "select af_fichefrais.nbjustificatifs as nb 
				from  af_fichefrais 
				where af_fichefrais.idvisiteur ='$idVisiteur' and af_fichefrais.mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = $rs->result_array();
		return $laLigne['nb'];
	}
		
	/**
	 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
	 * concernées par les deux arguments
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
	*/
	public function getLesLignesForfait($idVisiteur, $mois){
		$req = "select af_fraisforfait.id as idfrais, af_fraisforfait.libelle as libelle, af_lignefraisforfait.quantite as quantite, montantApplique as montant 
				from af_lignefraisforfait inner join af_fraisforfait 
					on af_fraisforfait.id = af_lignefraisforfait.idfraisforfait
				where af_lignefraisforfait.idvisiteur ='$idVisiteur' and af_lignefraisforfait.mois='$mois' 
				order by af_lignefraisforfait.idfraisforfait";	
		$rs = $this->db->query($req);
		$lesLignes = $rs->result_array();
		return $lesLignes; 
		
		
	}
	public function getLesLignesForfaitComp($idVisiteur, $mois){
		$req = "select af_fraisforfait.id as idfrais, af_fraisforfait.libelle as libelle, af_lignefraisforfait.quantite as quantite, af_lignefraisforfait.montantApplique as montant
		from af_lignefraisforfait inner join af_fraisforfait
		on af_fraisforfait.id = af_lignefraisforfait.idfraisforfait
		where af_lignefraisforfait.idvisiteur ='$idVisiteur' and af_lignefraisforfait.mois='$mois'
		order by af_lignefraisforfait.idfraisforfait";
		$rs = $this->db->query($req);
		$lesLignes = $rs->result_array();
		return $lesLignes;
	}
	
	
	/**
	 * Retourne tous les FraisForfait
	 * 
	 * @return un tableau associatif contenant les fraisForfaits
	*/
	public function getLesFraisForfait(){
		$req = "select af_fraisforfait.id as idfrais, libelle, montant from af_fraisforfait order by af_fraisforfait.id";
		$rs = $this->db->query($req);
		$lesLignes = $rs->result_array();
		return $lesLignes;
	}
	
	/**
	 * Met à jour la table ligneFraisForfait pour un visiteur et
	 * un mois donné en enregistrant les nouveaux montants
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
	*/
	public function majLignesForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update af_lignefraisforfait 
					set af_lignefraisforfait.quantite = $qte
					where af_lignefraisforfait.idvisiteur = '$idVisiteur' 
						and af_lignefraisforfait.mois = '$mois'
						and af_lignefraisforfait.idfraisforfait = '$unIdFrais'";
			$this->db->simple_query($req);
		}
	}
	
	public function majLignesForfaitComp($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update af_lignefraisforfait
			set af_lignefraisforfait.montantApplique = $qte
			where af_lignefraisforfait.idvisiteur = '$idVisiteur'
			and af_lignefraisforfait.mois = '$mois'
			and af_lignefraisforfait.idfraisforfait = '$unIdFrais'";
			$this->db->simple_query($req);
		}
	}
	
	/**
	 * met à jour le nombre de justificatifs de la table ficheFrais
	 * pour le mois et le visiteur concerné
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update af_fichefrais 
				set nbjustificatifs = $nbJustificatifs 
				where af_fichefrais.idvisiteur = '$idVisiteur' 
					and af_fichefrais.mois = '$mois'";
		$this->db->simple_query($req);	
	}
		
	/**
	 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return vrai si la fiche existe, ou faux sinon
	*/	
	public function existeFiche($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais 
				from af_fichefrais 
				where af_fichefrais.mois = '$mois' and af_fichefrais.idvisiteur = '$idVisiteur'";
		$rs = $this->db->query($req);
		$laLigne = $rs->first_row('array');
		if($laLigne['nblignesfrais'] != 0){
			$ok = true;
		}
		return $ok;
	}
	
	/**
	 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
	 * L'état de la fiche est mis à 'CR'
	 * Lles lignes de frais forfait sont affectées de quantités nulles et du montant actuel de FraisForfait
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	*/
	public function creeFiche($idVisiteur,$mois){
		$req = "insert into af_fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
				values('$idVisiteur','$mois',0,0,now(),'CR')";
		
		$req2 = "UPDATE AF_FICHEFRAIS
				SET ETAT = (SELECT CODEETAT
							FROM AF_ETAT
							WHERE AF_ETAT.ID = AF_FICHEFRAIS.IDETAT
							AND AF_FICHEFRAIS.IDVISITEUR = '$idVisiteur'
							AND AF_FICHEFRAIS.MOIS = '$mois')";
		
		$req3 = "UPDATE AF_FICHEFRAIS
				SET VISITEUR = (SELECT CODEVISITEUR
								FROM AF_VISITEUR
								WHERE AF_VISITEUR.ID = AF_FICHEFRAIS.IDVISITEUR
								AND AF_FICHEFRAIS.IDVISITEUR = '$idVisiteur'
								AND AF_FICHEFRAIS.MOIS = '$mois')";
								
								
				
		$this->db->simple_query($req);
		$this->db->simple_query($req2);
		$this->db->simple_query($req3);
		
		$lesFF = $this->getLesFraisForfait();
		foreach($lesFF as $uneLigneFF){
			$unIdFrais = $uneLigneFF['idfrais'];
			$montantU = $uneLigneFF['montant'];
			$req = "insert into af_lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite, montantApplique) 
					values('$idVisiteur','$mois','$unIdFrais',0, $montantU)";
			
			$req2 = "UPDATE AF_LIGNEFRAISFORFAIT
					SET FICHEFRAIS = (SELECT CODEFICHEFRAIS
									  FROM AF_FICHEFRAIS
									  WHERE AF_FICHEFRAIS.IDVISITEUR = AF_LIGNEFRAISFORFAIT.IDVISITEUR 
									  AND AF_FICHEFRAIS.MOIS = AF_LIGNEFRAISFORFAIT.MOIS
									  AND AF_LIGNEFRAISFORFAIT.IDVISITEUR = '$idVisiteur'
									  AND AF_LIGNEFRAISFORFAIT.MOIS = '$mois')";
			
			$req3 = "UPDATE AF_LIGNEFRAISFORFAIT
					SET FRAISFORFAIT = (SELECT CODEFRAISFORFAIT
										FROM AF_FRAISFORFAIT
										WHERE AF_FRAISFORFAIT.ID = AF_LIGNEFRAISFORFAIT.IDFRAISFORFAIT
										AND AF_LIGNEFRAISFORFAIT.IDFRAISFORFAIT = '$unIdFrais')";
			
			$this->db->simple_query($req);
			$this->db->simple_query($req2);
			$this->db->simple_query($req3);
		 }
	}

	/**
	 * Signe une fiche de frais en modifiant son état de "CR" à "CL"
	 * Ne fait rien si l'état initial n'est pas "CR"
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	*/
	public function signeFiche($idVisiteur,$mois){
		//met à 'CL' son champs idEtat
		$laFiche = $this->getLesInfosFicheFrais($idVisiteur,$mois);
		if($laFiche['idEtat']=='CR' or 'RF'){
				$this->majEtatFicheFrais($idVisiteur, $mois,'CL');
		}
	}   
	
	
	public function valideFiche($idVisiteur,$mois){//change l'état de la fiche en VA pour Validée
		$this->majEtatFicheFrais($idVisiteur, $mois,'VA');
	}

	
	public function refuseFiche($idVisiteur,$mois){//change l'état de la fiche en RF pour Réfusée
		$this->majEtatFicheFrais($idVisiteur, $mois,'RF');
	}
	
	public function commentaireRefusComptable($idVisiteur,$mois,$commentaire){
		$req = "update af_ficheFrais
		set commentaireRefus = '$commentaire'
		where af_fichefrais.idvisiteur ='$idVisiteur' and af_fichefrais.mois = '$mois'";
		$this->db->simple_query($req);
	}
	
	public function getlaRaison($idVisiteur, $mois){
		$req = "select commentaireRefus as raison
		from af_fichefrais
		where af_fichefrais.idVisiteur = '$idVisiteur' and af_fichefrais.mois = '$mois'";
		$rs = $this->db->query($req);
		$lesFiches = $rs->first_row('array');
		return $lesFiches;
	}
	
	/*public function getCleFicheFraisHF($idVisiteur,$mois){
		$req = "select af_fichefrais.codefichefrais as code 
		from  af_fichefrais 
		where af_fichefrais.idvisiteur ='$idVisiteur' and af_fichefrais.mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = array_column($rs, 'code');
		return $laLigne;
		
	}*/
	
	/**
	 * Crée un nouveau frais hors forfait pour un visiteur un mois donné
	 * à partir des informations fournies en paramètre
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @param $libelle : le libelle du frais
	 * @param $date : la date du frais au format français jj//mm/aaaa
	 * @param $montant : le montant
	*/
	public function creeLigneHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$this->load->model('functionsLib');
		$dateConvertie =  $this->functionsLib->dateFrancaisVersAnglais($date);
		//$codeFicheFrais = $this->getCleFicheFraisHF($idVisiteur,$mois);
		
		$req = "insert into af_lignefraishorsforfait 
				values('','$idVisiteur','$mois','$libelle','$dateConvertie','$montant','');";
		$this->db->simple_query($req);
		
		$req2 = "UPDATE AF_LIGNEFRAISHORSFORFAIT
				SET FICHEFRAIS = (
				SELECT CODEFICHEFRAIS
				FROM AF_FICHEFRAIS
				WHERE AF_FICHEFRAIS.IDVISITEUR = AF_LIGNEFRAISHORSFORFAIT.IDVISITEUR 
				AND AF_FICHEFRAIS.MOIS = AF_LIGNEFRAISHORSFORFAIT.MOIS)
				AND AF_LIGNEFRAISHORSFORFAIT.IDVISITEUR = '$idVisiteur'
				AND AF_LIGNEFRAISHORSFORFAIT.MOIS = '$mois';";
		$this->db->simple_query($req2);
	}
	
	
	/**
	 * Supprime le frais hors forfait dont l'id est passé en argument
	 * 
	 * @param $idFrais 
	*/
	public function supprimerLigneHorsForfait($idFrais){
		$req = "delete from af_lignefraishorsforfait 
				where af_lignefraishorsforfait.id =$idFrais ";
		$this->db->simple_query($req);
	}

	/**
	 * Retourne les mois pour lesquel un visiteur a une fiche de frais
	 * 
	 * @param $idVisiteur 
	 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
	*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select af_fichefrais.mois as mois 
				from  af_fichefrais 
				where af_fichefrais.idvisiteur ='$idVisiteur' 
				order by af_fichefrais.mois desc ";
		$rs = $this->db->query($req);
		$lesMois =array();
		$laLigne = $rs->first_row('array');
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee = substr( $mois,0,4);
			$numMois = substr( $mois,4,2);
			$lesMois["$mois"] = array(
				"mois"=>"$mois",
				"numAnnee"  => "$numAnnee",
				"numMois"  => "$numMois"
			 );
			$laLigne = $rs->next_row('array'); 		
		}
		return $lesMois;
	}

	/**
	 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
	*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select af_ficheFrais.idEtat as idEtat, af_ficheFrais.dateModif as dateModif, 
					af_ficheFrais.nbJustificatifs as nbJustificatifs, af_ficheFrais.montantValide as montantValide, af_etat.libelle as libEtat 
				from  af_fichefrais inner join Etat on af_ficheFrais.idEtat = af_etat.id 
				where af_fichefrais.idvisiteur ='$idVisiteur' and af_fichefrais.mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = $rs->first_row('array');
		return $laLigne;
	}

	/**
	 * Modifie l'état et la date de modification d'une fiche de frais
	 * 
	 * @param $idVisiteur 
	 * @param $mois sous la forme aaaamm
	 * @param $etat : le nouvel état de la fiche 
	 */
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update af_ficheFrais 
				set idEtat = '$etat', dateModif = now() 
				where af_fichefrais.idvisiteur ='$idVisiteur' and af_fichefrais.mois = '$mois'";
		$this->db->simple_query($req);
	}
	
	/**
	 * Obtient toutes les fiches (sans détail) d'un visiteur donné 
	 * 
	 * @param $idVisiteur 
	*/
	public function getFiches ($idVisiteur) {
		$req = "select idVisiteur, mois, montantValide, dateModif, id, libelle
				from  af_fichefrais inner join af_etat on af_ficheFrais.idEtat = af_etat.id 
				where af_fichefrais.idvisiteur = '$idVisiteur'
				order by mois desc";
		$rs = $this->db->query($req);
		$lesFiches = $rs->result_array();
		return $lesFiches;
	}
	
	/** Obtient toutes les fiches validées par n'importe quel visiteur  */
	
	public function getFichesValidation ($idVisiteur) {
		$req = "select idVisiteur, nom, prenom, mois, montantValide, dateModif, af_visiteur.id, libelle, af_etat.id
		from af_visiteur,  af_fichefrais inner join af_etat on af_ficheFrais.idEtat = af_etat.id
		where af_visiteur.id = idVisiteur
		order by idVisiteur, mois desc";
		$rs = $this->db->query($req);
		$lesFiches = $rs->result_array();
		return $lesFiches;
	}
	
	
	
	/**
	 * Calcule le montant total de la fiche pour un visiteur et un mois donnés
	 * 
	 * @param $idVisiteur 
	 * @param $mois
	 * @return le montant total de la fiche
	*/
	public function totalFiche ($idVisiteur, $mois) {
		// obtention du total hors forfait
		$req = "select SUM(montant) as totalHF
				from  af_lignefraishorsforfait 
				where idvisiteur = '$idVisiteur'
					and mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = $rs->first_row('array');
		$totalHF = $laLigne['totalHF'];
		
		// obtention du total forfaitisé
		$req = "select SUM(montantApplique * quantite) as totalF
				from  af_lignefraisforfait 
				where idvisiteur = '$idVisiteur'
					and mois = '$mois'";
		$rs = $this->db->query($req);
		$laLigne = $rs->first_row('array');
		$totalF = $laLigne['totalF'];

		return $totalHF + $totalF;
	}

	/**
	 * Modifie le montantValide et la date de modification d'une fiche de frais
	 * 
	 * @param $idVisiteur : l'id du visiteur
	 * @param $mois : mois sous la forme aaaamm
	 */
	public function recalculeMontantFiche($idVisiteur,$mois){
	
		$totalFiche = $this->totalFiche($idVisiteur,$mois);
		$req = "update af_ficheFrais 
				set montantValide = '$totalFiche', dateModif = now() 
				where af_fichefrais.idvisiteur ='$idVisiteur' and af_fichefrais.mois = '$mois'";
		$this->db->simple_query($req);
	}
}
?>