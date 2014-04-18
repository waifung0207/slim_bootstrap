<?php

/**
 * Official Repository: https://github.com/elasticsearch/elasticsearch-php
 */
class ES_Client
{
	private $mClient;

	// configuration
	private $mHost		= DB_HOST;
	private $mPort		= DB_PORT;
	private $mUsername	= DB_USERNAME;
	private $mPassword	= DB_PASSWORD;
	private $mAuthType	= ES_AUTH_TYPE;

	// logging
	private $mLogging	= ES_LOG_ENABLED;
	private $mLogPath	= ES_LOG_PATH;
	//private $mLogLevel	= Psr\Log\LogLevel::WARN;

	// default index
	private $mIndex		= ES_DEFAULT_INDEX;

	/**
	 * Constructor
	 */
	function __construct()
	{
		// configuration
		$params = array();

		// authentication (optional)
		if ( !empty($this->mUsername) )
		{
			$params['connectionParams']['auth'] = array(
				$this->mUsername,
				$this->mPassword,
				$this->mAuthType
			);
		}

		// logging (optional)
		if ($this->mLogging)
		{
			$params['logging'] = true;
			$params['logPath'] = $this->mLogPath;
			//$params['logLevel'] = $this->mLogLevel;
		}

		// create Elasticsearch client
		$this->mClient = new Elasticsearch\Client($params);
	}

	/**
	 * Override default index
	 */
	public function use_index($index)
	{
		$this->mIndex = $index;
	}

	/**
	 * ElasticSearch - Index operation
	 */
	function create_index($index)
	{
		$params = array();
		$params['index'] = $index;

		// sample:
		$params['body']['settings']['number_of_shards'] = 2;
		$params['body']['settings']['number_of_replicas'] = 0;

		$response = $this->mClient->indices()->create($params);
		return $response;
	}
	function delete_index($index)
	{
		$params = array();
		$params['index'] = $index;
		$response = $this->mClient->indices()->delete($params);
		return $response;
	}

	/**
	 * ElasticSearch - Type operation
	 */
	function delete_type($table)
	{
		// remove all documents inside a type
		$params = array();
		$params['index']	= $this->mIndex;
		$params['type']		= $table;
		$params['body']['query']['match_all'] = array();

		$response = $this->mClient->deleteByQuery($params);
		return $response;
	}
	
	/**
	 * ElasticSearch - Indexing operation
	 */
	function create($table, $values, $id = 0)
	{
		$params = array();
		$params['index']	= $this->mIndex;
		$params['type']		= $table;
		$params['body']		= $values;

		// assign ID if necessary
		if ( !empty($id) )
		{
			$params['id']	= $id;
		}

		// additional parameters
		// $params['routing'] = 'company_xyz';
		// $params['timestamp'] = strtotime("-1d");

		$response = $this->mClient->index($params);
		return $response;
	}
	
	/**
	 * ElasticSearch - Get operation (single)
	 */
	function get($table, $id)
	{
		$params = array();
		$params['index']	= $this->mIndex;
		$params['type']		= $table;
		$params['id']		= $id;

		try
		{
			return $this->mClient->get($params);
		}
		catch (Exception $e)
		{
			return json_decode($e->getMessage());
		}
	}

	/**
	 * ElasticSearch - Get operation (all)
	 */
	function get_all($table)
	{
		$params = array();
		$params['index']	= $this->mIndex;
		$params['type']		= $table;
		$params['body']['query']['match_all'] = array();

		try
		{
			return $this->mClient->search($params);
		}
		catch (Exception $e)
		{
			return json_decode($e->getMessage());
		}
	}
	
	/**
	 * ElasticSearch - Search operation
	 */
	function search_simple($table, $field, $match)
	{
		$params = array();
		$params['index']	= $this->mIndex;
		$params['type']		= $table;
		$params['body']['query']['match'][$field] = $match;

		try
		{
			return $this->mClient->search($params);
		}
		catch (Exception $e)
		{
			return json_decode($e->getMessage());
		}
	}
	function search($table, $filter, $query)
	{
		// sample:
		// $filter['term']['my_field'] = 'abc';
		// $query['match']['my_other_field'] = 'xyz';
		
		$params = array();
		$params['index']	= $this->mIndex;
		$params['type']		= $table;
		$params['body']['query']['filtered'] = array(
			"filter"	=> $filter,
			"query"		=> $query
		);

		try
		{
			return $this->mClient->search($params);
		}
		catch (Exception $e)
		{
			return json_decode($e->getMessage());
		}
	}

	/**
	 * ElasticSearch - Update operation
	 */
	function update($table, $id, $values)
	{
		$params = array();
		$params['index']		= $this->mIndex;
		$params['type']			= $table;
		$params['id']			= $id;
		$params['body']['doc']	= $values;

		try
		{
			return $this->mClient->update($params);
		}
		catch (Exception $e)
		{
			return json_decode($e->getMessage());
		}
	}

	/**
	 * ElasticSearch - Delete operation
	 */
	function delete($table, $id)
	{
		$params = array();
		$params['index']	= $this->mIndex;
		$params['type']		= $table;
		$params['id']		= $id;

		try
		{
			return $this->mClient->delete($params);
		}
		catch (Exception $e)
		{
			return json_decode($e->getMessage());
		}
	}
}