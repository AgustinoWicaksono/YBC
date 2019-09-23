<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class L_menu {

	/**
	 * PHP Script to build menu and the menu style
	 * @copyright http://www.roscripts.com/Building_a_dynamic_drop_down_menu-216.html => PHP script to build menu
	 * @copyright http://www.cssplay.co.uk/menus/drop_examples.html => Menu style
	 */
	function L_menu() {
		$this->obj =& get_instance();
	}
/*
	function get_menu() {
		// return: array, nested childs

		$this->obj->load->model('m_menu');
		$menu = $this->obj->m_menu->get_menu_list();

		return($menu);
	}
*/

	/**
	 * Create array of menu.
	 *
	 * @return array nested childs
	 */
	function get_menu()
	{
		// return: array, nested childs

		$menu = array
		(

//============================== Menu: HOME =======================================================
			1 => 	array
				(
					'text'		=> 	' &nbsp;  &nbsp; Depan &nbsp;  &nbsp; ',					
					'mnclass'	=> 	'mn_home',
					'class'		=> 	'dir',
					'link'		=> 	site_url(),
					'show'		=>	TRUE,
					'parent'	=>	0,
				),


// End of added by Edward

				
//============================== Menu: Transaksi GR-GI =======================================================
			2 =>	array
				(
					'text'		=> 	'Transaksi 1',
					'mnclass'	=> 	'mn_saptr',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	0,
					'perms'		=>	array
						(
							'trans',
						),
				),

//============================== Menu: Transaksi GR-GI - Input =======================================================
			201 =>	array
				(
					'text'		=> 	'Input Data Transaksi 1',
					'mnclass'	=> 	'mn_trinput',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	2,
					'perms'		=>	array
						(
							'trans',
						),
				),
					20101 =>	array
				(
					'text'		=> 	'EKSTERNAL',
					'class'		=> 	'mn_subtitle',
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_grpo',
						),
				),
			

			20102 =>	array
				(
					'text'		=> 	'In PO from Vendor',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grpo/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_grpo',
						),
				),

			20103 =>	array
				(   
					'text'		=> 	'Good Receipt From Central Kitchen ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grpodlv/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_grpodlv',
						),
				),
				
				20104 =>	array
				(
					'text'		=> 	'Transfer Out Inter Outlet',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('gistonew_out/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_gisto',
						),
				),
				
				20105 =>	array
				(
					'text'		=> 	'Transfer In Inter Outlet',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grsto/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_grsto',
						),
				),
				
				/*20106 =>	array
				(
					'text'		=> 	'Purchase Request(PR) ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('nonstdstock/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_nonstdstock',
						),
				),*/
			20106 =>	array
				(
					'text'		=> 	'Purchase Request(PR) ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('pr/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_pr',
						),
				),
				
				20110 =>	array
				(
					'text'		=> 	'Retur Out',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('gisto_dept/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_gisto',
						),
				),
				
			 20111 =>	array
				(
					'text'		=> 	'Retur In',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('retin/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_retin',
						),
				),
				
			/*		20129 =>	array
				(
					'text'		=> 	'Transfer Out Inter Outlet Old',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('gisto/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_gisto',
						),
				),
				*/
				
/*20119 =>	array
				(
					'text'		=> 	'Transfer Antar Outlet',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('gistonew_dept/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_gisto',
						),
				),
				*/
				
				
			/*	20192 =>	array
				(
					'text'		=> 	'INTERNAL',
					'class'		=> 	'mn_subtitle',
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_gisto',
						),
				),
				
				20112 =>	array
				(   
					'text'		=> 	'Transfer In Inter Departement',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grpodlv_dept/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_grsto',
						),
				),
				*/
				
			
				

			20113 =>	array
				(
					'text'		=> 	'Good Issue', 
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('issue/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_grnonpo',
						),
				),
				


			20112 =>	array
				(
					'text'		=> 	'Goods Receipt Non PO  ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grnonpo/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_grnonpo',
						),
				), 

			20114 =>	array
				(
					'text'		=> 	'PRODUKSI',
					'class'		=> 	'mn_subtitle',
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_tpaket',
						),
				),

		/*	20110 =>	array
				(
					'text'		=> 	'Transaksi Produksi ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('tpaket/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_tpaket',
						),
				),*/
/*	20119 =>	array
				(
					'text'		=> 	'Work Order',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('mpaket_prod/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_tpaket',
						),
				),
				*/
				20118 =>	array
				(
					'text'		=> 	'Work Order',      //yang bener or new
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('produksi/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_tpaket',
						),
				),

			20191 =>	array
				(
					'text'		=> 	'STOCK OUTLET',
					'class'		=> 	'mn_subtitle',
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_stockoutlet',
						),
				),
				
			/*20107 =>	array
				(
					'text'		=> 	'Stock Opname ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('stockoutlet/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_stockoutlet',
						),
				),*/
				
				20107 =>	array
				(
					'text'		=> 	'Stock Opname ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('opname/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_stockoutlet',
						),
				),

			20108 =>	array
				(
					'text'		=> 	'Spoiled / Breakage / Lost ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('waste/input'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_waste',
						),
				),

		/*	20109 =>	array
				(
					'text'		=> 	'Reset/Hapus Data Stock',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('deletedata'),
					'show'		=>	TRUE,
					'parent'	=>	201,
					'perms'		=>	array
						(
							'trans_deletedata',
						),
				),
				*/
				
				
//============================== Menu: Transaksi GR-GI - List =======================================================
			202 =>	array
				(
					'text'		=> 	'List Data Transaksi 1',
					'mnclass'	=> 	'mn_trlist',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	2,
					'perms'		=>	array
						(
							'trans',
						),
				),
				
	      20201 =>	array
				(
					'text'		=> 	'EKSTERNAL',
					'class'		=> 	'mn_subtitle',
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_grpo',
						),
				),
			
			20202 =>	array
				(
					'text'		=> 	'In PO from Vendor',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grpo/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_grpo',
						),
				),

			20203 =>	array
				(
					'text'		=> 	'Good Receipt From Central KItchen ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grpodlv/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_grpodlv',
						),
				),
				
				20204 =>	array
				(
					'text'		=> 	'Transfer Out Inter Outlet',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('gistonew_out/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_gisto',
						),
				),
				
				20205 =>	array
				(
					'text'		=> 	'Transfer In Inter Outlet',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grsto/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_grsto',
						),
				),
				
			/*		20206 =>	array
				(
					'text'		=> 	'Transfer Antar Outlet',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('gistonew_out/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_grsto',
						),
				),
				*/
					
			/*	20207 =>	array
				(
					'text'		=> 	'Purchase Request (PR)',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('nonstdstock/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_nonstdstock',
						),
				),*/
				
				20207 =>	array
				(
					'text'		=> 	'Purchase Request (PR)',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('pr/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_pr',
						),
				),
				
				
				20209 =>	array
				(
					'text'		=> 	'Retur Out',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('gisto_dept/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_gisto',
						),
				),
				
				 20210 =>	array
				(
					'text'		=> 	'Retur In',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('retin/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_retin',
						),
				),
				
				
				
			
				
			/*	20293 =>	array
				(
					'text'		=> 	'INTERNAL',
					'class'		=> 	'mn_subtitle',
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_grpodlv',
						),
				),
				
			20211 =>	array
				(
					'text'		=> 	'Transfer In Inter Departement',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grpodlv_dept/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_grsto',
						),
				),*/
			
				
			20212 =>	array
				(
					'text'		=> 	'Good Issue',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('issue/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_grnonpo',
						),
				),
				
			 
				


			20213 =>	array
				(
					'text'		=> 	'Goods Receipt Non PO',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grnonpo/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_grnonpo',
						),
				), 

				
				20292 =>	array
				(
					'text'		=> 	'PRODUKSI',
					'class'		=> 	'mn_subtitle',
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_tpaket',
						),
				),

			/*20209 =>	array
				(
					'text'		=> 	'Transaksi Produksi ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('tpaket/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_tpaket',
						),
				),*/
		/*		202013 =>	array
				(
					'text'		=> 	'Work Order ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('mpaket_prod/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_tpaket',
						),
				),
				
				*/
				202014 =>	array
				(
					'text'		=> 	'Work Order ',  //yang bener or new
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('produksi/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_tpaket',
						),
				),


			20291 =>	array
				(
					'text'		=> 	'STOCK OUTLET',
					'class'		=> 	'mn_subtitle',
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_stockoutlet',
						),
				),
				
			/*20214 =>	array
				(
					'text'		=> 	'Stock Opname ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('stockoutlet/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_stockoutlet',
						),
				),*/
				
				20214 =>	array
				(
					'text'		=> 	'Stock Opname ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('opname/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_stockoutlet',
						),
				),

			20215 =>	array
				(
					'text'		=> 	'Spoiled / Breakage / Lost ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('waste/browse'),
					'show'		=>	TRUE,
					'parent'	=>	202,
					'perms'		=>	array
						(
							'trans_waste',
						),
				),
				
//============================== Menu: Transaksi Stock =======================================================
			3 =>	array
				(
					'text'		=> 	'Transaksi 2',
					'mnclass'	=> 	'mn_saptr',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	0,
					'perms'		=>	array
						(
							'trans',
						),
				),

				
//============================== Menu: Transaksi Stock - Input =======================================================
			301 =>	array
				(
					'text'		=> 	'Input Data Transaksi 2',
					'mnclass'	=> 	'mn_trinput',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	3,
					'perms'		=>	array
						(
							'trans',
						),
				),

			30101 =>	array
				(
					'text'		=> 	'Store Room Request (SR)',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('stdstock/input'),
					'show'		=>	TRUE,
					'parent'	=>	301,
					'perms'		=>	array
						(
							'trans_stdstock',
						),
				),

		/*	30102 =>	array
				(
				 	'text'		=> 	'GR FG di Outlet',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grfg/input'),
					'show'		=>	TRUE,
					'parent'	=>	301,
					'perms'		=>	array
						(
							'trans_grfg',
						),
				),
				*/

		/*	30103 =>	array
				(
					'text'		=> 	'Transfer Selisih Stock ke CW',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('tssck/input'),
					'show'		=>	TRUE,
					'parent'	=>	301,
					'perms'		=>	array
						(
							'trans_tssck',
						),
				),
				
				*/

		/*	30104 =>	array
				(
					'text'		=> 	'Trend utility (usage)',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('trend_utility/input'),
					'show'		=>	TRUE,
					'parent'	=>	301,
					'perms'		=>	array
						(
							'trans_trend_utility',
						),
				),   */

		/*	30105 =>	array
				(
					'text'		=> 	'Productivity Staff/Labor per Store per Hari per Jam per Departement',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('prodstaff/input'),
					'show'		=>	TRUE,
					'parent'	=>	301,
					'perms'		=>	array
						(
							'trans_prodstaff',
						),
				), */

		/*	30106 =>	array
				(
					'text'		=> 	'GR PO STO & GR FG Pastry/Cookies dr CK',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grpofg/input'),
					'show'		=>	TRUE,
					'parent'	=>	301,
					'perms'		=>	array
						(
							'trans_grpofg',
						),
				),  */
/*
			30107 =>	array
				(
					'text'		=> 	'Transaksi Pemotongan Whole di Outlet',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('twts/input'),
					'show'		=>	TRUE,
					'parent'	=>	301,
					'perms'		=>	array
						(
							'trans_twts',
						),
				),
				*/
				
				30106 =>	array
				(
					'text'		=> 	'Transaksi Pemotongan Whole di Outlet',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('twtsnew/input'),
					'show'		=>	TRUE,
					'parent'	=>	301,
					'perms'		=>	array
						(
							'trans_twts',
						),
				),
			/*	30107 =>	array
				(
					'text'		=> 	'Transaksi Pemotongan Whole di Outlet TES',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('whole/input'),
					'show'		=>	TRUE,
					'parent'	=>	301,
					'perms'		=>	array
						(
							'trans_twts',
						),
				),
				*/

	/*		30108 =>	array
				(
					'text'		=> 	'End Of Day',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('posinc/input'),
					'show'		=>	TRUE,
					'parent'	=>	301,
					'perms'		=>	array
						(
							'trans_posinc',
						),
				),
*/

				
//============================== Menu: Transaksi Stock - List =======================================================

			302 =>	array
				(
					'text'		=> 	'List Data Transaksi 2',
					'mnclass'	=> 	'mn_trlist',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	3,
					'perms'		=>	array
						(
							'trans',
						),
				),

			30201 =>	array
				(
					'text'		=> 	'Store Room Request (SR)',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('stdstock/browse'),
					'show'		=>	TRUE,
					'parent'	=>	302,
					'perms'		=>	array
						(
							'trans_stdstock',
						),
				),

			/*30202 =>	array
				(
					'text'		=> 	'GR FG di Outlet',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grfg/browse'),
					'show'		=>	TRUE,
					'parent'	=>	302,
					'perms'		=>	array
						(
							'trans_grfg',
						),
				),

			30203 =>	array
				(
					'text'		=> 	'Transfer Selisih Stock ke CW',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('tssck/browse'),
					'show'		=>	TRUE,
					'parent'	=>	302,
					'perms'		=>	array
						(
							'trans_tssck',
						),
				),

			30204 =>	array
				(
					'text'		=> 	'Trend utility (usage)',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('trend_utility/browse'),
					'show'		=>	TRUE,
					'parent'	=>	302,
					'perms'		=>	array
						(
							'trans_trend_utility',
						),
				),

			/*30205 =>	array
				(
					'text'		=> 	'Productivity Staff/Labor per Store per Hari per Jam per Departement',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('prodstaff/browse'),
					'show'		=>	TRUE,
					'parent'	=>	302,
					'perms'		=>	array
						(
							'trans_prodstaff',
						),
				), */

		/*	30206 =>	array
				(
					'text'		=> 	'GR PO STO & GR FG Pastry/Cookies dr CK',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('grpofg/browse'),
					'show'		=>	TRUE,
					'parent'	=>	302,
					'perms'		=>	array
						(
							'trans_grpofg',
						),
				),     */
				

		/*	30207 =>	array
				(
					'text'		=> 	'Transaksi Pemotongan Whole di Outlet',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('twts/browse'),
					'show'		=>	TRUE,
					'parent'	=>	302,
					'perms'		=>	array
						(
							'trans_twts',
						),
				),
				
				*/
				
			30206 =>	array
				(
					'text'		=> 	'Transaksi Pemotongan Whole di Outlet ',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('twtsnew/browse'),
					'show'		=>	TRUE,
					'parent'	=>	302,
					'perms'		=>	array
						(
							'trans_twts',
						),
				),
	/*			30207 =>	array
				(
					'text'		=> 	'Transaksi Pemotongan Whole di Outlet TES',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('whole/browse'),
					'show'		=>	TRUE,
					'parent'	=>	302,
					'perms'		=>	array
						(
							'trans_twts',
						),
				),
*/
		/*	30208 =>	array
				(
					'text'		=> 	'End Of Day',
					'mnclass'	=> 	'mn_trans',
					'link'		=> 	site_url('posinc/browse'),
					'show'		=>	TRUE,
					'parent'	=>	302,
					'perms'		=>	array
						(
							'trans_posinc',
						),
				),
				*/
				
//============================== Menu: Master =======================================================
			4 =>	array
				(
					'text'		=> 	'Master Data',
					'mnclass'	=> 	'mn_masterdata',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	0,
					'perms'		=>	array
						(
							'masterdata',
						),
				),

//============================== Menu: Master - Input =======================================================
			401 =>	array
				(
					'text'		=> 	'Input Master Data',
					'mnclass'	=> 	'mn_mtinput',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	4,
					'perms'		=>	array
						(
							'masterdata',
						),
				),
/*
			40101 =>	array
				(
				  	'text'		=> 	'Employee Position',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('posisi/input'),
					'show'		=>	TRUE,
					'parent'	=>	401,
					'perms'		=>	array
						(
							'masterdata_posisi',
						),
				),

			40102 =>	array
				(
					'text'		=> 	'Employee Status',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('status/input'),
					'show'		=>	TRUE,
					'parent'	=>	401,
					'perms'		=>	array
						(
							'masterdata_status',
						),
				),
*/
			40103 =>	array
				(
				  	'text'		=> 	'Manajemen Pengguna',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('user/input'),
					'show'		=>	TRUE,
					'parent'	=>	401,
					'perms'		=>	array
						(
							'masterdata_admin',
						),
				),

			40104 =>	array
				(
					'text'		=> 	'Hak Akses',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('perm/group_add'),
					'show'		=>	TRUE,
					'parent'	=>	401,
					'perms'		=>	array
						(
							'masterdata_perm_group',
						),
				),
				
		/*	40105 =>	array
				(
				  	'text'		=> 	'Master Semi Finished Goods (SFG) BOM',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('sfgs/input'),
					'show'		=>	TRUE,
					'parent'	=>	401,
					'perms'		=>	array
						(
							'masterdata_sfg',
						),
				),
				
				*/

			/*40106 =>	array
				(
				  	'text'		=> 	'Master Item Opname Inventory',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('opnd/input'),
					'show'		=>	TRUE,
					'parent'	=>	401,
					'perms'		=>	array
						(
							'masterdata_opnd',
						),
				),*/

			40107 =>	array
				(
				  	'text'		=> 	'Master Konversi Item Whole ke Slice',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('mwts/input'),
					'show'		=>	TRUE,
					'parent'	=>	401,
					'perms'		=>	array
						(
							'masterdata_mwts',
						),
				),
				

			/*40108 =>	array
				(
				  	'text'		=> 	'Master Bill Of Materials',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('mpaket/input'),
					'show'		=>	TRUE,
					'parent'	=>	401,
					'perms'		=>	array
						(
							'masterdata_mpaket',
						),
				),
				*/
			


//============================== Menu: Master - List =======================================================
			402 =>	array
				(
					'text'		=> 	'List Master Data',
					'mnclass'	=> 	'mn_mtlist',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	4,
					'perms'		=>	array
						(
							'masterdata',
						),
				),

 			40201 =>	array
				(
					'text'		=> 	'Integration Log',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('posisi/browse'),
					'show'		=>	TRUE,
					'parent'	=>	402,
					'perms'		=>	array
						(
							'masterdata_posisi',
						),
				),

		/*	40202 =>	array
				(
					'text'		=> 	'Employee Status',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('status/browse'),
					'show'		=>	TRUE,
					'parent'	=>	402,
					'perms'		=>	array
						(
							'masterdata_status',
						),
				),
*/
 			40203 =>	array
				(
					'text'		=> 	'Manajemen Pengguna',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('user/browse'),
					'show'		=>	TRUE,
					'parent'	=>	402,
					'perms'		=>	array
						(
							'masterdata_admin',
						),
				),

			40204 =>	array
				(
					'text'		=> 	'Hak Akses',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('perm/group_browse'),
					'show'		=>	TRUE,
					'parent'	=>	402,
					'perms'		=>	array
						(
							'masterdata_perm_group',
						),
				),

 		/*	40205 =>	array
				(
					'text'		=> 	'Master Semi Finished Goods (SFG) BOM',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('sfgs/browse'),
					'show'		=>	TRUE,
					'parent'	=>	402,
					'perms'		=>	array
						(
							'masterdata_sfg',
						),
				),
				
				
 			40206 =>	array
				(
					'text'		=> 	'Master Item Opname Inventory',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('opnd/browse'),
					'show'		=>	TRUE,
					'parent'	=>	402,
					'perms'		=>	array
						(
							'masterdata_opnd',
						),
				),*/

 			40207 =>	array
				(
					'text'		=> 	'Master Konversi Item Whole ke Slice',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('mwts/browse'),
					'show'		=>	TRUE,
					'parent'	=>	402,
					'perms'		=>	array
						(
							'masterdata_mwts',
						),
				),
				
				
				
			

 			40208 =>	array
				(
					'text'		=> 	'Master Bill Of Materials',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('mpaket/browse'),
					'show'		=>	TRUE,
					'parent'	=>	402,
					'perms'		=>	array
						(
							'masterdata_mpaket',
						),
				),
				
				

//============================== Menu: Report =======================================================
	
	
			5 =>	array
				(
					'text'		=> 	'Report Summary',
					'mnclass'	=> 	'mn_rpt',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	0,
					'perms'		=>	array
						(
							'report',
						),
				),

			591 =>	array
				(
					'text'		=> 	'STOCK',
					'class'		=> 	'mn_subtitle',
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_stockstatus',
						),
				),

			/*501 =>	array
				(
					'text'		=> 	'Display Standard Stock di Outlet',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('dispnonstdstock/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_dispnonstdstock',
						),
				),

			502 =>	array
				(
					'text'		=> 	'List Material Document',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('kodematerial/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_kodematerial',
						),
				),

			503 =>	array
				(
					'text'		=> 	'Variance',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('variance/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_variance',
						),
				),

			504 =>	array
				(
					'text'		=> 	'List Outstanding PR/PO/Delivery vs Stock vs Requirements',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('listoutstanding/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_listoutstanding',
						),
				),

			505 =>	array
				(
					'text'		=> 	'Material Document Summary',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('summwebdoc/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_summwebdoc',
						),
				),
				
			507 =>	array
				(
					'text'		=> 	'Variance',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('variance2/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_variance2',
						),
				),


			508 =>	array
				(
					'text'		=> 	'Status Stock Opname',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('stockstatus/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_stockstatus',
						),
				),
				*/
				
				510 =>	array
				(
					'text'		=> 	'Invetory audit',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('pastry/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_pastry',
						),
				),
				
				511 =>	array
				(
					'text'		=> 	'Bincard Report',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('bincard/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_bincard',
						),
				),
				512 =>	array
				(
					'text'		=> 	'Onhand Report',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('onhand/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_onhand',
						),
				),
			
			/*520 =>	array
				(
					'text'		=> 	'Cake Shop',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('cakeshop/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_cakeshop',
						),
				),
			
			530 =>	array
				(
					'text'		=> 	'In Warehouse Report',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('store/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_varianceoutlet',
						
						),
				),
				
					530=>	array
				(
					'text'		=> 	'Report Store',
					'mnclass'	=> 	'mn_rpt',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report',
						),
				),
				
			
			531 =>	array
				(
					'text'		=> 	'Store  Daily',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('varsum3/browse'),
					'show'		=>	TRUE,
					'parent'	=>	530,
					'perms'		=>	array
						(
							'report_varianceoutlet',
						
						),
				),
				
				
				
				532 =>	array
				(
					'text'		=> 	'Store',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('store/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_store',
						
						),
				),
			
			540 =>	array
				(
					'text'		=> 	'Bar',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('bar/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_bar',
						),
				),
				
	    550 =>	array
				(
					'text'		=> 	'Bread',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('bread/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_bread',
						),
				),
			
	   560 =>	array
				(
					'text'		=> 	'Ice Cream',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('icecream/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_icecream',
						),
		 ),
		 
		 
	 570 =>	array
				(
					'text'		=> 	'Hot Kitchen',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('hotkitchen/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_hotkitchen',
						),
				),
				
				
			 571 =>	array
				(
					'text'		=> 	'Summary Variance',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('varsum_new/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_variance_summary',
						),
				),
				
					 572 =>	array
				(
					'text'		=> 	'Summary Spoiled ',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('spoiled2/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_spoiled',
						),
				),
				 573 =>	array
				(
					'text'		=> 	'Summary Retur Out ',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('returout/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_returout',
						),
				),
				 574 =>	array
				(
					'text'		=> 	'Summary Retur In ',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('returin/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_returin',
						),
				),
				 575 =>	array
				(
					'text'		=> 	'Delete History',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('userdelete/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_userdelete',
						),
				),
			
			
			
			6=>	array
				(
					'text'		=> 	'Report Outstanding ',
					'mnclass'	=> 	'mn_rpt',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	0,
					'perms'		=>	array
						(
							'report',
						),
				),
				
				601 =>	array
				(
					'text'		=> 	'Oustanding Purchase Request (PR) ',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('prouts/browse'),
					'show'		=>	TRUE,
					'parent'	=>	6,
					'perms'		=>	array
						(
							'report_outs_pr',
						),
				),
				602 =>	array
				(
					'text'		=> 	'Oustanding Store Room Request (SR) ',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('sroutsd/browse'),
					'show'		=>	TRUE,
					'parent'	=>	6,
					'perms'		=>	array
						(
							'report_outs_sr',
						),
				),
			
			
			  509 =>	array
				(
					'text'		=> 	'PR STO vs DO vs Goods Receipt',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('prstodlvgr/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_prstodlvgr',
						),
				),
				

			510 =>	array
				(
					'text'		=> 	'Variance Outlet',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('varianceoutlet/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_varianceoutlet',
						),
				),
*/
		/*	511 =>	array
				(
					'text'		=> 	'Upload Report Variance Outlet',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('uploadrptvariance/browse'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_upload_varianceoutlet',
						),
				),

			514 =>	array
				(
					'text'		=> 	'Waste',
					'mnclass'	=> 	'mn_report',
					'link'		=> 	site_url('rpt_waste/input'),
					'show'		=>	TRUE,
					'parent'	=>	5,
					'perms'		=>	array
						(
							'report_waste',
						),
				),	*/		



// Start of added by Edward
//============================== Menu: HR =======================================================
	/*		8 =>	array
				(
					'text'		=> 	'HR',
					'mnclass'	=> 	'mn_masterdata',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	0,
					'perms'		=>	array
						(
							'hrd',
						),
				),

//============================== Menu: HRD - Input =======================================================
			801 =>	array
				(
					'text'		=> 	'Input Data',
					'mnclass'	=> 	'mn_mtinput',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	8,
					'perms'		=>	array
						(
							'hrd',
						),
				),

			80101 =>	array
				(
					'text'		=> 	'Dinas Luar',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('employee_fp/enter'),
					'show'		=>	TRUE,
					'parent'	=>	801,
					'perms'		=>	array
						(
							'hrd_input_dl',
						),
				),

			80102 =>	array
				(
					'text'		=> 	'Shift Karyawan',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('employee_shift/browse'),
					'show'		=>	TRUE,
					'parent'	=>	801,
					'perms'		=>	array
						(
							'hrd_input_shift',
						),
				),

			80103 =>	array
				(
					'text'		=> 	'Izin Karyawan',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('employee_absent/enter'),
					'show'		=>	TRUE,
					'parent'	=>	801,
					'perms'		=>	array
						(
							'hrd_input_izin',
						),
				),

			80104 =>	array
				(
					'text'		=> 	'End of Month',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('endofmonth'),
					'show'		=>	TRUE,
					'parent'	=>	801,
					'perms'		=>	array
						(
							'hrd_input_eod',
						),
				),

			80105 =>	array
				(
					'text'		=> 	'Request Karyawan',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('employee_req/input'),
					'show'		=>	TRUE,
					'parent'	=>	801,
					'perms'		=>	array
						(
							'hrd_input_request',
						),
				),

//============================== Menu: HRD - List =======================================================
			802 =>	array
				(
					'text'		=> 	'List Data',
					'mnclass'	=> 	'mn_mtlist',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	8,
					'perms'		=>	array
						(
							'hrd',
						),
				),

 			80201 =>	array
				(
					'text'		=> 	'Employee',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('employee/browse'),
					'show'		=>	TRUE,
					'parent'	=>	802,
					'perms'		=>	array
						(
							'hrd_list_employee',
						),
				),

//============================== Menu: HRD - Report =======================================================
			803 =>	array
				(
					'text'		=> 	'Report',
					'mnclass'	=> 	'mn_mtlist',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	8,
					'perms'		=>	array
						(
							'hrd',
						),
				),

 			80301 =>	array
				(
					'text'		=> 	'Attendance List',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('employee_attn_list/browse'),
					'show'		=>	TRUE,
					'parent'	=>	803,
					'perms'		=>	array
						(
							'hrd_report_attendance',
						),
				),

 			80302 =>	array
				(
					'text'		=> 	'Attendance Detail',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('employee_attn_detail/browse'),
					'show'		=>	TRUE,
					'parent'	=>	803,
					'perms'		=>	array
						(
							'hrd_report_attendance_detail',
						),
				),

 			80305 =>	array
				(
					'text'		=> 	'Data Mesin Absen',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('employee_machine/browse'),
					'show'		=>	TRUE,
					'parent'	=>	803,
					'perms'		=>	array
						(
							'hrd_report_machine',
						),
				),
				
 			80306 =>	array
				(
					'text'		=> 	'Data Tidak Wajar',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('employee_suspect/browse'),
					'show'		=>	TRUE,
					'parent'	=>	803,
					'perms'		=>	array
						(
							'hrd_report_suspect',
						),
				),
				
 			80303 =>	array
				(
					'text'		=> 	'Employee Request',
					'mnclass'	=> 	'mn_master',
					'link'		=> 	site_url('employee_req/report'),
					'show'		=>	TRUE,
					'parent'	=>	803,
					'perms'		=>	array
						(
							'hrd_report_employee_req',
						),
				),

*/
				
				

//============================== Menu: Download =======================================================

/*  remark menu download
      6 =>	array
				(
					'text'		=> 'Download',
					'mnclass'	=> 	'mn_dl',
					'class'		=> 	'dir',
					'show'		=>	TRUE,
					'parent'	=>	0,
					'perms'		=>	array
						(
							'download',
						),
				),


	    	601 =>	array
				(
					'text'		=> 	'Template (Excel)',
					'link'		=> 	site_url('download'),
					'mnclass'	=> 	'mn_download',
					'show'		=>	TRUE,
					'parent'	=>	6,
					'perms'		=>	array
						(
							'download_excel',
						),
				),
				*/


				
				
				
				
			);

		return $menu;
	}

	/**
	 * Create blank menu. Used when user not logged in.
	 *
	 * @return void
	 */
	function blank_menu() {
?>
<div class="menu2" style="width: 100%; text-align:center; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; padding:7px"><b>
<?=$this->obj->lang->line('guest_area');?></b></div>
<?php
	}

	/**
	 * Create startup menu. Used when user login but 'trapped' on startup.
	 *
	 * @return void
	 */
	function startup_menu() {
?>
<div class="menu2" style="width: 100%; text-align:center; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:1px; padding:7px"><b><?=$this->obj->lang->line('startup_area');?></b></div>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="jquerycssmenu.js"></script>
<?php
	}

	/**
	 * Create menu with <div> tag.
	 *
	 * @param array $menu From get_menu() function
	 * @param bool $childs 1 if have childs of menu, 0 if doesn't have childs of menu
	 * @return string Display of menu
	 */

	function create_menu($menu, $childs = 1) {

//		$out = '<div class="menu2" style="width: 100%">'."\n";
		$out .= "\n".'<ul id="nav" class="dropdown dropdown-horizontal">' . "\n";

		foreach ($menu as $key => $value) 
		{
			if (is_array($menu[$key])) { //must be by construction but let's keep the errors home
				if ($menu[$key]['parent'] == 0) {
					if ( empty($menu[$key]['perms']) || $this->obj->l_auth->is_have_perm_category($menu[$key]['perms'])) {
						if (!empty($menu[$key]['mnclass'])) {
							if ($menu[$key]['mnclass']=="mn_home")
								$out .= '<li id="'.$menu[$key]['mnclass'].'">';
							elseif ($menu[$key]['mnclass']=="mn_myjag")
								$out .= '<li id="'.$menu[$key]['mnclass'].'">';
							else
								$out .= '<li>';
						}
						else
							$out .= '<li>';
							
						$dirclass="";
						if (!empty($menu[$key]['class']))
							$dirclass = ' class="'.$menu[$key]['class'].'" ';

						if (!empty($menu[$key]['link']))
							$out .= '<a href="'.$menu[$key]['link'].'" '.$dirclass.'>';
						else
							$out .= '<a href="./" '.$dirclass.'>';

						$out .= $menu[$key]['text'];
						$out .= '</a>';

						if($childs)
							$out .= $this->get_childs($menu, $key);
						$out .= '</li>'."\r\n";
					}
				}
			} else {
				die (sprintf('menu number %s must be an array', $key));
			}
		}

		$out .= '<li id="mn_end">&nbsp;</li></ul>'."\n";
//		$out .= "\n\t" . '</div>';
//		return $out . "\n\t" . '</div>';
		return $out;
	}

	/**
	 * Get childs menu.
	 *
	 * @param array $menu From get_menu() function
	 * @param int $el_id depth of the childs menu
	 * @return string|FALSE Display of childs menu | FALSE condition
	 */
	function get_childs($menu, $el_id) {

		$has_subcats = FALSE;
		$out = '';
		$out .= "\n\t\t"."\n\t\t".'<ul>'."\n";

		foreach ($menu as $key => $value) {
			if ( $menu[$key]['parent'] == $el_id ) {
				if (empty($menu[$key]['perms']) || $this->obj->l_auth->is_have_perm($menu[$key]['perms']) || $this->obj->l_auth->is_have_perm_category($menu[$key]['perms'])) {
					$has_subcats = TRUE;
					$add_class = ''; 
					$mn_subtitle="";
					if (@$menu[$key]['class']=="mn_subtitle") $mn_subtitle= ' class="mn_subtitle" ';
					
					if (!empty($menu[$key]['mnclass'])){
						if ($menu[$key]['mnclass']=="mn_home")
							$out .= '<li id="'.$menu[$key]['mnclass'].'"'.$mn_subtitle.'>';
						elseif ($menu[$key]['mnclass']=="mn_myjag")
							$out .= '<li id="'.$menu[$key]['mnclass'].'"'.$mn_subtitle.'>';
						else
							$out .= '<li'.$mn_subtitle.'>';
					}
					else
						$out .= '<li'.$mn_subtitle.'>';
					if (@$menu[$key]['class']=="mn_subtitle") $out .='<span>';
						
					$dirclass="";
					if (!empty($menu[$key]['class']))
						$dirclass = ' class="'.$menu[$key]['class'].'" ';

					if (!empty($menu[$key]['link']))
						$out .= '<a href="'.$menu[$key]['link'].'" '.$dirclass.'>';
					else {
						if (@$menu[$key]['class']!="mn_subtitle")
							$out .= '<a href="./" '.$dirclass.'>';
					}

					$out .= $menu[$key]['text'];
					if (@$menu[$key]['class']!="mn_subtitle")
						$out .= '</a>';

					if (@$menu[$key]['class']=="mn_subtitle") $out .='</span>';


					$out .= $this->get_childs($menu, $key);
					$out .= '</li>'."\r\n";
				}
			}
		}
		$out .= '</ul>'."\n\t\t"."\n";
		return ( $has_subcats ) ? $out : FALSE;
	}
}
?>