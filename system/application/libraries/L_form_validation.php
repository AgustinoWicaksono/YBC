<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Form Validation Class
 * Build especially to catch array post data, which until now
 * I don't know hot to catch array data with
 * CI Form Validation class
 * @author Wiwid Lukiyanto <wiwid@wiwid.org>
 */

class L_form_validation {

	function L_form_validation()
	{
		$this->obj =& get_instance();
	}

	/**
	 * Set Rules
	 *
	 * This function takes an array of field names and validation
	 * rules as input, validates the info, and stores it
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	function set_rules($field, $var, $label = '', $rules = '') {
		// No reason to set rules if we have no POST data
		if (count($_POST) == 0) {
			return FALSE;
		}

		$rules_array = explode("|", $rules);

		$i = 1;

		// firstly, assume no error
		$return['error'] = FALSE;

		foreach($rules_array as $rule) {

			if(!substr_count($rule, ';')) {

				if (function_exists($rule))
				{
					$result = $rule($field);
				} else {
					$result = $this->$rule($field);
				}

				$return[$i]['result'] = $result;
				$return[$i]['rule'] = $rule;

				if($result == FALSE)
					$return['error'] = TRUE;

			} else {

				$param = explode(";", $rule);

				$count = count($param);

				if($count == 2) {

					$func = $param[0];
					$param1 = $param[1];

					if (function_exists($func))
					{
						$result = $func($field, $param1);
					} else {
						$result = $this->$func($field, $param1);
					}

				} else if($count == 3) {

					$func = $param[0];
					$param1 = $param[1];
					$param2 = $param[2];

					if (function_exists($func))
					{
						$result = $func($field, $param1, $param2);
					} else {
						$result = $this->$func($field, $param1, $param2);
					}

				}

				$return[$i]['result'] = $result;
				$return[$i]['rule'] = $func;

				if($result == FALSE)
					$return['error'] = TRUE;

			}

			$i++;
		}

		$return['field'] = $field;
		$return['var'] = $var;
		$return['label'] = $label;

		return $return;

	}

  function error_fields($check) {

		foreach($check as $checked) {
			if($checked['error'] == TRUE) {
				$return[] = $checked['var'];
			}
		}

		return $return;
	}

  function error_strings($check) {

		$this->CI->lang->load('form_validation');

		foreach($check as $checked) {
			if($checked['result'] == FALSE) {
				$return[] = $this->obj->lang->line($checked['rule']);
			}
		}

		return $return;
	}

	function validation_errors($error, $prefix = '', $suffix = '') {
		if (count($_POST) != 0) {
      if(count($error)) {
				return $prefix.'Harap isi data dengan lengkap.'.$suffix;
    	}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Valid GR Quantity (less than outstanding quantity)
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function valid_quantity($str, $field) {
		if($str > $field)
			return FALSE;
		else
			return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Valid Lead Time (less than outstanding quantity)
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function valid_lead_time($str, $field) {
		if($field < $str)
			return FALSE;
		else
			return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Required
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function required($str)
	{
		if($str == '')
			return FALSE;
		else
			return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Match one field to another
	 *
	 * @access	public
	 * @param	string
	 * @param	field
	 * @return	bool
	 */
	function matches($str, $field)
	{
		if ( ! isset($field))
		{
			return FALSE;
		}

		return ($str !== $field) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Minimum Length
	 *
	 * @access	public
	 * @param	string
	 * @param	value
	 * @return	bool
	 */
	function min_length($str, $val)
	{
		if (preg_match("/[^0-9]/", $val))
		{
			return FALSE;
		}

		if (function_exists('mb_strlen'))
		{
			return (mb_strlen($str) < $val) ? FALSE : TRUE;
		}

		return (strlen($str) < $val) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Max Length
	 *
	 * @access	public
	 * @param	string
	 * @param	value
	 * @return	bool
	 */
	function max_length($str, $val)
	{
		if (preg_match("/[^0-9]/", $val))
		{
			return FALSE;
		}

		if (function_exists('mb_strlen'))
		{
			return (mb_strlen($str) > $val) ? FALSE : TRUE;
		}

		return (strlen($str) > $val) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Exact Length
	 *
	 * @access	public
	 * @param	string
	 * @param	value
	 * @return	bool
	 */
	function exact_length($str, $val)
	{
		if (preg_match("/[^0-9]/", $val))
		{
			return FALSE;
		}

		if (function_exists('mb_strlen'))
		{
			return (mb_strlen($str) != $val) ? FALSE : TRUE;
		}

		return (strlen($str) != $val) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Valid Email
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function valid_email($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Valid Emails
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function valid_emails($str)
	{
		if (strpos($str, ',') === FALSE)
		{
			return $this->valid_email(trim($str));
		}

		foreach(explode(',', $str) as $email)
		{
			if (trim($email) != '' && $this->valid_email(trim($email)) === FALSE)
			{
				return FALSE;
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Validate IP Address
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function valid_ip($ip)
	{
		return $this->obj->input->valid_ip($ip);
	}

	// --------------------------------------------------------------------

	/**
	 * Alpha
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function alpha($str)
	{
		return ( ! preg_match("/^([a-z])+$/i", $str)) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Alpha-numeric
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function alpha_numeric($str)
	{
		return ( ! preg_match("/^([a-z0-9])+$/i", $str)) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Alpha-numeric with underscores and dashes
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function alpha_dash($str)
	{
		return ( ! preg_match("/^([-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Numeric
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function numeric($str)
	{
		return (bool)preg_match( '/^[\-+]?[0-9]*\.?[0-9]+$/', $str);

	}

	// --------------------------------------------------------------------

    /**
     * Is Numeric
     *
     * @access    public
     * @param    string
     * @return    bool
     */
    function is_numeric($str)
    {
        return ( ! is_numeric($str)) ? FALSE : TRUE;
    }

    function is_valid_date($date)
    {
		$day = (int) substr($date, 0, 2);
		$month = (int) substr($date, 3, 2);
		$year = (int) substr($date, 6, 4);
		
        return ( !  checkdate($month, $day, $year)) ? FALSE : TRUE;
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

	/**
	 * Integer
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function integer($str)
	{
		return (bool)preg_match( '/^[\-+]?[0-9]+$/', $str);
	}

	// --------------------------------------------------------------------

    /**
     * Is a Natural number  (0,1,2,3, etc.)
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function is_natural($str)
    {
   		return (bool)preg_match( '/^[0-9]+$/', $str);
    }

	// --------------------------------------------------------------------

    /**
     * Is a Natural number, but not a zero  (1,2,3, etc.)
     *
     * @access	public
     * @param	string
     * @return	bool
     */
	function is_natural_no_zero($str)
    {
    	if ( ! preg_match( '/^[0-9]+$/', $str))
    	{
    		return FALSE;
    	}

    	if ($str == 0)
    	{
    		return FALSE;
    	}

   		return TRUE;
    }

	// --------------------------------------------------------------------

	/**
	 * Valid Base64
	 *
	 * Tests a string for characters outside of the Base64 alphabet
	 * as defined by RFC 2045 http://www.faqs.org/rfcs/rfc2045
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function valid_base64($str)
	{
		return (bool) ! preg_match('/[^a-zA-Z0-9\/\+=]/', $str);
	}

}

/* End of file L_form_validation.php */
/* Location: ./system/application/libraries/L_form_validation.php */