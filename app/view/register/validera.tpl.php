<div class="container">
	<?php if (isset($note)) {
		if ($note = TRUE) { ?>
				 <div class="alert alert-success" role="alert">Grattis! Du har nu validerat din e-post. Logga in och börja använda webbplatsen :-)</div>
		<?php }
	} else { ?>
				<div class="alert alert-danger" role="alert">Något gick fel :-( Prova igen</div>
	<?php }?>
</div>