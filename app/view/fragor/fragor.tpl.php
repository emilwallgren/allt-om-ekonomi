<div class="container fragor">
	<h1>Frågor</h1>
		<?php foreach ($fragor as $fraga) { ?>
			<div class="row">
				<a href="<?= $this->url->create('fragor/fraga'); ?>/<?= $fraga->id; ?>">
					<h3><?= $fraga->titel; ?></h3>
				</a>
				<p><b>Antal svar:</b> <?= $fraga->antal_svar ?> <b>Rank:</b> <?= $fraga->fragor_votes; ?></p>
			</div>
	<?php	} ?>
</div>