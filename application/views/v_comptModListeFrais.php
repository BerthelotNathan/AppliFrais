<?php
	$this->load->helper('url');
?>

<div id="contenu">
	<h2>Modification des montants de la fiche de frais du mois <?php echo $numMois."-".$numAnnee; ?></h2>
					
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	 
	<form method="post"  action="<?php echo base_url("c_comptable/majForfait");?>">
		<div class="corpsForm">
		  
			<fieldset>
				<legend>Eléments forfaitisés</legend>
				<?php
					
				$forfaitise =
				'<table style="border:none;">
					<tr>
						<th style="background:white; border:none;"> </th>
						<th style="background:white; border:none;"> Quantité</th>
						<th style="background:white; border:none;"> Montant </th>
						<th style="background:white; border:none;"> Total </th>
					</tr>';
					
				foreach ($lesFraisForfait as $unFrais)
				{
					$idFrais = $unFrais['idfrais'];
					$libelle = $unFrais['libelle'];
					$quantite = $unFrais['quantite'];
					$montant = $unFrais['montant'];
				
					$forfaitise = $forfaitise.
					'<tr >
							<td>
								<label for="'.$idFrais.'">'.$libelle.'</label>
							</td>
							<td class="quantites">
								<input disabled="disabled" onchange="calculTotal('.$idFrais.')" type="text" id="'.$idFrais.'" name="lesFrais['.$idFrais.']" size="10" maxlength="5" value="'.$quantite.'" class="justUneClasse"/>
								
							</td>
							<td class="montants">
								<input style="text-align : right" required="required" onchange="calculTotal('.$idFrais.')" type="text" id="montant'.$idFrais.'" name="lesFrais['.$idFrais.']" size="10" maxlength="5" value="'.$montant.'" class="justUneClasse"/> €
								
							</td>
							<td id="total'.$idFrais.'" style="text-align : right" class="totauxligne" value=0>
				
							</td>
						</tr>';
				
				}
				//Total frais forfaitisé
					$forfaitise = $forfaitise.
					'<tr>
						<td style="border:none;">
						</td>
						<td style="border:none;">
						</td>
					 	<td style="border:none;"> <b>Total frais forfaitisé</b>
						</td>
						<td> <label id="totalfinal" >0</label></td>
						</tr>';
					$forfaitise = $forfaitise
					.'</table>';
					echo $forfaitise
				?>
			</fieldset>
		</div>
		<div class="piedForm">
			<p>
				<input id="ok" type="submit" value="Enregistrer" size="20" />
				<input id="annuler" type="reset" value="Effacer" size="20" />
			</p> 
		</div>
	</form>

	
	<table class="listeLegere">
		<caption>Descriptif des éléments hors forfait</caption>
		<tr>
			<th >Date</th>
			<th >Libellé</th>  
			<th >Montant</th>  
			<!--<th >&nbsp;</th>     -->
		</tr>
          
		<?php    
			foreach( $lesFraisHorsForfait as $unFraisHorsForfait) 
			{
				$libelle = $unFraisHorsForfait['libelle'];
				$date = $unFraisHorsForfait['date'];
				$montant=$unFraisHorsForfait['montant'];
				$id = $unFraisHorsForfait['id'];
				echo 
				'<tr>
					<td class="date">'.$date.'</td>
					<td class="libelle">'.$libelle.'</td>
					<td class="montant">'.$montant.'</td>
					<!--<td class="action">'.
					anchor(	"c_comptable/supprFrais/$id", 
							"Supprimer ce frais", 
							'title="Suppression d\'une ligne de frais" onclick="return confirm(\'Voulez-vous vraiment supprimer ce frais ?\');"'
						).
					'</td>-->
				</tr>';
			}
		?>	  
                                          
    </table>

	<!--  <form method="post" action="<?php echo base_url("c_comptable/ajouteFrais");?>">
		<div class="corpsForm">
			<fieldset>
				<legend>Nouvel élément hors forfait</legend>
				<p>
					<label for="txtDateHF">Date (jj/mm/aaaa): </label>
					<input type="text" id="txtDateHF" name="dateFrais" size="10" maxlength="10" value=""  />
				</p>
				<p>
					<label for="txtLibelleHF">Libellé</label>
					<input type="text" id="txtLibelleHF" name="libelle" size="60" maxlength="256" value="" />
				</p>
				<p>
					<label for="txtMontantHF">Montant : </label>
					<input type="text" id="txtMontantHF" name="montant" size="10" maxlength="10" value="" />
				</p>
			</fieldset>
		</div>
		<div class="piedForm">
			<p>
				<input id="ajouter" type="submit" value="Ajouter" size="20" />
				<input id="effacer" type="reset" value="Effacer" size="20" />
			</p> 
		</div>
	</form>-->
</div>
