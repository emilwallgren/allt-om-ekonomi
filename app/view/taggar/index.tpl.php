<div class="container taggarSidan">
	<h1>Taggar</h1>
	<div class="taggContainer">
	<?php foreach ($taggar as $tagg) {?>
		<?php $url = $this->url->create('taggar/tagg').'/'.rawurlencode($tagg->tagg); ?>
		<a href="<?= $url ?>"><?= $tagg->tagg ?></a>
	<?php } ?>
	</div>
</div>