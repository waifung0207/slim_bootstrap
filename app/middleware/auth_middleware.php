<?php

/**
 * Handle authenication of all requests
 */
class AuthMiddleware extends \Slim\Middleware
{
	public function call()
	{
		// Get reference to application
		$app = $this->app;

		// (Optional) skip auth logic for debug mode
		/*
		if (APP_DEBUG)
			return;
		*/

		// Exit if auth failed
		if ( !$this->check_auth() )
		{
			$app->render('404.php', array(), 404);
			return;
		}

		// Run inner middleware and application
		$this->next->call();
	}

	/**
	 * Custom auth logic here
	 */
	private function check_auth()
	{
		$app = $this->app;

		// skip checking for GET requests
		if ($app->request->isGet())
			return TRUE;

		// accept only body in JSON format
		$content_type = $app->request->getContentType();
		if ( $content_type!='application/json' )
			return FALSE;

		/**
		 * Example of JSON body from REST client:
		 * {"id": "100", "api_key": "677398e5d4590619a4cdb5c7b890b8bf"}
		 */
		$json_body = $app->request->getBody();
		$body = json_decode($json_body, TRUE);

		// only accept request with valid API Key
		if ( $body['api_key']!=API_KEY )
			return FALSE;

		// all passed
		return 0;
	}
}