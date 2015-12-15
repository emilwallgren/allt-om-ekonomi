<div class="container">
	<div id="registerForm">
		<h1 class="headLineRegister">Registrera Användare:</h1>
		<p class="headLineRegister">Fyll i dina uppgifter!</p>
		<?php if (isset($note)) {
			echo '<p class="notification">'.$note.'</p>';
		} ?>
			<form method="post" action="<?= $this->url->create('anvandare/add') ?>">
				<label for="username">Användarnamn:</label>
				<input type="text" name="username" /><br>
				<label for="email">E-mail</label>
				<input type="text" name="email"/><br>
				<label for="password1">Lösenord</label>
				<input type="password" name="password1" /><br>
				<label for="password2">Bekräfta Lösenord</label>
				<input type="password" name="password2" /><br><br>
				<input type="submit" name="submitRegister" value="Registrera" />
			</form>
	</div>
</div>