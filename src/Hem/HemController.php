<?php

namespace Anax\Hem;
 

/**
 * A controller for users and admin related events.
 *
 */
class HemController implements \Anax\DI\IInjectionAware
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
    	$this->theme->setTitle("Hem");
    	$taggar = $this->taggar->getAllTaggarWithLimit();
    	$fragor = $this->fragor->findLatestQuestions();
    	$svar = $this->fragor->findLatestAnswers();
    	$anvandare = $this->anvandare->findLatestRegisteredUsers();
    	$this->views->add('firstpage/index', ['taggar' => $taggar, 'fragor' => $fragor, 'allaSvar' => $svar, 'allaAnvandare' => $anvandare]);
    }
    
  }