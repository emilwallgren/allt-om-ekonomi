<div class="container profil">
	<div class="row">
		<?php 
			if (isset($_SESSION['username'])) {
				if ($user == $_SESSION['username']) { ?>
					<div class="col-md-2">
						<h3>Inställningar</h3>
						<ul>
							<li>
								<a href="<?= $this->url->create('profil/anvandranamn') ?>/<?= $_SESSION['username'] ?>">Byt användarnamn</a>
							</li>
							<li>
								<a href="<?= $this->url->create('profil/bild') ?>/<?= $_SESSION['username'] ?>">Byt profilbild</a>
							</li>
							<li>
								<a href="<?= $this->url->create('profil/losenord') ?>/<?= $_SESSION['username'] ?>">Ändra lösenord</a>
							</li>
							<li>
								<a href="<?= $this->url->create('fragor/skriv') ?>/<?= $_SESSION['username'] ?>">Skriv fråga</a>
							</li>
						</ul>
					</div>
					<div class="col-md-8">
			<?php } }
				if (!isset($_SESSION['username']) || $_SESSION['username'] !== $user) { ?>
					<div class="col-md-12">
				<?php } ?>
						<div class="circle" style="background-image:url(<?= $userImage ?>)" alt="<?= $user ?>" /></div>
						<h1><?= $user ?></h1>
						<h3>Poäng: <span class="votes"><?= $votes ?></span> - 
						<?php if ($votes <= 10) { ?>
							Nybörjare
						<?php } ?>
						<?php if ($votes > 10 && $votes <= 20) { ?>
							Ekonomistudent
						<?php } ?>
						<?php if ($votes > 20 && $votes <= 30) { ?>
							Ekonom
						<?php } ?>
						<?php if ($votes > 30 && $votes <= 40) { ?>
							Erfaren Ekonom
						<?php } ?>
						<?php if ($votes > 40) { ?>
							Chefsekonom
						<?php } ?>
						</h3>
						<h5>Har röstat <span class="amount"><?= $voteAmount ?></span> gånger</h5>
					</div>
	</div>
	
	
	<div class="row info">
	
		<div class="col-md-3">
		<h3>Ställda Frågor:</h3>
		<?php foreach ($fragor as $fraga) { ?>
			<a href="<?= $this->url->create('fragor/fraga') ?>/<?= $fraga->id ?>">
				<h5><?= $fraga->titel ?></h5>
			</a>
		<?php } ?>
		</div>
		<div class="col-md-3">
			<h3>Besvarade Frågor</h3>
			<?php foreach ($allaSvar as $svar) { ?>
				<a href="<?= $this->url->create('fragor/fraga') ?>/<?= $svar->fragor_id ?>">
					<h5><?= $svar->titel ?></h5>
				</a>
			<?php } ?>
			</div>
			<div class="col-md-3">
				<h3>Skrivna Kommentarer</h3>
				<?php foreach ($comments as $comment) { ?>
					<a href="<?= $this->url->create('fragor/fraga') ?>/<?= $comment->fragor_id ?>">
						<h5><?= $comment->kommentar ?></h5>
					</a>
				<?php } ?>
				</div>
			
			<div class="col-md-3">
			<h3>Skapade Taggar:</h3>
			<?php foreach ($taggar as $tagg) { ?>
				<a href="<?= $this->url->create('taggar/tagg') ?>/<?= $tagg->tagg ?>" class="tagg"><?= $tagg->tagg ?></a>
			<?php } ?>
			</div>
		</div>
			
	</div>
</div>