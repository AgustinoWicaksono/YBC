<?php

class SwbEncryption {
	var $skey 	= "JCO77IT"; // you can change it
 
    public  function safe_b64encode($string) {
 
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
 
	public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
 
    public  function encode($value){ 
 
	    if(!$value){return false;}
        $text = $value;
        return trim($this->safe_b64encode($text)); 
    }
 
    public function decode($value){
 
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        return trim($crypttext);
    }
}

class stockoutlet extends Controller {
	private $jagmodule = array();


	function stockoutlet() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1049);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('trans_stockoutlet'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->model('m_stockoutlet');
		$this->load->model('m_general');
		$this->load->model('m_sfgs');
		$this->load->model('m_opnd');

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
		$stockoutlet_browse_result = $this->session->userdata['PAGE']['stockoutlet_browse_result'];

		if(!empty($stockoutlet_browse_result))
			redirect($this->session->userdata['PAGE']['stockoutlet_browse_result']);
		else
			redirect('stockoutlet/browse_result/0/0/0/0/0/0/0/10');

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

//		redirect('stockoutlet/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/".$_POST['sort1']."/".$_POST['sort2']."/".$_POST['sort3']."/".$limit);
		redirect('stockoutlet/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/".$date_from."/".$date_to."/".$_POST['status']."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $date_from = '', $date_to = '', $status = 0, $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('stockoutlet_browse_result');

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
			'a'	=>	'Material Document No',
			
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

		$sort_link1 = 'stockoutlet/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/';
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
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 11;
		$config['base_url'] = site_url('stockoutlet/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$date_from.'/'.$date_to.'/'.$status.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_stockoutlet->stockoutlet_headers_count_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['stockoutlet_headers'] = $this->m_stockoutlet->stockoutlet_headers_select_by_criteria($field_name, $field_type, $field_content, $date_from2, $date_to2, $status, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Stock Opname ';
		$this->template->write_view('content', 'stockoutlet/stockoutlet_browse', $object);
		$this->template->render();

	}

	// input data
	function input() {

		// if $data exist, add to the $object array
		if ( count($_POST) != 0) {
//		if(!empty($_POST['kd_vendor'])) {
			$data = $_POST;
			$object['data'] = $data;

            $quantity = array('quantity' => '');
            $this->session->unset_userdata($quantity);
            $qty_gso = array('qty_gso' => '');
            $this->session->unset_userdata($qty_gso);
            $qty_gss = array('qty_gss' => '');
            $this->session->unset_userdata($qty_gss);

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

 		$object['item_group_code'][0] = '';
		$tglakhirposting = $this->m_general->posting_date_select_max();
		$tglposting=strtotime($tglakhirposting);
		if ((date('N',$tglposting)==7)||(date("Y-m-t",$tglposting)==date('Y-m-d',$tglposting))){
//	    if((date('D')=='Sun')||(date("Y-m-t")==date('Y-m-d'))) {
    		$data['item_groups'] = $this->m_general->sap_item_groups_select_all_stockoutlet();
    		if($data['item_groups'] !== FALSE) {
    			$object['item_group_code']['all'] = '==All==';
    			foreach ($data['item_groups'] as $item_group) {
    			   $object['item_group_code'][$item_group['DSNAM']] = $item_group['DSNAM'];
    			}
    		}
        } else
   		      $object['item_group_code']['Item Opname Daily'] = 'Item Opname Inventory';

		if(!empty($data['item_group_code'])) {
			redirect('stockoutlet/input2/'.$data['item_group_code']);
		}

		$object['page_title'] = 'Stock Opname';
		$this->template->write_view('content', 'stockoutlet/stockoutlet_input', $object);
		$this->template->render();

	}

	function input2()	{

		$validation = FALSE;

		if(count($_POST) != 0) {

			// first post, assume all data TRUE
			$validation_temp = TRUE;


/*			$object['stockoutlet_details'] = $this->m_stockoutlet->sap_stockoutlet_details_select_by_do_no($_POST['stockoutlet_header']['do_no']);

			$i = 1;
			foreach ($object['stockoutlet_details'] as $object['stockoutlet_detail']) {

					$check[$i] = $this->l_form_validation->set_rules($_POST['stockoutlet_detail']['quantity'][$i], "stockoutlet_detail[quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['stockoutlet_detail']['LFIMG']);

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$i]['error'] == TRUE)
						$validation_temp = FALSE;

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
	
	function input3($coba = 'ABC'){
	/*
		$hasil = $this->m_stockoutlet->sap_stockoutlet_item_select_all();
		$data_material_all = $this->m_stockoutlet->sap_stockoutlet_item_select_all();
		$allowed_material = Array();
		// print_r($data_material_all);
		
		foreach($data_material_all as $key=>$value){
			$allowed_material[$data_material_all[$key]['MATNR']]=1;
		}
				$forgetEmail = 'Ini coba saja supaya bisa + jadi [percobaan/coba-coba2] {benar(saja)khan!}'." ' nama ' ".' --- "bukan" #@$ ';
				$forgetEnc = new SwbEncryption();
				$forgetURL = $forgetEnc->encode($forgetEmail);
				unset($forgetEnc);
				echo $forgetURL;
				echo '<hr />';


		$forgetDec = new SwbEncryption();
		$forgetEmailRaw = @$forgetURL;
		$forgetEmail = $forgetDec->decode($forgetEmailRaw);
		
		echo $forgetEmail;
		unset($forgetDec);
				
		// print_r($allowed_material);
		*/
		
		//$coba = 'ABC';
//	    $this->jagmodule['error_code'] = '001A'; 
//		$this->l_general->error_page($this->jagmodule, 'coba saja', site_url($this->session->userdata['PAGE']['next']));


		$hasil = $this->m_stockoutlet->sap_stockoutlet_item_select_all();
		$data_material_all = $this->m_stockoutlet->sap_stockoutlet_item_select_all();
		$allowed_material = Array();
		foreach($data_material_all as $key=>$value){
			$allowed_material[$data_material_all[$key]['MATNR']]=1;
		}		
		echo '<pre>';
		print_r($data_material_all);
		echo '</pre>';
		echo '<hr />';
		echo '<pre>';
		print_r($allowed_material);
		echo '</pre>';
		
		//if (intval($allowed_material[$material_no])!=1) {
//		die('<hr />');
	}

	function input_error($error_text) {
      $this->jagmodule['error_code'] = '002'; 
		$this->l_general->error_page($this->jagmodule, $error_text, site_url($this->session->userdata['PAGE']['next']));
    }

	function edit_error($error_text) {
      $this->jagmodule['error_code'] = '003'; 
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

		$item_group_code = $this->uri->segment(3);

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

       	$object['stockoutlet_header']['plant'] = $this->session->userdata['ADMIN']['plant'];
       	$object['stockoutlet_header']['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
        $object['stockoutlet_header']['item_group_code'] = $item_group_code;
		if($item_group_code == 'all') {
			$object['item_group']['item_group_code'] = $item_group_code;
			$object['item_group']['item_group_name'] = '<strong>All</strong>';
            $object['stockoutlet_details'] = $this->m_stockoutlet->sap_stockoutlet_item_select_all();
		} else {
            if ($item_group_code=='Item Opname Daily') {
              $object['item_group']['DISPO'] = $item_group_code;
            } else {
  			  $object['item_group'] = $this->m_general->sap_item_group_select($item_group_code);
            }
		    $object['item_group']['item_group_name'] = $item_group_code;
			$object['stockoutlet_details'] = $this->m_stockoutlet->sap_stockoutlet_item_select_by_item_group($object['item_group']['DISPO']);
			$data['items'] = $this->m_stockoutlet->sap_stockoutlet_item_select_by_item_group($object['item_group']['DISPO']);
		}
		if(($object['stockoutlet_details'] !== FALSE)&&(!empty($object['stockoutlet_details']))) {
			$i = 1;
			foreach ($object['stockoutlet_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
				  $object['stockoutlet_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}
		if(count($_POST) == 0) {
    		$object['data']['stockoutlet_details'] = $this->m_stockoutlet->stockoutlet_details_select($object['data']['id_stockoutlet_header']);

    		if($object['data']['stockoutlet_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['stockoutlet_details']->result_array() as $object['temp']) {
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['stockoutlet_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }
		
		if($data['items'] !== FALSE) {
/*
if ($this->session->userdata['ADMIN']['plant']=='B001'){
echo '<pre>';
print_r($data['items']);
echo '</pre>';
	die('a');
}
*/
			$object['item'][''] = '';
            $i = 1;
			foreach ($data['items'] as $data['item']) {
				
					$object['item'][$data['item']['MATNR']] = $data['item']['MATNR1'].' - '.$data['item']['MAKTX'].' ('.$data['item']['UNIT'].')';
				
                $item_to_display[$i] = $data['item']['MATNR'];
                $i++;
			}
		}
        if(!empty($object['item'])) {
    		if($item_choose == 1) {
              ksort($object['item']);
    		} elseif ($item_choose == 2) {
              asort($object['item']);
            }
        }
		if(($this->uri->segment(2) == 'input2')&&(!isset($_POST['button']['add']))&&(!isset($_POST['delete']))&&(empty($check))) {
		   $count = count($item_to_display);
           $k = 1;
           for ($i=1;$i<=$count;$i++) {
             if(!in_array($item_to_display[$i],$object['data']['stockoutlet_detail']['material_no'])) {
               $object['data']['stockoutlet_detail']['id_stockoutlet_h_detail'][$k] = $i;
               $object['data']['stockoutlet_detail']['material_no'][$k] = $item_to_display[$i];
               //$item_lead_time[$k] = $this->m_stockoutlet->sap_item_lead_time_select($item_to_display[$i]);
              // $object['data']['stockoutlet_detail']['lead_time'][$k] = $item_lead_time[$k]['LEAD_TIME'];
			   
//			   echo $item_to_display[$i]."=".$object['data']['stockoutlet_detail']['lead_time'][$k]."<br />";
               //$delivery_date = $this->l_general->date_add_day(date('d-m-Y',strtotime($this->m_general->posting_date_select_max())),$object['data']['stockoutlet_detail']['lead_time'][$k]);
            //   $object['data']['stockoutlet_detail']['delivery_date'][$k] = $delivery_date;
              // $object['data']['stockoutlet_detail']['requirement_qty'][$k] = 0;
			   //$object['data']['stockoutlet_detail']['price'][$k] = 0;
               $k++;
             }
           }
		}

		// save this page to referer
  		$this->l_page->save_page('next');

  		$object['page_title'] = 'Stock Opname';
  		$this->template->write_view('content', 'stockoutlet/stockoutlet_edit', $object);
  		$this->template->render();
	}

	function input_transaksi_baru_error() {
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Transaksi stock opname untuk hari ini sudah diinput dan di approve.<br>Anda hanya bisa menginput 1 transaksi stock opname dalam 1 hari';
        $object['refresh_url'] = 'stockoutlet/browse';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '004';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$stockoutlet = $_POST;
		unset($stockoutlet['button']);

		$count_filled = count($stockoutlet['stockoutlet_detail']['quantity']);

		$count = count($stockoutlet['stockoutlet_detail']['id_stockoutlet_h_detail']);


        $id_stockoutlet_header = $this->m_stockoutlet->stockoutlet_header_select_id_by_date_status_approve($this->l_general->str_to_date($stockoutlet['stockoutlet_header']['posting_date']));
        if ($id_stockoutlet_header==TRUE) {
   		  redirect('stockoutlet/input_transaksi_baru_error');
        }

		// check, at least one product quantity entered
		$quantity_exist = FALSE;
		for($i = 1; $i <= $count; $i++) {
			if(empty($stockoutlet['stockoutlet_detail']['qty_gso'][$i])&&(empty($stockoutlet['stockoutlet_detail']['qty_gss'][$i]))) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

         //   echo "<pre>";
         //   print '$stockoutlet_details';
         //   print_r($stockoutlet['stockoutlet_detail']);
         //   echo "</pre>";
         //   exit;

		if($quantity_exist == FALSE)
			redirect('stockoutlet/input_error/Anda belum memasukkan data Quantity. Mohon ulangi.');

		if(isset($_POST['button']['save']) || isset($_POST['button']['approve'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('qty_gso', $stockoutlet['stockoutlet_detail']['qty_gso']);
   			$this->session->set_userdata('qty_gss', $stockoutlet['stockoutlet_detail']['qty_gss']);
   			$this->session->set_userdata('quantity', $stockoutlet['stockoutlet_detail']['quantity']);
			//$sap_stockoutlet_header = $this->m_stockoutlet->sap_stockoutlet_header_select_by_do_no($stockoutlet['stockoutlet_header']['do_no']);

    		$stockoutlet_header['plant'] = $this->session->userdata['ADMIN']['plant'];
    		$stockoutlet_header['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
			$stockoutlet_header['id_stockoutlet_plant'] = $this->m_stockoutlet->id_stockoutlet_plant_new_select($stockoutlet_header['plant']);
// 			$stockoutlet_header['posting_date'] = $this->m_general->posting_date_select_max($stockoutlet_header['plant']);
 			$stockoutlet_header['posting_date'] = $this->l_general->str_to_date($stockoutlet['stockoutlet_header']['posting_date']);

			if(isset($_POST['button']['approve']))
				$stockoutlet_header['status'] = '2';
			else
				$stockoutlet_header['status'] = '1';

			$stockoutlet_header['item_group_code'] = $stockoutlet['stockoutlet_header']['item_group_code'];
			$stockoutlet_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];

      		if($stockoutlet_header['item_group_code'] == 'all') {
                $stockoutlet_details = $this->m_stockoutlet->sap_stockoutlet_item_select_all();
      		} else {
      			$item_group = $this->m_general->sap_item_group_select($stockoutlet_header['item_group_code']);
         		//$stockoutlet_details = $this->m_stockoutlet->sap_stockoutlet_item_select_by_item_group($item_group['DISPO']);
      		}
            $id_stockoutlet_header = $this->m_stockoutlet->stockoutlet_header_select_id_by_posting_date($stockoutlet_header['posting_date']);
            if ($id_stockoutlet_header==FALSE) {
               $id_exists = FALSE;
               $id_stockoutlet_header = $this->m_stockoutlet->stockoutlet_header_insert($stockoutlet_header);
            } else
               $id_exists = TRUE;
            if ($id_stockoutlet_header!==FALSE) {
                if ($id_exists==TRUE) {
                   if (($stockoutlet_header['item_group_code'] == 'all')||($stockoutlet_header['item_group_code'] == 'Item Opname Daily')) {
                       $this->m_stockoutlet->stockoutlet_details_delete($id_stockoutlet_header);
                       $this->m_stockoutlet->stockoutlet_detail_bom_delete($id_stockoutlet_header);
                   } else {
         				for($i = 1; $i <= $count; $i++) {
         				  $material[$i] = $stockoutlet_details[$i]['MATNR'];
                       }
                       //echo "<pre>";
                       //print_r($material);
                       //echo "</pre>";
                       $this->m_stockoutlet->stockoutlet_details_delete_by_material_no($id_stockoutlet_header,$material);
                       $this->m_stockoutlet->stockoutlet_detail_bom_delete_by_material_no($id_stockoutlet_header,$material);
                   }
                }
            	$count = count($stockoutlet['stockoutlet_detail']['id_stockoutlet_h_detail']);
                $id_stockoutlet_h_detail_max = $this->m_stockoutlet->stockoutlet_detail_selectmax_id_stockoutlet_h_detail($id_stockoutlet_header);
				for($i = 1; $i <= $count; $i++) {

        			$stockoutlet_detail['material_no'] = $stockoutlet['stockoutlet_detail']['MATNR'][$i];//$stockoutlet_details[$i]['MATNR'];
      				$stockoutlet_detail['id_stockoutlet_header'] = $id_stockoutlet_header;
      				$stockoutlet_detail['id_stockoutlet_h_detail'] = $id_stockoutlet_h_detail_max+$stockoutlet['stockoutlet_detail']['id_stockoutlet_h_detail'][$i];
      				$stockoutlet_detail['material_desc'] = $stockoutlet['stockoutlet_detail']['MAKTX'][$i];//$stockoutlet_details[$i]['MAKTX'];
      				$stockoutlet_detail['qty_gso'] = $stockoutlet['stockoutlet_detail']['qty_gso'][$i];
      				$stockoutlet_detail['qty_gss'] = $stockoutlet['stockoutlet_detail']['qty_gss'][$i];
      				$stockoutlet_detail['quantity'] = $stockoutlet_detail['qty_gso']+$stockoutlet_detail['qty_gss'];
      				$stockoutlet_detail['uom'] = $stockoutlet['stockoutlet_detail']['uom'][$i];
					$stockoutlet_detail['num'] = $stockoutlet['stockoutlet_detail']['num'][$i];
					

                	if($id_stockoutlet_detail = $this->m_stockoutlet->stockoutlet_detail_insert($stockoutlet_detail)) {
                       if($item_boms = $this->m_sfgs->sfgs_details_select_by_item_sfg($stockoutlet_detail['material_no'])) {
                         if($item_boms !== FALSE) {
                    		$k = 1;
                            unset($item_bom);
                    		foreach ($item_boms->result_array() as $object['temp']) {
                    			foreach($object['temp'] as $key => $value) {
                    				$item_bom[$key][$k] = $value;
                    			}
                    			$k++;
                    			unset($object['temp']);
                    		}
                     	 }
                      	 $c_item_bom = count($item_bom['id_sfgs_h_detail']);
            			 for($j = 1; $j <= $c_item_bom; $j++) {
                           $stockoutlet_detail_bom['id_stockoutlet_h_detail_bom'] = $j;
                           $stockoutlet_detail_bom['id_stockoutlet_detail'] = $id_stockoutlet_detail;
                           $stockoutlet_detail_bom['id_stockoutlet_header'] = $id_stockoutlet_header;
                           $stockoutlet_detail_bom['material_no_sfg'] = $stockoutlet_detail['material_no'];
                           $stockoutlet_detail_bom['material_no'] = $item_bom['material_no'][$j];
                           $stockoutlet_detail_bom['material_desc'] = $item_bom['material_desc'][$j];
                           $stockoutlet_detail_bom['quantity'] = ($item_bom['quantity'][$j]/$item_bom['quantity_sfg'][$j])*$stockoutlet_detail['quantity'];
                           $stockoutlet_detail_bom['uom'] = $item_bom['uom'][$j];
     					   if($this->m_stockoutlet->stockoutlet_detail_bom_insert($stockoutlet_detail_bom)) {
                               $input_detail_success = TRUE;
     					   } else
                               $input_detail_success = FALSE;
                         }
                       } else
                         $input_detail_success = TRUE;
                	} else {
                       $input_detail_success = FALSE;
                	}
				}
        		unset($stockoutlet_details);
            }


            $this->db->trans_complete();

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			    $this->l_general->success_page('Data Stock Opname berhasil dimasukkan', site_url('stockoutlet/input'));
              } else {
                $this->m_stockoutlet->stockoutlet_header_delete($id_stockoutlet_header);
 			    $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Stock Opname tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            }
		}
	 }

   /*	function _input_approve_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Stock Opname tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
//		$object['refresh_url'] = site_url('stockoutlet/input2');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function _input_approve_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Stock Opname berhasil diapprove';
		$object['refresh_url'] = site_url('stockoutlet/input');
		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();
	}

	function _input_success() {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Stock Opname berhasil dimasukkan';
		$object['refresh_url'] = site_url('stockoutlet/input');
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
	    $stockoutlet_header = $this->m_stockoutlet->stockoutlet_header_select($this->uri->segment(3));
		$status = $stockoutlet_header['status'];
        unset($stockoutlet_header);

        $quantity = array('quantity' => '');
        $this->session->unset_userdata($quantity);
        $qty_gso = array('qty_gso' => '');
        $this->session->unset_userdata($qty_gso);
        $qty_gss = array('qty_gss' => '');
        $this->session->unset_userdata($qty_gss);

    	$validation = FALSE;

    		if(count($_POST) != 0) {

    			// first post, assume all data TRUE
    			$validation_temp = TRUE;

/*    			$object['stockoutlet_details'] = $this->m_stockoutlet->sap_stockoutlet_details_select_by_do_no($_POST['stockoutlet_header']['do_no']);

    			$i = 1;
    			foreach ($object['stockoutlet_details'] as $object['stockoutlet_detail']) {

    					$check[$i] = $this->l_form_validation->set_rules($_POST['stockoutlet_detail']['quantity'][$i], "stockoutlet_detail[quantity][$i]", 'GR Quantity No. '.$i, 'valid_quantity;'.$object['stockoutlet_detail']['LFIMG']);

    					// if one data FALSE, set $validation_temp to FALSE
    					if($check[$i]['error'] == TRUE)
    						$validation_temp = FALSE;

    				$i++;
    			}
*/
    			// set $validation, based on $validation_temp value;
    			$validation = $validation_temp;
    		}

		if ($validation == FALSE) {
			if(!empty($_POST)) {

				$data = $_POST;
				$stockoutlet_header = $this->m_stockoutlet->stockoutlet_header_select($this->uri->segment(3));

				$this->_edit_form(0, $data, $check);
			} else {
				$data['stockoutlet_header'] = $this->m_stockoutlet->stockoutlet_header_select($this->uri->segment(3));
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

/*		if(count($_POST) != 0) {
		  $object['error'] = $this->l_form_validation->error_fields($check);
 		}
*/
		$object['data']['stockoutlet_header']['status_string'] = ($object['data']['stockoutlet_header']['status'] == '2') ? 'Approved' : 'Not Approved';

		if(count($_POST) == 0) {
    		$item_group_code = $data['stockoutlet_header']['item_group_code'];
        } else {
    		$item_group_code = $data['item_group']['item_group_code'];
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

  		$object['item_group']['item_group_name'] = '<strong>All</strong>';
       	$object['stockoutlet_header']['plant'] = $this->session->userdata['ADMIN']['plant'];
       	$object['stockoutlet_header']['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
        $object['stockoutlet_header']['item_group_code'] = $item_group_code;

        $object['stockoutlet_details'] = $this->m_stockoutlet->sap_stockoutlet_item_select_edited_item($object['data']['stockoutlet_header']['id_stockoutlet_header']);

		if(($object['stockoutlet_details'] !== FALSE)&&(!empty($object['stockoutlet_details']))) {
			$i = 1;
			foreach ($object['stockoutlet_details'] as $object['temp']) {
				foreach($object['temp'] as $key => $value) {
					$object['stockoutlet_detail'][$key][$i] = $value;
				}
				$i++;
				unset($object['temp']);
			}
		}

		if(count($_POST) == 0) {
    	    $object['data']['stockoutlet_details'] = $this->m_stockoutlet->stockoutlet_details_select($object['data']['stockoutlet_header']['id_stockoutlet_header']);

    		if($object['data']['stockoutlet_details'] !== FALSE) {
    			$i = 1;
    			foreach ($object['data']['stockoutlet_details']->result_array() as $object['temp']) {
    				foreach($object['temp'] as $key => $value) {
    					$object['data']['stockoutlet_detail'][$key][$i] = $value;
    				}
    				$i++;
    				unset($object['temp']);
    			}
    		}
        }

   	    // save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Stock Opname';
		$this->template->write_view('content', 'stockoutlet/stockoutlet_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$stockoutlet = $_POST;
		unset($stockoutlet['button']);
		// end of assign variables and delete not used variables

		$count_filled = count($stockoutlet['stockoutlet_detail']['quantity']);

		$count = count($stockoutlet['stockoutlet_detail']['id_stockoutlet_h_detail']);

		// variable to check, is at least one product quantity entered?
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if((empty($stockoutlet['stockoutlet_detail']['qty_gso'][$i]))&&
               (empty($stockoutlet['stockoutlet_detail']['qty_gss'][$i]))) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}
        $id_stockoutlet_header = $stockoutlet['stockoutlet_header']['id_stockoutlet_header'];

		if($quantity_exist == FALSE)
			redirect('stockoutlet/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

		if(isset($_POST['button']['save'])) {

			$this->db->trans_start();

          		for($i = 1; $i <= $count; $i++) {
                    $quantity = $stockoutlet['stockoutlet_detail']['qty_gso'][$i]+
                                $stockoutlet['stockoutlet_detail']['qty_gss'][$i];
                    $id_stockoutlet_detail = $stockoutlet['stockoutlet_detail']['id_stockoutlet_detail'][$i];
                    $material_no = $stockoutlet['stockoutlet_detail']['MATNR'][$i];
  	    			$stockoutlet_detail = array (
  						'id_stockoutlet_detail'=>$id_stockoutlet_detail,
  						'qty_gso'=>$stockoutlet['stockoutlet_detail']['qty_gso'][$i],
  						'qty_gss'=>$stockoutlet['stockoutlet_detail']['qty_gss'][$i],
  						'quantity'=>$quantity,
                        'uom'=>$stockoutlet['stockoutlet_detail']['uom'][$i],
						'num'=>$stockoutlet['stockoutlet_detail']['num'][$i],
  					);
  		    		if($this->m_stockoutlet->stockoutlet_detail_update($stockoutlet_detail)) {
                       if ($item_boms = $this->m_sfgs->sfgs_details_select_by_item_sfg($material_no)) {
                         if($item_boms !== FALSE) {
                    		$k = 1;
                            unset($item_bom);
                    		foreach ($item_boms->result_array() as $object['temp']) {
                    			foreach($object['temp'] as $key => $value) {
                    				$item_bom[$key][$k] = $value;
                    			}
                    			$k++;
                    			unset($object['temp']);
                    		}
                     	 }
                         if($this->m_stockoutlet->stockoutlet_detail_bom_select_by_id_stockoutlet_detail($id_stockoutlet_detail)) {
                            $this->m_stockoutlet->stockoutlet_detail_bom_delete_by_id_stockoutlet_detail($id_stockoutlet_detail);
                         }
                      	 $c_item_bom = count($item_bom['id_sfgs_h_detail']);
            			 for($j = 1; $j <= $c_item_bom; $j++) {
                           $stockoutlet_detail_bom['id_stockoutlet_h_detail_bom'] = $j;
                           $stockoutlet_detail_bom['id_stockoutlet_detail'] = $id_stockoutlet_detail;
                           $stockoutlet_detail_bom['id_stockoutlet_header'] = $id_stockoutlet_header;
                           $stockoutlet_detail_bom['material_no_sfg'] = $material_no;
                           $stockoutlet_detail_bom['material_no'] = $item_bom['material_no'][$j];
                           $stockoutlet_detail_bom['material_desc'] = $item_bom['material_desc'][$j];
                           $stockoutlet_detail_bom['quantity'] = ($item_bom['quantity'][$j]/$item_bom['quantity_sfg'][$j])*$quantity;
                           $stockoutlet_detail_bom['uom'] = $item_bom['uom'][$j];
     					   if($this->m_stockoutlet->stockoutlet_detail_bom_insert($stockoutlet_detail_bom)) {
                               $input_detail_success = TRUE;
     					   } else
                               $input_detail_success = FALSE;
                         }
                       } else
                         $input_detail_success = TRUE;
                	} else {
                       $input_detail_success = FALSE;
                	}
      	    	}

  			$this->db->trans_complete();
            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
    			  $this->l_general->success_page('Data Stock Opname berhasil diubah', site_url('stockoutlet/browse'));
   			  } else {
	    		  $this->jagmodule['error_code'] = '006'; 
		$this->l_general->error_page($this->jagmodule, 'Data Stock Opname tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            }

		}
	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'stockoutlet/browse';
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


	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Stock Opname tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_stockoutlet_header) {

		// check approve status
		$stockoutlet_header = $this->m_stockoutlet->stockoutlet_header_select($id_stockoutlet_header);

		if($stockoutlet_header['status'] == '1') {
			$this->m_stockoutlet->stockoutlet_header_delete($id_stockoutlet_header);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function delete($id_stockoutlet_header) {

		if($this->_delete($id_stockoutlet_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Stock Opname berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['stockoutlet_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Stock Opname gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['stockoutlet_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '007';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {
		if(!count($_POST['id_stockoutlet_header']))
			redirect($this->session->userdata['PAGE']['stockoutlet_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
          if(!empty($_POST['id_stockoutlet_header'][$i])) {
				$object['data']['stockoutlet_headers'][$j++] = $this->m_stockoutlet->stockoutlet_header_select($_POST['id_stockoutlet_header'][$i]);
			}
		}
        if (isset($_POST['button']['savetoexcel']))
  		  $this->template->write_view('content', 'stockoutlet/stockoutlet_export_confirm', $object);
        else
  		  $this->template->write_view('content', 'stockoutlet/stockoutlet_delete_multiple_confirm', $object);

        $this->template->render();

	}

	function delete_multiple_execute() {

		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_stockoutlet_header'][$i]);
		}

		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Stock Opname berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['stockoutlet_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

   	function file_export() {
        $data = $this->m_stockoutlet->stockoutlet_select_to_export($_POST['id_stockoutlet_header']);
    	if($data!=FALSE) {
    	  $this->l_general->export_to_excel($data,'StockOpname');
        }
    }

   	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'stockoutlet_data';
		$config['allowed_types'] = 'xls';
		$config['max_size']	= '10000000';
		$this->load->library('upload', $config);
		
		$data_material_all = $this->m_stockoutlet->sap_stockoutlet_item_select_all();
		$allowed_material = Array();
			if ($this->session->userdata['ADMIN']['plant']=='AB028') {
				print_r($data_material_all);
				die('<hr />');
			}
		
		foreach($data_material_all as $key=>$value){
			$allowed_material[$data_material_all[$key]['MATNR']]=1;
		}
		
		if (!$this->upload->do_upload('userfile')) {
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
//			$this->load->view('upload_form', $error);
		} else {
			$upload = $this->upload->data();;
			// Load the spreadsheet reader library
			$this->load->library('excel_reader');

			// Set output Encoding.
//			$this->excel_reader->setOutputEncoding('CP1251');
			$this->excel_reader->setOutputEncoding('CPa25a');

            if($_SERVER['SERVER_NAME'] == 'localhost')
            $file =  $_SERVER['DOCUMENT_ROOT'].'/sap.ybc.co.id/excel_upload/'.$upload['file_name'];
            else
            $file =  $_SERVER['DOCUMENT_ROOT'].'/excel_upload/'.$upload['file_name'];
			$file = str_replace('//','/',$file);

			$this->session->set_userdata('file_upload', $file);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;
			/* // debug only
			if ($this->session->userdata['ADMIN']['plant']=='AB028') {
			echo $this->session->userdata['ADMIN']['plant'].'<br />';
            echo "<pre>";
			print_r($this->excel_reader);
            echo "</pre>";
            echo "<pre>";
            print_r($excel);
            echo "</pre>";die('<hr />');
			}
			*/ //end debug
			// is it grpo template file?
 		    if($excel['cells'][1][1] == 'Material Doc. No' && $excel['cells'][1][2] == 'Material No.') {

				for ($i = 2; $i <= $excel['numRows']; $i++) {
                  $material_no_tmp[] = $excel['cells'][$i][2];    // to store material no to check wheater it's duplicate
                }
                $arr_count_item = array_count_values($material_no_tmp);

				$j = 0; // grpo_header number, started from 1, 0 assume no data

				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpo header?

					$item_group_code = 'all';
					$material_no =  trim($excel['cells'][$i][2]);
					$qty_gso = $excel['cells'][$i][3];
                    $qty_gss = $excel['cells'][$i][4];
                    $uom_import = $excel['cells'][$i][5];
                    $posting_date = $excel['cells'][$i][6];
                    $material_xls_name = $excel['cells'][$i][7]; //optional
					if (Empty($material_xls_name)) $material_xls_name = '-';
                    if ($material_xls_name=='-') $material_xls_name = $excel['cells'][$i][16]; //optional
					if (Empty($material_xls_name)) $material_xls_name = '-';
//					$material_xls_name = str_replace('/','eK8s7IWdXG',$material_xls_name);
//					$material_xls_name = str_replace('(','XblI3AvIxi',$material_xls_name);
//					$material_xls_name = str_replace(')','2sLawpmywU',$material_xls_name);

                    $c_item = $arr_count_item[$material_no];
					
					if (trim($material_no)=='') continue;
					
					$iTimestamp = strtotime( $posting_date );

					if ($iTimestamp >= 0 && false !== $iTimestamp)
					{
					// Its good.
					}
					else
					{
						$iTimestamp = mktime(0,0,0,1,$posting_date-1,1900); 
						$posting_date = date('Ymd',$iTimestamp);
						$iTimestamp = strtotime($posting_date);
					}
					
					
                    if($c_item>1) {
						redirect('stockoutlet/error_import_01/'.$material_no.'/'.$c_item);
                    }
                    if ($this->m_stockoutlet->stockoutlet_header_select_id_by_posting_date($posting_date)!=FALSE) {
						redirect('stockoutlet/error_import_02/'.date('d-m-Y',strtotime($posting_date)));
                    }
            	    if((date('N',$iTimestamp)!=7)&&(date("Y-m-t",$iTimestamp)!=date('Y-m-d',$iTimestamp))) {
                      $periode = date('Y-m',$iTimestamp);
                      if ($this->m_opnd->opnd_details_select_by_kode_item($periode,$material_no)==FALSE) {
						if (Empty($material_no)) $material_no = "none";
						if (Empty($periode)) { $periode = "none"; } 
						elseif (trim($periode)=='1970-01') { $periode = "none"; }
						redirect('stockoutlet/error_import_03/'.$material_no.'/'.$periode);
                      }
                    } else { //20140321: Menjaga material yang tidak terdaftar tidak bisa masuk
						if (intval($allowed_material[$material_no])!=1) {
						
							/* // debug only
							if ($this->session->userdata['ADMIN']['plant']=='AB061') {
								echo "#".$allowed_material[$material_no]."#".$material_no."#";die();
							}
							*/ // end debug
							
							// $material_xls_name = urlencode($material_xls_name);
							$matError = $material_no."###".$material_xls_name;
							$matEnc = new SwbEncryption();
							$matURL = $matEnc->encode($matError);
							unset($matEnc);
							
							redirect('stockoutlet/error_import_05/'.$matURL);
						}
					}

					// check grpo header
					if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

                            $j++;

                       if($stockoutlet_header_temp = $this->m_general->sap_item_groups_select_all_stockoutlet()) {
                            $object['stockoutlet_headers'][$j]['material_doc_no'] = $excel['cells'][$i][1];
							$object['stockoutlet_headers'][$j]['posting_date'] = $posting_date;
                            $object['stockoutlet_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['stockoutlet_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['stockoutlet_headers'][$j]['status'] = '1';
							$object['stockoutlet_headers'][$j]['item_group_code'] = $item_group_code;
							$object['stockoutlet_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['stockoutlet_headers'][$j]['filename'] = $upload['file_name'];

                        	$stockoutlet_header_exist = TRUE;
							$k = 1; // grpo_detail number
                       	} else {
                     	    $stockoutlet_header_exist = FALSE;
				       }
					}

				    	if($stockoutlet_header_exist) {
                            if ($stockoutlet_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)){
							$object['stockoutlet_details'][$j][$k]['id_stockoutlet_header'] = $id_stockoutlet_header;
							$object['stockoutlet_details'][$j][$k]['id_stockoutlet_h_detail'] = $k;
							$object['stockoutlet_details'][$j][$k]['item'] = $k;
							$object['stockoutlet_details'][$j][$k]['material_no'] = $material_no;

							$object['stockoutlet_details'][$j][$k]['material_desc'] = $stockoutlet_detail_temp['MAKTX'];
							$object['stockoutlet_details'][$j][$k]['qty_gso'] = $qty_gso;
                            $object['stockoutlet_details'][$j][$k]['qty_gss'] = $qty_gss;
                            $object['stockoutlet_details'][$j][$k]['quantity'] = $qty_gso + $qty_gss;
							$uom_import = trim(strtoupper($uom_import));
                            $uom_to_check = trim(strtoupper($stockoutlet_detail_temp['UNIT']));
                            if(strcasecmp($uom_import,'KG')==0) {
                              $uom_import = 'G';
                            }
                            if(strcasecmp($uom_import,'L')==0) {
                              $uom_import = 'ML';
                            }
                            if(strcasecmp($uom_to_check,'KG')==0) {
                              $uom_to_check = 'G';
                            }
                            if(strcasecmp($uom_to_check,'L')==0) {
                              $uom_to_check = 'ML';
                            }
                            if ($uom_import!=$uom_to_check) {
        					  redirect('stockoutlet/error_import_04/'.$material_no.'/'.$uom_to_check.'/'.$uom_import);
                            }

							$object['stockoutlet_details'][$j][$k]['uom'] = $uom_import;

							$k++;

                         }
					}

				}


				$this->template->write_view('content', 'stockoutlet/stockoutlet_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Stock Opname atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'stockoutlet/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '008';
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

		// is it grpo template file?
		 if($excel['cells'][1][1] == 'Material Doc. No' && $excel['cells'][1][2] == 'Material No.') {
				$totaltemp =0;

			$this->db->trans_start();

			$j = 0; // grpo_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same stockoutlet header?


				    $item_group_code = 'all';
					$material_no =  $excel['cells'][$i][2];
					$qty_gso = $excel['cells'][$i][3];
                    $qty_gss = $excel['cells'][$i][4];
                    $quantity = $qty_gso + $qty_gss;
                    $uom_import = $excel['cells'][$i][5];
                    $posting_date = $excel['cells'][$i][6];


				// check stockoutlet header
				if($excel['cells'][$i][1] != $excel['cells'][$x][1]) {

                        $j++;

                        if($stockoutlet_header_temp = $this->m_general->sap_item_groups_select_all_stockoutlet()) {

							/*if ($this->session->userdata['ADMIN']['plant']=='B062'){
								echo 'ROW '.$i.' = '.$x.'<br />';
							}
							*/

						    $object['stockoutlet_headers'][$j]['posting_date'] = $posting_date;
                            $object['stockoutlet_headers'][$j]['plant'] = $this->session->userdata['ADMIN']['plant'];
							$object['stockoutlet_headers'][$j]['id_stockoutlet_plant'] = $this->m_stockoutlet->id_stockoutlet_plant_new_select($object['stockoutlet_headers'][$j]['plant']);
							$object['stockoutlet_headers'][$j]['storage_location'] = $this->session->userdata['ADMIN']['storage_location'];
							$object['stockoutlet_headers'][$j]['status'] = '1';
							$object['stockoutlet_headers'][$j]['item_group_code'] = $item_group_code;
							$object['stockoutlet_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['stockoutlet_headers'][$j]['filename'] = $upload['file_name'];

							$id_stockoutlet_header = $this->m_stockoutlet->stockoutlet_header_insert($object['stockoutlet_headers'][$j]);

							$stockoutlet_header_exist = TRUE;
							$k = 1; // grpo_detail number
                        } else {
							$stockoutlet_header_exist = FALSE;
					}

				}

				if($stockoutlet_header_exist) {


                        if ($stockoutlet_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)){
						$object['stockoutlet_details'][$j][$k]['id_stockoutlet_header'] = $id_stockoutlet_header;
						$object['stockoutlet_details'][$j][$k]['id_stockoutlet_h_detail'] = $k;
								$object['stockoutlet_details'][$j][$k]['material_no'] = $material_no;
                            $object['stockoutlet_details'][$j][$k]['material_desc'] = $stockoutlet_detail_temp['MAKTX'];
							$object['stockoutlet_details'][$j][$k]['qty_gso'] = $qty_gso;
                            $object['stockoutlet_details'][$j][$k]['qty_gss'] = $qty_gss;
                            $object['stockoutlet_details'][$j][$k]['quantity'] = $quantity;
                            if(empty($uom_import)) {
                              $uom_import = $stockoutlet_detail_temp['UNIT'];
                            }
                            if(strcasecmp($uom_import,'KG')==0) {
                              $uom_import = 'G';
                            }
                            if(strcasecmp($uom_import,'L')==0) {
                              $uom_import = 'ML';
                            }
							$object['stockoutlet_details'][$j][$k]['uom'] = $uom_import;


						    if($id_stockoutlet_detail = $this->m_stockoutlet->stockoutlet_detail_insert($object['stockoutlet_details'][$j][$k])) {

                               if(($quantity > 0)&&($item_boms = $this->m_sfgs->sfgs_details_select_by_item_sfg($material_no))) {
                                 if($item_boms !== FALSE) {
                            		$l = 1;
                            		foreach ($item_boms->result_array() as $object['temp']) {
                            			foreach($object['temp'] as $key => $value) {
                            				$item_bom[$key][$l] = $value;
                            			}
                            			$l++;
                            			unset($object['temp']);
                            		}
                             	 }
                              	 $c_item_bom = count($item_bom['id_sfgs_h_detail']);
                    			 for($m = 1; $m <= $c_item_bom; $m++) {
                                   $stockoutlet_detail_bom['id_stockoutlet_h_detail_bom'] = $m;
                                   $stockoutlet_detail_bom['id_stockoutlet_detail'] = $id_stockoutlet_detail;
                                   $stockoutlet_detail_bom['id_stockoutlet_header'] = $id_stockoutlet_header;
                                   $stockoutlet_detail_bom['material_no_sfg'] = $material_no;
                                   $stockoutlet_detail_bom['material_no'] = $item_bom['material_no'][$m];
                                   $stockoutlet_detail_bom['material_desc'] = $item_bom['material_desc'][$m];
                                   $stockoutlet_detail_bom['quantity'] = ($item_bom['quantity'][$m]/$item_bom['quantity_sfg'][$m])*$quantity;
                                   $stockoutlet_detail_bom['uom'] = $item_bom['uom'][$m];
             					   $this->m_stockoutlet->stockoutlet_detail_bom_insert($stockoutlet_detail_bom);
                                 }
                               }
						    }

						$k++;

                       }
				}

			}

			$this->db->trans_complete();
			
			/*
			echo '<hr /><h1>DETAIL</h1>';
			print_r($object['stockoutlet_details']);
			
			echo '<hr /><h1>BOM 000000000000300260</h1>'.$totaltemp;
			
			die('<hr />');
			*/
			
			
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Stock Opname  berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['stockoutlet_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Stock Opname atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'stockoutlet/browse_result/0/0/0/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '009';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}
	
	
	function error_import_01() {
		$material_no = $this->uri->segment(3);
		$c_item = $this->uri->segment(4);
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Kode '.$material_no.' telah ada sebanyak '.$c_item.' kali dalam file Anda. Kode setiap item hanya boleh satu kali saja.<br><br>Silahkan cek kembali file Excel Anda.';
        $object['refresh_url'] = 'stockoutlet/browse_result/0/0/0/0/0/0/0/10';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '010';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function error_import_02() {
		$posting_date = $this->uri->segment(3);
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Stock opname untuk tanggal '.$posting_date.' sudah ada di sistem. Silahkan gunakan data stock opname Anda yang sudah ada di sistem.';
        $object['refresh_url'] = 'stockoutlet/browse_result/0/0/0/0/0/0/0/10';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '011';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}
	
	function error_import_03() {
		$material_no = $this->uri->segment(3);
		$periode = $this->uri->segment(4);
		if (trim($periode)=="1970-01") $periode="none";
		
		$object['refresh'] = 0;
		if (($material_no=="none")&&($periode=="none")){
			$object['refresh_text'] = 'Silahkan cek file Excel Anda. Anda tidak mengisi posting date pada salah satu atau lebih baris.<br><br>Harap isi posting date pada semua baris.';
		} elseif (($material_no!="none")&&($periode=="none")) {
			$object['refresh_text'] = 'Silahkan cek pada kode '.$material_no.'. Anda belum mencantumkan posting date pada kode tersebut.<br><br>Pastikan Anda telah mengisi posting date pada semua baris.';
		} else {
			$object['refresh_text'] = 'Kode '.$material_no.' tidak ada dalam daftar material untuk Daily Opname untuk periode '.$periode;
		}
        $object['refresh_url'] = 'stockoutlet/browse_result/0/0/0/0/0/0/0/10';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '012';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}

	function error_import_04() {
		$material_no = $this->uri->segment(3);
		$uom = $this->uri->segment(4);
		$false_uom = $this->uri->segment(5);
		$object['refresh'] = 0;
		$object['refresh_text'] = 'Kode '.$material_no.' seharusnya diinput dengan UOM "'.$uom.'". UOM yang anda input: "'.$false_uom.'" UOM harus diinput dengan benar.<br><br>Silahkan cek kembali file Excel Anda.';
        $object['refresh_url'] = 'stockoutlet/browse_result/0/0/0/0/0/0/0/10';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '013';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}
	
	function error_import_05() {
		$material_no = $this->uri->segment(3);
		$matEnc = new SwbEncryption();
		$mat_Desc = $matEnc->decode($material_no);
		unset($matEnc);
		
		$mat_Desc = explode('###',$mat_Desc);
		$material_no = $mat_Desc[0];
		$material_name = $mat_Desc[1];
		
//		$material_name = urldecode($this->uri->segment(4));
//		$material_name = str_replace('eK8s7IWdXG','/',$material_name);
//		$material_name = str_replace('XblI3AvIxi','(',$material_name);
//		$material_name = str_replace('2sLawpmywU',')',$material_name);
		
		$object['refresh'] = 0;
		if ($material_name=='-') 
			$object['refresh_text'] = 'Kode '.$material_no.' tidak bisa digunakan untuk Stock Opname.<br><br>Silahkan hapus baris kode tersebut di file Excel Anda, atau cek kembali file Excel Anda.';
		else
			$object['refresh_text'] = 'Kode '.$material_no.' ['.$material_name.'] tidak bisa digunakan untuk Stock Opname.<br><br>Silahkan hapus kode tersebut atau cek kembali file Excel Anda.';
        $object['refresh_url'] = 'stockoutlet/browse_result/0/0/0/0/0/0/0/10';
		$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = '014';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}	

}
