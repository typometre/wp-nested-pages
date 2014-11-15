<?php

function nestedpages_quickedit_handler()
{
	new NP_QuickEdit_Handler;
}

require_once('class-np-handler-base.php');

/**
* Handles processing the quick edit form
* @return json response
*/
class NP_QuickEdit_Handler extends NP_BaseHandler {


	public function __construct()
	{
		parent::__construct();
		$this->updatePost();
		$this->syncMenu();
		$this->sendResponse();
	}


	/**
	* Update the Post
	* @todo update taxonomies
	*/
	private function updatePost()
	{
		$updated = $this->post_repo->updatePost($this->data);
		if ( !$updated ) $this->sendErrorResponse();
		$this->addData();
		$this->response = array(
			'status' => 'success', 
			'message' => __('Post successfully updated'), 
			'post_data' => $this->data
		);
	}


	/**
	* Add additional data to the response object
	*/
	private function addData()
	{
		$this->data['nav_status'] = ( isset($this->data['nav_status']) ) ? 'hide' : 'show';
		$this->data['np_status'] = ( isset($this->data['nested_pages_status']) ) ? 'hide' : 'show';
		$this->data['link_target'] = ( isset($this->data['link_target']) ) ? '_blank' : 'none';
		$this->data['keep_private'] = ( isset($this->data['keep_private']) ) ? 'private' : 'public';
		$this->data['_status'] = ( isset($this->data['_status']) ) ? $this->data['_status'] : 'publish';
		if ( !isset($_POST['comment_status']) ) $this->data['comment_status'] = 'closed';
	}

}