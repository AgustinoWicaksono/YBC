<?php
class sfgs extends Controller {
	private $jagmodule = array();


	function sfgs() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1047);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('masterdata_sfg'))
			redirect('');

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->library('l_form_validation');
		$this->load->model('m_sfgs');
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
		$sfgs_browse_result = $this->session->userdata['PAGE']['sfgs_browse_result'];

		if(!empty($sfgs_browse_result))
			redirect($this->session->userdata['PAGE']['sfgs_browse_result']);
		else
			redirect('sfgs/browse_result/0/0/0/0/10');

	}

	// search data
	function browse_search() {

		if(empty($_POST['field_content'])) {
			$field_content = 0;
		} else {
			$field_content = $_POST['field_content'];
		}

		if(empty($_POST['limit'])) {
			$limit = 10;
		} else {
			$limit = $_POST['limit'];
		}

		redirect('sfgs/browse_result/'.$_POST['field_name']."/".$_POST['field_type']."/".$field_content."/0/".$limit);

	}

	// search result
	function browse_result($field_name = '', $field_type = '', $field_content = '', $sort = '', $limit = 10, $start = 0)	{

		$this->l_page->save_page('sfgs_browse_result');

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
			'a'	=>	'Kode SFG Item',
			'b'	=>	'Nama SFG Item',

		);

		$object['field_type'] = array (
			'part'	=>	'Any Part of Field',
			'all'	=>	'All Part of Field',
		);

		$sort_link1 = 'sfgs/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/';
		$sort_link2 = '/'.$limit.'/';

		$object['sort_link'] = array (
			'ay'	=>	$sort_link1.'ay'.$sort_link2,
			'az'	=>	$sort_link1.'az'.$sort_link2,
			'by'	=>	$sort_link1.'by'.$sort_link2,
			'bz'	=>	$sort_link1.'bz'.$sort_link2,
		);

		$this->load->library('pagination');

		$config['per_page'] = $limit;
		$config['num_links'] = 4;
		$config['first_link'] = "&lt;&lt;";
		$config['last_link'] = "&gt;&gt;";
		$config['prev_link'] = "&lt;";
		$config['next_link'] = "&gt;";

		$config['uri_segment'] = 8;
		$config['base_url'] = site_url('sfgs/browse_result/'.$field_name.'/'.$field_type.'/'.$field_content.'/'.$sort.'/'.$limit.'/');

		$config['total_rows'] = $this->m_sfgs->sfgs_headers_count_by_criteria($field_name, $field_type, $field_content, $sort);;

		// save pagination definition
		$this->pagination->initialize($config);

		$object['data']['sfgs_headers'] = $this->m_sfgs->sfgs_headers_select_by_criteria($field_name, $field_type, $field_content, $sort, $limit, $start);

		$object['limit'] = $limit;
		$object['total_rows'] = $config['total_rows'];

		$object['page_title'] = 'List of Master Semi Finished Goods (SFG) BOM  ';
		$this->template->write_view('content', 'sfgs/sfgs_browse', $object);
		$this->template->render();

	}

	// input data
	function input() {

		// if $data exist, add to the $object array
		if ( count($_POST) != 0) {
			$data = $_POST;
			$object['data'] = $data;
		} else {
			$object['data'] = NULL;
		}

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

        $sfgs_detail_tmp = array('sfgs_detail' => '');
        $this->session->unset_userdata($sfgs_detail_tmp);
        unset($sfgs_detail_tmp);

        $item_choose = $data['item_choose'];

    	$object['item_choose'][0] = '';
    	$object['item_choose'][1] = 'Kode';
    	$object['item_choose'][2] = 'Nama';

        if(!empty($data['item'])) {
          $item_code = $data['item'];
          $items = $this->m_general->sap_item_select_by_item_code($item_code);
          $item_name = $items['MAKTX'];
       	  $object['item_sfg_name'] = $item_name;
        }
   		$data['items'] = $this->m_general->sap_item_groups_select_all_sfgs();

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
		if(!empty($item_name)) {
			redirect('sfgs/input2/'.$data['item_choose'].'/'.$item_code);
		}

		$object['page_title'] = 'Master Semi Finished Goods (SFG) BOM';
		$this->template->write_view('content', 'sfgs/sfgs_input', $object);
		$this->template->render();

	}

	function input2()	{

		$item_choose = $this->uri->segment(4);

		$validation = FALSE;

		if(count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['sfgs_detail']['id_sfgs_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

                $check[0] = $this->l_form_validation->set_rules($_POST['sfgs_header']['quantity_sfg'], "sfgs_header[quantity_sfg]", 'Quantity SFG', 'required|is_numeric_no_zero');
				if($check[0]['error'] == TRUE)
				    $validation_temp = FALSE;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['sfgs_detail']['material_no'][$i], "sfgs_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['sfgs_detail']['quantity'][$i], "sfgs_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

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

		if(isset($_POST['button']['add']) || isset($_POST['delete'])) {
          $sfgs_detail_tmp = array('sfgs_detail' => '');
          $this->session->unset_userdata($sfgs_detail_tmp);
          unset($sfgs_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}
        if ($this->uri->segment(2) == 'edit') {
    		$item_choose = $this->uri->segment(4);
    		$kode_item_sfg = $this->uri->segment(5);
        } else {
    		$item_choose = $this->uri->segment(3);
    		$kode_item_sfg = $this->uri->segment(4);
        }
		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
		);
		// end of form attributes

        if(!empty($kode_item_sfg)) {
          $items = $this->m_general->sap_item_select_by_item_code($kode_item_sfg);
       	  $object['item_sfg_name'] = $items['MAKTX'];
       	  $object['item_sfg_code'] = $kode_item_sfg;
       	  $object['uom_sfg'] = $items['UNIT'];
        }

		$data['items'] = $this->m_general->sap_item_groups_select_all_sfgs_matr();
//exit;
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
		if(($this->uri->segment(2) == 'edit')) {
		  $object['data']['sfgs_header'] = $_POST['sfgs_header'];//$this->m_sfgs->sfgs_details_select($this->uri->segment(3));
		  $object['data']['sfgs_detail'] = $_POST['sfgs_detail'];//$this->m_sfgs->sfgs_details_select($this->uri->segment(3));
		}

		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Master Semi Finished Goods (SFG) BOM';
		$this->template->write_view('content', 'sfgs/sfgs_edit', $object);
		$this->template->render();
	}

	function _input_add() {
		// start of assign variables and delete not used variables
		$sfgs = $_POST;
		unset($sfgs['button']);
		// end of assign variables and delete not used variables

		$count = count($sfgs['sfgs_detail']['id_sfgs_h_detail']) - 1;

		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($sfgs['sfgs_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('sfgs/input_error/Anda belum memasukkan data GR Quantity. Mohon ulangi.');

//		if($this->m_config->running_number_select_update('sfgs', 1, date("Y-m-d")) {

		if (isset($_POST['button']['save'])) {

//			$sfgs_header['kode_sfg'] = '0001'.date("Ymd").sprintf("%04d", $running_number);

			$this->db->trans_start();

   			$this->session->set_userdata('sfgs_detail', $sfgs['sfgs_detail']);

            $sfgs_header['kode_sfg'] = $sfgs['sfgs_header']['kode_sfg'];
            $sfgs_header['nama_sfg'] = $sfgs['sfgs_header']['nama_sfg'];
			$sfgs_header['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
    		$sfgs_header['plant'] = $this->session->userdata['ADMIN']['plant'];
            $sfgs_header['quantity_sfg'] = $sfgs['sfgs_header']['quantity_sfg'];
            $sfgs_header['uom_sfg'] = $sfgs['sfgs_header']['uom_sfg'];

			if($id_sfgs_header = $this->m_sfgs->sfgs_header_insert($sfgs_header)) {
                $input_detail_success = FALSE;

				for($i = 1; $i <= $count; $i++) {

					if((!empty($sfgs['sfgs_detail']['quantity'][$i]))&&(!empty($sfgs['sfgs_detail']['material_no'][$i]))) {

						$sfgs_detail['id_sfgs_header'] = $id_sfgs_header;
						$sfgs_detail['quantity'] = $sfgs['sfgs_detail']['quantity'][$i];
						$sfgs_detail['id_sfgs_h_detail'] = $sfgs['sfgs_detail']['id_sfgs_h_detail'][$i];

  						$sfgs_detail['material_no'] = $sfgs['sfgs_detail']['material_no'][$i];
  						$sfgs_detail['material_desc'] = $sfgs['sfgs_detail']['material_desc'][$i];
  						$sfgs_detail['uom'] = $sfgs['sfgs_detail']['uom'][$i];

						if($this->m_sfgs->sfgs_detail_insert($sfgs_detail))
                          $input_detail_success = TRUE;
					}

				}

			}

            $this->db->trans_complete();

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success === TRUE) {
   			    $this->l_general->success_page('Data Master Semi Finished Goods (SFG) BOM berhasil dimasukkan', site_url('sfgs/input'));
              } else {
                $this->m_sfgs->sfgs_header_delete($kode_sfg);
				$this->jagmodule['error_code'] = '003'; 
		$this->l_general->error_page($this->jagmodule, 'Data Master Semi Finished Goods (SFG) BOM tidak berhasil di tambah', site_url($this->session->userdata['PAGE']['next']));
              }
            }

		}

	}

	function edit() {

		$item_choose = $this->uri->segment(4);

        $sfgs_detail_tmp = array('sfgs_detail' => '');
        $this->session->unset_userdata($sfgs_detail_tmp);
        unset($sfgs_detail_tmp);

		$validation = FALSE;

		if (count($_POST) != 0) {

			if(!isset($_POST['delete'])) {
				// first post, assume all data TRUE
				$validation_temp = TRUE;

				$count = count($_POST['sfgs_detail']['id_sfgs_h_detail']);
				$i = 1; // counter for each row
				$j = 1; // counter for each field

				// for POST data
				if(isset($_POST['button']['save']) || isset($_POST['button']['approve']))
					$count2 = $count - 1;
				else
					$count2 = $count;

                $check[0] = $this->l_form_validation->set_rules($_POST['sfgs_header']['quantity_sfg'], "sfgs_header[quantity_sfg]", 'Quantity SFG', 'required|is_numeric_no_zero');
				if($check[0]['error'] == TRUE)
				    $validation_temp = FALSE;

				for($i = 1; $i <= $count2; $i++) {
					$check[$j] = $this->l_form_validation->set_rules($_POST['sfgs_detail']['material_no'][$i], "sfgs_detail[material_no][$i]", 'Material No. '.$i, 'required');

					// if one data FALSE, set $validation_temp to FALSE
					if($check[$j]['error'] == TRUE)
						$validation_temp = FALSE;

					$j++;

					$check[$j] = $this->l_form_validation->set_rules($_POST['sfgs_detail']['quantity'][$i], "sfgs_detail[quantity][$i]", 'Quantity No. '.$i, 'required|is_numeric_no_zero');

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
				$this->_edit_form(0, $data, $check);
			} else {
				$data['sfgs_header'] = $this->m_sfgs->sfgs_header_select($this->uri->segment(3));
				$this->_edit_form(0, $data, $check);
			 }

		} else {

			if(isset($_POST['button']['save'])) {
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
          $sfgs_detail_tmp = array('sfgs_detail' => '');
          $this->session->unset_userdata($sfgs_detail_tmp);
          unset($sfgs_detail_tmp);
        }

		if((count($_POST) != 0)&&(!empty($check))) {
			$object['error'] = $this->l_form_validation->error_fields($check);
 		}

		$item_choose = $this->uri->segment(4);
        $id_sfgs_header = $this->uri->segment(3);
/*		if(count($_POST) == 0) {
			$item_group_code = $data['sfgs_header']['item_group_code'];
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

		$data['items'] = $this->m_general->sap_item_groups_select_all_sfgs();

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
			$object['data']['sfgs_details'] = $this->m_sfgs->sfgs_details_select($id_sfgs_header);

			if($object['data']['sfgs_details'] !== FALSE) {
				$i = 1;
				foreach ($object['data']['sfgs_details']->result_array() as $object['temp']) {
	//				$object['data']['sfgs_detail'][$i] = $object['temp'];
					foreach($object['temp'] as $key => $value) {
						$object['data']['sfgs_detail'][$key][$i] = $value;
					}
					$i++;
					unset($object['temp']);
				}
			}
		}
		// save this page to referer
		$this->l_page->save_page('next');

		$object['page_title'] = 'Edit Master Semi Finished Goods (SFG) BOM';
		$this->template->write_view('content', 'sfgs/sfgs_edit', $object);
		$this->template->render();
	}

	function _edit_update() {
		// start of assign variables and delete not used variables
		$sfgs = $_POST;
//		unset($sfgs['sfgs_header']['kode_sfg']);
		unset($sfgs['button']);
		// end of assign variables and delete not used variables

		$count = count($sfgs['sfgs_detail']['id_sfgs_h_detail']) - 1;

		// check, at least one product quantity entered
		$quantity_exist = FALSE;

		for($i = 1; $i <= $count; $i++) {
			if(empty($sfgs['sfgs_detail']['quantity'][$i])) {
				continue;
			} else {
				$quantity_exist = TRUE;
				break;
			}
		}

		if($quantity_exist == FALSE)
			redirect('sfgs/edit_error/Anda belum memasukkan data detail. Mohon ulangi');

    	if(isset($_POST['button']['save'])) {

			$this->db->trans_start();

   			$this->session->set_userdata('sfgs_detail', $sfgs['sfgs_detail']);
            $id_sfgs_header = $sfgs['sfgs_header']['id_sfgs_header'];

  			$data = array (
  				'id_sfgs_header' =>	$id_sfgs_header,
                'quantity_sfg' => $sfgs['sfgs_header']['quantity_sfg'],
  				'uom_sfg' => $sfgs['sfgs_header']['uom_sfg'],
  			);

            $input_detail_success = FALSE;

            if(($this->m_sfgs->sfgs_header_update($data))&&
              ($this->m_sfgs->sfgs_details_delete($id_sfgs_header))) {
        		for($i = 1; $i <= $count; $i++) {
					if((!empty($sfgs['sfgs_detail']['quantity'][$i]))&&(!empty($sfgs['sfgs_detail']['material_no'][$i]))) {

						$sfgs_detail['id_sfgs_header'] = $id_sfgs_header;
						$sfgs_detail['quantity'] = $sfgs['sfgs_detail']['quantity'][$i];
						$sfgs_detail['id_sfgs_h_detail'] = $sfgs['sfgs_detail']['id_sfgs_h_detail'][$i];

						$sfgs_detail['material_no'] = $sfgs['sfgs_detail']['material_no'][$i];
						$sfgs_detail['material_desc'] = $sfgs['sfgs_detail']['material_desc'][$i];
						$sfgs_detail['uom'] = $sfgs['sfgs_detail']['uom'][$i];

						if($this->m_sfgs->sfgs_detail_insert($sfgs_detail))
                          $input_detail_success = TRUE;
					}

       	    	}
            }

  			$this->db->trans_complete();

            if(isset($_POST['button']['save'])) {
              if ($input_detail_success == TRUE) {
			  $this->l_general->success_page('Data Master Semi Finished Goods (SFG) BOM berhasil diubah', site_url('sfgs/browse'));
              } else {
			  $this->jagmodule['error_code'] = '004'; 
		$this->l_general->error_page($this->jagmodule, 'Data Master Semi Finished Goods (SFG) BOM tidak berhasil diubah', site_url($this->session->userdata['PAGE']['next']));
              }
            } else if(isset($_POST['button']['approve']))
              if($approve_data_success == TRUE) {
			  $this->l_general->success_page('Data Master Semi Finished Goods (SFG) BOM berhasil diapprove', site_url('sfgs/browse'));
              } else {
			  $this->jagmodule['error_code'] = '005'; 
		$this->l_general->error_page($this->jagmodule, 'Data Master Semi Finished Goods (SFG) BOM tidak  berhasil diapprove.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$approved_data['sap_messages'], site_url($this->session->userdata['PAGE']['next']));
            }

		}

	}

	/*function _edit_success($refresh_text) {
		$object['refresh'] = 1;
		$object['refresh_text'] = $refresh_text;
		$object['refresh_url'] = 'sfgs/browse';
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


	/*function _edit_cancel_failed($error_messages) {
		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Master Semi Finished Goods (SFG) BOM tidak berhasil dibatalkan.<br>
                                   Pesan Kesalahan dari sistem SAP : '.$error_messages;
		$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
		//redirect('member_browse');

			$object['jag_module'] = $this->jagmodule;
		$object['error_code'] = 'xxx';
		$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
		$this->template->write_view('content', 'errorweb', $object);
		$this->template->render();
	}*/

	function _delete($id_sfgs_header) {

		$this->db->trans_start();

		// check approve status
		if($this->m_sfgs->sfgs_header_delete($id_sfgs_header)) {
			$this->db->trans_complete();
			return TRUE;
		} else {
			$this->db->trans_complete();
			return FALSE;
		}
	}

	function delete($id_sfgs_header) {

		if($this->_delete($id_sfgs_header)) {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Master Semi Finished Goods (SFG) BOM berhasil dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['sfgs_browse_result'];

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();
		} else {
			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data Master Semi Finished Goods (SFG) BOM gagal dihapus';
			$object['refresh_url'] = $this->session->userdata['PAGE']['sfgs_browse_result'];

			$object['jag_module'] = $this->jagmodule;
			$object['error_code'] = '006';
			$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
			$this->template->write_view('content', 'errorweb', $object);
			$this->template->render();
		}

	}

	function delete_multiple_confirm() {

		if(!count($_POST['id_sfgs_header']))
			redirect($this->session->userdata['PAGE']['sfgs_browse_result']);

		$j = 0;
		for($i = 1; $i <= $_POST['count']; $i++) {
      if(!empty($_POST['id_sfgs_header'][$i])) {
				$object['data']['sfgs_headers'][$j++] = $this->m_sfgs->sfgs_header_select($_POST['id_sfgs_header'][$i]);
			}
		}

		$this->template->write_view('content', 'sfgs/sfgs_delete_multiple_confirm', $object);
		$this->template->render();

	}

	function delete_multiple_execute() {

		$this->db->trans_start();
		for($i = 1; $i <= $_POST['count']; $i++) {
			$this->_delete($_POST['id_sfgs_header'][$i]);
		}
		$this->db->trans_complete();


		$object['refresh'] = 1;
		$object['refresh_text'] = 'Data Master Semi Finished Goods (SFG) BOM berhasil dihapus';
		$object['refresh_url'] = $this->session->userdata['PAGE']['sfgs_browse_result'];
		//redirect('member_browse');

		$this->template->write_view('content', 'refresh', $object);
		$this->template->render();

	}

  	function file_import() {

		$config['upload_path'] = './excel_upload/';
		$config['file_name'] = 'sfgs_data';
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
            $file =  $_SERVER['DOCUMENT_ROOT'].'/portalja/excel_upload/'.$upload['file_name'];
            else
            $file =  $_SERVER['DOCUMENT_ROOT'].'/excel_upload/'.$upload['file_name'];

			$this->session->set_userdata('file_upload', $file);
			$this->session->set_userdata('filename_upload', $upload['file_name']);

//			echo $this->session->userdata('file_upload');

			$this->excel_reader->read($file);

			// Sheet 1
			$excel = $this->excel_reader->sheets[0] ;

		 	if($excel['cells'][1][1] == 'SFG Item No.' && $excel['cells'][1][2] == 'SFG Quantity') {

				$j = 0; // grpo_header number, started from 1, 0 assume no data
				for ($i = 2; $i <= $excel['numRows']; $i++) {
					$x = $i - 1; // to check, is it same grpo header?

					$kode_sfg = $excel['cells'][$i][1];
					$quantity_sfg = $excel['cells'][$i][2];
                    $material_no =  $excel['cells'][$i][3];
					$quantity = $excel['cells'][$i][4];
					$plant = $excel['cells'][$i][5];
            	    if(empty($plant)) {
            	      $plant = $this->session->userdata['ADMIN']['plant'];
            	    }
					// check grpo header
					if(($excel['cells'][$i][1] != $excel['cells'][$x][1])||($excel['cells'][$i][5] != $excel['cells'][$x][5])) {

                        $j++;
				   //		if($sfgs_header_temp = $this->m_general->sap_item_groups_select_all_sfgs()) {

                            //echo "<pre>";
                            //print_r($sfgs_header_temp);
                            //echo "</pre>";
                            $object['sfgs_headers'][$j]['kode_sfg'] = $kode_sfg;
                            $item_temp = $this->m_general->sap_item_select_by_item_code($excel['cells'][$i][1]);
                            $object['sfgs_headers'][$j]['nama_sfg'] = $item_temp['MAKTX'];
                            $object['sfgs_headers'][$j]['quantity_sfg'] = $quantity_sfg;
                            $object['sfgs_headers'][$j]['uom_sfg'] = $item_temp['UNIT'];
							$object['sfgs_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
							$object['sfgs_headers'][$j]['filename'] = $upload['file_name'];
							$object['sfgs_headers'][$j]['plant'] = $plant;

                        	$sfgs_header_exist = TRUE;
							$k = 1; // grpo_detail number
				 //		} else {
//            	$sfgs_header_exist = FALSE;
//						}
					}

					if($sfgs_header_exist) {

						if($sfgs_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {

							$object['sfgs_details'][$j][$k]['id_sfgs_h_detail'] = $k;
							$object['sfgs_details'][$j][$k]['material_no'] = $material_no;
							$object['sfgs_details'][$j][$k]['material_desc'] = $sfgs_detail_temp['MAKTX'];
							$object['sfgs_details'][$j][$k]['quantity'] = $quantity;
                            $uom_import = $sfgs_detail_temp['UNIT'];
                            if(strcasecmp($uom_import,'KG')==0) {
                              $uom_import = 'G';
                            }
                            if(strcasecmp($uom_import,'L')==0) {
                              $uom_import = 'ML';
                            }
                			$object['sfgs_details'][$j][$k]['uom'] = $uom_import;

							$k++;
						}

					}

				}

				$this->template->write_view('content', 'sfgs/sfgs_file_import_confirm', $object);
				$this->template->render();

			} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Master Semi Finished Goods (SFG) BOM atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'sfgs/browse_result/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '007';
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
	   	if($excel['cells'][1][1] == 'SFG Item No.' && $excel['cells'][1][2] == 'SFG Quantity') {

			$this->db->trans_start();

			$j = 0; // grpo_header number, started from 1, 0 assume no data
			for ($i = 2; $i <= $excel['numRows']; $i++) {
				$x = $i - 1; // to check, is it same grpo header?

				$kode_sfg = $excel['cells'][$i][1];
				$quantity_sfg = $excel['cells'][$i][2];
    			$material_no =  $excel['cells'][$i][3];
    			$quantity = $excel['cells'][$i][4];
            	$plant = $excel['cells'][$i][5];
                if(empty($plant)) {
                  $plant = $this->session->userdata['ADMIN']['plant'];
                }


				// check grpo header
				if(($excel['cells'][$i][1] != $excel['cells'][$x][1])||($excel['cells'][$i][5] != $excel['cells'][$x][5])) {

                        $sfgs_header = $this->m_sfgs->sfgs_header_select_by_kode_sfg($kode_sfg,$plant);
                        if ($sfgs_header!=FALSE) {
                          $this->m_sfgs->sfgs_header_delete_multiple($sfgs_header);
                        }
                        $j++;
				  // 	if($sfgs_detail_temp = $this->m_general->sap_item_groups_select_all_sfgs()) {
                        $object['sfgs_headers'][$j]['plant'] = $plant;
                        $object['sfgs_headers'][$j]['kode_sfg'] = $excel['cells'][$i][1];
                        $item_temp = $this->m_general->sap_item_select_by_item_code($excel['cells'][$i][1]);
                        $object['sfgs_headers'][$j]['nama_sfg'] = $item_temp['MAKTX'];
                        $object['sfgs_headers'][$j]['quantity_sfg'] = $quantity_sfg;
                        $object['sfgs_headers'][$j]['uom_sfg'] = $item_temp['UNIT'];
					    $object['sfgs_headers'][$j]['id_user_input'] = $this->session->userdata['ADMIN']['admin_id'];
					    $object['sfgs_headers'][$j]['filename'] = $this->session->userdata('filename_upload');

						$id_sfgs_header = $this->m_sfgs->sfgs_header_insert($object['sfgs_headers'][$j]);

                       	$sfgs_header_exist = TRUE;
						$k = 1; // grpo_detail number

			  //		} else {
           //	$sfgs_header_exist = FALSE;
			//		}
				}

				if($sfgs_header_exist) {

					if($sfgs_detail_temp = $this->m_general->sap_item_select_by_item_code($material_no)) {
                        $object['sfgs_details'][$j][$k]['id_sfgs_header'] = $id_sfgs_header;
						$object['sfgs_details'][$j][$k]['id_sfgs_h_detail'] = $k;
						$object['sfgs_details'][$j][$k]['material_no'] = $material_no;
						$object['sfgs_details'][$j][$k]['material_desc'] = $sfgs_detail_temp['MAKTX'];
   					    $object['sfgs_details'][$j][$k]['quantity'] = $quantity;

                        $uom_import = $sfgs_detail_temp['UNIT'];
                        if(strcasecmp($uom_import,'KG')==0) {
                          $uom_import = 'G';
                        }
                        if(strcasecmp($uom_import,'L')==0) {
                          $uom_import = 'ML';
                        }
            			$object['sfgs_details'][$j][$k]['uom'] = $uom_import;

						$id_sfgs_detail = $this->m_sfgs->sfgs_detail_insert($object['sfgs_details'][$j][$k]);

						$k++;
					}

				}

			}

			$this->db->trans_complete();

			$object['refresh'] = 1;
			$object['refresh_text'] = 'Data  Master Semi Finished Goods (SFG) BOM  berhasil di-upload';
			$object['refresh_url'] = $this->session->userdata['PAGE']['sfgs_browse_result'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		} else {

				$object['refresh_text'] = 'File Excel yang Anda upload bukan file Master Semi Finished Goods (SFG) BOM atau file tersebut rusak. Umumnya karena di dalam file diberi warna baik pada teks maupun cell. Harap periksa kembali file Excel Anda.<br><br>SARAN: Coba pilih semua teks dan ubah warna menjadi "Automatic". Sebaiknya tidak ada warna pada teks, kolom dan baris dalam file Excel Anda.';
				$object['refresh_url'] = 'sfgs/browse_result/0/0/0/0/10';
				$object['jag_module'] = $this->jagmodule;
				$object['error_code'] = '008';
				$object['page_title'] = 'Error '.strtoupper($object['jag_module']['web_module']).': '.$object['jag_module']['web_trans'];
				$this->template->write_view('content', 'errorweb', $object);
				$this->template->render();

		}

	}

}
?>