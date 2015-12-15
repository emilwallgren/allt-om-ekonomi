<?php

namespace Anax\Anvandare;
 
/**
 * A controller for users and admin related events.
 *
 */
class Anvandare extends \Anax\MVC\CDatabaseModel
{		
		
		public function findUser($user, $col)
		{
		    $this->db->select()
		             ->from('anvandare')
		             ->where($col." = ?");
		 
		    $this->db->execute([$user]);
		    return $this->db->fetchInto($this);
		}
		
		public function createUser($table, $values)
		{
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
		
		public function findPassword($user)
		{
		    $this->db->select('password')
		             ->from('anvandare')
		             ->where("username = ?");
		 
		    $this->db->execute([$user]);
		    $fetched = $this->db->fetchInto($this);
		    return $fetched->password;
		}
		
		public function findValidation($user)
		{
		    $this->db->select('validated')
		             ->from('anvandare')
		             ->where("username = ?");
		 
		    $this->db->execute([$user]);
		    $fetched = $this->db->fetchInto($this);
		    return $fetched->validated;
		}
		
		public function findImage($user)
		{
		    $this->db->select('profileimage')
		             ->from('anvandare')
		             ->where("username = ?");
		 
		    $this->db->execute([$user]);
		    $fetched = $this->db->fetchInto($this);
		    return $fetched->profileimage;
		}
		
		
		public function updateImage($table, $user, $values)
		{
		    $keys   = array_keys($values);
		    $values = array_values($values);
		 
		    // Its update, remove id and use as where-clause
		    unset($keys['username']);
		    $values[] = $user;
		 
		    $this->db->update(
		       	$table,
		        $keys,
		        "username = ?"
		    );
		 
		    $this->db->execute($values);
		}
		
				
		public function findIdentifier($identifier)
		{
		    $this->db->select('identifier')
		             ->from('anvandare')
		             ->where("identifier = ?");
		 
		    $this->db->execute([$identifier]);
		    $fetched = $this->db->fetchInto($this);
		    return $fetched->identifier;
		}
		
		public function validateUser($table, $values)
		{
		    $keys   = array_keys($values);
		    $values = array_values($values);
		 
		    // Its update time
		    unset($keys['identifier']);
		    $values[] = $this->identifier;
		 
		    $this->db->update(
		        $table,
		        $keys,
		        "identifier = ?"
		    );
		 
		    return $this->db->execute($values);
		}
		
		
		public function updatePassword($table, $user, $values)
		{
		    $keys   = array_keys($values);
		    $values = array_values($values);
		 
		    // Its update, remove id and use as where-clause
		    unset($keys['username']);
		    $values[] = $user;
		 
		    $this->db->update(
		       	$table,
		        $keys,
		        "username = ?"
		    );
		 
		    $this->db->execute($values);
		}
		
		public function updateUsername($table, $user, $values)
		{
		    $keys   = array_keys($values);
		    $values = array_values($values);
		 
		    // Its update, remove id and use as where-clause
		    unset($keys['id']);
		    $values[] = $user;
		 
		    $this->db->update(
		       	$table,
		        $keys,
		        "id = ?"
		    );
		 
		    $this->db->execute($values);
		}
		
		public function selectAllUsers() {
			$this->db->select('*')->from('anvandare');
			
		  $this->db->execute();
		  $fetched = $this->db->fetchAll();
		  return $fetched;
		}
		
		public function findIdByUsername($user) {
			$this->db->select('id')->from('anvandare')->where('username = ?');
			$this->db->execute([$user]);
			$fetched = $this->db->fetchInto($this);
			return $fetched->id;
		}
		
		public function findPointsByUser($user) {
			$this->db->select('poang')->from('anvandare')->where('id = ?');
			$this->db->execute([$user]);
			$fetched = $this->db->fetchInto($this);
			return $fetched->poang;
		}
		
		public function findVotePoints($user) {
			$this->db->select('SUM(fragor_vote) AS vote')->from('fragor_votes')->where('fragor_user_id = ?');
			$this->db->execute([$user]);
			$fetched1 = $this->db->fetchOne();
					
			$this->db->select('SUM(svar_vote) AS vote')->from('svar_votes')->where('svar_user_id = ?');
			$this->db->execute([$user]);
			$fetched2 = $this->db->fetchOne();
			
			$this->db->select('SUM(vote) as vote')->from('votes')->where('user_id = ?');
			$this->db->execute([$user]);
			$fetched3 = $this->db->fetchOne();
			
			$fetched = $fetched1->vote + $fetched2->vote + $fetched3->vote;
			return $fetched;
		}
		public function updatePointsToUser($user, $table, $values) {
				 $keys   = array_keys($values);
			   $values = array_values($values);
			
			   // Its update, remove id and use as where-clause
			   unset($keys['id']);
			   $values[] = $user;
			
			   $this->db->update(
			      	$table,
			        $keys,
			       "id = ?"
			   );
			
			   $this->db->execute($values);
		}
		
		public function findAmountOfVotesMadeByUser($user) {
			$this->db->select('COUNT(fragor_vote) AS vote')->from('fragor_votes')->where('fragor_user_id = ?');
			$this->db->execute([$user]);
			$fetched1 = $this->db->fetchOne();
					
			$this->db->select('COUNT(svar_vote) AS vote')->from('svar_votes')->where('svar_user_id = ?');
			$this->db->execute([$user]);
			$fetched2 = $this->db->fetchOne();
			
			$this->db->select('COUNT(vote) as vote')->from('votes')->where('user_id = ?');
			$this->db->execute([$user]);
			$fetched3 = $this->db->fetchOne();
			
			$fetched = $fetched1->vote + $fetched2->vote + $fetched3->vote;
			return $fetched;
			
		}
		
		public function findLatestRegisteredUsers() {
			$this->db->select('*')->from('anvandare')->orderBY('created_at DESC')->limit(5);
			$this->db->execute();
			$fetched = $this->db->fetchAll();
			return $fetched;
		}
}