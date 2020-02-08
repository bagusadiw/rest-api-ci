<?php

class Product_model extends CI_Model {
	private $validations = array('email'=>'required|valid_email',"password"=>"required|min_length[5]|max_length[20]");
	function __construct() {
		
		parent::__construct();

		//Table Name
		$this->table_name = "product";
	}

	function all(){
		$count = $this->db->get($this->table_name)->num_rows();
		
		if($count = 0){
			return false;
		}

		$result = $this->db->get($this->table_name);
		return $result;
	}

	function check($id){
		$this->db->where('id', $id);
		$count = $this->db->get($this->table_name)->num_rows();

		return $count;
	}

	function delete($id){
		$this->db->where('id', $id);
		$result = $this->db->delete($this->table_name);

		return $result;
	}

	function insert($data){
		$result = $this->db->insert($this->table_name, $data);
		
		return $result;
	}

	function show($id){
		$this->db->where('id', $id);
		$result = $this->db->get($this->table_name);

		return $result;
	}

	function update($id, $data){
		$this->db->where('id', $id);
		$this->db->set('modified_at', 'NOW()', FALSE);
		$result = $this->db->update($this->table_name, $data);
		
		return $result;
	}
}

?>