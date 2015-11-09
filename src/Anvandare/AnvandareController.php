<?php

namespace Anax\Anvandare;
 
/**
 * A controller for users and admin related events.
 *
 */
class AnvandareController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    
    public function initialize()
    {
      $form = new \Mos\HTMLForm\CForm();
      $this->register = new \Anax\Anvandare\Anvandare();
      $this->register->setDI($this->register);
    }

		public function registreraAction() 
		{
			$form = new \Mos\HTMLForm\CForm();
			$this->theme->setTitle("Registrera");
			
			$registerForm = $form->create([], [
			    'username' => [
			      'type'        => 'text',
			      'label'       => 'Användarnamn',
			      'required'    => true,
			      'validation'  => ['not_empty'],
			    ],
			    'email' => [
			      'type'        => 'text',
			      'label'       => 'Email:',
			      'required'    => true,
			      'validation'  => ['not_empty', 'email_adress'],
			    ],
			    'password' => [
			      'type'        => 'password',
			      'label'       => 'Lösenord',
			      'required'    => true,
			      'validation'  => ['not_empty'],
			    ],
			    'repeat-password' => [
			      'type'        => 'password',
			      'label'       => 'Repetera Lösenord:',
			      'required'    => true,
			      'validation'  => ['not_empty'],
			    ],
			    'submit' => [
			        'type'      => 'submit',
			        'value'			=> 'Registrera',
			        'callback'  => function($form) {
 		
			          return true;
			        }
			    ]
			]);
			
			// Check the status of the form
			$status = $form->Check();
			 
			// What to do if the form was submitted?
			if($status === true) 
			{
				
				$username = $form->Value('username');
				$email = $form->Value('email');
				$password = $form->Value('password');
				$repeatPassword = $form->Value('repeat-password');
				$testPassword = false;
				$testUsername = false;
				$userNameExists = $this->register->findUser($username);
				
				
					// Testa om Lösenorden matchar
					if ($password == $repeatPassword) 
					{
						 $testPassword = true;
					}
					else {
						echo("Lösenorden matchar inte");
					}
					
					//Testa om användarnamnet redan finns
					if ($userNameExists = NULL) 
					{
						$testUsername = true;
					}
					else {
						echo("Användarnamnet existerar redan. Välj ett annat...");
					}
					
					//Om allt verkar funka, sätt in i databasen
					if ($testPassword = false || $testUsername = false) {
						echo("Något gick fel!");
					}
					else {
						$this->register->createUser('aoe_anvandare', [
								'username' => $username,
						]);
					}
					
			}
			
			$this->views->add('register/index', ['registerForm' => $registerForm->getHTML()]);
		}		
		
		
		
}