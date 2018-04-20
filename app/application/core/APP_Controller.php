<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class APP_Controller extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	function render($view, $data) {

		$var['name'] = $this->session->userdata('name');
		
		if(isset($data['title']))
			$var['title']=$data['title'];

		$this->load->view('layouts/before', $var);
		$this->load->view($view, $data);
		$this->load->view('layouts/after');

	}

}
