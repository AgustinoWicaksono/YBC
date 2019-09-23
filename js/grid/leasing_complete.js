	function add(){
		$( "div#add_in_company_chosen" ).find( "a.chosen-single" ).empty().append('<span>Select a Company...</span><div><b></b></div>');
		$( "div#add_in_mall_chosen" ).find( "a.chosen-single" ).empty().append('<span>Select one mall</span><div><b></b></div>');
		$( "div#add_in_mall_chosen" ).find( "ul.chosen-results" ).empty();
		$('#outlet_name_suggestion').hide();


		$('#form-add')[0].reset();

		
		$('input#add_or_edit').val("add");
		$('#add_in_outlet').attr('disabled','disabled');
		$('#add_in_city').attr('disabled','disabled');
	}

	function showHistoryItem(idd,num,change,usr,date){
		var id_history = 	$('#id_history').val();
		document.getElementById("btn_back_history").innerHTML = '<a onclick="showHistory('+id_history+')" data-toggle="modal" href="#change-modal" style="text-decoration:none;" class="btn" data-dismiss="modal">Back</a>';
		document.getElementById("title").innerHTML = 'Changes details - Changes ' + num;
		$('#changer').html(change + ' By: ' + usr+ ' On:' + date);
		$('button#submit').hide();

		$('input#add_or_edit').val("historyItem");
		
					$.ajax({
						url: "show_history_item",
						type: "POST",
						global: true,
						async: true,
						cache: false,
						dataType: "json",
						data: {id:idd},
						success:function(data)
						{	
							/*******   DISABLE ANY INPUTS   *******/
							$("#form1 :input").prop("disabled", true);
						
							$('#row_id').val(data.history_item[0]['ID']);
							$('#in_outlet').val(data.history_item[0]['SEWA_OUTLET']);
							$('#in_mall').val(data.history_item[0]['SEWA_MALL']);
							$('#in_plan').val(data.history_item[0]['SEWA_PLANT']);
							$('#in_city').val(data.history_item[0]['SEWA_CITY']);
							$('#in_company').val(data.history_item[0]['SEWA_COMPANY']);
							$('#in_opening_date').val(data.history_item[0]['SEWA_OPENING_DATE']);	
							$('#in_closing_date').val(data.history_item[0]['SEWA_CLOSING_DATE']);	
							$('#in_summary').val(data.history_item[0]['SEWA_SUMMARY']);	
							$('#in_loi').val(data.history_item[0]['SEWA_LOI']);	
							$('#in_psm').val(data.history_item[0]['SEWA_PSM']);	
							$('#in_thn_sewa').val(data.history_item[0]['SEWA_JML_TAHUN']);	
							$('#in_mulai_sewa').val(data.history_item[0]['SEWA_AWAL']);	
							$('#in_akhir_sewa').val(data.history_item[0]['SEWA_AKHIR']);	
							$('#in_opsi_sewa').val(data.history_item[0]['SEWA_OPSI']);	
							$('#in_location').val(data.history_item[0]['SEWA_LOCATION']);	
							$('#in_luas_1').val(data.history_item[0]['SEWA_LUAS_1']);	
							$('#in_luas_2').val(data.history_item[0]['SEWA_LUAS_2']);	
							$('#in_luas_3').val(data.history_item[0]['SEWA_LUAS_3']);	
							$('#in_luas_free').val(data.history_item[0]['SEWA_LUAS_FREE']);	
							$('#in_grace_period').val(data.history_item[0]['SEWA_GRACEPERIOD']);	
							$('#in_discount').val(data.history_item[0]['SEWA_DISC']);	
							$('#in_dp').val(data.history_item[0]['SEWA_DP']);	
							$('#in_installment').val(data.history_item[0]['SEWA_INSTALLMENT']);	
							$('#in_rate_thn_1').val(data.history_item[0]['SEWA_RATE_TAHUN_1']);	
							$('#in_rate_thn_2').val(data.history_item[0]['SEWA_RATE_TAHUN_2']);	
							$('#in_rate_thn_3').val(data.history_item[0]['SEWA_RATE_TAHUN_3']);	
							$('#in_rate_thn_4').val(data.history_item[0]['SEWA_RATE_TAHUN_4']);	
							$('#in_rate_thn_5').val(data.history_item[0]['SEWA_RATE_TAHUN_5']);	
							$('#in_rate_thn_6').val(data.history_item[0]['SEWA_RATE_TAHUN_6']);	
							$('#in_rate_thn_7').val(data.history_item[0]['SEWA_RATE_TAHUN_7']);	
							$('#in_rate_thn_8').val(data.history_item[0]['SEWA_RATE_TAHUN_8']);	
							$('#in_rate_thn_9').val(data.history_item[0]['SEWA_RATE_TAHUN_9']);	
							$('#in_rate_thn_10').val(data.history_item[0]['SEWA_RATE_TAHUN_10']);	
							$('#in_sc_thn_1').val(data.history_item[0]['SEWA_RATE_SC_1']);	
							$('#in_sc_thn_2').val(data.history_item[0]['SEWA_RATE_SC_2']);	
							$('#in_sc_thn_3').val(data.history_item[0]['SEWA_RATE_SC_3']);	
							$('#in_sc_thn_4').val(data.history_item[0]['SEWA_RATE_SC_4']);	
							$('#in_sc_thn_5').val(data.history_item[0]['SEWA_RATE_SC_5']);	
							$('#in_sc_thn_6').val(data.history_item[0]['SEWA_RATE_SC_6']);	
							$('#in_sc_thn_7').val(data.history_item[0]['SEWA_RATE_SC_7']);	
							$('#in_sc_thn_8').val(data.history_item[0]['SEWA_RATE_SC_8']);	
							$('#in_sc_thn_9').val(data.history_item[0]['SEWA_RATE_SC_9']);	
							$('#in_sc_thn_10').val(data.history_item[0]['SEWA_RATE_SC_10']);	
							$('#in_indoor_usd_1').val(data.history_item[0]['SEWA_TARIF_INDOOR_USD_01']);	
							$('#in_indoor_idr_1').val(data.history_item[0]['SEWA_TARIF_INDOOR_IDR_01']);	
							$('#in_outdoor_usd_1').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_USD_01']);	
							$('#in_outdoor_idr_1').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_IDR_01']);	
							$('#in_indoor_usd_2').val(data.history_item[0]['SEWA_TARIF_INDOOR_USD_02']);	
							$('#in_indoor_idr_2').val(data.history_item[0]['SEWA_TARIF_INDOOR_IDR_02']);	
							$('#in_outdoor_usd_2').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_USD_02']);	
							$('#in_outdoor_idr_2').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_IDR_02']);	
							$('#in_indoor_usd_3').val(data.history_item[0]['SEWA_TARIF_INDOOR_USD_03']);	
							$('#in_indoor_idr_3').val(data.history_item[0]['SEWA_TARIF_INDOOR_IDR_03']);	
							$('#in_outdoor_usd_3').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_USD_03']);	
							$('#in_outdoor_idr_3').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_IDR_03']);	
							$('#in_indoor_usd_4').val(data.history_item[0]['SEWA_TARIF_INDOOR_USD_04']);	
							$('#in_indoor_idr_4').val(data.history_item[0]['SEWA_TARIF_INDOOR_IDR_04']);	
							$('#in_outdoor_usd_4').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_USD_04']);	
							$('#in_outdoor_idr_4').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_IDR_04']);	
							$('#in_indoor_usd_5').val(data.history_item[0]['SEWA_TARIF_INDOOR_USD_05']);	
							$('#in_indoor_idr_5').val(data.history_item[0]['SEWA_TARIF_INDOOR_IDR_05']);	
							$('#in_outdoor_usd_5').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_USD_05']);	
							$('#in_outdoor_idr_5').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_IDR_05']);	
							$('#in_indoor_usd_6').val(data.history_item[0]['SEWA_TARIF_INDOOR_USD_06']);	
							$('#in_indoor_idr_6').val(data.history_item[0]['SEWA_TARIF_INDOOR_IDR_06']);	
							$('#in_outdoor_usd_6').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_USD_06']);	
							$('#in_outdoor_idr_6').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_IDR_06']);	
							$('#in_indoor_usd_7').val(data.history_item[0]['SEWA_TARIF_INDOOR_USD_07']);	
							$('#in_indoor_idr_7').val(data.history_item[0]['SEWA_TARIF_INDOOR_IDR_07']);	
							$('#in_outdoor_usd_7').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_USD_07']);	
							$('#in_outdoor_idr_7').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_IDR_07']);	
							$('#in_indoor_usd_8').val(data.history_item[0]['SEWA_TARIF_INDOOR_USD_08']);	
							$('#in_indoor_idr_8').val(data.history_item[0]['SEWA_TARIF_INDOOR_IDR_08']);	
							$('#in_outdoor_usd_8').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_USD_08']);	
							$('#in_outdoor_idr_8').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_IDR_08']);	
							$('#in_indoor_usd_9').val(data.history_item[0]['SEWA_TARIF_INDOOR_USD_09']);	
							$('#in_indoor_idr_9').val(data.history_item[0]['SEWA_TARIF_INDOOR_IDR_09']);	
							$('#in_outdoor_usd_9').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_USD_09']);	
							$('#in_outdoor_idr_9').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_IDR_09']);	
							$('#in_indoor_usd_10').val(data.history_item[0]['SEWA_TARIF_INDOOR_USD_10']);	
							$('#in_indoor_idr_10').val(data.history_item[0]['SEWA_TARIF_INDOOR_IDR_10']);	
							$('#in_outdoor_usd_10').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_USD_10']);	
							$('#in_outdoor_idr_10').val(data.history_item[0]['SEWA_TARIF_OUTDOOR_IDR_10']);	
							$('#in_sc_indoor_usd').val(data.history_item[0]['SEWA_TARIF_SC_INDOOR_USD']);	
							$('#in_sc_indoor_idr').val(data.history_item[0]['SEWA_TARIF_SC_INDOOR_IDR']);	
							$('#in_sc_outdoor_usd').val(data.history_item[0]['SEWA_TARIF_SC_OUTDOOR_USD']);	
							$('#in_sc_outdoor_idr').val(data.history_item[0]['SEWA_TARIF_SC_OUTDOOR_IDR']);	
							$('#in_pl_month_usd').val(data.history_item[0]['SEWA_TARIF_PL_BULAN_USD']);	
							$('#in_pl_month_idr').val(data.history_item[0]['SEWA_TARIF_PL_BULAN_IDR']);	
							$('#in_pl_onetine_usd').val(data.history_item[0]['SEWA_TARIF_PL_ONETIME_USD']);	
							$('#in_pl_onetine_idr').val(data.history_item[0]['SEWA_TARIF_PL_ONETIME_IDR']);	
							$('#in_singking_usd').val(data.history_item[0]['SEWA_TARIF_SINGKINGFUND_USD']);	
							$('#in_singking_idr').val(data.history_item[0]['SEWA_TARIF_SINGKINGFUND_IDR']);	
							$('#in_deposit_sewa').val(data.history_item[0]['SEWA_DEPOSIT_SEWA_VALUE']);	
							$('#in_deposit_sc').val(data.history_item[0]['SEWA_DEPOSIT_SC_VALUE']);	
							$('#in_deposit_tlp').val(data.history_item[0]['SEWA_DEPOSIT_TELP_VALUE']);	
							$('#in_deposit_inet').val(data.history_item[0]['SEWA_DEPOSIT_INET_VALUE']);	
							$('#in_deposit_listrik').val(data.history_item[0]['SEWA_DEPOSIT_LISTRIK_VALUE']);	
							$('#in_deposit_air').val(data.history_item[0]['SEWA_DEPOSIT_AIR_GAS_VALUE']);	
							$('#in_deposit_wallsign').val(data.history_item[0]['SEWA_DEPOSIT_WALLSIGN_VALUE']);	
							$('#in_deposit_holding').val(data.history_item[0]['SEWA_DEPOSIT_HOLDING_VALUE']);	
							$('#in_deposit_fitout').val(data.history_item[0]['SEWA_DEPOSIT_FITOUT_VALUE']);	
							$('#in_total_sewa_usd').val(data.history_item[0]['SEWA_TOTAL_SEWA_USD']);	
							$('#in_total_sewa_idr').val(data.history_item[0]['SEWA_TOTAL_SEWA_IDR']);	
							$('#in_total_sc_usd').val(data.history_item[0]['SEWA_TOTAL_SC_USD']);	
							$('#in_total_sc_idr').val(data.history_item[0]['SEWA_TOTAL_SC_IDR']);	
							$('#in_total_pl_usd').val(data.history_item[0]['SEWA_TOTAL_PL_USD']);	
							$('#in_total_pl_idr').val(data.history_item[0]['SEWA_TOTAL_PL_IDR']);	
							$('#in_total_singking_usd').val(data.history_item[0]['SEWA_TOTAL_SINGKING_USD']);	
							$('#in_total_singking_idr').val(data.history_item[0]['SEWA_TOTAL_SINGKING_IDR']);	
							$('#in_grand_total_usd').val(data.history_item[0]['SEWA_TOTAL_USD']);	
							$('#in_grand_total_idr').val(data.history_item[0]['SEWA_TOTAL_IDR']);	
							$('#in_sewa_per_bln_usd').val(data.history_item[0]['x_PERBLN_SEWA_USD']);	
							$('#in_sewa_per_bln_idr').val(data.history_item[0]['x_PERBLN_SEWA_IDR']);	
							$('#in_sc_per_bln_usd').val(data.history_item[0]['x_PERBLN_SC_USD']);	
							$('#in_sc_per_bln_idr').val(data.history_item[0]['x_PERBLN_SC_IDR']);	
							$('#in_pl_per_bln_usd').val(data.history_item[0]['x_PERBLN_PL_USD']);	
							$('#in_pl_per_bln_idr').val(data.history_item[0]['x_PERBLN_PL_IDR']);	
							$('#in_sf_per_bln_usd').val(data.history_item[0]['x_PERBLN_SF_USD']);	
							$('#in_sf_per_bln_idr').val(data.history_item[0]['x_PERBLN_SF_IDR']);	
							$('#in_total_per_bln_usd').val(data.history_item[0]['x_PERBLN_TOTAL_USD']);	
							$('#in_total_per_bln_idr').val(data.history_item[0]['x_PERBLN_TOTAL_IDR']);	
							$('#in_gs_thn_sewa').val(data.history_item[0]['SEWA_GUDANGSUPPORT_JML_THN']);	
							$('#in_gs_awal_sewa').val(data.history_item[0]['SEWA_GUDANGSUPPORT_AWAL']);	
							$('#in_gs_akhir_sewa').val(data.history_item[0]['SEWA_GUDANGSUPPORT_AKHIR']);	
							$('#in_gs_luas').val(data.history_item[0]['SEWA_GUDANGSUPPORT_LUAS']);	
							$('#in_gs_tarif_1').val(data.history_item[0]['SEWA_GUDANGSUPPORT_TARIF_01']);	
							$('#in_gs_tarif_2').val(data.history_item[0]['SEWA_GUDANGSUPPORT_TARIF_02']);	
							$('#in_gs_tarif_3').val(data.history_item[0]['SEWA_GUDANGSUPPORT_TARIF_03']);	
							$('#in_gs_tarif_4').val(data.history_item[0]['SEWA_GUDANGSUPPORT_TARIF_04']);	
							$('#in_gs_tarif_5').val(data.history_item[0]['SEWA_GUDANGSUPPORT_TARIF_05']);	
							$('#in_gs_total_biaya').val(data.history_item[0]['SEWA_GUDANGSUPPORT_BIAYA']);	
							$('#in_gs_konstruksi').val(data.history_item[0]['SEWA_KONSTRUKSI_VALUE']);	
							$('#in_gs_polesign').val(data.history_item[0]['SEWA_POLESIGN_VALUE']);	
							$('#in_gs_wallsign').val(data.history_item[0]['SEWA_WALLSIGN_VALUE']);	
							$('#in_gs_pylonsign').val(data.history_item[0]['SEWA_PYLONSIGN_VALUE']);	
							$('#in_daya_listrik').val(data.history_item[0]['SEWA_LISTRIK_DATA']);	
							$('#in_tarif_listrik').val(data.history_item[0]['SEWA_LISTRIK_TARIF']);	
							$('#in_fasilitas').val(data.history_item[0]['SEWA_FASILITAS']);	
							$('#in_keterangan').val(data.history_item[0]['SEWA_KETERANGAN']);	
							$('#in_pic_perusahaan').val(data.history_item[0]['SEWA_PIC_PERUSAHAAN']);	
							$('#in_pic_alamat').val(data.history_item[0]['SEWA_PIC_ALAMAT']);	
							$('#in_pic_tlp').val(data.history_item[0]['SEWA_PIC_TELP']);	
							$('#in_pic_nama').val(data.history_item[0]['SEWA_PIC_NAMA']);	
							$('#in_pic_financial').val(data.history_item[0]['SEWA_PIC_FIN']);
							$('#in_notes').val(data.history_item[0]['GLOBAL_COMMENT']);
						},
						error: function(){						
							alert('Error while request..');
						}
					});		
	}
	
	function change(time) {
		if(time == null){
			return '00/00/0000';
		}else{
			var r 		= time.split(" ");
			var date 	= r[0].split("-");
			return date[1] + '/' + date[2] + '/' + date[0];		
		}
	}

	function showDueDateItem(idd){
		document.getElementById("btn_back_history").innerHTML = '<a onclick="showHistory()" data-toggle="modal" href="#change-modal" style="text-decoration:none;" class="btn" data-dismiss="modal">Back</a>';
		document.getElementById("title").innerHTML = 'Due Date Detail ';
		$('#changer').html('');
		$('button#submit-edit').hide();
		$('button#submit').hide();

		$('input#add_or_edit').val("historyItem");
		
					$.ajax({
						url: "edit_browse_complete",
						type: "POST",
						global: true,
						async: true,
						cache: false,
						dataType: "json",
						data: {id:idd},
						success:function(data)
						{
							/*******   DISABLE ANY INPUTS   *******/
							$("#form1 :input").prop("disabled", true);
						
							$('#row_id').val(data.sewa_mall[0]['ID']);
							$('#in_outlet').val(data.sewa_mall[0]['SEWA_OUTLET']);
							$('#in_mall').val(data.sewa_mall[0]['SEWA_MALL']);
							$('#in_plan').val(data.sewa_mall[0]['SEWA_PLANT']);
							$('#in_city').val(data.sewa_mall[0]['SEWA_CITY']);
							$('#in_company').val(data.sewa_mall[0]['SEWA_COMPANY']);
							$('#in_opening_date').val(data.sewa_mall[0]['SEWA_OPENING_DATE']);	
							$('#in_closing_date').val(data.sewa_mall[0]['SEWA_CLOSING_DATE']);	
							$('#in_summary').val(data.sewa_mall[0]['SEWA_SUMMARY']);	
							$('#in_loi').val(data.sewa_mall[0]['SEWA_LOI']);	
							$('#in_psm').val(data.sewa_mall[0]['SEWA_PSM']);	
							$('#in_thn_sewa').val(data.sewa_mall[0]['SEWA_JML_TAHUN']);	
							$('#in_mulai_sewa').val(data.sewa_mall[0]['SEWA_AWAL']);	
							$('#in_akhir_sewa').val(data.sewa_mall[0]['SEWA_AKHIR']);	
							$('#in_opsi_sewa').val(data.sewa_mall[0]['SEWA_OPSI']);	
							$('#in_location').val(data.sewa_mall[0]['SEWA_LOCATION']);	
							$('#in_luas_1').val(data.sewa_mall[0]['SEWA_LUAS_1']);	
							$('#in_luas_2').val(data.sewa_mall[0]['SEWA_LUAS_2']);	
							$('#in_luas_3').val(data.sewa_mall[0]['SEWA_LUAS_3']);	
							$('#in_luas_free').val(data.sewa_mall[0]['SEWA_LUAS_FREE']);	
							$('#in_grace_period').val(data.sewa_mall[0]['SEWA_GRACEPERIOD']);	
							$('#in_discount').val(data.sewa_mall[0]['SEWA_DISC']);	
							$('#in_dp').val(data.sewa_mall[0]['SEWA_DP']);	
							$('#in_installment').val(data.sewa_mall[0]['SEWA_INSTALLMENT']);	
							$('#in_rate_thn_1').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_1']);	
							$('#in_rate_thn_2').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_2']);	
							$('#in_rate_thn_3').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_3']);	
							$('#in_rate_thn_4').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_4']);	
							$('#in_rate_thn_5').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_5']);	
							$('#in_rate_thn_6').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_6']);	
							$('#in_rate_thn_7').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_7']);	
							$('#in_rate_thn_8').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_8']);	
							$('#in_rate_thn_9').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_9']);	
							$('#in_rate_thn_10').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_10']);	
							$('#in_sc_thn_1').val(data.sewa_mall[0]['SEWA_RATE_SC_1']);	
							$('#in_sc_thn_2').val(data.sewa_mall[0]['SEWA_RATE_SC_2']);	
							$('#in_sc_thn_3').val(data.sewa_mall[0]['SEWA_RATE_SC_3']);	
							$('#in_sc_thn_4').val(data.sewa_mall[0]['SEWA_RATE_SC_4']);	
							$('#in_sc_thn_5').val(data.sewa_mall[0]['SEWA_RATE_SC_5']);	
							$('#in_sc_thn_6').val(data.sewa_mall[0]['SEWA_RATE_SC_6']);	
							$('#in_sc_thn_7').val(data.sewa_mall[0]['SEWA_RATE_SC_7']);	
							$('#in_sc_thn_8').val(data.sewa_mall[0]['SEWA_RATE_SC_8']);	
							$('#in_sc_thn_9').val(data.sewa_mall[0]['SEWA_RATE_SC_9']);	
							$('#in_sc_thn_10').val(data.sewa_mall[0]['SEWA_RATE_SC_10']);	
							$('#in_indoor_usd_1').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_01']);	
							$('#in_indoor_idr_1').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_01']);	
							$('#in_outdoor_usd_1').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_01']);	
							$('#in_outdoor_idr_1').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_01']);	
							$('#in_indoor_usd_2').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_02']);	
							$('#in_indoor_idr_2').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_02']);	
							$('#in_outdoor_usd_2').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_02']);	
							$('#in_outdoor_idr_2').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_02']);	
							$('#in_indoor_usd_3').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_03']);	
							$('#in_indoor_idr_3').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_03']);	
							$('#in_outdoor_usd_3').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_03']);	
							$('#in_outdoor_idr_3').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_03']);	
							$('#in_indoor_usd_4').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_04']);	
							$('#in_indoor_idr_4').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_04']);	
							$('#in_outdoor_usd_4').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_04']);	
							$('#in_outdoor_idr_4').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_04']);	
							$('#in_indoor_usd_5').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_05']);	
							$('#in_indoor_idr_5').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_05']);	
							$('#in_outdoor_usd_5').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_05']);	
							$('#in_outdoor_idr_5').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_05']);	
							$('#in_indoor_usd_6').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_06']);	
							$('#in_indoor_idr_6').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_06']);	
							$('#in_outdoor_usd_6').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_06']);	
							$('#in_outdoor_idr_6').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_06']);	
							$('#in_indoor_usd_7').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_07']);	
							$('#in_indoor_idr_7').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_07']);	
							$('#in_outdoor_usd_7').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_07']);	
							$('#in_outdoor_idr_7').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_07']);	
							$('#in_indoor_usd_8').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_08']);	
							$('#in_indoor_idr_8').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_08']);	
							$('#in_outdoor_usd_8').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_08']);	
							$('#in_outdoor_idr_8').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_08']);	
							$('#in_indoor_usd_9').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_09']);	
							$('#in_indoor_idr_9').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_09']);	
							$('#in_outdoor_usd_9').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_09']);	
							$('#in_outdoor_idr_9').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_09']);	
							$('#in_indoor_usd_10').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_10']);	
							$('#in_indoor_idr_10').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_10']);	
							$('#in_outdoor_usd_10').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_10']);	
							$('#in_outdoor_idr_10').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_10']);	
							$('#in_sc_indoor_usd').val(data.sewa_mall[0]['SEWA_TARIF_SC_INDOOR_USD']);	
							$('#in_sc_indoor_idr').val(data.sewa_mall[0]['SEWA_TARIF_SC_INDOOR_IDR']);	
							$('#in_sc_outdoor_usd').val(data.sewa_mall[0]['SEWA_TARIF_SC_OUTDOOR_USD']);	
							$('#in_sc_outdoor_idr').val(data.sewa_mall[0]['SEWA_TARIF_SC_OUTDOOR_IDR']);	
							$('#in_pl_month_usd').val(data.sewa_mall[0]['SEWA_TARIF_PL_BULAN_USD']);	
							$('#in_pl_month_idr').val(data.sewa_mall[0]['SEWA_TARIF_PL_BULAN_IDR']);	
							$('#in_pl_onetine_usd').val(data.sewa_mall[0]['SEWA_TARIF_PL_ONETIME_USD']);	
							$('#in_pl_onetine_idr').val(data.sewa_mall[0]['SEWA_TARIF_PL_ONETIME_IDR']);	
							$('#in_singking_usd').val(data.sewa_mall[0]['SEWA_TARIF_SINGKINGFUND_USD']);	
							$('#in_singking_idr').val(data.sewa_mall[0]['SEWA_TARIF_SINGKINGFUND_IDR']);	
							$('#in_deposit_sewa').val(data.sewa_mall[0]['SEWA_DEPOSIT_SEWA_VALUE']);	
							$('#in_deposit_sc').val(data.sewa_mall[0]['SEWA_DEPOSIT_SC_VALUE']);	
							$('#in_deposit_tlp').val(data.sewa_mall[0]['SEWA_DEPOSIT_TELP_VALUE']);	
							$('#in_deposit_inet').val(data.sewa_mall[0]['SEWA_DEPOSIT_INET_VALUE']);	
							$('#in_deposit_listrik').val(data.sewa_mall[0]['SEWA_DEPOSIT_LISTRIK_VALUE']);	
							$('#in_deposit_air').val(data.sewa_mall[0]['SEWA_DEPOSIT_AIR_GAS_VALUE']);	
							$('#in_deposit_wallsign').val(data.sewa_mall[0]['SEWA_DEPOSIT_WALLSIGN_VALUE']);	
							$('#in_deposit_holding').val(data.sewa_mall[0]['SEWA_DEPOSIT_HOLDING_VALUE']);	
							$('#in_deposit_fitout').val(data.sewa_mall[0]['SEWA_DEPOSIT_FITOUT_VALUE']);	
							$('#in_total_sewa_usd').val(data.sewa_mall[0]['SEWA_TOTAL_SEWA_USD']);	
							$('#in_total_sewa_idr').val(data.sewa_mall[0]['SEWA_TOTAL_SEWA_IDR']);	
							$('#in_total_sc_usd').val(data.sewa_mall[0]['SEWA_TOTAL_SC_USD']);	
							$('#in_total_sc_idr').val(data.sewa_mall[0]['SEWA_TOTAL_SC_IDR']);	
							$('#in_total_pl_usd').val(data.sewa_mall[0]['SEWA_TOTAL_PL_USD']);	
							$('#in_total_pl_idr').val(data.sewa_mall[0]['SEWA_TOTAL_PL_IDR']);	
							$('#in_total_singking_usd').val(data.sewa_mall[0]['SEWA_TOTAL_SINGKING_USD']);	
							$('#in_total_singking_idr').val(data.sewa_mall[0]['SEWA_TOTAL_SINGKING_IDR']);	
							$('#in_grand_total_usd').val(data.sewa_mall[0]['SEWA_TOTAL_USD']);	
							$('#in_grand_total_idr').val(data.sewa_mall[0]['SEWA_TOTAL_IDR']);	
							$('#in_sewa_per_bln_usd').val(data.sewa_mall[0]['x_PERBLN_SEWA_USD']);	
							$('#in_sewa_per_bln_idr').val(data.sewa_mall[0]['x_PERBLN_SEWA_IDR']);	
							$('#in_sc_per_bln_usd').val(data.sewa_mall[0]['x_PERBLN_SC_USD']);	
							$('#in_sc_per_bln_idr').val(data.sewa_mall[0]['x_PERBLN_SC_IDR']);	
							$('#in_pl_per_bln_usd').val(data.sewa_mall[0]['x_PERBLN_PL_USD']);	
							$('#in_pl_per_bln_idr').val(data.sewa_mall[0]['x_PERBLN_PL_IDR']);	
							$('#in_sf_per_bln_usd').val(data.sewa_mall[0]['x_PERBLN_SF_USD']);	
							$('#in_sf_per_bln_idr').val(data.sewa_mall[0]['x_PERBLN_SF_IDR']);	
							$('#in_total_per_bln_usd').val(data.sewa_mall[0]['x_PERBLN_TOTAL_USD']);	
							$('#in_total_per_bln_idr').val(data.sewa_mall[0]['x_PERBLN_TOTAL_IDR']);	
							$('#in_gs_thn_sewa').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_JML_THN']);	
							$('#in_gs_awal_sewa').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_AWAL']);	
							$('#in_gs_akhir_sewa').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_AKHIR']);	
							$('#in_gs_luas').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_LUAS']);	
							$('#in_gs_tarif_1').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_01']);	
							$('#in_gs_tarif_2').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_02']);	
							$('#in_gs_tarif_3').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_03']);	
							$('#in_gs_tarif_4').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_04']);	
							$('#in_gs_tarif_5').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_05']);	
							$('#in_gs_total_biaya').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_BIAYA']);	
							$('#in_gs_konstruksi').val(data.sewa_mall[0]['SEWA_KONSTRUKSI_VALUE']);	
							$('#in_gs_polesign').val(data.sewa_mall[0]['SEWA_POLESIGN_VALUE']);	
							$('#in_gs_wallsign').val(data.sewa_mall[0]['SEWA_WALLSIGN_VALUE']);	
							$('#in_gs_pylonsign').val(data.sewa_mall[0]['SEWA_PYLONSIGN_VALUE']);	
							$('#in_daya_listrik').val(data.sewa_mall[0]['SEWA_LISTRIK_DATA']);	
							$('#in_tarif_listrik').val(data.sewa_mall[0]['SEWA_LISTRIK_TARIF']);	
							$('#in_fasilitas').val(data.sewa_mall[0]['SEWA_FASILITAS']);	
							$('#in_keterangan').val(data.sewa_mall[0]['SEWA_KETERANGAN']);	
							$('#in_pic_perusahaan').val(data.sewa_mall[0]['SEWA_PIC_PERUSAHAAN']);	
							$('#in_pic_alamat').val(data.sewa_mall[0]['SEWA_PIC_ALAMAT']);	
							$('#in_pic_tlp').val(data.sewa_mall[0]['SEWA_PIC_TELP']);	
							$('#in_pic_nama').val(data.sewa_mall[0]['SEWA_PIC_NAMA']);	
							$('#in_pic_financial').val(data.sewa_mall[0]['SEWA_PIC_FIN']);
							$('#in_notes').val(data.sewa_mall[0]['GLOBAL_COMMENT']);
						},
						error: function(){						
							alert('Error while request..');
						}
					});		
	}	

	function show_attention(){
				$.ajax({
					type: "POST",
					url: 'show_sewa_attention',
					dataType: "HTML",
					success: function(html){
						$('#history_title').empty().append('Outlet due date');	
						$("#history_table_container").empty().append(html);	
						$("#btn_table_history").empty().append('');
						$('#change-modal').modal();						
					},
					error: function(msg){
						alert(msg.statusText);
						return msg;
					}
				});		
	}
/*
	function show_history_table(id){

		$('#gridTable2').dataTable( {	
				"destroy": true,
				"scrollY": "400px",
				"scrollCollapse": true,					
				"scrollX": true,
				"bProcessing": true,
				"bServerSide": true,
				"fnServerParams": function (aoData) {
					aoData.push( { "name": "idd", "value": id } );
				},				
				"sAjaxSource": "browse_complete_data_history",

				'fnServerData': function(sSource, aoData, fnCallback){
				
					$.ajax({
						'dataType': 'json',
						'type'    : 'POST',
						'url'     : sSource,
						'data'    : aoData,
						'success' : function(res){
							 console.log(res.data);
							 fnCallback(res);
						},
						'error'	:	function(){
							alert("Error");
						}
					});
				}	
		});	
			
	}
*/	
	function outlet_name_selected(){
		var outlet_name = document.querySelector('input[name="outlet_name_chosen"]:checked').value;

			$('#add_in_outlet').attr('disabled','disabled');
			$('#add_in_outlet').val(outlet_name);

	}

	function check_outlet_name(name){
		var result ='';
		$.ajax({
				url: "check_outlet_name",
				type: "POST",
				global: true,
				async: false,
				cache: false,
				dataType: "HTML",
				data: {outlet_name:name},
				success:function(data)
				{	
						result = data;					
				},
				error: function(){						
						alert('Error while request..');
				}
		});										
		return result;
	}	
		
	$(document).ready(function() {
		/*******************  Show Table 1st time  *******************/
		$('#gridTable').dataTable( {
				"scrollY": "400px",
				"scrollCollapse": true,		
				"scrollX": true,
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "browse_complete_data",
				"columnDefs": [ {
								"targets": -147,
								"data": null,
								"defaultContent": "<a href='#form-content' data-toggle='modal'><img id='edit' src='../images/icons/EditOrange16.png'></a> <a><img id='delete' src='../images/icons/DeleteRed16.png'></a> <a href='#change-modal' data-toggle='modal'><img id='history' alt='History of this item' src='../images/icons/calendar.png'></a>"
								} ],
				'fnServerData': function(sSource, aoData, fnCallback){
				
					$.ajax({
						'dataType': 'json',
						'type'    : 'POST',
						'url'     : sSource,
						'data'    : aoData,
						'success' : function(res){
							 console.log(res.data);
							 fnCallback(res);
						},
						'error'	:	function(){
							alert("Error");
						}
					});
				}	
		});	  
	
		
		/*******************  Set warning 1st time page load  *******************/
		setTimeout(function() {
			show_attention();
		},3000);		
		
		/*******************  Edit a Row  *******************/
		$('#gridTable tbody').on( 'click', 'img#edit', function () {
			var idd  = $(this).closest('td').siblings(':first-child').text();
			document.getElementById("title").innerHTML = 'Edit outlet data <span style="color:red;font-size:9px;">*) required</span>';
			document.getElementById("btn_back_history").innerHTML = '';
			$('#changer').html('');
			$('button#submit-edit').show();
			$('button#submit').show();
			$('input#add_or_edit').val("edit");
			
						$.ajax({
							url: "edit_browse_complete",
							type: "POST",
							global: true,
							async: true,
							cache: false,
							dataType: "json",
							data: {id:idd},
							success:function(data)
							{
								/*******   ENABLE ANY INPUTS   *******/
								$("#form1 :input").prop("disabled", false);	
							
								/* Disable some inputs */
								$('#in_outlet').attr('disabled','disabled');
								$('#in_mall').attr('disabled','disabled');
								$('#in_plan').attr('disabled','disabled');
								$('#in_city').attr('disabled','disabled');
								$('#in_company').attr('disabled','disabled');							
							
								/*  FILL DATA   */
								$('#row_id').val(data.sewa_mall[0]['ID']);
								$('#in_outlet').val(data.sewa_mall[0]['SEWA_OUTLET']);
								$('#in_mall').val(data.sewa_mall[0]['SEWA_MALL']);
								$('#in_plan').val(data.sewa_mall[0]['SEWA_PLANT']);
								$('#in_city').val(data.sewa_mall[0]['SEWA_CITY']);
								$('#in_company').val(data.sewa_mall[0]['SEWA_COMPANY']);
								$('#in_opening_date').val(change(data.sewa_mall[0]['SEWA_OPENING_DATE']));	
								$('#in_closing_date').val(change(data.sewa_mall[0]['SEWA_CLOSING_DATE']));	
								$('#in_summary').val(change(data.sewa_mall[0]['SEWA_SUMMARY']));	
								$('#in_loi').val(change(data.sewa_mall[0]['SEWA_LOI']));	
								$('#in_psm').val(change(data.sewa_mall[0]['SEWA_PSM']));	
								$('#in_thn_sewa').val(data.sewa_mall[0]['SEWA_JML_TAHUN']);	
								$('#in_mulai_sewa').val(change(data.sewa_mall[0]['SEWA_AWAL']));	
								$('#in_akhir_sewa').val(change(data.sewa_mall[0]['SEWA_AKHIR']));	
								$('#in_opsi_sewa').val(data.sewa_mall[0]['SEWA_OPSI']);	
								$('#in_location').val(data.sewa_mall[0]['SEWA_LOCATION']);	
								$('#in_luas_1').val(data.sewa_mall[0]['SEWA_LUAS_1']);	
								$('#in_luas_2').val(data.sewa_mall[0]['SEWA_LUAS_2']);	
								$('#in_luas_3').val(data.sewa_mall[0]['SEWA_LUAS_3']);	
								$('#in_luas_free').val(data.sewa_mall[0]['SEWA_LUAS_FREE']);	
								$('#in_grace_period').val(data.sewa_mall[0]['SEWA_GRACEPERIOD']);	
								$('#in_discount').val(data.sewa_mall[0]['SEWA_DISC']);	
								$('#in_dp').val(data.sewa_mall[0]['SEWA_DP']);	
								$('#in_installment').val(data.sewa_mall[0]['SEWA_INSTALLMENT']);	
								$('#in_rate_thn_1').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_1']);	
								$('#in_rate_thn_2').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_2']);	
								$('#in_rate_thn_3').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_3']);	
								$('#in_rate_thn_4').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_4']);	
								$('#in_rate_thn_5').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_5']);	
								$('#in_rate_thn_6').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_6']);	
								$('#in_rate_thn_7').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_7']);	
								$('#in_rate_thn_8').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_8']);	
								$('#in_rate_thn_9').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_9']);	
								$('#in_rate_thn_10').val(data.sewa_mall[0]['SEWA_RATE_TAHUN_10']);	
								$('#in_sc_thn_1').val(data.sewa_mall[0]['SEWA_RATE_SC_1']);	
								$('#in_sc_thn_2').val(data.sewa_mall[0]['SEWA_RATE_SC_2']);	
								$('#in_sc_thn_3').val(data.sewa_mall[0]['SEWA_RATE_SC_3']);	
								$('#in_sc_thn_4').val(data.sewa_mall[0]['SEWA_RATE_SC_4']);	
								$('#in_sc_thn_5').val(data.sewa_mall[0]['SEWA_RATE_SC_5']);	
								$('#in_sc_thn_6').val(data.sewa_mall[0]['SEWA_RATE_SC_6']);	
								$('#in_sc_thn_7').val(data.sewa_mall[0]['SEWA_RATE_SC_7']);	
								$('#in_sc_thn_8').val(data.sewa_mall[0]['SEWA_RATE_SC_8']);	
								$('#in_sc_thn_9').val(data.sewa_mall[0]['SEWA_RATE_SC_9']);	
								$('#in_sc_thn_10').val(data.sewa_mall[0]['SEWA_RATE_SC_10']);	
								$('#in_indoor_usd_1').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_01']);	
								$('#in_indoor_idr_1').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_01']);	
								$('#in_outdoor_usd_1').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_01']);	
								$('#in_outdoor_idr_1').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_01']);	
								$('#in_indoor_usd_2').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_02']);	
								$('#in_indoor_idr_2').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_02']);	
								$('#in_outdoor_usd_2').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_02']);	
								$('#in_outdoor_idr_2').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_02']);	
								$('#in_indoor_usd_3').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_03']);	
								$('#in_indoor_idr_3').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_03']);	
								$('#in_outdoor_usd_3').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_03']);	
								$('#in_outdoor_idr_3').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_03']);	
								$('#in_indoor_usd_4').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_04']);	
								$('#in_indoor_idr_4').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_04']);	
								$('#in_outdoor_usd_4').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_04']);	
								$('#in_outdoor_idr_4').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_04']);	
								$('#in_indoor_usd_5').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_05']);	
								$('#in_indoor_idr_5').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_05']);	
								$('#in_outdoor_usd_5').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_05']);	
								$('#in_outdoor_idr_5').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_05']);	
								$('#in_indoor_usd_6').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_06']);	
								$('#in_indoor_idr_6').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_06']);	
								$('#in_outdoor_usd_6').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_06']);	
								$('#in_outdoor_idr_6').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_06']);	
								$('#in_indoor_usd_7').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_07']);	
								$('#in_indoor_idr_7').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_07']);	
								$('#in_outdoor_usd_7').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_07']);	
								$('#in_outdoor_idr_7').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_07']);	
								$('#in_indoor_usd_8').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_08']);	
								$('#in_indoor_idr_8').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_08']);	
								$('#in_outdoor_usd_8').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_08']);	
								$('#in_outdoor_idr_8').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_08']);	
								$('#in_indoor_usd_9').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_09']);	
								$('#in_indoor_idr_9').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_09']);	
								$('#in_outdoor_usd_9').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_09']);	
								$('#in_outdoor_idr_9').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_09']);	
								$('#in_indoor_usd_10').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_10']);	
								$('#in_indoor_idr_10').val(data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_10']);	
								$('#in_outdoor_usd_10').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_10']);	
								$('#in_outdoor_idr_10').val(data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_10']);	
								$('#in_sc_indoor_usd').val(data.sewa_mall[0]['SEWA_TARIF_SC_INDOOR_USD']);	
								$('#in_sc_indoor_idr').val(data.sewa_mall[0]['SEWA_TARIF_SC_INDOOR_IDR']);	
								$('#in_sc_outdoor_usd').val(data.sewa_mall[0]['SEWA_TARIF_SC_OUTDOOR_USD']);	
								$('#in_sc_outdoor_idr').val(data.sewa_mall[0]['SEWA_TARIF_SC_OUTDOOR_IDR']);	
								$('#in_pl_month_usd').val(data.sewa_mall[0]['SEWA_TARIF_PL_BULAN_USD']);	
								$('#in_pl_month_idr').val(data.sewa_mall[0]['SEWA_TARIF_PL_BULAN_IDR']);	
								$('#in_pl_onetine_usd').val(data.sewa_mall[0]['SEWA_TARIF_PL_ONETIME_USD']);	
								$('#in_pl_onetine_idr').val(data.sewa_mall[0]['SEWA_TARIF_PL_ONETIME_IDR']);	
								$('#in_singking_usd').val(data.sewa_mall[0]['SEWA_TARIF_SINGKINGFUND_USD']);	
								$('#in_singking_idr').val(data.sewa_mall[0]['SEWA_TARIF_SINGKINGFUND_IDR']);	
								$('#in_deposit_sewa').val(data.sewa_mall[0]['SEWA_DEPOSIT_SEWA_VALUE']);	
								$('#in_deposit_sc').val(data.sewa_mall[0]['SEWA_DEPOSIT_SC_VALUE']);	
								$('#in_deposit_tlp').val(data.sewa_mall[0]['SEWA_DEPOSIT_TELP_VALUE']);	
								$('#in_deposit_inet').val(data.sewa_mall[0]['SEWA_DEPOSIT_INET_VALUE']);	
								$('#in_deposit_listrik').val(data.sewa_mall[0]['SEWA_DEPOSIT_LISTRIK_VALUE']);	
								$('#in_deposit_air').val(data.sewa_mall[0]['SEWA_DEPOSIT_AIR_GAS_VALUE']);	
								$('#in_deposit_wallsign').val(data.sewa_mall[0]['SEWA_DEPOSIT_WALLSIGN_VALUE']);	
								$('#in_deposit_holding').val(data.sewa_mall[0]['SEWA_DEPOSIT_HOLDING_VALUE']);	
								$('#in_deposit_fitout').val(data.sewa_mall[0]['SEWA_DEPOSIT_FITOUT_VALUE']);	
								$('#in_total_sewa_usd').val(data.sewa_mall[0]['SEWA_TOTAL_SEWA_USD']);	
								$('#in_total_sewa_idr').val(data.sewa_mall[0]['SEWA_TOTAL_SEWA_IDR']);	
								$('#in_total_sc_usd').val(data.sewa_mall[0]['SEWA_TOTAL_SC_USD']);	
								$('#in_total_sc_idr').val(data.sewa_mall[0]['SEWA_TOTAL_SC_IDR']);	
								$('#in_total_pl_usd').val(data.sewa_mall[0]['SEWA_TOTAL_PL_USD']);	
								$('#in_total_pl_idr').val(data.sewa_mall[0]['SEWA_TOTAL_PL_IDR']);	
								$('#in_total_singking_usd').val(data.sewa_mall[0]['SEWA_TOTAL_SINGKING_USD']);	
								$('#in_total_singking_idr').val(data.sewa_mall[0]['SEWA_TOTAL_SINGKING_IDR']);	
								$('#in_grand_total_usd').val(data.sewa_mall[0]['SEWA_TOTAL_USD']);	
								$('#in_grand_total_idr').val(data.sewa_mall[0]['SEWA_TOTAL_IDR']);	
								$('#in_sewa_per_bln_usd').val(data.sewa_mall[0]['x_PERBLN_SEWA_USD']);	
								$('#in_sewa_per_bln_idr').val(data.sewa_mall[0]['x_PERBLN_SEWA_IDR']);	
								$('#in_sc_per_bln_usd').val(data.sewa_mall[0]['x_PERBLN_SC_USD']);	
								$('#in_sc_per_bln_idr').val(data.sewa_mall[0]['x_PERBLN_SC_IDR']);	
								$('#in_pl_per_bln_usd').val(data.sewa_mall[0]['x_PERBLN_PL_USD']);	
								$('#in_pl_per_bln_idr').val(data.sewa_mall[0]['x_PERBLN_PL_IDR']);	
								$('#in_sf_per_bln_usd').val(data.sewa_mall[0]['x_PERBLN_SF_USD']);	
								$('#in_sf_per_bln_idr').val(data.sewa_mall[0]['x_PERBLN_SF_IDR']);	
								$('#in_total_per_bln_usd').val(data.sewa_mall[0]['x_PERBLN_TOTAL_USD']);	
								$('#in_total_per_bln_idr').val(data.sewa_mall[0]['x_PERBLN_TOTAL_IDR']);	
								$('#in_gs_thn_sewa').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_JML_THN']);	
								$('#in_gs_awal_sewa').val(change(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_AWAL']));	
								$('#in_gs_akhir_sewa').val(change(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_AKHIR']));	
								$('#in_gs_luas').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_LUAS']);	
								$('#in_gs_tarif_1').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_01']);	
								$('#in_gs_tarif_2').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_02']);	
								$('#in_gs_tarif_3').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_03']);	
								$('#in_gs_tarif_4').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_04']);	
								$('#in_gs_tarif_5').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_05']);	
								$('#in_gs_total_biaya').val(data.sewa_mall[0]['SEWA_GUDANGSUPPORT_BIAYA']);	
								$('#in_gs_konstruksi').val(data.sewa_mall[0]['SEWA_KONSTRUKSI_VALUE']);	
								$('#in_gs_polesign').val(data.sewa_mall[0]['SEWA_POLESIGN_VALUE']);	
								$('#in_gs_wallsign').val(data.sewa_mall[0]['SEWA_WALLSIGN_VALUE']);	
								$('#in_gs_pylonsign').val(data.sewa_mall[0]['SEWA_PYLONSIGN_VALUE']);	
								$('#in_daya_listrik').val(data.sewa_mall[0]['SEWA_LISTRIK_DATA']);	
								$('#in_tarif_listrik').val(data.sewa_mall[0]['SEWA_LISTRIK_TARIF']);	
								$('#in_fasilitas').val(data.sewa_mall[0]['SEWA_FASILITAS']);	
								$('#in_keterangan').val(data.sewa_mall[0]['SEWA_KETERANGAN']);	
								$('#in_pic_perusahaan').val(data.sewa_mall[0]['SEWA_PIC_PERUSAHAAN']);	
								$('#in_pic_alamat').val(data.sewa_mall[0]['SEWA_PIC_ALAMAT']);	
								$('#in_pic_tlp').val(data.sewa_mall[0]['SEWA_PIC_TELP']);	
								$('#in_pic_nama').val(data.sewa_mall[0]['SEWA_PIC_NAMA']);	
								$('#in_pic_financial').val(data.sewa_mall[0]['SEWA_PIC_FIN']);	
								$('#in_notes').val(data.sewa_mall[0]['GLOBAL_COMMENT']);	

								$('#mulai_sewa_before').val(change(data.sewa_mall[0]['SEWA_AWAL']));	
								$('#akhir_sewa_before').val(change(data.sewa_mall[0]['SEWA_AKHIR']));
								
							},
							error: function(){						
								alert('Error while request..');
							}
						});				
								
		});	
		
		/*******************  Delete a Row  *******************/
		$('#gridTable tbody').on( 'click', 'img#delete', function () {
			var id  = $(this).closest('td').siblings(':first-child').text();
			var tr  = $(this).closest('tr');			
			if (confirm("Are you sure you want to delete row " + id + "? ")){
				$.ajax({
					   type: "POST",
					   url: "delete_browse_complete",
					   data: {delId : id},
					   cache: false,					
					   success: function()
					   {								
							tr.fadeOut('slow', function() {$(this).remove();});
					   }
				 }); 
			}		
		});		
		
		/*******************  Show Row Histroy  *******************/
		$('#gridTable tbody').on( 'click', 'img#history', function () {
			var id  = $(this).closest('td').siblings(':first-child').text();	
			var malls  = $(this).closest('td').siblings(':nth-child(3)').text();			
			$('#id_history').val(id);
			$('#history_title').empty().append('Changes history - <span style="font-size: 16px;">' + malls + '</span>');
			$("#btn_table_history").empty().append('<a id="btn_history_table" onclick=window.open("../leasing/browse_result_history/'+id+'") style="text-decoration:none;" class="btn" data-dismiss="modal">Show history in table format</a>');
			/*$('#outlet_name').html(mall);*/
				$.ajax({
					type: "POST",
					url: 'show_sewa_history',
					data: {outletId : id},
					dataType: "HTML",
					success: function(html){
						$("#history_table_container").empty().append(html);	
						if(html != '<center>No data</center>'){											
								$('#history_table').dataTable( {
									"scrollX": true,
									"bDestroy": true
								});		
								$('#btn_history_table').show();
						}else{
								$('#btn_history_table').hide();
						}			
					},
					error: function(msg){
						alert(msg.statusText);
						return msg;
					}

				});			
		} );		


		/*******************  Datepicked all date input *******************/
		$('#in_opening_date').datepick();
		$('#in_closing_date').datepick();
		$('#in_summary').datepick();
		$('#in_loi').datepick();
		$('#in_psm').datepick();
		$('#in_mulai_sewa').datepick();
		$('#in_akhir_sewa').datepick();
		$('#in_gs_awal_sewa').datepick();
		$('#in_gs_akhir_sewa').datepick();
		$('#add_in_opening_date').datepick();
		$('#add_in_closing_date').datepick();
		$('#add_in_summary').datepick();
		$('#add_in_loi').datepick();
		$('#add_in_psm').datepick();
		$('#add_in_mulai_sewa').datepick();
		$('#add_in_akhir_sewa').datepick();
		$('#add_in_gs_awal_sewa').datepick();
		$('#add_in_gs_akhir_sewa').datepick();
	
	
	
		/*******************  Submit Data For Add  *******************/
		$("#submit-add").click(function(){
				var add_or_edit		=	$('#add_or_edit').val();
				var in_outlet =			$('#add_in_outlet').val();
				var in_mall =			$('#add_in_mall').val();
			/*	var in_plan =			$('#add_in_plan').val(); */
				var in_city =			$('#add_in_city').val();
				var in_company =		$('#add_in_company').val();
				var in_opening_date =	$('#add_in_opening_date').val();	
				var in_closing_date =	$('#add_in_closing_date').val();	
				var in_summary =		$('#add_in_summary').val();	
				var in_loi =			$('#add_in_loi').val();	
				var in_psm =			$('#add_in_psm').val();	
				var in_thn_sewa =		$('#add_in_thn_sewa').val();	
				var in_mulai_sewa =		$('#add_in_mulai_sewa').val();	
				var in_akhir_sewa =		$('#add_in_akhir_sewa').val();	
				var in_opsi_sewa =		$('#add_in_opsi_sewa').val();	
				var in_location =		$('#add_in_location').val();	
				var in_luas_1 =			$('#add_in_luas_1').val();	
				var in_luas_2 =			$('#add_in_luas_2').val();	
				var in_luas_3 =			$('#add_in_luas_3').val();	
				var in_luas_free =		$('#add_in_luas_free').val();	
				var in_grace_period =	$('#add_in_grace_period').val();	
				var in_discount =		$('#add_in_discount').val();	
				var in_dp =				$('#add_in_dp').val();	
				var in_installment =	$('#add_in_installment').val();	
				var in_rate_thn_1 =	$('#add_in_rate_thn_1').val();	
				var in_rate_thn_2 =	$('#add_in_rate_thn_2').val();	
				var in_rate_thn_3 =	$('#add_in_rate_thn_3').val();	
				var in_rate_thn_4 =	$('#add_in_rate_thn_4').val();	
				var in_rate_thn_5 =	$('#add_in_rate_thn_5').val();	
				var in_rate_thn_6 =	$('#add_in_rate_thn_6').val();	
				var in_rate_thn_7 =	$('#add_in_rate_thn_7').val();	
				var in_rate_thn_8 =	$('#add_in_rate_thn_8').val();	
				var in_rate_thn_9 =	$('#add_in_rate_thn_9').val();
				var in_rate_thn_10 =$('#add_in_rate_thn_10').val();			
				var in_sc_thn_1 =	$('#add_in_sc_thn_1').val();	
				var in_sc_thn_2 =	$('#add_in_sc_thn_2').val();	
				var in_sc_thn_3 =	$('#add_in_sc_thn_3').val();	
				var in_sc_thn_4 =	$('#add_in_sc_thn_4').val();	
				var in_sc_thn_5 =	$('#add_in_sc_thn_5').val();	
				var in_sc_thn_6 =	$('#add_in_sc_thn_6').val();	
				var in_sc_thn_7 =	$('#add_in_sc_thn_7').val();	
				var in_sc_thn_8 =	$('#add_in_sc_thn_8').val();	
				var in_sc_thn_9 =	$('#add_in_sc_thn_9').val();	
				var in_sc_thn_10 =	$('#add_in_sc_thn_10').val();	
				var in_indoor_usd_1 =	$('#add_in_indoor_usd_1').val();	
				var in_indoor_idr_1 =	$('#add_in_indoor_idr_1').val();	
				var in_outdoor_usd_1 =	$('#add_in_outdoor_usd_1').val();	
				var in_outdoor_idr_1 =	$('#add_in_outdoor_idr_1').val();	
				var in_indoor_usd_2 =	$('#add_in_indoor_usd_2').val();	
				var in_indoor_idr_2 =	$('#add_in_indoor_idr_2').val();	
				var in_outdoor_usd_2 =	$('#add_in_outdoor_usd_2').val();	
				var in_outdoor_idr_2 =	$('#add_in_outdoor_idr_2').val();	
				var in_indoor_usd_3 =	$('#add_in_indoor_usd_3').val();	
				var in_indoor_idr_3 =	$('#add_in_indoor_idr_3').val();	
				var in_outdoor_usd_3 =	$('#add_in_outdoor_usd_3').val();	
				var in_outdoor_idr_3 =	$('#add_in_outdoor_idr_3').val();	
				var in_indoor_usd_4 =	$('#add_in_indoor_usd_4').val();	
				var in_indoor_idr_4 =	$('#add_in_indoor_idr_4').val();	
				var in_outdoor_usd_4 =	$('#add_in_outdoor_usd_4').val();	
				var in_outdoor_idr_4 =	$('#add_in_outdoor_idr_4').val();	
				var in_indoor_usd_5 =	$('#add_in_indoor_usd_5').val();	
				var in_indoor_idr_5 =	$('#add_in_indoor_idr_5').val();	
				var in_outdoor_usd_5 =	$('#add_in_outdoor_usd_5').val();	
				var in_outdoor_idr_5 =	$('#add_in_outdoor_idr_5').val();	
				var in_indoor_usd_6 =	$('#add_in_indoor_usd_6').val();	
				var in_indoor_idr_6 =	$('#add_in_indoor_idr_6').val();	
				var in_outdoor_usd_6 =	$('#add_in_outdoor_usd_6').val();	
				var in_outdoor_idr_6 =	$('#add_in_outdoor_idr_6').val();	
				var in_indoor_usd_7 =	$('#add_in_indoor_usd_7').val();	
				var in_indoor_idr_7 =	$('#add_in_indoor_idr_7').val();	
				var in_outdoor_usd_7 =	$('#add_in_outdoor_usd_7').val();	
				var in_outdoor_idr_7 =	$('#add_in_outdoor_idr_7').val();	
				var in_indoor_usd_8 =	$('#add_in_indoor_usd_8').val();	
				var in_indoor_idr_8 =	$('#add_in_indoor_idr_8').val();	
				var in_outdoor_usd_8 =	$('#add_in_outdoor_usd_8').val();	
				var in_outdoor_idr_8 =	$('#add_in_outdoor_idr_8').val();	
				var in_indoor_usd_9 =	$('#add_in_indoor_usd_9').val();	
				var in_indoor_idr_9 =	$('#add_in_indoor_idr_9').val();	
				var in_outdoor_usd_9 =	$('#add_in_outdoor_usd_9').val();	
				var in_outdoor_idr_9 =	$('#add_in_outdoor_idr_9').val();	
				var in_indoor_usd_10 =	$('#add_in_indoor_usd_10').val();	
				var in_indoor_idr_10 =	$('#add_in_indoor_idr_10').val();	
				var in_outdoor_usd_10 =	$('#add_in_outdoor_usd_10').val();	
				var in_outdoor_idr_10 =	$('#add_in_outdoor_idr_10').val();	
				var in_sc_indoor_usd =	$('#add_in_sc_indoor_usd').val();	
				var in_sc_indoor_idr =	$('#add_in_sc_indoor_idr').val();	
				var in_sc_outdoor_usd =	$('#add_in_sc_outdoor_usd').val();	
				var in_sc_outdoor_idr =	$('#add_in_sc_outdoor_idr').val();	
				var in_pl_month_usd =	$('#add_in_pl_month_usd').val();	
				var in_pl_month_idr =	$('#add_in_pl_month_idr').val();	
				var in_pl_onetine_usd =	$('#add_in_pl_onetine_usd').val();	
				var in_pl_onetine_idr =	$('#add_in_pl_onetine_idr').val();	
				var in_singking_usd =	$('#add_in_singking_usd').val();	
				var in_singking_idr =	$('#add_in_singking_idr').val();	
				var in_deposit_sewa =	$('#add_in_deposit_sewa').val();	
				var in_deposit_sc =	$('#add_in_deposit_sc').val();	
				var in_deposit_tlp =	$('#add_in_deposit_tlp').val();	
				var in_deposit_inet =	$('#add_in_deposit_inet').val();	
				var in_deposit_listrik =	$('#add_in_deposit_listrik').val();	
				var in_deposit_air =		$('#add_in_deposit_air').val();	
				var in_deposit_wallsign =	$('#add_in_deposit_wallsign').val();	
				var in_deposit_holding =	$('#add_in_deposit_holding').val();	
				var in_deposit_fitout =	$('#add_in_deposit_fitout').val();	
				var in_total_sewa_usd =	$('#add_in_total_sewa_usd').val();	
				var in_total_sewa_idr =	$('#add_in_total_sewa_idr').val();	
				var in_total_sc_usd =	$('#add_in_total_sc_usd').val();	
				var in_total_sc_idr =	$('#add_in_total_sc_idr').val();	
				var in_total_pl_usd =	$('#add_in_total_pl_usd').val();	
				var in_total_pl_idr =	$('#add_in_total_pl_idr').val();	
				var in_total_singking_usd =	$('#add_in_total_singking_usd').val();	
				var in_total_singking_idr =	$('#add_in_total_singking_idr').val();	
				var in_grand_total_usd =	$('#add_in_grand_total_usd').val();	
				var in_grand_total_idr =	$('#add_in_grand_total_idr').val();	
				var in_sewa_per_bln_usd =	$('#add_in_sewa_per_bln_usd').val();	
				var in_sewa_per_bln_idr =	$('#add_in_sewa_per_bln_idr').val();	
				var in_sc_per_bln_usd =		$('#add_in_sc_per_bln_usd').val();	
				var in_sc_per_bln_idr =		$('#add_in_sc_per_bln_idr').val();	
				var in_pl_per_bln_usd =		$('#add_in_pl_per_bln_usd').val();	
				var in_pl_per_bln_idr =		$('#add_in_pl_per_bln_idr').val();	
				var in_sf_per_bln_usd =		$('#add_in_sf_per_bln_usd').val();	
				var in_sf_per_bln_idr =		$('#add_in_sf_per_bln_idr').val();	
				var in_total_per_bln_usd =	$('#add_in_total_per_bln_usd').val();	
				var in_total_per_bln_idr =	$('#add_in_total_per_bln_idr').val();	
				var in_gs_thn_sewa =		$('#add_in_gs_thn_sewa').val();	
				var in_gs_awal_sewa =		$('#add_in_gs_awal_sewa').val();	
				var in_gs_akhir_sewa =		$('#add_in_gs_akhir_sewa').val();	
				var in_gs_luas =			$('#add_in_gs_luas').val();	
				var in_gs_tarif_1 =			$('#add_in_gs_tarif_1').val();	
				var in_gs_tarif_2 =			$('#add_in_gs_tarif_2').val();	
				var in_gs_tarif_3 =			$('#add_in_gs_tarif_3').val();	
				var in_gs_tarif_4 =			$('#add_in_gs_tarif_4').val();	
				var in_gs_tarif_5 =			$('#add_in_gs_tarif_5').val();	
				var in_gs_total_biaya =		$('#add_in_gs_total_biaya').val();	
				var in_gs_konstruksi =		$('#add_in_gs_konstruksi').val();	
				var in_gs_polesign =		$('#add_in_gs_polesign').val();	
				var in_gs_wallsign =		$('#add_in_gs_wallsign').val();	
				var in_gs_pylonsign =		$('#add_in_gs_pylonsign').val();	
				var in_daya_listrik =		$('#add_in_daya_listrik').val();	
				var in_tarif_listrik =		$('#add_in_tarif_listrik').val();	
				var in_fasilitas =			$('#add_in_fasilitas').val();	
				var in_keterangan =			$('#add_in_keterangan').val();	
				var in_pic_perusahaan =		$('#add_in_pic_perusahaan').val();	
				var in_pic_alamat =			$('#add_in_pic_alamat').val();	
				var in_pic_tlp =			$('#add_in_pic_tlp').val();	
				var in_pic_nama =			$('#add_in_pic_nama').val();	
				var in_pic_financial =		$('#add_in_pic_financial').val();
				var in_notes =				$('#add_in_notes').val();

				if(in_outlet==''||in_mall==''||in_city==''||in_company=='')
				{
					alert("Please Fill All Required Fields");
				}else{				
					/* INSERT NEW DATA TO DB*/
					$.ajax({
						type: "POST",
						url: "submit",
						data: {
								add_or_edit : add_or_edit,
								in_outlet :	in_outlet,
								in_mall : in_mall,
							/*	in_plan : in_plan, */
								in_city : in_city,		
								in_company : in_company,		
								in_opening_date : in_opening_date,		
								in_closing_date : in_closing_date,		
								in_summary : in_summary, 		
								in_loi : in_loi,				
								in_psm : in_psm,				
								in_thn_sewa : in_thn_sewa,			
								in_mulai_sewa :	in_mulai_sewa,		
								in_akhir_sewa :	in_akhir_sewa,	
								in_opsi_sewa : in_opsi_sewa,		
								in_location : in_location,			
								in_luas_1 :	in_luas_1,	
								in_luas_2 : in_luas_2,			
								in_luas_3 : in_luas_3,			
								in_luas_free :	in_luas_free,	
								in_grace_period : in_grace_period,	
								in_discount : in_discount,
								in_dp :	in_dp,		
								in_installment : in_installment,	
								in_rate_thn_1 :	in_rate_thn_1,	
								in_rate_thn_2 :	in_rate_thn_2,	
								in_rate_thn_3 :	in_rate_thn_3,	
								in_rate_thn_4 :	in_rate_thn_4,	
								in_rate_thn_5 :	in_rate_thn_5,	
								in_rate_thn_6 :	in_rate_thn_6,
								in_rate_thn_7 :	in_rate_thn_7,	
								in_rate_thn_8 :	in_rate_thn_8,	
								in_rate_thn_9 :	in_rate_thn_9,
								in_rate_thn_10 : in_rate_thn_10,			
								in_sc_thn_1 : in_sc_thn_1,		
								in_sc_thn_2 : in_sc_thn_2,	
								in_sc_thn_3 : in_sc_thn_3,		
								in_sc_thn_4 : in_sc_thn_4,		
								in_sc_thn_5 : in_sc_thn_5,		
								in_sc_thn_6 : in_sc_thn_6,		
								in_sc_thn_7 : in_sc_thn_7,		
								in_sc_thn_8 : in_sc_thn_8,		
								in_sc_thn_9 : in_sc_thn_9,		
								in_sc_thn_10 : in_sc_thn_10,		
								in_indoor_usd_1 : in_indoor_usd_1,		
								in_indoor_idr_1 : in_indoor_idr_1,	 
								in_outdoor_usd_1 : in_outdoor_usd_1,		
								in_outdoor_idr_1 : in_outdoor_idr_1,	
								in_indoor_usd_2 : in_indoor_usd_2,		
								in_indoor_idr_2 : in_indoor_idr_2,		
								in_outdoor_usd_2 : in_outdoor_usd_2,	
								in_outdoor_idr_2 : in_outdoor_idr_2,	
								in_indoor_usd_3 : in_indoor_usd_3,	
								in_indoor_idr_3 : in_indoor_idr_3,		
								in_outdoor_usd_3 : in_outdoor_usd_3,		
								in_outdoor_idr_3 : in_outdoor_idr_3,		
								in_indoor_usd_4 : in_indoor_usd_4,		
								in_indoor_idr_4 : in_indoor_idr_4,		
								in_outdoor_usd_4 : in_outdoor_usd_4,	
								in_outdoor_idr_4 : in_outdoor_idr_4,	
								in_indoor_usd_5 : in_indoor_usd_5,		
								in_indoor_idr_5 : in_indoor_idr_5,		
								in_outdoor_usd_5 : in_outdoor_usd_5,
								in_outdoor_idr_5 : in_outdoor_idr_5,	
								in_indoor_usd_6 : in_indoor_usd_6,	
								in_indoor_idr_6 : in_indoor_idr_6,		
								in_outdoor_usd_6 : in_outdoor_usd_6,		
								in_outdoor_idr_6 : in_outdoor_idr_6,		
								in_indoor_usd_7 : in_indoor_usd_7,		
								in_indoor_idr_7 : in_indoor_idr_7,	
								in_outdoor_usd_7 : in_outdoor_usd_7,		
								in_outdoor_idr_7 : in_outdoor_idr_7,	
								in_indoor_usd_8 : in_indoor_usd_8,		
								in_indoor_idr_8 : in_indoor_idr_8,		
								in_outdoor_usd_8 : in_outdoor_usd_8,	
								in_outdoor_idr_8 : in_outdoor_idr_8,
								in_indoor_usd_9 : in_indoor_usd_9,	
								in_indoor_idr_9 : in_indoor_idr_9,		
								in_outdoor_usd_9 : in_outdoor_usd_9,		
								in_outdoor_idr_9 : in_outdoor_idr_9,	
								in_indoor_usd_10 : in_indoor_usd_10,		
								in_indoor_idr_10 : in_indoor_idr_10,		
								in_outdoor_usd_10 : in_outdoor_usd_10,		
								in_outdoor_idr_10 : in_outdoor_idr_10,		
								in_sc_indoor_usd : in_sc_indoor_usd,	
								in_sc_indoor_idr : in_sc_indoor_idr,	
								in_sc_outdoor_usd :	in_sc_outdoor_usd,  	
								in_sc_outdoor_idr :  in_sc_outdoor_idr,	
								in_pl_month_usd : in_pl_month_usd,	 	
								in_pl_month_idr : in_pl_month_idr,	 	
								in_pl_onetine_usd : in_pl_onetine_usd,	 	
								in_pl_onetine_idr : in_pl_onetine_idr,	 	
								in_singking_usd : in_singking_usd,	 	
								in_singking_idr : in_singking_idr,	 	
								in_deposit_sewa : in_deposit_sewa,	 	
								in_deposit_sc :	in_deposit_sc, 	
								in_deposit_tlp : in_deposit_tlp,	 	
								in_deposit_inet : in_deposit_inet,	 	
								in_deposit_listrik : in_deposit_listrik,	 	
								in_deposit_air : in_deposit_air,		 
								in_deposit_wallsign : in_deposit_wallsign,	 	
								in_deposit_holding : in_deposit_holding, 	
								in_deposit_fitout :	in_deposit_fitout, 	
								in_total_sewa_usd : in_total_sewa_usd,	 
								in_total_sewa_idr :	 in_total_sewa_idr,	
								in_total_sc_usd : in_total_sc_usd,	 	
								in_total_sc_idr : in_total_sc_idr,	 	
								in_total_pl_usd : in_total_pl_usd,	 	
								in_total_pl_idr : in_total_pl_idr,	 	
								in_total_singking_usd :	in_total_singking_usd, 	
								in_total_singking_idr : in_total_singking_idr,	
								in_grand_total_usd : in_grand_total_usd,	 	
								in_grand_total_idr : in_grand_total_idr,	 
								in_sewa_per_bln_usd : in_sewa_per_bln_usd,	 	
								in_sewa_per_bln_idr : in_sewa_per_bln_idr,	 	
								in_sc_per_bln_usd :	in_sc_per_bln_usd,	 	
								in_sc_per_bln_idr :	in_sc_per_bln_idr,	 	
								in_pl_per_bln_usd :	in_pl_per_bln_usd,	 	
								in_pl_per_bln_idr :	in_pl_per_bln_idr,	 	
								in_sf_per_bln_usd :	in_sf_per_bln_usd,	 	
								in_sf_per_bln_idr :	in_sf_per_bln_idr,	 	
								in_total_per_bln_usd : in_total_per_bln_usd,	 	
								in_total_per_bln_idr : in_total_per_bln_idr, 	
								in_gs_thn_sewa : in_gs_thn_sewa,		 
								in_gs_awal_sewa : in_gs_awal_sewa,		 	
								in_gs_akhir_sewa : in_gs_akhir_sewa,	  
								in_gs_luas : in_gs_luas,			 	
								in_gs_tarif_1 :	in_gs_tarif_1,	 
								in_gs_tarif_2 :	in_gs_tarif_2,	 	
								in_gs_tarif_3 :	in_gs_tarif_3, 
								in_gs_tarif_4 :	in_gs_tarif_4,
								in_gs_tarif_5 :	in_gs_tarif_5, 	
								in_gs_total_biaya :	in_gs_total_biaya, 
								in_gs_konstruksi : in_gs_konstruksi,	 	
								in_gs_polesign : in_gs_polesign,	 
								in_gs_wallsign : in_gs_wallsign,
								in_gs_pylonsign : in_gs_pylonsign,	 	
								in_daya_listrik : in_daya_listrik,	 	
								in_tarif_listrik : in_tarif_listrik,	 	
								in_fasilitas : in_fasilitas, 	 	
								in_keterangan :	in_keterangan, 
								in_pic_perusahaan :	in_pic_perusahaan, 	
								in_pic_alamat :	in_pic_alamat, 	
								in_pic_tlp : in_pic_tlp,	 
								in_pic_nama : in_pic_nama,	 	
								in_pic_financial : in_pic_financial,			
								in_notes : in_notes
						},
						cache: false,
						success: function(result){
								alert(result);
						}
					});
				
					
				}
				
				
				return false;	


		});			

		
		/*******************  Submit Data For Edit  *******************/
		$("#submit-edit").click(function(){
				var add_or_edit	=		$('input#add_or_edit').val();

				var mulai_sewa_before	=		$('input#mulai_sewa_before').val();
				var akhir_sewa_before	=		$('input#akhir_sewa_before').val();

				var mulai_sewa_after	= 		$('#in_mulai_sewa').val();	
				var akhir_sewa_after	= 		$('#in_akhir_sewa').val();				
				
				var in_id		=		$('#row_id').val();
				var in_outlet =			$('#in_outlet').val();
				var in_mall =			$('#in_mall').val();
				var in_plan =			$('#in_plan').val();
				var in_city =			$('#in_city').val();
				var in_company =		$('#in_company').val();
				var in_opening_date =	$('#in_opening_date').val();	
				var in_closing_date =	$('#in_closing_date').val();	
				var in_summary =		$('#in_summary').val();	
				var in_loi =			$('#in_loi').val();	
				var in_psm =			$('#in_psm').val();	
				var in_thn_sewa =		$('#in_thn_sewa').val();	
				var in_mulai_sewa =		$('#in_mulai_sewa').val();	
				var in_akhir_sewa =		$('#in_akhir_sewa').val();	
				var in_opsi_sewa =		$('#in_opsi_sewa').val();	
				var in_location =		$('#in_location').val();	
				var in_luas_1 =			$('#in_luas_1').val();	
				var in_luas_2 =			$('#in_luas_2').val();	
				var in_luas_3 =			$('#in_luas_3').val();	
				var in_luas_free =		$('#in_luas_free').val();	
				var in_grace_period =	$('#in_grace_period').val();	
				var in_discount =		$('#in_discount').val();	
				var in_dp =				$('#in_dp').val();	
				var in_installment =	$('#in_installment').val();	
				var in_rate_thn_1 =	$('#in_rate_thn_1').val();	
				var in_rate_thn_2 =	$('#in_rate_thn_2').val();	
				var in_rate_thn_3 =	$('#in_rate_thn_3').val();	
				var in_rate_thn_4 =	$('#in_rate_thn_4').val();	
				var in_rate_thn_5 =	$('#in_rate_thn_5').val();	
				var in_rate_thn_6 =	$('#in_rate_thn_6').val();	
				var in_rate_thn_7 =	$('#in_rate_thn_7').val();	
				var in_rate_thn_8 =	$('#in_rate_thn_8').val();	
				var in_rate_thn_9 =	$('#in_rate_thn_9').val();
				var in_rate_thn_10 =$('#in_rate_thn_10').val();			
				var in_sc_thn_1 =	$('#in_sc_thn_1').val();	
				var in_sc_thn_2 =	$('#in_sc_thn_2').val();	
				var in_sc_thn_3 =	$('#in_sc_thn_3').val();	
				var in_sc_thn_4 =	$('#in_sc_thn_4').val();	
				var in_sc_thn_5 =	$('#in_sc_thn_5').val();	
				var in_sc_thn_6 =	$('#in_sc_thn_6').val();	
				var in_sc_thn_7 =	$('#in_sc_thn_7').val();	
				var in_sc_thn_8 =	$('#in_sc_thn_8').val();	
				var in_sc_thn_9 =	$('#in_sc_thn_9').val();	
				var in_sc_thn_10 =	$('#in_sc_thn_10').val();	
				var in_indoor_usd_1 =	$('#in_indoor_usd_1').val();	
				var in_indoor_idr_1 =	$('#in_indoor_idr_1').val();	
				var in_outdoor_usd_1 =	$('#in_outdoor_usd_1').val();	
				var in_outdoor_idr_1 =	$('#in_outdoor_idr_1').val();	
				var in_indoor_usd_2 =	$('#in_indoor_usd_2').val();	
				var in_indoor_idr_2 =	$('#in_indoor_idr_2').val();	
				var in_outdoor_usd_2 =	$('#in_outdoor_usd_2').val();	
				var in_outdoor_idr_2 =	$('#in_outdoor_idr_2').val();	
				var in_indoor_usd_3 =	$('#in_indoor_usd_3').val();	
				var in_indoor_idr_3 =	$('#in_indoor_idr_3').val();	
				var in_outdoor_usd_3 =	$('#in_outdoor_usd_3').val();	
				var in_outdoor_idr_3 =	$('#in_outdoor_idr_3').val();	
				var in_indoor_usd_4 =	$('#in_indoor_usd_4').val();	
				var in_indoor_idr_4 =	$('#in_indoor_idr_4').val();	
				var in_outdoor_usd_4 =	$('#in_outdoor_usd_4').val();	
				var in_outdoor_idr_4 =	$('#in_outdoor_idr_4').val();	
				var in_indoor_usd_5 =	$('#in_indoor_usd_5').val();	
				var in_indoor_idr_5 =	$('#in_indoor_idr_5').val();	
				var in_outdoor_usd_5 =	$('#in_outdoor_usd_5').val();	
				var in_outdoor_idr_5 =	$('#in_outdoor_idr_5').val();	
				var in_indoor_usd_6 =	$('#in_indoor_usd_6').val();	
				var in_indoor_idr_6 =	$('#in_indoor_idr_6').val();	
				var in_outdoor_usd_6 =	$('#in_outdoor_usd_6').val();	
				var in_outdoor_idr_6 =	$('#in_outdoor_idr_6').val();	
				var in_indoor_usd_7 =	$('#in_indoor_usd_7').val();	
				var in_indoor_idr_7 =	$('#in_indoor_idr_7').val();	
				var in_outdoor_usd_7 =	$('#in_outdoor_usd_7').val();	
				var in_outdoor_idr_7 =	$('#in_outdoor_idr_7').val();	
				var in_indoor_usd_8 =	$('#in_indoor_usd_8').val();	
				var in_indoor_idr_8 =	$('#in_indoor_idr_8').val();	
				var in_outdoor_usd_8 =	$('#in_outdoor_usd_8').val();	
				var in_outdoor_idr_8 =	$('#in_outdoor_idr_8').val();	
				var in_indoor_usd_9 =	$('#in_indoor_usd_9').val();	
				var in_indoor_idr_9 =	$('#in_indoor_idr_9').val();	
				var in_outdoor_usd_9 =	$('#in_outdoor_usd_9').val();	
				var in_outdoor_idr_9 =	$('#in_outdoor_idr_9').val();	
				var in_indoor_usd_10 =	$('#in_indoor_usd_10').val();	
				var in_indoor_idr_10 =	$('#in_indoor_idr_10').val();	
				var in_outdoor_usd_10 =	$('#in_outdoor_usd_10').val();	
				var in_outdoor_idr_10 =	$('#in_outdoor_idr_10').val();	
				var in_sc_indoor_usd =	$('#in_sc_indoor_usd').val();	
				var in_sc_indoor_idr =	$('#in_sc_indoor_idr').val();	
				var in_sc_outdoor_usd =	$('#in_sc_outdoor_usd').val();	
				var in_sc_outdoor_idr =	$('#in_sc_outdoor_idr').val();	
				var in_pl_month_usd =	$('#in_pl_month_usd').val();	
				var in_pl_month_idr =	$('#in_pl_month_idr').val();	
				var in_pl_onetine_usd =	$('#in_pl_onetine_usd').val();	
				var in_pl_onetine_idr =	$('#in_pl_onetine_idr').val();	
				var in_singking_usd =	$('#in_singking_usd').val();	
				var in_singking_idr =	$('#in_singking_idr').val();	
				var in_deposit_sewa =	$('#in_deposit_sewa').val();	
				var in_deposit_sc =	$('#in_deposit_sc').val();	
				var in_deposit_tlp =	$('#in_deposit_tlp').val();	
				var in_deposit_inet =	$('#in_deposit_inet').val();	
				var in_deposit_listrik =	$('#in_deposit_listrik').val();	
				var in_deposit_air =		$('#in_deposit_air').val();	
				var in_deposit_wallsign =	$('#in_deposit_wallsign').val();	
				var in_deposit_holding =	$('#in_deposit_holding').val();	
				var in_deposit_fitout =	$('#in_deposit_fitout').val();	
				var in_total_sewa_usd =	$('#in_total_sewa_usd').val();	
				var in_total_sewa_idr =	$('#in_total_sewa_idr').val();	
				var in_total_sc_usd =	$('#in_total_sc_usd').val();	
				var in_total_sc_idr =	$('#in_total_sc_idr').val();	
				var in_total_pl_usd =	$('#in_total_pl_usd').val();	
				var in_total_pl_idr =	$('#in_total_pl_idr').val();	
				var in_total_singking_usd =	$('#in_total_singking_usd').val();	
				var in_total_singking_idr =	$('#in_total_singking_idr').val();	
				var in_grand_total_usd =	$('#in_grand_total_usd').val();	
				var in_grand_total_idr =	$('#in_grand_total_idr').val();	
				var in_sewa_per_bln_usd =	$('#in_sewa_per_bln_usd').val();	
				var in_sewa_per_bln_idr =	$('#in_sewa_per_bln_idr').val();	
				var in_sc_per_bln_usd =		$('#in_sc_per_bln_usd').val();	
				var in_sc_per_bln_idr =		$('#in_sc_per_bln_idr').val();	
				var in_pl_per_bln_usd =		$('#in_pl_per_bln_usd').val();	
				var in_pl_per_bln_idr =		$('#in_pl_per_bln_idr').val();	
				var in_sf_per_bln_usd =		$('#in_sf_per_bln_usd').val();	
				var in_sf_per_bln_idr =		$('#in_sf_per_bln_idr').val();	
				var in_total_per_bln_usd =	$('#in_total_per_bln_usd').val();	
				var in_total_per_bln_idr =	$('#in_total_per_bln_idr').val();	
				var in_gs_thn_sewa =		$('#in_gs_thn_sewa').val();	
				var in_gs_awal_sewa =		$('#in_gs_awal_sewa').val();	
				var in_gs_akhir_sewa =		$('#in_gs_akhir_sewa').val();	
				var in_gs_luas =			$('#in_gs_luas').val();	
				var in_gs_tarif_1 =			$('#in_gs_tarif_1').val();	
				var in_gs_tarif_2 =			$('#in_gs_tarif_2').val();	
				var in_gs_tarif_3 =			$('#in_gs_tarif_3').val();	
				var in_gs_tarif_4 =			$('#in_gs_tarif_4').val();	
				var in_gs_tarif_5 =			$('#in_gs_tarif_5').val();	
				var in_gs_total_biaya =		$('#in_gs_total_biaya').val();	
				var in_gs_konstruksi =		$('#in_gs_konstruksi').val();	
				var in_gs_polesign =		$('#in_gs_polesign').val();	
				var in_gs_wallsign =		$('#in_gs_wallsign').val();	
				var in_gs_pylonsign =		$('#in_gs_pylonsign').val();	
				var in_daya_listrik =		$('#in_daya_listrik').val();	
				var in_tarif_listrik =		$('#in_tarif_listrik').val();	
				var in_fasilitas =			$('#in_fasilitas').val();	
				var in_keterangan =			$('#in_keterangan').val();	
				var in_pic_perusahaan =		$('#in_pic_perusahaan').val();	
				var in_pic_alamat =			$('#in_pic_alamat').val();	
				var in_pic_tlp =			$('#in_pic_tlp').val();	
				var in_pic_nama =			$('#in_pic_nama').val();	
				var in_pic_financial =		$('#in_pic_financial').val();
				var in_notes =				$('#in_notes').val();

				if(in_outlet==''||in_mall==''||in_city==''||in_company=='')
				{
					alert("Please Fill All Required Fields");
				}else{				

					$.ajax({
						type: "POST",
						url: "submit",
						data: {
								add_or_edit : add_or_edit,
								mulai_sewa_before : mulai_sewa_before,
								akhir_sewa_before : akhir_sewa_before,
								mulai_sewa_after :	mulai_sewa_after,
								akhir_sewa_after :  akhir_sewa_after,
								
								in_id : in_id,
								in_outlet :	in_outlet,
								in_mall : in_mall,
								in_plan : in_plan,
								in_city : in_city,		
								in_company : in_company,		
								in_opening_date : in_opening_date,		
								in_closing_date : in_closing_date,		
								in_summary : in_summary, 		
								in_loi : in_loi,				
								in_psm : in_psm,				
								in_thn_sewa : in_thn_sewa,			
								in_mulai_sewa :	in_mulai_sewa,		
								in_akhir_sewa :	in_akhir_sewa,	
								in_opsi_sewa : in_opsi_sewa,		
								in_location : in_location,			
								in_luas_1 :	in_luas_1,	
								in_luas_2 : in_luas_2,			
								in_luas_3 : in_luas_3,			
								in_luas_free :	in_luas_free,	
								in_grace_period : in_grace_period,	
								in_discount : in_discount,
								in_dp :	in_dp,		
								in_installment : in_installment,	
								in_rate_thn_1 :	in_rate_thn_1,	
								in_rate_thn_2 :	in_rate_thn_2,	
								in_rate_thn_3 :	in_rate_thn_3,	
								in_rate_thn_4 :	in_rate_thn_4,	
								in_rate_thn_5 :	in_rate_thn_5,	
								in_rate_thn_6 :	in_rate_thn_6,
								in_rate_thn_7 :	in_rate_thn_7,	
								in_rate_thn_8 :	in_rate_thn_8,	
								in_rate_thn_9 :	in_rate_thn_9,
								in_rate_thn_10 : in_rate_thn_10,			
								in_sc_thn_1 : in_sc_thn_1,		
								in_sc_thn_2 : in_sc_thn_2,	
								in_sc_thn_3 : in_sc_thn_3,		
								in_sc_thn_4 : in_sc_thn_4,		
								in_sc_thn_5 : in_sc_thn_5,		
								in_sc_thn_6 : in_sc_thn_6,		
								in_sc_thn_7 : in_sc_thn_7,		
								in_sc_thn_8 : in_sc_thn_8,		
								in_sc_thn_9 : in_sc_thn_9,		
								in_sc_thn_10 : in_sc_thn_10,		
								in_indoor_usd_1 : in_indoor_usd_1,		
								in_indoor_idr_1 : in_indoor_idr_1,	 
								in_outdoor_usd_1 : in_outdoor_usd_1,		
								in_outdoor_idr_1 : in_outdoor_idr_1,	
								in_indoor_usd_2 : in_indoor_usd_2,		
								in_indoor_idr_2 : in_indoor_idr_2,		
								in_outdoor_usd_2 : in_outdoor_usd_2,	
								in_outdoor_idr_2 : in_outdoor_idr_2,	
								in_indoor_usd_3 : in_indoor_usd_3,	
								in_indoor_idr_3 : in_indoor_idr_3,		
								in_outdoor_usd_3 : in_outdoor_usd_3,		
								in_outdoor_idr_3 : in_outdoor_idr_3,		
								in_indoor_usd_4 : in_indoor_usd_4,		
								in_indoor_idr_4 : in_indoor_idr_4,		
								in_outdoor_usd_4 : in_outdoor_usd_4,	
								in_outdoor_idr_4 : in_outdoor_idr_4,	
								in_indoor_usd_5 : in_indoor_usd_5,		
								in_indoor_idr_5 : in_indoor_idr_5,		
								in_outdoor_usd_5 : in_outdoor_usd_5,
								in_outdoor_idr_5 : in_outdoor_idr_5,	
								in_indoor_usd_6 : in_indoor_usd_6,	
								in_indoor_idr_6 : in_indoor_idr_6,		
								in_outdoor_usd_6 : in_outdoor_usd_6,		
								in_outdoor_idr_6 : in_outdoor_idr_6,		
								in_indoor_usd_7 : in_indoor_usd_7,		
								in_indoor_idr_7 : in_indoor_idr_7,	
								in_outdoor_usd_7 : in_outdoor_usd_7,		
								in_outdoor_idr_7 : in_outdoor_idr_7,	
								in_indoor_usd_8 : in_indoor_usd_8,		
								in_indoor_idr_8 : in_indoor_idr_8,		
								in_outdoor_usd_8 : in_outdoor_usd_8,	
								in_outdoor_idr_8 : in_outdoor_idr_8,
								in_indoor_usd_9 : in_indoor_usd_9,	
								in_indoor_idr_9 : in_indoor_idr_9,		
								in_outdoor_usd_9 : in_outdoor_usd_9,		
								in_outdoor_idr_9 : in_outdoor_idr_9,	
								in_indoor_usd_10 : in_indoor_usd_10,		
								in_indoor_idr_10 : in_indoor_idr_10,		
								in_outdoor_usd_10 : in_outdoor_usd_10,		
								in_outdoor_idr_10 : in_outdoor_idr_10,		
								in_sc_indoor_usd : in_sc_indoor_usd,	
								in_sc_indoor_idr : in_sc_indoor_idr,	
								in_sc_outdoor_usd :	in_sc_outdoor_usd,  	
								in_sc_outdoor_idr :  in_sc_outdoor_idr,	
								in_pl_month_usd : in_pl_month_usd,	 	
								in_pl_month_idr : in_pl_month_idr,	 	
								in_pl_onetine_usd : in_pl_onetine_usd,	 	
								in_pl_onetine_idr : in_pl_onetine_idr,	 	
								in_singking_usd : in_singking_usd,	 	
								in_singking_idr : in_singking_idr,	 	
								in_deposit_sewa : in_deposit_sewa,	 	
								in_deposit_sc :	in_deposit_sc, 	
								in_deposit_tlp : in_deposit_tlp,	 	
								in_deposit_inet : in_deposit_inet,	 	
								in_deposit_listrik : in_deposit_listrik,	 	
								in_deposit_air : in_deposit_air,		 
								in_deposit_wallsign : in_deposit_wallsign,	 	
								in_deposit_holding : in_deposit_holding, 	
								in_deposit_fitout :	in_deposit_fitout, 	
								in_total_sewa_usd : in_total_sewa_usd,	 
								in_total_sewa_idr :	 in_total_sewa_idr,	
								in_total_sc_usd : in_total_sc_usd,	 	
								in_total_sc_idr : in_total_sc_idr,	 	
								in_total_pl_usd : in_total_pl_usd,	 	
								in_total_pl_idr : in_total_pl_idr,	 	
								in_total_singking_usd :	in_total_singking_usd, 	
								in_total_singking_idr : in_total_singking_idr,	
								in_grand_total_usd : in_grand_total_usd,	 	
								in_grand_total_idr : in_grand_total_idr,	 
								in_sewa_per_bln_usd : in_sewa_per_bln_usd,	 	
								in_sewa_per_bln_idr : in_sewa_per_bln_idr,	 	
								in_sc_per_bln_usd :	in_sc_per_bln_usd,	 	
								in_sc_per_bln_idr :	in_sc_per_bln_idr,	 	
								in_pl_per_bln_usd :	in_pl_per_bln_usd,	 	
								in_pl_per_bln_idr :	in_pl_per_bln_idr,	 	
								in_sf_per_bln_usd :	in_sf_per_bln_usd,	 	
								in_sf_per_bln_idr :	in_sf_per_bln_idr,	 	
								in_total_per_bln_usd : in_total_per_bln_usd,	 	
								in_total_per_bln_idr : in_total_per_bln_idr, 	
								in_gs_thn_sewa : in_gs_thn_sewa,		 
								in_gs_awal_sewa : in_gs_awal_sewa,		 	
								in_gs_akhir_sewa : in_gs_akhir_sewa,	  
								in_gs_luas : in_gs_luas,			 	
								in_gs_tarif_1 :	in_gs_tarif_1,	 
								in_gs_tarif_2 :	in_gs_tarif_2,	 	
								in_gs_tarif_3 :	in_gs_tarif_3, 
								in_gs_tarif_4 :	in_gs_tarif_4,
								in_gs_tarif_5 :	in_gs_tarif_5, 	
								in_gs_total_biaya :	in_gs_total_biaya, 
								in_gs_konstruksi : in_gs_konstruksi,	 	
								in_gs_polesign : in_gs_polesign,	 
								in_gs_wallsign : in_gs_wallsign,
								in_gs_pylonsign : in_gs_pylonsign,	 	
								in_daya_listrik : in_daya_listrik,	 	
								in_tarif_listrik : in_tarif_listrik,	 	
								in_fasilitas : in_fasilitas, 	 	
								in_keterangan :	in_keterangan, 
								in_pic_perusahaan :	in_pic_perusahaan, 	
								in_pic_alamat :	in_pic_alamat, 	
								in_pic_tlp : in_pic_tlp,	 
								in_pic_nama : in_pic_nama,	 	
								in_pic_financial : in_pic_financial,			
								in_notes : in_notes
						},
						cache: false,
						success: function(result){
								alert(result);
								if(add_or_edit == 'edit'){
										
										$.ajax({
											url: "edit_browse_complete",
											type: "POST",
											global: true,
											async: true,
											cache: false,
											dataType: "json",
											data: {id:in_id},
											success:function(data)
											{
											
											/*
												$("tr#" + in_id).innerHTML  = '<td>' + data.sewa_mall[0]['ID'] + '</td>' + 
																						'<td>'
																							'<a onclick="edit(' + data.sewa_mall[0]['ID'] + ')" data-toggle="modal" href="#form-content"><img src="../images/icons/EditOrange16.png"></a>&nbsp;' +	
																							'<a onclick="del(' + data.sewa_mall[0]['ID'] + ')"><img src="../images/icons/DeleteRed16.png"></a></td>' +
																						
																						'<td>&nbsp&nbsp' + data.sewa_mall[0]['SEWA_OUTLET'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_MALL'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_PLAN'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_CITY'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_COMPANY'] + '</td>' +		
																						'<td>' + data.sewa_mall[0]['SEWA_OPENING_DATE'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_CLOSING_DATE'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_JML_TAHUN'] + '</td>' +					
																						'<td>' + data.sewa_mall[0]['SEWA_AWAL'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_AKHIR'] + ' <img src="../images/icons/warning_red.png"></td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_SUMMARY'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_LOI'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_PSM'] + '</td>' +				
																						'<td>' + data.sewa_mall[0]['SEWA_OPSI'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_LOCATION'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_LUAS_1'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_LUAS_2'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_LUAS_3'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_LUAS_FREE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_GRACEPERIOD'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_DISC'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_DP'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_INSTALLMENT'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_TAHUN_1'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_TAHUN_2'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_TAHUN_3'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_TAHUN_4'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_TAHUN_5'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_TAHUN_6'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_TAHUN_7'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_TAHUN_8'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_TAHUN_9'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_TAHUN_10'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_SC_1'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_SC_2'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_SC_3'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_SC_4'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_SC_5'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_SC_6'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_SC_7'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_SC_8'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_SC_9'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_RATE_SC_10'] + '</td>' +		
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_01'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_01'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_01'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_01'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_02'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_02'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_02'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_02'] + '</td>' +			
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_03'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_03'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_03'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_03'] + '</td>' +				
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_04'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_04'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_04'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_04'] + '</td>' +				
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_05'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_05'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_05'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_05'] + '</td>' +				
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_06'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_06'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_06'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_06'] + '</td>' +				
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_07'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_07'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_07'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_07'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_08'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_08'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_08'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_08'] + '</td>' +				
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_09'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_09'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_09'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_09'] + '</td>' +				
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_USD_10'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_INDOOR_IDR_10'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_USD_10'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_OUTDOOR_IDR_10'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_SC_INDOOR_USD'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_SC_INDOOR_IDR'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_SC_OUTDOOR_USD'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_SC_OUTDOOR_IDR'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_PL_BULAN_USD'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_PL_BULAN_IDR'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_PL_ONETIME_USD'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_PL_ONETIME_IDR'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_SINGKINGFUND_USD'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TARIF_SINGKINGFUND_IDR'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_DEPOSIT_SEWA_VALUE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_DEPOSIT_SC_VALUE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_DEPOSIT_TELP_VALUE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_DEPOSIT_INET_VALUE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_DEPOSIT_LISTRIK_VALUE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_DEPOSIT_AIR_GAS_VALUE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_DEPOSIT_WALLSIGN_VALUE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_DEPOSIT_HOLDING_VALUE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_DEPOSIT_FITOUT_VALUE'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_TOTAL_SEWA_USD'] + '</td>' +				
																						'<td>' + data.sewa_mall[0]['SEWA_TOTAL_SEWA_IDR'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TOTAL_SC_USD'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TOTAL_SC_IDR'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TOTAL_PL_USD'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TOTAL_PL_IDR'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TOTAL_SINGKING_USD'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TOTAL_SINGKING_IDR'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TOTAL_USD'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_TOTAL_IDR'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['x_PERBLN_SEWA_USD'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['x_PERBLN_SEWA_IDR'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['x_PERBLN_SC_USD'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['x_PERBLN_SC_IDR'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['x_PERBLN_PL_USD'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['x_PERBLN_PL_IDR'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['x_PERBLN_SF_USD'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['x_PERBLN_SF_IDR'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['x_PERBLN_TOTAL_USD'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['x_PERBLN_TOTAL_IDR'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_GUDANGSUPPORT_JML_THN'] + '</td>' +				
																						'<td>' + data.sewa_mall[0]['SEWA_GUDANGSUPPORT_AWAL'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_GUDANGSUPPORT_AKHIR'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_GUDANGSUPPORT_LUAS'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_01'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_02'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_03'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_04'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_GUDANGSUPPORT_TARIF_05'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_GUDANGSUPPORT_BIAYA'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_KONSTRUKSI_VALUE'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_POLESIGN_VALUE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_WALLSIGN_VALUE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_PYLONSIGN_VALUE'] + '</td>' +	
																						'<td>' + data.sewa_mall[0]['SEWA_LISTRIK_DATA'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_LISTRIK_TARIF'] + '</td>' +				
																						'<td>' + data.sewa_mall[0]['SEWA_FASILITAS'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_KETERANGAN'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_PIC_PERUSAHAAN'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_PIC_ALAMAT'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_PIC_TELP'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_PIC_NAMA'] + '</td>' +
																						'<td>' + data.sewa_mall[0]['SEWA_PIC_FIN'] + '</td>';	
													

											*/
												
											},
											error: function(){						
												alert('Error while request..');
											}
										});		
										
								}
						}
					});
				
					
				}
				
				
				return false;	


		});			

		
		/*******************  Add new outlet, MALL Drop-down Filler  *******************/
		$('#add_in_company').change(function () {
				var idd = $(this).val();
						$.ajax({
							url: "show_mall_by_comp_id",
							type: "POST",
							global: true,
							async: true,
							cache: false,
							dataType: "json",
							data: {id:idd},
							success:function(data)
							{
								$('#add_in_outlet').val('');
								$('#add_in_plan').val('');
								$('#add_in_city').val('');
								$('#outlet_name_suggestion').hide();
								$('#add_in_mall').empty().append('<option></option>');
								for(var i=0;i<data.length;i++) {	
									$('#add_in_mall').append('<option value="'+data[i].BUILDING_CODE+'">'+data[i].BUILDING_NAME+'</option>');
								} 	
									$('#add_in_mall').trigger('chosen:updated');					
							},
							error: function(){						
								alert('Error while request..');
							}
						});		
		});

		
		/*******************  Add new outlet, OUTLET name Sugestor  *******************/
		$("#add_in_mall").change(function(){

					var comp_code 	= $("#add_in_company").val();
					var mall		= $("#add_in_mall").val();
					$('#add_in_outlet').attr('disabled','disabled');
					$('#add_in_plan').attr('disabled','disabled');
					$('#add_in_city').attr('disabled','disabled');
					$('#add_in_plan').val('');
					$('#add_in_city').val('');					
						$.ajax({
							url: "get_hrcode_by_compid",
							type: "POST",
							global: true,
							async: true,
							cache: false,
							dataType: "json",
							data: {comp_code:comp_code, building_code:mall},
							success:function(data)
							{	
								/* Get the first frase of HR_CODE*//*
								var tmp		= '';
								var hr_code = new Array();
									for (var i=0;i<data.length;++i){
										tmp			= data[i].HR_CODE.split(" ");						
										hr_code[i]  = tmp[0];										
									}
									
								/* Get unique HR_CODE in array *//*	
								var uniqueHrCode = [];
									$.each(hr_code, function(i, el){
										if($.inArray(el, uniqueHrCode) === -1) uniqueHrCode.push(el);
									});	
								*//*
								var HTMLoutletSuggestion = 'We have some options that you might like for this outlet name:<br/>';		
									for (var i=0;i<uniqueHrCode.length;++i){
										HTMLoutletSuggestion += '<input type="radio" name="outlet_name_chosen" onclick="outlet_name_selected()" value="' + data[0].HR_CODE + '"> ' + data[0].HR_CODE + '<br>';
									}*/
								var  tmp	    	= data[0].HR_CODE.split(" ");						
								var  hr_code_cpy	= tmp[0];	

								if(data[0].HR_CODE != 'none'){
										$('#add_in_outlet').val('');
										
										var HTMLoutletSuggestion = 'Outlet name : ' + data[0].HR_CODE + ' has been used. Please choose one of these suggestions:<br/>';	
										var new_name ='';
										var tmp='';
										
										for(var i=2;i<102;i++){
											new_name  = hr_code_cpy + ' ' + mall + i;
											new_name2 = hr_code_cpy + ' ' + i + mall;											

											if(check_outlet_name(new_name) == '\"kosong\"' && check_outlet_name(new_name2) == '\"kosong\"'){
												HTMLoutletSuggestion += '<input type="radio" name="outlet_name_chosen" onclick="outlet_name_selected()" value="' + hr_code_cpy + ' ' + mall + i + '"> ' + hr_code_cpy + ' ' + mall + i + '<br>';
												HTMLoutletSuggestion += '<input type="radio" name="outlet_name_chosen" onclick="outlet_name_selected()" value="' + hr_code_cpy + ' ' + i + mall + '"> ' + hr_code_cpy + ' ' + i + mall + '<br>';
												break;
											} 
										}								

										$('#outlet_name_suggestion').empty().append(HTMLoutletSuggestion);									
										$('#outlet_name_suggestion').fadeIn('slow', function() {$(this).show();});
								}
								
								if(data[0].HR_CODE == 'none'){	
							
										$('#add_in_outlet').val(data[0].OUTLET + ' ' + mall);
										$('#add_in_city').val(data[0].CITY);
										$('#outlet_name_suggestion').hide();
								}
	
								$('#add_in_plan').val(data[0].OUTLET);
								$('#add_in_city').val(data[0].CITY);
							},
							error: function(){						
								alert('Error while request..');
							}
						});	
		});	


		
	});  /* END DOCUMENT READY FUNCT  */
