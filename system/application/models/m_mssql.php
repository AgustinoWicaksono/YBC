<?php
class M_mssql extends Model {
	
	//private $this->db2;
	public function __construct()
 	{
  		parent::__construct();
        $this->db2 = $this->load->database('DEMO_MSI', TRUE);
	}
	
	}