<?php

class ApiOutput
{
	// output to JSON string
	public static function to_json($data, $extra_params = array())
	{
		// resulted data
		$result = array(
			'app_name'		=> APP_NAME,
			'app_version'	=> APP_VERSION,
			'data'			=> $data
		);
		$result = array_merge($result, $extra_params);

		// return more info for debug purpose
		if (APP_DEBUG)
		{
			$debug_data = debug_backtrace();
			$caller_class = $debug_data[1]['class'];
			$caller_func = $debug_data[1]['function'];

			$result['app_function'] = $caller_class.'::'.$caller_func;
		}

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