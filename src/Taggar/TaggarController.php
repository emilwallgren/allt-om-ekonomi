<?php

namespace Anax\Taggar;
 

/**
 * A controller for users and admin related events.
 *
 */
class TaggarController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    
    public function initialize()
    {
    	$this->anvandare = new \Anax\Anvandare\Anvandare();
    	$this->anvandare->setDI($this->di);
    	$this->profil = new \Anax\Profil\Profil();
    	$this->profil->setDI($this->di);
    	$this->fragor = new \Anax\Fragor\Fragor();
    	$this->fragor->setDI($this->di);
    	$this->login = new \Anax\Login\Login();
    	$this->login->setDI($this->di);
    	$this->taggar = new \Anax\Taggar\Taggar();
    	$this->taggar->setDI($this->di);
    }
    
    public function indexAction() {
    	$this->theme->setTitle("Taggar");
    	$taggar = $this->taggar->getAllTaggar();
    	$this->views->add('taggar/index', ['taggar' => $taggar]);
    }
    
    public function taggAction($tagg) {
    
    	//$eTagg = utf8_decode($tagg);
    	$eTagg = rawurldecode($tagg);
    	$this->theme->setTitle("Tagg - ".$eTagg);
    	$fragor = $this->taggar->getQuestionByTagg($eTagg);
    	$this->views->add('taggar/taggar', ['fragor' => $fragor]);
    }
}