<?php
class grpofg extends Controller {
	private $jagmodule = array();


	function grpofg() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1034);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_grpofg'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_grpofg');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->model('m_general');

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
		$grpofg_browse_result = $this->session->userdata['PAGE']['grpofg_browse_result'];

		if(!empty($grpofg_browse_result))
			redirect($this->session->userdata['PAGE']['grpofg_browse_result']);
		else
			redirect('grpofg/browse_result/0/0/0/0/0/0/0/10');

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
//		redirect('grpofg/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('grpofg/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('grpofg_browse_result');

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
			'a'	=>	'Goods Receipt PO No',
			'b'	=>	'Goods Receipt FG No',
			'c'	=>	'Delivery No',
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

		$sort_link1 = 'grpofg/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['base_url'] = site_url('grpofg/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_grpofg->grpofg_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['grpofg_headers'] = $this->m_grpofg->grpofg_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of GR PO STO & GR FG Pastry/Cookies dr CK';
		$this->template->write_view('content', 'grpofg/grpofg_browse', $object);
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
    		$data['do_nos'] = $this->m_grpofg->sap_do_select_all();
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

		if(!empty($data['do_no'])) {
			$object['data']['grpofg_header'] = $this->m_grpofg->sap_grpofg_header_select_by_do_no($data['do_no']);
			$data['delivery_date'] = $object['data']['grpofg_header']['DELIV_DATE'];

    		$data['item_groups'] = $this->m_grpofg->sap_grpofg_select_item_group_do($data['do_no']);

   			$object['item_group_code'][0] = '';
   			$object['item_group_code']['all'] = '==All==';

    		if($data['item_groups'] !== FALSE) {
    			foreach ($data['item_groups'] as $item_group) {
    			   $object['item_group_code'][$item_group] = $item_group;
    			}
    		}
		}


		if(!empty($data['item_group_code'])) {
			redirect('grpofg/input2/'.$data['do_no'].'/'.$data['item_group_code'].'/'.$data['delivery_date']);
		}

		$object['page_title'] = 'GR PO STO & GR FG Pastry/Cookies dr CK<div style="font-weight:normal;font-size:80%;font-style:italic;">Terima Barang dari CK</div>';
		$this->template->write_view('content', 'grpofg/grpofg_input', $object);
		$this->template->render();

	}

	function input2()	{

		$validation = FALSE;

		if(count($_POST) != 0) {

			// first post, assume all data TRUE
			$validation_temp = TRUE;

			$j = 1; // counter for each field

			$object['grpofg_details'] = $this->m_grpofg->sap_grpofg_details_select_by_do_no($_POST['grpofg_header']['do_no']);
            $count = count($_POST['grpofg_detail']['item']);
            for($i=1;$i<=$count;$i++) {
                $qty_to_check = 0;
    			foreach ($object['grpofg_details'] as $object['grpofg_detail']) {
                    if ($_POST['grpofg_detail']['item'][$i]==$object['grpofg_detail']['POSNR']) {
                      $qty_to_check = $object['grpofg_detail']['LFIMG'];
                      break;
                    }
    			}
            	$check[$j] = $this->l_form_validation->set_rules($_POST['grpofg_detail']['gr_quantity'][$i], "grpofg_detail[gr_quantity][$i]", 'GR PO Quantity No. '.$i, 'valid_quantity;'.$qty_to_check);
            	// if one data FALSE, set $validation_temp to FALSE
            	if($check[$j]['error'] == TRUE)
            		$validation_temp = FALSE;

				$j++;

            	$check[$j] = $this->l_form_validation->set_rules($_POST['grpofg_detail']['grfg_quantity'][$i], "grpofg_detail[grfg_quantity][$i]", 'GR FG Quantity No. '.$i, 'valid_quantity;'.$qty_to_check);
            	// if one data FALSE, set $validation_temp to FALSE
            	if($check[$j]['error'] == TRUE)
            		$validation_temp = FALSE;
            }
/*
			$object['grpofg_details'] = $this->m_grpofg->sap_grpofg_details_select_by_do_no($_POST['grpofg_header']['do_no']);
			$i = 1;
			foreach ($object['grpofg_details'] as $object['grpofg_detail']) {
                if ($i==$_POST['grpofg_detail']['id_grpofg_h_detail'][$i]) {
					$check[$i] = $this->l_form_validation->set_rules($_POST['grpofg_detail']['gr_quantity'][$i], "grpofg_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['grpofg_detail']['LFIMG']);

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

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

    	if(!empty($do_no)) {
           	$object['grpofg_header']['plant'] = $this->session->userdata['ADMIN']['plant'];
           	$object['grpofg_header']['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
            $object['grpofg_header']['item_group_code'] = $item_group_code;
			$object['grpofg_header']['VBELN'] = $do_no;
       		$object['grpofg_header']['delivery_date'] = $delivery_date;

			if ((!empty($item_group_code)) || (trim($item_group_code)!="")) {
        		if($item_group_code == 'all') {
        			$object['item_group']['item_group_code'] = $item_group_code;
        			$object['item_group']['item_group_name'] = '<strong>All</strong>';
                    $object['grpofg_details'] = $this->m_grpofg->sap_grpofg_details_select_by_do_no($do_no);
        		} else {
        			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
        			$object['item_group']['item_group_name'] = $item_group_code;
        			$object['grpofg_details'] = $this->m_grpofg->sap_grpofg_details_select_by_do_and_item_group($do_no, $object['item_group']['DISPO']);
        		}
            }
    	}

		if(($object['grpofg_details'] !== FALSE)&&(!empty($object['grpofg_details']))) {
			$i = 1;
			foreach ($object['grpofg_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['grpofg_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}
		if(count($_POST) == 0) {
    		$object['data']['grpofg_details'] = $this->m_grpofg->grpofg_details_select($object['data']['id_grpofg_header']);

    		if($object['data']['grpofg_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['grpofg_details']->result_array() as $object['temp']) {
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['grpofg_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }


		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'GR PO STO & GR FG Pastry/Cookies dr CK<div style="font-weight:normal;font-size:80%;font-style:italic;">Terima Barang dari CK</div>';
		$this->template->write_view('content', 'grpofg/grpofg_edit', $object);
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
		$grpofg = $_POST;
		unset($grpofg['button']);

		$count_filled = count($grpofg['grpofg_detail']['gr_quantity']);

		$count = count($grpofg['grpofg_detail']['id_grpofg_h_detail']);

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grpofg['grpofg_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grpofg/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grpofg['grpofg_header']['posting_date'])==FALSE)) {
     	   redirect('grpofg/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

    		$this->session->set_userdata('gr_quantity', $grpofg['grpofg_detail']['gr_quantity']);
 			$grpofg_header['do_no'] = $grpofg['grpofg_header']['do_no'];
			$grpofg_header['delivery_date'] = $grpofg['grpofg_header']['delivery_date'];
			$grpofg_header['grpo_no'] = '';
			$grpofg_header['grfg_no'] = '';

			//$sap_grpofg_header = $this->m_grpofg->sap_grpofg_header_select_by_do_no($grpofg['grpofg_header']['do_no']);

    		$grpofg_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$grpofg_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
// 			$grpofg_header['posting_date'] = $this->m_general->posting_date_select_max($grpofg_header['plant']);
 			$grpofg_header['posting_date'] = $this->l_general->str_to_date($grpofg['grpofg_header']['posting_date']);
			$grpofg_header['id_grpofg_plant'] = $this->m_grpofg->id_grpofg_plant_new_select($grpofg_header['plant'],$grpofg_header['posting_date']);

			if(isset($_POST['button']['approve']))
				$grpofg_header['status'] = '2';
			else
				$grpofg_header['status'] = '1';

			$grpofg_header['item_group_code'] = $grpofg['grpofg_header']['item_group_code'];
			$grpofg_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];

            $web_trans_id = $this->l_general->_get_web_trans_id($grpofg_header['plant'],$grpofg_header['posting_date'],
                      $grpofg_header['id_grpofg_plant'],'15');
            $web_trans_fg_id = $this->l_general->_get_web_trans_id($grpofg_header['plant'],$grpofg_header['posting_date'],
                      $grpofg_header['id_grpofg_plant'],'16');
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $grpofg_to_approve = array (
                      'plant' => $grpofg_header['plant'],
                      'do_no' => $grpofg_header['do_no'],
                      'posting_date' => date('Ymd',strtotime($grpofg_header['posting_date'])),
                      'id_user_input' => $grpofg_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                      'web_trans_fg_id' => $web_trans_fg_id,
                );
              }
              //

			if($id_grpofg_header = $this->m_grpofg->grpofg_header_insert($grpofg_header)) {

                $input_detail_success = FALSE;


				for($i = 1; $i <= $count; $i++) {

					if(!empty($grpofg['grpofg_detail']['gr_quantity'][$i])) {
						$grpofg_detail = $this->m_grpofg->sap_grpofg_details_select_by_do_and_item($grpofg_header['do_no'],$grpofg['grpofg_detail']['item'][$i]);
                        //array utk parameter masukan pada saat save
						$grpofg_detail_to_save['id_grpofg_header'] = $id_grpofg_header;
						$grpofg_detail_to_save['id_grpofg_h_detail'] = $grpofg['grpofg_detail']['id_grpofg_h_detail'][$i];
						$grpofg_detail_to_save['item'] = $grpofg['grpofg_detail']['item'][$i];
						$grpofg_detail_to_save['material_no'] = $grpofg_detail['MATNR'];
						$grpofg_detail_to_save['material_no_pos'] = $grpofg['grpofg_detail']['material_no_pos'][$i];
						$grpofg_detail_to_save['material_desc'] = $grpofg_detail['MAKTX'];
						$grpofg_detail_to_save['outstanding_qty'] = $grpofg_detail['LFIMG'];
						$grpofg_detail_to_save['gr_quantity'] = $grpofg['grpofg_detail']['gr_quantity'][$i];
						$grpofg_detail_to_save['grfg_quantity'] = $grpofg['grpofg_detail']['grfg_quantity'][$i];
						$grpofg_detail_to_save['uom'] = $grpofg_detail['VRKME'];
						$grpofg_detail_to_save['item_storage_location'] = $grpofg_detail['LGORT'];
						$grpofg_detail_to_save['ok'] = '1';
                        //array utk parameter masukan pada saat approval
                        $grpofg_to_approve['item'][$i] = $grpofg_detail_to_save['item'];
                        $grpofg_to_approve['material_no'][$i] = $grpofg_detail_to_save['material_no'];
                        $grpofg_to_approve['material_no_pos'][$i] = $grpofg_detail_to_save['material_no_pos'];
                        $grpofg_to_approve['gr_quantity'][$i] = $grpofg_detail_to_save['gr_quantity'];
                        $grpofg_to_approve['grfg_quantity'][$i] = $grpofg_detail_to_save['grfg_quantity'];
                        $grpofg_to_approve['item_storage_location'][$i] = $grpofg_detail['LGORT'];
                        $grpofg_to_approve['uom'][$i] = $grpofg_detail['VRKME'];
                        $uom_fg = $this->m_grpofg->grpofg_map_item_ck_pos_select_uom($grpofg_to_approve['material_no'][$i],$grpofg_to_approve['material_no_pos'][$i]);
                        if(!empty($uom_fg['uom_pos']))
                          $grpofg_to_approve['uom_fg'][$i] = $uom_fg['uom_pos'];
                        else
                          $grpofg_to_approve['uom_fg'][$i] = $grpofg_detail['VRKME'];
                        //

						unset($grpofg_detail);

						if($this->m_grpofg->grpofg_detail_insert($grpofg_detail_to_save))
                          $input_detail_success = TRUE;

					}

				}

			}

            $this->db->trans_complete();
            $do_nos1 = array('do_nos' => '');
            $this->session->unset_userdata($do_nos1);

			if (($input_detail_success === TRUE) && (isset($_POST['button']['approve']))) {
			    $approved_data = $this->m_grpofg->sap_grpofg_header_approve($grpofg_to_approve);
       			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grpo_no = $approved_data['material_document'];
    				$data = array (
    					'id_grpofg_header'	=>$id_grpofg_header,
    					'grpo_no'	=>	$grpo_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_grpofg->grpofg_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}

                if($approve_data_success==TRUE) {
    			    $approved_data = $this->m_grpofg->sap_grfg_header_approve($grpofg_to_approve);
           			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
        			    $grfg_no = $approved_data['material_document'];
        				$data = array (
        					'id_grpofg_header'	=>$id_grpofg_header,
        					'grfg_no'	=>	$grfg_no,
        					'status'	=>	'2',
        					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
        				);
        				$this->m_grpofg->grpofg_header_update($data);
      				    $approve_data_success = TRUE;
    				} else {

                      $grpofg_to_cancel['grpo_no'] = $grpo_no;
                      $grpofg_to_cancel['mat_doc_year'] = date('Y',strtotime($grpofg_header['posting_date']));
                      $grpofg_to_cancel['posting_date'] = date('Ymd',strtotime($grpofg_header['posting_date']));
                      $grpofg_to_cancel['plant'] = $grpofg_header['plant'];
          		      $grpofg_to_cancel['id_grpofg_plant'] = $this->m_grpofg->id_grpofg_plant_new_select($grpofg_to_cancel['plant'],date('Y-m-d',strtotime($grpofg_header['posting_date'])));
                      $grpofg_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($grpofg_header['plant'],$grpofg_header['posting_date'],
                                $grpofg_to_cancel['id_grpofg_plant'],'15');
                      $grpofg_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                      //$count = count($grpofg['grpofg_detail']['id_grpofg_h_detail']);
              		  for($i = 1; $i <= $count; $i++) {
                	    $grpofg_to_cancel['item'][$i] = $i;
                      }
                      $cancelled_data = $this->m_grpofg->sap_grpofg_header_cancel($grpofg_to_cancel);

        			  $data = array (
        					'id_grpofg_header'	=>$id_grpofg_header,
        					'grpo_no'	=>	'',
        					'status'	=>	'1',
        					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
        			  );
        			  $this->m_grpofg->grpofg_header_update($data);

    				  $approve_data_success = FALSE;
    				}
                }
            }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			    $this->l_general->success_page('Data GR PO STO & GR FG Pastry/Cookies dr CK berhasil dimasukkan', site_url('grpofg/input'));
              } else {
                $this->m_grpofg->grpofg_header_delete($id_grpofg_header);
 			    $this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data GR PO STO & GR FG Pastry/Cookies dr CK tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data GR PO STO & GR FG Pastry/Cookies dr CK berhasil diapprove', site_url('grpofg/input'));
              } else {
                $this->m_grpofg->grpofg_header_delete($id_grpofg_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data GR PO STO & GR FG Pastry/Cookies dr CK tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }
		}

        }
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data GR PO STO & GR FG Pastry/Cookies dr CK tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('grpofg/input2');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data GR PO STO & GR FG Pastry/Cookies dr CK berhasil diapprove';
		$object['refresh_url'] = site_url('grpofg/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data GR PO STO & GR FG Pastry/Cookies dr CK berhasil dimasukkan';
		$object['refresh_url'] = site_url('grpofg/input');
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
	    $grpofg_header = $this->m_grpofg->grpofg_header_select($this->uri->segment(3));
		$status = $grpofg_header['status'];
        unset($grpofg_header);

        $gr_quantity = array('gr_quantity' => '');
        $this->session->unset_userdata($gr_quantity);

    	$validation = FALSE;

        if ($status !== '2') {
    		if(count($_POST) != 0) {

    			// first post, assume all data TRUE
    			$validation_temp = TRUE;

				$j = 1; // counter for each field

    			$object['grpofg_details'] = $this->m_grpofg->sap_grpofg_details_select_by_do_no($_POST['grpofg_header']['do_no']);
                $count = count($_POST['grpofg_detail']['item']);
                for($i=1;$i<=$count;$i++) {
                    $qty_to_check = 0;
        			foreach ($object['grpofg_details'] as $object['grpofg_detail']) {
                        if ($_POST['grpofg_detail']['item'][$i]==$object['grpofg_detail']['POSNR']) {
                          $qty_to_check = $object['grpofg_detail']['LFIMG'];
                          break;
                        }
        			}
                	$check[$j] = $this->l_form_validation->set_rules($_POST['grpofg_detail']['gr_quantity'][$i], "grpofg_detail[gr_quantity][$i]", 'GR PO Quantity No. '.$i, 'valid_quantity;'.$qty_to_check);
                	// if one data FALSE, set $validation_temp to FALSE
                	if($check[$j]['error'] == TRUE)
                		$validation_temp = FALSE;

    				$j++;

                	$check[$j] = $this->l_form_validation->set_rules($_POST['grpofg_detail']['grfg_quantity'][$i], "grpofg_detail[grfg_quantity][$i]", 'GR FG Quantity No. '.$i, 'valid_quantity;'.$qty_to_check);
                	// if one data FALSE, set $validation_temp to FALSE
                	if($check[$j]['error'] == TRUE)
                		$validation_temp = FALSE;
                }
                /*
    			$i = 1;
    			foreach ($object['grpofg_details'] as $object['grpofg_detail']) {

                    if ($i==$_POST['grpofg_detail']['id_grpofg_h_detail'][$i]) {
    					$check[$i] = $this->l_form_validation->set_rules($_POST['grpofg_detail']['gr_quantity'][$i], "grpofg_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['grpofg_detail']['LFIMG']);

    					// if one data FALSE, set $validation_temp to FALSE
    					if($check[$i]['error'] == TRUE)
    						$validation_temp = FALSE;
                    }

    				$i++;
    			}  */

    			// set $validation, based on $validation_temp value;
    			$validation = $validation_temp;
    		}
        }

		if ($validation == FALSE) {
			if(!empty($_POST)) {

				$data = $_POST;
				$grpofg_header = $this->m_grpofg->grpofg_header_select($this->uri->segment(3));

				if($grpofg_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['grpofg_header'] = $this->m_grpofg->grpofg_header_select($this->uri->segment(3));
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

		$object['data']['grpofg_header']['status_string'] = ($object['data']['grpofg_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$do_no = $data['grpofg_header']['do_no'];

		if(count($_POST) == 0) {
    		$item_group_code = $data['grpofg_header']['item_group_code'];
        } else {
    		$item_group_code = $data['item_group']['item_group_code'];
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['grpofg_header']['VBELN'] = $do_no;
		$object['grpofg_header']['delivery_date'] = $data['grpofg_header']['delivery_date'];

    		if($item_group_code == 'all') {
    			$object['item_group']['item_group_code'] = $item_group_code;
    			$object['item_group']['item_group_name'] = '<strong>All</strong>';
    			$object['grpofg_details'] = $this->m_grpofg->sap_grpofg_details_select_by_do_no($do_no);
    		} else {
    			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
    			$object['item_group']['item_group_name'] = $item_group_code;
    			$object['grpofg_details'] = $this->m_grpofg->sap_grpofg_details_select_by_do_and_item_group($do_no, $object['item_group']['DISPO']);
    		}

		if(($object['grpofg_details'] !== FALSE)&&(!empty($object['grpofg_details']))) {
			$i = 1;
			foreach ($object['grpofg_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['grpofg_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}

		if(count($_POST) == 0) {
    	    $object['data']['grpofg_details'] = $this->m_grpofg->grpofg_details_select($object['data']['grpofg_header']['id_grpofg_header']);

    		if($object['data']['grpofg_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['grpofg_details']->result_array() as $object['temp']) {
    //				$object['data']['grpofg_detail'][$i] = $object['temp'];
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['grpofg_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }

   	    // save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit GR PO STO & GR FG Pastry/Cookies dr CK<div style="font-weight:normal;font-size:80%;font-style:italic;">Terima Barang dari CK</div>';
		$this->template->write_view('content', 'grpofg/grpofg_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$grpofg = $_POST;
		unset($grpofg['button']);
		// end of assign variables and delete not used variables

		$count_filled = count($grpofg['grpofg_detail']['gr_quantity']);

		$count = count($grpofg['grpofg_detail']['id_grpofg_h_detail']);

		// variable to check, is at least one product gr_quantity entered?
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grpofg['grpofg_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grpofg/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grpofg['grpofg_header']['posting_date'])==FALSE)) {
     	   redirect('grpofg/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		$edit_grpofg_details = $this->m_grpofg->grpofg_details_select($grpofg['grpofg_header']['id_grpofg_header']);
    	$i = 1;
   		if(!empty($edit_grpofg_details)) {
    	    foreach ($edit_grpofg_details->result_array() as $value) {
    		    $edit_grpofg_detail[$i] = $value;
    		    $i++;
            }
        }
        unset($edit_grpofg_details);

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('gr_quantity', $grpofg['grpofg_detail']['gr_quantity']);

            $postingdate = $grpofg['grpofg_header']['posting_date'];
			$year = $this->l_general->rightstr($postingdate, 4);
			$month = substr($postingdate, 3, 2);
			$day = $this->l_general->leftstr($postingdate, 2);
            $postingdate = $year."-".$month."-".$day.' 00:00:00';
			$id_grpofg_plant = $this->m_grpofg->id_grpofg_plant_new_select("",$postingdate,$grpofg['grpofg_header']['id_grpofg_header']);
            unset($year);
            unset($month);
            unset($day);
    			$data = array (
    				'id_grpofg_header' =>	$grpofg['grpofg_header']['id_grpofg_header'],
                    'id_grpofg_plant' => $id_grpofg_plant,
    				'posting_date' => $postingdate,
    			);
                $this->m_grpofg->grpofg_header_update($data);

                $edit_grpofg_header = $this->m_grpofg->grpofg_header_select($grpofg['grpofg_header']['id_grpofg_header']);

    			if ($this->m_grpofg->grpofg_header_update($data)) {
            		for($i = 1; $i <= $count; $i++) {
            			if(!empty($grpofg['grpofg_detail']['gr_quantity'][$i])) {
        	    			$grpofg_detail = array (
        						'id_grpofg_detail'=>$grpofg['grpofg_detail']['id_grpofg_detail'][$i],
        						'gr_quantity'=>$grpofg['grpofg_detail']['gr_quantity'][$i],
        						'grfg_quantity'=>$grpofg['grpofg_detail']['grfg_quantity'][$i],
        					);
        		    		if($this->m_grpofg->grpofg_detail_update($grpofg_detail)) {
                                $input_detail_success = TRUE;
        			    	} else {
                                $input_detail_success = FALSE;
        			    	}
            			} else {
                          $this->m_grpofg->grpofg_detail_delete($grpofg['grpofg_detail']['id_grpofg_detail'][$i]);
            			}

        	    	}
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
			    $id_grpofg_header = $grpofg['grpofg_header']['id_grpofg_header'];
                $grpofg_to_approve['posting_date'] = date('Ymd',strtotime($edit_grpofg_header['posting_date']));
                $grpofg_to_approve['plant'] = $edit_grpofg_header['plant'];
                $grpofg_to_approve['id_grpofg_plant'] = $edit_grpofg_header['id_grpofg_plant'];
                $grpofg_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $grpofg_to_approve['do_no'] = $edit_grpofg_header['do_no'];
                $grpofg_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grpofg_header['plant'],$edit_grpofg_header['posting_date'],
                      $edit_grpofg_header['id_grpofg_plant'],'15');
                $grpofg_to_approve['web_trans_fg_id'] = $this->l_general->_get_web_trans_id($edit_grpofg_header['plant'],$edit_grpofg_header['posting_date'],
                      $edit_grpofg_header['id_grpofg_plant'],'16');
        		for($i = 1; $i <= $count; $i++) {
        		   $grpofg_to_approve['item'][$i] = $edit_grpofg_detail[$i]['item'];
        		   $grpofg_to_approve['material_no'][$i] = $edit_grpofg_detail[$i]['material_no'];
        		   $grpofg_to_approve['material_no_pos'][$i] = $edit_grpofg_detail[$i]['material_no_pos'];
                   $grpofg_to_approve['gr_quantity'][$i] = $grpofg['grpofg_detail']['gr_quantity'][$i];
                   $grpofg_to_approve['grfg_quantity'][$i] = $grpofg['grpofg_detail']['grfg_quantity'][$i];
                   $grpofg_to_approve['uom'][$i] = $edit_grpofg_detail[$i]['uom'];
                   $uom_fg = $this->m_grpofg->grpofg_map_item_ck_pos_select_uom($grpofg_to_approve['material_no'][$i],$grpofg_to_approve['material_no_pos'][$i]);
                   if(!empty($uom_fg['uom_pos']))
                     $grpofg_to_approve['uom_fg'][$i] = $uom_fg['uom_pos'];
                   else
                     $grpofg_to_approve['uom_fg'][$i] = $grpofg_to_approve['uom'][$i];
        		   $grpofg_to_approve['uom'][$i] = $edit_grpofg_detail[$i]['uom'];
        		   $grpofg_to_approve['item_storage_location'][$i] = $edit_grpofg_detail[$i]['item_storage_location'];
                }
			    $approved_data = $this->m_grpofg->sap_grpofg_header_approve($grpofg_to_approve);
       			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grpo_no = $approved_data['material_document'];
    				$data = array (
    					'id_grpofg_header' =>$id_grpofg_header,
    					'grpo_no'	=>	$grpo_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$grpofg_header_update_status = $this->m_grpofg->grpofg_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}

                if($approve_data_success==TRUE) {
    			    $approved_data = $this->m_grpofg->sap_grfg_header_approve($grpofg_to_approve);
           			if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
        			    $grfg_no = $approved_data['material_document'];
        				$data = array (
        					'id_grpofg_header'	=>$id_grpofg_header,
        					'grfg_no'	=>	$grfg_no,
        					'status'	=>	'2',
        					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
        				);
        				$this->m_grpofg->grpofg_header_update($data);
      				    $approve_data_success = TRUE;
    				} else {
                      $grpofg_to_cancel['grpo_no'] = $grpo_no;
                      $grpofg_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_grpofg_header['posting_date']));
                      $grpofg_to_cancel['posting_date'] = date('Ymd',strtotime($edit_grpofg_header['posting_date']));
                      $grpofg_to_cancel['plant'] = $edit_grpofg_header['plant'];
          		      $grpofg_to_cancel['id_grpofg_plant'] = $this->m_grpofg->id_grpofg_plant_new_select($grpofg_to_cancel['plant'],date('Y-m-d',strtotime($edit_grpofg_header['posting_date'])));
                      $grpofg_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grpofg_header['plant'],$edit_grpofg_header['posting_date'],
                                $grpofg_to_cancel['id_grpofg_plant'],'15');
                      $grpofg_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                      //$count = count($edit_grpofg_detail['id_grpofg_h_detail']);
              		  for($i = 1; $i <= $count; $i++) {
                	    $grpofg_to_cancel['item'][$i] = $i;
                      }
                      $cancelled_data = $this->m_grpofg->sap_grpofg_header_cancel($grpofg_to_cancel);

        			  $data = array (
        					'id_grpofg_header'	=>$id_grpofg_header,
        					'grpo_no'	=>	'',
        					'status'	=>	'1',
        					'id_user_cancel'	=>	$this->session->userdata['ADMIN']['admin_id'],
        			  );
        			  $this->m_grpofg->grpofg_header_update($data);

    				  $approve_data_success = FALSE;
    				}
                }
            }
            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
			  $this->l_general->success_page('Data GR PO STO & GR FG Pastry/Cookies dr CK berhasil diubah', site_url('grpofg/browse'));
              } else {
			  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data GR PO STO & GR FG Pastry/Cookies dr CK tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
 			   }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
			  $this->l_general->success_page('Data GR PO STO & GR FG Pastry/Cookies dr CK berhasil diapprove', site_url('grpofg/browse'));
              } else {
			  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data GR PO STO & GR FG Pastry/Cookies dr CK tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'grpofg/browse';
 		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function edit_error($error_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $error_text;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '001';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _cancel_update() {
		// start of assign variables and delete not used variables
		$grpofg = $_POST;
		unset($grpofg['button']);
		// end of assign variables and delete not used variables

		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($grpofg['grpofg_header']['posting_date']!=$date_today) {
			redirect('grpofg/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

    	if(empty($grpofg['cancel'])) {
            $gr_quantity_exist = FALSE;
    	} else {
    		$gr_quantity_exist = TRUE;
    	}

		if($gr_quantity_exist == FALSE)
			redirect('grpofg/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('grpofg', 1, date("Y-m-d")) {

        $edit_grpofg_header = $this->m_grpofg->grpofg_header_select($grpofg['grpofg_header']['id_grpofg_header']);
		$edit_grpofg_details = $this->m_grpofg->grpofg_details_select($grpofg['grpofg_header']['id_grpofg_header']);
    	$i = 1;
	    foreach ($edit_grpofg_details->result_array() as $value) {
		    $edit_grpofg_detail[$i] = $value;
		    $i++;
        }
        unset($edit_grpofg_details);

		if(isset($_POST['button']['cancel'])) {

//			$grpofg_header['id_grpofg_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();
//            echo "<pre>";
//            print_r($grpofg['cancel']);
//            echo "</pre>";
//            exit;
            $grpofg_to_cancel['grpo_no'] = $edit_grpofg_header['grpo_no'];
            $grpofg_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_grpofg_header['posting_date']));
            $grpofg_to_cancel['posting_date'] = date('Ymd',strtotime($edit_grpofg_header['posting_date']));
            $grpofg_to_cancel['plant'] = $edit_grpofg_header['plant'];
			$grpofg_to_cancel['id_grpofg_plant'] = $this->m_grpofg->id_grpofg_plant_new_select($grpofg_to_cancel['plant'],date('Y-m-d',strtotime($edit_grpofg_header['posting_date'])));
            $grpofg_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grpofg_header['plant'],$edit_grpofg_header['posting_date'],
                      $grpofg_to_cancel['id_grpofg_plant'],'15');
            $grpofg_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_grpofg_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($grpofg['cancel'][$i]))
       		     $grpofg_to_cancel['item'][$i] = $i;
            }
            $cancelled_data = $this->m_grpofg->sap_grpofg_header_cancel($grpofg_to_cancel);
 			$cancel_data_success = FALSE;
   			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($grpofg['cancel'][$i])) {
    	    			$grpofg_header = array (
    						'id_grpofg_header'=>$grpofg['grpofg_header']['id_grpofg_header'],
    						'id_grpofg_plant'=>$grpofg_to_cancel['id_grpofg_plant'],
    					);
    		    		if($this->m_grpofg->grpofg_header_update($grpofg_header)==TRUE) {
        	    			$grpofg_detail = array (
        						'id_grpofg_detail'=>$edit_grpofg_detail[$i]['id_grpofg_detail'],
        						'ok_cancel'=>1,
        						'material_docno_cancellation'=>$mat_doc_cancellation,
        						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
        					);
        		    		if($this->m_grpofg->grpofg_detail_update($grpofg_detail)==TRUE) {
            				    $cancel_data_success = TRUE;
        			    	}
                        }
                      }
        	    }
            }

            if(($cancel_data_success==TRUE)&&(!empty($edit_grpofg_header['grfg_no']))) {

                $grpofg_to_cancel['grpo_no'] = $edit_grpofg_header['grfg_no'];
                $grpofg_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grpofg_header['plant'],$edit_grpofg_header['posting_date'],
                          $grpofg_to_cancel['id_grpofg_plant'],'16');

                $cancelled_data = $this->m_grpofg->sap_grpofg_header_cancel($grpofg_to_cancel);
     			$cancel_data_success = FALSE;
       			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
    			    $mat_doc_cancellation = $cancelled_data['material_document'];
            		for($i = 1; $i <= $count; $i++) {
            			if(!empty($grpofg['cancel'][$i])) {
        	    			$grpofg_header = array (
        						'id_grpofg_header'=>$grpofg['grpofg_header']['id_grpofg_header'],
        						'id_grpofg_plant'=>$grpofg_to_cancel['id_grpofg_plant'],
        					);
        		    		if($this->m_grpofg->grpofg_header_update($grpofg_header)==TRUE) {
        		    		  $grpofg_detail = array (
            						'id_grpofg_detail'=>$edit_grpofg_detail[$i]['id_grpofg_detail'],
            						'ok_cancel'=>1,
            						'material_docno_fg_cancellation'=>$mat_doc_cancellation,
            						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
            					);
            		    		if($this->m_grpofg->grpofg_detail_update($grpofg_detail)==TRUE) {
                				    $cancel_data_success = TRUE;
            			    	}
                            }
                          }
            	    }
                }

            }


      	    $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
			     $this->l_general->success_page('Data GR PO STO & GR FG Pastry/Cookies dr CK berhasil dibatalkan', site_url('grpofg/browse'));
            } else {
				$this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data GR PO STO & GR FG Pastry/Cookies dr CK tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

/*			if($this->m_grpofg->grpofg_details_delete($grpofg['id_grpofg_header'])) {

				if(isset($_POST['button']['approve'])) {
					if($grpofg_header = $this->m_grpofg->grpofg_header_select($grpofg['id_grpofg_header'])) {
						if($grpofg_no = $this->m_grpofg->sap_grpofg_header_approve($grpofg_header)) {
							$data = array (
								'id_grpofg_header'	=>	$grpofg['id_grpofg_header'],
								'grpofg_no'	=>	$grpofg_no,
							);

							$grpofg_header_update_status = $this->m_grpofg->grpofg_header_update($data);
						}
					}
				}

				for($i = 1; $i <= $count; $i++) {

					if(!empty($grpofg['gr_quantity'][$i])) {
						$grpofg_detail = $this->m_grpofg->sap_grpofg_detail_select_by_id_grpofg_h_detail($grpofg['id_grpofg_h_detail'][$i]);
						unset($grpofg_detail['id_grpofg_header']);
						unset($grpofg_detail['do_no']);
						unset($grpofg_detail['plant']);
						unset($grpofg_detail['storage_location']);

						$grpofg_detail['id_grpofg_header'] = $grpofg['id_grpofg_header'];
						$grpofg_detail['gr_quantity'] = $grpofg['gr_quantity'][$i];

						if($this->m_grpofg->grpofg_detail_insert($grpofg_detail)) {
							if(isset($_POST['button']['approve']))
								$id_grpofg_detail2 = $this->m_grpofg->sap_grpofg_detail_approve($grpofg_detail);
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
		$object['refresh_text'] = 'Data GR PO STO & GR FG Pastry/Cookies dr CK tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_grpofg_header) {

		// check approve status
		$grpofg_header = $this->m_grpofg->grpofg_header_select($id_grpofg_header);

		if($grpofg_header['status'] == '1') {
			$this->m_grpofg->grpofg_header_delete($id_grpofg_header);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function delete($id_grpofg_header) {

		if($this->_delete($id_grpofg_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data GR PO STO & GR FG Pastry/Cookies dr CK berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpofg_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data GR PO STO & GR FG Pastry/Cookies dr CK gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpofg_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '008';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_grpofg_header']))
			redirect($this->session->userdata['PAGE']['grpofg_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_grpofg_header'][$i])) {
				$object['data']['grpofg_headers'][$j++] = $this->m_grpofg->grpofg_header_select($_POST['id_grpofg_header'][$i]);
			}
		}

        if (isset($_POST['button']['savetoexcel']))
  		  $this->template->write_view('content', 'grpofg/grpofg_export_confirm', $object);
        else
  		  $this->template->write_view('content', 'grpofg/grpofg_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_grpofg_header'][$i]);
		}

		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data GR PO STO & GR FG Pastry/Cookies dr CK berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['grpofg_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

   	function file_export() {
        $data = $this->m_grpofg->grpofg_select_to_export($_POST['id_grpofg_header']);
    	if($data!=FALSE) {
    	  $this->l_general->export_to_excel($data,'GRPoFG');
        }
    }

   function file_import() {

	$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'grpofg_data';
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

            if($_SERVER['SERVER_NAME'] == 'localhost')
            $file =  $_SERVER['DOCUMENT_ROOT'].'/sap_php/excel_upload/'.$upload['file_name'];
            else
            $file =  $_SERVER['DOCUMENT_ROOT'].'/excel_upload/'.$upload['file_name'];

			$this->session->set_userdata('file_upload', $file);
			$this->session->set_userdata('file_name_upload', $upload['file_name']);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

			// is it grpofg template file?
			if($excel['cells'][1][1] == 'Goods Receipt No.' && $excel['cells'][1][3] == 'Material No.') {

				$j = 0; // grpofg_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpofg header?

					$do_no = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
					$gr_quantity = $excel['cells'][$i][4];

					// check grpofg header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;
						if($grpofg_header_temp = $this->m_grpofg->sap_grpofg_header_select_by_do_no($do_no)) {
							$object['grpofg_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['grpofg_headers'][$j]['grpofg_no'] = $excel['cells'][$i][1];
							$object['grpofg_headers'][$j]['do_no'] = $do_no;


							$object['grpofg_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['grpofg_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['grpofg_headers'][$j]['status'] = '1';
							$object['grpofg_headers'][$j]['item_group_code'] = $item_group_code;
							$object['grpofg_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['grpofg_headers'][$j]['file_name'] = $upload['file_name'];

            	$grpofg_header_exist = TRUE;
							$k = 1; // grpofg_detail number
						} else {
            	$grpofg_header_exist = FALSE;
						}
					}

					if($grpofg_header_exist) {

   						if($grpofg_detail_temp = $this->m_grpofg->sap_grpofg_details_select_by_do_and_item_code($do_no,$material_no)) {
							$object['grpofg_details'][$j][$k]['id_grpofg_h_detail'] = $k;
							$object['grpofg_details'][$j][$k]['item'] = $grpofg_detail_temp['POSNR'];
							$object['grpofg_details'][$j][$k]['material_no'] = $material_no;
							$object['grpofg_details'][$j][$k]['material_desc'] = $grpofg_detail_temp['MAKTX'];
							$object['grpofg_details'][$j][$k]['outstanding_qty'] = $grpofg_detail_temp['LFIMG'];
							$object['grpofg_details'][$j][$k]['gr_quantity'] = $gr_quantity;
							$object['grpofg_details'][$j][$k]['uom'] = $grpofg_detail_temp['VRKME'];
							$k++;
						}

					}

				}

//				print_r($excel);
//				print_r($object);

				$this->template->write_view('content', 'grpofg/grpofg_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file GR PO STO & GR FG Pastry/Cookies dr CK atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grpofg/browse_result/0/0/0/0/0/0/0/10';
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

        $upload['file_name'] = $this->session->userdata('file_name_upload');
		$this->excel_reader->read($this->session->userdata('file_upload'));
		// Sheet 1
		$excel = $this->excel_reader->sheets[0] ;

		// is it grpofg template file?
		if($excel['cells'][1][1] == 'Goods Receipt No.' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // grpofg_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grpofg header?

				$do_no = $excel['cells'][$i][2];
				$item_group_code = 'all';
				$material_no = $excel['cells'][$i][3];
				$gr_quantity = $excel['cells'][$i][4];

				// check grpofg header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;
					if($grpofg_header_temp = $this->m_grpofg->sap_grpofg_header_select_by_do_no($do_no)) {

						$object['grpofg_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
						$object['grpofg_headers'][$j]['do_no'] = $do_no;
						$object['grpofg_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
            			$object['grpofg_headers'][$j]['id_grpofg_plant'] = $this->m_grpofg->id_grpofg_plant_new_select($object['grpofg_headers'][$j]['plant'],$object['grpofg_headers'][$j]['posting_date']);
						$object['grpofg_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
						$object['grpofg_headers'][$j]['status'] = '1';
						$object['grpofg_headers'][$j]['item_group_code'] = $item_group_code;
						$object['grpofg_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
						$object['grpofg_headers'][$j]['filename'] = $upload['file_name'];

						$id_grpofg_header = $this->m_grpofg->grpofg_header_insert($object['grpofg_headers'][$j]);

           	$grpofg_header_exist = TRUE;
						$k = 1; // grpofg_detail number

					} else {
           	$grpofg_header_exist = FALSE;
					}
				}

				if($grpofg_header_exist) {

					if($grpofg_detail_temp = $this->m_grpofg->sap_grpofg_details_select_by_do_and_item_code($do_no,$material_no)) {
						$object['grpofg_details'][$j][$k]['id_grpofg_header'] = $id_grpofg_header;
						$object['grpofg_details'][$j][$k]['id_grpofg_h_detail'] = $k;
						$object['grpofg_details'][$j][$k]['item'] = $grpofg_detail_temp['POSNR'];
						$object['grpofg_details'][$j][$k]['material_no'] = $material_no;
						$object['grpofg_details'][$j][$k]['material_desc'] = $grpofg_detail_temp['MAKTX'];
						$object['grpofg_details'][$j][$k]['outstanding_qty'] = $grpofg_detail_temp['LFIMG'];
						$object['grpofg_details'][$j][$k]['gr_quantity'] = $gr_quantity;
						$object['grpofg_details'][$j][$k]['uom'] = $grpofg_detail_temp['UNIT'];

						$id_grpofg_detail = $this->m_grpofg->grpofg_detail_insert($object['grpofg_details'][$j][$k]);

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data GR PO STO & GR FG Pastry/Cookies dr CK berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpofg_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file GR PO STO & GR FG Pastry/Cookies dr CK atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grpofg/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}

}
?>