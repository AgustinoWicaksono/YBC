<?php
class gistonew_dept extends Controller {
	private $jagmodule = array();


	function gistonew_dept() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1028);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_gisto'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_general');
		$this->load->model('m_database');
		$this->load->model('m_gistonew_dept');

		$this->lang->load('calendar', $this->session->userdata('lang_name'));
		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_auth', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
		$this->lang->load('g_calendar', $this->session->userdata('lang_name'));
	}

	// main function
	function index()
	{
		$this->browse();
	}

	// list data
	function browse() {
		$gistonew_dept_browse_result = $this->session->userdata['PAGE']['gistonew_dept_browse_result'];

		if(!empty($gistonew_dept_browse_result))
			redirect($this->session->userdata['PAGE']['gistonew_dept_browse_result']);
		else
			redirect('gistonew_dept/browse_result/0/0/0/0/0/0/0/10');

	}

	// search data
	function browse_search() {

		if(empty($_POST['field_content'])) {
			$field_content = 0;
		} else {
			$field_content = $_POST['field_content'];
		}

		if(empty($_POST['date_from']) || ($_POST['date_from'] == '--')) {
			$date_from = 0;
		} else {
			$date = explode("-", $_POST['date_from']);
			$date_from = $date[2].$date[1].$date[0];
			unset($date);
		}

		if(empty($_POST['date_to']) || ($_POST['date_to'] == '--')) {
			$date_to = 0;
		} else {
			$date = explode("-", $_POST['date_to']);
			$date_to = $date[2].$date[1].$date[0];
			unset($date);
		}

		if(empty($_POST['limit'])) {
			$limit = 10;
		} else {
			$limit = $_POST['limit'];
		}

//		redirect('gistonew_dept/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('gistonew_dept/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('gistonew_dept_browse_result');

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);

		$object['form2'] = array(
			'name'	=>	'form2',
			'id'	=>	'form2',
		);
		// end of form attributes

		$object['data']['field_name'] = $field_name;
		$object['data']['field_type'] = $field_type;

		if($field_content !== '0') {
			$object['data']['field_content'] = $field_content;
		} else {
			$object['data']['field_content'] = '';
		}

		if($date_from !== '0') {
			$year = substr($date_from, 0, 4);
			$month = substr($date_from, 4, 2);
			$day = substr($date_from, 6, 2);
			$object['data']['date_from'] = $day."-".$month."-".$year;
			$date_from2 = $year.'-'.$month.'-'.$day.' 00:00:00';
		} else {
			$object['data']['date_from'] = '';
			$date_from2 = '0';
		}

		if($date_to !== '0') {
			$year = substr($date_to, 0, 4);
			$month = substr($date_to, 4, 2);
			$day = substr($date_to, 6, 2);
			$object['data']['date_to'] = $day."-".$month."-".$year;
			$date_to2 = $year.'-'.$month.'-'.$day.' 23:59:59';
		} else {
			$object['data']['date_to'] = '';
			$date_to2 = '0';
		}

		unset($year);
		unset($month);
		unset($day);
/*
		$object['data']['sort1'] = $sort1;
		$object['data']['sort2'] = $sort2;
		$object['data']['sort3'] = $sort3;
*/
		$object['data']['sort'] = $sort;

		$object['data']['status'] = $status;
		$object['data']['limit'] = $limit;
		$object['data']['start'] = $start;

		$object['field_name'] = array (
			'a'	=>	'Goods Receipt No',
			'b'	=>	'Purchase Order No',
			'c'	=>	'Vendor Code',
			'd'	=>	'Vendor Name',
		);

		$object['field_type'] = array (
			'part'	=>	'Any Part of Field',
			'all'	=>	'All Part of Field',
		);

		$object['status'] = array (
			'0'	=>	'',
			'1'	=>	'Not Approved',
			'2'	=>	'Approved',
		);
/*
		$object['sort'] = array (
			'gy'	=>	'Goods Receipt No ASC',
			'gz'	=>	'Goods Receipt No DESC',
			'py'	=>	'Purchase Order No ASC',
			'pz'	=>	'Purchase Order No DESC',
			'vy'	=>	'Vendor Code ASC',
			'vz'	=>	'Vendor Code DESC',
			'ny'	=>	'Vendor Name ASC',
			'nz'	=>	'Vendor Name DESC',
			'dy'	=>	'Posting Date ASC',
			'dz'	=>	'Posting Date DESC',
		);
*/

		$sort_link1 = 'gistonew_dept/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
		$sort_link2 = '/'.$limit.'/';

		$object['sort_link'] = array (
			'ay'	=>	$sort_link1.'ay'.$sort_link2,
			'az'	=>	$sort_link1.'az'.$sort_link2,
			'by'	=>	$sort_link1.'by'.$sort_link2,
			'bz'	=>	$sort_link1.'bz'.$sort_link2,
			'cy'	=>	$sort_link1.'cy'.$sort_link2,
			'cz'	=>	$sort_link1.'cz'.$sort_link2,
			'dy'	=>	$sort_link1.'dy'.$sort_link2,
			'dz'	=>	$sort_link1.'dz'.$sort_link2,
			'ey'	=>	$sort_link1.'ey'.$sort_link2,
			'ez'	=>	$sort_link1.'ez'.$sort_link2,
			'fy'	=>	$sort_link1.'fy'.$sort_link2,
			'fz'	=>	$sort_link1.'fz'.$sort_link2,
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 11;
		$config['base_url'] = site_url('gistonew_dept/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_gistonew_dept->gistonew_dept_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['gistonew_dept_headers'] = $this->m_gistonew_dept->gistonew_dept_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Transfer Out Inter Departement';
		$this->template->write_view('content', 'gistonew_dept/gistonew_dept_browse', $object);
		$this->template->render();

	}

	// input data
	function input() {

		// if $data exist, add to the $object array lama
		/*if ( count($_POST) != 0) {
			$data = $_POST;
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;
			$object['data']['receiving_plant'] = 0;
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

        $gistonew_dept_detail_tmp = array('gistonew_dept_detail' => '');
        $this->session->unset_userdata($gistonew_dept_detail_tmp);
        unset($gistonew_dept_detail_tmp);
		$whs=$this->session->userdata['ADMIN']['plant'];
		mysql_connect("localhost","root","");
		mysql_select_db("sap_php");
		$rq=mysql_fetch_array(mysql_query("SELECT otd_code FROM m_outlet where OUTLET ='$whs'"));
		$pl=$rq['otd_code'];
		//print_r($pl);F
  		$data['plants'] = $this->m_general->sap_plants_select_all_outlet1($pl);
  		if($data['plants'] !== FALSE) {
  			$object['receiving_plant'][0] = '';
  			foreach ($data['plants'] as $plant) {
  				$object['receiving_plant'][$plant['plant']] = $plant['plant'].' - '.$plant['plant_name'] ;
  			}
  		}
		
		

		if(!empty($data['receiving_plant'])) {
			$data['item_groups'] = $this->m_general->sap_item_groups_select_all_gisto();

			if($data['item_groups'] !== FALSE) {
				$object['item_group_code'][0] = '';
				$object['item_group_code']['all'] = '==All==';

				foreach ($data['item_groups'] as $item_group) {
					$object['item_group_code'][$item_group['DSNAM']] = $item_group['DSNAM'];
				}
			}
		}
		
		$data['item_groups'] = $this->m_general->sap_item_groups_select_all_gisto();

			if($data['item_groups'] !== FALSE) {
				$object['item_group_code'][0] = '';
				$object['item_group_code']['all'] = '==All==';

				foreach ($data['item_groups'] as $item_group) {
					$object['item_group_code'][$item_group['DSNAM']] = $item_group['DSNAM'];
				}
			}
		
		

		if(!empty($data['item_group_code'])) {

			$object['item_choose'][0] = '';
			$object['item_choose'][1] = 'Kode';
			$object['item_choose'][2] = 'Nama';

		}

		if(!empty($data['item_choose'])) {
			redirect('gistonew_dept/input2/'.$data['receiving_plant'].'/'.$data['item_group_code'].'/'.$data['item_choose']);
		}

		$object['page_title'] = 'Good Issue Stock Transfer antar Departement';
		$this->template->write_view('content', 'gistonew_dept/gistonew_dept_input', $object);
		$this->template->render(); */
		
		// baru 
		
		$gistonew_dept_detail_tmp = array('gistonew_dept_detail' => '');
        $this->session->unset_userdata($gistonew_dept_detail_tmp);
        unset($gistonew_dept_detail_tmp);
	
		
		if ( count($_POST) != 0) {
//		if(!empty($_POST['kd_vendor'])) {
			$data = $_POST;
			$object['data'] = $data;

            $gr_quantity = array('gr_quantity' => '');
            $this->session->unset_userdata($gr_quantity);

		} else {
			$object['data'] = NULL;

			$object['data']['do_no'] = 0;
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes
		

        if(empty($this->session->userdata['do_nos'])||empty($data)) {
    		$data['do_nos'] = $this->m_gistonew_dept->sap_do_select_all();
      		$this->session->set_userdata('do_nos', $data['do_nos']);
        } else {
            $data['do_nos'] = $this->session->userdata['do_nos'];
        }

		if($data['do_nos'] !== FALSE) {
			$object['do_no'][0] = '';
			foreach ($data['do_nos'] as $do_no) {
				$object['do_no'][$do_no['VBELN']] = $do_no['VBELN'];
			}
		}
		//print_r($do_no['VBELN']);

		if(!empty($data['do_no'])) {
			$object['data']['gistonew_dept_header'] = $this->m_gistonew_dept->sap_gistonew_dept_header_select_by_do_no($data['do_no']);
			$data['delivery_date'] = $object['data']['gistonew_dept_header']['DELIV_DATE'];

    		$data['item_groups'] = $this->m_gistonew_dept->sap_gistonew_dept_select_item_group_do($data['do_no']);

   			$object['item_group_code'][0] = '';
   			$object['item_group_code']['all'] = '==All==';

    		if($data['item_groups'] !== FALSE) {
    			foreach ($data['item_groups'] as $item_group) {
    			   $object['item_group_code'][$item_group] = $item_group;
    			}
    		}
		}


		if(!empty($data['item_group_code'])) {
			redirect('gistonew_dept/input2/'.$data['do_no'].'/'.$data['item_group_code'].'/'.$data['delivery_date']);
		}

		$object['page_title'] = 'Transfer Out Inter Departement <div style="font-weight:normal;font-size:80%;font-style:italic;"></div>';
		$this->template->write_view('content', 'gistonew_dept/gistonew_dept_input', $object);
		$this->template->render();


	}

	function input2()	{

		$validation = FALSE;

		if(count($_POST) != 0) {

			// first post, assume all data TRUE
			$validation_temp = TRUE;

			$count = count($_POST['gistonew_dept_detail']['id_gistonew_dept_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field
				$a = 1;

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
				$qty_to_check = $_POST['gistonew_dept_detail']['outstanding_qty'][$i];
				$gr=$_POST['gistonew_dept_detail']['gr_quantity'][$i];
				$item=$_POST['gistonew_dept_detail']['material_no'][$i];
				$check_qty = $qty_to_check < $gr;
				
					$check[$j] = $this->l_form_validation->set_rules($_POST['gistonew_dept_detail']['gr_quantity'][$i], "gistonew_dept_detail[gr_quantity][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE || $check_qty == TRUE)
						$validation_temp = FALSE;
						//print_r();

					$j++;
					
					$stock=$_POST['gistonew_dept_detail']['stock'][$i];
				$qty=$_POST['gistonew_dept_detail']['gr_quantity'][$i];
				if ($qty > $stock || $qty_to_check < $gr)
				{
					$check[$j] = $this->l_form_validation->set_rules(0, "gistonew_dept_detail[gr_quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;
				}
					
					if ( $qty_to_check < $gr || $gr <= 0)
					{
					$check[$j] = $this->l_form_validation->set_rules(0, "gistonew_dept_detail[gr_quantity][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE || $check_qty == TRUE)
						$validation_temp = FALSE;
						//print_r();

					$j++;
					}
					
					
					$db_mysql=$this->m_database->get_db_mysql();
					$user_mysql=$this->m_database->get_user_mysql();
					$pass_mysql=$this->m_database->get_pass_mysql();
					$db_sap=$this->m_database->get_db_sap();
					$user_sap=$this->m_database->get_user_sap();
					$pass_sap=$this->m_database->get_pass_sap();
					$host_sap=$this->m_database->get_host_sap();
					$con = mysql_connect("localhost",$user_mysql,$pass_mysql);
					mysql_select_db($db_mysql,$con);
					
					$cek_req=mysql_num_rows(mysql_query("SELECT BATCH FROM m_item WHERE MATNR='$item' AND BATCH='Y'",$con));
					mysql_close($con);
					if ($cek_req == 1)
					{
					$check[$j] = $this->l_form_validation->set_rules($_POST['gistonew_dept_detail']['num'][$i], "gistonew_dept_detail[num][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE )
						$validation_temp = FALSE;
						//print_r();

					$j++;
					}
					
					
}
/*
			$object['gistonew_dept_details'] = $this->m_gistonew_dept->sap_gistonew_dept_details_select_by_do_no($_POST['gistonew_dept_header']['do_no']);
			$i = 1;
			foreach ($object['gistonew_dept_details'] as $object['gistonew_dept_detail']) {
                if ($i==$_POST['gistonew_dept_detail']['id_gistonew_dept_h_detail'][$i]) {
					$check[$i] = $this->l_form_validation->set_rules($_POST['gistonew_dept_detail']['gr_quantity'][$i], "gistonew_dept_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['gistonew_dept_detail']['LFIMG']);

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$i]['error'] == TRUE)
						$validation_temp = FALSE;
                }
				$i++;
			}
  */
			// set $validation, based on $validation_temp value;
			$validation = $validation_temp;

		}

		if ($validation == FALSE) {

	   	if(!empty($_POST)) {
	   		$data = $_POST;
	 			$this->_input_form(0, $data, $check);
	   	} else {
	 			$this->_input_form();
			}

		} else {

			if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {
				$this->_input_add();
			} else {
			
    	   		$data = $_POST;
	 			$this->_input_form(0, $data, $check);
				
			}
		}

	}


	function input_error($error_text) {
      $this->jagmodule['error_code'] = '001'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function edit_error($error_text) {
      $this->jagmodule['error_code'] = '002'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function _input_form($reset = 0, $data = NULL, $check = NULL) {
		// if data added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;
		$object['data'] = $data;
		$object['check'] = $check;

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$do_no = $this->uri->segment(3);
		$item_group_code = $this->uri->segment(4);
		$delivery_date = $this->uri->segment(5);

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

    	if(!empty($do_no)) {
           	$object['gistonew_dept_header']['plant'] = $this->session->userdata['ADMIN']['plant'];
           	$object['gistonew_dept_header']['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
            $object['gistonew_dept_header']['item_group_code'] = $item_group_code;
			$object['gistonew_dept_header']['VBELN'] = $do_no;
       		$object['gistonew_dept_header']['delivery_date'] = $delivery_date;

			if ((!empty($item_group_code)) || (trim($item_group_code)!="")) {
        		if($item_group_code == 'all') {
        			$object['item_group']['item_group_code'] = $item_group_code;
        			$object['item_group']['item_group_name'] = '<strong>All</strong>';
                    $object['gistonew_dept_details'] = $this->m_gistonew_dept->sap_gistonew_dept_details_select_by_do_no($do_no);
        		} else {
        			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
        			$object['item_group']['item_group_name'] = $item_group_code;
        			$object['gistonew_dept_details'] = $this->m_gistonew_dept->sap_gistonew_dept_details_select_by_do_and_item_group($do_no, $object['item_group']['DISPO']);
        		}
            }
    	}
		

		if(($object['gistonew_dept_details'] !== FALSE)&&(!empty($object['gistonew_dept_details']))) {
			$i = 1;
			foreach ($object['gistonew_dept_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['gistonew_dept_detail'][$key][$i] = $value;
					//echo $value;
				}
				$i++;
				unset($object['temp']);
				//$object['temp'] = '';
			}
		}
		if(count($_POST) == 0) {
    		$object['data']['gistonew_dept_details'] = $this->m_gistonew_dept->gistonew_dept_details_select($object['data']['id_gistonew_dept_header']);

    		if($object['data']['gistonew_dept_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['gistonew_dept_details']->result_array() as $object['temp']) {
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['gistonew_dept_detail'][$key][$i] = $value;
						
    				}
    				$i++;
    				unset($object['temp']);
					//$object['temp'] = '';
    			}
    		}
        }


		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Transfer Out Inter Departement<div style="font-weight:normal;font-size:80%;font-style:italic;"></div>';
		$this->template->write_view('content', 'gistonew_dept/gistonew_dept_edit', $object);
		$this->template->render();
	}

	function _input_add() {
	
		// start of assign variables and delete not used variables
		$gistonew_dept = $_POST;
		unset($gistonew_dept['gistonew_dept_header']['id_gistonew_dept_header']);
		unset($gistonew_dept['button']);
		// end of assign variables and delete not used variables

		$count = count($gistonew_dept['gistonew_dept_detail']['id_gistonew_dept_h_detail']) - 1;

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('gistonew_dept/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($gistonew_dept['gistonew_dept_header']['posting_date'])==FALSE)) {
     	   redirect('gistonew_dept/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {


			$this->db->trans_start();

   			$this->session->set_userdata('gistonew_dept_detail', $gistonew_dept['gistonew_dept_detail']);
			
    		$gistonew_dept_header['plant'] = $this->session->userdata['ADMIN']['plant'];
			$plant=$gistonew_dept_header['plant'];
    		$gistonew_dept_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
			$storage=$gistonew_dept_header['storage_location'];
 			$gistonew_dept_header['posting_date'] = $this->l_general->str_to_date($gistonew_dept['gistonew_dept_header']['posting_date']);
			$posting=$gistonew_dept_header['posting_date'];
			$gistonew_dept_header['id_gistonew_dept_plant'] = $this->m_gistonew_dept->id_gistonew_dept_plant_new_select($gistonew_dept_header['plant'],$gistonew_dept_header['posting_date']);
			$id=$gistonew_dept_header['id_gistonew_dept_plant'];

 			$gistonew_dept_header['receiving_plant'] = $gistonew_dept['gistonew_dept_header']['receiving_plant'];
			$receive=$gistonew_dept_header['receiving_plant'];
 			$gistonew_dept_header['receiving_plant_name'] = $gistonew_dept['gistonew_dept_header']['receiving_plant_name'];
			$rec_name=$gistonew_dept_header['receiving_plant_name'];

 			$gistonew_dept_header['po_no'] = $gistonew_dept['gistonew_dept_header']['po_no'];
			$base= $gistonew_dept['gistonew_dept_header']['po_no'];
			$object['data']['gistonew_dept_header'] = $this->m_gistonew_dept->sap_gistonew_dept_header_select_by_do_no($base);
			$data['to_plant'] = $object['data']['gistonew_dept_header']['PLANT'];
			$to=$data['to_plant'];
			$gistonew_dept_header['to_plant'] = $data['to_plant'];
			$gistonew_dept_header['gistonew_dept_no'] = '';

			if(isset($_POST['button']['approve']))
				$gistonew_dept_header['status'] = '2';
			else
				$gistonew_dept_header['status'] = '1';
				
			

			$gistonew_dept_header['item_group_code'] = $gistonew_dept['gistonew_dept_header']['item_group_code'];
			$gistonew_dept_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
			$status=$gistonew_dept_header['status'];
			$group=$gistonew_dept_header['item_group_code'];
			$user=$gistonew_dept_header['id_user_input'];


         //   $web_trans_id = $this->l_general->_get_web_trans_id($gistonew_dept_header['plant'],$gistonew_dept_header['posting_date'],
           //           $gistonew_dept_header['id_gistonew_dept_plant'],'04');
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $gistonew_dept_to_approve = array (
                      'plant' => $gistonew_dept_header['plant'],
                      'posting_date' => date('Ymd',strtotime($gistonew_dept_header['posting_date'])),
                      'id_user_input' => $gistonew_dept_header['id_user_input'],
                    //  'web_trans_id' => $web_trans_id,
                      'receiving_plant' => $gistonew_dept_header['receiving_plant'],
					  'po_no'=>$base
                );
              }

			if($id_gistonew_dept_header = $this->m_gistonew_dept->gistonew_dept_header_insert($gistonew_dept_header)) {
//$this->m_gistonew_dept->gistonew_dept_header_insert($gistonew_dept_header);

                $input_detail_success = FALSE;
				$input_batch_success = FALSE;
				for($i = 1; $i <= $count; $i++) {

					if((!empty($gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i]))&&(!empty($gistonew_dept['gistonew_dept_detail']['material_no'][$i]))) {

						$gistonew_dept_detail['id_gistonew_dept_header'] = $id_gistonew_dept_header;
						$batch['BaseEntry']= $id_gistonew_dept_header;
						$gistonew_dept_detail['gr_quantity'] = $gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i];
						$batch['Quantity'] =  $gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i];
						$gistonew_dept_detail['id_gistonew_dept_h_detail'] = $gistonew_dept['gistonew_dept_detail']['id_gistonew_dept_h_detail'][$i];
						$batch['BaseLinNum']=$gistonew_dept['gistonew_dept_detail']['id_gistonew_dept_h_detail'][$i];
						$batch['Createdate']=date('Y-m-d');
						
						$batch['BatchNum']=$gistonew_dept['gistonew_dept_detail']['num'][$i];
						$batch['BaseType']=11;
						$Whs=$gistonew_dept_header['plant'];
						$item = $this->m_general->sap_item_select_by_item_code($gistonew_dept['gistonew_dept_detail']['material_no'][$i]);
						
  						$gistonew_dept_detail['material_no'] = $gistonew_dept['gistonew_dept_detail']['material_no'][$i];
						$gistonew_dept_detail['num'] = $gistonew_dept['gistonew_dept_detail']['num'][$i];
						$gistonew_dept_detail['outstanding_qty'] = $gistonew_dept['gistonew_dept_detail']['outstanding_qty'][$i];
						$batch['ItemCode'] = $gistonew_dept['gistonew_dept_detail']['material_no'][$i];
  						$gistonew_dept_detail['material_desc'] = $gistonew_dept['gistonew_dept_detail']['material_desc'][$i];
  						$gistonew_dept_detail['uom'] = $gistonew_dept['gistonew_dept_detail']['uom'][$i];
						$gistonew_dept_detail['uom_req'] = $gistonew_dept['gistonew_dept_detail']['uom_req'][$i];
						$gistonew_dept_detail['posnr'] = $gistonew_dept['gistonew_dept_detail']['posnr'][$i];
						$gistonew_dept_detail['stock'] = $gistonew_dept['gistonew_dept_detail']['stock'][$i];
						if(isset($_POST['button']['approve']))
						$batch['status'] = '2';
						else
						$bacth['status'] = '1';
					
						
						$db_mysql=$this->m_database->get_db_mysql();
						$user_mysql=$this->m_database->get_user_mysql();
						$pass_mysql=$this->m_database->get_pass_mysql();
						$db_sap=$this->m_database->get_db_sap();
						$user_sap=$this->m_database->get_user_sap();
						$pass_sap=$this->m_database->get_pass_sap();
						$host_sap=$this->m_database->get_host_sap();
						$con = mysql_connect("localhost",$user_mysql,$pass_mysql);
						mysql_select_db($db_mysql,$con);
						$c=mssql_connect($host_sap,$user_sap,$pass_sap);
						$b=mssql_select_db($db_sap,$c);
						$line=$gistonew_dept_detail['posnr'];
						$posnr=$gistonew_dept_detail['posnr'];
						$tem=mssql_query("SELECT U_grqty_web FROM WTQ1 where DocEntry = '$base' AND LineNum ='$line'");
						$rem=mssql_fetch_array($tem);
						//$gr_qty1=$rem['U_grqty_web'];
						$realoutstanding = $gistonew_dept['gistonew_dept_detail']['outstanding_qty'][$i];
						
						
						$t=mysql_query("SELECT Quantity FROM m_batch WHERE ItemCode = '$batch[ItemCode]' AND DistNumber='$batch[BatchNum]' AND Whs='$Whs'",$con);
						$r=mysql_fetch_array($t);
						$qty=$r['Quantity'];
						$NewQty=$qty-$batch['Quantity'];
						
						//echo 'kampret2';
						if ($batch['BatchNum'] !== '')
						{
							$this->m_gistonew_dept->batch_insert($batch);
							
							$input_batch_success= TRUE;
							mysql_query("UPDATE m_batch SET Quantity='$NewQty' WHERE ItemCode = '$batch[ItemCode]' AND DistNumber='$batch[BatchNum]' AND Whs='$Whs'",$con);
						}
						mysql_close($con);
                        //array utk parameter masukan pada saat approval
                        /*$gistonew_dept_to_approve['item'][$i] = $gistonew_dept_detail['id_gistonew_dept_h_detail'];
                        $gistonew_dept_to_approve['material_no'][$i] = $gistonew_dept_detail['material_no'];
                        $gistonew_dept_to_approve['gr_quantity'][$i] = $gistonew_dept_detail['gr_quantity'];
                        if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                            $gistonew_dept_to_approve['uom'][$i] = $gistonew_dept_detail['uom'];
                        } else {
                            $gistonew_dept_to_approve['uom'][$i] = $item['MEINS'];
                        } */
						
                        //
						$c=mssql_connect("192.168.0.22","sa","M$1S@p!#@");
						$b=mssql_select_db('MSI',$c);
						$line=$i-1;
						$tem=mssql_query("SELECT U_grqty_web FROM WTQ1 where DocEntry = '$base' AND LineNum ='$posnr'");
						$temCek=mssql_query("SELECT * FROM WTQ1 where DocEntry = '$base'");
						$cekLine=mssql_num_rows($temCek);
						$rem=mssql_fetch_array($tem);
						$gr_qty1=$rem['U_grqty_web'];
						$realoutstanding = $grpodlv_dept_detail_to_save['outstanding_qty'];
						
						$outstanding =$grpodlv_dept_detail['LFIMG'];
						$gr_qty = $gr_qty1 + $gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i];
						
						if($this->m_gistonew_dept->gistonew_dept_detail_insert($gistonew_dept_detail) )
							unset($gistonew_dept_detail);
                          $input_detail_success = TRUE;
						 // echo "xxxxx";
						  if ($input_detail_success === TRUE) 
						  {
						  	if(isset($_POST['button']['approve']))
							{
							 if ($outstanding == 0 && $count==$cekLine )
							 { 
							// echo "UBAH";
							 mssql_query("UPDATE OWTQ SET U_Stat = 1 WHERE DOcEntry = '$base' ");
							 }
							 mssql_query("UPDATE WTQ1 SET U_grqty_web = '$gr_qty'  WHERE DocEntry = '$base' AND LineNum ='$posnr'");
							 //echo "UPDATE OWTQ SET U_Stat = 1 WHERE DOcEntry = '$base' ";
							 //echo "UPDATE WTQ1 SET U_grqty_web = '$gr_qty'  WHERE DocEntry = '$base'";
							 unset($_SESSION['gistonew_dept_detail']);
							}

						  }

						  
					}

				}

			}

            $this->db->trans_complete();

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			    /*$approved_data = $this->m_gistonew_dept->sap_gistonew_dept_header_approve($gistonew_dept_to_approve);
    			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')
                    && (trim($approved_data['po_document']) !== '')) {
    			  */  $gistonew_dept_no = '';//$approved_data['material_document'];
    			   // $po_no = '';//$approved_data['po_document'];
    				$data = array (
    					'id_gistonew_dept_header'	=>$id_gistonew_dept_header,
    					'gistonew_dept_no'	=>	$gistonew_dept_no,
    					'po_no'	=>	$base,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_gistonew_dept->gistonew_dept_header_update($data);
  				    $approve_data_success = TRUE;
					
				} else {
				  $approve_data_success = FALSE;
				}
            //}


            if(isset($_POST['button']['save'])) {
			//echo 'kampret2';
              if ($input_detail_success === TRUE && $input_batch_success === TRUE) {
			    $this->l_general->success_page('Data Transfer Out Inter Departement berhasil dimasukkan', site_url('gistonew_dept/input'));

              } 
			  else if ($input_batch_success === FALSE)
			  {
			  	$this->m_gistonew_dept->gistonew_dept_header_delete($id_gistonew_dept_header);
 			    $this->$this->jagmodule['error_code'] = '003';
		        $this->l_general->error_page($this->jagmodule, 'Quantity Melebihi Stock yang Ada', site_url($this->session->userdata['PAGE']['next']));
			  }
			  else {
			    $this->m_gistonew_dept->gistonew_dept_header_delete($id_gistonew_dept_header);
 			    $this->$this->jagmodule['error_code'] = '003';
		        $this->l_general->error_page($this->jagmodule, 'Data Transfer Out Inter Departement tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));

              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Transfer Out Inter Departement berhasil diapprove', site_url('gistonew_dept/input'));
              } 
			  else if ($input_batch_success === FALSE)
			  {
			  	$this->m_gistonew_dept->gistonew_dept_header_delete($id_gistonew_dept_header);
 			    $this->$this->jagmodule['error_code'] = '003';
		        $this->l_general->error_page($this->jagmodule, 'Quantity Melebihi Stock yang Ada', site_url($this->session->userdata['PAGE']['next']));
			  }else {
                $this->m_gistonew_dept->gistonew_dept_header_delete($id_gistonew_dept_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer Out Inter Departement tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'DataGood Issue Stock Transfer antar Departement tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('gistonew_dept/input2');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'DataGood Issue Stock Transfer antar Departement berhasil diapprove';
		$object['refresh_url'] = site_url('gistonew_dept/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'DataGood Issue Stock Transfer antar Departement berhasil dimasukkan';
//		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['refresh_url'] = site_url('gistonew_dept/input');
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function input_error($error_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $error_text;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}
           */

	function edit() {

		$item_choose = $this->uri->segment(6);
		
	    $gistonew_dept_header = $this->m_gistonew_dept->gistonew_dept_header_select($this->uri->segment(3));
		
		$status = $gistonew_dept_header['status'];
        unset($gistonew_dept_header);

        $gistonew_dept_detail_tmp = array('gistonew_dept_detail' => '');
        $this->session->unset_userdata($gistonew_dept_detail_tmp);
        unset($gistonew_dept_detail_tmp);

		$validation = FALSE;

		if(($status !== '2')&&(count($_POST) != 0)) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['gistonew_dept_detail']['id_gistonew_dept_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
				
					$count2 = $count - 1;
					
				else
					$count2 = $count;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['gistonew_dept_detail']['material_no'][$i], "gistonew_dept_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['gistonew_dept_detail']['gr_quantity'][$i], "gistonew_dept_detail[gr_quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

                    if(isset($_POST['button']['delete'])) {
                        $check[$j] = $this->l_form_validation->set_rules($_POST['delete'][$i], "delete[$i]", 'Tick Mark Delete. '.$i, 'required');

    					// if one data FALSE, set $validation_temp to FALSE
    					if($check[$j]['error'] == TRUE)
    						$validation_temp = FALSE;

    					$j++;
                    }
				}

				// set $validation, based on $validation_temp value;
				$validation = $validation_temp;

			}

		}


		if ($validation == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$gistonew_dept_header = $this->m_gistonew_dept->gistonew_dept_header_select($this->uri->segment(3));

				if($gistonew_dept_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['gistonew_dept_header'] = $this->m_gistonew_dept->gistonew_dept_header_select($this->uri->segment(3));
				$this->_edit_form(0, $data, $check);
			 }

		} else {

			if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {
				$this->_edit_update();
			} else {
//	 		  	$this->_edit_form(0, $data, $check);
	 		  	$this->_input_form(0, $data, $check);
			}

		}

	}

	function _edit_form($reset = 0, $data = NULL, $check = NULL) {
		// if data added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;
		$object['data'] = $data;
		$object['check'] = $check;

		if(isset($_POST['button']['add']) || isset($_POST['delete'])) {
          $gistonew_dept_detail_tmp = array('gistonew_dept_detail' => '');
          $this->session->unset_userdata($gistonew_dept_detail_tmp);
          unset($gistonew_dept_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['gistonew_dept_header']['status_string'] = ($object['data']['gistonew_dept_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$receiving_plant = $data['gistonew_dept_header']['receiving_plant'];
		$item_group_code = $data['gistonew_dept_header']['item_group_code'];
		
		$item_choose = $this->uri->segment(6);

/*		if(count($_POST) == 0) {
			$item_group_code = $data['gistonew_dept_header']['item_group_code'];
		} else {
			$item_group_code = $data['item_group']['item_group_code'];
		}
*/
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['receiving_plant'] = $this->m_general->sap_plant_select_2($receiving_plant);
		
//exit;
		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
			$data['items'] = $this->m_general->sap_item_groups_select_all_gisto();
		} else {
			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
			$object['item_group']['item_group_code'] = $item_group_code;
			$data['items'] = $this->m_general->sap_items_select_by_item_group($item_group_code, $item_choose, 'gist');
		}

		if($data['items'] !== FALSE) {
			$object['item'][''] = '';

			foreach ($data['items'] as $data['item']) {
				if($item_choose == 1) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MATNR1'].' - '.$data['item']['MAKTX'].' ('.$data['item']['UNIT'].')';
				} elseif ($item_choose == 2) {
					$object['item'][$data['item']['MATNR']] = $data['item']['MAKTX'].' - '.$data['item']['MATNR1'].' ('.$data['item']['UNIT'].')';
				}
			}
		}

        if(!empty($object['item'])) {
    		if($item_choose == 1) {
              ksort($object['item']);
    		} elseif ($item_choose == 2) {
              asort($object['item']);
            }
        }


		if(count($_POST) == 0) {
			$object['data']['gistonew_dept_details'] = $this->m_gistonew_dept->gistonew_dept_details_select($object['data']['gistonew_dept_header']['id_gistonew_dept_header']);

			if($object['data']['gistonew_dept_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['gistonew_dept_details']->result_array() as $object['temp']) {
	//				$object['data']['gistonew_dept_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['gistonew_dept_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
			$object['data']['batch'] = $this->m_gistonew_dept->batch($object['data']['batch']['ItemCode']);

			if($object['data']['batch'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['batch']->result_array() as $object['temp']) {
	//				$object['data']['gistonew_dept_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['batch'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Transfer Out Inter Departement';
		$this->template->write_view('content', 'gistonew_dept/gistonew_dept_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$gistonew_dept = $_POST;
		unset($gistonew_dept['gistonew_dept_header']['id_gistonew_dept_header']);
		unset($gistonew_dept['button']);
		// end of assign variables and delete not used variables

		$count = count($gistonew_dept['gistonew_dept_detail']['id_gistonew_dept_h_detail']) - 1;

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

//echo "<pre>";
//print 'array ';
//print_r($gistonew_dept['gistonew_dept_detail']);
//echo "</pre>";
//exit;

		if($gr_quantity_exist == FALSE)
			redirect('gistonew_dept/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($gistonew_dept['gistonew_dept_header']['posting_date'])==FALSE)) {
     	   redirect('gistonew_dept/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('gistonew_dept_detail', $gistonew_dept['gistonew_dept_detail']);

            $id_gistonew_dept_header = $this->uri->segment(3);
            $postingdate = $this->l_general->str_to_date($gistonew_dept['gistonew_dept_header']['posting_date']);
			$id_gistonew_dept_plant = $this->m_gistonew_dept->id_gistonew_dept_plant_new_select("",$postingdate,$id_gistonew_dept_header);
			$base=$gistonew_dept['gistonew_dept_header']['po_no'];

    			$data = array (
    				'id_gistonew_dept_header' => $id_gistonew_dept_header,
                    'id_gistonew_dept_plant' => $id_gistonew_dept_plant,
    				'posting_date' => $postingdate,
					'po_no'=>$gistonew_dept['gistonew_dept_header']['po_no'],
    			);

                $this->m_gistonew_dept->gistonew_dept_header_update($data);
                $edit_gistonew_dept_header = $this->m_gistonew_dept->gistonew_dept_header_select($id_gistonew_dept_header);

//       echo "<pre>";
//       print_r($gistonew_dept['gistonew_dept_detail']);
//       echo "</pre>";
//       exit;

    			if ($this->m_gistonew_dept->gistonew_dept_header_update($data)) {
				
                    $input_detail_success = FALSE;
    			    if($this->m_gistonew_dept->gistonew_dept_details_delete($id_gistonew_dept_header) && $this->m_gistonew_dept->batch_delete($id_gistonew_dept_header)) {
						for($i = 1; $i <= $count; $i++) {
        					if((!empty($gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i]))&&(!empty($gistonew_dept['gistonew_dept_detail']['material_no'][$i]))) {
								
        						$gistonew_dept_detail['id_gistonew_dept_header'] = $id_gistonew_dept_header;
								$batch['BaseEntry'] = $id_gistonew_dept_header;
        						$gistonew_dept_detail['gr_quantity'] = $gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i];
								$batch['Quantity'] = $gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i];
        						$gistonew_dept_detail['id_gistonew_dept_h_detail'] = $gistonew_dept['gistonew_dept_detail']['id_gistonew_dept_h_detail'][$i];
								$batch['BaseLinNum'] = $gistonew_dept['gistonew_dept_detail']['id_gistonew_dept_h_detail'][$i];

        						$gistonew_dept_detail['material_no'] = $gistonew_dept['gistonew_dept_detail']['material_no'][$i];
								$gistonew_dept_detail['num'] = $gistonew_dept['gistonew_dept_detail']['num'][$i];
								$batch['ItemCode'] = $gistonew_dept['gistonew_dept_detail']['material_no'][$i];
								$batch['BatchNum'] = $gistonew_dept['gistonew_dept_detail']['num'][$i];
								$batch['Createdate'] = $postingdate;
        						$gistonew_dept_detail['material_desc'] = $gistonew_dept['gistonew_dept_detail']['material_desc'][$i];
        						$gistonew_dept_detail['uom'] = $gistonew_dept['gistonew_dept_detail']['uom'][$i];
								$gistonew_dept_detail['uom_req'] = $gistonew_dept['gistonew_dept_detail']['uom_req'][$i];
								$gistonew_dept_detail['posnr'] = $gistonew_dept['gistonew_dept_detail']['posnr'][$i];
								$gistonew_dept_detail['stock'] = $gistonew_dept['gistonew_dept_detail']['stock'][$i];
								$line=$gistonew_dept['gistonew_dept_detail']['posnr'][$i];
								
						
								$c=mssql_connect("192.168.0.22","sa","M$1S@p!#@");
						$b=mssql_select_db('MSI_TRIAL',$c);
						$tem=mssql_query("SELECT U_grqty_web FROM WTQ1 where DocEntry = '$base' AND LineNum ='$line'");
						$temCek=mssql_query("SELECT * FROM WTQ1 where DocEntry = '$base'");
						$cekLine=mssql_num_rows($temCek);
						$rem=mssql_fetch_array($tem);
						$gr_qty1=$rem['U_grqty_web'];
						$realoutstanding = $grpodlv_dept_detail_to_save['outstanding_qty'];
						
						$outstanding =$grpodlv_dept_detail['LFIMG'];
						$gr_qty = $gr_qty1 + $gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i];
						
						if($this->m_gistonew_dept->gistonew_dept_detail_insert($gistonew_dept_detail) )
							unset($gistonew_dept_detail);
                          $input_detail_success = TRUE;
						  if ($input_detail_success === TRUE) 
						  {
						  	if(isset($_POST['button']['approve']))
							{
							 if ($outstanding == 0 && $count==$cekLine )
							 { 
							// echo "UBAH";
							 mssql_query("UPDATE OWTQ SET U_Stat = 1 WHERE DOcEntry = '$base' ");
							 }
							 mssql_query("UPDATE WTQ1 SET U_grqty_web = '$gr_qty'  WHERE DocEntry = '$base' AND LineNum ='$line'");
							 //echo "UPDATE OWTQ SET U_Stat = 1 WHERE DOcEntry = '$base' ";
							 unset($_SESSION['gistonew_dept_detail']);
							}
						  }
								
								if(isset($_POST['button']['approve']))
								$batch['status'] = '2';
								else
								$bacth['status'] = '1';

                                //array utk parameter masukan pada saat approval
                                $gistonew_dept_to_approve['item'][$i] = $gistonew_dept_detail['id_gistonew_dept_h_detail'];
                                $gistonew_dept_to_approve['material_no'][$i] = $gistonew_dept_detail['material_no'];
                                $gistonew_dept_to_approve['gr_quantity'][$i] = $gistonew_dept_detail['gr_quantity'];

        					   $item = $this->m_general->sap_item_select_by_item_code($gistonew_dept['gistonew_dept_detail']['material_no'][$i]);
                               if ((strcmp($item['UNIT'],'KG')==0)||(strcmp($item['UNIT'],'G')==0)||(strcmp($item['UNIT'],'L')==0)||(strcmp($item['UNIT'],'ML')==0)) {
                                    $gistonew_dept_to_approve['uom'][$i] = $gistonew_dept_detail['uom'];
                                } else {
                                    $gistonew_dept_to_approve['uom'][$i] = $item['MEINS'];
                                }
                                //
        						if($this->m_gistonew_dept->gistonew_dept_detail_insert($gistonew_dept_detail) && $this->m_gistonew_dept->batch_insert($batch))
                                  $input_detail_success = TRUE;
        					}

    /*            			if(!empty($gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i])) {
            	    			$gistonew_dept_detail = array (
            						'id_gistonew_dept_detail'=>$gistonew_dept['gistonew_dept_detail']['id_gistonew_dept_detail'][$i],
            						'gr_quantity'=>$gistonew_dept['gistonew_dept_detail']['gr_quantity'][$i],
            					);
            		    		if($this->m_gistonew_dept->gistonew_dept_detail_update($gistonew_dept_detail)) {
                                    $input_detail_success = TRUE;
            			    	} else {
                                    $input_detail_success = FALSE;
            			    	}
                			} else {
                              $this->m_gistonew_dept->gistonew_dept_detail_delete($gistonew_dept['gistonew_dept_detail']['id_gistonew_dept_detail'][$i]);
                			}
    */
            	    	}
                    }
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $gistonew_dept_to_approve['posting_date'] = date('Ymd',strtotime($edit_gistonew_dept_header['posting_date']));
                $gistonew_dept_to_approve['plant'] = $edit_gistonew_dept_header['plant'];
                $gistonew_dept_to_approve['receiving_plant'] = $edit_gistonew_dept_header['receiving_plant'];
                $gistonew_dept_to_approve['id_gistonew_dept_plant'] = $edit_gistonew_dept_header['id_gistonew_dept_plant'];
                $gistonew_dept_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $gistonew_dept_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_gistonew_dept_header['plant'],$edit_gistonew_dept_header['posting_date'],
                      $edit_gistonew_dept_header['id_gistonew_dept_plant'],'04');
					  
			    /*$approved_data = $this->m_gistonew_dept->sap_gistonew_dept_header_approve($gistonew_dept_to_approve);
 			    $approve_data_success = FALSE;
    			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')
                    && (trim($approved_data['po_document']) !== '')) {
    			*/  $gistonew_dept_no = '';//$approved_data['material_document'];
    			    $po_no = '';//$approved_data['po_document'];
    				$data = array (
    					'id_gistonew_dept_header' =>$id_gistonew_dept_header,
    					'gistonew_dept_no'	=>	$gistonew_dept_no,
    					'po_no'	=>	$gistonew_dept['gistonew_dept_header']['po_no'],
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$gistonew_dept_header_update_status = $this->m_gistonew_dept->gistonew_dept_header_update($data);
  				    $approve_data_success = TRUE;
				//}
            }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
			  $this->l_general->success_page('Data Transfer Out Inter Departement berhasil diubah', site_url('gistonew_dept/browse'));
              } else {
			  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer Out Inter Departement tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));

 			  }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
			    $this->l_general->success_page('Data Transfer Out Inter Departement berhasil diapprove', site_url('gistonew_dept/browse'));
              } else {
                $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer Out Inter Departement tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));            }
		}

        }
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'gistonew_dept/browse';
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function edit_error($error_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $error_text;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _cancel_update() {
		// start of assign variables and delete not used variables
		$gistonew_dept = $_POST;
		unset($gistonew_dept['button']);
		// end of assign variables and delete not used variables
		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($gistonew_dept['gistonew_dept_header']['posting_date']!=$date_today) {
			redirect('gistonew_dept/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

    	if(empty($gistonew_dept['cancel'])) {
            $gr_quantity_exist = FALSE;
    	} else {
    		$gr_quantity_exist = TRUE;
    	}
		if($gr_quantity_exist == FALSE)
			redirect('gistonew_dept/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('gistonew_dept', 1, date("Y-m-d")) {


        $edit_gistonew_dept_header = $this->m_gistonew_dept->gistonew_dept_header_select($gistonew_dept['gistonew_dept_header']['id_gistonew_dept_header']);
		$edit_gistonew_dept_details = $this->m_gistonew_dept->gistonew_dept_details_select($gistonew_dept['gistonew_dept_header']['id_gistonew_dept_header']);
    	$i = 1;
	    foreach ($edit_gistonew_dept_details->result_array() as $value) {
		    $edit_gistonew_dept_detail[$i] = $value;
		    $i++;
        }
        unset($edit_gistonew_dept_details);

		if(isset($_POST['button']['cancel'])) {

//			$gistonew_dept_header['id_gistonew_dept_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

            $gistonew_dept_to_cancel['gistonew_dept_no'] = $edit_gistonew_dept_header['gistonew_dept_no'];
            $gistonew_dept_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_gistonew_dept_header['posting_date']));
            $gistonew_dept_to_cancel['posting_date'] = date('Ymd',strtotime($edit_gistonew_dept_header['posting_date']));
            $gistonew_dept_to_cancel['plant'] = $edit_gistonew_dept_header['plant'];
			$gistonew_dept_to_cancel['id_gistonew_dept_plant'] = $this->m_gistonew_dept->id_gistonew_dept_plant_new_select($gistonew_dept_to_cancel['plant'],date('Y-m-d',strtotime($edit_gistonew_dept_header['posting_date'])));
			$gistonew_dept_to_cancel['po_no'] = $edit_gistonew_dept_header['po_no'];
            $gistonew_dept_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_gistonew_dept_header['plant'],$edit_gistonew_dept_header['posting_date'],
                      $gistonew_dept_to_cancel['id_gistonew_dept_plant'],'04');
            $gistonew_dept_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_gistonew_dept_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($gistonew_dept['cancel'][$i]))
       		     $gistonew_dept_to_cancel['item'][$i] = $i;
            }
            $cancelled_data = $this->m_gistonew_dept->sap_gistonew_dept_header_cancel($gistonew_dept_to_cancel);
 			$cancel_data_success = FALSE;
   			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($gistonew_dept['cancel'][$i])) {
    	    			$gistonew_dept_header = array (
    						'id_gistonew_dept_header'=>$gistonew_dept['gistonew_dept_header']['id_gistonew_dept_header'],
    						'id_gistonew_dept_plant'=>$gistonew_dept_to_cancel['id_gistonew_dept_plant'],
    					);
    		    		if($this->m_gistonew_dept->gistonew_dept_header_update($gistonew_dept_header)==TRUE) {
        	    			$gistonew_dept_detail = array (
        						'id_gistonew_dept_detail'=>$edit_gistonew_dept_detail[$i]['id_gistonew_dept_detail'],
        						'ok_cancel'=>1,
        						'material_docno_cancellation'=>$mat_doc_cancellation,
        						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
        					);
        		    		if($this->m_gistonew_dept->gistonew_dept_detail_update($gistonew_dept_detail)==TRUE) {
            				    $cancel_data_success = TRUE;
        			    	}
                        }
                   }
        		}
            }

           $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
			    $this->l_general->success_page('Data Goods antar Departement berhasil dibatalkan', site_url('gistonew_dept/browse'));
            } else {
				$this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer Out Inter Departement tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'DataGood Issue Stock Transfer antar Departement tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_gistonew_dept_header) {

		$this->db->trans_start();
		
		$gistonew_dept_delete['user'] = $this->session->userdata['ADMIN']['admin_id'];
	  $gistonew_dept_delete['module'] = "Transfer Out Depatement";
	 $gistonew_dept_delete['plant'] = $this->session->userdata['ADMIN']['plant'];
	  $gistonew_dept_delete['id_delete'] = $id_gistonew_dept_header;

		// check approve status
		$gistonew_dept_header = $this->m_gistonew_dept->gistonew_dept_header_select($id_gistonew_dept_header);

		if($gistonew_dept_header['status'] == '1') {
			$this->m_gistonew_dept->gistonew_dept_header_delete($id_gistonew_dept_header);
			$this->m_gistonew_dept->user_delete($gistonew_dept_delete);
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_gistonew_dept_header) {

		if($this->_delete($id_gistonew_dept_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer Out Inter Departement berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['gistonew_dept_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer Out Inter Departement gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['gistonew_dept_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '008';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_gistonew_dept_header']))
			redirect($this->session->userdata['PAGE']['gistonew_dept_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_gistonew_dept_header'][$i])) {
				$object['data']['gistonew_dept_headers'][$j++] = $this->m_gistonew_dept->gistonew_dept_header_select($_POST['id_gistonew_dept_header'][$i]);
			}
		}

		$this->template->write_view('content', 'gistonew_dept/gistonew_dept_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_gistonew_dept_header'][$i]);
		}

		$object['refresh'] = 1;
   		$object['refresh_text'] = 'Data Transfer Out Inter Departement berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['gistonew_dept_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

  	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'gistonew_dept_data';
		$config['allowed_types'] = 'xls';
		$config['max_size']	= '10000000';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile')) {
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
//			$this->load->view('upload_form', $error);
		} else {
			$upload = $this->upload->data();;

			// Load the spreadsheet reader library
			$this->load->library('excel_reader');

			// Set output Encoding.
			$this->excel_reader->setOutputEncoding('CP1251');

			
			$db_mysql=$this->m_database->get_db_mysql();
			$user_mysql=$this->m_database->get_user_mysql();
			$pass_mysql=$this->m_database->get_pass_mysql();
			$db_sap=$this->m_database->get_db_sap();
			$user_sap=$this->m_database->get_user_sap();
			$pass_sap=$this->m_database->get_pass_sap();
			$host_sap=$this->m_database->get_host_sap();
            if($_SERVER['SERVER_NAME'] == 'localhost')
            $file =  $_SERVER['DOCUMENT_ROOT'].'/'.$db_mysql.'/excel_upload/'.$upload['file_name'];
            else
            $file =  $_SERVER['DOCUMENT_ROOT'].'/excel_upload/'.$upload['file_name'];

			$this->session->set_userdata('file_upload', $file);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

			// is it gistonew_dept template file?
			if($excel['cells'][1][1] == 'Goods Issue No' && $excel['cells'][1][3] == 'Material No.') {

				$j = 0; // gistonew_dept_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same gistonew_dept header?

					$receiving_plant = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
                     $do_no = $excel['cells'][$i][4];
					$gr_quantity = $excel['cells'][$i][5];

					// check gistonew_dept header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;

                       $plant = $this->m_general->sap_plant_select($receiving_plant);
                         if($plant!= FALSE){
//                            if($gistonew_dept_receiving_temp = $this->m_general->sap_plants_select_all_non_ck_outlet()){
							$object['gistonew_dept_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['gistonew_dept_headers'][$j]['receiving_plant'] = $receiving_plant;
                            $object['gistonew_dept_headers'][$j]['gistonew_dept_no'] = $excel['cells'][$i][1];
							$object['gistonew_dept_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['gistonew_dept_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['gistonew_dept_headers'][$j]['status'] = '1';
							$object['gistonew_dept_headers'][$j]['item_group_code'] = $item_group_code;
							$object['gistonew_dept_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['gistonew_dept_headers'][$j]['filename'] = $upload['file_name'];

            	            $gistonew_dept_header_exist = TRUE;
							$k = 1; // gistonew_dept_detail number
						} else {
                        	$gistonew_dept_header_exist = FALSE;
						}
                       }

					if($gistonew_dept_header_exist) {


                             if($gistonew_dept_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {
							$object['gistonew_dept_details'][$j][$k]['id_gistonew_dept_h_detail'] = $k;
							$object['gistonew_dept_details'][$j][$k]['item'] = $k;
							$object['gistonew_dept_details'][$j][$k]['material_no'] = $material_no;
                            $object['gistonew_dept_details'][$j][$k]['material_desc'] = $gistonew_dept_detail_temp['MAKTX'];
							$object['gistonew_dept_details'][$j][$k]['gr_quantity'] = $gr_quantity;
                            $uom_import = $gistonew_dept_detail_temp['UNIT'];
                            if(strcasecmp($uom_import,'KG')==0) {
                              $uom_import = 'G';
                            }
                            if(strcasecmp($uom_import,'L')==0) {
                              $uom_import = 'ML';
                            }
							$object['gistonew_dept_details'][$j][$k]['uom'] = $uom_import;

							$k++;
                       }

					}

				}

				$this->template->write_view('content', 'gistonew_dept/gistonew_dept_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Transfer Out Inter Departement atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'gistonew_dept/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '009';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

			}

		}

	}

	function file_import_execute() {

		// Load the spreadsheet reader library
		$this->load->library('excel_reader');

		// Set output Encoding.
		$this->excel_reader->setOutputEncoding('CP1251');

		$this->excel_reader->read($this->session->userdata('file_upload'));

		// Sheet 1
		$excel = $this->excel_reader->sheets[0] ;

		// is it gistonew_dept template file?
		if($excel['cells'][1][1] == 'Goods Issue No' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // gistonew_dept_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same gistonew_dept header?

					$receiving_plant = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
                     $do_no = $excel['cells'][$i][4];
					$gr_quantity = $excel['cells'][$i][5];


				// check gistonew_dept header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;

                       $plant = $this->m_general->sap_plant_select($receiving_plant);
                       if($plant!= FALSE){
						    $object['gistonew_dept_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");

                       		$object['gistonew_dept_headers'][$j]['receiving_plant'] = $receiving_plant;
                       		$object['gistonew_dept_headers'][$j]['receiving_plant_name'] = $plant['NAME1'];
							$object['gistonew_dept_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['gistonew_dept_headers'][$j]['id_gistonew_dept_plant'] = $this->m_gistonew_dept->id_gistonew_dept_plant_new_select($object['gistonew_dept_headers'][$j]['plant'],$object['gistonew_dept_headers'][$j]['posting_date']);
							$object['gistonew_dept_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['gistonew_dept_headers'][$j]['status'] = '1';
							$object['gistonew_dept_headers'][$j]['item_group_code'] = $item_group_code;
							$object['gistonew_dept_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['gistonew_dept_headers'][$j]['filename'] = $upload['file_name'];

						$id_gistonew_dept_header = $this->m_gistonew_dept->gistonew_dept_header_insert($object['gistonew_dept_headers'][$j]);

           	$gistonew_dept_header_exist = TRUE;
						$k = 1; // gistonew_dept_detail number

					} else {
           	$gistonew_dept_header_exist = FALSE;
					}
                    }

				if($gistonew_dept_header_exist) {


                     if($gistonew_dept_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {
						$object['gistonew_dept_details'][$j][$k]['id_gistonew_dept_header'] = $id_gistonew_dept_header;
						$object['gistonew_dept_details'][$j][$k]['id_gistonew_dept_h_detail'] = $k;

						$object['gistonew_dept_details'][$j][$k]['material_no'] = $material_no;

						$object['gistonew_dept_details'][$j][$k]['material_desc'] = $gistonew_dept_detail_temp['MAKTX'];
						$object['gistonew_dept_details'][$j][$k]['gr_quantity'] = $gr_quantity;

                        $uom_import = $gistonew_dept_detail_temp['UNIT'];
                        if(strcasecmp($uom_import,'KG')==0) {
                          $uom_import = 'G';
                        }
                        if(strcasecmp($uom_import,'L')==0) {
                          $uom_import = 'ML';
                        }
            			$object['gistonew_dept_details'][$j][$k]['uom'] = $uom_import;

						$id_gistonew_dept_detail = $this->m_gistonew_dept->gistonew_dept_detail_insert($object['gistonew_dept_details'][$j][$k]);

						$k++;
					}

                   }

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer Out Inter Departement berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['gistonew_dept_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {
				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Transfer Out Inter Departement atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'gistonew_dept/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();
		}

	}
	
	public function printpdf($id_gistonew_dept_header)
	{
		$this->load->model('m_gistonew_pdf');
		$data['data'] = $this->m_gistonew_pdf->tampil($id_gistonew_dept_header);
		
		ob_start();
		$content = $this->load->view('gistonew_pdf',$data);
		$content = ob_get_clean();		
		$this->load->library('html2pdf');
		try
		{
		ob_clean();
			$html2pdf = new HTML2PDF('L', 'F4', 'fr');
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output('print.pdf');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
		
	}
	
	public function excel($id_gistonew_dept_header)
	{
		$this->load->model('m_gistonew_pdf');
		//$this->load->model('m_stdstock');
		//$stdstock_header = $this->m_stdstock->stdstock_header_select($id_stdstock_header);
		$data['data'] = $this->m_gistonew_pdf->tampil($id_gistonew_dept_header);
		
		ob_start();
	   $this->load->view('gistonew_pdf',$data);
		
		
	}


}
