<div class="container hem">
	<div class="jumbotron" style="background-image: url('<?= $this->url->create('') ?>/img/money.jpg');">
	  <h1>WGTOTW - Allt om ekonomi</h1>
	  <p>Där frågor får svar...</p>
	  <p><a class="btn btn-primary btn-lg" href="<?= $this->url->create('anvandare/registrera') ?>" role="button">Skapa konto</a></p>
	</div>
	<div class="row">
		<div class="col-md-6">
			<h2>Senaste Frågor</h2>
			<?php foreach ($fragor as $fraga) { ?>
				<a href="<?= $this->url->create('fragor/fraga') ?>/<?= $fraga->id ?>"><h5><?= substr($fraga->titel, 0, 100) ?></h5></a>
			<?php } ?>
		</div>
		<div class="col-md-6">
			<h2>Senaste Svar</h2>
			<?php foreach ($allaSvar as $svar) { ?>
				<a href="<?= $this->url->create('fragor/fraga') ?>/<?= $svar->fragor_id ?>"><h5><?= substr($svar->svar, 0, 100) ?></h5></a>
			<?php } ?>
		</div>
		<div class="col-md-6">
			<h2>Nya Användare</h2>
			<?php foreach ($allaAnvandare as $anvandare) { ?>
				<a href="<?= $this->url->create('profil/anvandare') ?>/<?= $anvandare->username ?>"><h5><?= $anvandare->username ?></h5></a>
			<?php } ?>
		</div>
		<div class="col-md-6">
			<h2>Senaste Taggar</h2>
			<?php foreach ($taggar as $tagg) { ?>
				<a href="<?= $this->url->create('taggar/tagg') ?>/<?= $tagg->tagg ?>" class="tagg"><?= $tagg->tagg ?></a>
			<?php } ?>
		</div>
	</div>
</div>
<div class="container-fluid hem">
	<div class="row">
		<div class="col-md-12">
				<h2>Om Oss</h2>
				<p>Allt om Ekonomi är skapad av Emil Wallgren som ett projekt för att lära sig MVC-ramverk i php inom Webbprogrammering på Blekinge Tekniska Universitet. Sidan är till för alla med ekonomiskt intresse som vill använda sig av ett forum för att lära sig saker relaterade till Marknadsföring, Redovisning och Nationalekonomi.
				
				Skriv frågor, tagga frågor, svara på frågor och hjälp varann. Det är denna sidans motto. Genom god gemenskap kan vi alla bli bättre på ekonomi. Vare sig det är privatekonomi eller att förstå hur hela sammanhanget hänger ihop. Desto mer aktivitet du bidrar med och upvotes du får, desto högre rykte och betyg får du av oss. Betyg du kan använda i CV och inom övriga arbetslivet. </p>
			</div>
		</div>
</div>