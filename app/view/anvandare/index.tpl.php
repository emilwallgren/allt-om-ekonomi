<div class="container anvandare">
	<h1>Användare</h1>
	<?php foreach ($users as $user) { ?>
		<a href="<?= $this->url->create('profil/anvandare') ?>/<?= $user->username ?>">
		<div class="row">
			<div class="col-md-2 col-md-offset-4">
				<div class="backgroundImage" style="background-image: url(<?= $user->profileimage ?>);"></div>
			</div>
			<div class="col-md-3"><h3><?= $user->username ?></h3></div>
		</div>
		</a>
	<?php	} ?>
</div>