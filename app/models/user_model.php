<?php

class UserModel extends CrudModel
{
	// dummy data
	private $users = array(
		0 => array('id' => 1, 'name' => 'Michael'),
		1 => array('id' => 2, 'name' => 'Paul'),
		2 => array('id' => 3, 'name' => 'Peter')
	);

	// get list of users
	public function get_list()
	{
		return $this->to_json($this->users);
	}

	// get single user
	public function get_one($id)
	{
		if ( empty($this->users[$id-1]) )
			return $this->to_invalid();
		else
			return $this->to_json($this->users[$id-1]);
	}

	// create new user
	public function create()
	{
		return $this->to_json('Record created.');
	}

	// update a user
	public function update($id)
	{
		return $this->to_json('Record updated');
	}
}