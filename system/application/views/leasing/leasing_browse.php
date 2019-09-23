<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_admin', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<div align="center" class="page_title"><?php echo $page_title;?></div>
<p>&nbsp;</p>

<?php 
// echo $this->session->userdata['ADMIN']['admin_id'];
// $plants_diizinkan = $this->m_perm->admin_plants_select_all($this->session->userdata['ADMIN']['admin_id']);
// print ( '<pre>' )  ;
// print_r($plants_diizinkan);
// print ( '</pre>' )  ;

// foreach ($plants_diizinkan as $key => $list) {
   // echo "No.: " . $key . "<br/>";
   // echo "Name: " . $list['OUTLET_NAME1'] . "<br/>";
// }
?>


<a style="text-decoration:none;margin-left:20px;" onclick="add()" class="btn btn-default btn-xs" data-toggle="modal" href="#form-content-add"><img src="../images/icons/AddOrange16.png"><strong>&nbsp;&nbsp;New Outlet</strong></a>
<a style="text-decoration:none;margin-left:0px;" onclick="show_attention()" class="btn btn-default btn-xs"><img src="../images/icons/warning_yellow2.png"><strong>&nbsp;&nbsp;Due Date</strong></a>
<a style="text-decoration:none;margin-left:0px;" onclick="filter_div()" class="btn btn-default btn-xs" id="filter_btn"><img src="../images/icons/Filter.png"><strong>&nbsp;&nbspShow Filter</strong></a>
<br/><br/>
<input type="hidden" name="add_or_edit" id="add_or_edit">
<input type="hidden" name="mulai_sewa_before" id="mulai_sewa_before">
<input type="hidden" name="akhir_sewa_before" id="akhir_sewa_before">

<!--  FORM FILTER DATA -->	
<div id="filter_div" style="margin-left:1%;margin-right:1%;display:none;">
	<input type="hidden" id="filter_stat">
	<div class="well">
            <select id="filter_company" data-placeholder="Select a company..." class="chosen-select" style="width:100%;" tabindex="2">
									<option value=""></option>
									<?php foreach($company->result() as $row){
												echo '<option value="'.$row->id_jenisoutlet.'">'.$row->jenisoutlet.'</option>';
									}?>	
			</select>	
            <select id="filter_city" data-placeholder="Select a city..." class="chosen-select" style="width:100%;" tabindex="2">
									<option value=""></option>
									<?php foreach($city->result() as $row){
												echo '<option value="'.$row->city_name.'">'.$row->city_name.'</option>';
									}?>	
			</select>			
<!--		<input type="text" class="input-xlarge" id="filter_company" placeholder="Company name">		
			<input type="text" class="input-xlarge" id="filter_city" placeholder="City name">				-->
			<span class="label">DATE RANGE</span> <input type="text" class="input-small" id="filter_date_start" placeholder="Lease start"> - <input type="text" class="input-small" id="filter_date_end" placeholder="Lease end">  			
			<button class="btn btn-success" id="filter_go" style="margin-top:-10px;">Search</button>
			<button class="btn btn-default" id="filter_clear" style="margin-top:-10px;display:none;">Clear results</button>
	</div>	
</div>
<!--  FORM FILTER DATA -->


	<!-- FORM FOR EDIT DATA AND SHOW HISTORY-->	
	<div id="form-content" class="modal hide fade in" style="display: none; ">
	        <div class="modal-header">
	              <a class="close" data-dismiss="modal">X</a>
	              <h4 id="title"></h4>
				  <h6 id="changer"></h6>
	        </div>
		<div>
			<form class="contact" name="form1" id="form1">
			<fieldset>
		         <div class="modal-body">
		        	 <ul class="nav nav-list">
							<li class="nav-header">Company <span style="color:red;">*</span></li>
							<li><input class="input-xlarge" type="text" name="in_company" id="in_company"></li>						
							<li class="nav-header">Mall <span style="color:red;">*</span></li>
							<li><input class="input-xlarge" type="text" name="in_mall" id="in_mall"></li>	
							<li class="nav-header">Outlet Name <span style="color:red;">*</span></li>							
							<li><input class="input-xlarge" type="text" name="in_outletname" id="in_outletname"></li>						
							<li class="nav-header">Outlet Code <span style="color:red;">*</span></li>							
							<input type="hidden" name="row_id" id="row_id">
							<li><input class="input-xlarge" type="text" name="in_outlet" id="in_outlet"></li>								
							<li class="nav-header">Plan</li>
							<li><input class="input-xlarge" type="text" name="in_plan" id="in_plan"></li>							
							<li class="nav-header">City <span style="color:red;">*</span></li>
							<li><input class="input-xlarge" type="text" name="in_city" id="in_city"></li>

							<li class="nav-header">Opening Date</li>
							<li><input class="input-xlarge" type="text" name="in_opening_date" id="in_opening_date" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Closing Date</li>
							<li><input class="input-xlarge" type="text" name="in_closing_date" id="in_closing_date" style="position: relative; z-index: 100000;"></li>	
							<li class="nav-header">Summary</li>
							<li><input class="input-xlarge" type="text" name="in_summary" id="in_summary" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">LOI</li>
							<li><input class="input-xlarge" type="text" name="in_loi" id="in_loi" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">PSM</li>
							<li><input class="input-xlarge" type="text" name="in_psm" id="in_psm" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Thn Sewa</li>
							<li><input class="input-xlarge" type="text" name="in_thn_sewa" id="in_thn_sewa"></li>
							<li class="nav-header">Mulai Sewa</li>
							<li><input class="input-xlarge" type="text" name="in_mulai_sewa" id="in_mulai_sewa" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Akhir Sewa</li>
							<li><input class="input-xlarge" type="text" name="in_akhir_sewa" id="in_akhir_sewa" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Opsi Sewa</li>
							<li><input class="input-xlarge" type="text" name="in_opsi_sewa" id="in_opsi_sewa"></li>
							<li class="nav-header">Location</li>
							<li><input class="input-xlarge" type="text" name="in_location" id="in_location"></li>
							<li class="nav-header">Luas 1</li>
							<li><input class="input-xlarge" type="text" name="in_luas_1" id="in_luas_1"></li>
							<li class="nav-header">Luas 2</li>
							<li><input class="input-xlarge" type="text" name="in_luas_2" id="in_luas_2"></li>
							<li class="nav-header">Luas 3</li>
							<li><input class="input-xlarge" type="text" name="in_luas_3" id="in_luas_3"></li>		
							<li class="nav-header">Luas Free</li>
							<li><input class="input-xlarge" type="text" name="in_luas_free" id="in_luas_free"></li>
							<li class="nav-header">Grace Period</li>
							<li><input class="input-xlarge" type="text" name="in_grace_period" id="in_grace_period"></li>
							<li class="nav-header">Discount</li>
							<li><input class="input-xlarge" type="text" name="in_discount" id="in_discount"></li>
							<li class="nav-header">Advance Money/ DP</li>
							<li><input class="input-xlarge" type="text" name="in_dp" id="in_dp"></li>
							<li class="nav-header">Installment</li>
							<li><input class="input-xlarge" type="text" name="in_installment" id="in_installment"></li>
							<li class="nav-header">Rate Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="in_rate_thn_1" id="in_rate_thn_1"></li>
							<li class="nav-header">Rate Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="in_rate_thn_2" id="in_rate_thn_2"></li>
							<li class="nav-header">Rate Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="in_rate_thn_3" id="in_rate_thn_3"></li>
							<li class="nav-header">Rate Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="in_rate_thn_4" id="in_rate_thn_4"></li>
							<li class="nav-header">Rate Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="in_rate_thn_5" id="in_rate_thn_5"></li>
							<li class="nav-header">Rate Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="in_rate_thn_6" id="in_rate_thn_6"></li>
							<li class="nav-header">Rate Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="in_rate_thn_7" id="in_rate_thn_7"></li>
							<li class="nav-header">Rate Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="in_rate_thn_8" id="in_rate_thn_8"></li>
							<li class="nav-header">Rate Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="in_rate_thn_9" id="in_rate_thn_9"></li>
							<li class="nav-header">Rate Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="in_rate_thn_10" id="in_rate_thn_10"></li>	
							<li class="nav-header">Service Charge  Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="in_sc_thn_1" id="in_sc_thn_1"></li>
							<li class="nav-header">Service Charge  Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="in_sc_thn_2" id="in_sc_thn_2"></li>
							<li class="nav-header">Service Charge  Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="in_sc_thn_3" id="in_sc_thn_3"></li>
							<li class="nav-header">Service Charge  Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="in_sc_thn_4" id="in_sc_thn_4"></li>
							<li class="nav-header">Service Charge  Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="in_sc_thn_5" id="in_sc_thn_5"></li>
							<li class="nav-header">Service Charge  Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="in_sc_thn_6" id="in_sc_thn_6"></li>
							<li class="nav-header">Service Charge  Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="in_sc_thn_7" id="in_sc_thn_7"></li>
							<li class="nav-header">Service Charge  Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="in_sc_thn_8" id="in_sc_thn_8"></li>
							<li class="nav-header">Service Charge  Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="in_sc_thn_9" id="in_sc_thn_9"></li>
							<li class="nav-header">Service Charge  Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="in_sc_thn_10" id="in_sc_thn_10"></li>	
							<li class="nav-header">Tarif Indoor (USD) Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_usd_1" id="in_indoor_usd_1"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_idr_1" id="in_indoor_idr_1"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_usd_1" id="in_outdoor_usd_1"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_idr_1" id="in_outdoor_idr_1"></li>	
							<li class="nav-header">Tarif Indoor (USD) Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_usd_2" id="in_indoor_usd_2"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_idr_2" id="in_indoor_idr_2"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_usd_2" id="in_outdoor_usd_2"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_idr_2" id="in_outdoor_idr_2"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_usd_3" id="in_indoor_usd_3"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_idr_3" id="in_indoor_idr_3"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_usd_3" id="in_outdoor_usd_3"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_idr_3" id="in_outdoor_idr_3"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_usd_4" id="in_indoor_usd_4"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_idr_4" id="in_indoor_idr_4"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_usd_4" id="in_outdoor_usd_4"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_idr_4" id="in_outdoor_idr_4"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_usd_5" id="in_indoor_usd_5"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_idr_5" id="in_indoor_idr_5"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_usd_5" id="in_outdoor_usd_5"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_idr_5" id="in_outdoor_idr_5"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_usd_6" id="in_indoor_usd_6"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_idr_6" id="in_indoor_idr_6"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_usd_6" id="in_outdoor_usd_6"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_idr_6" id="in_outdoor_idr_6"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_usd_7" id="in_indoor_usd_7"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_idr_7" id="in_indoor_idr_7"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_usd_7" id="in_outdoor_usd_7"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_idr_7" id="in_outdoor_idr_7"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_usd_8" id="in_indoor_usd_8"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_idr_8" id="in_indoor_idr_8"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_usd_8" id="in_outdoor_usd_8"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_idr_8" id="in_outdoor_idr_8"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_usd_9" id="in_indoor_usd_9"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_idr_9" id="in_indoor_idr_9"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_usd_9" id="in_outdoor_usd_9"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_idr_9" id="in_outdoor_idr_9"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_usd_10" id="in_indoor_usd_10"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="in_indoor_idr_10" id="in_indoor_idr_10"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_usd_10" id="in_outdoor_usd_10"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="in_outdoor_idr_10" id="in_outdoor_idr_10"></li>	
							<li class="nav-header">Service Charge Indoor (USD)</li>
							<li><input class="input-xlarge" type="text" name="in_sc_indoor_usd" id="in_sc_indoor_usd"></li>	
							<li class="nav-header">Service Charge Indoor (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_sc_indoor_idr" id="in_sc_indoor_idr"></li>
							<li class="nav-header">Service Charge Outdoor (USD)</li>
							<li><input class="input-xlarge" type="text" name="in_sc_outdoor_usd" id="in_sc_outdoor_usd"></li>	
							<li class="nav-header">Service Charge Outdoor (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_sc_outdoor_idr" id="in_sc_outdoor_idr"></li>	
							<li class="nav-header">PL @Month (USD)</li>
							<li><input class="input-xlarge" type="text" name="in_pl_month_usd" id="in_pl_month_usd"></li>		
							<li class="nav-header">PL @Month (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_pl_month_idr" id="in_pl_month_idr"></li>	
							<li class="nav-header">PL Tahun (USD)</li>
							<li><input class="input-xlarge" type="text" name="in_pl_year_usd" id="in_pl_year_usd"></li>		
							<li class="nav-header">PL Tahun (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_pl_year_idr" id="in_pl_year_idr"></li>								
							<li class="nav-header">PL Onetime (USD)</li>
							<li><input class="input-xlarge" type="text" name="in_pl_onetine_usd" id="in_pl_onetine_usd"></li>	
							<li class="nav-header">PL Onetime (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_pl_onetine_idr" id="in_pl_onetine_idr"></li>	
							<li class="nav-header">Singking Fund (USD)</li>
							<li><input class="input-xlarge" type="text" name="in_singking_usd" id="in_singking_usd"></li>	
							<li class="nav-header">Singking Fund (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_singking_idr" id="in_singking_idr"></li>
							<li class="nav-header">Deposit Sewa (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_deposit_sewa" id="in_deposit_sewa"></li>		
							<li class="nav-header">Deposit Service Charge (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_deposit_sc" id="in_deposit_sc"></li>
							<li class="nav-header">Deposit Telpon (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_deposit_tlp" id="in_deposit_tlp"></li>
							<li class="nav-header">Deposit Internet (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_deposit_inet" id="in_deposit_inet"></li>
							<li class="nav-header">Deposit Listrik (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_deposit_listrik" id="in_deposit_listrik"></li>
							<li class="nav-header">Deposit Air & Gas (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_deposit_air" id="in_deposit_air"></li>
							<li class="nav-header">Deposit Wallsign (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_deposit_wallsign" id="in_deposit_wallsign"></li>
							<li class="nav-header">Deposit Holding (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_deposit_holding" id="in_deposit_holding"></li>
							<li class="nav-header">Deposit Fitout/ Renovation (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_deposit_fitout" id="in_deposit_fitout"></li>
							<li class="nav-header">Total Biaya Sewa (USD)</li>
							<li><input class="input-xlarge" type="text" name="in_total_sewa_usd" id="in_total_sewa_usd"></li>	
							<li class="nav-header">Total Biaya Sewa (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_total_sewa_idr" id="in_total_sewa_idr"></li>	
							<li class="nav-header">Total Biaya Service Charge (USD)</li>
							<li><input class="input-xlarge" type="text" name="in_total_sc_usd" id="in_total_sc_usd"></li>	
							<li class="nav-header">Total Biaya Service Charge (IDR)</li>
							<li><input class="input-xlarge" type="text" name="in_total_sc_idr" id="in_total_sc_idr"></li>
							<li class="nav-header">Total Biaya PL (USD)</li>
							<li><input class="input-xlarge" type="text" name="in_total_pl_usd" id="in_total_pl_usd"></li>	
							<li class="nav-header">Total Biaya PL (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="in_total_pl_idr" id="in_total_pl_idr"></li>			
							<li class="nav-header">Total Biaya Singking (USD)</li>
							<li><input class="input-xlarge" type="text" name="in_total_singking_usd" id="in_total_singking_usd"></li>	
							<li class="nav-header">Total Biaya Singking (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="in_total_singking_idr" id="in_total_singking_idr"></li>		
							<li class="nav-header">Grand Total (USD)</li>
							<li><input class="input-xlarge" type="text" name="in_grand_total_usd" id="in_grand_total_usd"></li>	
							<li class="nav-header">Grand Total (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="in_grand_total_idr" id="in_grand_total_idr"></li>							
							<li class="nav-header">Biaya Sewa/ Bulan (USD)</li>	
							<li><input class="input-xlarge" type="text" name="in_sewa_per_bln_usd" id="in_sewa_per_bln_usd"></li>	
							<li class="nav-header">Biaya Sewa/ Bulan (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="in_sewa_per_bln_idr" id="in_sewa_per_bln_idr"></li>	
							<li class="nav-header">Biaya Service Charge/ Bulan (USD)</li>	
							<li><input class="input-xlarge" type="text" name="in_sc_per_bln_usd" id="in_sc_per_bln_usd"></li>	
							<li class="nav-header">Biaya Service Charge/ Bulan (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="in_sc_per_bln_idr" id="in_sc_per_bln_idr"></li>	
							<li class="nav-header">Biaya PL/ Bulan (USD)</li>	
							<li><input class="input-xlarge" type="text" name="in_pl_per_bln_usd" id="in_pl_per_bln_usd"></li>	
							<li class="nav-header">Biaya PL/ Bulan (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="in_pl_per_bln_idr" id="in_pl_per_bln_idr"></li>		
							<li class="nav-header">Biaya SF/ Bulan (USD)</li>	
							<li><input class="input-xlarge" type="text" name="in_sf_per_bln_usd" id="in_sf_per_bln_usd"></li>	
							<li class="nav-header">Biaya SF/ Bulan (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="in_sf_per_bln_idr" id="in_sf_per_bln_idr"></li>	
							<li class="nav-header">Total Biaya/ Bulan (USD)</li>	
							<li><input class="input-xlarge" type="text" name="in_total_per_bln_usd" id="in_total_per_bln_usd"></li>	
							<li class="nav-header">Total Biaya/ Bulan (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="in_total_per_bln_idr" id="in_total_per_bln_idr"></li>	
							<li class="nav-header">Tahun Sewa Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_thn_sewa" id="in_gs_thn_sewa"></li>
							<li class="nav-header">Awal Sewa Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_awal_sewa" id="in_gs_awal_sewa" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Akhir Sewa Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_akhir_sewa" id="in_gs_akhir_sewa" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Luas Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_luas" id="in_gs_luas"></li>	
							<li class="nav-header">Tarif Gudang Support 1</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_tarif_1" id="in_gs_tarif_1"></li>
							<li class="nav-header">Tarif Gudang Support 2</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_tarif_2" id="in_gs_tarif_2"></li>
							<li class="nav-header">Tarif Gudang Support 3</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_tarif_3" id="in_gs_tarif_3"></li>	
							<li class="nav-header">Tarif Gudang Support 4</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_tarif_4" id="in_gs_tarif_4"></li>
							<li class="nav-header">Tarif Gudang Support 5</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_tarif_5" id="in_gs_tarif_5"></li>	
							<li class="nav-header">Total Biaya Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_total_biaya" id="in_gs_total_biaya"></li>	
							<li class="nav-header">Sewa Konstruksi Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_konstruksi" id="in_gs_total_biaya"></li>
							<li class="nav-header">Sewa Polesign Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_polesign" id="in_gs_polesign"></li>
							<li class="nav-header">Sewa Wallsign Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_wallsign" id="in_gs_wallsign"></li>
							<li class="nav-header">Sewa Pylonsign Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="in_gs_pylonsign" id="in_gs_pylonsign"></li>
							<li class="nav-header">Daya Listrik</li>	
							<li><input class="input-xlarge" type="text" name="in_daya_listrik" id="in_daya_listrik"></li>
							<li class="nav-header">Tarif Listrik</li>	
							<li><input class="input-xlarge" type="text" name="in_tarif_listrik" id="in_tarif_listrik"></li>	
							<li class="nav-header">Fasilitas</li>
							<li><textarea class="input-xlarge" name="in_fasilitas" id="in_fasilitas" rows="3" ></textarea></li>		
							<li class="nav-header">Keterangan</li>
							<li><textarea class="input-xlarge" name="in_keterangan" id="in_keterangan" rows="3"></textarea></li>		
							<li class="nav-header">PIC Perusahaan</li>	
							<li><input class="input-xlarge" type="text" name="in_pic_perusahaan" id="in_pic_perusahaan"></li>
							<li class="nav-header">Alamat PIC</li>
							<li><textarea class="input-xlarge" name="in_pic_alamat" id="in_pic_alamat" rows="3"></textarea></li>	
							<li class="nav-header">Telp/ Fax PIC</li>	
							<li><input class="input-xlarge" type="text" name="in_pic_tlp" id="in_pic_tlp"></li>
							<li class="nav-header">Nama PIC</li>	
							<li><input class="input-xlarge" type="text" name="in_pic_nama" id="in_pic_nama"></li>	
							<li class="nav-header">PIC Financial</li>	
							<li><input class="input-xlarge" type="text" name="in_pic_financial" id="in_pic_financial"></li>	
							<li class="nav-header">Notes/ Catatan</li>
							<li><textarea class="input-xlarge" name="in_notes" id="in_notes" rows="3" ></textarea></li>								
					</ul> 
		        </div>
			</fieldset>
			</form>
		</div>
	     <div class="modal-footer">
			<span id="btn_back_history"></span>			 
	         <button class="btn btn-success" id="submit-edit" >Submit</button>
	         <a href="#" style="text-decoration:none;" class="btn" data-dismiss="modal">Close</a>
  		</div>
	</div>		
	<!-- END FORM EDIT DATA AND SHOW HISTORY-->

	
	<!-- TABLE FOR CHANGES HISTORY -->		
	<div id="change-modal" class="modal hide fade in" style="display: none; ">
		<input type="hidden" id="id_history">
	        <div class="modal-header">
	              <a class="close" data-dismiss="modal">X</a>
	              <h4 id="history_title" style="display:inline"><h6 id="outlet_name" style="display:inline"></h6></h4>
				  
	        </div>
		<div>
			<form class="contact">
			<fieldset>
				<p id="history_outlet_name"><p>
		        <div class="modal-body">
					<div id="history_table_container"></div>
		        </div>
			</fieldset>
			</form>
		</div>
	    <div class="modal-footer">
	         <span id="btn_table_history"></span> <a href="#" style="text-decoration:none;" class="btn" data-dismiss="modal">Close</a>
  		</div>
	</div>			 
	<!-- END FORM FOR HISTORY -->		

	
	<!-- FORM FOR ADD DATA -->
	<div id="form-content-add" class="modal hide fade in" style="display: none; ">
	        <div class="modal-header">
	              <a class="close" data-dismiss="modal">X</a>
	              <h4>Add new outlet <span style="color:red;font-size:9px;">*) required</span></h4>
	        </div>
		<div>
			<form class="contact" name="form-add" id="form-add">
			<fieldset>
		         <div class="modal-body">
		        	 <ul class="nav nav-list">
							<li class="nav-header">Company <span style="color:red;">*</span></li>								
							<li>
					            <select id="add_in_company" name="add_in_company" data-placeholder="Select a Company..." class="chosen-select" style="width:100%;" tabindex="2">
									<option value=""></option>
									<?php foreach($company->result() as $row){
												echo '<option value="'.$row->id_jenisoutlet.'">'.$row->jenisoutlet.'</option>';
									}?>	
								</select>
							</li>					
							<li class="nav-header">Mall <span style="color:red;">*</span></li>
							<li>
					            <select id="add_in_mall" name="add_in_mall" data-placeholder="Select one mall" class="chosen-select" style="width:100%;" tabindex="2">
									<option value=""></option>
								</select>	
								<a href="<?php echo base_url();?>building/input" style="margin-left:100px;width:170px;">Add new  building or mall</a>
							</li>			
							<li class="nav-header">Outlet Code <span style="color:red;">*</span></li>
							<li>
								<input class="input-xlarge" type="text" name="add_in_outlet" id="add_in_outlet">
								<div id="outlet_name_suggestion" class="alert alert-info" role="alert" style="display:none;width:300px;">
								  
								</div>							
							</li>								
					<!--	<li class="nav-header">Plan</li>
							<li><input class="input-xlarge" type="text" name="add_in_plan" id="add_in_plan"></li>	-->						
							<li class="nav-header">City <span style="color:red;">*</span></li>
							<li><input class="input-xlarge" type="text" name="add_in_city" id="add_in_city"></li>

							<li class="nav-header">Opening Date</li>
							<li><input class="input-xlarge" type="text" name="add_in_opening_date" id="add_in_opening_date" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Closing Date</li>
							<li><input class="input-xlarge" type="text" name="add_in_closing_date" id="add_in_closing_date" style="position: relative; z-index: 100000;"></li>	
							<li class="nav-header">Summary</li>
							<li><input class="input-xlarge" type="text" name="add_in_summary" id="add_in_summary" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">LOI</li>
							<li><input class="input-xlarge" type="text" name="add_in_loi" id="add_in_loi" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">PSM</li>
							<li><input class="input-xlarge" type="text" name="add_in_psm" id="add_in_psm" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Thn Sewa</li>
							<li><input class="input-xlarge" type="text" name="add_in_thn_sewa" id="add_in_thn_sewa"></li>
							<li class="nav-header">Mulai Sewa</li>
							<li><input class="input-xlarge" type="text" name="add_in_mulai_sewa" id="add_in_mulai_sewa" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Akhir Sewa</li>
							<li><input class="input-xlarge" type="text" name="add_in_akhir_sewa" id="add_in_akhir_sewa" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Opsi Sewa</li>
							<li><input class="input-xlarge" type="text" name="add_in_opsi_sewa" id="add_in_opsi_sewa"></li>
							<li class="nav-header">Location</li>
							<li><input class="input-xlarge" type="text" name="add_in_location" id="add_in_location"></li>
							<li class="nav-header">Luas 1</li>
							<li><input class="input-xlarge" type="text" name="add_in_luas_1" id="add_in_luas_1"></li>
							<li class="nav-header">Luas 2</li>
							<li><input class="input-xlarge" type="text" name="add_in_luas_2" id="add_in_luas_2"></li>
							<li class="nav-header">Luas 3</li>
							<li><input class="input-xlarge" type="text" name="add_in_luas_3" id="add_in_luas_3"></li>		
							<li class="nav-header">Luas Free</li>
							<li><input class="input-xlarge" type="text" name="add_in_luas_free" id="add_in_luas_free"></li>
							<li class="nav-header">Grace Period</li>
							<li><input class="input-xlarge" type="text" name="add_in_grace_period" id="add_in_grace_period"></li>
							<li class="nav-header">Discount</li>
							<li><input class="input-xlarge" type="text" name="add_in_discount" id="add_in_discount"></li>
							<li class="nav-header">Advance Money/ DP</li>
							<li><input class="input-xlarge" type="text" name="add_in_dp" id="add_in_dp"></li>
							<li class="nav-header">Installment</li>
							<li><input class="input-xlarge" type="text" name="add_in_installment" id="add_in_installment"></li>
							<li class="nav-header">Rate Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="add_in_rate_thn_1" id="add_in_rate_thn_1"></li>
							<li class="nav-header">Rate Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="add_in_rate_thn_2" id="add_in_rate_thn_2"></li>
							<li class="nav-header">Rate Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="add_in_rate_thn_3" id="add_in_rate_thn_3"></li>
							<li class="nav-header">Rate Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="add_in_rate_thn_4" id="add_in_rate_thn_4"></li>
							<li class="nav-header">Rate Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="add_in_rate_thn_5" id="add_in_rate_thn_5"></li>
							<li class="nav-header">Rate Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="add_in_rate_thn_6" id="add_in_rate_thn_6"></li>
							<li class="nav-header">Rate Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="add_in_rate_thn_7" id="add_in_rate_thn_7"></li>
							<li class="nav-header">Rate Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="add_in_rate_thn_8" id="add_in_rate_thn_8"></li>
							<li class="nav-header">Rate Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="add_in_rate_thn_9" id="add_in_rate_thn_9"></li>
							<li class="nav-header">Rate Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="add_in_rate_thn_10" id="add_in_rate_thn_10"></li>	
							<li class="nav-header">Service Charge  Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_thn_1" id="add_in_sc_thn_1"></li>
							<li class="nav-header">Service Charge  Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_thn_2" id="add_in_sc_thn_2"></li>
							<li class="nav-header">Service Charge  Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_thn_3" id="add_in_sc_thn_3"></li>
							<li class="nav-header">Service Charge  Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_thn_4" id="add_in_sc_thn_4"></li>
							<li class="nav-header">Service Charge  Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_thn_5" id="add_in_sc_thn_5"></li>
							<li class="nav-header">Service Charge  Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_thn_6" id="add_in_sc_thn_6"></li>
							<li class="nav-header">Service Charge  Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_thn_7" id="add_in_sc_thn_7"></li>
							<li class="nav-header">Service Charge  Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_thn_8" id="add_in_sc_thn_8"></li>
							<li class="nav-header">Service Charge  Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_thn_9" id="add_in_sc_thn_9"></li>
							<li class="nav-header">Service Charge  Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_thn_10" id="add_in_sc_thn_10"></li>	
							<li class="nav-header">Tarif Indoor (USD) Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_usd_1" id="add_in_indoor_usd_1"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_idr_1" id="add_in_indoor_idr_1"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_usd_1" id="add_in_outdoor_usd_1"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 1</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_idr_1" id="add_in_outdoor_idr_1"></li>	
							<li class="nav-header">Tarif Indoor (USD) Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_usd_2" id="add_in_indoor_usd_2"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_idr_2" id="add_in_indoor_idr_2"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_usd_2" id="add_in_outdoor_usd_2"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 2</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_idr_2" id="add_in_outdoor_idr_2"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_usd_3" id="add_in_indoor_usd_3"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_idr_3" id="add_in_indoor_idr_3"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_usd_3" id="add_in_outdoor_usd_3"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 3</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_idr_3" id="add_in_outdoor_idr_3"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_usd_4" id="add_in_indoor_usd_4"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_idr_4" id="add_in_indoor_idr_4"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_usd_4" id="add_in_outdoor_usd_4"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 4</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_idr_4" id="add_in_outdoor_idr_4"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_usd_5" id="add_in_indoor_usd_5"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_idr_5" id="add_in_indoor_idr_5"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_usd_5" id="add_in_outdoor_usd_5"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 5</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_idr_5" id="add_in_outdoor_idr_5"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_usd_6" id="add_in_indoor_usd_6"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_idr_6" id="add_in_indoor_idr_6"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_usd_6" id="add_in_outdoor_usd_6"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 6</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_idr_6" id="add_in_outdoor_idr_6"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_usd_7" id="add_in_indoor_usd_7"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_idr_7" id="add_in_indoor_idr_7"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_usd_7" id="add_in_outdoor_usd_7"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 7</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_idr_7" id="add_in_outdoor_idr_7"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_usd_8" id="add_in_indoor_usd_8"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_idr_8" id="add_in_indoor_idr_8"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_usd_8" id="add_in_outdoor_usd_8"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 8</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_idr_8" id="add_in_outdoor_idr_8"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_usd_9" id="add_in_indoor_usd_9"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_idr_9" id="add_in_indoor_idr_9"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_usd_9" id="add_in_outdoor_usd_9"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 9</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_idr_9" id="add_in_outdoor_idr_9"></li>							
							<li class="nav-header">Tarif Indoor (USD) Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_usd_10" id="add_in_indoor_usd_10"></li>	
							<li class="nav-header">Tarif Indoor (IDR) Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="add_in_indoor_idr_10" id="add_in_indoor_idr_10"></li>
							<li class="nav-header">Tarif Outdoor (USD) Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_usd_10" id="add_in_outdoor_usd_10"></li>	
							<li class="nav-header">Tarif Outdoor (IDR) Tahun 10</li>
							<li><input class="input-xlarge" type="text" name="add_in_outdoor_idr_10" id="add_in_outdoor_idr_10"></li>	
							<li class="nav-header">Service Charge Indoor (USD)</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_indoor_usd" id="add_in_sc_indoor_usd"></li>	
							<li class="nav-header">Service Charge Indoor (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_indoor_idr" id="add_in_sc_indoor_idr"></li>
							<li class="nav-header">Service Charge Outdoor (USD)</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_outdoor_usd" id="add_in_sc_outdoor_usd"></li>	
							<li class="nav-header">Service Charge Outdoor (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_sc_outdoor_idr" id="add_in_sc_outdoor_idr"></li>	
							<li class="nav-header">PL @Month (USD)</li>
							<li><input class="input-xlarge" type="text" name="add_in_pl_month_usd" id="add_in_pl_month_usd"></li>		
							<li class="nav-header">PL @Month (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_pl_month_idr" id="add_in_pl_month_idr"></li>	
							<li class="nav-header">PL Tahun (USD)</li>
							<li><input class="input-xlarge" type="text" name="add_in_pl_year_usd" id="add_in_pl_year_usd"></li>		
							<li class="nav-header">PL Tahun (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_pl_year_idr" id="add_in_pl_year_idr"></li>							
							
							<li class="nav-header">PL Onetime (USD)</li>
							<li><input class="input-xlarge" type="text" name="add_in_pl_onetine_usd" id="add_in_pl_onetine_usd"></li>	
							<li class="nav-header">PL Onetime (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_pl_onetine_idr" id="add_in_pl_onetine_idr"></li>	
							<li class="nav-header">Singking Fund (USD)</li>
							<li><input class="input-xlarge" type="text" name="add_in_singking_usd" id="add_in_singking_usd"></li>	
							<li class="nav-header">Singking Fund (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_singking_idr" id="add_in_singking_idr"></li>
							<li class="nav-header">Deposit Sewa (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_deposit_sewa" id="add_in_deposit_sewa"></li>		
							<li class="nav-header">Deposit Service Charge (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_deposit_sc" id="add_in_deposit_sc"></li>
							<li class="nav-header">Deposit Telpon (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_deposit_tlp" id="add_in_deposit_tlp"></li>
							<li class="nav-header">Deposit Internet (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_deposit_inet" id="add_in_deposit_inet"></li>
							<li class="nav-header">Deposit Listrik (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_deposit_listrik" id="add_in_deposit_listrik"></li>
							<li class="nav-header">Deposit Air & Gas (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_deposit_air" id="add_in_deposit_air"></li>
							<li class="nav-header">Deposit Wallsign (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_deposit_wallsign" id="add_in_deposit_wallsign"></li>
							<li class="nav-header">Deposit Holding (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_deposit_holding" id="add_in_deposit_holding"></li>
							<li class="nav-header">Deposit Fitout/ Renovation (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_deposit_fitout" id="add_in_deposit_fitout"></li>
							<li class="nav-header">Total Biaya Sewa (USD)</li>
							<li><input class="input-xlarge" type="text" name="add_in_total_sewa_usd" id="add_in_total_sewa_usd"></li>	
							<li class="nav-header">Total Biaya Sewa (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_total_sewa_idr" id="add_in_total_sewa_idr"></li>	
							<li class="nav-header">Total Biaya Service Charge (USD)</li>
							<li><input class="input-xlarge" type="text" name="add_in_total_sc_usd" id="add_in_total_sc_usd"></li>	
							<li class="nav-header">Total Biaya Service Charge (IDR)</li>
							<li><input class="input-xlarge" type="text" name="add_in_total_sc_idr" id="add_in_total_sc_idr"></li>
							<li class="nav-header">Total Biaya PL (USD)</li>
							<li><input class="input-xlarge" type="text" name="add_in_total_pl_usd" id="add_in_total_pl_usd"></li>	
							<li class="nav-header">Total Biaya PL (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_total_pl_idr" id="add_in_total_pl_idr"></li>			
							<li class="nav-header">Total Biaya Singking (USD)</li>
							<li><input class="input-xlarge" type="text" name="add_in_total_singking_usd" id="add_in_total_singking_usd"></li>	
							<li class="nav-header">Total Biaya Singking (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_total_singking_idr" id="add_in_total_singking_idr"></li>		
							<li class="nav-header">Grand Total (USD)</li>
							<li><input class="input-xlarge" type="text" name="add_in_grand_total_usd" id="add_in_grand_total_usd"></li>	
							<li class="nav-header">Grand Total (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_grand_total_idr" id="add_in_grand_total_idr"></li>							
							<li class="nav-header">Biaya Sewa/ Bulan (USD)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_sewa_per_bln_usd" id="add_in_sewa_per_bln_usd"></li>	
							<li class="nav-header">Biaya Sewa/ Bulan (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_sewa_per_bln_idr" id="add_in_sewa_per_bln_idr"></li>	
							<li class="nav-header">Biaya Service Charge/ Bulan (USD)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_sc_per_bln_usd" id="add_in_sc_per_bln_usd"></li>	
							<li class="nav-header">Biaya Service Charge/ Bulan (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_sc_per_bln_idr" id="add_in_sc_per_bln_idr"></li>	
							<li class="nav-header">Biaya PL/ Bulan (USD)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_pl_per_bln_usd" id="add_in_pl_per_bln_usd"></li>	
							<li class="nav-header">Biaya PL/ Bulan (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_pl_per_bln_idr" id="add_in_pl_per_bln_idr"></li>		
							<li class="nav-header">Biaya SF/ Bulan (USD)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_sf_per_bln_usd" id="add_in_sf_per_bln_usd"></li>	
							<li class="nav-header">Biaya SF/ Bulan (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_sf_per_bln_idr" id="add_in_sf_per_bln_idr"></li>	
							<li class="nav-header">Total Biaya/ Bulan (USD)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_total_per_bln_usd" id="add_in_total_per_bln_usd"></li>	
							<li class="nav-header">Total Biaya/ Bulan (IDR)</li>	
							<li><input class="input-xlarge" type="text" name="add_in_total_per_bln_idr" id="add_in_total_per_bln_idr"></li>	
							<li class="nav-header">Tahun Sewa Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_thn_sewa" id="add_in_gs_thn_sewa"></li>
							<li class="nav-header">Awal Sewa Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_awal_sewa" id="add_in_gs_awal_sewa" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Akhir Sewa Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_akhir_sewa" id="add_in_gs_akhir_sewa" style="position: relative; z-index: 100000;"></li>
							<li class="nav-header">Luas Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_luas" id="add_in_gs_luas"></li>	
							<li class="nav-header">Tarif Gudang Support 1</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_tarif_1" id="add_in_gs_tarif_1"></li>
							<li class="nav-header">Tarif Gudang Support 2</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_tarif_2" id="add_in_gs_tarif_2"></li>
							<li class="nav-header">Tarif Gudang Support 3</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_tarif_3" id="add_in_gs_tarif_3"></li>	
							<li class="nav-header">Tarif Gudang Support 4</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_tarif_4" id="add_in_gs_tarif_4"></li>
							<li class="nav-header">Tarif Gudang Support 5</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_tarif_5" id="add_in_gs_tarif_5"></li>	
							<li class="nav-header">Total Biaya Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_total_biaya" id="add_in_gs_total_biaya"></li>	
							<li class="nav-header">Sewa Konstruksi Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_konstruksi" id="add_in_gs_total_biaya"></li>
							<li class="nav-header">Sewa Polesign Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_polesign" id="add_in_gs_polesign"></li>
							<li class="nav-header">Sewa Wallsign Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_wallsign" id="add_in_gs_wallsign"></li>
							<li class="nav-header">Sewa Pylonsign Gudang Support</li>	
							<li><input class="input-xlarge" type="text" name="add_in_gs_pylonsign" id="add_in_gs_pylonsign"></li>
							<li class="nav-header">Daya Listrik</li>	
							<li><input class="input-xlarge" type="text" name="add_in_daya_listrik" id="add_in_daya_listrik"></li>
							<li class="nav-header">Tarif Listrik</li>	
							<li><input class="input-xlarge" type="text" name="add_in_tarif_listrik" id="add_in_tarif_listrik"></li>	
							<li class="nav-header">Fasilitas</li>
							<li><textarea class="input-xlarge" name="add_in_fasilitas" id="add_in_fasilitas" rows="3" ></textarea></li>		
							<li class="nav-header">Keterangan</li>
							<li><textarea class="input-xlarge" name="add_in_keterangan" id="add_in_keterangan" rows="3"></textarea></li>		
							<li class="nav-header">PIC Perusahaan</li>	
							<li><input class="input-xlarge" type="text" name="add_in_pic_perusahaan" id="add_in_pic_perusahaan"></li>
							<li class="nav-header">Alamat PIC</li>
							<li><textarea class="input-xlarge" name="add_in_pic_alamat" id="add_in_pic_alamat" rows="3"></textarea></li>	
							<li class="nav-header">Telp/ Fax PIC</li>	
							<li><input class="input-xlarge" type="text" name="add_in_pic_tlp" id="add_in_pic_tlp"></li>
							<li class="nav-header">Nama PIC</li>	
							<li><input class="input-xlarge" type="text" name="add_in_pic_nama" id="add_in_pic_nama"></li>	
							<li class="nav-header">PIC Financial</li>	
							<li><input class="input-xlarge" type="text" name="add_in_pic_financial" id="add_in_pic_financial"></li>	
							<li class="nav-header">Notes/ Catatan</li>
							<li><textarea class="input-xlarge" name="add_in_notes" id="add_in_notes" rows="3" ></textarea></li>								
					</ul> 
		        </div>
			</fieldset>
			</form>
		</div>
	     <div class="modal-footer">			 
	         <button class="btn btn-success" id="submit-add" >Submit</button>
	         <a href="#" style="text-decoration:none;" class="btn" data-dismiss="modal">Close</a>
  		</div>
	</div>		
	<!-- END FORM FOR ADD DATA -->
	
	
<table id="gridTable" class="display" cellspacing="0" width="100%">
    <thead>
	
        <tr>
            <th>ID</th>
            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th>Outlet Code</th>			
            <th>Outlet Name</th>	
			<th>Mall</th>			
			<th>Plant</th>
			<th>City</th>	
			<th>Company</th>
			<th>Opening Date</th>
			<th>Closing Date</th>	
			<th>Thn Sewa</th>
			<th>Mulai Sewa</th>
			<th>Akhir Sewa</th>
			<th>Summary</th>
			<th>LOI</th>
			<th>PSM</th>			
			<th>Opsi Sewa</th>
			<th>Location</th>
			<th>Large Area</th>
			<th>Large Area 2</th>
			<th>Large Area 3</th>
			<th>Large Area Free</th>	
			<th>Grace Period</th>
			<th>Discount</th>
			<th>Advance Money/ DP</th>
			<th>Installment</th>
			<th>Tahun Sewa: 1</th>
			<th>Tahun Sewa: 2</th>		
			<th>Tahun Sewa: 3</th>
			<th>Tahun Sewa: 4</th>	
			<th>Tahun Sewa: 5</th>
			<th>Tahun Sewa: 6</th>	
			<th>Tahun Sewa: 7</th>
			<th>Tahun Sewa: 8</th>	
			<th>Tahun Sewa: 9</th>
			<th>Tahun Sewa: 10</th>	
			<th>Service Charge <br/>Tahun: 1</th>
			<th>Service Charge <br/>Tahun: 2</th>		
			<th>Service Charge <br/>Tahun: 3</th>
			<th>Service Charge <br/>Tahun: 4</th>	
			<th>Service Charge <br/>Tahun: 5</th>
			<th>Service Charge <br/>Tahun: 6</th>	
			<th>Service Charge <br/>Tahun: 7</th>
			<th>Service Charge <br/>Tahun: 8</th>	
			<th>Service Charge <br/>Tahun: 9</th>
			<th>Service Charge <br/>Tahun: 10</th>	
			<th>Indoor Charge <br/>(USD) : 1</th>
			<th>Indoor Charge <br/>(IDR) : 1</th>
			<th>Outdoor Charge <br/>(USD) : 1</th>	
			<th>Outdoor Charge <br/>(IDR) : 1</th>	
			<th>Indoor Charge <br/>(USD) : 2</th>
			<th>Indoor Charge <br/>(IDR) : 2</th>
			<th>Outdoor Charge <br/>(USD) : 2</th>	
			<th>Outdoor Charge <br/>(IDR) : 2</th>			
			<th>Indoor Charge <br/>(USD) : 3</th>
			<th>Indoor Charge <br/>(IDR) : 3</th>
			<th>Outdoor Charge <br/>(USD) : 3</th>	
			<th>Outdoor Charge <br/>(IDR) : 3</th>			
			<th>Indoor Charge <br/>(USD) : 4</th>
			<th>Indoor Charge <br/>(IDR) : 4</th>
			<th>Outdoor Charge <br/>(USD) : 4</th>	
			<th>Outdoor Charge <br/>(IDR) : 4</th>			
			<th>Indoor Charge <br/>(USD) : 5</th>
			<th>Indoor Charge <br/>(IDR) : 5</th>
			<th>Outdoor Charge <br/>(USD) : 5</th>	
			<th>Outdoor Charge <br/>(IDR) : 5</th>			
			<th>Indoor Charge <br/>(USD) : 6</th>
			<th>Indoor Charge <br/>(IDR) : 6</th>
			<th>Outdoor Charge <br/>(USD) : 6</th>	
			<th>Outdoor Charge <br/>(IDR) : 6</th>		
			<th>Indoor Charge <br/>(USD) : 7</th>
			<th>Indoor Charge <br/>(IDR) : 7</th>
			<th>Outdoor Charge <br/>(USD) : 7</th>	
			<th>Outdoor Charge <br/>(IDR) : 7</th>			
			<th>Indoor Charge <br/>(USD) : 8</th>
			<th>Indoor Charge <br/>(IDR) : 8</th>
			<th>Outdoor Charge <br/>(USD) : 8</th>	
			<th>Outdoor Charge <br/>(IDR) : 8</th>
			<th>Indoor Charge <br/>(USD) : 9</th>
			<th>Indoor Charge <br/>(IDR) : 9</th>
			<th>Outdoor Charge <br/>(USD) : 9</th>	
			<th>Outdoor Charge <br/>(IDR) : 9</th>			
			<th>Indoor Charge <br/>(USD) : 10</th>
			<th>Indoor Charge <br/>(IDR) : 10</th>	
			<th>Outdoor Charge <br/>(USD) : 10</th>	
			<th>Outdoor Charge <br/>(IDR) : 10</th>				
			<th>Service Charge <br/>Indoor (USD)</th>	
			<th>Service Charge <br/>Indoor (IDR)</th>
			<th>Service Charge <br/>Outdoor (USD)</th>
			<th>Service Charge <br/>Outdoor (IDR)</th>	
			<th>PL @ Month <br/>(USD)</th>	
			<th>PL @ Month <br/>(IDR)</th>
			<th>PL Tahun <br/>(USD)</th>
			<th>PL Tahun <br/>(IDR)</th>				
			<th>PL Onetime <br/>(USD)</th>
			<th>PL Onetime <br/>(IDR)</th>	
			<th>Singking Fund <br/>(USD)</th>				
			<th>Singking Fund <br/>(IDR)</th>
			<th>Deposit <br/>Sewa (IDR)</th>	
			<th>Deposit <br/>Service Charge (IDR)</th>	
			<th>Deposit <br/>Telpon (IDR)</th>
			<th>Deposit <br/>Internet (IDR)</th>
			<th>Deposit <br/>Listrik (IDR)</th>
			<th>Deposit <br/>Air & Gas (IDR)</th>
			<th>Deposit <br/>Wallsign (IDR)</th>
			<th>Deposit <br/>Holding (IDR)</th>
			<th>Deposit <br/>Fitout/ Renovation (IDR)</th>					
			<th>Total Biaya <br/>Sewa (USD)</th>		
			<th>Total Biaya <br/>Sewa (IDR)</th>	
			<th>Total Biaya <br/>Service Charge (USD)</th>		
			<th>Total Biaya <br/>Service Charge (IDR)</th>
			<th>Total Biaya <br/>PL (USD)</th>				
			<th>Total Biaya <br/>PL (IDR)</th>	
			<th>Total Biaya <br/>Singking (USD)</th>				
			<th>Total Biaya <br/>Singking (IDR)</th>			
			<th>TOTAL (USD)</th>	
			<th>TOTAL (IDR)</th>	
			<th>Biaya Sewa <br/>/ Bulan (USD)</th>	
			<th>Biaya Sewa <br/>/ Bulan (IDR)</th>	
			<th>Biaya Service Charge <br/>/ Bulan (USD)</th>	
			<th>Biaya Service Charge <br/>/ Bulan (IDR)</th>	
			<th>Biaya PL <br/>/ Bulan (USD)</th>	
			<th>Biaya PL <br/>/ Bulan (IDR)</th>	
			<th>Biaya SF <br/>/ Bulan (USD)</th>	
			<th>Biaya SF <br/>/ Bulan (IDR)</th>				
			<th>Total Biaya <br/>/ Bulan (USD)</th>	
			<th>Total Biaya <br/>/ Bulan (IDR)</th>				
			<th>Gudang Support <br/>Jumlah Thn Sewa</th>	
			<th>Gudang Support <br/>Awal Masa Sewa</th>			
			<th>Gudang Support <br/>Akhir Masa Sewa</th>
			<th>Gudang Support <br/>Luas</th>
			<th>Gudang Support <br/>Tarif 1</th>
			<th>Gudang Support <br/>Tarif 2</th>
			<th>Gudang Support <br/>Tarif 3</th>
			<th>Gudang Support <br/>Tarif 4</th>
			<th>Gudang Support <br/>Tarif 5</th>	
			<th>Gudang Support <br/>TOTAL BIAYA</th>
			<th>Sewa <br/>Konstruksi (Rp)</th>
			<th>Sewa <br/>Polesign (Rp)</th>
			<th>Sewa <br/>Wallsign (Rp)</th>
			<th>Sewa <br/>Pylonsign (Rp)</th>
			<th>Daya Listrik</th>
			<th>Tarif Listrik</th>	
			<th>Fasilitas</th>
			<th>Keterangan</th>
			<th>PIC <br/>Perusahaan</th>
			<th>PIC <br/>Alamat</th>
			<th>PIC <br/>Telpon/Fax</th>
			<th>PIC <br/>Nama</th>
			<th>PIC <br/>Financial</th>		
			<th>NOTES</th>		
        </tr>
    </thead>
</table>			


	<script src="<?php echo base_url();?>js/chosen.jquery.min.js"></script> 
	<script type="text/javascript">
		var config = {
		  '.chosen-select'           : {search_contains:true},
		  '.chosen-select-deselect'  : {allow_single_deselect:true},
		  '.chosen-select-no-single' : {disable_search_threshold:0},
		  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		  '.chosen-select-width'     : {width:"95%"}
		}
		for (var selector in config) {
		  $(selector).chosen(config[selector]);
		}
	</script>	
	
<br/><br/>
