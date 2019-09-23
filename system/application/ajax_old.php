<?php
class Ajax extends Controller {

	function Ajax()
	{
		parent::Controller();	
		$this->load->model('ajax_old_model');      
	}
	
	function index()
	{
		$this->load->view('ajax');
	}
	
	function getname() {		
		$nim = $this->input->post('nim');
		echo '<input type="hidden" name="name" value="'.$this->ajax_model->get_name($nim).'" />'.$this->ajax_model->get_name($nim);
	}
}
