<?php
class grpodlv extends Controller {
	private $jagmodule = array();


	function grpodlv() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1033);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_grpodlv'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_grpodlv');
		$this->load->library('l_form_validation');
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
		$grpodlv_browse_result = $this->session->userdata['PAGE']['grpodlv_browse_result'];

		if(!empty($grpodlv_browse_result))
			redirect($this->session->userdata['PAGE']['grpodlv_browse_result']);
		else
			redirect('grpodlv/browse_result/0/0/0/0/0/0/0/10');

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
        if (empty($limit)) {
		  $limit = 10;
        }
//		redirect('grpodlv/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('grpodlv/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('grpodlv_browse_result');

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
			'b'	=>	'Transfer Slip Number',
			'a'	=>	'Goods Receipt No',
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

		$sort_link1 = 'grpodlv/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['base_url'] = site_url('grpodlv/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_grpodlv->grpodlv_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['grpodlv_headers'] = $this->m_grpodlv->grpodlv_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Goods Receipt from Central Kitchen  ';
		$this->template->write_view('content', 'grpodlv/grpodlv_browse', $object);
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

			$object['data']['do_no'] = 0;
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes


        if(empty($this->session->userdata['do_nos'])||empty($data)) {
		//echo "xxxxx";
    		$data['do_nos'] = $this->m_grpodlv->sap_do_select_all();
      		$this->session->set_userdata('do_nos', $data['do_nos']);
        } else {
            $data['do_nos'] = $this->session->userdata['do_nos'];
        }

		if($data['do_nos'] !== FALSE) {
			$object['do_no'][0] = '';
			foreach ($data['do_nos'] as $do_no) {
				$object['do_no'][$do_no['VBELN']] = $do_no['VBELN'].' - '.$do_no['Doc_Num'];
			}
		}

		if(!empty($data['do_no'])) {
			$object['data']['grpodlv_header'] = $this->m_grpodlv->sap_grpodlv_header_select_by_do_no($data['do_no']);
			$data['delivery_date'] = $object['data']['grpodlv_header']['DELIV_DATE'];
			$data['to_plant'] = $object['data']['grpodlv_header']['PLANT'];
			//echo $data['to_plant'];
			
    		$data['item_groups'] = $this->m_grpodlv->sap_grpodlv_select_item_group_do($data['do_no']);

   			$object['item_group_code'][0] = '';
   			$object['item_group_code']['all'] = '==All==';

    		if($data['item_groups'] !== FALSE) {
    			foreach ($data['item_groups'] as $item_group) {
    			   $object['item_group_code'][$item_group] = $item_group;
    			}
    		}
		}


		if(!empty($data['item_group_code'])) {
			redirect('grpodlv/input2/'.$data['do_no'].'/'.$data['item_group_code'].'/'.$data['delivery_date']);
		}

		$object['page_title'] = 'Goods Receipt from Central Kitchen  ';
// <div style="font-weight:normal;font-size:80%;font-style:italic;">Terima Barang dari Central Warehouse</div>';
		$this->template->write_view('content', 'grpodlv/grpodlv_input', $object);
		$this->template->render();

	}

	function input2()	{

		$validation = FALSE;

		if(count($_POST) != 0) {

			// first post, assume all data TRUE
			$validation_temp = TRUE;

			$object['grpodlv_details'] = $this->m_grpodlv->sap_grpodlv_details_select_by_do_no($_POST['grpodlv_header']['do_no']);
            $count = count($_POST['grpodlv_detail']['item']);
            for($i=1;$i<=$count;$i++) {
                $qty_to_check = 0;
    			foreach ($object['grpodlv_details'] as $object['grpodlv_detail']) {
                    if ($_POST['grpodlv_detail']['item'][$i]==$object['grpodlv_detail']['POSNR']) {
                      $qty_to_check = $object['grpodlv_detail']['LFIMG'];
                      break;
                    }
    			}
            	$check[$i] = $this->l_form_validation->set_rules($_POST['grpodlv_detail']['gr_quantity'][$i], "grpodlv_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$qty_to_check);
            	// if one data FALSE, set $validation_temp to FALSE
            	if($check[$i]['error'] == TRUE)
            		$validation_temp = FALSE;
            }
/*
			$object['grpodlv_details'] = $this->m_grpodlv->sap_grpodlv_details_select_by_do_no($_POST['grpodlv_header']['do_no']);
			$i = 1;
			foreach ($object['grpodlv_details'] as $object['grpodlv_detail']) {
                if ($i==$_POST['grpodlv_detail']['id_grpodlv_h_detail'][$i]) {
					$check[$i] = $this->l_form_validation->set_rules($_POST['grpodlv_detail']['gr_quantity'][$i], "grpodlv_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['grpodlv_detail']['LFIMG']);

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

		$do_no = $this->uri->segment(3);
		$item_group_code = $this->uri->segment(4);
		$delivery_date = $this->uri->segment(5);
		$object['data']['grpodlv_header'] = $this->m_grpodlv->sap_grpodlv_header_select_by_do_no($do_no);
			$data['to_plant'] = $object['data']['grpodlv_header']['PLANT'];
			
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

    	if(!empty($do_no)) {
           	$object['grpodlv_header']['plant'] = $this->session->userdata['ADMIN']['plant'];
           	$object['grpodlv_header']['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
            $object['grpodlv_header']['item_group_code'] = $item_group_code;
			$object['grpodlv_header']['VBELN'] = $do_no;
       		$object['grpodlv_header']['delivery_date'] = $delivery_date;
			$object['grpodlv_header']['to_plant'] = $data['to_plant'];

			if ((!empty($item_group_code)) || (trim($item_group_code)!="")) {
        		if($item_group_code == 'all') {
					$object['item_group']['item_group_code'] = $item_group_code;
        			$object['item_group']['item_group_name'] = '<strong>All</strong>';
                    $object['grpodlv_details'] = $this->m_grpodlv->sap_grpodlv_details_select_by_do_no($do_no);
        		} else {
        			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
        			$object['item_group']['item_group_name'] = $item_group_code;
        			$object['grpodlv_details'] = $this->m_grpodlv->sap_grpodlv_details_select_by_do_and_item_group($do_no, $object['item_group']['DISPO']);
        		}
            }
    	}

		if(($object['grpodlv_details'] !== FALSE)&&(!empty($object['grpodlv_details']))) {
			$i = 1;
			foreach ($object['grpodlv_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['grpodlv_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}
		
		$data['val'] = $this->m_grpodlv->var_reason_select_all();

    	if($data['val'] !== FALSE) {
    		$object['val'][''] = '';

    		foreach ($data['val']->result_array() as $reason) {
    			$object['val'][$reason['variance_name']] = $reason['variance_name'];
    		}
    	}
		
		if(count($_POST) == 0) {
    		$object['data']['grpodlv_details'] = $this->m_grpodlv->grpodlv_details_select($object['data']['id_grpodlv_header']);

    		if($object['data']['grpodlv_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['grpodlv_details']->result_array() as $object['temp']) {
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['grpodlv_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }


		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Goods Receipt from Central Kitchen <div style="font-weight:normal;font-size:80%;font-style:italic;">Terima Barang dari CK</div>';
		$this->template->write_view('content', 'grpodlv/grpodlv_edit', $object);
		$this->template->render();
	}

	function input_error($error_text) {
      $this->jagmodule['error_code'] = '001'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function edit_error($error_text) {
      $this->jagmodule['error_code'] = '002'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function _input_add() {
		// start of assign variables and delete not used variables
		$grpodlv = $_POST;
		unset($grpodlv['button']);

		$count_filled = count($grpodlv['grpodlv_detail']['gr_quantity']);

		$count = count($grpodlv['grpodlv_detail']['id_grpodlv_h_detail']);

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grpodlv['grpodlv_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grpodlv/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grpodlv['grpodlv_header']['posting_date'])==FALSE)) {
     	   redirect('grpodlv/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

    		$this->session->set_userdata('gr_quantity', $grpodlv['grpodlv_detail']['gr_quantity']);
 			$grpodlv_header['do_no'] = $grpodlv['grpodlv_header']['do_no'];
			$base=$grpodlv['grpodlv_header']['do_no'];
			$grpodlv_header['delivery_date'] = $grpodlv['grpodlv_header']['delivery_date'];
			$grpodlv_header['grpodlv_no'] = '';

			//$sap_grpodlv_header = $this->m_grpodlv->sap_grpodlv_header_select_by_do_no($grpodlv['grpodlv_header']['do_no']);

    		$grpodlv_header['plant'] = $this->session->userdata['ADMIN']['plant'];
			$grpodlv_header['to_plant'] = $grpodlv['grpodlv_header']['to_plant'] ;
    		$grpodlv_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
 			$grpodlv_header['posting_date'] = $this->m_general->posting_date_select_max($grpodlv_header['plant']);
 			//$grpodlv_header['posting_date'] = $grpodlv['grpodlv_header']['posting_date'];
			$grpodlv_header['id_grpodlv_plant'] = $this->m_grpodlv->id_grpodlv_plant_new_select($grpodlv_header['plant'],$grpodlv_header['posting_date']);

			if(isset($_POST['button']['approve']))
				$grpodlv_header['status'] = '2';
			else
				$grpodlv_header['status'] = '1';

			$grpodlv_header['item_group_code'] = $grpodlv['grpodlv_header']['item_group_code'];
			$grpodlv_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];

             $web_trans_id = $this->l_general->_get_web_trans_id($grpodlv_header['plant'],$grpodlv_header['posting_date'],
                      $grpodlv_header['id_grpodlv_plant'],'02');
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $grpodlv_to_approve = array (
                      'plant' => $grpodlv_header['plant'],
                      'do_no' => $grpodlv_header['do_no'],
                      'posting_date' => $grpodlv_header['posting_date'],
                      'id_user_input' => $grpodlv_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                );
              }
              //

			if($id_grpodlv_header = $this->m_grpodlv->grpodlv_header_insert($grpodlv_header)) {

                $input_detail_success = FALSE;


				for($i = 1; $i <= $count; $i++) {

					if(!empty($grpodlv['grpodlv_detail']['gr_quantity'][$i])) {
						$grpodlv_detail = $this->m_grpodlv->sap_grpodlv_details_select_by_do_and_item($grpodlv_header['do_no'],$grpodlv['grpodlv_detail']['item'][$i]);
                        //array utk parameter masukan pada saat save
						$grpodlv_detail_to_save['id_grpodlv_header'] = $id_grpodlv_header;
						
		
						$batch['BaseEntry']= $id_grpodlv_header;
						$grpodlv_detail_to_save['id_grpodlv_h_detail'] = $grpodlv['grpodlv_detail']['id_grpodlv_h_detail'][$i];
						$batch['BaseLinNum'] = $grpodlv['grpodlv_detail']['id_grpodlv_h_detail'][$i];
						$grpodlv_detail_to_save['item'] = $grpodlv['grpodlv_detail']['item'][$i];
						$line = $grpodlv['grpodlv_detail']['item'][$i];
						$grpodlv_detail_to_save['material_no'] = $grpodlv_detail['MATNR'];
						$batch['ItemCode'] = $grpodlv_detail['MATNR'];
						
						if ($grpodlv_detail['LFIMG'] >= $grpodlv_detail['grpodlv_dept_detail']['gr_quantity'][$i])
						{
							$grpodlv_detail_to_save['outstanding_qty'] = $grpodlv_detail['LFIMG'] - $grpodlv['grpodlv_dept_detail']['gr_quantity'][$i];
						}
						else
						{
							$grpodlv_detail_to_save['outstanding_qty'] = $grpodlv_detail['LFIMG'];
						}
		
						$batch['BatchNum']=  $grpodlv['grpodlv_detail']['num'][$i];
						$batch['BaseType'] = 67;
						$batch['Createdate'] = date('Ymd',strtotime($grpodlv_header['posting_date']));
						$grpodlv_detail_to_save['material_desc'] = $grpodlv_detail['MAKTX'];
						//$grpodlv_detail_to_save['num'] = $grpodlv['grpodlv_detail']['num'][$i];
						$grpodlv_detail_to_save['outstanding_qty'] = $grpodlv_detail['LFIMG'];
						$grpodlv_detail_to_save['gr_quantity'] = $grpodlv['grpodlv_detail']['gr_quantity'][$i];
						$grpodlv_detail_to_save['val'] = $grpodlv['grpodlv_detail']['val'][$i];
						$grpodlv_detail_to_save['var'] = $grpodlv_detail_to_save['outstanding_qty']-$grpodlv_detail_to_save['gr_quantity'];
						//echo '{'.$grpodlv_detail_to_save['val'].'} <br>';
						//echo '{'.$grpodlv_detail_to_save['var'].'}';
						$batch['Quantity'] = $grpodlv['grpodlv_detail']['gr_quantity'][$i];
						$grpodlv_detail_to_save['uom'] = $grpodlv_detail['VRKME'];
						$grpodlv_detail_to_save['item_storage_location'] = $grpodlv_detail['LGORT'];
						$grpodlv_detail_to_save['ok'] = '1';
                        //array utk parameter masukan pada saat approval
                        $grpodlv_to_approve['item'][$i] = $grpodlv_detail_to_save['item'];
                        $grpodlv_to_approve['material_no'][$i] = $grpodlv_detail_to_save['material_no'];
                        $grpodlv_to_approve['gr_quantity'][$i] = $grpodlv_detail_to_save['gr_quantity'];
                        $grpodlv_to_approve['item_storage_location'][$i] = $grpodlv_detail['LGORT'];
                        $grpodlv_to_approve['uom'][$i] = $grpodlv_detail['VRKME'];
						$val=$grpodlv['grpodlv_detail']['val'][$i] ;
                        //
						
						
						$db_mysql=$this->m_database->get_db_mysql();
						$user_mysql=$this->m_database->get_user_mysql();
						$pass_mysql=$this->m_database->get_pass_mysql();
						$db_sap=$this->m_database->get_db_sap();
						$user_sap=$this->m_database->get_user_sap();
						$pass_sap=$this->m_database->get_pass_sap();
						$host_sap=$this->m_database->get_host_sap();
						$c=mssql_connect($host_sap,$user_sap,$pass_sap);
						$b=mssql_select_db($db_sap,$c);
						$con = sqlsrv_connect($host_sap, array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap));
						
						//$line=$i-1;
						//$tem=mssql_query("SELECT U_grqty_web FROM WTR1 where DocEntry = '$base' AND LineNum ='$line'");
						//$rem=mssql_fetch_array($tem);
						
						$rem=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT U_grqty_web FROM WTR1 where DocEntry = '$base' AND LineNum ='$line'"));
						$gr_qty1=$rem['U_grqty_web'];
						$realoutstanding = $grpodlv_detail_to_save['outstanding_qty'];
						
						$outstanding =$grpodlv_detail['LFIMG'];
						$gr_qty = $gr_qty1 + $grpodlv['grpodlv_detail']['gr_quantity'][$i];
						//echo $realoutstanding.'-'.$outstanding.'-'.$gr_qty;
						//echo "<br>SELECT U_grqty_web FROM WTR1 where DocEntry = '$base' AND LineNum ='$line'";
						
						unset($grpodlv_detail);
						//echo "$batch[BaseEntry],$batch[BaseLinNum],$batch[ItemCode],$batch[BatchNum],$batch[Createdate],$batch[Quantity] <br>";
						if($this->m_grpodlv->grpodlv_detail_insert($grpodlv_detail_to_save))
                          $input_detail_success = TRUE;
						  
						  if ($input_detail_success === TRUE)
						  {
						  
						   if(isset($_POST['button']['approve']))
							{
						   
						   		if ($outstanding = 0)
							 	{ 
							 		//mssql_query("UPDATE OWTR SET U_Stat = 1 WHERE DOcEntry = '$base' ");
									sqlsrv_query($con,"UPDATE OWTR SET U_Stat = 1 WHERE DOcEntry = '$base'");
							 	}
							// mssql_query("UPDATE WTR1 SET U_grqty_web = '$gr_qty'  WHERE DocEntry = '$base'  AND LineNum ='$line'");
							 sqlsrv_query($con,"UPDATE WTR1 SET U_grqty_web = '$gr_qty'  WHERE DocEntry = '$base'  AND LineNum ='$line'");
						     
							
								if ($val==1 || $val==2)
								{
									$cekvar=$grpodlv_detail_to_save['var'] + $gr_qty;
									//mssql_query("UPDATE OWTR SET U_Stat = 1 WHERE DOcEntry = '$base' "); sudah tidak dipakai
									// mssql_query("UPDATE WTR1 SET U_grqty_web = '$cekvar'  WHERE DocEntry = '$base' AND LineNum ='$line'");
									 sqlsrv_query($con,"UPDATE WTR1 SET U_grqty_web = '$cekvar'  WHERE DocEntry = '$base' AND LineNum ='$line'");
								}
							
						    }
						}

					}

				}

			}

            $this->db->trans_complete();
            $do_nos1 = array('do_nos' => '');
            $this->session->unset_userdata($do_nos1);

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			 //   $approved_data = $this->m_grpodlv->sap_grpodlv_header_approve($grpodlv_to_approve);
       		//	if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grpodlv_no ='';// $approved_data['material_document'];
    				$data = array (
    					'id_grpodlv_header'	=>$id_grpodlv_header,
    					'grpodlv_no'	=>	$grpodlv_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_grpodlv->grpodlv_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
				sqlsrv_close($con);
         //   }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
			  	
   			    $this->l_general->success_page('Data Goods Receipt from Central Kitchen  berhasil dimasukkan', site_url('grpodlv/input'));
              } else {
                $this->m_grpodlv->grpodlv_header_delete($id_grpodlv_header);
 			    $this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt from Central Kitchen  tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Goods Receipt from Central Kitchen  berhasil diapprove', site_url('grpodlv/input'));
              } else {
                $this->m_grpodlv->grpodlv_header_delete($id_grpodlv_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt from Central Kitchen  tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }
		}

        }
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt PO STO with Delivery tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('grpodlv/input2');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt PO STO with Delivery berhasil diapprove';
		$object['refresh_url'] = site_url('grpodlv/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt PO STO with Delivery berhasil dimasukkan';
		$object['refresh_url'] = site_url('grpodlv/input');
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
	    $grpodlv_header = $this->m_grpodlv->grpodlv_header_select($this->uri->segment(3));
		$status = $grpodlv_header['status'];
        unset($grpodlv_header);

        $gr_quantity = array('gr_quantity' => '');
        $this->session->unset_userdata($gr_quantity);

    	$validation = FALSE;

        if ($status !== '2') {
    		if(count($_POST) != 0) {

    			// first post, assume all data TRUE
    			$validation_temp = TRUE;

    			$object['grpodlv_details'] = $this->m_grpodlv->sap_grpodlv_details_select_by_do_no($_POST['grpodlv_header']['do_no']);
                $count = count($_POST['grpodlv_detail']['item']);
                for($i=1;$i<=$count;$i++) {
                    $qty_to_check = 0;
					$id=$_POST['grpodlv_header']['do_no'];
					$id_d=$_POST['grpodlv_detail']['item'][$i];
					
					$db_mysql=$this->m_database->get_db_mysql();
					$user_mysql=$this->m_database->get_user_mysql();
					$pass_mysql=$this->m_database->get_pass_mysql();
					$db_sap=$this->m_database->get_db_sap();
					$user_sap=$this->m_database->get_user_sap();
					$pass_sap=$this->m_database->get_pass_sap();
					$host_sap=$this->m_database->get_host_sap();
					$con = mysql_connect("localhost",$user_mysql,$pass_mysql);
			mysql_select_db($db_mysql, $con);
		$to="SELECT t_grpodlv_detail.outstanding_qty FROM t_grpodlv_detail JOIN t_grpodlv_header ON t_grpodlv_header.id_grpodlv_header = t_grpodlv_detail.id_grpodlv_header
			WHERE t_grpodlv_header.do_no='$id' AND t_grpodlv_detail.item='$id_d' <br>";
		$t=mysql_query($to, $con);
		$rw=mysql_fetch_array($t);
		//echo $to;
        			foreach ($object['grpodlv_details'] as $object['grpodlv_detail']) {
                        if ($_POST['grpodlv_detail']['item'][$i]==$object['grpodlv_detail']['id_grpodlv_h_detail']) {
                          $qty_to_check = $object['grpodlv_detail']['outstanding_qty'];
                          break;
                        }
        			}
					$cekQty=$_POST['grpodlv_detail']['gr_quantity'][$i]+$_POST['grpodlv_detail']['var'][$i];
					$outs=$_POST['grpodlv_detail']['outstanding_qty'][$i];
					$rcpt=$_POST['grpodlv_detail']['gr_quantity'][$i];
					$ot=$_POST['grpodlv_detail']['outstanding_qty'][$i];
					
					//echo '['.$cekQty.'] - ['.$ot.']';
                	$check[$i] = $this->l_form_validation->set_rules($_POST['grpodlv_detail']['gr_quantity'][$i], "grpodlv_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$ot);
					if ($cekQty < 1)
					{
						
						$validation_temp = FALSE;
						
					}
                	// if one data FALSE, set $validation_temp to FALSE
                	if($check[$i]['error'] == TRUE)
                		$validation_temp = FALSE;
                }
                /*
    			$i = 1;
    			foreach ($object['grpodlv_details'] as $object['grpodlv_detail']) {

                    if ($i==$_POST['grpodlv_detail']['id_grpodlv_h_detail'][$i]) {
    					$check[$i] = $this->l_form_validation->set_rules($_POST['grpodlv_detail']['gr_quantity'][$i], "grpodlv_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['grpodlv_detail']['LFIMG']);

    					// if one data FALSE, set $validation_temp to FALSE
    					if($check[$i]['error'] == TRUE)
    						$validation_temp = FALSE;
                    }

    				$i++;
    			}  */

    			// set $validation, based on $validation_temp value;
    			$validation = $validation_temp;
    		}
		mysql_close($con);
        }

		if ($validation == FALSE) {
			if(!empty($_POST)) {

				$data = $_POST;
				$grpodlv_header = $this->m_grpodlv->grpodlv_header_select($this->uri->segment(3));

				if($grpodlv_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['grpodlv_header'] = $this->m_grpodlv->grpodlv_header_select($this->uri->segment(3));
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

		$object['data']['grpodlv_header']['status_string'] = ($object['data']['grpodlv_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$id_grpodlv_header = $data['grpodlv_header']['id_grpodlv_header'];
		$do_no = $data['grpodlv_header']['do_no'];

		if(count($_POST) == 0) {
    		$item_group_code = $data['grpodlv_header']['item_group_code'];
        } else {
    		$item_group_code = $data['item_group']['item_group_code'];
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['grpodlv_header']['id_grpodlv_header'] = $id_grpodlv_header;
		$object['grpodlv_header']['VBELN'] = $do_no;
		$object['grpodlv_header']['delivery_date'] = $data['grpodlv_header']['delivery_date'];

    		if($item_group_code == 'all') {
    			$object['item_group']['item_group_code'] = $item_group_code;
    			$object['item_group']['item_group_name'] = '<strong>All</strong>';
    			$object['grpodlv_details'] = $this->m_grpodlv->sap_grpodlv_details_select_by_do_no($do_no);
    		} else {
    			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
    			$object['item_group']['item_group_name'] = $item_group_code;
    			$object['grpodlv_details'] = $this->m_grpodlv->sap_grpodlv_details_select_by_do_and_item_group($do_no, $object['item_group']['DISPO']);
    		}

		if(($object['grpodlv_details'] !== FALSE)&&(!empty($object['grpodlv_details']))) {
			$i = 1;
			foreach ($object['grpodlv_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['grpodlv_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}

		if(count($_POST) == 0) {
    	    $object['data']['grpodlv_details'] = $this->m_grpodlv->grpodlv_details_select($object['data']['grpodlv_header']['id_grpodlv_header']);

    		if($object['data']['grpodlv_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['grpodlv_details']->result_array() as $object['temp']) {
    //				$object['data']['grpodlv_detail'][$i] = $object['temp'];
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['grpodlv_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }

   	    // save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Goods Receipt from Central Kitchen <div style="font-weight:normal;font-size:80%;font-style:italic;">Terima Barang dari CK</div>';
		$this->template->write_view('content', 'grpodlv/grpodlv_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$grpodlv = $_POST;
		unset($grpodlv['button']);
		// end of assign variables and delete not used variables

		$count_filled = count($grpodlv['grpodlv_detail']['gr_quantity']);

		$count = count($grpodlv['grpodlv_detail']['id_grpodlv_h_detail']);

		// variable to check, is at least one product gr_quantity entered?
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grpodlv['grpodlv_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grpodlv/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

       // if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grpodlv['grpodlv_header']['posting_date'])==FALSE)) {
     	 //  redirect('grpodlv/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        //} else {

		$edit_grpodlv_details = $this->m_grpodlv->grpodlv_details_select($grpodlv['grpodlv_header']['id_grpodlv_header']);
    	$i = 1;
   		if(!empty($edit_grpodlv_details)) {
    	    foreach ($edit_grpodlv_details->result_array() as $value) {
    		    $edit_grpodlv_detail[$i] = $value;
    		    $i++;
            }
        }
        unset($edit_grpodlv_details);

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('gr_quantity', $grpodlv['grpodlv_detail']['gr_quantity']);

            $postingdate = $grpodlv['grpodlv_header']['posting_date'];
			$year = $this->l_general->rightstr($postingdate, 4);
			$month = substr($postingdate, 3, 2);
			$day = $this->l_general->leftstr($postingdate, 2);
            $postingdate = $year."-".$month."-".$day.' 00:00:00';
			$base=$grpodlv['grpodlv_header']['do_no'];
			$id_grpodlv_plant = $this->m_grpodlv->id_grpodlv_plant_new_select("",$postingdate,$grpodlv['grpodlv_header']['id_grpodlv_header']);
            unset($year);
            unset($month);
            unset($day);
    			$data = array (
    				'id_grpodlv_header' =>	$grpodlv['grpodlv_header']['id_grpodlv_header'],
                    'id_grpodlv_plant' => $id_grpodlv_plant,
    				'posting_date' => $postingdate,
    			);
                $this->m_grpodlv->grpodlv_header_update($data);

                $edit_grpodlv_header = $this->m_grpodlv->grpodlv_header_select($grpodlv['grpodlv_header']['id_grpodlv_header']);

    			if ($this->m_grpodlv->grpodlv_header_update($data)) {
            		for($i = 1; $i <= $count; $i++) {
            			if(!empty($grpodlv['grpodlv_detail']['gr_quantity'][$i])) {
						$var= $grpodlv['grpodlv_detail']['outstanding_qty'][$i]-$grpodlv['grpodlv_detail']['gr_quantity'][$i];
						$line=$grpodlv['grpodlv_detail']['item'][$i];
        	    			$grpodlv_detail = array (
        						'id_grpodlv_detail'=>$grpodlv['grpodlv_detail']['id_grpodlv_detail'][$i],
        						'gr_quantity'=>$grpodlv['grpodlv_detail']['gr_quantity'][$i],
								'num' => $grpodlv['grpodlv_detail']['num'][$i],
								'val' => $grpodlv['grpodlv_detail']['val'][$i],
								'var' => $var
        					);
							$batch = array (
								'BaseEntry'=>$grpodlv['grpodlv_header']['do_no'],
								'ItemCode'=>$grpodlv['grpodlv_detail']['material_no'][$i],
								'BatchNum'=>$grpodlv['grpodlv_detail']['num'][$i],
        						'BaseLinNum'=>$grpodlv['grpodlv_detail']['id_grpodlv_h_detail'][$i],
        						'Quantity'=>$grpodlv['grpodlv_detail']['gr_quantity'][$i]
        					);
						//	$t="$batch[BaseEntry]-$batch[ItemCode]-$batch[BatchNum]-($batch[BaseLinNum])-$batch[Quantity]";
							//echo $t;
        		    		if($this->m_grpodlv->grpodlv_detail_update($grpodlv_detail)) {
                                $input_detail_success = TRUE;
        			    	} else {
                                $input_detail_success = FALSE;
        			    	}
            			} else {
                          $this->m_grpodlv->grpodlv_detail_delete($grpodlv['grpodlv_detail']['id_grpodlv_detail'][$i]);
            			}
						
						$val=$grpodlv['grpodlv_detail']['val'][$i] ;
                        //
						
						$db_mysql=$this->m_database->get_db_mysql();
						$user_mysql=$this->m_database->get_user_mysql();
						$pass_mysql=$this->m_database->get_pass_mysql();
						$db_sap=$this->m_database->get_db_sap();
						$user_sap=$this->m_database->get_user_sap();
						$pass_sap=$this->m_database->get_pass_sap();
						$host_sap=$this->m_database->get_host_sap();
						$c=mssql_connect($host_sap,$user_sap,$pass_sap);
						$b=mssql_select_db($db_sap,$c);
						$con = sqlsrv_connect($host_sap, array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));
						//$line=$i-1;
						//$tem=mssql_query("SELECT U_grqty_web FROM WTR1 where DocEntry = '$base' AND LineNum ='$line'");
						//$rem=mssql_fetch_array($tem);
						$rem=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT U_grqty_web FROM WTR1 where DocEntry = '$base' AND LineNum ='$line'"));
						$gr_qty1=$rem['U_grqty_web'];
						$realoutstanding = $grpodlv_detail_to_save['outstanding_qty'];
						
						$gr_qty = $gr_qty1 + $grpodlv['grpodlv_detail']['gr_quantity'][$i];
						//echo $realoutstanding.'-'.$outstanding.'-'.$gr_qty;
						//echo "<br>SELECT U_grqty_web FROM WTR1 where DocEntry = '$base' AND LineNum ='$line'";
						
						//echo "$batch[BaseEntry],$batch[BaseLinNum],$batch[ItemCode],$batch[BatchNum],$batch[Createdate],$batch[Quantity] <br>";
						  
						  if ($input_detail_success === TRUE)
						  {
						   //echo "<br>SELECT U_grqty_web FROM WTR1 where DocEntry = '$base' AND LineNum ='$line'";
						   
						   if(isset($_POST['button']['approve']))
							{
							sqlsrv_query($con,"UPDATE WTR1 SET U_grqty_web = '$gr_qty'  WHERE DocEntry = '$base' AND  LineNum='$line'");
						    //mssql_query("UPDATE WTR1 SET U_grqty_web = '$gr_qty'  WHERE DocEntry = '$base' AND  LineNum='$line'");
							
							//echo "UPDATE WTR1 SET U_grqty_web = '$gr_qty'  WHERE DocEntry = '$base' AND  LineNum='$line'";
						     
							
							if ($val==1 || $val==2)
							{
							$cekvar=$var + $gr_qty;
								//mssql_query("UPDATE OWTR SET U_Stat = 1 WHERE DOcEntry = '$base' ");
								sqlsrv_query($con,"UPDATE WTR1 SET U_grqty_web = '$cekvar'  WHERE DocEntry = '$base' AND  LineNum='$line'");
								//mssql_query("UPDATE WTR1 SET U_grqty_web = '$cekvar'  WHERE DocEntry = '$base' AND  LineNum='$line' ");
								//echo "UPDATE WTR1 SET U_grqty_web = '$cekvar'  WHERE DocEntry = '$base' AND  LineNum='$line' ";
							}
							 	
								
							}

					//}
						

        	    	}
                }
				sqlsrv_close($con);
  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $grpodlv_to_approve['posting_date'] = date('Ymd',strtotime($edit_grpodlv_header['posting_date']));
                $grpodlv_to_approve['plant'] = $edit_grpodlv_header['plant'];
                $grpodlv_to_approve['id_grpodlv_plant'] = $edit_grpodlv_header['id_grpodlv_plant'];
                $grpodlv_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $grpodlv_to_approve['do_no'] = $edit_grpodlv_header['do_no'];
                $grpodlv_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grpodlv_header['plant'],$edit_grpodlv_header['posting_date'],
                      $edit_grpodlv_header['id_grpodlv_plant'],'02');
        		for($i = 1; $i <= $count; $i++) {
        		   $grpodlv_to_approve['item'][$i] = $edit_grpodlv_detail[$i]['item'];
        		   $grpodlv_to_approve['material_no'][$i] = $edit_grpodlv_detail[$i]['material_no'];
                   $grpodlv_to_approve['gr_quantity'][$i] = $grpodlv['grpodlv_detail']['gr_quantity'][$i];
        		   $grpodlv_to_approve['uom'][$i] = $edit_grpodlv_detail[$i]['uom'];
        		   $grpodlv_to_approve['item_storage_location'][$i] = $edit_grpodlv_detail[$i]['item_storage_location'];
                }
			 //   $approved_data = $this->m_grpodlv->sap_grpodlv_header_approve($grpodlv_to_approve);
       		//	if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grpodlv_no = '';// $approved_data['material_document'];
    				$data = array (
    					'id_grpodlv_header' =>$grpodlv['grpodlv_header']['id_grpodlv_header'],
    					'grpodlv_no'	=>	$grpodlv_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$grpodlv_header_update_status = $this->m_grpodlv->grpodlv_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
				//mssql_close($c);
           // }
		   
		    		/*if ($input_detail_success === TRUE)
						  {
						   	if ($outstanding = 0)
							 { 
							 mssql_query("UPDATE OWTR SET U_Stat = 1 WHERE DOcEntry = '$base' ");}
							 mssql_query("UPDATE WTR1 SET U_grqty_web = '$gr_qty'  WHERE DocEntry = '$base' ");
							 } 
						  }*/
					
            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
			  $this->l_general->success_page('Data Goods Receipt from Central Kitchen  berhasil diubah', site_url('grpodlv/browse'));
              } else {
			  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data GGoods Receipt from Central Kitchen  tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
 			   }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
			  $this->l_general->success_page('Data Goods Receipt from Central Kitchen  berhasil diapprove', site_url('grpodlv/browse'));
              } else {
			  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt PO STO with Delivery tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'grpodlv/browse';
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
		$grpodlv = $_POST;
		unset($grpodlv['button']);
		// end of assign variables and delete not used variables

		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($grpodlv['grpodlv_header']['posting_date']!=$date_today) {
			redirect('grpodlv/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

    	if(empty($grpodlv['cancel'])) {
            $gr_quantity_exist = FALSE;
    	} else {
    		$gr_quantity_exist = TRUE;
    	}

		if($gr_quantity_exist == FALSE)
			redirect('grpodlv/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('grpodlv', 1, date("Y-m-d")) {

        $edit_grpodlv_header = $this->m_grpodlv->grpodlv_header_select($grpodlv['grpodlv_header']['id_grpodlv_header']);
		$edit_grpodlv_details = $this->m_grpodlv->grpodlv_details_select($grpodlv['grpodlv_header']['id_grpodlv_header']);
    	$i = 1;
	    foreach ($edit_grpodlv_details->result_array() as $value) {
		    $edit_grpodlv_detail[$i] = $value;
		    $i++;
        }
        unset($edit_grpodlv_details);

		if(isset($_POST['button']['cancel'])) {

//			$grpodlv_header['id_grpodlv_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();
//            echo "<pre>";
//            print_r($grpodlv['cancel']);
//            echo "</pre>";
//            exit;
            $grpodlv_to_cancel['grpodlv_no'] = $edit_grpodlv_header['grpodlv_no'];
            $grpodlv_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_grpodlv_header['posting_date']));
            $grpodlv_to_cancel['posting_date'] = date('Ymd',strtotime($edit_grpodlv_header['posting_date']));
            $grpodlv_to_cancel['plant'] = $edit_grpodlv_header['plant'];
			$grpodlv_to_cancel['id_grpodlv_plant'] = $this->m_grpodlv->id_grpodlv_plant_new_select($grpodlv_to_cancel['plant'],date('Y-m-d',strtotime($edit_grpodlv_header['posting_date'])));
            $grpodlv_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grpodlv_header['plant'],$edit_grpodlv_header['posting_date'],
                      $grpodlv_to_cancel['id_grpodlv_plant'],'02');
            $grpodlv_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_grpodlv_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($grpodlv['cancel'][$i]))
       		     $grpodlv_to_cancel['item'][$i] = $i;
            }
            $cancelled_data = $this->m_grpodlv->sap_grpodlv_header_cancel($grpodlv_to_cancel);
 			$cancel_data_success = FALSE;
   			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($grpodlv['cancel'][$i])) {
    	    			$grpodlv_header = array (
    						'id_grpodlv_header'=>$grpodlv['grpodlv_header']['id_grpodlv_header'],
    						'id_grpodlv_plant'=>$grpodlv_to_cancel['id_grpodlv_plant'],
    					);
    		    		if($this->m_grpodlv->grpodlv_header_update($grpodlv_header)==TRUE) {
        	    			$grpodlv_detail = array (
        						'id_grpodlv_detail'=>$edit_grpodlv_detail[$i]['id_grpodlv_detail'],
        						'ok_cancel'=>1,
        						'material_docno_cancellation'=>$mat_doc_cancellation,
        						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
        					);
        		    		if($this->m_grpodlv->grpodlv_detail_update($grpodlv_detail)==TRUE) {
            				    $cancel_data_success = TRUE;
        			    	}
                        }
                      }
        			}
            }


      	    $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
			     $this->l_general->success_page('Data Goods Receipt from Central Kitchen  berhasil dibatalkan', site_url('grpodlv/browse'));
            } else {
				$this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Goods Receipt from Central Kitchen  tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

/*			if($this->m_grpodlv->grpodlv_details_delete($grpodlv['id_grpodlv_header'])) {

				if(isset($_POST['button']['approve'])) {
					if($grpodlv_header = $this->m_grpodlv->grpodlv_header_select($grpodlv['id_grpodlv_header'])) {
						if($grpodlv_no = $this->m_grpodlv->sap_grpodlv_header_approve($grpodlv_header)) {
							$data = array (
								'id_grpodlv_header'	=>	$grpodlv['id_grpodlv_header'],
								'grpodlv_no'	=>	$grpodlv_no,
							);

							$grpodlv_header_update_status = $this->m_grpodlv->grpodlv_header_update($data);
						}
					}
				}

				for($i = 1; $i <= $count; $i++) {

					if(!empty($grpodlv['gr_quantity'][$i])) {
						$grpodlv_detail = $this->m_grpodlv->sap_grpodlv_detail_select_by_id_grpodlv_h_detail($grpodlv['id_grpodlv_h_detail'][$i]);
						unset($grpodlv_detail['id_grpodlv_header']);
						unset($grpodlv_detail['do_no']);
						unset($grpodlv_detail['plant']);
						unset($grpodlv_detail['storage_location']);

						$grpodlv_detail['id_grpodlv_header'] = $grpodlv['id_grpodlv_header'];
						$grpodlv_detail['gr_quantity'] = $grpodlv['gr_quantity'][$i];

						if($this->m_grpodlv->grpodlv_detail_insert($grpodlv_detail)) {
							if(isset($_POST['button']['approve']))
								$id_grpodlv_detail2 = $this->m_grpodlv->sap_grpodlv_detail_approve($grpodlv_detail);
						}

					}

				}

			}

			$this->db->trans_complete();

			$this->_edit_success();
*/
		}
	}

	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt PO STO with Delivery tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_grpodlv_header) {
$grpodlv_delete['user'] = $this->session->userdata['ADMIN']['admin_id'];
	  $grpodlv_delete['module'] = "GR FROM Central Kitchen";
	 $grpodlv_delete['plant'] = $this->session->userdata['ADMIN']['plant'];
	  $grpodlv_delete['id_delete'] = $id_grpodlv_header;
		// check approve status
		$grpodlv_header = $this->m_grpodlv->grpodlv_header_select($id_grpodlv_header);

		if($grpodlv_header['status'] == '1') {
			$this->m_grpodlv->grpodlv_header_delete($id_grpodlv_header);
			$this->m_grpodlv->user_delete($grpodlv_delete);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function delete($id_grpodlv_header) {

		if($this->_delete($id_grpodlv_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt from Central Kitchen  berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpodlv_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt from Central Kitchen  gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpodlv_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '008';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_grpodlv_header']))
			redirect($this->session->userdata['PAGE']['grpodlv_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_grpodlv_header'][$i])) {
				$object['data']['grpodlv_headers'][$j++] = $this->m_grpodlv->grpodlv_header_select($_POST['id_grpodlv_header'][$i]);
			}
		}

        if (isset($_POST['button']['savetoexcel']))
  		  $this->template->write_view('content', 'grpodlv/grpodlv_export_confirm', $object);
        else
    	  $this->template->write_view('content', 'grpodlv/grpodlv_delete_multiple_confirm', $object);

		$this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_grpodlv_header'][$i]);
		}

		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Goods Receipt from Central Kitchen  berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['grpodlv_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

 function file_import() {

	$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'grpodlv_data';
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
			$this->session->set_userdata('file_name_upload', $upload['file_name']);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

			// is it grpodlv template file?
			if($excel['cells'][1][1] == 'Goods Receipt No.' && $excel['cells'][1][3] == 'Material No.') {

				$j = 0; // grpodlv_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpodlv header?

					$do_no = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
					$gr_quantity = $excel['cells'][$i][4];

					// check grpodlv header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;
						if($grpodlv_header_temp = $this->m_grpodlv->sap_grpodlv_header_select_by_do_no($do_no)) {
							$object['grpodlv_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['grpodlv_headers'][$j]['grpodlv_no'] = $excel['cells'][$i][1];
							$object['grpodlv_headers'][$j]['do_no'] = $do_no;


							$object['grpodlv_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['grpodlv_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['grpodlv_headers'][$j]['status'] = '1';
							$object['grpodlv_headers'][$j]['item_group_code'] = $item_group_code;
							$object['grpodlv_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['grpodlv_headers'][$j]['file_name'] = $upload['file_name'];

            	$grpodlv_header_exist = TRUE;
							$k = 1; // grpodlv_detail number
						} else {
            	$grpodlv_header_exist = FALSE;
						}
					}

					if($grpodlv_header_exist) {

   						if($grpodlv_detail_temp = $this->m_grpodlv->sap_grpodlv_details_select_by_do_and_item_code($do_no,$material_no)) {
							$object['grpodlv_details'][$j][$k]['id_grpodlv_h_detail'] = $k;
							$object['grpodlv_details'][$j][$k]['item'] = $grpodlv_detail_temp['POSNR'];
							$object['grpodlv_details'][$j][$k]['material_no'] = $material_no;
							$object['grpodlv_details'][$j][$k]['material_desc'] = $grpodlv_detail_temp['MAKTX'];
							$object['grpodlv_details'][$j][$k]['outstanding_qty'] = $grpodlv_detail_temp['LFIMG'];
							$object['grpodlv_details'][$j][$k]['gr_quantity'] = $gr_quantity;
							$object['grpodlv_details'][$j][$k]['uom'] = $grpodlv_detail_temp['VRKME'];
							$k++;
						}

					}

				}

//				print_r($excel);
//				print_r($object);

				$this->template->write_view('content', 'grpodlv/grpodlv_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Goods Receipt from Central Kitchen  atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grpodlv/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '009';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

			}

		}

	}

   	function file_export() {
        $data = $this->m_grpodlv->grpodlv_select_to_export($_POST['id_grpodlv_header']);
    	if($data!=FALSE) {
    	  $this->l_general->export_to_excel($data,'GRPoSTO');
        }
    }

	function file_import_execute() {

		// Load the spreadsheet reader library
		$this->load->library('excel_reader');

		// Set output Encoding.
		$this->excel_reader->setOutputEncoding('CP1251');

        $upload['file_name'] = $this->session->userdata('file_name_upload');
		$this->excel_reader->read($this->session->userdata('file_upload'));
		// Sheet 1
		$excel = $this->excel_reader->sheets[0] ;

		// is it grpodlv template file?
		if($excel['cells'][1][1] == 'Goods Receipt No.' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // grpodlv_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grpodlv header?

				$do_no = $excel['cells'][$i][2];
				$item_group_code = 'all';
				$material_no = $excel['cells'][$i][3];
				$gr_quantity = $excel['cells'][$i][4];

				// check grpodlv header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;
					if($grpodlv_header_temp = $this->m_grpodlv->sap_grpodlv_header_select_by_do_no($do_no)) {

						$object['grpodlv_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
						$object['grpodlv_headers'][$j]['do_no'] = $do_no;
						$object['grpodlv_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
            			$object['grpodlv_headers'][$j]['id_grpodlv_plant'] = $this->m_grpodlv->id_grpodlv_plant_new_select($object['grpodlv_headers'][$j]['plant'],$object['grpodlv_headers'][$j]['posting_date']);
						$object['grpodlv_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
						$object['grpodlv_headers'][$j]['status'] = '1';
						$object['grpodlv_headers'][$j]['item_group_code'] = $item_group_code;
						$object['grpodlv_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
						$object['grpodlv_headers'][$j]['filename'] = $upload['file_name'];

						$id_grpodlv_header = $this->m_grpodlv->grpodlv_header_insert($object['grpodlv_headers'][$j]);

           	$grpodlv_header_exist = TRUE;
						$k = 1; // grpodlv_detail number

					} else {
           	$grpodlv_header_exist = FALSE;
					}
				}

				if($grpodlv_header_exist) {

					if($grpodlv_detail_temp = $this->m_grpodlv->sap_grpodlv_details_select_by_do_and_item_code($do_no,$material_no)) {
						$object['grpodlv_details'][$j][$k]['id_grpodlv_header'] = $id_grpodlv_header;
						$object['grpodlv_details'][$j][$k]['id_grpodlv_h_detail'] = $k;
						$object['grpodlv_details'][$j][$k]['item'] = $grpodlv_detail_temp['POSNR'];
						$object['grpodlv_details'][$j][$k]['material_no'] = $material_no;
						$object['grpodlv_details'][$j][$k]['material_desc'] = $grpodlv_detail_temp['MAKTX'];
						$object['grpodlv_details'][$j][$k]['outstanding_qty'] = $grpodlv_detail_temp['LFIMG'];
						$object['grpodlv_details'][$j][$k]['gr_quantity'] = $gr_quantity;
						$object['grpodlv_details'][$j][$k]['uom'] = $grpodlv_detail_temp['UNIT'];

						$id_grpodlv_detail = $this->m_grpodlv->grpodlv_detail_insert($object['grpodlv_details'][$j][$k]);

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Goods Receipt PO STO with Delivery berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpodlv_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Goods Receipt from Central Kitchen  atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grpodlv/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}
	
	public function printpdf($id_grpodlv_header)
	{
		$this->load->model('m_printgrpodlv');
		//$this->load->model('m_pr');
		//$pr_header = $this->m_pr->pr_header_select($id_pr_header);
		$data['data'] = $this->m_printgrpodlv->tampil($id_grpodlv_header);
		
		ob_start();
		$content = $this->load->view('grpodlv',$data);
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
?>