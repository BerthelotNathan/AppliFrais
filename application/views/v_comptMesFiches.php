<?php
	$this->load->helper('url');
?>
<div id="contenu">
	<h2>Liste des fiches de frais à valider</h2>
	 	
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	 
	<table class="listeLegere">
		<thead>
			<tr>
				<th >ID visiteur</th>
				<th >Mois</th>
				<th >Etat</th>  
				<th >Montant</th>  
				<th >Date modif.</th>  
				<th  colspan="4">Actions</th>              
			</tr>
		</thead>
		<tbody>
          
		<?php    
			foreach( $mesFiches as $uneFiche) 
			{
				$consultLink = '';
				$validLink = '';
				$refusLink = '';
				if ($uneFiche['id'] == 'CL') {
					$consultLink = anchor('c_comptable/consultFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'modifier',  'title="Modifier les montants de la fiche"');
					$validLink = anchor('c_comptable/validFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'valider',  'title="Valider la fiche"  onclick="return confirm(\'Voulez-vous vraiment valider cette fiche ?\');"');
					$refusLink = anchor('c_comptable/refusFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'refuser',  'title="Refuser la fiche"');
				}
				
				echo 
				'<tr>
					<td class="idVisiteur">'.$uneFiche['idVisiteur'].'</td>
					<td class="date">'.anchor('c_comptable/voirFiche/'.$uneFiche['mois'], $uneFiche['mois'],  'title="Consulter la fiche"').'</td>
					<td class="etat">'.$uneFiche['libelle'].'</td>
					<td class="montant">'.$uneFiche['montantValide'].'</td>
					<td class="date">'.$uneFiche['dateModif'].'</td>
					<td class="action">'.$consultLink.'</td>
					<td class="action">'.$validLink.'</td>
					<td class="action">'.$refusLink.' </td>
				</tr>'
				
				;
			}
		?>	  
		</tbody>
    </table>

</div>