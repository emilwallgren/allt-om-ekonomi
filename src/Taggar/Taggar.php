<?php

namespace Anax\Taggar;
 
/**
 * A controller for users and admin related events.
 *
 */
class Taggar extends \Anax\MVC\CDatabaseModel
{		
		
		public function separateInput($input) {
			$taggar = explode(',', $input);
			return $taggar;
		}
		
		public function createTaggar($table, $values) {
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
		
		public function getTaggarByUser($user) {
			$this->db->select('*')->from('taggar')->join('anvandare', 'anvandare.id = taggar.anvandare_id')->where('anvandare.username = ?');
			$this->db->execute([$user]);
			$fetched = $this->db->fetchAll();
			return $fetched;
		}
		
		public function getQuestionByTagg($tagg) {
			$this->db->select('*')->from('fragor')->join('taggar', 'taggar.fragor_id = fragor.id')->where('taggar.tagg = ?');
			$this->db->execute([$tagg]);
			$fetched = $this->db->fetchAll();
			return $fetched;
		}
		
		public function getTaggByQuestion($userID) {
			$this->db->select('*')->from('taggar')->join('fragor', 'fragor.id = taggar.fragor_id')->where('fragor.id = ?');
			$this->db->execute([$userID]);
			$fetched = $this->db->fetchAll();
			return $fetched;
		}
		
		public function getAllTaggar() {
			$this->db->select('*')->from('taggar');
			$this->db->execute();
			$fetched = $this->db->fetchAll();
			return $fetched;
		}
		
		public function getAllTaggarWithLimit() {
			$this->db->select('*')->from('taggar')->orderBy('id DESC')->limit(15);
			$this->db->execute();
			$fetched = $this->db->fetchAll();
			return $fetched;
		}
		
		
		}