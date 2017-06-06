<?php
	$this->load->helper('url');
?>
<div id="contenu">
	<h2>Fiche de Frais</h2>
	 	
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	 
	<table class="listeLegere">
		<thead>
			<tr>
				<th>Mois</th>
				<th>Utilisateur</th>  
				<th>Montant</th>  
				<th>Date modif.</th>  
				<th colspan="3">Actions</th>              
			</tr>
		</thead>
		<tbody>
          
		<?php    
			foreach( $mesFiches as $uneFiche) 
			{
				$modLink = '';
				$signeLink = '';
				$refuserLink = '';

				if ($uneFiche['id'] == 'CL') {
					$modLink = anchor('c_comptable/modFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'modifier',  'title="Modifier la fiche"');
					$validerLink = anchor('c_comptable/validerFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'valider',  'title="Valider la fiche"  onclick="return confirm(\'Voulez-vous vraiment valider cette fiche ?\');"');
					$refuserLink = anchor('c_comptable/refuserFicheCommentaire/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], 'refuser',  'title="Refuser la fiche"');
					echo
					'<tr>
					<td class="date">'.anchor('c_comptable/voirFiche/'.$uneFiche['mois'].'/'.$uneFiche['idVisiteur'], $uneFiche['mois'],  'title="Consulter la fiche"').'</td>
					<td class="libelle">'.$uneFiche['idVisiteur'].'</td>
					<td class="montant">'.$uneFiche['montantValide'].' €</td>
					<td class="date">'.$uneFiche['dateModif'].'</td>
					
					<td class="action">'.$modLink.'</td>
					<td class="action">'.$validerLink.'</td>
					<td class ="action">'.$refuserLink.' </td>
				</tr>';
				}
				
				
			}
		?>	  
		</tbody>
    </table>

</div>