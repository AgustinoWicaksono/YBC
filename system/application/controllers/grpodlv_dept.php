<?php
class grpodlv_dept extends Controller {
	private $jagmodule = array();


	function grpodlv_dept() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1033);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_grsto'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_grpodlv_dept');
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
		$grpodlv_dept_browse_result = $this->session->userdata['PAGE']['grpodlv_dept_browse_result'];

		if(!empty($grpodlv_dept_browse_result))
			redirect($this->session->userdata['PAGE']['grpodlv_dept_browse_result']);
		else
			redirect('grpodlv_dept/browse_result/0/0/0/0/0/0/0/10');

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
//		redirect('grpodlv_dept/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('grpodlv_dept/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('grpodlv_dept_browse_result');

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
			'b'	=>	'Delivery No',
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

		$sort_link1 = 'grpodlv_dept/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		$config['base_url'] = site_url('grpodlv_dept/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_grpodlv_dept->grpodlv_dept_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['grpodlv_dept_headers'] = $this->m_grpodlv_dept->grpodlv_dept_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Transfer In Inter Departement';
		$this->template->write_view('content', 'grpodlv_dept/grpodlv_dept_browse', $object);
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
    		$data['do_nos'] = $this->m_grpodlv_dept->sap_do_select_all();
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
			$object['data']['grpodlv_dept_header'] = $this->m_grpodlv_dept->sap_grpodlv_dept_header_select_by_do_no($data['do_no']);
			$data['delivery_date'] = $object['data']['grpodlv_dept_header']['DELIV_DATE'];

    		$data['item_groups'] = $this->m_grpodlv_dept->sap_grpodlv_dept_select_item_group_do($data['do_no']);

   			$object['item_group_code'][0] = '';
   			$object['item_group_code']['all'] = '==All==';

    		if($data['item_groups'] !== FALSE) {
    			foreach ($data['item_groups'] as $item_group) {
    			   $object['item_group_code'][$item_group] = $item_group;
    			}
    		}
			$data['to_plant'] = $object['data']['grpodlv_dept_header']['PLANT'];
			//echo $data['to_plant'];
		}


		if(!empty($data['item_group_code'])) {
			redirect('grpodlv_dept/input2/'.$data['do_no'].'/'.$data['item_group_code'].'/'.$data['delivery_date']);
		}

		$object['page_title'] = 'Transfer In Inter Departement <div style="font-weight:normal;font-size:80%;font-style:italic;"></div>';
		$this->template->write_view('content', 'grpodlv_dept/grpodlv_dept_input', $object);
		$this->template->render();

	}

	function input2()	{

		$validation = FALSE;

		if(count($_POST) != 0) {

			// first post, assume all data TRUE
			$validation_temp = TRUE;

			$object['grpodlv_dept_details'] = $this->m_grpodlv_dept->sap_grpodlv_dept_details_select_by_do_no($_POST['grpodlv_dept_header']['do_no']);
            $count = count($_POST['grpodlv_dept_detail']['item']);
            for($i=1;$i<=$count;$i++) {
                $qty_to_check = 0;
    			foreach ($object['grpodlv_dept_details'] as $object['grpodlv_dept_detail']) {
                    if ($_POST['grpodlv_dept_detail']['item'][$i]==$object['grpodlv_dept_detail']['POSNR']) {
                      $qty_to_check = $object['grpodlv_dept_detail']['LFIMG'] ;
                      break;
                    }
    			}
            	$check[$i] = $this->l_form_validation->set_rules($_POST['grpodlv_dept_detail']['gr_quantity'][$i], "grpodlv_dept_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$qty_to_check);
            	// if one data FALSE, set $validation_temp to FALSE
            	if($check[$i]['error'] == TRUE)
            		$validation_temp = FALSE;
					//echo "(".$qty_to_check.")"; 
            }
/*
			$object['grpodlv_dept_details'] = $this->m_grpodlv_dept->sap_grpodlv_dept_details_select_by_do_no($_POST['grpodlv_dept_header']['do_no']);
			$i = 1;
			foreach ($object['grpodlv_dept_details'] as $object['grpodlv_dept_detail']) {
                if ($i==$_POST['grpodlv_dept_detail']['id_grpodlv_dept_h_detail'][$i]) {
					$check[$i] = $this->l_form_validation->set_rules($_POST['grpodlv_dept_detail']['gr_quantity'][$i], "grpodlv_dept_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['grpodlv_dept_detail']['LFIMG']);

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
           	$object['grpodlv_dept_header']['plant'] = $this->session->userdata['ADMIN']['plant'];
           	$object['grpodlv_dept_header']['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
            $object['grpodlv_dept_header']['item_group_code'] = $item_group_code;
			$object['grpodlv_dept_header']['VBELN'] = $do_no;
       		$object['grpodlv_dept_header']['delivery_date'] = $delivery_date;

			if ((!empty($item_group_code)) || (trim($item_group_code)!="")) {
        		if($item_group_code == 'all') {
        			$object['item_group']['item_group_code'] = $item_group_code;
        			$object['item_group']['item_group_name'] = '<strong>All</strong>';
                    $object['grpodlv_dept_details'] = $this->m_grpodlv_dept->sap_grpodlv_dept_details_select_by_do_no($do_no);
        		} else {
        			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
        			$object['item_group']['item_group_name'] = $item_group_code;
        			$object['grpodlv_dept_details'] = $this->m_grpodlv_dept->sap_grpodlv_dept_details_select_by_do_and_item_group($do_no, $object['item_group']['DISPO']);
        		}
            }
    	}

		if(($object['grpodlv_dept_details'] !== FALSE)&&(!empty($object['grpodlv_dept_details']))) {
			$i = 1;
			foreach ($object['grpodlv_dept_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['grpodlv_dept_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}
		if(count($_POST) == 0) {
    		$object['data']['grpodlv_dept_details'] = $this->m_grpodlv_dept->grpodlv_dept_details_select($object['data']['id_grpodlv_dept_header']);

    		if($object['data']['grpodlv_dept_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['grpodlv_dept_details']->result_array() as $object['temp']) {
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['grpodlv_dept_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }


		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Transfer In Inter Departement<div style="font-weight:normal;font-size:80%;font-style:italic;"></div>';
		$this->template->write_view('content', 'grpodlv_dept/grpodlv_dept_edit', $object);
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
		$grpodlv_dept = $_POST;
		unset($grpodlv_dept['button']);

		$count_filled = count($grpodlv_dept['grpodlv_dept_detail']['gr_quantity']);

		$count = count($grpodlv_dept['grpodlv_dept_detail']['id_grpodlv_dept_h_detail']);

		// check, at least one product gr_quantity entered
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grpodlv_dept/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grpodlv_dept['grpodlv_dept_header']['posting_date'])==FALSE)) {
     	   redirect('grpodlv_dept/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

    		$this->session->set_userdata('gr_quantity', $grpodlv_dept['grpodlv_dept_detail']['gr_quantity']);
 			$grpodlv_dept_header['do_no'] = $grpodlv_dept['grpodlv_dept_header']['do_no'];
			$base= $grpodlv_dept['grpodlv_dept_header']['do_no'];
			$grpodlv_dept_header['delivery_date'] = $grpodlv_dept['grpodlv_dept_header']['delivery_date'];
			$grpodlv_dept_header['grpodlv_dept_no'] = '';
			
			$object['data']['grpodlv_dept_header'] = $this->m_grpodlv_dept->sap_grpodlv_dept_header_select_by_do_no($base);
			$data['to_plant'] = $object['data']['grpodlv_dept_header']['PLANT'];

			//$sap_grpodlv_dept_header = $this->m_grpodlv_dept->sap_grpodlv_dept_header_select_by_do_no($grpodlv_dept['grpodlv_dept_header']['do_no']);
			$grpodlv_dept_header['to_plant'] = $data['to_plant'];
    		$grpodlv_dept_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$grpodlv_dept_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
// 			$grpodlv_dept_header['posting_date'] = $this->m_general->posting_date_select_max($grpodlv_dept_header['plant']);
 			$grpodlv_dept_header['posting_date'] = $this->l_general->str_to_date($grpodlv_dept['grpodlv_dept_header']['posting_date']);
			$grpodlv_dept_header['id_grpodlv_dept_plant'] = $this->m_grpodlv_dept->id_grpodlv_dept_plant_new_select($grpodlv_dept_header['plant'],$grpodlv_dept_header['posting_date']);

			if(isset($_POST['button']['approve']))
				$grpodlv_dept_header['status'] = '2';
			else
				$grpodlv_dept_header['status'] = '1';

			$grpodlv_dept_header['item_group_code'] = $grpodlv_dept['grpodlv_dept_header']['item_group_code'];
			$grpodlv_dept_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];

             $web_trans_id = $this->l_general->_get_web_trans_id($grpodlv_dept_header['plant'],$grpodlv_dept_header['posting_date'],
                      $grpodlv_dept_header['id_grpodlv_dept_plant'],'02');
             //array utk parameter masukan pada saat approval
             if(isset($_POST['button']['approve'])) {
               $grpodlv_dept_to_approve = array (
                      'plant' => $grpodlv_dept_header['plant'],
                      'do_no' => $grpodlv_dept_header['do_no'],
                      'posting_date' => date('Ymd',strtotime($grpodlv_dept_header['posting_date'])),
                      'id_user_input' => $grpodlv_dept_header['id_user_input'],
                      'web_trans_id' => $web_trans_id,
                );
              }
              //

			if($id_grpodlv_dept_header = $this->m_grpodlv_dept->grpodlv_dept_header_insert($grpodlv_dept_header)) {

                $input_detail_success = FALSE;


				for($i = 1; $i <= $count; $i++) {

					if(!empty($grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i])) {
						$grpodlv_dept_detail = $this->m_grpodlv_dept->sap_grpodlv_dept_details_select_by_do_and_item($grpodlv_dept_header['do_no'],$grpodlv_dept['grpodlv_dept_detail']['item'][$i]);
                        //array utk parameter masukan pada saat save
						$grpodlv_dept_detail_to_save['id_grpodlv_dept_header'] = $id_grpodlv_dept_header;
						
		
						$batch['BaseEntry']= $id_grpodlv_dept_header;
						$grpodlv_dept_detail_to_save['id_grpodlv_dept_h_detail'] = $grpodlv_dept['grpodlv_dept_detail']['id_grpodlv_dept_h_detail'][$i];
						$batch['BaseLinNum'] = $grpodlv_dept['grpodlv_dept_detail']['id_grpodlv_dept_h_detail'][$i];
						$grpodlv_dept_detail_to_save['item'] = $grpodlv_dept['grpodlv_dept_detail']['item'][$i];
						$line=$grpodlv_dept['grpodlv_dept_detail']['item'][$i];
						$grpodlv_dept_detail_to_save['material_no'] = $grpodlv_dept_detail['MATNR'];
						$batch['ItemCode'] = $grpodlv_dept_detail['MATNR'];
						
		
						$batch['BatchNum']=  $grpodlv_dept['grpodlv_dept_detail']['material_docno_cancellation'][$i];
						$batch['BaseType'] = 69;
						$batch['Createdate'] = date('Ymd',strtotime($grpodlv_dept_header['posting_date']));
						$grpodlv_dept_detail_to_save['material_desc'] = $grpodlv_dept_detail['MAKTX'];
						//if (isset($_POST['button']['approve']))
						//{
						if ($grpodlv_dept_detail['LFIMG'] >= $grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i])
						{
							$grpodlv_dept_detail_to_save['outstanding_qty'] = $grpodlv_dept_detail['LFIMG'] - $grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i];
							//echo '1-'.$grpodlv_dept_detail_to_save['outstanding_qty'];
						}
						else
						{
							$grpodlv_dept_detail_to_save['outstanding_qty'] = $grpodlv_dept_detail['LFIMG'];
							//echo '2-'.$grpodlv_dept_detail_to_save['outstanding_qty'];
						}
						//}
						
						$grpodlv_dept_detail_to_save['gr_quantity'] = $grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i];
						$grpodlv_dept_detail_to_save['var'] = $grpodlv_dept_detail['LFIMG'] - $grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i];
						$grpodlv_dept_detail_to_save['val'] = $grpodlv_dept['grpodlv_dept_detail']['val'][$i];
						$val=$grpodlv_dept['grpodlv_dept_detail']['val'][$i];
						$batch['Quantity'] = $grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i];
						$grpodlv_dept_detail_to_save['uom'] = $grpodlv_dept_detail['VRKME'];
						$grpodlv_dept_detail_to_save['item_storage_location'] = $grpodlv_dept_detail['LGORT'];
						$grpodlv_dept_detail_to_save['ok'] = '1';
                        //array utk parameter masukan pada saat approval
                        $grpodlv_dept_to_approve['item'][$i] = $grpodlv_dept_detail_to_save['item'];
                        $grpodlv_dept_to_approve['material_no'][$i] = $grpodlv_dept_detail_to_save['material_no'];
                        $grpodlv_dept_to_approve['gr_quantity'][$i] = $grpodlv_dept_detail_to_save['gr_quantity'];
                        $grpodlv_dept_to_approve['item_storage_location'][$i] = $grpodlv_dept_detail['LGORT'];
                        $grpodlv_dept_to_approve['uom'][$i] = $grpodlv_dept_detail['VRKME'];
						//echo $grpodlv_dept_detail['VRKME'];
                        //
						mysql_connect("localhost","root","");
						mysql_select_db("sap_php");
						$Whs=$grpodlv_dept_header['plant'];
						
						
						$c=mssql_connect("192.168.0.20","sa","abc123?");
						$b=mssql_select_db('Test_MSI_TRIAL',$c);
						$line=$i-1;
						$tem=mssql_query("SELECT U_grqty_web FROM WTR1 where DocEntry = '$base' AND LineNum ='$line'");
						$rem=mssql_fetch_array($tem);
						$gr_qty1=$rem['U_grqty_web'];
						$realoutstanding = $grpodlv_dept_detail_to_save['outstanding_qty'];
						
						$outstanding =$grpodlv_dept_detail['LFIMG']-$grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i];
						$gr_qty = $gr_qty1 + $grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i];
						//echo '-'.$outstanding.'-';
						unset($grpodlv_dept_detail);
						
						//echo "$batch[BaseEntry],$batch[BaseLinNum],$batch[ItemCode],$batch[BatchNum],$batch[Createdate],$batch[Quantity] <br>";
						if($this->m_grpodlv_dept->grpodlv_dept_detail_insert($grpodlv_dept_detail_to_save) && $this->m_grpodlv_dept->batch_insert($batch) )
                          $input_detail_success = TRUE;
						   
						  if ($input_detail_success === TRUE) 
						  {
						  	
							 if(isset($_POST['button']['approve']))
							{
							 if ($outstanding == 0)
							 { 
							 mssql_query("UPDATE OWTR SET U_Stat = 1 WHERE DOcEntry = '$base' ");
							 }
							 mssql_query("UPDATE WTR1 SET U_grqty_web = '$gr_qty'  WHERE DocEntry = '$base' ");
							 
							 if ($val != 0)
							 {
							 	mssql_query("UPDATE WTR1 SET U_close = 1  WHERE DocEntry = '$base' AND LineNum='$line' ");
								
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
			 //   $approved_data = $this->m_grpodlv_dept->sap_grpodlv_dept_header_approve($grpodlv_dept_to_approve);
       		//	if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grpodlv_dept_no ='';// $approved_data['material_document'];
    				$data = array (
    					'id_grpodlv_dept_header'	=>$id_grpodlv_dept_header,
    					'grpodlv_dept_no'	=>	$grpodlv_dept_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$this->m_grpodlv_dept->grpodlv_dept_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
         //   }

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
			  	
   			    $this->l_general->success_page('Data Transfer In Inter Departement berhasil dimasukkan', site_url('grpodlv_dept/input'));
              } else {
                $this->m_grpodlv_dept->grpodlv_dept_header_delete($id_grpodlv_dept_header);
 			    $this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer In Inter Departement tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success === TRUE) {
  			     $this->l_general->success_page('Data Transfer In Inter Departement berhasil diapprove', site_url('grpodlv_dept/input'));
              } else {
                $this->m_grpodlv_dept->grpodlv_dept_header_delete($id_grpodlv_dept_header);
				$this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer In Inter Departement tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }
		}

        }
	}

	/*function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transfer In Inter Departement tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('grpodlv_dept/input2');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transfer In Inter Departement berhasil diapprove';
		$object['refresh_url'] = site_url('grpodlv_dept/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transfer In Inter Departement berhasil dimasukkan';
		$object['refresh_url'] = site_url('grpodlv_dept/input');
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
	    $grpodlv_dept_header = $this->m_grpodlv_dept->grpodlv_dept_header_select($this->uri->segment(3));
		$status = $grpodlv_dept_header['status'];
        unset($grpodlv_dept_header);

        $gr_quantity = array('gr_quantity' => '');
        $this->session->unset_userdata($gr_quantity);

    	$validation = FALSE;

        if ($status !== '2') {
    		if(count($_POST) != 0) {

    			// first post, assume all data TRUE
    			$validation_temp = TRUE;

    			$object['grpodlv_dept_details'] = $this->m_grpodlv_dept->sap_grpodlv_dept_details_select_by_do_no($_POST['grpodlv_dept_header']['do_no']);
                $count = count($_POST['grpodlv_dept_detail']['item']);
                for($i=1;$i<=$count;$i++) {
                    $qty_to_check = 0;
					$id=$_POST['grpodlv_dept_header']['do_no'];
					$id_d=$_POST['grpodlv_dept_detail']['item'][$i];
					 mysql_connect("localhost","root","");
		mysql_select_db('sap_php');
		$to="SELECT (t_grpodlv_dept_detail.outstanding_qty + t_grpodlv_dept_detail.gr_quantity) as QTY FROM t_grpodlv_dept_detail JOIN t_grpodlv_dept_header ON t_grpodlv_dept_header.id_grpodlv_dept_header = t_grpodlv_dept_detail.id_grpodlv_dept_header
			WHERE t_grpodlv_dept_header.do_no='$id' AND t_grpodlv_dept_detail.item='$id_d'";
		$t=mysql_query($to);
		$rw=mysql_fetch_row($t);
		//echo $to;
        		/*	foreach ($object['grpodlv_dept_details'] as $object['grpodlv_dept_detail']) {
                        if ($_POST['grpodlv_dept_detail']['item'][$i]==$object['grpodlv_dept_detail']['id_grpodlv_dept_h_detail']) {
                          $qty_to_check = $object['grpodlv_dept_detail']['outstanding_qty'];
                          break;
                        }
        			}
                	$check[$i] = $this->l_form_validation->set_rules($_POST['grpodlv_dept_detail']['gr_quantity'][$i], "grpodlv_dept_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$rw[0]);
					if ($_POST['grpodlv_dept_detail']['gr_quantity'][$i] < 1)
					{
						$validation_temp = FALSE;
					}
                	// if one data FALSE, set $validation_temp to FALSE
                	if($check[$i]['error'] == TRUE)
                		$validation_temp = FALSE;*/
                }
                /*
    			$i = 1;
    			foreach ($object['grpodlv_dept_details'] as $object['grpodlv_dept_detail']) {

                    if ($i==$_POST['grpodlv_dept_detail']['id_grpodlv_dept_h_detail'][$i]) {
    					$check[$i] = $this->l_form_validation->set_rules($_POST['grpodlv_dept_detail']['gr_quantity'][$i], "grpodlv_dept_detail[gr_quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['grpodlv_dept_detail']['LFIMG']);

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
				$grpodlv_dept_header = $this->m_grpodlv_dept->grpodlv_dept_header_select($this->uri->segment(3));

				if($grpodlv_dept_header['status'] == '2') {
					$this->_cancel_update($data);
				} else {
					$this->_edit_form(0, $data, $check);
				}
			} else {
				$data['grpodlv_dept_header'] = $this->m_grpodlv_dept->grpodlv_dept_header_select($this->uri->segment(3));
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

		$object['data']['grpodlv_dept_header']['status_string'] = ($object['data']['grpodlv_dept_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		$do_no = $data['grpodlv_dept_header']['do_no'];

		if(count($_POST) == 0) {
    		$item_group_code = $data['grpodlv_dept_header']['item_group_code'];
        } else {
    		$item_group_code = $data['item_group']['item_group_code'];
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

		$object['grpodlv_dept_header']['VBELN'] = $do_no;
		$object['grpodlv_dept_header']['delivery_date'] = $data['grpodlv_dept_header']['delivery_date'];

    		if($item_group_code == 'all') {
    			$object['item_group']['item_group_code'] = $item_group_code;
    			$object['item_group']['item_group_name'] = '<strong>All</strong>';
    			$object['grpodlv_dept_details'] = $this->m_grpodlv_dept->sap_grpodlv_dept_details_select_by_do_no($do_no);
    		} else {
    			$object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
    			$object['item_group']['item_group_name'] = $item_group_code;
    			$object['grpodlv_dept_details'] = $this->m_grpodlv_dept->sap_grpodlv_dept_details_select_by_do_and_item_group($do_no, $object['item_group']['DISPO']);
    		}

		if(($object['grpodlv_dept_details'] !== FALSE)&&(!empty($object['grpodlv_dept_details']))) {
			$i = 1;
			foreach ($object['grpodlv_dept_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['grpodlv_dept_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}

		if(count($_POST) == 0) {
    	    $object['data']['grpodlv_dept_details'] = $this->m_grpodlv_dept->grpodlv_dept_details_select($object['data']['grpodlv_dept_header']['id_grpodlv_dept_header']);

    		if($object['data']['grpodlv_dept_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['grpodlv_dept_details']->result_array() as $object['temp']) {
    //				$object['data']['grpodlv_dept_detail'][$i] = $object['temp'];
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['grpodlv_dept_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }

   	    // save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Transfer In Inter Departement<div style="font-weight:normal;font-size:80%;font-style:italic;"></div>';
		$this->template->write_view('content', 'grpodlv_dept/grpodlv_dept_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$grpodlv_dept = $_POST;
		unset($grpodlv_dept['button']);
		// end of assign variables and delete not used variables

		$count_filled = count($grpodlv_dept['grpodlv_dept_detail']['gr_quantity']);

		$count = count($grpodlv_dept['grpodlv_dept_detail']['id_grpodlv_dept_h_detail']);

		// variable to check, is at least one product gr_quantity entered?
		$gr_quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i])) {
				continue;
			} else {
				$gr_quantity_exist = TRUE;
				break;
			}
		}

		if($gr_quantity_exist == FALSE)
			redirect('grpodlv_dept/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

        if(isset($_POST['button']['approve'])&&($this->m_general->check_is_can_approve($grpodlv_dept['grpodlv_dept_header']['posting_date'])==FALSE)) {
     	   redirect('grpodlv_dept/input_error/Selama jam 02.00 AM sampai jam 06.00 AM data tidak dapat di approve karena sedang ada proses data POS');
        } else {

		$edit_grpodlv_dept_details = $this->m_grpodlv_dept->grpodlv_dept_details_select($grpodlv_dept['grpodlv_dept_header']['id_grpodlv_dept_header']);
    	$i = 1;
   		if(!empty($edit_grpodlv_dept_details)) {
    	    foreach ($edit_grpodlv_dept_details->result_array() as $value) {
    		    $edit_grpodlv_dept_detail[$i] = $value;
    		    $i++;
            }
        }
        unset($edit_grpodlv_dept_details);

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('gr_quantity', $grpodlv_dept['grpodlv_dept_detail']['gr_quantity']);

            $postingdate = $grpodlv_dept['grpodlv_dept_header']['posting_date'];
			$year = $this->l_general->rightstr($postingdate, 4);
			$month = substr($postingdate, 3, 2);
			$day = $this->l_general->leftstr($postingdate, 2);
			$base=$grpodlv_dept['grpodlv_dept_header']['do_no'];
            $postingdate = $year."-".$month."-".$day.' 00:00:00';
			$id_grpodlv_dept_plant = $this->m_grpodlv_dept->id_grpodlv_dept_plant_new_select("",$postingdate,$grpodlv_dept['grpodlv_dept_header']['id_grpodlv_dept_header']);
            unset($year);
            unset($month);
            unset($day);
    			$data = array (
    				'id_grpodlv_dept_header' =>	$grpodlv_dept['grpodlv_dept_header']['id_grpodlv_dept_header'],
                    'id_grpodlv_dept_plant' => $id_grpodlv_dept_plant,
    				'posting_date' => $postingdate,
    			);
                $this->m_grpodlv_dept->grpodlv_dept_header_update($data);

                $edit_grpodlv_dept_header = $this->m_grpodlv_dept->grpodlv_dept_header_select($grpodlv_dept['grpodlv_dept_header']['id_grpodlv_dept_header']);

    			if ($this->m_grpodlv_dept->grpodlv_dept_header_update($data)) {
            		for($i = 1; $i <= $count; $i++) {
            			if(!empty($grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i])) {
        	    			$grpodlv_dept_detail = array (
        						'id_grpodlv_dept_detail'=>$grpodlv_dept['grpodlv_dept_detail']['id_grpodlv_dept_detail'][$i],
        						'gr_quantity'=>$grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i],
								'val' => $grpodlv_dept['grpodlv_dept_detail']['val'][$i],
								'var' => $grpodlv_dept['grpodlv_dept_detail']['var'][$i]
        					);
							$batch = array (
								'BaseEntry'=>$grpodlv_dept['grpodlv_dept_header']['do_no'],
								'ItemCode'=>$grpodlv_dept['grpodlv_dept_detail']['material_no'][$i],
								'BatchNum'=>$grpodlv_dept['grpodlv_dept_detail']['material_docno_cancellation'][$i],
        						'BaseLinNum'=>$grpodlv_dept['grpodlv_dept_detail']['id_grpodlv_dept_h_detail'][$i],
        						'Quantity'=>$grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i]
        					);
							$val=$grpodlv_dept['grpodlv_dept_detail']['val'][$i];
						//	$t="$batch[BaseEntry]-$batch[ItemCode]-$batch[BatchNum]-($batch[BaseLinNum])-$batch[Quantity]";
							//echo $t;
        		    		if($this->m_grpodlv_dept->grpodlv_dept_detail_update($grpodlv_dept_detail) && $this->m_grpodlv_dept->batch_update($batch)) {
                                $input_detail_success = TRUE;
        			    	} else {
                                $input_detail_success = FALSE;
        			    	}
            			} else {
                          $this->m_grpodlv_dept->grpodlv_dept_detail_delete($grpodlv_dept['grpodlv_dept_detail']['id_grpodlv_dept_detail'][$i]);
            			}
						
							
						$c=mssql_connect("192.168.0.20","sa","abc123?");
						$b=mssql_select_db('Test_MSI_TRIAL',$c);
						$line=$i-1;
						$tem=mssql_query("SELECT U_grqty_web FROM WTR1 where DocEntry = '$base' AND LineNum ='$line'");
						$rem=mssql_fetch_array($tem);
						$gr_qty1=$rem['U_grqty_web'];
						$realoutstanding =$grpodlv_dept['grpodlv_dept_detail']['outstanding_qty'][$i];
						
						$outstanding =$grpodlv_dept_detail['LFIMG']-$grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i];
						$gr_qty = $gr_qty1 + $grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i];
						
						if ($input_detail_success === TRUE) 
						  {
						  	
							 if(isset($_POST['button']['approve']))
							{
							 if ($realoutstanding == 0)
							 { 
							 mssql_query("UPDATE OWTR SET U_Stat = 1 WHERE DOcEntry = '$base' AND LineNum='$line'");
							 }
							 mssql_query("UPDATE WTR1 SET U_grqty_web = '$gr_qty'  WHERE DocEntry = '$base' AND LineNum='$line' ");
							 if ($val != 0)
							 {
							 	mssql_query("UPDATE WTR1 SET U_close = 1  WHERE DocEntry = '$base' AND LineNum='$line' ");
								
							 }
							 }
							
						  }

        	    	}
                }

  			$this->db->trans_complete();

			if (($input_detail_success == TRUE) && (isset($_POST['button']['approve']))) {
                $grpodlv_dept_to_approve['posting_date'] = date('Ymd',strtotime($edit_grpodlv_dept_header['posting_date']));
                $grpodlv_dept_to_approve['plant'] = $edit_grpodlv_dept_header['plant'];
                $grpodlv_dept_to_approve['id_grpodlv_dept_plant'] = $edit_grpodlv_dept_header['id_grpodlv_dept_plant'];
                $grpodlv_dept_to_approve['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
                $grpodlv_dept_to_approve['do_no'] = $edit_grpodlv_dept_header['do_no'];
                $grpodlv_dept_to_approve['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grpodlv_dept_header['plant'],$edit_grpodlv_dept_header['posting_date'],
                      $edit_grpodlv_dept_header['id_grpodlv_dept_plant'],'02');
        		for($i = 1; $i <= $count; $i++) {
        		   $grpodlv_dept_to_approve['item'][$i] = $edit_grpodlv_dept_detail[$i]['item'];
        		   $grpodlv_dept_to_approve['material_no'][$i] = $edit_grpodlv_dept_detail[$i]['material_no'];
                   $grpodlv_dept_to_approve['gr_quantity'][$i] = $grpodlv_dept['grpodlv_dept_detail']['gr_quantity'][$i];
        		   $grpodlv_dept_to_approve['uom'][$i] = $edit_grpodlv_dept_detail[$i]['uom'];
        		   $grpodlv_dept_to_approve['item_storage_location'][$i] = $edit_grpodlv_dept_detail[$i]['item_storage_location'];
                }
			 //   $approved_data = $this->m_grpodlv_dept->sap_grpodlv_dept_header_approve($grpodlv_dept_to_approve);
       		//	if((!empty($approved_data['material_document'])) && (trim($approved_data['material_document']) !== '')) {
    			    $grpodlv_dept_no = '';// $approved_data['material_document'];
    				$data = array (
    					'id_grpodlv_dept_header' =>$grpodlv_dept['grpodlv_dept_header']['id_grpodlv_dept_header'],
    					'grpodlv_dept_no'	=>	$grpodlv_dept_no,
    					'status'	=>	'2',
    					'id_user_approved'	=>	$this->session->userdata['ADMIN']['admin_id'],
    				);
    				$grpodlv_dept_header_update_status = $this->m_grpodlv_dept->grpodlv_dept_header_update($data);
  				    $approve_data_success = TRUE;
				} else {
				  $approve_data_success = FALSE;
				}
           // }
            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
			  $this->l_general->success_page('Data Transfer In Inter Departement berhasil diubah', site_url('grpodlv_dept/browse'));
              } else {
			  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer In Inter Departement tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
 			   }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
			  $this->l_general->success_page('Data Transfer In Inter Departement berhasil diapprove', site_url('grpodlv_dept/browse'));
              } else {
			  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer In Inter Departement tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

        }
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'grpodlv_dept/browse';
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
		$grpodlv_dept = $_POST;
		unset($grpodlv_dept['button']);
		// end of assign variables and delete not used variables

		// variable to check, is at least one product cancellation entered?

        $date_today = date('d-m-Y');
		if($grpodlv_dept['grpodlv_dept_header']['posting_date']!=$date_today) {
			redirect('grpodlv_dept/edit_error/Anda tidak bisa membatalkan transaksi yang tanggalnya lebih kecil dari hari ini '.$date_today);
        }

    	if(empty($grpodlv_dept['cancel'])) {
            $gr_quantity_exist = FALSE;
    	} else {
    		$gr_quantity_exist = TRUE;
    	}

		if($gr_quantity_exist == FALSE)
			redirect('grpodlv_dept/edit_error/Anda belum memilih item yang akan di-cancel. Mohon ulangi');


//		if($this->m_config->running_number_select_update('grpodlv_dept', 1, date("Y-m-d")) {

        $edit_grpodlv_dept_header = $this->m_grpodlv_dept->grpodlv_dept_header_select($grpodlv_dept['grpodlv_dept_header']['id_grpodlv_dept_header']);
		$edit_grpodlv_dept_details = $this->m_grpodlv_dept->grpodlv_dept_details_select($grpodlv_dept['grpodlv_dept_header']['id_grpodlv_dept_header']);
    	$i = 1;
	    foreach ($edit_grpodlv_dept_details->result_array() as $value) {
		    $edit_grpodlv_dept_detail[$i] = $value;
		    $i++;
        }
        unset($edit_grpodlv_dept_details);

		if(isset($_POST['button']['cancel'])) {

//			$grpodlv_dept_header['id_grpodlv_dept_header'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();
//            echo "<pre>";
//            print_r($grpodlv_dept['cancel']);
//            echo "</pre>";
//            exit;
            $grpodlv_dept_to_cancel['grpodlv_dept_no'] = $edit_grpodlv_dept_header['grpodlv_dept_no'];
            $grpodlv_dept_to_cancel['mat_doc_year'] = date('Y',strtotime($edit_grpodlv_dept_header['posting_date']));
            $grpodlv_dept_to_cancel['posting_date'] = date('Ymd',strtotime($edit_grpodlv_dept_header['posting_date']));
            $grpodlv_dept_to_cancel['plant'] = $edit_grpodlv_dept_header['plant'];
			$grpodlv_dept_to_cancel['id_grpodlv_dept_plant'] = $this->m_grpodlv_dept->id_grpodlv_dept_plant_new_select($grpodlv_dept_to_cancel['plant'],date('Y-m-d',strtotime($edit_grpodlv_dept_header['posting_date'])));
            $grpodlv_dept_to_cancel['web_trans_id'] = $this->l_general->_get_web_trans_id($edit_grpodlv_dept_header['plant'],$edit_grpodlv_dept_header['posting_date'],
                      $grpodlv_dept_to_cancel['id_grpodlv_dept_plant'],'02');
            $grpodlv_dept_to_cancel['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
            $count = count($edit_grpodlv_dept_detail);
    		for($i = 1; $i <= $count; $i++) {
      		   if(!empty($grpodlv_dept['cancel'][$i]))
       		     $grpodlv_dept_to_cancel['item'][$i] = $i;
            }
            $cancelled_data = $this->m_grpodlv_dept->sap_grpodlv_dept_header_cancel($grpodlv_dept_to_cancel);
 			$cancel_data_success = FALSE;
   			if((!empty($cancelled_data['material_document'])) && (trim($cancelled_data['material_document']) !== '')) {
			    $mat_doc_cancellation = $cancelled_data['material_document'];
        		for($i = 1; $i <= $count; $i++) {
        			if(!empty($grpodlv_dept['cancel'][$i])) {
    	    			$grpodlv_dept_header = array (
    						'id_grpodlv_dept_header'=>$grpodlv_dept['grpodlv_dept_header']['id_grpodlv_dept_header'],
    						'id_grpodlv_dept_plant'=>$grpodlv_dept_to_cancel['id_grpodlv_dept_plant'],
    					);
    		    		if($this->m_grpodlv_dept->grpodlv_dept_header_update($grpodlv_dept_header)==TRUE) {
        	    			$grpodlv_dept_detail = array (
        						'id_grpodlv_dept_detail'=>$edit_grpodlv_dept_detail[$i]['id_grpodlv_dept_detail'],
        						'ok_cancel'=>1,
        						'material_docno_cancellation'=>$mat_doc_cancellation,
        						'id_user_cancel'=>$this->session->userdata['ADMIN']['admin_id']
        					);
        		    		if($this->m_grpodlv_dept->grpodlv_dept_detail_update($grpodlv_dept_detail)==TRUE) {
            				    $cancel_data_success = TRUE;
        			    	}
                        }
                      }
        			}
            }


      	    $this->db->trans_complete();

            if($cancel_data_success == TRUE) {
			     $this->l_general->success_page('Data Transfer In Inter Departement berhasil dibatalkan', site_url('grpodlv_dept/browse'));
            } else {
				$this->jagmodule['error_code'] = '007'; 
		$this->l_general->error_page($this->jagmodule, 'Data Transfer In Inter Departement tidak  berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$cancelled_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

/*			if($this->m_grpodlv_dept->grpodlv_dept_details_delete($grpodlv_dept['id_grpodlv_dept_header'])) {

				if(isset($_POST['button']['approve'])) {
					if($grpodlv_dept_header = $this->m_grpodlv_dept->grpodlv_dept_header_select($grpodlv_dept['id_grpodlv_dept_header'])) {
						if($grpodlv_dept_no = $this->m_grpodlv_dept->sap_grpodlv_dept_header_approve($grpodlv_dept_header)) {
							$data = array (
								'id_grpodlv_dept_header'	=>	$grpodlv_dept['id_grpodlv_dept_header'],
								'grpodlv_dept_no'	=>	$grpodlv_dept_no,
							);

							$grpodlv_dept_header_update_status = $this->m_grpodlv_dept->grpodlv_dept_header_update($data);
						}
					}
				}

				for($i = 1; $i <= $count; $i++) {

					if(!empty($grpodlv_dept['gr_quantity'][$i])) {
						$grpodlv_dept_detail = $this->m_grpodlv_dept->sap_grpodlv_dept_detail_select_by_id_grpodlv_dept_h_detail($grpodlv_dept['id_grpodlv_dept_h_detail'][$i]);
						unset($grpodlv_dept_detail['id_grpodlv_dept_header']);
						unset($grpodlv_dept_detail['do_no']);
						unset($grpodlv_dept_detail['plant']);
						unset($grpodlv_dept_detail['storage_location']);

						$grpodlv_dept_detail['id_grpodlv_dept_header'] = $grpodlv_dept['id_grpodlv_dept_header'];
						$grpodlv_dept_detail['gr_quantity'] = $grpodlv_dept['gr_quantity'][$i];

						if($this->m_grpodlv_dept->grpodlv_dept_detail_insert($grpodlv_dept_detail)) {
							if(isset($_POST['button']['approve']))
								$id_grpodlv_dept_detail2 = $this->m_grpodlv_dept->sap_grpodlv_dept_detail_approve($grpodlv_dept_detail);
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
		$object['refresh_text'] = 'Data Transfer In Inter Departement tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_grpodlv_dept_header) {
	$grpodlv_dept_delete['user'] = $this->session->userdata['ADMIN']['admin_id'];
	 $grpodlv_dept_delete['module'] = "Transfer In Inter Department";
	$grpodlv_dept_delete['plant'] = $this->session->userdata['ADMIN']['plant'];
	 $grpodlv_dept_delete['id_delete'] = $id_grpodlv_dept_header;

		// check approve status
		$grpodlv_dept_header = $this->m_grpodlv_dept->grpodlv_dept_header_select($id_grpodlv_dept_header);

		if($grpodlv_dept_header['status'] == '1') {
			$this->m_grpodlv_dept->grpodlv_dept_header_delete($id_grpodlv_dept_header);
			$this->m_grpodlv_dept->user_delete($grpodlv_dept_delete);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function delete($id_grpodlv_dept_header) {

		if($this->_delete($id_grpodlv_dept_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer In Inter Departement berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpodlv_dept_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer In Inter Departement gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpodlv_dept_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '008';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_grpodlv_dept_header']))
			redirect($this->session->userdata['PAGE']['grpodlv_dept_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_grpodlv_dept_header'][$i])) {
				$object['data']['grpodlv_dept_headers'][$j++] = $this->m_grpodlv_dept->grpodlv_dept_header_select($_POST['id_grpodlv_dept_header'][$i]);
			}
		}

        if (isset($_POST['button']['savetoexcel']))
  		  $this->template->write_view('content', 'grpodlv_dept/grpodlv_dept_export_confirm', $object);
        else
    	  $this->template->write_view('content', 'grpodlv_dept/grpodlv_dept_delete_multiple_confirm', $object);

		$this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_grpodlv_dept_header'][$i]);
		}

		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Transfer In Inter Departement berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['grpodlv_dept_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

 function file_import() {

	$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'grpodlv_dept_data';
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
            $file =  $_SERVER['DOCUMENT_ROOT'].'/sap_php2/excel_upload/'.$upload['file_name'];
            else
            $file =  $_SERVER['DOCUMENT_ROOT'].'/excel_upload/'.$upload['file_name'];

			$this->session->set_userdata('file_upload', $file);
			$this->session->set_userdata('file_name_upload', $upload['file_name']);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

			// is it grpodlv_dept template file?
			if($excel['cells'][1][1] == 'Goods Receipt No.' && $excel['cells'][1][3] == 'Material No.') {

				$j = 0; // grpodlv_dept_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpodlv_dept header?

					$do_no = $excel['cells'][$i][2];
					$item_group_code = 'all';
					$material_no = $excel['cells'][$i][3];
					$gr_quantity = $excel['cells'][$i][4];

					// check grpodlv_dept header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

            $j++;
						if($grpodlv_dept_header_temp = $this->m_grpodlv_dept->sap_grpodlv_dept_header_select_by_do_no($do_no)) {
							$object['grpodlv_dept_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
                            $object['grpodlv_dept_headers'][$j]['grpodlv_dept_no'] = $excel['cells'][$i][1];
							$object['grpodlv_dept_headers'][$j]['do_no'] = $do_no;


							$object['grpodlv_dept_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['grpodlv_dept_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['grpodlv_dept_headers'][$j]['status'] = '1';
							$object['grpodlv_dept_headers'][$j]['item_group_code'] = $item_group_code;
							$object['grpodlv_dept_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['grpodlv_dept_headers'][$j]['file_name'] = $upload['file_name'];

            	$grpodlv_dept_header_exist = TRUE;
							$k = 1; // grpodlv_dept_detail number
						} else {
            	$grpodlv_dept_header_exist = FALSE;
						}
					}

					if($grpodlv_dept_header_exist) {

   						if($grpodlv_dept_detail_temp = $this->m_grpodlv_dept->sap_grpodlv_dept_details_select_by_do_and_item_code($do_no,$material_no)) {
							$object['grpodlv_dept_details'][$j][$k]['id_grpodlv_dept_h_detail'] = $k;
							$object['grpodlv_dept_details'][$j][$k]['item'] = $grpodlv_dept_detail_temp['POSNR'];
							$object['grpodlv_dept_details'][$j][$k]['material_no'] = $material_no;
							$object['grpodlv_dept_details'][$j][$k]['material_desc'] = $grpodlv_dept_detail_temp['MAKTX'];
							$object['grpodlv_dept_details'][$j][$k]['outstanding_qty'] = $grpodlv_dept_detail_temp['LFIMG'];
							$object['grpodlv_dept_details'][$j][$k]['gr_quantity'] = $gr_quantity;
							$object['grpodlv_dept_details'][$j][$k]['uom'] = $grpodlv_dept_detail_temp['VRKME'];
							$k++;
						}

					}

				}

//				print_r($excel);
//				print_r($object);

				$this->template->write_view('content', 'grpodlv_dept/grpodlv_dept_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Transfer In Inter Departement atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grpodlv_dept/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '009';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

			}

		}

	}

   	function file_export() {
        $data = $this->m_grpodlv_dept->grpodlv_dept_select_to_export($_POST['id_grpodlv_dept_header']);
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

		// is it grpodlv_dept template file?
		if($excel['cells'][1][1] == 'Goods Receipt No.' && $excel['cells'][1][3] == 'Material No.') {

			$this->db->trans_start();

			$j = 0; // grpodlv_dept_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grpodlv_dept header?

				$do_no = $excel['cells'][$i][2];
				$item_group_code = 'all';
				$material_no = $excel['cells'][$i][3];
				$gr_quantity = $excel['cells'][$i][4];

				// check grpodlv_dept header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

           $j++;
					if($grpodlv_dept_header_temp = $this->m_grpodlv_dept->sap_grpodlv_dept_header_select_by_do_no($do_no)) {

						$object['grpodlv_dept_headers'][$j]['posting_date'] = date("Y-m-d H:i:s");
						$object['grpodlv_dept_headers'][$j]['do_no'] = $do_no;
						$object['grpodlv_dept_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
            			$object['grpodlv_dept_headers'][$j]['id_grpodlv_dept_plant'] = $this->m_grpodlv_dept->id_grpodlv_dept_plant_new_select($object['grpodlv_dept_headers'][$j]['plant'],$object['grpodlv_dept_headers'][$j]['posting_date']);
						$object['grpodlv_dept_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
						$object['grpodlv_dept_headers'][$j]['status'] = '1';
						$object['grpodlv_dept_headers'][$j]['item_group_code'] = $item_group_code;
						$object['grpodlv_dept_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
						$object['grpodlv_dept_headers'][$j]['filename'] = $upload['file_name'];

						$id_grpodlv_dept_header = $this->m_grpodlv_dept->grpodlv_dept_header_insert($object['grpodlv_dept_headers'][$j]);

           	$grpodlv_dept_header_exist = TRUE;
						$k = 1; // grpodlv_dept_detail number

					} else {
           	$grpodlv_dept_header_exist = FALSE;
					}
				}

				if($grpodlv_dept_header_exist) {

					if($grpodlv_dept_detail_temp = $this->m_grpodlv_dept->sap_grpodlv_dept_details_select_by_do_and_item_code($do_no,$material_no)) {
						$object['grpodlv_dept_details'][$j][$k]['id_grpodlv_dept_header'] = $id_grpodlv_dept_header;
						$object['grpodlv_dept_details'][$j][$k]['id_grpodlv_dept_h_detail'] = $k;
						$object['grpodlv_dept_details'][$j][$k]['item'] = $grpodlv_dept_detail_temp['POSNR'];
						$object['grpodlv_dept_details'][$j][$k]['material_no'] = $material_no;
						$object['grpodlv_dept_details'][$j][$k]['material_desc'] = $grpodlv_dept_detail_temp['MAKTX'];
						$object['grpodlv_dept_details'][$j][$k]['outstanding_qty'] = $grpodlv_dept_detail_temp['LFIMG'];
						$object['grpodlv_dept_details'][$j][$k]['gr_quantity'] = $gr_quantity;
						$object['grpodlv_dept_details'][$j][$k]['uom'] = $grpodlv_dept_detail_temp['UNIT'];

						$id_grpodlv_dept_detail = $this->m_grpodlv_dept->grpodlv_dept_detail_insert($object['grpodlv_dept_details'][$j][$k]);

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Transfer In Inter Departement berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['grpodlv_dept_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Transfer In Inter Departement atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'grpodlv_dept/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '010';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}
	
	public function printpdf($id_grpodlv_dept_header)
	{
		$this->load->model('m_printgrpodlv_dept');
		//$this->load->model('m_pr');
		//$pr_header = $this->m_pr->pr_header_select($id_pr_header);
		$data['data'] = $this->m_printgrpodlv_dept->tampil($id_grpodlv_dept_header);
		
		ob_start();
		$content = $this->load->view('grpodlv_dept_test',$data);
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