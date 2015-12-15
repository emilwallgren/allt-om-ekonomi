<div class="container bytlosen">
			<div class="row">
				<h1>Byt Lösenord</h1>
				<div class="col-md-12">
					<form method="post" action="<?= $this->url->create('profil/bytlosenord') ?>/<?= $_SESSION['username'] ?>">
						<div class="form-group">
							<label for="losenord1">Nuvarande Lösenord</label>
							<input type="password" class="form-control" name="losenord1" />
						</div>
						<div class="form-group">
							<label for="losenord2">Skriv in nytt lösenord</label>
							<input type="password" class="form-control" name="losenord2" />
						</div>
						<div class="form-group">
							<label for="losenord3">Repetera nytt lösenord</label>
							<input type="password" class="form-control" name="losenord3" /><br>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-default" name="losenordSubmit" value="Byt Lösenord" />
						</div>
					</form>
				</div>
		</div>
</div>