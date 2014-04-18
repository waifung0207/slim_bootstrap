<?php

class CrudModel
{
	protected $mApp;
	protected $mModel;
	protected $mTable;

	public function __construct($app)
	{
		$this->mApp = $app;
		$this->mModel = get_called_class();
	}

	/**
	 * Override below functions to handle custom logic
	 */

	// GET (multiple)
	public function get_list()
	{
		if (DB_ENGINE=='elasticsearch')
		{
			$client = new ES_Client();
			$response = $client->get_all($this->mTable);

			$this->mApp->contentType('application/json');
			return ApiOutput::to_json($response);
		}
		else
		{
			return $this->mModel.': GET /';
		}
	}

	// GET (single)
	public function get_one($id)
	{
		if (DB_ENGINE=='elasticsearch')
		{
			// get from ElasticSearch
			$client = new ES_Client();
			$response = $client->get($this->mTable, $id);

			$this->mApp->contentType('application/json');
			return ApiOutput::to_json($response);
		}
		else
		{
			return $this->mModel.': GET /'.$id;
		}
	}

	// CREATE
	public function create()
	{
		if (DB_ENGINE=='elasticsearch')
		{
			$client = new ES_Client();
			$params = array('name' => 'new user');
			$response = $client->create($this->mTable, $params);

			$this->mApp->contentType('application/json');
			return ApiOutput::to_json($response);
		}
		else
		{
			return $this->mModel.': POST /';
		}
	}

	// UPDATE
	public function update($id)
	{
		if (DB_ENGINE=='elasticsearch')
		{
			$client = new ES_Client();
			$params = array('name' => 'update value');
			$response = $client->update($this->mTable, $id, $params);

			$this->mApp->contentType('application/json');
			return ApiOutput::to_json($response);
		}
		else
		{
			return $this->mModel.': PUT /'.$id;
		}
	}

	// DELETE
	public function delete($id)
	{
		if (DB_ENGINE=='elasticsearch')
		{
			$client = new ES_Client();
			$response = $client->delete($this->mTable, $id);

			$this->mApp->contentType('application/json');
			return ApiOutput::to_json($response);
		}
		else
		{
			return $this->mModel.': DELETE /'.$id;
		}
	}
}