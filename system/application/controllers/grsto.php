<?php
class grsto extends Controller {
	private $jagmodule = array();


	function grsto() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1035);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_grsto'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_grsto');
		$this->load->model('m_gisto');
		$this->load->library('l_general');
		$this->load->model('m_general');
		$this->load->model('m_database');

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
		$grsto_browse_result = $this->session->userdata['PAGE']['grsto_browse_result'];

		if(!empty($grsto_browse_result))
			redirect($this->session->userdata['PAGE']['grsto_browse_result']);
		else
			redirect('grsto/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('grsto/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('grsto/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('grsto_browse_result');

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
			'a'	=>	'Transfer In No',
			'b'	=>	'SR Number',
			'c'	=>	'Transfer Slip No',
			'd'	=>	'Delivery Outlet',

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

		$sort_link1 = 'grsto/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
			'gy'	=>	$sort_link1.'gy'.$sort_link2,
			'gz'	=>	$sort_link1.'gz'.$sort_link2,
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 11;
		$config['base_url'] = site_url('grsto/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_grsto->grsto_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['grsto_headers'] = $this->m_grsto->grsto_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Transfer In Inter Outlet';
		$this->template->write_view('content', 'grsto/grsto_browse', $object);
		$this->template->render();

	}

	// input data
	function input() {

		// if $data exist, add to the $object array
		if ( count($_POST) != 0) {
//		if(!empty($_POST['kd_vendor'])) {
			$data = $_POST;
			$object['data'] = $data;

            $gr_quantity = array('gr_quantity' => '');
            $this->session->unset_userdata($gr_quantity);

		} else {
			$object['data'] = NULL;

			$object['data']['po_no'] = 0;
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

        if(empty($this->session->userdata['po_nos'])||empty($data)) {
    		$data['po_nos'] = $this->m_grsto->sap_po_select_all();
      		$this->session->set_userdata('po_nos', $data['po_nos']);
        } else {
            $data['po_nos'] = $this->session->userdata['po_nos'];
        }

		if(!empty($data['po_nos'])) {
			$object['po_no'][0] = '';

			foreach ($data['po_nos'] as $po_no) {
				$object['po_no'][$po_no['EBELN']] = $po_no['EBELN'];
			}
		}

		if(!empty($data['po_no'])) {
			$object['data']['grsto_header'] = $this->m_grsto->sap_grsto_header_select_by_po_no($data['po_no']);
			$data['no_doc_gist'] = $object['data']['grsto_header']['MBLNR'];
			$data['delivery_plant'] = $object['data']['grsto_header']['SUPPL_PLANT'];
			$data['delivery_plant_name'] = $object['data']['grsto_header']['SPLANT_NAME'];
			$data['delivery_date'] = $object['data']['grsto_header']['DELIV_DATE'];

    		$data['item_groups'] = $this->m_grsto->sap_grsto_select_item_group_po($data['po_no']);
   			$object['item_group_code'][0] = '';
   			$object['item_group_code']['all'] = '==All==';

    		if($data['item_groups'] !== FALSE) {
    			foreach ($data['item_groups'] as $item_group) {
    			   $object['item_group_code'][$item_group] = $item_group;
    			}
    		}
		}

		$this->session->set_userdata('delivery_plant_name', $data['delivery_plant_name']);

		if(!empty($data['item_group_code'])) {
			redirect('grsto/input2/'.$data['po_no'].'/'.$data['item_group_code'].'/'.$data['no_doc_gist'].'/'.$data['delivery_plant'].'/'.$data['delivery_date']);
		}

		$object['page_title'] = 'Transfer In Inter Outlet';
		$this->template->write_view('content', 'grsto/grsto_input', $object);
		$this->template->render();

	}

	function input2()	{

		$validation = FALSE;

		if(count($_POST) != 0) {

			// first post, assume all data TRUE
			$validation_temp = TRUE;

			$object['grsto_details'] = $this->m_grsto->sap_grsto_details_select_by_po_no($_POST['grsto_header']['po_no']);
            $count = count($_POST['grsto_detail']['item']);
            for($i=1;$i<=$count;$i++) {
                $qty_to_check = 0;
    			foreach ($object['grsto_details'] as $object['grsto_detail']) {
                    if ($_POST['grsto_detail']['item'][$i]==$object['grsto_detail']['NUMBER']) {
                      $qty_to_check = $object['grsto_detail']['BSTMG'];
                      break;
                    }
    			}
            	$check[$i] = $this->l_form_validation->set_rules($_POST['grsto_detail']['gr_quantity'][$i], "grsto_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$qty_to_check);
            	// if one data FALSE, set $validation_temp to FALSE
            	if($check[$i]['error'] == TRUE)
            		$validation_temp = FALSE;
            }

            /*
			$i = 1;
			foreach ($object['grsto_details'] as $object['grsto_detail']) {

                    if ($i==$_POST['grsto_detail']['id_grsto_h_detail'][$i]) {
    					$check[$i] = $this->l_form_validation->set_rules($_POST['grsto_detail']['gr_quantity'][$i], "grsto_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['grsto_detail']['BSTMG']);

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
			$this->_input_add();
		}

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

		$po_no = $this->uri->segment(3);
		$item_group_code = $this->uri->segment(4);
        $no_doc_gist = $this->uri->segment(5);
        $delivery_plant = $this->uri->segment(6);
		$delivery_plant_name = $this->session->userdata['delivery_plant_name'];
		$delivery_date = $this->uri->segment(7);
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

    	if(!empty($po_no)) {
           	$object['grsto_header']['plant'] = $this->session->userdata['ADMIN']['plant'];
           	$object['grsto_header']['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
            $object['grsto_header']['item_group_code'] = $item_group_code;
  		    $object['grsto_header']['EBELN'] = $po_no;
  		    $object['grsto_header']['MBLNR'] = $no_doc_gist;
  		    $object['grsto_header']['SUPPL_PLANT'] = $delivery_plant;
  		    $object['grsto_header']['SPLANT_NAME'] = $delivery_plant_name;
    		$object['grsto_header']['delivery_date'] = $delivery_date;
			if ((!empty($item_group_code)) || (trim($item_group_code)!="")) {
        		if($item_group_code == 'all') {
        			$object['item_group']['item_group_code'] = $item_group_code;
        			$object['item_group']['item_group_name'] = '<strong>All</strong>';
                    $object['grsto_details'] = $this->m_grsto->sap_grsto_details_select_by_po_no($po_no);
        		} else {
        			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
        			$object['item_group']['item_group_name'] = $item_group_code;
        			$object['grsto_details'] = $this->m_grsto->sap_grsto_details_select_by_po_and_item_group($po_no, $object['item_group']['DISPO']);
        		}
            }
    	}

		if(($object['grsto_details'] !== FALSE)&&(!empty($object['grsto_details']))) {
			$i = 1;
			foreach ($object['grsto_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['grsto_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}

		if(count($_POST) == 0) {
    		$object['data']['grsto_details'] = $this->m_grsto->grsto_details_select($object['data']['id_grsto_header']);

    		if($object['data']['grsto_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['grsto_details']->result_array() as $object['temp']) {
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['grsto_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }


		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Transfer In Inter Outlet';
		$this->template->write_view('content', 'grsto/grsto_edit', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$grsto = $_POST;
		unset($grsto['button']);

		$count_filled = count($grsto['grsto_detail']['gr_quantity']);

		$count = count($grsto['grsto_detail']['id_grsto_h_detail']);

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			$gr=$grsto['grsto_detail']['gr_quantity'][$i]+$grsto['grsto_detail']['var'][$i];
			if(empty($gr)) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grsto/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grsto['grsto_header']['posting_date'])==FALSE)) {
     	   redirect('grsto/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

            //echo "<pre>";
            //print_r($grsto);
            //echo "</pre>";
            //exit;
            $delivery_plant_name1 = array('delivery_plant_name' => '');
            $this->session->unset_userdata($delivery_plant_name1);

    		$this->session->set_userdata('gr_quantity', $grsto['grsto_detail']['gr_quantity']);
 			$grsto_header['po_no'] = $grsto['grsto_header']['po_no'];
 			$grsto_header['no_doc_gist'] = $grsto['grsto_header']['no_doc_gist'];
 			$grsto_header['delivery_plant'] = $grsto['grsto_header']['delivery_plant'];
 			$grsto_header['delivery_plant_name'] = $grsto['grsto_header']['delivery_plant_name'];
			$grsto_header['delivery_date'] = $grsto['grsto_header']['delivery_date'];
			$grsto_header['grsto_no'] = '';
			$po=$grsto_header['po_no'];

			//$sap_grsto_header = $this->m_grsto->sap_grsto_header_select_by_po_no($grsto['grsto_header']['po_no']);

    		$grsto_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$grsto_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
// 			$grsto_header['posting_date'] = $this->m_general->posting_date_select_max($grsto_header['plant']);
 			$grsto_header['posting_date'] = $this->l_general->str_to_date($grsto['grsto_header']['posting_date']);
			$grsto_header['id_grsto_plant'] = $this->m_grsto->id_grsto_plant_new_select($grsto_header['plant'],$grsto_header['posting_date']);

			if(isset($_POST['button']['approve']))
				$grsto_header['status'] = '2';
			else
				$grsto_header['status'] = '1';

			$grsto_header['item_group_code'] = $grsto['grsto_header']['item_group_code'];
			$grsto_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];

            $web_trans_id = $this->l_general->_get_web_trans_id($grsto_header['plant'],$grsto_header['posting_date'],
                      $grsto_header['id_grsto_plant'],'05');
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $grsto_to_approve = array (
                      'plant' => $grsto_header['plant'],
                      'po_no' => $grsto_header['po_no'],
                      'posting_date' => date('Ymd',strtotime($grsto_header['posting_date'])),
                      'id_user_input' => $grsto_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                );
              }
              //

			if($id_grsto_header = $this->m_grsto->grsto_header_insert($grsto_header)) {

                $input_detail_success = FALSE;


				for($i = 1; $i <= $count; $i++) {

					if(!empty($grsto['grsto_detail']['gr_quantity'][$i])&&($grsto['grsto_detail']['gr_quantity'][$i]>0)) {
						$grsto_detail = $this->m_grsto->sap_grsto_details_select_by_po_and_item($grsto_header['po_no'],$grsto['grsto_detail']['item1'][$i]);

						$grsto_detail_to_save['id_grsto_header'] = $id_grsto_header;
						$batch['BaseEntry'] = $id_grsto_header;
						$grsto_detail_to_save['id_grsto_h_detail'] = $grsto['grsto_detail']['id_grsto_h_detail'][$i];
						$batch['BaseLinNum'] = $grsto['grsto_detail']['id_grsto_h_detail'][$i];
						$grsto_detail_to_save['item'] = $grsto['grsto_detail']['item1'][$i];
						$batch['BatchNum']= $grsto['grsto_detail']['material_docno_cancellation'][$i];
						$batch_m['DistNumber']= $grsto['grsto_detail']['material_docno_cancellation'][$i];
						$grsto_detail_to_save['material_no'] = $grsto['grsto_detail']['material_no'][$i];//$grsto_detail['MATNR'];
						$grsto_detail_to_save['material_docno_cancellation'] = $grsto['grsto_detail']['material_docno_cancellation'][$i];
						$batch['ItemCode'] =  $grsto['grsto_detail']['material_no'][$i];//$grsto_detail['MATNR'];
						$item=$grsto['grsto_detail']['material_no'][$i];
						$batch_m['ItemCode'] = $grsto['grsto_detail']['material_no'][$i];// $grsto_detail['MATNR'];
						$grsto_detail_to_save['material_desc'] = $grsto['grsto_detail']['material_desc'][$i];//$grsto_detail['MAKTX'];
						$grsto_detail_to_save['outstanding_qty'] = $grsto['grsto_detail']['outstanding_qty'][$i];//$grsto_detail['BSTMG'];
						//$grsto_detail_to_save['gr_quantity'] = $grsto['grsto_detail']['gr_quantity'][$i];
						$grsto_detail_to_save['val'] = $grsto['grsto_detail']['val'][$i];
						$grsto_detail_to_save['var'] =$grsto_detail_to_save['outstanding_qty']-$grsto['grsto_detail']['gr_quantity'][$i];
						$var=$grsto_detail_to_save['var'];
						$val=$grsto['grsto_detail']['val'][$i];
						if ($val <> 0)
						{
							$grsto_detail_to_save['gr_quantity'] = $grsto['grsto_detail']['gr_quantity'][$i];
							$batch['Quantity']= $grsto['grsto_detail']['gr_quantity'][$i];
						$batch_m['Quantity']= $grsto['grsto_detail']['gr_quantity'][$i];
						}
						else
						{
							$new=$grsto_detail_to_save['var']+$grsto['grsto_detail']['gr_quantity'][$i];
							$grsto_detail_to_save['gr_quantity'] = $grsto['grsto_detail']['gr_quantity'][$i];
							$batch['Quantity']= $grsto['grsto_detail']['gr_quantity'][$i];
							$batch_m['Quantity']= $grsto['grsto_detail']['gr_quantity'][$i];
						}
						
						if(isset($_POST['button']['approve']))
						{
							
							$db_mysql=$this->m_database->get_db_mysql();
							$user_mysql=$this->m_database->get_user_mysql();
							$pass_mysql=$this->m_database->get_pass_mysql();
							$db_sap=$this->m_database->get_db_sap();
							$user_sap=$this->m_database->get_user_sap();
							$pass_sap=$this->m_database->get_pass_sap();
							$host_sap=$this->m_database->get_host_sap();
							$con = mysql_connect("localhost",$user_mysql,$pass_mysql);
							mysql_select_db($db_mysql, $con);
							$cekQty=mysql_fetch_array(mysql_query("SELECT A.receipt,A.var FROM t_gistonew_out_detail A 
							JOIN t_gistonew_out_header B ON A.id_gistonew_out_header=B.id_gistonew_out_header
							WHERE B.po_no='$po' AND A.material_no='$item'", $con));
							$ReceiptQty=$cekQty['receipt']+$grsto['grsto_detail']['gr_quantity'][$i];
							//echo '{'.$val.'} ';
							mysql_query("UPDATE t_gistonew_out_detail A 
							JOIN t_gistonew_out_header B ON A.id_gistonew_out_header=B.id_gistonew_out_header 
							SET A.receipt='$ReceiptQty',A.var='$var' WHERE B.po_no='$po' AND A.material_no='$item'", $con);
							
							mysql_close($con);
						}
						$batch['Quantity']= $grsto['grsto_detail']['gr_quantity'][$i];
						$batch_m['Quantity']= $grsto['grsto_detail']['gr_quantity'][$i];
						$batch['BaseType'] = '1';
						$batch_m['Whs']= $grsto_header['plant'];
						$batch['Createdate'] = $grsto_header['posting_date'];
						$grsto_detail_to_save['uom'] = $grsto_detail['BSTME'];
						//echo "(".$grsto_detail_to_save['uom'].")" ;
						$grsto_detail_to_save['ok'] = '1';
                        //array utk parameter masukan pada saat approval
                        $grsto_to_approve['item'][$i] = $grsto_detail_to_save['item'];
                        $grsto_to_approve['material_no'][$i] = $grsto_detail_to_save['material_no'];
                        $grsto_to_approve['gr_quantity'][$i] = $grsto_detail_to_save['gr_quantity'];
                        $grsto_to_approve['uom'][$i] = $grsto_detail['BSTME'];
                        //
						

						unset($grsto_detail);
						//echo $batch_m['ItemCode']."-".$batch_m['DistNumber']."-".$batch_m['Quantity'].'-'.$batch_m['Whs'].'-'.$batch['Createdate'];

						/*if($this->m_grsto->grsto_detail_insert($grsto_detail_to_save)&& $this->m_grsto->batch_insert($batch)&& $this->m_grsto->batch_master($batch_m))
                          $input_detail_success = TRUE;*/
						  if($this->m_grsto->grsto_detail_insert($grsto_detail_to_save))
                          $input_detail_success = TRUE; 

					}

				}

			}

            $this->db->trans_complete();

            $po_nos1 = array('po_nos' => '');
            $this->session->unset_userdata($po_nos1);

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			  //  $approved_data = $this->m_grsto->sap_grsto_header_approve($grsto_to_approve);
    			//if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grsto_no = '';//$approved_data['material_document'];
    				$data = array (
    					'id_grsto_header'	=>$id_grsto_header,
    					'grsto_no'	=>	$grsto_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_grsto->grsto_header_update($data);

    				$data = array (
    					'gisto_no' =>$grsto_header['no_doc_gist'],
    					'po_no'	=>	$id_grsto_header
    				);

    				$this->m_gisto->gisto_header_update_by_gisto_no($data);

  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
            //}

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			    $this->l_general->success_page('Data Transfer In Inter Outlet berhasil dimasukkan', site_url('grsto/input'));
              } else {
                $this->m_grsto->grsto_header_delete($id_grsto_header);
				$this->jagmodule['error_code'] = '001';
		$this->l_general->error_page($this->jagmodule, 'Data Transfer In Inter Outlet tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
               }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Transfer In Inter Outlet berhasil diapprove', site_url('grsto/input'));
              } else {
                $this->m_grsto->grsto_header_delete($id_grsto_header);
				$this->jagmodule['error_code'] = '002';
		$this->l_general->error_page($this->jagmodule, 'Data Transfer In Inter Outlet tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }
		}

        }
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt Stock Transfer Antar Plant tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('grsto/input2');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt Stock Transfer Antar Plant berhasil diapprove';
		$object['refresh_url'] = site_url('grsto/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt Stock Transfer Antar Plant berhasil dimasukkan';
		$object['refresh_url'] = site_url('grsto/input');
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
	}*/


	function edit() {
	    $grsto_header = $this->m_grsto->grsto_header_select($this->uri->segment(3));
		$status = $grsto_header['status'];
        unset($grsto_header);

        $gr_quantity = array('gr_quantity' => '');
        $this->session->unset_userdata($gr_quantity);

    	$validation = FALSE;

        if ($status !== '2') {
    		if(count($_POST) != 0) {

    			// first post, assume all data TRUE
    			$validation_temp = TRUE;

			$object['grsto_details'] = $this->m_grsto->sap_grsto_details_select_by_po_no($_POST['grsto_header']['po_no']);
            $count = count($_POST['grsto_detail']['item']);
         /*   for($i=1;$i<=$count;$i++) {
                $qty_to_check = 0;
    			foreach ($object['grsto_details'] as $object['grsto_detail']) {
                    if ($_POST['grsto_detail']['item'][$i]==$object['grsto_detail']['EBELP']) {
                      $qty_to_check = $object['grsto_detail']['BSTMG'];
                      break;
                    }
    			}
            	$check[$i] = $this->l_form_validation->set_rules($_POST['grsto_detail']['gr_quantity'][$i], "grsto_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$qty_to_check);
            	// if one data FALSE, set $validation_temp to FALSE
            	if($check[$i]['error'] == TRUE)
            		$validation_temp = FALSE;
            }*/

                /*
    			$i = 1;
    			foreach ($object['grsto_details'] as $object['grsto_detail']) {

                    if ($i==$_POST['grsto_detail']['id_grsto_h_detail'][$i]) {
    					$check[$i] = $this->l_form_validation->set_rules($_POST['grsto_detail']['gr_quantity'][$i], "grsto_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['grsto_detail']['BSTMG']);

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
        }

		if ($validation == FALSE) {
			if(!empty($_POST)) {

				$data = $_POST;
				$grsto_header = $this->m_grsto->grsto_header_select($this->uri->segment(3));

				if($grsto_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['grsto_header'] = $this->m_grsto->grsto_header_select($this->uri->segment(3));
				$this->_edit_form(0, $data, $check);
			 }

		} else {
			$this->_edit_update();
		}

	}

	function _edit_form($reset = 0, $data = NULL, $check = NULL) {
		// if data added to the database,
		// reset the contents of the form
		// $reset = 1
		$object['reset'] = $reset;
		$object['data'] = $data;
		$object['check'] = $check;

		if((count($_POST) != 0)&&(!empty($check))) {
		  $object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$object['data']['grsto_header']['status_string'] = ($object['data']['grsto_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$po_no = $data['grsto_header']['po_no'];
		$id_grsto_header = $data['grsto_header']['id_grsto_header'];

		if(count($_POST) == 0) {
    		$item_group_code = $data['grsto_header']['item_group_code'];
        } else {
    		$item_group_code = $data['item_group']['item_group_code'];
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['grsto_header']['id_grsto_header'] = $id_grsto_header;
		$object['grsto_header']['EBELN'] = $po_no;
		$object['grsto_header']['MBLNR'] = $data['grsto_header']['no_doc_gist'];
		$object['grsto_header']['SUPPL_PLANT'] = $data['grsto_header']['delivery_plant'];
		$object['grsto_header']['SPLANT_NAME'] = $data['grsto_header']['delivery_plant_name'];
		$object['grsto_header']['delivery_date'] = $data['grsto_header']['delivery_date'];

  		if($item_group_code == 'all') {
  			$object['item_group']['item_group_code'] = $item_group_code;
  			$object['item_group']['item_group_name'] = '<strong>All</strong>';
  			$object['grsto_details'] = $this->m_grsto->sap_grsto_details_select_by_po_no($po_no);
  		} else {
  			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
  			$object['item_group']['item_group_name'] = $item_group_code;
  			$object['grsto_details'] = $this->m_grsto->sap_grsto_details_select_by_po_and_item_group($po_no, $object['item_group']['DISPO']);
  		}

		if(($object['grsto_details'] !== FALSE)&&(!empty($object['grsto_details']))) {
			$i = 1;
			foreach ($object['grsto_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['grsto_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}

//            echo "<pre>";
//            print_r($object['grsto_detail']);
//            echo "</pre>";
            //exit; */

		if(count($_POST) == 0) {
    	    $object['data']['grsto_details'] = $this->m_grsto->grsto_details_select($object['data']['grsto_header']['id_grsto_header']);

    		if($object['data']['grsto_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['grsto_details']->result_array() as $object['temp']) {
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['grsto_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }

   	    // save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Transfer In Inter Outlet';
		$this->template->write_view('content', 'grsto/grsto_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$grsto = $_POST;
		unset($grsto['button']);
		// end of assign variables and delete not used variables

		$count_filled = count($grsto['grsto_detail']['gr_quantity']);

		$count = count($grsto['grsto_detail']['id_grsto_h_detail']);

		// variable to check, is at least one product gr_quantity entered?
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grsto['grsto_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grsto/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grsto['grsto_header']['posting_date'])==FALSE)) {
     	   redirect('grsto/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		$edit_grsto_details = $this->m_grsto->grsto_details_select($grsto['grsto_header']['id_grsto_header']);
    	$i = 1;
   		if(!empty($edit_grsto_details)) {
    	    foreach ($edit_grsto_details->result_array() as $value) {
    		    $edit_grsto_detail[$i] = $value;
    		    $i++;
            }
        }
        unset($edit_grsto_details);

    	if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('gr_quantity', $grsto['grsto_detail']['gr_quantity']);

            $postingdate = $grsto['grsto_header']['posting_date'];
			$year = $this->l_general->rightstr($postingdate, 4);
			$month = substr($postingdate, 3, 2);
			$day = $this->l_general->leftstr($postingdate, 2);
            $postingdate = $year."-".$month."-".$day.' 00:00:00';
			$id_grsto_plant = $this->m_grsto->id_grsto_plant_new_select("",$postingdate,$grsto['grsto_header']['id_grsto_header']);
            unset($year);
            unset($month);
            unset($day);
    			$data = array (
    				'id_grsto_header' =>	$grsto['grsto_header']['id_grsto_header'],
                    'id_grsto_plant' => $id_grsto_plant,
    				'posting_date' => $postingdate,
    			);
				
				$po=$grsto['grsto_header']['po_no'];
				
                $this->m_grsto->grsto_header_update($data);

                $edit_grsto_header = $this->m_grsto->grsto_header_select($grsto['grsto_header']['id_grsto_header']);

    			if ($this->m_grsto->grsto_header_update($data)) {
            		for($i = 1; $i <= $count; $i++) {
            			if(!empty($grsto['grsto_detail']['gr_quantity'][$i])) {
        	    			$grsto_detail = array (
        						'id_grsto_detail'=>$grsto['grsto_detail']['id_grsto_detail'][$i],
        						'gr_quantity'=>$grsto['grsto_detail']['gr_quantity'][$i],
								'var'=>$grsto['grsto_detail']['var'][$i],
								'val'=>$grsto['grsto_detail']['val'][$i]
								
        					);
							
							$batch = array (
								'BaseEntry'=>$grsto['grsto_header']['id_grsto_header'],
								'BaseLinNum'=>$grsto['grsto_detail']['id_grsto_detail'][$i],
        						'Quantity'=>$grsto['grsto_detail']['gr_quantity'][$i],
								'BatchNum'=>$grsto['grsto_detail']['material_docno_cancellation'][$i],
								'ItemCode'=>$grsto['grsto_detail']['material_no'][$i],
								'status'=>'1'
							);
							$db_mysql=$this->m_database->get_db_mysql();
							$user_mysql=$this->m_database->get_user_mysql();
							$pass_mysql=$this->m_database->get_pass_mysql();
							$db_sap=$this->m_database->get_db_sap();
							$user_sap=$this->m_database->get_user_sap();
							$pass_sap=$this->m_database->get_pass_sap();
							$host_sap=$this->m_database->get_host_sap();
							$con = mysql_connect("localhost",$user_mysql,$pass_mysql);
							mysql_select_db($db_mysql, $con);	
							//$this->m_database->get_database();
							$entry = $grsto['grsto_header']['id_grsto_header'];
							$BaseLinNum=$grsto['grsto_detail']['id_grsto_detail'][$i];
        					$qty=$grsto['grsto_detail']['gr_quantity'][$i];
							$Outs=$grsto['grsto_detail']['outstanding_qty'][$i];
							$batch=$grsto['grsto_detail']['material_docno_cancellation'][$i];
							$item=$grsto['grsto_detail']['material_no'][$i];
							$ta="UPDATE t_batch SET Quantity ='$qty' WHERE ItemCode='$item' AND BatchNum='$batch' AND BaseLinNum ='$i' AND BaseEntry='$entry'";
							
						if(isset($_POST['button']['approve']))
						{
							$db_mysql=$this->m_database->get_db_mysql();
							$user_mysql=$this->m_database->get_user_mysql();
							$pass_mysql=$this->m_database->get_pass_mysql();
							$db_sap=$this->m_database->get_db_sap();
							$user_sap=$this->m_database->get_user_sap();
							$pass_sap=$this->m_database->get_pass_sap();
							$host_sap=$this->m_database->get_host_sap();
							$con = mysql_connect("localhost",$user_mysql,$pass_mysql);
							mysql_select_db($db_mysql, $con);
							//$this->m_database->get_database();
							$cekQty=mysql_fetch_array(mysql_query("SELECT A.receipt,A.var FROM t_gistonew_out_detail A 
							JOIN t_gistonew_out_header B ON A.id_gistonew_out_header=B.id_gistonew_out_header
							WHERE B.po_no='$po' AND A.material_no='$item'", $con));
							$ReceiptQty=$cekQty['receipt']+$grsto['grsto_detail']['gr_quantity'][$i];
							$var=$Outs-$qty;
							echo '{'.$var.'} ';
							mysql_query("UPDATE t_gistonew_out_detail A 
							JOIN t_gistonew_out_header B ON A.id_gistonew_out_header=B.id_gistonew_out_header 
							SET A.receipt='$ReceiptQty',A.var='$var' WHERE B.po_no='$po' AND A.material_no='$item'", $con);
							mysql_close($con);
						}
							
							
							//echo $ta;
						/*$t=mysql_query($ta);
						if ($t)
						{
						//echo "YES";
						}
						else
						{*/
						 $input_detail_success = FALSE;
						//}
        		    		if($this->m_grsto->grsto_detail_update($grsto_detail)) {
                                $input_detail_success = TRUE;
        			    	} else {
                                $input_detail_success = FALSE;
        			    	}
						mysql_close($con);
            			} else {
                          $this->m_grsto->grsto_detail_delete($grsto['grsto_detail']['id_grsto_detail'][$i]);
            			}

        	    	}
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $grsto_to_approve['posting_date'] = date('Ymd',strtotime($edit_grsto_header['posting_date']));
                $grsto_to_approve['plant'] = $edit_grsto_header['plant'];
                $grsto_to_approve['id_grsto_plant'] = $edit_grsto_header['id_grsto_plant'];
                $grsto_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $grsto_to_approve['po_no'] = $edit_grsto_header['po_no'];
                $grsto_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grsto_header['plant'],$edit_grsto_header['posting_date'],
                      $edit_grsto_header['id_grsto_plant'],'05');
        		for($i = 1; $i <= $count; $i++) {
        		   $grsto_to_approve['item'][$i] = $edit_grsto_detail[$i]['item'];
        		   $grsto_to_approve['material_no'][$i] = $edit_grsto_detail[$i]['material_no'];
                   $grsto_to_approve['gr_quantity'][$i] = $grsto['grsto_detail']['gr_quantity'][$i];
        		   $grsto_to_approve['uom'][$i] = $edit_grsto_detail[$i]['uom'];
        		   $grsto_to_approve['item_storage_location'][$i] = $edit_grsto_detail[$i]['item_storage_location'];
                }
			    //$approved_data = $this->m_grsto->sap_grsto_header_approve($grsto_to_approve);
    			//if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grsto_no = '';//$approved_data['material_document'];
    				$data = array (
    					'id_grsto_header' =>$grsto['grsto_header']['id_grsto_header'],
    					'grsto_no'	=>	$grsto_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$grsto_header_update_status = $this->m_grsto->grsto_header_update($data);
    				$data = array (
    					'gisto_no' =>$edit_grsto_header['no_doc_gist'],
    					'po_no'	=>	$grsto['grsto_header']['id_grsto_header']
    				);
    				$gisto_header_update_status = $this->m_gisto->gisto_header_update_by_gisto_no($data);

  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
            //}

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
   			    $this->l_general->success_page('Data Transfer In Inter Outlet berhasil diubah ', site_url('grsto/browse'));

              } else {
 			    $this->jagmodule['error_code'] = '003';
		$this->l_general->error_page($this->jagmodule, 'Data Transfer In Inter Outlet tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
  			     $this->l_general->success_page('Data Transfer In Inter Outlet', site_url('grsto/browse'));
              } else {
				  $this->jagmodule['error_code'] = '004';
		$this->l_general->error_page($this->jagmodule, 'Data Transfer In Inter Outlet tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'grsto/browse';
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

	function input_error($error_text) {
      $this->jagmodule['error_code'] = '005';
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function edit_error($error_text) {
      $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function _cancel_update() {
		// start of assign variables and delete not used variables
		$grsto = $_POST;
		unset($grsto['button']);
		// end of assign variables and delete not used variables

		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($grsto['grsto_header']['posting_date']!=$date_today) {
			redirect('grsto/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

    	if(empty($grsto['cancel'])) {
            $gr_quantity_exist = FALSE;
    	} else {
    		$gr_quantity_exist = TRUE;
    	}

		if($gr_quantity_exist == FALSE)
			redirect('grsto/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('grsto', 1, date("Y-m-d")) {

        $edit_grsto_header = $this->m_grsto->grsto_header_select($grsto['grsto_header']['id_grsto_header']);
		$edit_grsto_details = $this->m_grsto->grsto_details_select($grsto['grsto_header']['id_grsto_header']);
    	$i = 1;
	    foreach ($edit_grsto_details->result_array() as $value) {
		    $edit_grsto_detail[$i] = $value;
		    $i++;
        }
        unset($edit_grsto_details);

		if(isset($_POST['button']['cancel'])) {

//			$grsto_header['id_grsto_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

            $grsto_to_cancel['grsto_no'] = $edit_grsto_header['grsto_no'];
            $grsto_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_grsto_header['posting_date']));
            $grsto_to_cancel['posting_date'] = date('Ymd',strtotime($edit_grsto_header['posting_date']));
            $grsto_to_cancel['plant'] = $edit_grsto_header['plant'];
			$grsto_to_cancel['id_grsto_plant'] = $this->m_grsto->id_grsto_plant_new_select($grsto_to_cancel['plant'],date('Y-m-d',strtotime($edit_grsto_header['posting_date'])));
            $grsto_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grsto_header['plant'],$edit_grsto_header['posting_date'],
                      $grsto_to_cancel['id_grsto_plant'],'05');
            $grsto_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_grsto_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($grsto['cancel'][$i]))
       		     $grsto_to_cancel['item'][$i] = $i;
            }
            $cancelled_data = $this->m_grsto->sap_grsto_header_cancel($grsto_to_cancel);
 			$cancel_data_success = FALSE;
   			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($grsto['cancel'][$i])) {
    	    			$grsto_header = array (
    						'id_grsto_header'=>$grsto['grsto_header']['id_grsto_header'],
    						'id_grsto_plant'=>$grsto_to_cancel['id_grsto_plant'],
    					);
    		    		if($this->m_grsto->grsto_header_update($grsto_header)==TRUE) {
    	    			$grsto_detail = array (
    						'id_grsto_detail'=>$edit_grsto_detail[$i]['id_grsto_detail'],
    						'ok_cancel'=>1,
    						'material_docno_cancellation'=>$mat_doc_cancellation,
    						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
    					);
						$batch = array (
								'BaseEntry'=>$grsto['grsto_header']['id_grsto_header'],
								'BaseLinNum'=>$grsto['grsto_detail']['id_grsto_detail'][$i],
        						'Quantity'=>$grsto['grsto_detail']['gr_quantity'][$i],
								'BatchNum'=>$grsto['grsto_detail']['material_docno_cancellation'][$i],
								'Quantity'=>$grsto['grsto_detail']['material_no'][$i],
							);
        		    		
                            
    		    		if($this->m_grsto->grsto_detail_update($grsto_detail)==TRUE && $this->m_grsto->batch_update($batch)==TRUE) {
        				    $cancel_data_success = TRUE;
    			    	}
                        }
                      }
        			}
            }


      	    $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
    			$this->l_general->success_page('Data Transfer In Inter Outlet berhasil dibatalkan', site_url('grsto/browse'));
            } else {
				$this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer In Inter Outlet tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}
	}

	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt Stock Transfer Antar Plant tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_grsto_header) {

		// check approve status
		$grsto_header = $this->m_grsto->grsto_header_select($id_grsto_header);

		if($grsto_header['status'] == '1') {
			$this->m_grsto->grsto_header_delete($id_grsto_header);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function delete($id_grsto_header) {

		if($this->_delete($id_grsto_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer In Inter Outlet berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grsto_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer In Inter Outlet gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grsto_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '008';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_grsto_header']))
			redirect($this->session->userdata['PAGE']['grsto_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_grsto_header'][$i])) {
				$object['data']['grsto_headers'][$j++] = $this->m_grsto->grsto_header_select($_POST['id_grsto_header'][$i]);
			}
		}

		$this->template->write_view('content', 'grsto/grsto_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_grsto_header'][$i]);
		}

		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transfer In Inter Outlet berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['grsto_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

  	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'grsto_data';
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

			// is it grsto template file?
			if($excel['cells'][1][1] == 'Goods Issue  No' && $excel['cells'][1][3] == 'Material No.') {

				$j = 0; // grsto_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grsto header?

					$po_no = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
					$gr_quantity = $excel['cells'][$i][4];

					// check grsto header
					if(strcmp($excel['cells'][$i][1],$excel['cells'][$x][1])!=0) {
                      $j++;
						if($grsto_header_temp = $this->m_grsto->sap_grsto_header_select_by_po_no($po_no)) {

							$object['grsto_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['grsto_headers'][$j]['grsto_no'] = $excel['cells'][$i][1];
							$object['grsto_headers'][$j]['po_no'] = $po_no;
                            $object['grsto_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['grsto_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
                            $object['grsto_headers'][$j]['delivery_plant'] = $grsto_header_temp['SUPPL_PLANT'];
                            $object['grsto_headers'][$j]['delivery_plant_name'] = $grsto_header_temp['SPLANT_NAME'];
                            $object['grsto_headers'][$j]['no_doc_gist'] = $grsto_header_temp['MBLNR'];
							$object['grsto_headers'][$j]['status'] = '1';
							$object['grsto_headers'][$j]['item_group_code'] = $item_group_code;
							$object['grsto_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['grsto_headers'][$j]['filename'] = $upload['file_name'];

            	$grsto_header_exist = TRUE;
							$k = 1; // grsto_detail number
						} else {
            	$grsto_header_exist = FALSE;
						}
					}

					if($grsto_header_exist) {

						if($grsto_detail_temp = $this->m_grsto->sap_grsto_details_select_by_po_and_item_code($po_no,$material_no)) {

							$object['grsto_details'][$j][$k]['id_grsto_h_detail'] = $k;
							$object['grsto_details'][$j][$k]['item'] = $grsto_detail_temp['EBELP'];
							$object['grsto_details'][$j][$k]['material_no'] = $material_no;
							$object['grsto_details'][$j][$k]['material_desc'] = $grsto_detail_temp['MAKTX'];
							$object['grsto_details'][$j][$k]['outstanding_qty'] = $grsto_detail_temp['BSTMG'];
							$object['grsto_details'][$j][$k]['gr_quantity'] = $gr_quantity;
							$object['grsto_details'][$j][$k]['uom'] = $grsto_detail_temp['UNIT'];
							$k++;
						}

					}

				}
				$this->template->write_view('content', 'grsto/grsto_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Goods Receipt Stock Transfer Antar Plant atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grsto/browse_result/0/0/0/0/0/0/0/10';
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

		// is it grsto template file?
		if($excel['cells'][1][1] == 'Goods Issue No' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // grsto_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grsto header?

				$po_no = $excel['cells'][$i][2];
				$item_group_code = 'all';
//				$item = $excel['cells'][$i][2];
				$material_no = $excel['cells'][$i][3];
				$gr_quantity = $excel['cells'][$i][4];

				// check grsto header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;
					if($grsto_header_temp = $this->m_grsto->sap_grsto_header_select_by_po_no($po_no)) {

						$object['grsto_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");

						$object['grsto_headers'][$j]['po_no'] = $po_no;
                        $object['grsto_headers'][$j]['delivery_plant'] = $grsto_header_temp['SUPPL_PLANT'];
                        $object['grsto_headers'][$j]['delivery_plant_name'] = $grsto_header_temp['SPLANT_NAME'];
                        $object['grsto_headers'][$j]['no_doc_gist'] = $grsto_header_temp['MBLNR'];
						$object['grsto_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
            			$object['grsto_headers'][$j]['id_grsto_plant'] = $this->m_grsto->id_grsto_plant_new_select($object['grsto_headers'][$j]['plant'],$object['grsto_headers'][$j]['posting_date']);
						$object['grsto_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
						$object['grsto_headers'][$j]['status'] = '1';
						$object['grsto_headers'][$j]['item_group_code'] = $item_group_code;
						$object['grsto_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
						$object['grsto_headers'][$j]['filename'] = $upload['file_name'];

						$id_grsto_header = $this->m_grsto->grsto_header_insert($object['grsto_headers'][$j]);

           	$grsto_header_exist = TRUE;
						$k = 1; // grsto_detail number

					} else {
           	$grsto_header_exist = FALSE;
					}
				}

				if($grsto_header_exist) {

					if($grsto_detail_temp = $this->m_grsto->sap_grsto_details_select_by_po_and_item_code($po_no,$material_no)) {

						$object['grsto_details'][$j][$k]['id_grsto_header'] = $id_grsto_header;
						$object['grsto_details'][$j][$k]['id_grsto_h_detail'] = $k;
						$object['grsto_details'][$j][$k]['item'] = $grsto_detail_temp['EBELP'];
						$object['grsto_details'][$j][$k]['material_no'] = $material_no;
						$object['grsto_details'][$j][$k]['material_desc'] = $grsto_detail_temp['MAKTX'];
						$object['grsto_details'][$j][$k]['outstanding_qty'] = $grsto_detail_temp['BSTMG'];
						$object['grsto_details'][$j][$k]['gr_quantity'] = $gr_quantity;
						$object['grsto_details'][$j][$k]['uom'] = $grsto_detail_temp['UNIT'];

						$id_grsto_detail = $this->m_grsto->grsto_detail_insert($object['grsto_details'][$j][$k]);

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer In Inter Outlet berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grsto_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Goods Receipt Stock Transfer Antar Plant atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grsto/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}
	
	public function printpdf($id_grsto_header)
	{
		$this->load->model('m_printgrsto');
		//$this->load->model('m_pr');
		//$pr_header = $this->m_pr->pr_header_select($id_pr_header);
		$data['data'] = $this->m_printgrsto->tampil($id_grsto_header);
		
		ob_start();
		$content = $this->load->view('grsto',$data);
		$content = ob_get_clean();		
		$this->load->library('html2pdf');
		try
		{
			$html2pdf = new HTML2PDF('P', 'F4', 'fr');
			$html2pdf->pdf->SetDisplayMode('fullpage');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output('print.pdf');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
		
	}

}
