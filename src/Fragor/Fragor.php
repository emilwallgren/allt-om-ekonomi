<?php

namespace Anax\Fragor;
 
/**
 * A controller for users and admin related events.
 *
 */
class Fragor extends \Anax\MVC\CDatabaseModel
{		
		
		public function createFraga($table, $values) {
			 $keys   = array_keys($values);
			 $values = array_values($values);
			
		   $this->db->insert(
		       $table,
		       $keys
		   );
			
			  $res = $this->db->execute($values);
			
			  $this->id = $this->db->lastInsertId();
			
			  return $res;
		}
		
		public function readAllFraga() {
			$this->db->select('*')->from('fragor');
				
			$this->db->execute();
			$fetched = $this->db->fetchAll();
			return $fetched;
		}
	
		
		public function readFragaFromUser($userID) {
			
			$this->db->select('*')->from('fragor')->where('anvandare_id = ?');
			$this->db->execute([$userID]);
			$fetched = $this->db->fetchAll();
			return $fetched;
		}
		
		public function findUserToFraga($questionID) {
			$this->db->select('*')->from('anvandare')->join('fragor', 'anvandare.id = anvandare_id')->where('fragor.id = ?');
			$this->db->execute([$questionID]);
			$fetched = $this->db->fetchInto($this);
			return $fetched;
		}
		
		public function lastInsertId() {
			return $this->db->lastInsertId();
		}
		
		public function createComment($table, $values) {
			 $keys   = array_keys($values);
			 $values = array_values($values);
			
		   $this->db->insert(
		       $table,
		       $keys
		   );
		   
			  $res = $this->db->execute($values);
			
			  $this->id = $this->db->lastInsertId();
			
			  return $res;
		}
		
		public function findCommentsByQuestionId($questionID) {
				$this->db->select('*')->from('kommentarer')->join('anvandare', 'anvandare.id = kommentarer.anvandare_id')->where('kommentarer.fragor_id = ?')->andWhere('kommentarer.svar_id IS NULL');
				$this->db->execute([$questionID]);
				$fetched = $this->db->fetchAll();
				return $fetched;
				
		}
		
		public function createAnswer($table, $values) {
			 $keys   = array_keys($values);
			 $values = array_values($values);
			
		   $this->db->insert(
		       $table,
		       $keys
		   );
			
			  $res = $this->db->execute($values);
			
			  $this->id = $this->db->lastInsertId();
			
			  return $res;
		}
		
		public function findAnswerAmount($question_id) {
			$this->db->select('antal_svar')->from('fragor')->where('id = ?');
			$this->db->execute([$question_id]);
			$fetched = $this->db->fetchInto($this);
			return $fetched;
			
		}
		
		public function updateQuestion($table, $fraga_id, $values) {
			 		$keys   = array_keys($values);
			    $values = array_values($values);
			 
			    // Its update, remove id and use as where-clause
			    unset($keys['id']);
			    $values[] = $fraga_id;
			 
			    $this->db->update(
			       	$table,
			        $keys,
			        "id = ?"
			    );
			 
			    $this->db->execute($values);
			 
		}
		
		public function findAnswersByQuestionId($questionID, $orderBy) {
		
			if ($orderBy == 0) {
				$this->db->select('*')->from('svar')->join('anvandare', 'anvandare.id = svar.anvandare_id')->where('svar.fragor_id = ?');
				$this->db->execute([$questionID]);
				$fetched = $this->db->fetchAll();
				return $fetched;
			}
			if ($orderBy == 1) {
				$this->db->select('*')->from('svar')->join('anvandare', 'anvandare.id = svar.anvandare_id')->where('svar.fragor_id = ?')->orderBy('svar_votes DESC');
				$this->db->execute([$questionID]);
				$fetched = $this->db->fetchAll();
				return $fetched;
			}
		}
		
		public function createCommentToAnswer($table, $values) {
			 $keys   = array_keys($values);
			 $values = array_values($values);
			
		   $this->db->insert(
		       $table,
		       $keys
		   );
			
			  $res = $this->db->execute($values);
			
			  $this->id = $this->db->lastInsertId();
			
			  return $res;
		}
		
		public function findCommentsToAnswer($questionID) {
			$this->db->select('*')->from('kommentarer')->join('anvandare', 'anvandare.id = kommentarer.anvandare_id')->join('svar', 'svar.id_svar = kommentarer.svar_id')->where('kommentarer.fragor_id = ?');
			$this->db->execute([$questionID]);
			$fetched = $this->db->fetchAll();
			return $fetched;
		}
		
		public function likeOrDislikeComment($table, $kommentar_id, $values) {
		
			 				$keys   = array_keys($values);
			 		    $values = array_values($values);
			 		 
			 		    // Its update, remove id and use as where-clause
			 		    unset($keys['kommentar_id']);
			 		    $values[] = $kommentar_id;
			 		 
			 		    $this->db->update(
			 		       	$table,
			 		        $keys,
			 		        "kommentar_id = ?"
			 		    );
			 		 
			 		    $this->db->execute($values);
			 		}
			
			public function findVotes($id){
				$this->db->select('votes')->from('kommentarer')->where('kommentar_id = ?');
				$this->db->execute([$id]);
				$fetched = $this->db->fetchInto($this);
				
				return $fetched;
			}
			
			public function insertVoter($table, $values) {
				
			  		 $keys   = array_keys($values);
			  		 $values = array_values($values);
			  		 	
			  		 $this->db->insert(
			  		     $table,
			  		     $keys
			  		 );
			  		 	
	  		 	  $res = $this->db->execute($values);
	  		 	
	  		 	  $this->id = $this->db->lastInsertId();
	  		 	
	  		 	  return $res;
			}
			
			public function updateVoter($table, $kommentar_id, $values) {
			
				 				$keys   = array_keys($values);
				 		    $values = array_values($values);
				 		 
				 		    // Its update, remove id and use as where-clause
				 		    unset($keys['comment_id_vote']);
				 		    $values[] = $kommentar_id;
				 		 
				 		    $this->db->update(
				 		       	$table,
				 		        $keys,
				 		        "comment_id_vote = ?"
				 		    );
				 		 
				 		    $this->db->execute($values);
				 		}
			
			public function findOutIfUserVoted($comment_id, $userID) {
				$this->db->select('vote')->from('votes')->where('comment_id_vote = ?')->andWhere('user_id = ?');
				$this->db->execute([$comment_id, $userID]);
				$fetched = $this->db->fetchInto($this);
				return $fetched;
			}
			
			//Answers
			
			public function likeOrDislikeAnswer($table, $answer_id, $values) {
			
				 				$keys   = array_keys($values);
				 		    $values = array_values($values);
				 		 
				 		    // Its update, remove id and use as where-clause
				 		    unset($keys['id_svar']);
				 		    $values[] = $answer_id;
				 		 
				 		    $this->db->update(
				 		       	$table,
				 		        $keys,
				 		        "id_svar = ?"
				 		    );
				 		 
				 		    $this->db->execute($values);
				 		}
				
				public function findVotesToAnswer($id){
					$this->db->select('svar_votes')->from('svar')->where('id_svar = ?');
					$this->db->execute([$id]);
					$fetched = $this->db->fetchInto($this);
					
					return $fetched;
				}
				
				
				public function updateVoterToAnswer($table, $kommentar_id, $values) {
				
					 				$keys   = array_keys($values);
					 		    $values = array_values($values);
					 		 
					 		    // Its update, remove id and use as where-clause
					 		    unset($keys['svar_id_vote']);
					 		    $values[] = $kommentar_id;
					 		 
					 		    $this->db->update(
					 		       	$table,
					 		        $keys,
					 		        "svar_id_vote = ?"
					 		    );
					 		 
					 		    $this->db->execute($values);
					 		}
				
				
				public function findOutIfUserVotedAnswer($answer_id, $userID) {
					$this->db->select('svar_vote')->from('svar_votes')->where('svar_id_vote = ?')->andWhere('svar_user_id = ?');
					$this->db->execute([$answer_id, $userID]);
					$fetched = $this->db->fetchInto($this);
					return $fetched;
				}
				
				//Questions
				
				public function likeOrDislikeQuestion($table, $question_id, $values) {
				
					 				$keys   = array_keys($values);
					 		    $values = array_values($values);
					 		 
					 		    // Its update, remove id and use as where-clause
					 		    unset($keys['id']);
					 		    $values[] = $question_id;
					 		 
					 		    $this->db->update(
					 		       	$table,
					 		        $keys,
					 		        "id = ?"
					 		    );
					 		 
					 		    $this->db->execute($values);
					 		}
					
					public function findVotesToQuestion($id){
						$this->db->select('fragor_votes')->from('fragor')->where('id = ?');
						$this->db->execute([$id]);
						$fetched = $this->db->fetchInto($this);
						
						return $fetched;
					}
					
					
					public function updateVoterToQuestion($table, $kommentar_id, $values) {
					
						 				$keys   = array_keys($values);
						 		    $values = array_values($values);
						 		 
						 		    // Its update, remove id and use as where-clause
						 		    unset($keys['fragor_id_vote']);
						 		    $values[] = $kommentar_id;
						 		 
						 		    $this->db->update(
						 		       	$table,
						 		        $keys,
						 		        "fragor_id_vote = ?"
						 		    );
						 		 
						 		    $this->db->execute($values);
						 		}
					
					
					public function findOutIfUserVotedQuestion($answer_id, $userID) {
						$this->db->select('fragor_vote')->from('fragor_votes')->where('fragor_id_vote = ?')->andWhere('fragor_user_id = ?');
						$this->db->execute([$answer_id, $userID]);
						$fetched = $this->db->fetchInto($this);
						return $fetched;
					}
					
					public function setOrUnsetAcceptedAnswer($answer_id, $table, $values) {
								$keys   = array_keys($values);
						    $values = array_values($values);
						 
						    // Its update, remove id and use as where-clause
						    unset($keys['id_svar']);
						    $values[] = $answer_id;
						 
						    $this->db->update(
						       	$table,
						        $keys,
						        "id_svar = ?"
						    );
						 
						    $this->db->execute($values);
						}
					
					public function findWriterToQuestion($question_id) {
						$this->db->select('anvandare_id')->from('fragor')->where('id = ?');
						$this->db->execute([$question_id]);
						$fetched = $this->db->fetchInto($this);
						return $fetched->anvandare_id;
					}
					
					public function findAcceptedStatus($answer_id) {
						$this->db->select('accepted')->from('svar')->where('id_svar = ?');
						$this->db->execute([$answer_id]);
						$fetched = $this->db->fetchInto($this);
						return $fetched->accepted;
					}
					
					public function findLatestQuestions() {
						$this->db->select('*')->from('fragor')->orderBy('created_at DESC')->limit(10);
						$this->db->execute();
						$fetched = $this->db->fetchAll();
						return $fetched;
					}
					
					public function findLatestAnswers() {
						$this->db->select('*')->from('svar')->orderBy('answer_created_at DESC')->limit(10);
						$this->db->execute();
						$fetched = $this->db->fetchAll();
						return $fetched;
					}
				
			
		
		}