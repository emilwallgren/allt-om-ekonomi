<?php

namespace Anax\Profil;
 

/**
 * A controller for users and admin related events.
 *
 */
class ProfilController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    //use \Aura\Filter\FilterFactory;
    
    public function initialize()
    {
    	$this->anvandare = new \Anax\Anvandare\Anvandare();
    	$this->anvandare->setDI($this->di);
    	$this->profil = new \Anax\Profil\Profil();
    	$this->profil->setDI($this->di);
    	$this->fragor = new \Anax\Fragor\Fragor();
    	$this->fragor->setDI($this->di);
    	$this->taggar = new \Anax\Taggar\Taggar();
    	$this->taggar->setDI($this->di);
    }

		public function anvandareAction($user) {
			
			$vUser = $this->profil->validateInput($user);
			$userImage = $this->anvandare->findImage($vUser);
			$userID = $this->anvandare->findIdByUsername($user);
			$fragor = $this->fragor->readFragaFromUser($userID);
			$taggar = $this->taggar->getTaggarByUser($vUser);
			$id = $this->anvandare->findIdByUsername($vUser);
			$svar = $this->profil->relateAnswerToUser('svar', $id);
			$comments = $this->profil->findCommentsMadeByUser($userID);
			$voteAmount = $this->anvandare->findAmountOfVotesMadeByUser($userID);
			$points1 = $this->anvandare->findPointsByUser($userID);
			$points2 = $this->anvandare->findVotePoints($userID);
			$votes = $points1 + $points2;
			
			$this->views->add('profil/index', ['user' => $vUser, 'userImage' => $userImage, 'fragor' => $fragor, 'taggar' => $taggar, 'allaSvar' => $svar, 'votes' => $votes, 'voteAmount' => $voteAmount, 'comments' => $comments]);	
			
			$this->theme->setTitle($vUser);
			
		}
		
		public function bildAction($user) {
			
			$this->theme->setTitle("Byt Profilbild");
			
			$vUser = $this->profil->validateInput($user);
			$userImage = $this->anvandare->findImage($vUser);
			
			$this->views->add('profil/profileimage', ['user' => $vUser, 'userImage' => $userImage]);
		}
		
		public function bytbildAction($user) {
			
			$filter_factory = new \Aura\Filter\FilterFactory();
			$filter = $filter_factory->newValueFilter();
			//$filter = $filter_factory->newSubjectFilter();
			//$vUser = $this->profil->validateInput($user);
			$vUser = $filter->sanitize($user, 'alnum');
			if ($vUser) {
				$vUser = $user;
			}
			else {
				echo "Användarnamnet är inte alfanumeriskt!";
			}
		
			$path = ANAX_INSTALL_PATH.'/webroot/files';
			$realPath = $this->url->create('files');
			$storage = new \Upload\Storage\FileSystem($path);
			$file = new \Upload\File('profileImage', $storage);
			
			// Optionally you can rename the file on upload
			$new_filename = uniqid();
			$file->setName($new_filename);
			$fileName = $file->getNameWithExtension();
			
			$newPath = $realPath.'/'.$fileName;
			
			// Validate file upload
			// MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
			$file->addValidations(array(
			    // Ensure file is of type "image/png"
			    new \Upload\Validation\Mimetype(array('image/png', 'image/jpg', 'image/jpeg', 'image/gif')),
			
			    //You can also add multi mimetype validation
			    //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))
			
			    // Ensure file is no larger than 5M (use "B", "K", M", or "G")
			    new \Upload\Validation\Size('5M')
			));
			
			// Access data about the file that has been uploaded
			$data = array(
			    'name'       => $file->getNameWithExtension(),
			    'extension'  => $file->getExtension(),
			    'mime'       => $file->getMimetype(),
			    'size'       => $file->getSize(),
			    'md5'        => $file->getMd5(),
			    'dimensions' => $file->getDimensions()
			);	
			$this->anvandare->updateImage('anvandare', $vUser, [
				'username' => $vUser,
				'profileimage' => $newPath,
			]);
			
			// Try to upload file
			try {
			    // Success!
			    $file->upload();
			    $url = $this->url->create('profil/bild').'/'.$vUser;
		
			    $this->flash->message('success', 'Bilden uppdaterades');
			    $output = $this->flash->output();
			    $userImage = $this->anvandare->findImage($vUser);
			    $this->views->add('profil/profileimage', ['output' => $output, 'userImage' => $userImage]);
			    
			   			    
			} catch (\Exception $e) {
			    // Fail!
			   // $errors = $file->getErrors();
			    $this->flash->message('danger', 'Något gick fel, ladda upp en png eller jpg-fil och försök igen...');
			    $output = $this->flash->output();
			    $userImage = $this->anvandare->findImage($vUser);
			    $this->views->add('profil/profileimage', ['output' => $output, 'userImage' => $userImage]);
			}
		}
		
		
		public function losenordAction($user) {
			
			$this->theme->setTitle("Byt Profilbild");
			
			$vUser = $this->profil->validateInput($user);
			
			$this->views->add('profil/losenord', ['user' => $vUser]);
		}
		
		
		public function bytlosenordAction($user) {
			
			$this->theme->setTitle("Byt Profilbild");
			
			$vUser = $this->profil->validateInput($user);
			$password = $this->anvandare->findPassword($vUser);
			
			$inputPassword1 = $this->profil->validateInput($_POST['losenord1']);
			$inputPassword2 = $this->profil->validateInput($_POST['losenord2']);
			$inputPassword3 = $this->profil->validateInput($_POST['losenord3']);
			
			if ($password = $inputPassword1) {
				
				if ($inputPassword2 == $inputPassword3) {
					$this->anvandare->updatePassword('anvandare', $vUser, [
						'username' => $vUser,
						'password' => hash("sha256", $inputPassword2)
					]);
					$url = $this->di->url->create('profil/losenord').'/'.$_SESSION['username'];
					$this->response->redirect($url);	
				}
			}
		}
		
		public function anvandranamnAction($user) {
			$this->views->add('profil/anvandarnamn');
		}
		
		public function updatenvandarnamnAction($user) {
			$filter_factory = new \Aura\Filter\FilterFactory();
			$filter = $filter_factory->newValueFilter();
			$vUser = $filter->sanitize($user, 'alnum');
			if ($vUser) {
				$vUser = $user;
			}
			
			$username = $_POST['username'];
			$usernameExists = $this->anvandare->findUser($username, 'username');
			$id = $this->anvandare->findIdByUsername($vUser);
			
			
			if ($usernameExists == Null) {
				$this->anvandare->updateUsername('anvandare', $id, [
					'username' => $username
					]);
					$usernameSession = $this->session->get('username');
					unset($usernameSession);
					$this->session->set('username', $username);
					$this->flash->message('success', 'Användarnamnet uppdaterades!');
					$output = $this->flash->output();
			}
			else {
				$this->flash->message('danger', 'Användarnamnet finns redan...');
				$output = $this->flash->output();
			}
		
			
			$this->views->add('profil/anvandarnamn', ['output' => $output]);
		}
		
		
		
}