<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/MY_REST_Controller.php';
require  'vendor/autoload.php';

class Product extends MY_REST_Controller {

	public function __construct(){		

		parent::__construct();
		$this->load->model('Product_model');
	}

	public function regex_check($str){
    if (preg_match("/^[+]?\d+([.]\d+)?$/", $str)){
      return TRUE;
    }else{
  		$this->form_validation->set_message('regex_check', 'The %s field must not negative!');
      return FALSE;
    }
  }

	public function index_get($id=""){

		if(!empty($id)){
  		$data = $this->Product_model->show($id)->row();
    }else{
      $data = $this->Product_model->all()->result();
    }
 		
 		if(!$data){
			return $this->set_response(
				array(),
				$this->lang->line('text_no_product_available'),
				REST_Controller::HTTP_NOT_FOUND,
			);
		}else{
    	return $this->set_response($data, $this->lang->line('text_product_available'), REST_Controller::HTTP_OK);
    }
	}

	public function index_post(){
		$this->load->library('form_validation');

		// Set validations
		$this->form_validation->set_rules('name', 'name', 'required|trim|min_length[5]|max_length[100]');
		$this->form_validation->set_rules('description', 'description', 'required|trim|min_length[5]|max_length[255]');
		$this->form_validation->set_rules('price', 'price', 'required|trim|callback_regex_check');

		// Set data to validate
		$this->form_validation->set_data($this->post());

		//Run Validations
		if ($this->form_validation->run() == FALSE) {
			return $this->set_response(
				array(),
				validation_errors(),
				REST_Controller::HTTP_BAD_REQUEST
			);
		}

		// Get needed data of product
		$data = $this->form_validation->need_data_as($this->post(), array(
			'name' 				=> null,
			'description' => null,
			'price' 			=> null
		));

		// check whether or not update was success
		$data = $this->Product_model->insert($data);

		if(!$data){
			return $this->set_response(
				array(),
				$this->lang->line('text_insert_failed'),
				REST_Controller::HTTP_EXPECTATION_FAILED,
			);
		}

		return $this->set_response($data, $this->lang->line('text_insert_success'), REST_Controller::HTTP_OK);
	}

	public function index_put($id=''){
		if(!empty($id)){
			$this->load->library('form_validation');

			// Set validations
			$this->form_validation->set_rules('name', 'name', 'required|trim|min_length[5]|max_length[100]');
			$this->form_validation->set_rules('description', 'description', 'required|trim|min_length[5]|max_length[255]');
			$this->form_validation->set_rules('price', 'price', 'required|trim|callback_regex_check');

			// Set data to validate
			$this->form_validation->set_data($this->put());

			//Run Validations
			if ($this->form_validation->run() == FALSE) {
				return $this->set_response(
					array(),
					validation_errors(),
					REST_Controller::HTTP_BAD_REQUEST
				);
			}

			// Get needed data of product
			$data = $this->form_validation->need_data_as($this->put(), array(
				'name' 				=> null,
				'description' => null,
				'price' 			=> null
			));

			// check whether or not product exist
			$check = $this->Product_model->check($id);

			if($check == 0){
				return $this->set_response(
					array(),
					$this->lang->line('text_no_product_available'),
					REST_Controller::HTTP_NOT_FOUND,
				);
			}

			// check whether or not update was success
			$data = $this->Product_model->update($id, $data);

			if(!$data){
				return $this->set_response(
					array(),
					$this->lang->line('text_update_failed'),
					REST_Controller::HTTP_EXPECTATION_FAILED,
				);
			}

			return $this->set_response($data, $this->lang->line('text_update_success'), REST_Controller::HTTP_OK);
		}
	}

	public function index_delete($id=""){
		
		// Check whether id exist or not
		if(!empty($id)){
			
			// check whether or not product exist
			$check = $this->Product_model->check($id);

			if($check == 0){
				return $this->set_response(
					array(),
					$this->lang->line('text_no_product_available'),
					REST_Controller::HTTP_NOT_FOUND,
				);
			}

			// Do delete product by id
  		$data = $this->Product_model->delete($id);

  		// check whether or not delete was success
  		if(!$data){
				return $this->set_response(
					array(),
					$this->lang->line('text_no_product_available'),
					REST_Controller::HTTP_NOT_FOUND,
				);
			}else{
	    	return $this->set_response($data, $this->lang->line('text_delete_success'), REST_Controller::HTTP_OK);
	    }
    } 		
	}
}