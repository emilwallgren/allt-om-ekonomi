<div class="container changeImage">
<?php if (isset($output)) { ?>
	<output><?=$output?></output>
<?php } ?>

	<h1>Nuvarande profilbild</h1>
	<div class="backgroundImage" style="background-image: url(<?= $userImage ?>);"></div>
	<form method="POST" enctype="multipart/form-data" action="<?= $this->url->create('profil/bytbild') ?>/<?= $_SESSION['username'] ?>">
			<div class="form-group">
		    <input type="file" name="profileImage" value=""/>
		    <input type="submit" class="btn btn-default" value="Byt Profilbild"/>
	    </div>
	</form>
</div>