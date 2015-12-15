<div class="container">
	<div class="register">
	<?php if (isset($note)) {
		foreach ($note as $notification) {
			echo '<div class="alert alert-danger" role="alert">'.$notification.'</div>';
		}
	} 
				if (isset($success)) {
					echo '<div class="alert alert-success" role="alert">'.$success.'</div>';
				}
	?>
	<div class="col-md-6">
		<h1 class="headLineRegister">Registrera Användare</h1>
		<p>Registrera dig idag på Allt Om Ekonomi för att ta del av vår community. Tillsammans hjälper vi varann att bli bättre på ekonomi. Desto mer engagerad du är och ger bra svar samt ställer fler frågor, desto högre betyg/status får du av oss vilket du i sin tur kan använda till din egen fördel. För att registrera måste du fylla i formuläret till höger. För att sedan använda kontot måste du först bekräfta din email-adress via ett mail vi skickar ut till dig. Så fort du validerat din e-postadress kan du börja läsa, skriva och ta del av all kunskap och community på detta forum. Låter detta intressant? Tveka inte att signa upp dig och ta del i ett av Sveriges bästa ekonomiforum. Välkommen till Allt Om Ekonomi!</p>
	</div>
	<div class="col-md-4">
	<div id="registerForm">
		<?= $form ?>
		
		</div>
	</div>
	</div>
</div>