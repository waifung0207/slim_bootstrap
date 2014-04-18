<?php

class UserModel extends CrudModel
{
	protected $mTable = 'users';

	/**
	 * Examples of overriding CrudModel functions
	 */

	/*
	// dummy data
	private $users = array(
		0 => array('id' => 1, 'name' => 'Michael'),
		1 => array('id' => 2, 'name' => 'Paul'),
		2 => array('id' => 3, 'name' => 'Peter')
	);

	// get list of users
	public function get_list()
	{
		return ApiOutput::to_json($this->users);
	}

	// get single user
	public function get_one($id)
	{
		if ( empty($this->users[$id-1]) )
			return ApiOutput::to_invalid();
		else
			return ApiOutput::to_json($this->users[$id-1]);
	}

	// create new user
	public function create()
	{
		return ApiOutput::to_json($response);
	}

	// update a user
	public function update($id)
	{
		return ApiOutput::to_json('Record updated');
	}
	*/
}