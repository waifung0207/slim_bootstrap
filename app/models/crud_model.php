<?php

class BaseModel
{
	protected $mDb;
	protected $mTable;
	
	/**
	 * Create database client according to app config
	 */
	public function __construct()
	{
		// TODO: handle more database engine
		if (DB_ENGINE=='elasticsearch')
			$this->mDb = new ElasticClient();

		// must need to override mTable value from child class
		if ( empty($this->mTable) )
			exit("Error: no target table");
	}

	/**
	 * Override below functions to handle custom logic
	 */

	// GET (multiple)
	public function get_list()
	{
		return $this->mDb->get_all($this->mTable);
	}

	// GET (single)
	public function get_one($id)
	{
		return $this->mDb->get($this->mTable, $id);
	}

	// CREATE
	public function create()
	{
		// for testing only
		$params = array('name' => 'new user');

		return $this->mDb->create($this->mTable, $params);
	}

	// UPDATE
	public function update($id)
	{
		// for testing only
		$params = array('name' => 'update value');

		return $this->mDb->update($this->mTable, $id, $params);
	}

	// DELETE
	public function delete($id)
	{
		return $this->mDb->delete($this->mTable, $id);
	}
}