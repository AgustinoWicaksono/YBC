<?php
/**
 * Synchronize Model
 * This model class used to synchronize between MySQL and MS SQL data
 * This Model for MySQL
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */

class M_sinkron_mssql extends Model {

  # the mysql db instance
  private $_db = NULL;

	/**
	 * Synchronize Model
	 * This model class used to synchronize between MySQL and MS SQL data
	 * This Model for MySQL
	 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
	 */



	function M_sinkron_mssql() {
		parent::Model();
		$this->obj =& get_instance();
        $this->_db = $this->load->database('mssql', TRUE);
		$this->load->library('l_general');
        $this->load->library('msdb');
	}

	function employee_select_all() {
		$this->_db->from('v_m_pegawai_web_phpcompliant');
		$this->_db->order_by('nik');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function employee_select_by_nik($nik) {
		$this->_db->from('m_pegawai');
		$this->_db->where('NoPeg',$nik);

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function outlet_select_all() {
		$this->_db->from('v_m_outlet');
		$this->_db->order_by('kode_cabang');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function emp_status_select_all() {
		$this->_db->from('m_employeestatus');
		$this->_db->order_by('employeestatus_id');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function divisi_select_all() {
		$this->_db->from('m_divisi');
		$this->_db->order_by('nama_divisi');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function bagian_select_all() {
		$this->_db->from('m_bagian');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function dept_select_all() {
		$this->_db->from('m_dept');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function jabatan_select_all() {
		$this->_db->from('m_jabatan');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function emp_education_select_all() {
		$this->_db->from('m_pendidikan');
		$this->_db->order_by('kode_pend');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function m_kehadiran_select_all() {
		$this->_db->from('m_Cuti');
		$this->_db->order_by('KdAbsen');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function m_cuti_ph_select_all() {
		$this->_db->from('v_m_cuti_ph');
		$this->_db->order_by('nik');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function working_shift_select_all() {
		$this->_db->from('v_msshiftweb');
		$this->_db->order_by('kdcabang');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

    function t_employee_update_cuti($data) {
       $data1['CutiSkr'] = $data['saldo_cuti'];
       $data1['CutiHutang'] = $data['saldo_cutihutang'];
       $this->_db->where('NoPeg', $data['nik']);
       $this->_db->update('m_pegawai', $data1);
    }

    function t_requestkaryawan_insert_update($data) {

        $employee = $this->employee_select_by_nik($data['requestby']);

        if($data['req_type'] == 'Additional')
           $reg_type = 0;
        else
           $reg_type = 1;

        if($data['req_kelamin'] == 'Pria')
           $reg_kelamin = 0;
        else if($data['req_kelamin'] == 'Wanita')
           $reg_kelamin = 1;
        else
           $reg_kelamin = 2;

        if($data['req_marital'] == 'SINGLE')
           $req_marital = 0;
        else if($data['req_marital'] == 'MARIED')
           $req_marital = 1;
        else if($data['req_marital'] == 'WIDOW')
           $req_marital = 2;

        $data1 = array(
          'tglrequest'=>$data['req_date'],
          'requestby'=>$data['requestby'],
          'kode_cabang'=>$this->session->userdata['ADMIN']['hr_plant_code'],
          'kode_divisi'=>$data['req_divisi'],
          'kode_bagian'=>$data['req_bagian'],
          'kode_dept'=>$data['req_dept'],
          'kode_job'=>$data['req_jabatan'],
          'employeestatus_id'=>$data['req_status_kerja'],
          'alasan'=>$reg_type,
          'jmlh_permintaan'=>$data['req_jumlah'],
          'mulai_bekerja'=>$data['req_start_date'],
          'gender'=>$reg_kelamin,
          'status'=>$req_marital,
          '[b.degree]'=>$data['req_education'],
          'umur'=>$data['req_umur'],
          'keahlian'=>$data['req_pengalaman'],
          'lain_lain'=>$data['req_others'],
          'id_trans_web'=>$data['employee_req_id'],
          'proses'=>0,
        );

      	$this->_db->from('t_requestkaryawan');
      	$this->_db->where('id_trans_web',$data['employee_req_id']);

      	$query = $this->_db->get();

        if($query->num_rows() > 0) {
            $this->_db->where('id_trans_web', $data1['employee_req_id']);
            $this->_db->update('t_requestkaryawan', $data1);
        } else {
            $result = $this->msdb->output('S_Sel_Gen_Reg', array('table_name'=>'t_requestkaryawan', 'key_field_name'=>'norequest', 'transdate'=>$data1['tglrequest'] ), 'SELECT');
            $data1['norequest'] = $result[0]['regno'];
            $this->_db->insert('t_requestkaryawan', $data1);

    		$swbquery1 = "UPDATE t_requestkaryawan SET proses = 1, filter = (SELECT TOP 1 filter FROM t_filtertmp) WHERE norequest = '".$data1['norequest']."'";
	    	$this->_db->query($swbquery1);
        }
    }

	function employee_req_hrms_select_by_date($date_from, $date_to, $plant) {

		$plants = $this->m_perm->admin_plants_select($this->session->userdata['ADMIN']['admin_id']);
		if($plants !== FALSE) {
			foreach ($plants as $plant1) {
 			  $plant_all[] = $plant1['HR_CODE'];
			}
		}

		$this->_db->from('v_rptempreqweb');
        if($plant=='ALL')
    		$this->_db->where_in('outlet', $plant_all);
        else
    		$this->_db->where('replace(outlet, "&","") =', $plant);
		$this->_db->where("req_date BETWEEN '".$date_from."' AND '".$date_to."'");
		$this->_db->order_by('req_date');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

    function t_kehadiran_insert($datas) {
        if(!empty($datas)) {
          foreach($datas as $data) {
        	$this->_db->from('t_kehadirankaryawan');
        	$this->_db->where('tanggal',$data['tanggal']);
        	$this->_db->where('kode_cabang',$data['cabang']);
        	$this->_db->where('NoPeg',$data['nik']);

        	$query = $this->_db->get();

            $data1 = array(
              'tanggal'=>$data['tanggal'],
              'kode_cabang'=>strtoupper($data['cabang']),
              'NoPeg'=>$data['nik'],
              'shift'=>$data['shift'],
              'schedule_on'=>$data['shift_in'],
              'schedule_off'=>$data['shift_out'],
              'schedule_break_on'=>$data['shift_break_in'],
              'schedule_break_off'=>$data['shift_break_out'],
              'kode_aktual'=>$data['kd_aktual'],
              'kode_schedule'=>$data['kd_aktual'],
              'kode_cuti'=>$data['kd_cuti'],
              'kode_actual_import'=>$data['kd_aktual_temp'],
              'kode_schedule_import'=>$data['kode_schedule_import'],
              'time_on'=>$data['in'],
              'break_out'=>$data['break_out'],
              'break_in'=>$data['break_in'],
              'time_out'=>$data['out'],
              'ftransport'=>$data['ftransport'],
              'proses'=>1,
            );
            if($query->num_rows() > 0) {
            	$this->_db->where('tanggal',$data['tanggal']);
            	$this->_db->where('kode_cabang',strtoupper($data['cabang']));
            	$this->_db->where('NoPeg',$data['nik']);
        		$this->_db->delete('t_kehadirankaryawan');
            }
            $this->_db->insert('t_kehadirankaryawan', $data1);
          }
        }
    }

	function m_schedule_pembayaran() {
		$this->_db->from('V_m_schedulepembayaran');
		$this->_db->order_by('kode_grouppembayaran');
		$this->_db->order_by('period');

		$query = $this->_db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

}