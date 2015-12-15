<?php

namespace Anax\Anvandare;
 
require "../vendor/phpmailer/phpmailer/PHPMailerAutoload.php"; 
/**
 * A controller for users and admin related events.
 *
 */
class AnvandareController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    
    public function initialize()
    {
    	$this->anvandare = new \Anax\Anvandare\Anvandare();
    	$this->anvandare->setDI($this->di);
    	$this->form = new \Mos\HTMLForm\CForm();
    	$this->session = new \Anax\Session\CSession();
    }

		public function registreraAction() 
		{		
			$this->theme->setTitle("Registrera");
			$note = Null;
			$success = Null;
			$form = $this->form->create([], [
			    'username' => [
			      'type'        => 'text',
			      'label'       => 'Användarnamn: (Sammansatt ord)',
			      'required'    => true,
			      'validation'  => ['not_empty'],
			    ],
			    'email' => [
			      'type'        => 'text',
			      'label'       => 'E-mail:',
			      'required'    => true,
			      'validation'  => ['not_empty', 'email_adress'],
			    ],
			    'password1' => [
			      'type'        => 'password',
			      'label'       => 'Lösenord',
			      'required'    => true,
			      'validation'  => ['not_empty'],
			    ],
			    'password2' => [
			      'type'        => 'password',
			      'label'       => 'Bekräfta lösenord:',
			      'required'    => true,
			      'validation'  => ['not_empty'],
			    ],
			    'submit' => [
			        'type'      => 'submit',
			        'callback'  => function($form) {
			            return true;
			        }
			    ],
			]);
			$checked = $form->check();
			
			if ($checked == true) {
			
				$username = htmlentities(strip_tags($this->form->Value('username')));
				$email = htmlentities(strip_tags($this->form->Value('email')));
				$password1 = htmlentities(strip_tags($this->form->Value('password1')));
				$password2 = htmlentities(strip_tags($this->form->Value('password2')));
				$baseUrlForFiles = $this->di->url->create('files');
				$gravatar1 = $baseUrlForFiles.'/kr.jpg';
				$gravatar2 = $baseUrlForFiles.'/euro.jpg';
				$gravatar3 = $baseUrlForFiles.'/dollar.jpg';
				$gravatars = array($gravatar1, $gravatar2, $gravatar3);
				$randomNumber = rand(0, 2);
				
				$usernameExists = $this->anvandare->findUser($username, 'username');
				$emailExists = $this->anvandare->findUser($email, 'email');
				$passwordValidates = false;
				$usernameValidates = false;
				$emailValidates = false;
				
				//Check if passwords match
				if ($password1 == $password2) {
					$passwordValidates = true;
					}
				else {
					//$this->url->get('anvandare/registrera');
					$note[] = 'Lösenorden matchar ej! <br>';	
				}
				
				//Check if username already exists
				if ($usernameExists != Null) {
						$note[] = "Användarnamnet är upptaget...Välj ett annat";
				}
				else {
					$usernameValidates = true;
				}
				
				//Check if email already exists
				if ($emailExists != Null) {
						$note[] = "Emailaddressen finns redan...Välj ett annat eller logga in om du redan har konto";
				}
				else {
					$emailValidates = true;
				}
								
				//IF all validates, insert data
				if ($emailValidates == true && $passwordValidates == true && $usernameValidates == true ) {
							
							//Hash identifier
							$identifier = hash("sha256", $username);
							
							//Sending mail
							$mail = new \PHPMailer();
							
							//$mail->SMTPDebug = 3;                               // Enable verbose debug output
							
							$mail->isSMTP();                                      // Set mailer to use SMTP
							$mail->Host = '';  							// Specify main and backup SMTP servers
							$mail->SMTPAuth = true;                               // Enable SMTP authentication
							$mail->Username = '';                 // SMTP username
							$mail->Password = '';                           // SMTP password
							$mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
							$mail->Port = 587;                                    // TCP port to connect to
							
							$mail->CharSet = 'UTF-8';
							$mail->setFrom('', 'Allt om Ekonomi!');
							$mail->addAddress($email);               							// Name is optional
							$mail->isHTML(true);                                  // Set email format to HTML
							
							$mail->Subject = 'Allt om Ekonomi | Validera Email';
							$mail->Body    = '<h1>Allt Om Ekonomi</h1><p>Grattis! Du har registrerat dig till <b>Allt om Ekonomi</b></p>
																<p>Innan du själv kan börja använda webbplatsen måste du först validera din email så att vi vet att du är du :-)</p>
																<p>Tryck på följande länk för att registrera dig: <a href="'.$this->di->url->create('anvandare/validera').'/'.$identifier.'">Validera din mailaddress här!</a></p>';
							$mail->AltBody = 'Allt Om Ekonomi!
																Grattis! Du har registrerat dig till Allt om Ekonomi
																Innan du själv kan börja använda webbplatsen måste du först validera din email så att vi vet att du är du :-)
																Tryck på följande länk för att registrera dig: <a href="'.$this->di->url->create('anvandare/validera').$identifier.'">Validera din mailaddress här!';
							
							if(!$mail->send()) {
							    $note[] = "Något gick fel :-( Prova att registrera igen...";
							    echo 'Mailer Error: ' . $mail->ErrorInfo;
							} else {
									$this->anvandare->createUser('anvandare', [
										'username' 	=> $username,
										'email'			=> $email,
										'password' => hash("sha256", $password1),
										'profileimage' => $gravatars[$randomNumber],
										'identifier' => $identifier,
									]);
							    $success = "Grattis, du har registrerats! Vi har skickat ett mail till dig där du måste verifiera din e-post. Sen är det bara att börja använda webbplatsen :-)";
							}		
							
							
				}

			}
			
			$this->views->add('register/form', ['form' => $form->getHTML(), 'note' => $note, 'success' => $success]);		
		}	
		
		
		
		public function loginAction() {
				$this->theme->setTitle("Login");
				$session = new \Anax\Session\CSession();
		
				$note = Null;
				$form = $this->form->create([], [
				    'username' => [
				      'type'        => 'text',
				      'label'       => 'Användarnamn:',
				      'required'    => true,
				      'validation'  => ['not_empty'],
				    ],
						'password' => [
				      'type'        => 'password',
				      'label'       => 'Lösenord',
				      'required'    => true,
				      'validation'  => ['not_empty'],
				    ],
				    'submit' => [
				        'type'      => 'submit',
				        'value'			=> 'Login',
				        'callback'  => function($form) {
				            return true;
				        }
				    ],
				]);
				$checked = $this->form->check();
				
				if ($checked == true) {
					$username = htmlentities(strip_tags($form->Value('username')));
					$password = htmlentities(strip_tags($form->Value('password')));
					$hashedPassword = hash("sha256", $password);
					$realPassword = $this->anvandare->findPassword($username);
					$validated = $this->anvandare->findValidation($username);
					
					if ($hashedPassword === $realPassword && $validated == 1) {
						$this->session->set('username', $username);
						$url = $this->di->url->create('profil/anvandare').'/'.$_SESSION['username'];
						$this->response->redirect($url);	
						
					}
					else {
						$note = "Inloggning misslyckades";
					}
				}
		
		$this->views->add('login/form', ['form' => $this->form->getHTML(), 'note' => $note]);	
		
		
		}
		
		public function logoutAction() {
			session_destroy();
			$url = $this->di->url->create('anvandare/login');
			$this->response->redirect($url);	
		}
		
		public function valideraAction($identifier) {
			$this->theme->setTitle("Validerad");
		
			$validated = $this->anvandare->findIdentifier($identifier);
			
			if ($identifier == $validated) {
					$this->anvandare->validateUser('anvandare', [
					'validated' => 1,]);
					$note = TRUE;
					$this->views->add('register/validera', ['note' => $note]);	
			}
			else {
					$note = FALSE;
					$this->views->add('register/validera', ['note' => $note]);	
			}
		}
		
		public function indexAction() {
			$this->theme->setTitle("Användare");
			$users = $this->anvandare->selectAllUsers();
			$this->views->add('anvandare/index', ['users' => $users]);
		}
		
}