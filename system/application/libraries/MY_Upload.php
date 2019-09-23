<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// From http://www.blueemberdesign.com/blog/2009/07/29/codeigniter-file-upload-setting-disallowed-file-types/
class MY_Upload extends CI_Upload {

  // declare disallowed types variable
  var $disallowed_types = '';

  // add in the 'disallowed_types' default during initialization
  function initialize($config = array()) {
    $defaults = array(
      'max_size'         => 0,
      'max_width'        => 0,
      'max_height'       => 0,
      'max_filename'     => 0,
      'allowed_types'    => "",
      'disallowed_types' => "",
      'file_temp'        => "",
      'file_name'        => "",
      'orig_name'        => "",
      'file_type'        => "",
      'file_size'        => "",
      'file_ext'         => "",
      'upload_path'      => "",
      'overwrite'        => FALSE,
      'encrypt_name'     => FALSE,
      'is_image'         => FALSE,
      'image_width'      => '',
      'image_height'     => '',
      'image_type'       => '',
      'image_size_str'   => '',
      'error_msg'        => array(),
      'mimes'            => array(),
      'remove_spaces'    => TRUE,
      'xss_clean'        => FALSE,
      'temp_prefix'      => "temp_file_"
    );

    foreach ($defaults as $key => $val) {
      if (isset($config[$key])) {
        $method = 'set_'.$key;
        if (method_exists($this, $method)) {
          $this->$method($config[$key]);
        }
        else {
          $this->$key = $config[$key];
        }
      }
      else {
        $this->$key = $val;
      }
    }
  }

  // set disallowed filetypes
  function set_disallowed_types($types) {
    $this->disallowed_types = explode('|', $types);
  }

  // adapted to not require allowed_types and to check for disallowed types if it exists
  function is_allowed_filetype() {
    // if allowed file type list is not defined
    if (count($this->allowed_types) == 0 OR ! is_array($this->allowed_types)) {
      // if disallowed file type list is not defined
      if (count($this->disallowed_types) == 0 OR ! is_array($this->disallowed_types))
        return TRUE;

      // check for disallowed file types and return
      // negated because is_disallowed_filetype returns opposite result as this function
      return ! $this->is_disallowed_filetype();
    }

    // proceed as usual with allowed file type list check
    return parent::is_allowed_filetype();
  }

  // check for disallowed file types
  function is_disallowed_filetype() {
    // no file types provided
    if (count($this->disallowed_types) == 0 OR ! is_array($this->disallowed_types))
      return FALSE;

    // search through disallowed for this file type
    foreach ($this->disallowed_types as $val) {
      $mime = $this->mimes_types(strtolower($val));

      if (is_array($mime)) {
        if (in_array($this->file_type, $mime, TRUE)) {
          return TRUE;
        }
      }
      else {
        if ($mime == $this->file_type) {
          return TRUE;
        }
      }
    }

    return FALSE;
  }

	// From below, added by LuckyGuy354

	// --------------------------------------------------------------------

	/**
	 * Set the file name
	 *
	 * This function takes a filename/path as input and looks for the
	 * existence of a file with the same name. If found, it will append a
	 * number to the end of the filename to avoid overwriting a pre-existing file.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function set_filename($path, $filename)
	{
		if ($this->encrypt_name == TRUE)
		{
			mt_srand();
			$filename = md5(uniqid(mt_rand())).$this->file_ext;
		}

		if ( ! file_exists($path.$filename))
		{
			return $filename;
		}

		$filename = str_replace($this->file_ext, '', $filename);

		$new_filename = '';
		for ($i = 1; $i < 1000000; $i++)
		{
			if ( ! file_exists($path.$filename.$i.$this->file_ext))
			{
				$new_filename = $filename.$i.$this->file_ext;
				break;
			}
		}

		if ($new_filename == '')
		{
			$this->set_error('upload_bad_filename');
			return FALSE;
		}
		else
		{
			return $new_filename;
		}
	}



}
