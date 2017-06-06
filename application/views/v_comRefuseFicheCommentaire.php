<?php
	$this->load->helper('url');
?>

<div id="contenu">			
	<?php if(!empty($notify)) echo '<p id="notify" >'.$notify.'</p>';?>
	<?php echo 'Fiche de frais du mois ' .$numMois."-".$numAnnee."-".$util?>
	<form method="post"  action="<?php echo base_url("c_comptable/refuserFiche/".$numAnnee.$numMois.'/'.$util);?>">
		<div class="corpsForm">
			<fieldset>
				<legend>Commentaire de refus</legend>
				<p>
					<label for="commentaire">Libellé</label>
					<textarea required="required" id="commentaire" name="commentaire" rows=4 cols=40 maxlength="256" value=""> </textarea>
				</p>
			</fieldset>
		</div>
		<div class="piedForm">
			<p>
				<input class="bouton" id="envoyer" type="submit" value="Envoyer" size="20"' onclick="return confirm('Voulez-vous vraiment refuser cette fiche ?')" /> 
				<input class="bouton" id="effacer" type="reset" value="Effacer" size="20" />
			</p> 
		</div>
	</form>
</div>