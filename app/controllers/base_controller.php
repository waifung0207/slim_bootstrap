<?php

class BaseController
{
	protected $mCtrler;
	protected $mModel;

	public function __construct()
	{
		$app = \Slim\Slim::getInstance();
		$app->contentType('application/json');

		$this->mCtrler = get_called_class();
		$this->mModel = str_replace('Controller', 'Model', $this->mCtrler);
	}

	/**
	 * Override below functions to handle custom logic
	 */
	// GET (multiple)
	public function get_list()
	{
		$model = new $this->mModel;
		$data = $model->get_list();
		$this->output_result($data);
	}

	// GET (single)
	public function get_one($id)
	{
		$model = new $this->mModel;
		$data = $model->get_one($id);
		$this->output_result($data);
	}

	// CREATE
	public function create()
	{
		$model = new $this->mModel;
		$data = $model->create();
		$this->output_result($data);
	}

	// UPDATE
	public function update($id)
	{
		$model = new $this->mModel;
		$data = $model->update($id);
		$this->output_result($data);
	}

	// DELETE
	public function delete($id)
	{
		$model = new $this->mModel;
		$data = $model->delete($id);
		$this->output_result($data);
	}

	/**
	 * Result Output (e.g. as JSON format)
	 */
	public function output_result($data, $extra_params = array())
	{
		$result = array();

		// additional information for debug
		if (APP_DEBUG)
		{
			$trace = debug_backtrace();

			$result['debug'] = array(
				'controller'	=> $this->mCtrler,
				'function'		=> $trace[1]['function'],
				'model'			=> $this->mModel
			);
		}

		// resulted data
		$result['app_name']		= APP_NAME;
		$result['app_version']	= APP_VERSION;
		$result['data'] 		= $data;

		// extra info
		$result = array_merge($result, $extra_params);

		// output as JSON
		echo $this->to_json($result);
	}

	// output to JSON string
	public function to_json($result)
	{
		$json_option = (APP_DEBUG) ? JSON_PRETTY_PRINT : 0;
		return json_encode($result, $json_option);
	}

	// results for empty records, 404, invalid operations
	protected function to_invalid()
	{
		$result = array(
			'app_name'		=> APP_NAME,
			'app_version'	=> APP_VERSION,
			'result'		=> 'invalid'
		);
		$json_option = (APP_DEBUG) ? JSON_PRETTY_PRINT : 0;
		return json_encode($result, $json_option);
	}
}