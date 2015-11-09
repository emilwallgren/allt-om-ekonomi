<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
      <a class="navbar-brand" href="<?= $this->url->create('') ?>">
        <img alt="Brand" src="<?= $this->url->create('') ?>/logo.png" style="width: 200px;">
      </a>
    </div>
    	<div id="navbar" class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
              <li><a href="<?= $this->url->create('') ?>">Hem</a></li>
              <li><a href="<?= $this->url->create('fragor') ?>">Frågor</a></li>
              <li><a href="<?= $this->url->create('taggar') ?>">Taggar</a></li>
              <li><a href="<?= $this->url->create('anvandare') ?>">Användare</a></li>
              <li><a href="<?= $this->url->create('omoss') ?>">Om Oss</a></li>
              <li><a href="<?= $this->url->create('anvandare/registrera') ?>">Registrera</a></li>
              <li><a href="<?= $this->url->create('profil') ?>">Profil</a></li>
            </ul>
  		</div>
  	</div>
</nav>
