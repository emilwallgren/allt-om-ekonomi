<?php

namespace Anax\Login;
 
/**
 * A controller for users and admin related events.
 *
 */
class Login implements \Anax\DI\IInjectionAware
{		
	use \Anax\DI\TInjectable;
	
	public function setRestriction() {
		if (!isset($_SESSION['username'])) {
			$loginSite = $this->url->create('anvandare/login');
			die("<h1>Oj då...</h1><p>Du måste vara inloggad för att ta del av denna sidan..<br><br><a href=".$loginSite.">Logga in</a> och försök igen...</p>");
		}
	}
		
}