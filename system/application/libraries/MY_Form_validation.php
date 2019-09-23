<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	/**
	 * Must Choose (Radio/Dropdown)
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function valid_choose($str)
	{
		if(empty($str))
			return FALSE;
		else
			return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Valid Date Format (DD-MM-YYYY or DD/MM/YYYY)
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function valid_date_ddmmyyyy($str) {
		if(strlen($str) != 10)
			return FALSE;

		if(!(substr($str, 2, 1) == '-' || substr($str, 2, 1) == '/'))
			return FALSE;

		if(!(substr($str, 5, 1) == '-' || substr($str, 5, 1) == '/'))
			return FALSE;

		$day = substr($str, 0, 2);
		$month = substr($str, 3, 2);
		$year = substr($str, 6, 4);

		if(checkdate($month, $day, $year))
			return TRUE;
		else
			return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Email exist on the database, on d_member_email table
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function email_exist($str) {
		$this->CI->load->model('m_member');
		if($this->CI->m_member->check_email_available($str))
			return TRUE;
		else
			return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Current login password is right. It's used to change password.
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function admin_password_old_right($str) {
		$this->CI->load->model('m_admin');
		if($this->CI->m_admin->check_password($str))
			return TRUE;
		else
			return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Check captcha code.
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function captcha($str) {
//		if($str == $this->CI->session->userdata('captcha'))
//		if($_SESSION['captcha'] == $str)
//		echo "CAPTCHA: ".$_SESSION['captcha'];
//		echo " str: ".$str;
//		if($str == $_SESSION['captcha'])
		if($str == $this->CI->session->userdata('captcha'))
			return TRUE;
		else
			return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Valid Password
	 * must contain minimal 8 characters, combination of alfabets and numbers
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function valid_password($str) {
		if(preg_match("/^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{8,}$/", $str))
			return TRUE;
		else
			return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Valid GR Quantity (less than outstanding quantity)
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function valid_quantity($arr) {
		if($arr['gr_quantity'] > $arr['outstanding_qty'])
			return FALSE;
		else
			return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Check, at least one quantity exist
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function quantity_exist($arr) {
		if($arr['gr_qty'] > $arr['outstanding_qty'])
			return FALSE;
		else
			return TRUE;
	}

	// --------------------------------------------------------------------

    /**
     * Is Numeric no zero
     *
     * @access    public
     * @param    string
     * @return    bool
     */
    function is_numeric_no_zero($str)
    {
        return ((is_numeric($str))&&(((float)$str)>0)) ? TRUE : FALSE;
    }

	// --------------------------------------------------------------------
}
