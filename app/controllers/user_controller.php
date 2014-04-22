<?php

class UserController extends BaseController
{
	/**
	 * Override general routes here (e.g. get_list)
	 */
	/*
	public function get_list()
	{
		// do custom logic
		parent::get_list();
	}
	*/

	/**
	 * Examples of custom routes
	 */
	public function get_followers($id)
	{
		$data = "Get followers of User ID: ".$id;
		echo json_encode($data);
	}

	public function get_posts($id)
	{
		$data = "Get posts of User ID: ".$id;
		echo json_encode($data);
	}

	public function create_post($id)
	{
		$data = "Create post under User ID: ".$id;
		echo json_encode($data);
	}

	public function update_password($id)
	{
		$data = "Update Password of User ID: ".$id;
		echo json_encode($data);
	}
}