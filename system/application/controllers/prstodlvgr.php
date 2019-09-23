<?php
class prstodlvgr extends Controller {
	private $jagmodule = array();


	function prstodlvgr() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1046);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		if(!$this->l_auth->is_have_perm('report_prstodlvgr'))
			redirect('');

   		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('l_form_validation');
		$this->load->library('l_general');
		$this->load->model('m_prstodlvgr');

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

		// start of form attributes
		$object['form1'] = array(
			'name'	=>	'form1',
			'id'	=>	'form1',
			'target'	=>	'_blank',
		);
        for($i = 0; $i <= 10; $i++) {
          $backdays[$i] = $i;
        }
        $dovsgrfilter[0] = 'No';
        $dovsgrfilter[1] = 'Yes';
		$object['backdays'] = $backdays;
		$object['dovsgrfilter'] = $dovsgrfilter;
		// end of form attributes

		$object['page_title'] = 'Report PR STO vs DO vs Goods Receipt';
		$this->template->write_view('content', 'prstodlvgr/prstodlvgr_browse', $object);
		$this->template->render();

	}

	// search data
	function browse_search() {

		if(!empty($_POST['date_to'])) {
			$date = explode("-", $_POST['date_to']);
			$date_from = $date[2].$date[1].$date[0];
		} else {
			$date_from = date("Ymd", time());
		}
        $backdays = $_POST['backdays'];
        $dovsgrfilter = $_POST['dovsgrfilter'];
        if ($dovsgrfilter == '1') {
          $dovsgrfilter = 'Yes';
        } else {
          $dovsgrfilter = 'No';
        }
        $date_to = $this->l_general->date_add_day($date_from,$backdays);
		redirect('prstodlvgr/browse_result/'.$date_from."/".$date_to."/".$backdays."/".$dovsgrfilter);

	}

	// search result
	function browse_result($date_from = '', $date_to = '',$backdays,$dovsgrfilter)	{

		$this->l_page->save_page('prstodlvgr_browse_result');

		if($date_from !== '0') {
			$year = substr($date_from, 0, 4);
			$month = substr($date_from, 4, 2);
			$day = substr($date_from, 6, 2);
			$object['date_from'] = $day."-".$month."-".$year;
		    $date_from = $this->l_general->date_add_day($date_from,-1);
			$year = substr($date_from, 6, 4);
			$month = substr($date_from, 3, 2);
			$day = substr($date_from, 0, 2);
			$date_from2 = $year.'-'.$month.'-'.$day.' 00:00:00';
		} else {
//			$object['data']['date_from'] = '';
			$object['date_from'] = date("d-m-Y", now());
			$date_from2 = '0';
		}

		if($date_to !== '0') {
			$year = substr($date_to, 6, 4);
			$month = substr($date_to, 3, 2);
			$day = substr($date_to, 0, 2);
			$object['date_to'] = $day."-".$month."-".$year;
			$date_to2 = $year.'-'.$month.'-'.$day.' 23:59:59';
		} else {
			$object['date_to'] = '';
			$date_to2 = '0';
		}

		unset($year);
		unset($month);
		unset($day);

        $matnr = $this->m_prstodlvgr->prstodlvgr_select_matr($date_from2,$date_to2,$dovsgrfilter);
        $columns = 3+(($backdays+1)*4);
        $rows = count($matnr);
        $k = 0;
        for($i = 0; $i <= $rows; $i++) {
          for($j = 1; $j <= $columns; $j++) {
            if ($i == 0) {
               if ($j <= 3) {
                  switch ($j) {
                     case 1:
                           $col_title = 'Mat. Numb';
                           break;
                     case 2:
                           $col_title = 'Mat. Desc';
                           break;
                     case 3:
                           $col_title = 'UoM';
                           break;
                  }
                  $col_title_h = '&nbsp';
               } else {
                 $m = fmod($j,4);
                 if($m==0) {
                   $col_title_h = $this->l_general->date_add_day($date_from2,($j/4));
                   $col_title = 'PR';
                 } else {
                    switch ($m) {
                       case 1:
                             $col_title = 'DO';
                             break;
                       case 2:
                             $col_title = 'GR';
                             break;
                       case 3:
                             $col_title = 'DO vs GR';
                             break;
                    }
                   $col_title_h = '&nbsp';//$this->l_general->date_add_day($date_from,($j/4));//
                 }
               }
               $k++;
               $data[0][$j] = $col_title;
               $data_h[0][$k] = $col_title_h;
               if ($j <= 3) {
					switch ($j) {
                     case 1:
                           $field_name = 'MATERIAL';
                           break;
                     case 2:
                           $field_name = 'MAKTX';
                           break;
                     case 3:
                           $field_name = 'UOM';
                           break;
					}
					$col_data = $matnr[$i][$field_name];
				}
               $data[$i+1][$j] = $col_data;
		   } else {
               if ($j <= 3) {
					switch ($j) {
                     case 1:
                           $field_name = 'MATERIAL';
                           break;
                     case 2:
                           $field_name = 'MAKTX';
                           break;
                     case 3:
                           $field_name = 'UOM';
                           break;
					}
					$col_data = $matnr[$i][$field_name];
				}
               $data[$i+1][$j] = $col_data;
			}
        }
        }

		$object['backdays'] = $backdays;
		$object['days_interval'] = $days_interval;
		$object['filetime'] = $filetime;
		$object['timestamp'] = $timestamp;
		$object['data'] = $data;
		$object['data_h'] = $data_h;
		$object['data_d'] = $data_d;

		$object['page_title'] = 'Report PR STO vs DO vs Goods Receipt';

		$this->load->view('prstodlvgr/prstodlvgr_browse_result', $object);

	}

}
?>