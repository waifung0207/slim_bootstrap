<?php

class BaseController
{
	protected $mCtrler;
	protected $mModel;

	public function __construct()
	{
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
		echo json_encode($data);
	}

	// GET (single)
	public function get_one($id)
	{
		$model = new $this->mModel;
		$data = $model->get_one($id);
		echo json_encode($data);
	}

	// CREATE
	public function create()
	{
		$model = new $this->mModel;
		$data = $model->create();
		echo json_encode($data);
	}

	// UPDATE
	public function update($id)
	{
		$model = new $this->mModel;
		$data = $model->update($id);
		echo json_encode($data);
	}

	// DELETE
	public function delete($id)
	{
		$model = new $this->mModel;
		$data = $model->delete($id);
		echo json_encode($data);
	}
}