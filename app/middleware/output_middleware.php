<?php

class OutputMiddleware extends \Slim\Middleware
{
    public function call()
    {
        // Get reference to application
        $app = $this->app;

        // Run inner middleware and application
        $this->next->call();

        // Return response body as JSON
		$app->contentType('application/json');
        $response = $app->response;
        $status = $response->getStatus();

        // bypass when invalid operation is found
        if ($status!=200)
        	return;

        // prepare array to store all info returned
        $result = array();
		$result['app_name']		= APP_NAME;
		$result['app_version']	= APP_VERSION;
		$result['status']		= $status;
		$result['data'] 		= json_decode($response->getBody());

		// additional information for debug
		if (APP_DEBUG)
		{
			// request info
			$request = $app->request;
			$result['FOR_DEBUG_ONLY'] = array(
				'request' => array(
					'resource_uri'	=> $request->getResourceUri(),
					'headers'		=> $request->headers,
					'cookies'		=> $request->cookies,
					'body'			=> $request->getBody(),
				)
			);
		}

		// convert to JSON
		$json_option = (APP_DEBUG) ? JSON_PRETTY_PRINT : 0;
		$body = json_encode($result, $json_option);

        $response->setBody($body);
    }
}