<?php
class M_endofmonth extends Model {

	function M_endofmonth() {
		parent::Model();
		$this->obj =& get_instance();
		$this->load->library('l_general');
	}

	function endofmoth_select($periode,$kode_outlet) {
		$this->db->from('d_endofmonth');
		$this->db->where('periode', $periode);
		$this->db->where('kode_outlet', $kode_outlet);

		$query = $this->db->get();

		if($query->num_rows() > 0)
          return TRUE;
        else
          return FALSE;
	}

	function m_shcedule_pmbyrn_select() {
		$posting_date = date('Y-m-d', mktime(0, 0, 0, date("m")+1, 1, date("Y")));
		$this->db->from('m_schedule_pembyaran');
		$this->db->where('status', '0');
		$this->db->where("akhir <= '".$posting_date."'");
//		$this->db->where("kode_grouppembayaran IN (select kode_grouppembayaran from m_employee where kode_cabang='".$this->session->userdata['ADMIN']['hr_plant_code']."')");

		$query = $this->db->get();
//		echo $this->db->last_query();

		if($query->num_rows() > 0)
          return $query->result_array();
        else
          return FALSE;
	}

	function m_shcedule_pmbyrn_enddate($kode_grouppembayaran,$period) {
		$this->db->select('akhir');
		$this->db->from('m_schedule_pembyaran');
		$this->db->where('kode_grouppembayaran',$kode_grouppembayaran);
		$this->db->where('period',$period);

		$query = $this->db->get();
//		echo $this->db->last_query();

		if($query->num_rows() > 0){
          $hasil = $query->row_array();
		  $hasil = date('Y-m-d',strtotime($hasil['akhir']));
		  return $hasil;
		} else {
          return '';
		}
	}

	
	function endofmoth_exists($period_type,$periode,$kode_outlet) {
		$this->db->from('d_endofmonth');
		$this->db->where('kode_outlet', $kode_outlet);
		$this->db->where('period_type', $period_type);
		$this->db->where('periode', $periode);

		$query = $this->db->get();

		if($query->num_rows() > 0)
          return TRUE;
        else
          return FALSE;
	}

	function endofmoth_add($data) {

  		foreach($data['cabang'] as $outlet) {
            unset($data1);
            $period_type = substr($data['periode'], 0, strlen($data['periode'])-6);
            $periode = $this->l_general->rightstr($data['periode'],6);
  		    $data1['period_type'] = $period_type;
  		    $data1['periode'] = $periode;
  		    $data1['kode_outlet'] = $outlet;

    		$this->db->from('d_endofmonth');
    		$this->db->where('period_type', $period_type);
    		$this->db->where('periode', $periode);
    		$this->db->where('kode_outlet', $outlet);

    		$query = $this->db->get();

    		if($query->num_rows() == 0) {
        		if($this->db->insert('d_endofmonth', $data1))
        			$return = TRUE;
        		else
        			$return = FALSE; 
            }
            if($return) {
        		$this->db->where('kode_outlet', $outlet);
        		$this->db->delete('m_eod');
                unset($data1);
      		    $data1['eod_date'] = $this->m_shcedule_pmbyrn_enddate($period_type,$periode);
      		    $data1['kode_outlet'] = $outlet;

          		if($this->db->insert('m_eod', $data1))
          			$return = TRUE;
          		else
          			$return = FALSE;
            }
  		}
        return $return;
	}

	//20130626-By Edo
	function endofmoth_plants_select($admin_id,$kode_grouppembayaran,$periode) {

		if($admin_id === 0)
			$admin_id = $this->obj->session->userdata['ADMIN']['admin_id'];

		$this->db->select('plants,admin_selectall');
		$this->db->from('d_admin');
		$this->db->where('admin_id', $admin_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$admin = $query->row_array();
			
			$admin_selectall=trim($admin['admin_selectall']);
			
			if ($admin_selectall!=''){
			
			//echo $admin_selectall; die();
				$companies = explode(",",$admin_selectall);
				$digit = count($companies) - 1;
				if(empty($companies[$digit]))
					unset($companies[$digit]);
				sort($companies);
				
				$hr_comp = '';
				foreach ($companies as $company) {
					if (trim($company)!='')
						$hr_comp .= "'".trim($company)."',";
				}
				$hr_comp .= '#';
				$hr_comp = trim(str_replace(',#','',$hr_comp));	
				$hr_comp = trim(str_replace('#','',$hr_comp));	

				if ($hr_comp!=''){
					$sqlQuery = "select distinct upper(kode_cabang) as `HR_CODE`from m_employee where kode_grouppembayaran='".$kode_grouppembayaran."' and kode_cabang in (SELECT hr_code FROM m_outlet where COMP_CODE IN (".$hr_comp.")) and kode_cabang not in (SELECT kode_outlet FROM d_endofmonth WHERE period_type='".$kode_grouppembayaran."' AND periode='".$periode."') ORDER BY kode_cabang;";
					
					//echo $sqlQuery;die();
					
					$query = $this->db->query($sqlQuery);

					if($query->num_rows() > 0)
						$hasil =  $query->result_array();
					else
						$hasil = '';
				}				
			} else {

				$temp = substr($admin['plants'], 1); // delete the first space
				$plants = explode(", ", $temp); // get permissions array
				unset($temp);
				sort($plants);

				// check the last array
				// if empty, unset/delete it
				$digit = count($plants) - 1;
				if(empty($plants[$digit]))
					unset($plants[$digit]);

	//			echo "TEMP#2 : <hr>";
	//			print_r($plants);
	//			die("<hr>");
				
				$hr_plant = '';
				foreach ($plants as $plant) {
					if (trim($plant)!='')
						$hr_plant .= "'".trim($plant)."',";
				}
				$hr_plant .= '#';
				$hr_plant = trim(str_replace(',#','',$hr_plant));
				$hr_plant = trim(str_replace('#','',$hr_plant));
				
				if ($hr_plant!=''){
					$sqlQuery = "select distinct upper(kode_cabang) as `HR_CODE`from m_employee where kode_grouppembayaran='".$kode_grouppembayaran."' and kode_cabang in (SELECT hr_code FROM m_outlet where outlet IN (".$hr_plant.")) and kode_cabang not in (SELECT kode_outlet FROM d_endofmonth WHERE period_type='".$kode_grouppembayaran."' AND periode='".$periode."') ORDER BY kode_cabang;";
					
					$query = $this->db->query($sqlQuery);

					if($query->num_rows() > 0)
						$hasil =  $query->result_array();
					else
						$hasil = '';
				}
			}
			return $hasil;
			

		} else {
			return FALSE;
		}
	}
	//20130626-By Edo
	
}

/* End of file m_admin.php */
/* Location: ./system/application/models/m_admin.php */