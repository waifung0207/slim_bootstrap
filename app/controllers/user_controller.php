<?php

class UserController extends BaseController
{
	/**
	 * Examples of custom functions
	 */
	public function get_followers($id)
	{
		$data = "Get followers of User ID: ".$id;
		echo json_encode($data.$id);
	}

	public function get_posts($id)
	{
		$data = "Get posts of User ID: ".$id;
		echo json_encode($data.$id);
	}

	public function create_post($id)
	{
		$data = "Create post under User ID: ".$id;
		echo json_encode($data.$id);
	}

	public function update_password($id)
	{
		$data = "Update Password of User ID: ".$id;
		echo json_encode($data.$id);
	}
}