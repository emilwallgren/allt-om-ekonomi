<div class="container">
	<div class="loginForm">
		<h1>Logga in</h1>
		<?php if (isset($note)) {
				echo '<div class="alert alert-danger" role="alert">'.$note.'</div>';
			} ?>
		<?= $form ?>		
	</div>
</div>