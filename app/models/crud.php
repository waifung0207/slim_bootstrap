<?php

class CrudModel
{
	protected $mApp;
	protected $mModel;

	public function __construct($app)
	{
		$this->mApp = $app;
		$this->mModel = get_called_class();
	}

	// Override these functions to handle custom logic
	public function get_list()
	{
		return $this->mModel.': GET /';
	}
	public function get_one($id)
	{
		return $this->mModel.': GET /'.$id;
	}
	public function create()
	{
		return $this->mModel.': POST /';
	}
	public function update($id)
	{
		return $this->mModel.': PUT /'.$id;
	}
	public function delete($id)
	{
		return $this->mModel.': DELETE /'.$id;
	}

	// JSON result
	protected function to_json($data)
	{
		// return info for debug purpose (optional)
		$debug_data = debug_backtrace();
		$caller_class = $debug_data[1]['class'];
		$caller_func = $debug_data[1]['function'];

		// JSON response
		$this->mApp->contentType('application/json');
		$result = array(
			'app_name'		=> APP_NAME,
			'app_version'	=> APP_VERSION,
			'app_function'	=> $caller_class.'::'.$caller_func,
			'data'			=> $data
		);
		return json_encode($result);
	}

	// results for empty records, 404, invalid operations
	protected function to_invalid()
	{
		$this->mApp->contentType('application/json');
		$result = array(
			'app_name'		=> APP_NAME,
			'app_version'	=> APP_VERSION,
			'result'		=> 'invalid'
		);
		return json_encode($result);
	}
}