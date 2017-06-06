<?php
$this->load->helper('url');
?>

<div id="contenu">
	<h2>Renseigner ma fiche de frais du mois <?php echo $numMois."-".$numAnnee; ?></h2>
					
	<div class="corpsForm">
	  
	<fieldset>
		<legend>Eléments forfaitisés</legend>			
				
				<table id="tableForfait" style="border:none;">
				<tr>
					<th>Forfait</th>
					<th>Quantité</th>
					<th>Montant</th>
					<th>Total</th>
				</tr>
				<?php
		
					foreach ($lesFraisForfait as $unFrais)
					{
						$idFrais = $unFrais['idfrais'];
						$libelle = $unFrais['libelle'];
						$quantite = $unFrais['quantite'];
						$montant = $unFrais['montant'];

					echo 
						'<tr>
						<!--<p>-->
							<td>
								<label for="'.$idFrais.'">'.$libelle.'</label>
							</td>
							<td>
								<input type="text" readonly id="'.$idFrais.'" name="lesFrais['.$idFrais.']" size="10" maxlength="5" value="'.$quantite.'" />
							</td>
							<td id="montant'.$idFrais.'">
								<input id="input'.$idFrais.'" readonly type="text" name="lesMontants['.$idFrais.']"  size="10" maxlength="5" value="'.$montant.'"onchange="calculForfait('.$idFrais.')"/> € 
							</td>		
							<td id="total'.$idFrais.'" >
								0
							</td>
						<!--</p>-->
						</tr>';
				}
				?>
				<?php echo'<tr>
							<td style="border:none;"></td><td style="border:none;"></td><td>Total frais forfaitisé</td><td id="eltotal">0</td>
							</tr>'?>
				</table>
	</fieldset>
	
	</div>
	<br>
	<fieldset>
		<legend>Descriptif des éléments hors forfait</legend>
			<table class="listeLegere">
			
				<tr>
					<th >Date</th>
					<th >Libellé</th>  
					<th >Montant</th>              
				</tr>
			  
				<?php    
					foreach( $lesFraisHorsForfait as $unFraisHorsForfait) 
					{
						$libelle = $unFraisHorsForfait['libelle'];
						$date = $unFraisHorsForfait['dateFrais'];
						$montant=$unFraisHorsForfait['montant'];
						$id = $unFraisHorsForfait['id'];
						echo 
						
						'<tr>
							<td class="date">'.$date.'</td>
							<td class="libelle">'.$libelle.'</td>
							<td class="montant">'.$montant.'</td>
						</tr>';
					}
				?>	  								  
			</table>
	</fieldset>
</div>
