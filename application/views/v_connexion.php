﻿<?php
	$this->load->helper('url');
	$path = base_url();
?>

<div id="contenu">
	<h2>Identification utilisateur</h2>

	<?php if (isset($erreur))	echo '<div class ="erreur"><ul><li>'.$erreur.'</li></ul></div>'; ?>

	<form method="post" action="<?php echo $path.'c_default/connecter';?>">
		<p>
			<label for="login">Login*</label>
			<input id="login" type="text" name="login"  size="30" maxlength="45"/>
		</p>
		<p>
			<label for="mdp">Mot de passe*</label>
			<input id="mdp"  type="password"  name="mdp" size="30" maxlength="45"/>
		</p>
		<p>
			<input class="bouton" type="submit" value="Valider" name="valider"/>
			<input class="bouton" type="reset" value="Annuler" name="annuler"/> 
		</p>
	</form>

</div>