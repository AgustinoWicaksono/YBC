<?php
class Perm extends Controller {
	private $jagmodule = array();


	function Perm() {
		parent::Controller();
		$this->jagmodule = $this->m_config->system_web_module(1071);  //get module data from module ID
		

		if(!$this->l_auth->is_logged_in()) {
//			$this->l_auth->save_referer_and_login();
			$this->l_page->save_page_and_login('login_redirect');
		}

 		if(!$this->l_auth->is_have_perm('masterdata_perm'))
			redirect('');

	$this->l_auth->startup();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('m_perm');

		$this->lang->load('form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_form_validation', $this->session->userdata('lang_name'));
		$this->lang->load('g_general', $this->session->userdata('lang_name'));
		$this->lang->load('g_perm',$this->session->userdata('lang_name'));
		$this->lang->load('g_button', $this->session->userdata('lang_name'));
	}

	function index() {
		$this->group_browse();
	}

	function group_browse() {

		// start of check page permission
		$perm_codes = array (
      'perm_group_browse_name_all',
			'perm_group_browse_detail_all',
		);

		if(!$this->l_auth->is_have_perm($perm_codes))
			redirect('');
		// end of check page permission

		// start of content permissions
		$object['perm_codes']['own'] = array (
			'perm_group_view_name_own',
		);

		$object['perm_codes']['view'] = array (
			'perm_group_view_detail_own',
			'perm_group_view_name_all',
			'perm_group_view_detail_all',
		);

		$object['perm_codes']['edit'] = array (
			'perm_group_edit_name_all',
			'perm_group_edit_detail_all',
		);

		$object['perm_codes']['delete'] = array (
			'perm_group_delete_all',
		);

		$object['perm_codes']['add'] = array (
			'perm_group_add_all',
		);

		$object['perm_codes2'] = $this->l_auth->perm_code_merge($object['perm_codes']);
		// end of content permissions

		$object['data']['perm_groups'] = $this->m_perm->perm_groups_select_all();
		$object['perms'] = $this->m_perm->perms_select_all();

		// save this page to referer
		$this->l_page->save_page('next');

/*
		$i = 1;
		foreach ($object['data']['perm_groups']->result_array() as $data['perm_group']) {
			$object['data']['perm_group'][$i] = $data['perm_group'];
    	$i++;
		}

		$i = 1;
		foreach ($object['perms']->result_array() as $perm) {
			$object['perm'][$i] = $perm;
    	$i++;
		}


		$i = 0;
		foreach ($object['perms'] as $perm) {

			$j = $perm['cat_id'];

			$object['data']['perm_group'][$i]['group_id'] = $perm['group_id'];

			$perm['have_category'][$i] = 0;

			if($j != $i) {
				if ($i != 0)
					echo "<br />";
				echo "<strong>".$this->lang->line('perm_opt_category_'.$perm['category_name'])."</strong>\n<br />";
			}

			if(substr_count($perm_group['group_perms'], $perm['category_code'].sprintf("%02s", $perm['perm_code']))) {

				echo $this->lang->line('perm_opt_'.$perm['perm_name'])."<br />";

			}

			$i = $j;
		}
*/

		$this->template->write_view('content', 'perm/group_browse', $object);
		$this->template->render();
	}

	function group_add()	{

		// start of check page permission
		$perm_codes = array (
      'perm_group_add_all',
		);

		if(!$this->l_auth->is_have_perm($perm_codes))
			redirect('');
		// end of check page permission

		$this->_group_check();

		if ($this->form_validation->run() == FALSE) {

    	if(!empty($_POST)) {
    		$data = $_POST;
  			$this->_group_form(0, $data);
    	} else {
				$this->l_page->save_page('next', 'referer');
  			$this->_group_form();
      }

		} else {
			$this->_group_add();
		}

	}

	function group_view($group_id) {
		// start of check page permission
		$perm_codes = array (
      'perm_group_view_name_all',
			'perm_group_view_detail_all',
		);

		if(!$this->l_auth->is_have_perm($perm_codes))
			redirect('');
		// end of check page permission

		$object['group_id'] = $group_id;
		$object['data'] = $this->m_perm->perm_group_select($group_id);
		$object['perms'] = $this->m_perm->perms_select_all();
		$this->template->write_view('content', 'perm/group_view', $object);
		$this->template->render();
	}

	function group_edit() {

		// start of check page permission
		$perm_codes = array (
			'perm_group_edit_name_all',
			'perm_group_edit_detail_all',
		);

		if(!$this->l_auth->is_have_perm($perm_codes))
			redirect('');
		// end of check page permission

		$this->_group_check();

		if ($this->form_validation->run() == FALSE) {

    	if(!empty($_POST)) {
    		$data = $_POST;
  			$this->_group_form(0, $data);
    	} else {
				$this->l_page->save_page('next', 'referer');
        $data = $this->m_perm->perm_group_select($this->uri->segment(3));
  			$this->_group_form(0, $data);
      }

		} else {
			$this->_group_update();
    }

	}

	function group_delete($group_id) {

		$group_id = (int) $group_id;

		// start of check page permission
		$perm_codes = array (
			'perm_group_delete_all',
		);

		if(!$this->l_auth->is_have_perm($perm_codes))
			redirect('');
		// end of check page permission

		$this->m_perm->perm_group_delete($group_id);

		redirect($this->session->userdata['PAGE']['next']);
	}

/*
	function group_view() {

		// start of check page permission
		$perm_codes = array (
			'perm_group_view_all_name',
			'perm_group_edit_all_detail',
		);

		if(!$this->l_auth->is_have_perm($perm_codes))
			redirect('');
		// end of check page permission

		$this->_group_check();

		if ($this->form_validation->run() == FALSE) {

    	if(!empty($_POST)) {
    		$data = $_POST;
  			$this->_group_form(0, $data);
    	} else {
        $data = $this->m_perm->perm_group_select($this->uri->segment(3));
  			$this->_group_form(0, $data);
      }

		} else {
			$this->_group_update();
    }

	}
*/
	function _group_check() {
		$this->form_validation->set_rules('group_name', $this->lang->line('perm_group_name'), 'trim|required');
	}

	function _group_form($reset=0, $data=NULL) {
    // if want to add group permission to the database,
    // reset the contents of the form
    // $reset = 1
    $object['reset'] = $reset;

    // if $data exist, add to the $object array
    if($data != NULL) {
      $object['data'] = $data;
			$object['page_title'] = $this->lang->line('perm_group_perm_edit');
    } else {
      $object['data'] = NULL;

      // For add data, assign the default variable here
//      $object['data']['stock_type'] = 2;
			$object['new'] = 1;
			$object['page_title'] = $this->lang->line('perm_group_perm_add');
    }

		$object['perms'] = $this->m_perm->perms_select_all();
		$this->template->write_view('content', 'perm/group_form', $object);
		$this->template->render();
	}

	function _group_add() {
		// start assign member data and delete not used vars
		$group = $_POST;
		unset($group['group_id']);
		unset($group['submit']);

		$group['group_perms'] = '';

		foreach($group['perm'] as $perm) {
			if(!empty($perm))
				$group['group_perms'] .= $perm;
		}
		unset($group['perm']);

		$group['group_order'] = $this->m_perm->perm_group_order_max_select() + 1;

		if($this->m_perm->perm_group_add($group)) {

			$object['refresh'] = 1;
			$object['refresh_text'] = sprintf($this->lang->line('redirect_member_perm_group_update_success'), $group['member_name']);
			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		}
		
//		$this->_group_form(1);
	}

  // update member section 1
	function _group_update()	{
		// assign group permission data and delete not used vars
		$group = $_POST;
		unset($group['submit']);
		unset($group['cancel']);

		$group['group_perms'] = '';

		foreach($group['perm'] as $perm) {
			if(!empty($perm))
				$group['group_perms'] .= $perm;
		}
		unset($group['perm']);

		if($this->m_perm->perm_group_update($group)) {
			
			$object['refresh'] = 1;
			$object['refresh_text'] = sprintf($this->lang->line('redirect_perm_group_update_success'), $group['group_name']);
			$object['refresh_url'] = $this->session->userdata['PAGE']['next'];
			//redirect('member_browse');

			$this->template->write_view('content', 'refresh', $object);
			$this->template->render();

		}
		
		//redirect('perm/group_browse');
		//$this->group_browse();
	}

	function perm_group_grant($group_id) {

		// start of check page permission
		$perm_codes = array (
			'perm_group_admin_manage_all',
		);

		if(!$this->l_auth->is_have_perm($perm_codes))
			redirect('');
		// end of check page permission

		$this->_perm_group_check();

		if ($this->form_validation->run() == FALSE) {

			if(!empty($_POST)) {
				$data = $_POST;
				$this->_perm_group_form(0, $data);
			} else {
				$this->l_page->save_page('next', 'referer');
				$data['member'] = $this->m_admin->admin_select($admin_id);
//				$data['member_perm_group_id'] = $this->m_member->member_perm_groups_select($member_id);
				$data['admin_perm_group_ids'] = $this->m_perm->admin_perm_group_ids_select($admin_id);
				$this->_perm_group_form(0, $data);
			}

		} else {
			$this->_perm_group_update();
		}

	}

}

/* End of file perm.php */