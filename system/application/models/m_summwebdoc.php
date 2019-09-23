<?php
class M_summwebdoc extends Model {

	function M_summwebdoc() {
		parent::Model();
		$this->load->model('m_general');
	}

	// start of browse

	function grpo_select($date_from='') {

		$this->db->select('plant,grpo_no');
		$this->db->from('t_grpo_header');
		$this->db->order_by('plant');
		$this->db->order_by('grpo_no');
		$this->db->where('grpo_no is not null and grpo_no <> ""');
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $grpo) {
			  $grpos[$grpo['plant']][$i] = $grpo['grpo_no'];
   		      $i++;
  			}
  		}
		if(!empty($grpos))
			return $grpos;
		else
			return FALSE;
	}

	function grpodlv_select($date_from='') {

		$this->db->select('plant,grpodlv_no');
		$this->db->from('t_grpodlv_header');
		$this->db->order_by('plant');
		$this->db->order_by('grpodlv_no');
		$this->db->where('grpodlv_no is not null and grpodlv_no <> ""');
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $grpodlv) {
			  $grpodlvs[$grpodlv['plant']][$i] = $grpodlv['grpodlv_no'];
   		      $i++;
  			}
  		}

		if(!empty($grpodlvs))
			return $grpodlvs;
		else
			return FALSE;
	}

	function stockoutlet_select($date_from='') {

		$this->db->select('plant,stockoutlet_no');
		$this->db->from('t_posinc_header');
		$this->db->order_by('plant');
		$this->db->order_by('stockoutlet_no');
//		$this->db->where('stockoutlet_no is not null and stockoutlet_no <> ""');
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $stockoutlet) {
			  $stockoutlets[$stockoutlet['plant']][$i] = $stockoutlet['stockoutlet_no'];
   		      $i++;
  			}
  		}

		if(!empty($stockoutlets))
			return $stockoutlets;
		else
			return FALSE;
	}

	function gisto_select($date_from='') {

		$this->db->select('plant,gisto_no');
		$this->db->from('t_gisto_header');
		$this->db->order_by('plant');
		$this->db->order_by('gisto_no');
		$this->db->where('gisto_no is not null and gisto_no <> ""');
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $gisto) {
			  $gistos[$gisto['plant']][$i] = $gisto['gisto_no'];
   		      $i++;
  			}
  		}

		if(!empty($gistos))
			return $gistos;
		else
			return FALSE;
	}

	function grsto_select($date_from='') {

		$this->db->select('plant,grsto_no');
		$this->db->from('t_grsto_header');
		$this->db->order_by('plant');
		$this->db->order_by('grsto_no');
		$this->db->where('grsto_no is not null and grsto_no <> ""');
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $grsto) {
			  $grstos[$grsto['plant']][$i] = $grsto['grsto_no'];
   		      $i++;
  			}
  		}

		if(!empty($grstos))
			return $grstos;
		else
			return FALSE;
	}

	function waste_select($date_from='') {

		$this->db->select('plant,waste_no');
		$this->db->from('t_posinc_header');
		$this->db->order_by('plant');
		$this->db->order_by('waste_no');
//		$this->db->where('waste_no is not null and waste_no <> "" ');
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $waste) {
			  $wastes[$waste['plant']][$i] = $waste['waste_no'];
   		      $i++;
  			}
  		}

		if(!empty($wastes))
			return $wastes;
		else
			return FALSE;
	}

	function nonstdstock_select($date_from='') {

		$this->db->select('plant,pr_no');
		$this->db->from('t_nonstdstock_header');
		$this->db->order_by('plant');
		$this->db->order_by('pr_no');
		$this->db->where('pr_no is not null and pr_no <> ""');
		$this->db->where('DATE(created_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $nonstdstock) {
			  $nonstdstocks[$nonstdstock['plant']][$i] = $nonstdstock['pr_no'];
   		      $i++;
  			}
  		}

		if(!empty($nonstdstocks))
			return $nonstdstocks;
		else
			return FALSE;
	}

	function stdstock_select($date_from='') {

		$this->db->select('plant,pr_no');
		$this->db->from('t_stdstock_header');
		$this->db->order_by('plant');
		$this->db->order_by('pr_no');
		$this->db->where('pr_no is not null and pr_no <> ""');
		$this->db->where('DATE(created_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $stdstock) {
			  $stdstocks[$stdstock['plant']][$i] = $stdstock['pr_no'];
   		      $i++;
  			}
  		}

		if(!empty($stdstocks))
			return $stdstocks;
		else
			return FALSE;
	}

	function grfg_select($date_from='') {

		$this->db->select('plant,grfg_no');
		$this->db->from('t_grfg_header');
		$this->db->order_by('plant');
		$this->db->order_by('grfg_no');
		$this->db->where('grfg_no is not null and grfg_no <> "" ');
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $grfg) {
			  $grfgs[$grfg['plant']][$i] = $grfg['grfg_no'];
   		      $i++;
  			}
  		}

		if(!empty($grfgs))
			return $grfgs;
		else
			return FALSE;
	}

	function tssck_select($date_from='') {

		$this->db->select('plant,tssck_no');
		$this->db->from('t_tssck_header');
		$this->db->order_by('plant');
		$this->db->order_by('tssck_no');
		$this->db->where('tssck_no is not null and tssck_no <> ""');
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $tssck) {
			  $tsscks[$tssck['plant']][$i] = $tssck['tssck_no'];
   		      $i++;
  			}
  		}

		if(!empty($tsscks))
			return $tsscks;
		else
			return FALSE;
	}

	function trend_utility_select($date_from='') {

		$this->db->select('plant,trend_utility_no');
		$this->db->from('t_trend_utility_header');
		$this->db->order_by('plant');
		$this->db->order_by('trend_utility_no');
		$this->db->where('trend_utility_no is not null and trend_utility_no <> ""');
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $trend_utility) {
			  $trend_utilitys[$trend_utility['plant']][$i] = $trend_utility['trend_utility_no'];
   		      $i++;
  			}
  		}

		if(!empty($trend_utilitys))
			return $trend_utilitys;
		else
			return FALSE;
	}

	function gitcc_select($date_from='') {

		$this->db->select('plant,gitcc_no');
		$this->db->from('t_gitcc_header');
		$this->db->order_by('plant');
		$this->db->order_by('gitcc_no');
		$this->db->where('gitcc_no is not null and gitcc_no <> ""');
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $gitcc) {
			  $gitccs[$gitcc['plant']][$i] = $gitcc['gitcc_no'];
   		      $i++;
  			}
  		}

		if(!empty($gitccs))
			return $gitccs;
		else
			return FALSE;
	}

	function prodstaff_select($date_from='') {

		$this->db->select('plant');
		$this->db->from('t_prodstaff_header');
		$this->db->order_by('plant');
		$this->db->where('status',2);
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $prodstaff) {
			  $prodstaffs[$prodstaff['plant']][$i] = $prodstaff['id_prodstaff_header'];
   		      $i++;
  			}
  		}

		if(!empty($prodstaffs))
			return $prodstaffs;
		else
			return FALSE;
	}

	function eod_select($date_from='') {

		$this->db->select('plant');
		$this->db->from('t_posinc_header');
		$this->db->order_by('plant');
		$this->db->where('status',2);
		$this->db->where('DATE(posting_date)',$date_from);

		$query = $this->db->get();

  		if(!empty($query)) {
  		    $i = 1;
  			foreach ($query->result_array() as $eod) {
			  $eods[$eod['plant']][$i] = $eod['id_posinc_header'];
   		      $i++;
  			}
  		}

		if(!empty($eods))
			return $eods;
		else
			return FALSE;
	}

	function summwebdoc_headers_count_by_criteria($date_from = '', $outlet_type = '', $outlet_from = '', $outlet_to = '') {

		$query =$this->summwebdoc_headers_select_by_criteria($date_from,$outlet_type,$outlet_from,$outlet_to);

		if((!empty($query))&&($query->num_rows() > 0)) {
			return $query->num_rows();
		} else {
			return FALSE;
		}

	}

	function eod_success_count($date_from='', $outlet_type = '', $outlet_from = '', $outlet_to = '') {

		$this->db->from('t_posinc_header');
		//$this->db->where('waste_no is not null and waste_no <> "" ');
		$this->db->join('m_outlet','OUTLET = plant','inner');
		$this->db->where('status',2);
		$this->db->where('DATE(posting_date)',$date_from);
		if(!empty($outlet_type))
			$this->db->where('COMP_CODE', $outlet_type);

		if((!empty($outlet_from))&&(!empty($outlet_to))) {
			$this->db->where('OUTLET >=', $outlet_from);
			$this->db->where('OUTLET <=', $outlet_to);
        }

		$query = $this->db->get();

		if((!empty($query))&&($query->num_rows() > 0)) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}

	function summwebdoc_headers_select_by_criteria($date_from = '', $outlet_type = '', $outlet_from = '', $outlet_to = '', $limit = 0, $start = 0) {

		if(empty($outlet_type))
			$outlet_type = 'BID';

		if(empty($outlet_from))
			$outlet_from = '';

		if(empty($outlet_to))
			$outlet_to = '';

		if(empty($date_from))
			$date_from = date('Y-m-d');

		$this->db->select('OUTLET, OUTLET_NAME1, OUTLET_NAME2');
		$this->db->from('m_outlet');
        $this->db->where('OUTLET NOT LIKE "C%"');
        $this->db->where('OUTLET NOT LIKE "H%"');
        $this->db->where('OUTLET_NAME1 NOT LIKE "Next%"');
		$this->db->order_by('OUTLET');

		// start of searching

		if(!empty($outlet_type))
			$this->db->where('COMP_CODE', $outlet_type);

		if((!empty($outlet_from))&&(!empty($outlet_to))) {
			$this->db->where('OUTLET >=', $outlet_from);
			$this->db->where('OUTLET <=', $outlet_to);
        }

        if($limit>0)
   		   $this->db->limit($limit, $start);

		$query = $this->db->get();

    	if($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}

	}

}
?>