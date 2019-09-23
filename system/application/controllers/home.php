<?php

class Home extends Controller {
	private $jagmodule = array();


	function Home()	{
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1064);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

		$this->l_auth->startup();

	}

	function index() {
		$object['page_title'] = "Selamat Datang";
		$this->load->model('m_menu');
		$this->load->model('m_gisto');
		$this->load->model('m_gisto_dept');
		$this->load->model('m_gistonew_out');
        $this->load->model('m_grpo');
		$this->load->model('m_grpodlv');
		$this->load->model('m_grpodlv_dept');
		$this->load->model('m_stockoutlet');
		$this->load->model('m_grsto');
		$this->load->model('m_waste');
		$this->load->model('m_grnonpo');
		$this->load->model('m_nonstdstock');
		$this->load->model('m_stdstock');
		$this->load->model('m_grfg');
		$this->load->model('m_tssck');
		$this->load->model('m_prodstaff');
		$this->load->model('m_trend_utility');
		$this->load->model('m_gitcc');
		$this->load->model('m_posinc');
		$this->load->model('m_general');
		$this->load->model('m_home');
		$this->load->model('m_posisi');
		$this->load->model('m_retin');
		$this->load->model('m_issue');
		$this->load->model('m_produksi');
		$this->load->model('m_pr');
		$this->load->model('m_poouts');
		$this->load->model('m_database');
		//$this->load->model('m_opname');
//		$object['page'] = $this->m_menu->get_menu_list();
		//echo '('.$this->m_database->get_mysql('hostname',TRUE).')';
		//echo '('.$this->m_database->get_sql().')';

        $posting_date = date("Y-m-d",strtotime($this->m_general->posting_date_select_max()));

		$object['data']['gisto_count_unapproved'] = $this->m_gisto->gisto_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
		
		$object['data']['gisto_dept_count_unapproved'] = $this->m_gisto_dept->gisto_dept_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
		$object['data']['gistonew_out_count_unapproved'] = $this->m_gistonew_out->gistonew_out_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//		$object['data']['gisto_count'] = $this->m_gisto->gisto_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
		$object['data']['grpo_count_unapproved'] = $this->m_grpo->grpo_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//		$object['data']['grpo_count'] = $this->m_grpo->grpo_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
		$object['data']['grpodlv_count_unapproved'] = $this->m_grpodlv->grpodlv_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
		
		$object['data']['grpodlv_dept_count_unapproved'] = $this->m_grpodlv_dept->grpodlv_dept_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//		$object['data']['grpodlv_count'] = $this->m_grpodlv->grpodlv_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
				$object['data']['stockoutlet_count_unapproved'] = $this->m_stockoutlet->stockoutlet_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//					$object['data']['stockoutlet_count'] = $this->m_stockoutlet->stockoutlet_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
				$object['data']['grsto_count_unapproved'] = $this->m_grsto->grsto_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//				$object['data']['grsto_count'] = $this->m_grsto->grsto_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
				$object['data']['waste_count_unapproved'] = $this->m_waste->waste_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//				$object['data']['waste_count'] = $this->m_waste->waste_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
				$object['data']['grnonpo_count_unapproved'] = $this->m_grnonpo->grnonpo_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);	
//					$object['data']['grnonpo_count'] = $this->m_grnonpo->grnonpo_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);						
		$object['data']['nonstdstock_count_unapproved'] = $this->m_nonstdstock->nonstdstock_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//		$object['data']['nonstdstock_count'] = $this->m_nonstdstock->nonstdstock_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
			$object['data']['stdstock_count_unapproved'] = $this->m_stdstock->stdstock_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//			$object['data']['stdstock_count'] = $this->m_stdstock->stdstock_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
			$object['data']['grfg_count_unapproved'] = $this->m_grfg->grfg_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//			$object['data']['grfg_count'] = $this->m_grfg->grfg_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
				$object['data']['tssck_count_unapproved'] = $this->m_tssck->tssck_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//				$object['data']['tssck_count'] = $this->m_tssck->tssck_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
				$object['data']['prodstaff_count_unapproved'] = $this->m_prodstaff->prodstaff_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);

//				$object['data']['prodstaff_count'] = $this->m_prodstaff->prodstaff_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
				$object['data']['gitcc_count_unapproved'] = $this->m_gitcc->gitcc_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//				$object['data']['gitcc_count'] = $this->m_gitcc->gitcc_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
				$object['data']['trend_utility_count_unapproved'] = $this->m_trend_utility->trend_utility_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
//                $object['data']['trend_utility_count'] = $this->m_trend_utility->trend_utility_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
				$object['data']['posinc_count_unapproved'] = $this->m_posinc->posinc_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				$object['data']['retin_count_unapproved'] = $this->m_retin->retin_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				$object['data']['issue_count_unapproved'] = $this->m_issue->issue_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				$object['data']['produksi_count_unapproved'] = $this->m_produksi->produksi_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				$object['data']['pr_count_unapproved'] = $this->m_pr->pr_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				//$object['data']['opname_count_unapproved'] = $this->m_opname->opname_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				//echo '{'.$object['data']['produksi_count_unapproved'].'}';
//					$object['data']['posinc_count'] = $this->m_posinc->posinc_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
//					$object['data']['posinc_count'] = $this->m_posinc->posinc_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 0, 0);
				
			//$object['data']['opname_count_sap'] = $this->m_opname->opname_headers_count_by_criteria_sap('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 1, 0);		
			$object['data']['gisto_dept_count_sap'] = $this->m_gisto_dept->gisto_dept_headers_count_by_criteria_sap('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 1, 0);
			$object['data']['gistonew_out_count_sap'] = $this->m_gistonew_out->gistonew_out_headers_count_by_criteria_sap('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 1, 0);
			$object['data']['grpo_count_sap'] = $this->m_grpo->grpo_headers_count_by_criteria_sap('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 1, 0);
			$object['data']['grpodlv_count_sap'] = $this->m_grpodlv->grpodlv_headers_count_by_criteria_sap('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 1, 0);
				//$object['data']['grpodlv_dept_count_unapproved'] = $this->m_grpodlv_dept->grpodlv_dept_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				//$object['data']['stockoutlet_count_unapproved'] = $this->m_stockoutlet->stockoutlet_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
			$object['data']['grsto_count_sap'] = $this->m_grsto->grsto_headers_count_by_criteria_sap('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 1, 0);
			$object['data']['waste_count_sap'] = $this->m_waste->waste_headers_count_by_criteria_sap('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 1, 0);
				//$object['data']['grnonpo_count_unapproved'] = $this->m_grnonpo->grnonpo_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				//$object['data']['nonstdstock_count_unapproved'] = $this->m_nonstdstock->nonstdstock_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				//$object['data']['stdstock_count_unapproved'] = $this->m_stdstock->stdstock_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				//$object['data']['grfg_count_unapproved'] = $this->m_grfg->grfg_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				//$object['data']['tssck_count_unapproved'] = $this->m_tssck->tssck_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				//$object['data']['prodstaff_count_unapproved'] = $this->m_prodstaff->prodstaff_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				//$object['data']['gitcc_count_unapproved'] = $this->m_gitcc->gitcc_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				//$object['data']['trend_utility_count_unapproved'] = $this->m_trend_utility->trend_utility_headers_count_by_criteria('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
				//$object['data']['posinc_count_unapproved'] = $this->m_posinc->posinc_headers_count_by_criteria('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 0);
			$object['data']['retin_count_sap'] = $this->m_retin->retin_headers_count_by_criteria_sap('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 1, 0);
			$object['data']['issue_count_sap'] = $this->m_issue->issue_headers_count_by_criteria_sap('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 1, 0);
			$object['data']['produksi_count_sap'] = $this->m_produksi->produksi_headers_count_by_criteria_sap('a', 'part', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 1,0);
			$object['data']['pr_count_sap'] = $this->m_pr->pr_headers_count_by_criteria_sap('a', '0', 0, $posting_date." 00:00:00", $posting_date." 23:59:59", 1, 1, 0);






        $posting_date = date("Ymd",strtotime($this->m_general->posting_date_select_max()));

		$object['link']['gisto_count_unapproved'] = 'gisto/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['gisto_dept_count_unapproved'] = 'gisto_dept/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['gistonew_out_count_unapproved'] = 'gistonew_out/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['grpo_count_unapproved'] = 'grpo/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['grpodlv_count_unapproved'] = 'grpodlv/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['stockoutlet_count_unapproved'] = 'stockoutlet/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['grsto_count_unapproved'] = 'grsto/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['waste_count_unapproved'] = 'waste/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['grnonpo_count_unapproved'] = 'grnonpo/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['nonstdstock_count_unapproved'] = 'nonstdstock/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['stdstock_count_unapproved'] = 'stdstock/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['grfg_count_unapproved'] = 'grfg/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['tssck_count_unapproved'] = 'tssck/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['gitcc_count_unapproved'] = 'gitcc/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['trend_utility_count_unapproved'] = 'trend_utility/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['prodstaff_count_unapproved'] = 'prodstaff/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['posinc_count_unapproved'] = 'posinc/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['grpodlv_dept_count_unapproved'] = 'grpodlv_dept/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['retin_count_unapproved'] = 'retin/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['issue_count_unapproved'] = 'issue/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['produksi_count_unapproved'] = 'produksi/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['pr_count_unapproved'] = 'pr/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		
		$object['link']['gisto_dept_count_sap'] = 'gisto_dept/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['gistonew_out_count_sap'] = 'gistonew_out/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['grpo_count_sap'] = 'grpo/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['grpodlv_count_sap'] = 'grpodlv/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
			//$object['link']['stockoutlet_count_unapproved'] = 'stockoutlet/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['grsto_count_sap'] = 'grsto/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['waste_count_sap'] = 'waste/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
			//$object['link']['grnonpo_count_unapproved'] = 'grnonpo/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
			//$object['link']['nonstdstock_count_unapproved'] = 'nonstdstock/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
			//$object['link']['stdstock_count_unapproved'] = 'stdstock/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
			//$object['link']['grfg_count_unapproved'] = 'grfg/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
			//$object['link']['tssck_count_unapproved'] = 'tssck/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
			//$object['link']['prodstaff_count_unapproved'] = 'prodstaff/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
			//$object['link']['gitcc_count_unapproved'] = 'gitcc/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
			//$object['link']['trend_utility_count_unapproved'] = 'trend_utility/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
			//$object['link']['posinc_count_unapproved'] = 'posinc/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
			//$object['link']['grpodlv_dept_count_unapproved'] = 'grpodlv_dept/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['retin_count_sap'] = 'retin/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['issue_count_sap'] = 'issue/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['produksi_count_sap'] = 'produksi/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		$object['link']['pr_count_sap'] = 'pr/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		
		//$object['link']['opname_count_unapproved'] = 'opname/browse_result/a/part/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		//$object['link']['opname_count_sap'] = 'opname/browse_result/a/0/0/'.$posting_date.'/'.$posting_date.'/1/0/10';
		


	$object['data']['po_count_outstanding'] = $this->m_home->home_po_vendor_outstanding();
	$object['link']['po_count_outstanding'] = 'grpo/input';
	
	//$object['data']['grpodlv_dept_count'] = $this->m_home->grpodlv_dept();
	//$object['link']['grpodlv_dept_count'] = 'grpodlv_dept/input';
	
	$object['data']['grpodlv_count'] = $this->m_home->grpodlv();
	//echo '{'.$object['data']['grpodlv_count'].'}';
	$object['link']['grpodlv_count'] = 'grpodlv/input';
	
	$object['data']['grsto_count'] = $this->m_home->grsto();
	$object['link']['grsto_count'] = 'grsto/input';
	
	$object['data']['retin_count'] = $this->m_home->retin();
	$object['link']['retin_count'] = 'retin/input';
	
	$object['data']['gistonew_out_count'] = $this->m_home->gistonew_out();
	$object['link']['gistonew_out_count'] = 'gistonew_out/input';
	
	$object['data']['error_log'] = $this->m_home->error_log();
	$object['link']['error_log'] = 'posisi/browse_result/0/0/0/0/0/0/0/20';
	
	$object['data']['item_agging'] = $this->m_home->item_agging();
	$object['link']['item_agging'] = 'agging/browse_result/40';
	
	$object['data']['poouts'] = $this->m_poouts->poouts_select_all_count();
	//echo '{'.$object['data']['item_agging'].'}';
	$object['link']['poouts'] = 'poouts/browse_result/40';

//	$object['data']['posto_count_outstanding'] = $this->m_home->home_posto_do_ck_outstanding();
//	$object['link']['posto_count_outstanding'] = 'grpodlv/input';
	

		$this->template->write_view('content', 'home/index', $object);
		$this->template->render();
	}

}

/* End of file home.php */
/* Location: ./system/application/controller/home.php */