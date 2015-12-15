<?php

namespace Anax\Fragor;
 

/**
 * A controller for users and admin related events.
 *
 */
class FragorController implements \Anax\DI\IInjectionAware
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
    	$this->taggar = new \Anax\Taggar\Taggar();
    	$this->taggar->setDI($this->di);
    	$this->login = new \Anax\Login\Login();
    	$this->login->setDI($this->di);
    }
    
    public function skrivAction($user) {
    	$this->theme->setTitle("Skriv Fråga");
    	$this->views->add('fragor/index');		
    }
    
    
    public function adddbAction($user) {
    	
    	$vUser = $this->profil->validateInput($user);
    	$anvandarID = $this->anvandare->findIdByUsername($vUser);
    	
    	$titel = $this->profil->validateInput($_POST['rubrikFraga']);
    	$fraga = $this->profil->validateInput($_POST['fraga']);
    	$taggar = $this->taggar->separateInput($_POST['taggar']);
    	
    	$this->fragor->createFraga('fragor', [
    		'anvandare_id' => $anvandarID,
    		'fraga'	=> $fraga,
    		'titel'	=> $titel
    	]);
    	
    	$id = $this->fragor->lastInsertId();
    	
    	foreach ($taggar as $tagg) {
    		$this->taggar->createTaggar('taggar', [
    			'tagg' => trim($tagg),
    			'anvandare_id' => $anvandarID,
    			'fragor_id' => $id
    		]);
    	}
    	
    	$poang = $this->anvandare->findPointsByUser($anvandarID);
    	$nyPoang = intval($poang) + 10;
    	$this->anvandare->updatePointsToUser($anvandarID, 'anvandare', [
    		'poang' => $nyPoang
    	]);
    	
    	
    	$url = $this->url->create('fragor/skriv').'/'.$vUser;
    	$this->response->redirect($url);	
    	
    }
    
    public function indexAction() {
    	$this->theme->setTitle("Frågor");
    	$allaFragor = $this->fragor->readAllFraga();
    	$this->views->add('fragor/fragor', ['fragor'	=> $allaFragor]);
    }
    
    public function fragaAction($id, $orderBy = 0) {
    	$this->login->setRestriction();
    	$fraga = $this->profil->findByID('fragor', $id);
    	$user = $this->fragor->findUserToFraga($id);
    	$taggar = $this->taggar->getTaggByQuestion($id);
    	$writer = $_SESSION['username'];
    	$anvandarID = $this->anvandare->findIdByUsername($writer);
    	$kommentarer = $this->fragor->findCommentsByQuestionId($id);
    	$allaSvar = $this->fragor->findAnswersByQuestionId($id, $orderBy);
    	$kommentarerTillSvar = $this->fragor->findCommentsToAnswer($id);
    	$antalSvar = $this->fragor->findAnswerAmount($id);
    	
    	$this->theme->setTitle($fraga->titel);
    	
    	if (isset($_POST['postComment'])) {
    		$comment = $_POST['kommentar'];
    	
    		$this->fragor->createComment('kommentarer', [
    			'fragor_id' => $id,
    			'anvandare_id'	=> $anvandarID,
    			'kommentar'	=> $comment
    		], $id);
    		
    		$poang = $this->anvandare->findPointsByUser($anvandarID);
    		$nyPoang = intval($poang) + 3;
    		$this->anvandare->updatePointsToUser($anvandarID, 'anvandare', [
    			'poang' => $nyPoang
    		]);
    		
    		$url = $this->url->create('fragor/fraga').'/'.$id;
    		$this->response->redirect($url);	
    	}
    	
    	if (isset($_POST['postAnswer'])) {
    		$answer = $_POST['svar'];
    	
    		$this->fragor->createComment('svar', [
    			'fragor_id' => $id,
    			'anvandare_id'	=> $anvandarID,
    			'svar'	=> $answer
    		]);
    		
    		$poang = $this->anvandare->findPointsByUser($anvandarID);
    		$nyPoang = intval($poang) + 5;
    		$this->anvandare->updatePointsToUser($anvandarID, 'anvandare', [
    			'poang' => $nyPoang
    		]);
    		
    		
    		$nyttAntalSvar = intval($antalSvar->antal_svar) + 1;
    		$this->fragor->updateQuestion('fragor', $id, [
    			'antal_svar' => $nyttAntalSvar,
    		]);
    		
    		$url = $this->url->create('fragor/fraga').'/'.$id;
    		$this->response->redirect($url);	
    	}
    	
    	if (isset($_POST['postAnswerComment'])) {
    		$answerComment = $_POST['svarKommentar'];
    		$answerId = $_POST['svar_id'];
    	
    		$this->fragor->createComment('kommentarer', [
    			'fragor_id'	=> $id,
    			'svar_id' => $answerId,
    			'anvandare_id'	=> $anvandarID,
    			'kommentar'	=> $answerComment
    		]);
    		
    		$poang = $this->anvandare->findPointsByUser($anvandarID);
    		$nyPoang = intval($poang) + 2;
    		$this->anvandare->updatePointsToUser($anvandarID, 'anvandare', [
    			'poang' => $nyPoang
    		]);
    		
    		
    		$url = $this->url->create('fragor/fraga').'/'.$id;
    		$this->response->redirect($url);	
    	}
    	
    	
    	$this->views->add('fragor/fraga', ['fraga'	=> $fraga, 'user' => $user, 'taggar' => $taggar, 'kommentarer' => $kommentarer, 'allaSvar' => $allaSvar, 'kommentarerTillSvar' => $kommentarerTillSvar, 'anvandarID' => $anvandarID]);
    }
    
    public function commentlikeAction($id, $pageId) {
    	$writer = $_SESSION['username'];
    	$anvandarID = $this->anvandare->findIdByUsername($writer);
    	$userVote = $this->fragor->findOutIfUserVoted($id, $anvandarID);
    	
    	if (isset($userVote->vote)) {
    		if (intval($userVote->vote) == 1) {
    				
		    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
		    		$this->response->redirect($url);
		    	}
		    elseif (intval($userVote->vote) == 0) {
		    		$votes = $this->fragor->findVotes($id);
		    		$newVote = intval($votes->votes) + 1;
		    		
		    		$this->fragor->likeOrDislikeComment('kommentarer', $id, [
		    			'votes' => $newVote
		    		]);
		    		$this->fragor->updateVoter('votes', $id, [
		    			'vote' => 1
		    		]);
		    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
		    		$this->response->redirect($url);
		    	}
	    	 elseif (intval($userVote->vote) == -1) {
	    	 		$votes = $this->fragor->findVotes($id);
    	 			$newVote = intval($votes->votes) + 1;
    	 			
    	 			$this->fragor->likeOrDislikeComment('kommentarer', $id, [
    	 				'votes' => $newVote
    	 			]);
    	 			$this->fragor->updateVoter('votes', $id, [
    	 				'vote' => 0
    	 			]);
    	 			$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	 			$this->response->redirect($url);
	    	 		}
		    	 }
    	 else {
		    	$votes = $this->fragor->findVotes($id);
		    	$newVote = intval($votes->votes) + 1;
		    	
		    	$this->fragor->likeOrDislikeComment('kommentarer', $id, [
		    		'votes' => $newVote
		    	]);
		    	$this->fragor->insertVoter('votes', [
		    		'vote'	=> 1,
		    		'comment_id_vote'	=> $id,
		    		'user_id'	=> $anvandarID
		    	]);
		    	
		    	$url = $this->url->create('fragor/fraga').'/'.$pageId;
		    	$this->response->redirect($url);	
		   }
    }
    
    public function answerlikeAction($id, $pageId) {
    	$writer = $_SESSION['username'];
    	$anvandarID = $this->anvandare->findIdByUsername($writer);
    	$userVote = $this->fragor->findOutIfUserVotedAnswer($id, $anvandarID);
    	
    	if (isset($userVote->svar_vote)) {
    		if (intval($userVote->svar_vote) == 1) {
    				
    	    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    		$this->response->redirect($url);
    	    	}
    	    elseif (intval($userVote->svar_vote) == 0) {
    	    		$votes = $this->fragor->findVotesToAnswer($id);
    	    		$newVote = intval($votes->svar_votes) + 1;
    	    		
    	    		$this->fragor->likeOrDislikeAnswer('svar', $id, [
    	    			'svar_votes' => $newVote
    	    		]);
    	    		$this->fragor->updateVoterToAnswer('svar_votes', $id, [
    	    			'svar_vote' => 1
    	    		]);
    	    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    		$this->response->redirect($url);
    	    	}
    		 elseif (intval($userVote->svar_vote) == -1) {
    		 		$votes = $this->fragor->findVotesToAnswer($id);
    	 			$newVote = intval($votes->svar_votes) + 1;
    	 			
    	 			$this->fragor->likeOrDislikeAnswer('svar', $id, [
    	 				'svar_votes' => $newVote
    	 			]);
    	 			$this->fragor->updateVoterToAnswer('svar_votes', $id, [
    	 				'svar_vote' => 0
    	 			]);
    	 			$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	 			$this->response->redirect($url);
    		 		}
    	    	 }
    	 else {
    	    	$votes = $this->fragor->findVotesToAnswer($id);
    	    	$newVote = intval($votes->svar_votes) + 1;
    	    	
    	    	$this->fragor->likeOrDislikeAnswer('svar', $id, [
    	    		'svar_votes' => $newVote
    	    	]);
    	    	$this->fragor->insertVoter('svar_votes', [
    	    		'svar_vote'	=> 1,
    	    		'svar_id_vote'	=> $id,
    	    		'svar_user_id'	=> $anvandarID
    	    	]);
    	    	
    	    	$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    	$this->response->redirect($url);	
    	   }
    	
    }
    
    public function commentdislikeAction($id, $pageId) {
    			$writer = $_SESSION['username'];
    			$anvandarID = $this->anvandare->findIdByUsername($writer);
    			$userVote = $this->fragor->findOutIfUserVoted($id, $anvandarID);
    			
    			if (isset($userVote->vote)) {
    				if (intval($userVote->vote) == -1) {
    						
    			    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
    			    		$this->response->redirect($url);
    			    	}
    			    elseif (intval($userVote->vote) == 0) {
    			    		$votes = $this->fragor->findVotes($id);
    			    		$newVote = intval($votes->votes) - 1;
    			    		
    			    		$this->fragor->likeOrDislikeComment('kommentarer', $id, [
    			    			'votes' => $newVote
    			    		]);
    			    		$this->fragor->updateVoter('votes', $id, [
    			    			'vote' => -1
    			    		]);
    			    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
    			    		$this->response->redirect($url);
    			    	}
    				 elseif (intval($userVote->vote) == 1) {
    				 		$votes = $this->fragor->findVotes($id);
    			 			$newVote = intval($votes->votes) - 1;
    			 			
    			 			$this->fragor->likeOrDislikeComment('kommentarer', $id, [
    			 				'votes' => $newVote
    			 			]);
    			 			$this->fragor->updateVoter('votes', $id, [
    			 				'vote' => 0
    			 			]);
    			 			$url = $this->url->create('fragor/fraga').'/'.$pageId;
    			 			$this->response->redirect($url);
    				 		}
    				 	}
    			 else {
    			    	$votes = $this->fragor->findVotes($id);
    			    	$newVote = intval($votes->votes) - 1;
    			    	
    			    	$this->fragor->likeOrDislikeComment('kommentarer', $id, [
    			    		'votes' => $newVote
    			    	]);
    			    	$this->fragor->insertVoter('votes', [
    			    		'vote'	=> -1,
    			    		'comment_id_vote'	=> $id,
    			    		'user_id'	=> $anvandarID
    			    	]);
    			    	
    			    	$url = $this->url->create('fragor/fraga').'/'.$pageId;
    			    	$this->response->redirect($url);	
    			   }
    			
    		}
    					
    	    
    public function answerdislikeAction($id, $pageId) {
    	$writer = $_SESSION['username'];
    	$anvandarID = $this->anvandare->findIdByUsername($writer);
    	$userVote = $this->fragor->findOutIfUserVotedAnswer($id, $anvandarID);
    	
    	if (isset($userVote->svar_vote)) {
    		if (intval($userVote->svar_vote) == -1) {
    				
    	    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    		$this->response->redirect($url);
    	    	}
    	    elseif (intval($userVote->svar_vote) == 0) {
    	    		$votes = $this->fragor->findVotesToAnswer($id);
    	    		$newVote = intval($votes->svar_votes) - 1;
    	    		
    	    		$this->fragor->likeOrDislikeAnswer('svar', $id, [
    	    			'svar_votes' => $newVote
    	    		]);
    	    		$this->fragor->updateVoterToAnswer('svar_votes', $id, [
    	    			'svar_vote' => -1
    	    		]);
    	    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    		$this->response->redirect($url);
    	    	}
    		 elseif (intval($userVote->svar_vote) == 1) {
    		 		$votes = $this->fragor->findVotesToAnswer($id);
    	 			$newVote = intval($votes->svar_votes) - 1;
    	 			
    	 			$this->fragor->likeOrDislikeAnswer('svar', $id, [
    	 				'svar_votes' => $newVote
    	 			]);
    	 			$this->fragor->updateVoterToAnswer('svar_votes', $id, [
    	 				'svar_vote' => 0
    	 			]);
    	 			$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	 			$this->response->redirect($url);
    		 		}
    	    	 }
    	 else {
    	    	$votes = $this->fragor->findVotesToAnswer($id);
    	    	$newVote = intval($votes->svar_votes) - 1;
    	    	
    	    	$this->fragor->likeOrDislikeAnswer('svar', $id, [
    	    		'svar_votes' => $newVote
    	    	]);
    	    	$this->fragor->insertVoter('svar_votes', [
    	    		'svar_vote'	=> -1,
    	    		'svar_id_vote'	=> $id,
    	    		'svar_user_id'	=> $anvandarID
    	    	]);
    	    	
    	    	$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    	$this->response->redirect($url);	
    	   }
    }
    
    public function questionlikeAction($id, $pageId) {
    	$writer = $_SESSION['username'];
    	$anvandarID = $this->anvandare->findIdByUsername($writer);
    	$userVote = $this->fragor->findOutIfUserVotedQuestion($id, $anvandarID);
    	
    	if (isset($userVote->fragor_vote)) {
    		if (intval($userVote->fragor_vote) == 1) {
    				
    	    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    		$this->response->redirect($url);
    	    	}
    	    elseif (intval($userVote->fragor_vote) == 0) {
    	    		$votes = $this->fragor->findVotesToQuestion($id);
    	    		$newVote = intval($votes->fragor_votes) + 1;
    	    		
    	    		$this->fragor->likeOrDislikeQuestion('fragor', $id, [
    	    			'fragor_votes' => $newVote
    	    		]);
    	    		$this->fragor->updateVoterToQuestion('fragor_votes', $id, [
    	    			'fragor_vote' => 1
    	    		]);
    	    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    		$this->response->redirect($url);
    	    	}
    		 elseif (intval($userVote->fragor_vote) == -1) {
    		 		$votes = $this->fragor->findVotesToQuestion($id);
    	 			$newVote = intval($votes->fragor_votes) + 1;
    	 			
    	 			$this->fragor->likeOrDislikeQuestion('fragor', $id, [
    	 				'fragor_votes' => $newVote
    	 			]);
    	 			$this->fragor->updateVoterToQuestion('fragor_votes', $id, [
    	 				'fragor_vote' => 0
    	 			]);
    	 			$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	 			$this->response->redirect($url);
    		 		}
    	    	 }
    	 else {
    	    	$votes = $this->fragor->findVotesToQuestion($id);
    	    	$newVote = intval($votes->fragor_votes) + 1;
    	    	
    	    	$this->fragor->likeOrDislikeQuestion('fragor', $id, [
    	    		'fragor_votes' => $newVote
    	    	]);
    	    	$this->fragor->insertVoter('fragor_votes', [
    	    		'fragor_vote'	=> 1,
    	    		'fragor_id_vote'	=> $id,
    	    		'fragor_user_id'	=> $anvandarID
    	    	]);
    	    	
    	    	$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    	$this->response->redirect($url);	
    	   }
    	
    }
    
    
    public function questiondislikeAction($id, $pageId) {
    	$writer = $_SESSION['username'];
    	$anvandarID = $this->anvandare->findIdByUsername($writer);
    	$userVote = $this->fragor->findOutIfUserVotedQuestion($id, $anvandarID);
    	
    	if (isset($userVote->fragor_vote)) {
    		if (intval($userVote->fragor_vote) == -1) {
    				
    	    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    		$this->response->redirect($url);
    	    	}
    	    elseif (intval($userVote->fragor_vote) == 0) {
    	    		$votes = $this->fragor->findVotesToQuestion($id);
    	    		$newVote = intval($votes->fragor_votes) - 1;
    	    		
    	    		$this->fragor->likeOrDislikeQuestion('fragor', $id, [
    	    			'fragor_votes' => $newVote
    	    		]);
    	    		$this->fragor->updateVoterToQuestion('fragor_votes', $id, [
    	    			'fragor_vote' => -1
    	    		]);
    	    		$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    		$this->response->redirect($url);
    	    	}
    		 elseif (intval($userVote->fragor_vote) == 1) {
    		 		$votes = $this->fragor->findVotesToQuestion($id);
    	 			$newVote = intval($votes->fragor_votes) - 1;
    	 			
    	 			$this->fragor->likeOrDislikeQuestion('fragor', $id, [
    	 				'fragor_votes' => $newVote
    	 			]);
    	 			$this->fragor->updateVoterToQuestion('fragor_votes', $id, [
    	 				'fragor_vote' => 0
    	 			]);
    	 			$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	 			$this->response->redirect($url);
    		 		}
    	    	 }
    	 else {
    	    	$votes = $this->fragor->findVotesToQuestion($id);
    	    	$newVote = intval($votes->fragor_votes) - 1;
    	    	
    	    	$this->fragor->likeOrDislikeQuestion('fragor', $id, [
    	    		'fragor_votes' => $newVote
    	    	]);
    	    	$this->fragor->insertVoter('fragor_votes', [
    	    		'fragor_vote'	=> -1,
    	    		'fragor_id_vote'	=> $id,
    	    		'fragor_user_id'	=> $anvandarID
    	    	]);
    	    	
    	    	$url = $this->url->create('fragor/fraga').'/'.$pageId;
    	    	$this->response->redirect($url);	
    	   }
    	
    }
    
    public function setacceptedanswerAction($answer_id, $question_id) {
    	$writer = $_SESSION['username'];
    	$anvandarID = $this->anvandare->findIdByUsername($writer);
    	$questionWriter = $this->fragor->findWriterToQuestion($question_id);
    	$acceptedStatus = $this->fragor->findAcceptedStatus($answer_id);
    	
    	if ($questionWriter == $anvandarID) {
    		
    		if ($acceptedStatus == 0) {
    			$this->fragor->setOrUnsetAcceptedAnswer($answer_id, 'svar', [
    				'accepted' => 1
    			]);
    			$url = $this->url->create('fragor/fraga').'/'.$question_id;
    			$this->response->redirect($url);	
    		}
    		
    		if ($acceptedStatus == 1) {
    			$this->fragor->setOrUnsetAcceptedAnswer($answer_id, 'svar', [
    				'accepted' => 0
    			]);
    			$url = $this->url->create('fragor/fraga').'/'.$question_id;
    			$this->response->redirect($url);
    		}
    		
    	}
    	
    }
    
    
    
}