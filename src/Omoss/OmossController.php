<?php

namespace Anax\Omoss;
 

/**
 * A controller for users and admin related events.
 *
 */
class OmossController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    
    public function initialize() {
    	
    }
    
		public function indexAction() {
			$this->theme->setTitle('Om Oss');
			$this->views->add('omoss/index');	
			
		}
		
}