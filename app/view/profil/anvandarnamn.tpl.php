<div class="container">
	<?php if (isset($output)) { ?>
		<output><?= $output ?></output>
	<?php } ?>
			<div class="row bytanvandarnamn">
				<h1>Byt Användarnamn</h1>
				<div class="col-md-12">
					<form method="post" action="<?= $this->url->create('profil/updatenvandarnamn') ?>/<?= $_SESSION['username'] ?>">
						<div class="form-group">
							<label for="username">Skriv in nytt användarnamn</label>
							<input type="text" class="form-control" name="username" />
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-default"name="usernameSubmit" value="Byt Användarnamn" />
						</div>
					</form>
				</div>
		</div>
</div>