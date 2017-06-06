<?php
	$this->load->helper('url');
?>

<div id="contenu">
	<h2>Renseigner ma fiche de frais du mois <?php echo $numMois."-".$numAnnee; ?></h2>
					
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	
	
		<fieldset>
			<legend>Eléments forfaitisés</legend>
			
			<form method="post"  action="<?php echo base_url("c_visiteur/majForfait");?>">
			
				<div class="corpsForm">
					
					
					<?php if(isset($raison['raison'])) {
							//if($raison['raison'] != NULL) {
								echo '<fieldset style= "color:red; border:none;">La fiche a été refusée.</fieldset>';//'<fieldset><legend id="raisonRefus">Raison du refus</legend>'.$raison['raison'].'</fieldset><br>';
							//}
							}
					?>
					<text id="erreurSaisi"></text></br>
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
									<td>
										<label for="'.$idFrais.'">'.$libelle.'</label>
									</td>
									<td>
										<input type="text" required="required" id="'.$idFrais.'" name="lesFrais['.$idFrais.']" size="10" maxlength="5" value="'.$quantite.'" onchange="calculForfait('.$idFrais.')"/>
									</td>
									<td id="montant'.$idFrais.'">
										<input id="input'.$idFrais.'" type="text" disabled="disabled" size="10" maxlength="7" value="'.$montant.'"/> €
									</td>		
									<td id="total'.$idFrais.'" >
										0
									</td>
								</tr>';
									
							}
							
						?>
							
						<?php echo'<tr>
								<td style="border:none;"></td><td style="border:none;"></td><td>Total frais forfaitisé</td><td id="eltotal">0</td>
								</tr>'?>
						
					</table>
					
				</div>
						
				<div class="piedForm">
						<input class="bouton" id="ok" type="submit" value="Enregistrer" size="20" />
						<input class="bouton" id="annuler" type="reset" value="Effacer" size="20"/>
				</div>
			
			</form>
		</fieldset>		
		<br>
		<fieldset>
			<legend>Descriptif des éléments hors forfait</legend>
				<table class="listeLegere">
					<tr>
						<th >Date</th>
						<th >Libellé</th>  
						<th >Montant</th>  
						<th >&nbsp;</th>              
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
								<td class="action">'.
								anchor(	"c_visiteur/supprFrais/$id", 
										"Supprimer ce frais", 
										'title="Suppression d\'une ligne de frais" onclick="return confirm(\'Voulez-vous vraiment supprimer ce frais ?\');"'
									).
								'</td>
								</tr>';
							}
						?>	  
							
				</table>
		
		
		
		
		<form method="post" action="<?php echo base_url("c_visiteur/ajouteFrais");?>">
			<div class="corpsForm">
				<br>
				<fieldset>
					<legend>Nouvel élément hors forfait</legend>
					<p>
						<label for="txtDateHF">Date : </label>
						<input required="required" type="date" id="txtDateHF" name="dateFrais" size="10" maxlength="10" value=""  />
					</p>
					<p>
						<label for="txtLibelleHF">Libellé :</label>
						<input required="required" type="text" id="txtLibelleHF" name="libelle" size="60" maxlength="256" value="" />
					</p>
					<p>
						<label for="txtMontantHF">Montant : </label>
						<input required="required" type="text" id="txtMontantHF" name="montant" size="10" maxlength="10" value="" onchange="verifElementHorsForfait()" />
						<text id="erreurSaisiHF"></text></br>
					</p>
				</fieldset>
			</div>
			<div class="piedForm">
				<p>
					<input class="bouton" id="ajouter" type="submit" value="Ajouter" size="20" />
					<input class="bouton" id="effacer" type="reset" value="Effacer" size="20"/>
				</p> 
			</div>
		</form>
	</fieldset>
</div>
