<?php

namespace Anax\Anvandare;
 
/**
 * A controller for users and admin related events.
 *
 */
class Anvandare extends \Anax\MVC\CDatabaseModel
{		
		
		public function findUser($username)
		{
		    $this->db->select()
		             ->from('aoe_anvandare')
		             ->where("username = ?");
		 
		    $this->db->execute([$username]);
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
		
}