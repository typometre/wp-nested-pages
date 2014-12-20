<?php namespace NestedPages\Form\Handlers;

use NestedPages\Form\Validation\Validation;
use NestedPages\Factories\PostFactory;

/**
* Handles processing the quick edit form
* @return json response
*/
class NewChildHandler extends BaseHandler {

	/**
	* Post Factory
	*/
	private $factory;

	/**
	* Validation
	*/
	private $validation;


	public function __construct()
	{
		parent::__construct();
		$this->factory = new PostFactory;
		$this->validation = new Validation;
		$this->savePages();
		$this->syncMenu();
		$this->sendResponse();
	}


	/**
	* Run Validation
	*/
	private function validates()
	{
		return $this->validation->validateNewPages($this->data);
	}


	/**
	* Save the new page(s)
	*/
	private function savePages()
	{
		if ( $this->validates() ){
			$this->data['new_pages'] = $this->factory->createChildPages($this->data);
			$this->setResponse();
			return;
		}
		$this->sendErrorResponse();
	}


	/**
	* Set the Response
	*/
	private function setResponse()
	{
		$this->response = array(
			'status'=>'success',
			'new_pages' => $this->data['new_pages']
		);
	}

}
