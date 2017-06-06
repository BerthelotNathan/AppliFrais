<?php
$this->load->helper('url');
?>

<div id="contenu">
	<h2>Renseigner ma fiche de frais du mois <?php echo $numMois."-".$numAnnee; ?></h2>
					
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	 
	<form method="post"  action="<?php echo base_url("c_comptable/majForfait/".$numAnnee.$numMois.'/'.$util);?>">
		<fieldset>
			<legend>Eléments forfaitisés</legend>
				<div class="corpsForm">
		 			
					<table id="tableForfait" style="border:none;">
						<tr>
							<th>Quantité</th>
							<th>Montant</td>
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
									<input type="text" disabled="disabled" id="'.$idFrais.'" name="lesFrais['.$idFrais.']" size="10" maxlength="5" value="'.$quantite.'" />
								</td>
								<td id="montant'.$idFrais.'">
									<input id="input'.$idFrais.'" type="text" name="lesMontants['.$idFrais.']" required="required" size="10" maxlength="7" value="'.$montant.'"onchange="calculForfait('.$idFrais.')"/> € 
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
				</div>
		
				<div class="piedForm">
					<p>
						<input class="bouton" id="ok" type="submit" value="Enregistrer" size="20" />
						<input class="bouton" id="annuler" type="reset" value="Effacer" size="20"/>
					</p> 
				</div>
		</fieldset>
	</form>
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
				$date =$unFraisHorsForfait['dateFrais'];
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
