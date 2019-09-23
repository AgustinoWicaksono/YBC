<?php
require_once("class.phpmailer.php");

class M_deletedata extends Model {
		
	function M_deletedata() {
		parent::Model();  
	}
	
	function checkdata($posting_date) {
        $posting_date = date('Y-m-d',strtotime($posting_date));

		$this->db->from('t_stockoutlet_header');
		$this->db->where('DATE(posting_date)', $posting_date);
    	$this->db->where('plant', $this->session->userdata['ADMIN']['plant']);
    	$this->db->where('status', 2);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}
			
	function deleteopname($delete_date,$delete_option='reset') {
		if (Empty($delete_option)) $delete_option="reset";
		$deleteresult = TRUE;
		$swbplant = trim($this->session->userdata['ADMIN']['plant']);
		$delete_date=trim($delete_date);
	
		$swbquery1 = "update `t_posinc_header` set `stockoutlet_no` = NULL, `waste_no` = NULL, `status` = 1 WHERE `plant` = '".$swbplant."' AND date(`posting_date`) = '".$delete_date."';";
		
		if ($delete_option=="reset") {
		$swbquery2 = "update `t_stockoutlet_header` SET `status`=1,`material_doc_no`=NULL WHERE `plant` = '".$swbplant."' AND date(`posting_date`) = '".$delete_date."';";
		$swbquery3 = "update `t_waste_header` SET `status`=1,`material_doc_no`=NULL WHERE `plant` = '".$swbplant."' AND date(`posting_date`) = '".$delete_date."';";
		
		}
		elseif ($delete_option=="delete") {
		$swbquery2 = "delete from `t_stockoutlet_detail` WHERE `id_stockoutlet_header` IN (SELECT `id_stockoutlet_header` FROM `t_stockoutlet_header` WHERE `plant` = '".$swbplant."' AND date(`posting_date`) = '".$delete_date."');";
		$swbquery3 = "delete from `t_stockoutlet_header` WHERE `plant` = '".$swbplant."' AND date(`posting_date`) = '".$delete_date."';";
		$swbquery4 = "update `t_waste_header` SET `status`=1,`material_doc_no`=NULL WHERE `plant` = '".$swbplant."' AND date(`posting_date`) = '".$delete_date."';";
		
		}

//		echo $delete_option."<hr><br />";
//		die(@$swbquery1."<hr>".@$swbquery2."<hr>".@$swbquery3."<hr>".@$swbquery4."<hr>");
		$this->db->trans_start();
		$this->db->query($swbquery1);
		$this->db->query($swbquery2);
		$this->db->query($swbquery3);
		if ($delete_option=="delete") {$this->db->query($swbquery4); }
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			$deleteresult = FALSE;
		} 
		return $deleteresult;
	}
	


}
