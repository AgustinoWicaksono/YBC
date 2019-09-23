<?php
/**
 * Cron Job Model
 * This model class related to automatic system on this website
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */
class M_cron extends Model {

	/**
	 * Cron Job Model
	 * This model class related to automatic system on this website
	 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
	 */
	function M_cron() {
		parent::Model();
		$this->obj =& get_instance();
	}

	/**
	 * Get one row of member import sent status data.
	 * @return array Array of member data
	 */
	function member_import_sent_status_select($message_frequency) {
		$this->db->from('z_member_import');
		$this->db->where('member_sent_status', 0);
		$this->db->where('message_frequency', $message_frequency);
		$this->db->order_by('joined');
		$this->db->limit(1);

		$query = $this->db->get();
		
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}
	
	/**
	 * Count member sent status data, which not yet reported to moderator
	 * @return int Amount of members
	 */
	function member_import_sent_status_not_syn_count() {
		$this->db->from('z_member_import');
		$this->db->where('member_sent_status', 1);
		$this->db->where('moderator_sent_status', 0);
		$this->db->order_by('joined');

		$query = $this->db->get();

		return $query->num_rows();
	}

	/**
	 * Get member sent status data, which not yet reported to moderator
	 * @return array Array of member data
	 */
	function member_import_sent_status_not_syn_select() {
		$this->db->from('z_member_import');
		$this->db->where('member_sent_status', 1);
		$this->db->where('moderator_sent_status', 0);
		$this->db->order_by('joined');

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	/**
	 * Update member import data.
	 * @param array $data Member data
	 * @return boolean
	 */
	function member_import_update($data) {
		$this->db->where('member_id', $data['member_id']);

		if($this->db->update('z_member_import', $data))
			return TRUE;
		else
			return FALSE;
	}

}

/* End of file m_config.php */
/* Location: ./system/application/models/m_config.php */