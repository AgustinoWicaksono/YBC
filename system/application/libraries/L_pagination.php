<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class L_pagination
{

	function L_pagination() {
		$this->obj =& get_instance();
	}

	/**
	 * Create pagination of alphabet, from A to Z.
	 * The $uri parameter contains the 'base' URL,
	 * because it will catch the 4th segment of the URL
	 *
	 * @param string $uri	Base URL without trailing slash
	 * @return string
	 */
	function pagination_alphabet($uri = '')
	{
		$uri_segment4 = $this->obj->uri->segment(4); // alphabet

		$letter = "A";
		$str = "";
		
		for($i = 1; $i <= 26; $i++) {
			if($uri_segment4 != $letter)
				$str .= anchor($uri.'/alphabet/'.$letter, $letter)." ";
			else
				$str .= "<b>".$letter."</b> ";

			$letter++;
		}		

		return $str;
	}

	/**
	 * Show all of the data.
	 * The $uri parameter contains the 'base' URL
	 * because it will catch the 3rd segment of the URL
	 *
	 * @access	public
	 * @param	string $uri Base URL without trailing slash
	 * @return string
	 */
	function pagination_all($uri = '')
	{
		$uri_segment3 = $this->obj->uri->segment(3); // 'all' string

		if($uri_segment3 != 'all')
			$str .= anchor($uri.'/all', $this->obj->lang->line('all'))." ";
		else
			$str .= "<b>".$this->obj->lang->line('all')."</b> ";

		return $str;
	}

}

/* End of file L_pagination.php */
/* Location: ./system/application/libraries/L_pagination.php */