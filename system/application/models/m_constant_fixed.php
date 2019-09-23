<?php
class M_constant_fixed extends Model {

	function M_constant_fixed() {
		parent::Model();
		$this->obj =& get_instance();
	}

	function office_plants() {
		$plant[] = 'AB01';
		$plant[] = 'AB02';

		return $plant;
	}
	
	function kurs() {
		$matauang = 'IDR';
		$matauang = 'USD';
		return $matauang;
	}


}
?>
