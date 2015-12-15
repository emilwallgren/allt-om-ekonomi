<footer class="footer">
      <div class="container">
        <p class="text-muted">Copyright 2015 | Emil Wallgren (emil.wallgren@hotmail.se) | 
        	<?php if (isset($_SESSION['username'])) { ?>
        		<a href="<?= $this->url->create('anvandare/logout') ?>">Logga ut</a>
        	<?php } else { ?>
		        <a href="<?= $this->url->create('anvandare/login') ?>">Logga in</a> 
        <?php } ?>
      </div>
</footer>
