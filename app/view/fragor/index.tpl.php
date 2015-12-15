<div class="container skrivfraga">
	<h1>Skriv ny fråga</h1>
	<form method="post" action="<?= $this->url->create('fragor/adddb') ?>/<?= $_SESSION['username'] ?>">
		<div class="form-group">
			<label for="rubrikFraga">Rubrik</label><br>
			<input type="text" class="form-control" name="rubrikFraga" /><br>
		</div>
		<div class="form-group">
			<label for="taggar">Taggar (separera med , )</label><br>
			<input type="taggar" class="form-control" name="taggar" /><br>
		</div>
		<div class="form-group">
			<label for="fraga">Fråga</label><br>
			<textarea class="form-control" name="fraga"></textarea><br>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-default" name="skickaFraga" value="Skicka" />
		</div>
	</form>
</div>