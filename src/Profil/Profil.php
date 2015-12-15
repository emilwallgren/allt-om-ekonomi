<?php

namespace Anax\Profil;
 
/**
 * A controller for users and admin related events.
 *
 */
class Profil extends \Anax\MVC\CDatabaseModel
{		

	public function validateInput($input) {
		$input = htmlspecialchars($input);
		return $input;
	}
	
	public function findByID($table, $id)
	{
    $this->db->select('*')->from($table)->where('id = ?');
    $this->db->execute([$id]);
    $fetched = $this->db->fetchInto($this);
    return $fetched;
	}
	
	
	public function relateAnswerToUser($table, $id) {
		$this->db->select('*')->from('svar')->join('fragor', 'fragor.id = svar.fragor_id')->where('svar.anvandare_id = ?');
		$this->db->execute([$id]);
		$fetched = $this->db->fetchAll();
		return $fetched;
	}
	
	public function findCommentsMadeByUser($id) {
		$this->db->select('*')->from('kommentarer')->where('anvandare_id = ?');
		$this->db->execute([$id]);
		$fetched = $this->db->fetchAll();
		return $fetched;
	}
		
}