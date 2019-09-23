	function add(){
		document.getElementById("title").innerHTML = 'Add New Data <span style="color:red;font-size:9px;">*) required</span>';
		document.getElementById("btn_back_history").innerHTML = '';
		$('#changer').html('');
		$('button#submit').show();
		$('input#add_or_edit').val("add");
						/* Enable any inputs */
							$('#in_outlet').removeAttr('disabled');
							$('#in_mall').removeAttr('disabled');
							$('#in_plan').removeAttr('disabled');
							$('#in_city').removeAttr('disabled');
							$('#in_company').removeAttr('disabled');
							$('#in_opening_date').removeAttr('disabled');
							$('#in_closing_date').removeAttr('disabled');	
							$('#in_summary').removeAttr('disabled');	
							$('#in_loi').removeAttr('disabled');
							$('#in_psm').removeAttr('disabled');	
							$('#in_thn_sewa').removeAttr('disabled');	
							$('#in_mulai_sewa').removeAttr('disabled');	
							$('#in_akhir_sewa').removeAttr('disabled');	
							$('#in_opsi_sewa').removeAttr('disabled');	
							$('#in_location').removeAttr('disabled');	
							$('#in_luas_1').removeAttr('disabled');	
							$('#in_luas_2').removeAttr('disabled');	
							$('#in_luas_3').removeAttr('disabled');	
							$('#in_luas_free').removeAttr('disabled');	
							$('#in_grace_period').removeAttr('disabled');	
							$('#in_discount').removeAttr('disabled');	
							$('#in_dp').removeAttr('disabled');	
							$('#in_installment').removeAttr('disabled');	
							$('#in_rate_thn_1').removeAttr('disabled');	
							$('#in_rate_thn_2').removeAttr('disabled');	
							$('#in_rate_thn_3').removeAttr('disabled');
							$('#in_rate_thn_4').removeAttr('disabled');
							$('#in_rate_thn_5').removeAttr('disabled');	
							$('#in_rate_thn_6').removeAttr('disabled');
							$('#in_rate_thn_7').removeAttr('disabled');	
							$('#in_rate_thn_8').removeAttr('disabled');	
							$('#in_rate_thn_9').removeAttr('disabled');	
							$('#in_rate_thn_10').removeAttr('disabled');	
							$('#in_sc_thn_1').removeAttr('disabled');
							$('#in_sc_thn_2').removeAttr('disabled');	
							$('#in_sc_thn_3').removeAttr('disabled');	
							$('#in_sc_thn_4').removeAttr('disabled');	
							$('#in_sc_thn_5').removeAttr('disabled');	
							$('#in_sc_thn_6').removeAttr('disabled');
							$('#in_sc_thn_7').removeAttr('disabled');	
							$('#in_sc_thn_8').removeAttr('disabled');
							$('#in_sc_thn_9').removeAttr('disabled');	
							$('#in_sc_thn_10').removeAttr('disabled');	
							$('#in_indoor_usd_1').removeAttr('disabled');	
							$('#in_indoor_idr_1').removeAttr('disabled');	
							$('#in_outdoor_usd_1').removeAttr('disabled');	
							$('#in_outdoor_idr_1').removeAttr('disabled');	
							$('#in_indoor_usd_2').removeAttr('disabled');	
							$('#in_indoor_idr_2').removeAttr('disabled');	
							$('#in_outdoor_usd_2').removeAttr('disabled');	
							$('#in_outdoor_idr_2').removeAttr('disabled');	
							$('#in_indoor_usd_3').removeAttr('disabled');	
							$('#in_indoor_idr_3').removeAttr('disabled');	
							$('#in_outdoor_usd_3').removeAttr('disabled');	
							$('#in_outdoor_idr_3').removeAttr('disabled');	
							$('#in_indoor_usd_4').removeAttr('disabled');	
							$('#in_indoor_idr_4').removeAttr('disabled');	
							$('#in_outdoor_usd_4').removeAttr('disabled');	
							$('#in_outdoor_idr_4').removeAttr('disabled');	
							$('#in_indoor_usd_5').removeAttr('disabled');	
							$('#in_indoor_idr_5').removeAttr('disabled');	
							$('#in_outdoor_usd_5').removeAttr('disabled');	
							$('#in_outdoor_idr_5').removeAttr('disabled');
							$('#in_indoor_usd_6').removeAttr('disabled');	
							$('#in_indoor_idr_6').removeAttr('disabled');	
							$('#in_outdoor_usd_6').removeAttr('disabled');	
							$('#in_outdoor_idr_6').removeAttr('disabled');	
							$('#in_indoor_usd_7').removeAttr('disabled');	
							$('#in_indoor_idr_7').removeAttr('disabled');	
							$('#in_outdoor_usd_7').removeAttr('disabled');	
							$('#in_outdoor_idr_7').removeAttr('disabled');	
							$('#in_indoor_usd_8').removeAttr('disabled');	
							$('#in_indoor_idr_8').removeAttr('disabled');	
							$('#in_outdoor_usd_8').removeAttr('disabled');	
							$('#in_outdoor_idr_8').removeAttr('disabled');
							$('#in_indoor_usd_9').removeAttr('disabled');	
							$('#in_indoor_idr_9').removeAttr('disabled');	
							$('#in_outdoor_usd_9').removeAttr('disabled');	
							$('#in_outdoor_idr_9').removeAttr('disabled');	
							$('#in_indoor_usd_10').removeAttr('disabled');	
							$('#in_indoor_idr_10').removeAttr('disabled');	
							$('#in_outdoor_usd_10').removeAttr('disabled');
							$('#in_outdoor_idr_10').removeAttr('disabled');	
							$('#in_sc_indoor_usd').removeAttr('disabled');	
							$('#in_sc_indoor_idr').removeAttr('disabled');	
							$('#in_sc_outdoor_usd').removeAttr('disabled');	
							$('#in_sc_outdoor_idr').removeAttr('disabled');	
							$('#in_pl_month_usd').removeAttr('disabled');	
							$('#in_pl_month_idr').removeAttr('disabled');
							$('#in_pl_onetine_usd').removeAttr('disabled');	
							$('#in_pl_onetine_idr').removeAttr('disabled');	
							$('#in_singking_usd').removeAttr('disabled');	
							$('#in_singking_idr').removeAttr('disabled');
							$('#in_deposit_sewa').removeAttr('disabled');	
							$('#in_deposit_sc').removeAttr('disabled');	
							$('#in_deposit_tlp').removeAttr('disabled');	
							$('#in_deposit_inet').removeAttr('disabled');	
							$('#in_deposit_listrik').removeAttr('disabled');	
							$('#in_deposit_air').removeAttr('disabled');	
							$('#in_deposit_wallsign').removeAttr('disabled');
							$('#in_deposit_holding').removeAttr('disabled');	
							$('#in_deposit_fitout').removeAttr('disabled');	
							$('#in_total_sewa_usd').removeAttr('disabled');	
							$('#in_total_sewa_idr').removeAttr('disabled');	
							$('#in_total_sc_usd').removeAttr('disabled');	
							$('#in_total_sc_idr').removeAttr('disabled');
							$('#in_total_pl_usd').removeAttr('disabled');	
							$('#in_total_pl_idr').removeAttr('disabled');	
							$('#in_total_singking_usd').removeAttr('disabled');
							$('#in_total_singking_idr').removeAttr('disabled');
							$('#in_grand_total_usd').removeAttr('disabled');	
							$('#in_grand_total_idr').removeAttr('disabled');
							$('#in_sewa_per_bln_usd').removeAttr('disabled');	
							$('#in_sewa_per_bln_idr').removeAttr('disabled');	
							$('#in_sc_per_bln_usd').removeAttr('disabled');	
							$('#in_sc_per_bln_idr').removeAttr('disabled');	
							$('#in_pl_per_bln_usd').removeAttr('disabled');	
							$('#in_pl_per_bln_idr').removeAttr('disabled');	
							$('#in_sf_per_bln_usd').removeAttr('disabled');	
							$('#in_sf_per_bln_idr').removeAttr('disabled');	
							$('#in_total_per_bln_usd').removeAttr('disabled');
							$('#in_total_per_bln_idr').removeAttr('disabled');
							$('#in_gs_thn_sewa').removeAttr('disabled');	
							$('#in_gs_awal_sewa').removeAttr('disabled');	
							$('#in_gs_akhir_sewa').removeAttr('disabled');
							$('#in_gs_luas').removeAttr('disabled');	
							$('#in_gs_tarif_1').removeAttr('disabled');
							$('#in_gs_tarif_2').removeAttr('disabled');	
							$('#in_gs_tarif_3').removeAttr('disabled');	
							$('#in_gs_tarif_4').removeAttr('disabled');
							$('#in_gs_tarif_5').removeAttr('disabled');	
							$('#in_gs_total_biaya').removeAttr('disabled');	
							$('#in_gs_konstruksi').removeAttr('disabled');	
							$('#in_gs_polesign').removeAttr('disabled');
							$('#in_gs_wallsign').removeAttr('disabled');
							$('#in_gs_pylonsign').removeAttr('disabled');	
							$('#in_daya_listrik').removeAttr('disabled');	
							$('#in_tarif_listrik').removeAttr('disabled');
							$('#in_fasilitas').removeAttr('disabled');
							$('#in_keterangan').removeAttr('disabled');	
							$('#in_pic_perusahaan').removeAttr('disabled');	
							$('#in_pic_alamat').removeAttr('disabled');	
							$('#in_pic_tlp').removeAttr('disabled');	
							$('#in_pic_nama').removeAttr('disabled');	
							$('#in_pic_financial').removeAttr('disabled');
							$('#in_notes').removeAttr('disabled');							
						/* END Enable any inputs */
						
							$('#in_outlet').val('');
							$('#in_mall').val('');
							$('#in_plan').val('');
							$('#in_city').val('');
							$('#in_company').val('');
							$('#in_opening_date').val('');	
							$('#in_closing_date').val('');	
							$('#in_summary').val('');	
							$('#in_loi').val('');	
							$('#in_psm').val('');	
							$('#in_thn_sewa').val('');	
							$('#in_mulai_sewa').val('');	
							$('#in_akhir_sewa').val('');	
							$('#in_opsi_sewa').val('');	
							$('#in_location').val('');	
							$('#in_luas_1').val('');	
							$('#in_luas_2').val('');	
							$('#in_luas_3').val('');	
							$('#in_luas_free').val('');	
							$('#in_grace_period').val('');	
							$('#in_discount').val('');	
							$('#in_dp').val('');	
							$('#in_installment').val('');	
							$('#in_rate_thn_1').val('');	
							$('#in_rate_thn_2').val('');	
							$('#in_rate_thn_3').val('');	
							$('#in_rate_thn_4').val('');	
							$('#in_rate_thn_5').val('');	
							$('#in_rate_thn_6').val('');	
							$('#in_rate_thn_7').val('');	
							$('#in_rate_thn_8').val('');	
							$('#in_rate_thn_9').val('');	
							$('#in_rate_thn_10').val('');	
							$('#in_sc_thn_1').val('');	
							$('#in_sc_thn_2').val('');	
							$('#in_sc_thn_3').val('');	
							$('#in_sc_thn_4').val('');	
							$('#in_sc_thn_5').val('');	
							$('#in_sc_thn_6').val('');	
							$('#in_sc_thn_7').val('');	
							$('#in_sc_thn_8').val('');	
							$('#in_sc_thn_9').val('');	
							$('#in_sc_thn_10').val('');	
							$('#in_indoor_usd_1').val('');	
							$('#in_indoor_idr_1').val('');	
							$('#in_outdoor_usd_1').val('');	
							$('#in_outdoor_idr_1').val('');	
							$('#in_indoor_usd_2').val('');	
							$('#in_indoor_idr_2').val('');	
							$('#in_outdoor_usd_2').val('');	
							$('#in_outdoor_idr_2').val('');	
							$('#in_indoor_usd_3').val('');	
							$('#in_indoor_idr_3').val('');	
							$('#in_outdoor_usd_3').val('');	
							$('#in_outdoor_idr_3').val('');	
							$('#in_indoor_usd_4').val('');	
							$('#in_indoor_idr_4').val('');	
							$('#in_outdoor_usd_4').val('');	
							$('#in_outdoor_idr_4').val('');	
							$('#in_indoor_usd_5').val('');	
							$('#in_indoor_idr_5').val('');	
							$('#in_outdoor_usd_5').val('');	
							$('#in_outdoor_idr_5').val('');	
							$('#in_indoor_usd_6').val('');	
							$('#in_indoor_idr_6').val('');	
							$('#in_outdoor_usd_6').val('');	
							$('#in_outdoor_idr_6').val('');	
							$('#in_indoor_usd_7').val('');	
							$('#in_indoor_idr_7').val('');	
							$('#in_outdoor_usd_7').val('');	
							$('#in_outdoor_idr_7').val('');	
							$('#in_indoor_usd_8').val('');	
							$('#in_indoor_idr_8').val('');	
							$('#in_outdoor_usd_8').val('');	
							$('#in_outdoor_idr_8').val('');	
							$('#in_indoor_usd_9').val('');	
							$('#in_indoor_idr_9').val('');	
							$('#in_outdoor_usd_9').val('');	
							$('#in_outdoor_idr_9').val('');	
							$('#in_indoor_usd_10').val('');	
							$('#in_indoor_idr_10').val('');	
							$('#in_outdoor_usd_10').val('');	
							$('#in_outdoor_idr_10').val('');	
							$('#in_sc_indoor_usd').val('');	
							$('#in_sc_indoor_idr').val('');	
							$('#in_sc_outdoor_usd').val('');	
							$('#in_sc_outdoor_idr').val('');	
							$('#in_pl_month_usd').val('');	
							$('#in_pl_month_idr').val('');	
							$('#in_pl_onetine_usd').val('');	
							$('#in_pl_onetine_idr').val('');	
							$('#in_singking_usd').val('');	
							$('#in_singking_idr').val('');	
							$('#in_deposit_sewa').val('');	
							$('#in_deposit_sc').val('');	
							$('#in_deposit_tlp').val('');	
							$('#in_deposit_inet').val('');	
							$('#in_deposit_listrik').val('');	
							$('#in_deposit_air').val('');	
							$('#in_deposit_wallsign').val('');	
							$('#in_deposit_holding').val('');	
							$('#in_deposit_fitout').val('');	
							$('#in_total_sewa_usd').val('');	
							$('#in_total_sewa_idr').val('');	
							$('#in_total_sc_usd').val('');	
							$('#in_total_sc_idr').val('');	
							$('#in_total_pl_usd').val('');	
							$('#in_total_pl_idr').val('');	
							$('#in_total_singking_usd').val('');	
							$('#in_total_singking_idr').val('');	
							$('#in_grand_total_usd').val('');	
							$('#in_grand_total_idr').val('');	
							$('#in_sewa_per_bln_usd').val('');	
							$('#in_sewa_per_bln_idr').val('');	
							$('#in_sc_per_bln_usd').val('');	
							$('#in_sc_per_bln_idr').val('');	
							$('#in_pl_per_bln_usd').val('');	
							$('#in_pl_per_bln_idr').val('');	
							$('#in_sf_per_bln_usd').val('');	
							$('#in_sf_per_bln_idr').val('');	
							$('#in_total_per_bln_usd').val('');	
							$('#in_total_per_bln_idr').val('');	
							$('#in_gs_thn_sewa').val('');	
							$('#in_gs_awal_sewa').val('');	
							$('#in_gs_akhir_sewa').val('');	
							$('#in_gs_luas').val('');	
							$('#in_gs_tarif_1').val('');	
							$('#in_gs_tarif_2').val('');	
							$('#in_gs_tarif_3').val('');	
							$('#in_gs_tarif_4').val('');	
							$('#in_gs_tarif_5').val('');	
							$('#in_gs_total_biaya').val('');	
							$('#in_gs_konstruksi').val('');	
							$('#in_gs_polesign').val('');	
							$('#in_gs_wallsign').val('');	
							$('#in_gs_pylonsign').val('');	
							$('#in_daya_listrik').val('');	
							$('#in_tarif_listrik').val('');	
							$('#in_fasilitas').val('');	
							$('#in_keterangan').val('');	
							$('#in_pic_perusahaan').val('');	
							$('#in_pic_alamat').val('');	
							$('#in_pic_tlp').val('');	
							$('#in_pic_nama').val('');	
							$('#in_pic_financial').val('');										
							$('#in_notes').val('');
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
						/* Disable any inputs */
							$('#in_outlet').attr('disabled','disabled');
							$('#in_mall').attr('disabled','disabled');
							$('#in_plan').attr('disabled','disabled');
							$('#in_city').attr('disabled','disabled');
							$('#in_company').attr('disabled','disabled');
							$('#in_opening_date').attr('disabled','disabled');
							$('#in_closing_date').attr('disabled','disabled');	
							$('#in_summary').attr('disabled','disabled');	
							$('#in_loi').attr('disabled','disabled');
							$('#in_psm').attr('disabled','disabled');	
							$('#in_thn_sewa').attr('disabled','disabled');	
							$('#in_mulai_sewa').attr('disabled','disabled');	
							$('#in_akhir_sewa').attr('disabled','disabled');	
							$('#in_opsi_sewa').attr('disabled','disabled');	
							$('#in_location').attr('disabled','disabled');	
							$('#in_luas_1').attr('disabled','disabled');	
							$('#in_luas_2').attr('disabled','disabled');	
							$('#in_luas_3').attr('disabled','disabled');	
							$('#in_luas_free').attr('disabled','disabled');	
							$('#in_grace_period').attr('disabled','disabled');	
							$('#in_discount').attr('disabled','disabled');	
							$('#in_dp').attr('disabled','disabled');	
							$('#in_installment').attr('disabled','disabled');	
							$('#in_rate_thn_1').attr('disabled','disabled');	
							$('#in_rate_thn_2').attr('disabled','disabled');	
							$('#in_rate_thn_3').attr('disabled','disabled');
							$('#in_rate_thn_4').attr('disabled','disabled');
							$('#in_rate_thn_5').attr('disabled','disabled');	
							$('#in_rate_thn_6').attr('disabled','disabled');
							$('#in_rate_thn_7').attr('disabled','disabled');	
							$('#in_rate_thn_8').attr('disabled','disabled');	
							$('#in_rate_thn_9').attr('disabled','disabled');	
							$('#in_rate_thn_10').attr('disabled','disabled');	
							$('#in_sc_thn_1').attr('disabled','disabled');
							$('#in_sc_thn_2').attr('disabled','disabled');	
							$('#in_sc_thn_3').attr('disabled','disabled');	
							$('#in_sc_thn_4').attr('disabled','disabled');	
							$('#in_sc_thn_5').attr('disabled','disabled');	
							$('#in_sc_thn_6').attr('disabled','disabled');
							$('#in_sc_thn_7').attr('disabled','disabled');	
							$('#in_sc_thn_8').attr('disabled','disabled');
							$('#in_sc_thn_9').attr('disabled','disabled');	
							$('#in_sc_thn_10').attr('disabled','disabled');	
							$('#in_indoor_usd_1').attr('disabled','disabled');	
							$('#in_indoor_idr_1').attr('disabled','disabled');	
							$('#in_outdoor_usd_1').attr('disabled','disabled');	
							$('#in_outdoor_idr_1').attr('disabled','disabled');	
							$('#in_indoor_usd_2').attr('disabled','disabled');	
							$('#in_indoor_idr_2').attr('disabled','disabled');	
							$('#in_outdoor_usd_2').attr('disabled','disabled');	
							$('#in_outdoor_idr_2').attr('disabled','disabled');	
							$('#in_indoor_usd_3').attr('disabled','disabled');	
							$('#in_indoor_idr_3').attr('disabled','disabled');	
							$('#in_outdoor_usd_3').attr('disabled','disabled');	
							$('#in_outdoor_idr_3').attr('disabled','disabled');	
							$('#in_indoor_usd_4').attr('disabled','disabled');	
							$('#in_indoor_idr_4').attr('disabled','disabled');	
							$('#in_outdoor_usd_4').attr('disabled','disabled');	
							$('#in_outdoor_idr_4').attr('disabled','disabled');	
							$('#in_indoor_usd_5').attr('disabled','disabled');	
							$('#in_indoor_idr_5').attr('disabled','disabled');	
							$('#in_outdoor_usd_5').attr('disabled','disabled');	
							$('#in_outdoor_idr_5').attr('disabled','disabled');
							$('#in_indoor_usd_6').attr('disabled','disabled');	
							$('#in_indoor_idr_6').attr('disabled','disabled');	
							$('#in_outdoor_usd_6').attr('disabled','disabled');	
							$('#in_outdoor_idr_6').attr('disabled','disabled');	
							$('#in_indoor_usd_7').attr('disabled','disabled');	
							$('#in_indoor_idr_7').attr('disabled','disabled');	
							$('#in_outdoor_usd_7').attr('disabled','disabled');	
							$('#in_outdoor_idr_7').attr('disabled','disabled');	
							$('#in_indoor_usd_8').attr('disabled','disabled');	
							$('#in_indoor_idr_8').attr('disabled','disabled');	
							$('#in_outdoor_usd_8').attr('disabled','disabled');	
							$('#in_outdoor_idr_8').attr('disabled','disabled');
							$('#in_indoor_usd_9').attr('disabled','disabled');	
							$('#in_indoor_idr_9').attr('disabled','disabled');	
							$('#in_outdoor_usd_9').attr('disabled','disabled');	
							$('#in_outdoor_idr_9').attr('disabled','disabled');	
							$('#in_indoor_usd_10').attr('disabled','disabled');	
							$('#in_indoor_idr_10').attr('disabled','disabled');	
							$('#in_outdoor_usd_10').attr('disabled','disabled');
							$('#in_outdoor_idr_10').attr('disabled','disabled');	
							$('#in_sc_indoor_usd').attr('disabled','disabled');	
							$('#in_sc_indoor_idr').attr('disabled','disabled');	
							$('#in_sc_outdoor_usd').attr('disabled','disabled');	
							$('#in_sc_outdoor_idr').attr('disabled','disabled');	
							$('#in_pl_month_usd').attr('disabled','disabled');	
							$('#in_pl_month_idr').attr('disabled','disabled');
							$('#in_pl_onetine_usd').attr('disabled','disabled');	
							$('#in_pl_onetine_idr').attr('disabled','disabled');	
							$('#in_singking_usd').attr('disabled','disabled');	
							$('#in_singking_idr').attr('disabled','disabled');
							$('#in_deposit_sewa').attr('disabled','disabled');	
							$('#in_deposit_sc').attr('disabled','disabled');	
							$('#in_deposit_tlp').attr('disabled','disabled');	
							$('#in_deposit_inet').attr('disabled','disabled');	
							$('#in_deposit_listrik').attr('disabled','disabled');	
							$('#in_deposit_air').attr('disabled','disabled');	
							$('#in_deposit_wallsign').attr('disabled','disabled');
							$('#in_deposit_holding').attr('disabled','disabled');	
							$('#in_deposit_fitout').attr('disabled','disabled');	
							$('#in_total_sewa_usd').attr('disabled','disabled');	
							$('#in_total_sewa_idr').attr('disabled','disabled');	
							$('#in_total_sc_usd').attr('disabled','disabled');	
							$('#in_total_sc_idr').attr('disabled','disabled');
							$('#in_total_pl_usd').attr('disabled','disabled');	
							$('#in_total_pl_idr').attr('disabled','disabled');	
							$('#in_total_singking_usd').attr('disabled','disabled');
							$('#in_total_singking_idr').attr('disabled','disabled');
							$('#in_grand_total_usd').attr('disabled','disabled');	
							$('#in_grand_total_idr').attr('disabled','disabled');
							$('#in_sewa_per_bln_usd').attr('disabled','disabled');	
							$('#in_sewa_per_bln_idr').attr('disabled','disabled');	
							$('#in_sc_per_bln_usd').attr('disabled','disabled');	
							$('#in_sc_per_bln_idr').attr('disabled','disabled');	
							$('#in_pl_per_bln_usd').attr('disabled','disabled');	
							$('#in_pl_per_bln_idr').attr('disabled','disabled');	
							$('#in_sf_per_bln_usd').attr('disabled','disabled');	
							$('#in_sf_per_bln_idr').attr('disabled','disabled');	
							$('#in_total_per_bln_usd').attr('disabled','disabled');
							$('#in_total_per_bln_idr').attr('disabled','disabled');
							$('#in_gs_thn_sewa').attr('disabled','disabled');	
							$('#in_gs_awal_sewa').attr('disabled','disabled');	
							$('#in_gs_akhir_sewa').attr('disabled','disabled');
							$('#in_gs_luas').attr('disabled','disabled');	
							$('#in_gs_tarif_1').attr('disabled','disabled');
							$('#in_gs_tarif_2').attr('disabled','disabled');	
							$('#in_gs_tarif_3').attr('disabled','disabled');	
							$('#in_gs_tarif_4').attr('disabled','disabled');
							$('#in_gs_tarif_5').attr('disabled','disabled');	
							$('#in_gs_total_biaya').attr('disabled','disabled');	
							$('#in_gs_konstruksi').attr('disabled','disabled');	
							$('#in_gs_polesign').attr('disabled','disabled');
							$('#in_gs_wallsign').attr('disabled','disabled');
							$('#in_gs_pylonsign').attr('disabled','disabled');	
							$('#in_daya_listrik').attr('disabled','disabled');	
							$('#in_tarif_listrik').attr('disabled','disabled');
							$('#in_fasilitas').attr('disabled','disabled');
							$('#in_keterangan').attr('disabled','disabled');	
							$('#in_pic_perusahaan').attr('disabled','disabled');	
							$('#in_pic_alamat').attr('disabled','disabled');	
							$('#in_pic_tlp').attr('disabled','disabled');	
							$('#in_pic_nama').attr('disabled','disabled');	
							$('#in_pic_financial').attr('disabled','disabled');	
							$('#in_notes').attr('disabled','disabled');	
						/* END Disable any inputs */
						
							$('#row_id').val(data.history_item[0]['ID']);
							$('#in_outlet').val(data.history_item[0]['SEWA_OUTLET']);
							$('#in_mall').val(data.history_item[0]['SEWA_MALL']);
							$('#in_plan').val(data.history_item[0]['SEWA_PLAN']);
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
		var r 		= time.split(" ");
		var date 	= r[0].split("-");
		return date[1] + '/' + date[2] + '/' + date[0];
	}

	function showDueDateItem(idd){
		document.getElementById("btn_back_history").innerHTML = '<a onclick="showHistory()" data-toggle="modal" href="#change-modal" style="text-decoration:none;" class="btn" data-dismiss="modal">Back</a>';
		document.getElementById("title").innerHTML = 'Due Date Detail ';
		$('#changer').html('');
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
						/* Disable any inputs */
							$('#in_outlet').attr('disabled','disabled');
							$('#in_mall').attr('disabled','disabled');
							$('#in_plan').attr('disabled','disabled');
							$('#in_city').attr('disabled','disabled');
							$('#in_company').attr('disabled','disabled');
							$('#in_opening_date').attr('disabled','disabled');
							$('#in_closing_date').attr('disabled','disabled');	
							$('#in_summary').attr('disabled','disabled');	
							$('#in_loi').attr('disabled','disabled');
							$('#in_psm').attr('disabled','disabled');	
							$('#in_thn_sewa').attr('disabled','disabled');	
							$('#in_mulai_sewa').attr('disabled','disabled');	
							$('#in_akhir_sewa').attr('disabled','disabled');	
							$('#in_opsi_sewa').attr('disabled','disabled');	
							$('#in_location').attr('disabled','disabled');	
							$('#in_luas_1').attr('disabled','disabled');	
							$('#in_luas_2').attr('disabled','disabled');	
							$('#in_luas_3').attr('disabled','disabled');	
							$('#in_luas_free').attr('disabled','disabled');	
							$('#in_grace_period').attr('disabled','disabled');	
							$('#in_discount').attr('disabled','disabled');	
							$('#in_dp').attr('disabled','disabled');	
							$('#in_installment').attr('disabled','disabled');	
							$('#in_rate_thn_1').attr('disabled','disabled');	
							$('#in_rate_thn_2').attr('disabled','disabled');	
							$('#in_rate_thn_3').attr('disabled','disabled');
							$('#in_rate_thn_4').attr('disabled','disabled');
							$('#in_rate_thn_5').attr('disabled','disabled');	
							$('#in_rate_thn_6').attr('disabled','disabled');
							$('#in_rate_thn_7').attr('disabled','disabled');	
							$('#in_rate_thn_8').attr('disabled','disabled');	
							$('#in_rate_thn_9').attr('disabled','disabled');	
							$('#in_rate_thn_10').attr('disabled','disabled');	
							$('#in_sc_thn_1').attr('disabled','disabled');
							$('#in_sc_thn_2').attr('disabled','disabled');	
							$('#in_sc_thn_3').attr('disabled','disabled');	
							$('#in_sc_thn_4').attr('disabled','disabled');	
							$('#in_sc_thn_5').attr('disabled','disabled');	
							$('#in_sc_thn_6').attr('disabled','disabled');
							$('#in_sc_thn_7').attr('disabled','disabled');	
							$('#in_sc_thn_8').attr('disabled','disabled');
							$('#in_sc_thn_9').attr('disabled','disabled');	
							$('#in_sc_thn_10').attr('disabled','disabled');	
							$('#in_indoor_usd_1').attr('disabled','disabled');	
							$('#in_indoor_idr_1').attr('disabled','disabled');	
							$('#in_outdoor_usd_1').attr('disabled','disabled');	
							$('#in_outdoor_idr_1').attr('disabled','disabled');	
							$('#in_indoor_usd_2').attr('disabled','disabled');	
							$('#in_indoor_idr_2').attr('disabled','disabled');	
							$('#in_outdoor_usd_2').attr('disabled','disabled');	
							$('#in_outdoor_idr_2').attr('disabled','disabled');	
							$('#in_indoor_usd_3').attr('disabled','disabled');	
							$('#in_indoor_idr_3').attr('disabled','disabled');	
							$('#in_outdoor_usd_3').attr('disabled','disabled');	
							$('#in_outdoor_idr_3').attr('disabled','disabled');	
							$('#in_indoor_usd_4').attr('disabled','disabled');	
							$('#in_indoor_idr_4').attr('disabled','disabled');	
							$('#in_outdoor_usd_4').attr('disabled','disabled');	
							$('#in_outdoor_idr_4').attr('disabled','disabled');	
							$('#in_indoor_usd_5').attr('disabled','disabled');	
							$('#in_indoor_idr_5').attr('disabled','disabled');	
							$('#in_outdoor_usd_5').attr('disabled','disabled');	
							$('#in_outdoor_idr_5').attr('disabled','disabled');
							$('#in_indoor_usd_6').attr('disabled','disabled');	
							$('#in_indoor_idr_6').attr('disabled','disabled');	
							$('#in_outdoor_usd_6').attr('disabled','disabled');	
							$('#in_outdoor_idr_6').attr('disabled','disabled');	
							$('#in_indoor_usd_7').attr('disabled','disabled');	
							$('#in_indoor_idr_7').attr('disabled','disabled');	
							$('#in_outdoor_usd_7').attr('disabled','disabled');	
							$('#in_outdoor_idr_7').attr('disabled','disabled');	
							$('#in_indoor_usd_8').attr('disabled','disabled');	
							$('#in_indoor_idr_8').attr('disabled','disabled');	
							$('#in_outdoor_usd_8').attr('disabled','disabled');	
							$('#in_outdoor_idr_8').attr('disabled','disabled');
							$('#in_indoor_usd_9').attr('disabled','disabled');	
							$('#in_indoor_idr_9').attr('disabled','disabled');	
							$('#in_outdoor_usd_9').attr('disabled','disabled');	
							$('#in_outdoor_idr_9').attr('disabled','disabled');	
							$('#in_indoor_usd_10').attr('disabled','disabled');	
							$('#in_indoor_idr_10').attr('disabled','disabled');	
							$('#in_outdoor_usd_10').attr('disabled','disabled');
							$('#in_outdoor_idr_10').attr('disabled','disabled');	
							$('#in_sc_indoor_usd').attr('disabled','disabled');	
							$('#in_sc_indoor_idr').attr('disabled','disabled');	
							$('#in_sc_outdoor_usd').attr('disabled','disabled');	
							$('#in_sc_outdoor_idr').attr('disabled','disabled');	
							$('#in_pl_month_usd').attr('disabled','disabled');	
							$('#in_pl_month_idr').attr('disabled','disabled');
							$('#in_pl_onetine_usd').attr('disabled','disabled');	
							$('#in_pl_onetine_idr').attr('disabled','disabled');	
							$('#in_singking_usd').attr('disabled','disabled');	
							$('#in_singking_idr').attr('disabled','disabled');
							$('#in_deposit_sewa').attr('disabled','disabled');	
							$('#in_deposit_sc').attr('disabled','disabled');	
							$('#in_deposit_tlp').attr('disabled','disabled');	
							$('#in_deposit_inet').attr('disabled','disabled');	
							$('#in_deposit_listrik').attr('disabled','disabled');	
							$('#in_deposit_air').attr('disabled','disabled');	
							$('#in_deposit_wallsign').attr('disabled','disabled');
							$('#in_deposit_holding').attr('disabled','disabled');	
							$('#in_deposit_fitout').attr('disabled','disabled');	
							$('#in_total_sewa_usd').attr('disabled','disabled');	
							$('#in_total_sewa_idr').attr('disabled','disabled');	
							$('#in_total_sc_usd').attr('disabled','disabled');	
							$('#in_total_sc_idr').attr('disabled','disabled');
							$('#in_total_pl_usd').attr('disabled','disabled');	
							$('#in_total_pl_idr').attr('disabled','disabled');	
							$('#in_total_singking_usd').attr('disabled','disabled');
							$('#in_total_singking_idr').attr('disabled','disabled');
							$('#in_grand_total_usd').attr('disabled','disabled');	
							$('#in_grand_total_idr').attr('disabled','disabled');
							$('#in_sewa_per_bln_usd').attr('disabled','disabled');	
							$('#in_sewa_per_bln_idr').attr('disabled','disabled');	
							$('#in_sc_per_bln_usd').attr('disabled','disabled');	
							$('#in_sc_per_bln_idr').attr('disabled','disabled');	
							$('#in_pl_per_bln_usd').attr('disabled','disabled');	
							$('#in_pl_per_bln_idr').attr('disabled','disabled');	
							$('#in_sf_per_bln_usd').attr('disabled','disabled');	
							$('#in_sf_per_bln_idr').attr('disabled','disabled');	
							$('#in_total_per_bln_usd').attr('disabled','disabled');
							$('#in_total_per_bln_idr').attr('disabled','disabled');
							$('#in_gs_thn_sewa').attr('disabled','disabled');	
							$('#in_gs_awal_sewa').attr('disabled','disabled');	
							$('#in_gs_akhir_sewa').attr('disabled','disabled');
							$('#in_gs_luas').attr('disabled','disabled');	
							$('#in_gs_tarif_1').attr('disabled','disabled');
							$('#in_gs_tarif_2').attr('disabled','disabled');	
							$('#in_gs_tarif_3').attr('disabled','disabled');	
							$('#in_gs_tarif_4').attr('disabled','disabled');
							$('#in_gs_tarif_5').attr('disabled','disabled');	
							$('#in_gs_total_biaya').attr('disabled','disabled');	
							$('#in_gs_konstruksi').attr('disabled','disabled');	
							$('#in_gs_polesign').attr('disabled','disabled');
							$('#in_gs_wallsign').attr('disabled','disabled');
							$('#in_gs_pylonsign').attr('disabled','disabled');	
							$('#in_daya_listrik').attr('disabled','disabled');	
							$('#in_tarif_listrik').attr('disabled','disabled');
							$('#in_fasilitas').attr('disabled','disabled');
							$('#in_keterangan').attr('disabled','disabled');	
							$('#in_pic_perusahaan').attr('disabled','disabled');	
							$('#in_pic_alamat').attr('disabled','disabled');	
							$('#in_pic_tlp').attr('disabled','disabled');	
							$('#in_pic_nama').attr('disabled','disabled');	
							$('#in_pic_financial').attr('disabled','disabled');	
							$('#in_notes').attr('disabled','disabled');	
						/* END Disable any inputs */
						
							$('#row_id').val(data.sewa_mall[0]['ID']);
							$('#in_outlet').val(data.sewa_mall[0]['SEWA_OUTLET']);
							$('#in_mall').val(data.sewa_mall[0]['SEWA_MALL']);
							$('#in_plan').val(data.sewa_mall[0]['SEWA_PLAN']);
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
						$('#history_title').empty().append('Due date list');	
						$("#history_table_container").empty().append(html);	
						$('#change-modal').modal();						
					},
					error: function(msg){
						alert(msg.statusText);
						return msg;
					}
				});		
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
								"targets": -146,
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
		
		/*
			"scrollX": true,
			"bDestroy": true,
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "browse_complete_data",
			"sAjaxDataProp": "data",
            "sPaginationType": "full_numbers",
			"iDisplayStart": 0,
            "aoColumns": [
                        { mData: 'ID' },
                        { mData: 'SEWA_OUTLET' },
                        { mData: 'SEWA_MALL' },
                        { mData: 'SEWA_PLAN' },
                        { mData: 'SEWA_CITY' }						
                ],			
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
			}		*/
		});	  

		/*******************  Set warning 1st time page load  *******************/
		setTimeout(function() {
			show_attention();
		},5000);		
		
		/*******************  Edit a Row  *******************/
		$('#gridTable tbody').on( 'click', 'img#edit', function () {
			var tr = $(this).closest('tr');
			var idd = tr.find('.sorting_1').text();	
			document.getElementById("title").innerHTML = 'Edit Data <span style="color:red;font-size:9px;">*) required</span>';
			document.getElementById("btn_back_history").innerHTML = '';
			$('#changer').html('');
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
							/* Enable any inputs */
								$('#in_outlet').removeAttr('disabled');
								$('#in_mall').removeAttr('disabled');
								$('#in_plan').removeAttr('disabled');
								$('#in_city').removeAttr('disabled');
								$('#in_company').removeAttr('disabled');
								$('#in_opening_date').removeAttr('disabled');
								$('#in_closing_date').removeAttr('disabled');	
								$('#in_summary').removeAttr('disabled');	
								$('#in_loi').removeAttr('disabled');
								$('#in_psm').removeAttr('disabled');	
								$('#in_thn_sewa').removeAttr('disabled');	
								$('#in_mulai_sewa').removeAttr('disabled');	
								$('#in_akhir_sewa').removeAttr('disabled');	
								$('#in_opsi_sewa').removeAttr('disabled');	
								$('#in_location').removeAttr('disabled');	
								$('#in_luas_1').removeAttr('disabled');	
								$('#in_luas_2').removeAttr('disabled');	
								$('#in_luas_3').removeAttr('disabled');	
								$('#in_luas_free').removeAttr('disabled');	
								$('#in_grace_period').removeAttr('disabled');	
								$('#in_discount').removeAttr('disabled');	
								$('#in_dp').removeAttr('disabled');	
								$('#in_installment').removeAttr('disabled');	
								$('#in_rate_thn_1').removeAttr('disabled');	
								$('#in_rate_thn_2').removeAttr('disabled');	
								$('#in_rate_thn_3').removeAttr('disabled');
								$('#in_rate_thn_4').removeAttr('disabled');
								$('#in_rate_thn_5').removeAttr('disabled');	
								$('#in_rate_thn_6').removeAttr('disabled');
								$('#in_rate_thn_7').removeAttr('disabled');	
								$('#in_rate_thn_8').removeAttr('disabled');	
								$('#in_rate_thn_9').removeAttr('disabled');	
								$('#in_rate_thn_10').removeAttr('disabled');	
								$('#in_sc_thn_1').removeAttr('disabled');
								$('#in_sc_thn_2').removeAttr('disabled');	
								$('#in_sc_thn_3').removeAttr('disabled');	
								$('#in_sc_thn_4').removeAttr('disabled');	
								$('#in_sc_thn_5').removeAttr('disabled');	
								$('#in_sc_thn_6').removeAttr('disabled');
								$('#in_sc_thn_7').removeAttr('disabled');	
								$('#in_sc_thn_8').removeAttr('disabled');
								$('#in_sc_thn_9').removeAttr('disabled');	
								$('#in_sc_thn_10').removeAttr('disabled');	
								$('#in_indoor_usd_1').removeAttr('disabled');	
								$('#in_indoor_idr_1').removeAttr('disabled');	
								$('#in_outdoor_usd_1').removeAttr('disabled');	
								$('#in_outdoor_idr_1').removeAttr('disabled');	
								$('#in_indoor_usd_2').removeAttr('disabled');	
								$('#in_indoor_idr_2').removeAttr('disabled');	
								$('#in_outdoor_usd_2').removeAttr('disabled');	
								$('#in_outdoor_idr_2').removeAttr('disabled');	
								$('#in_indoor_usd_3').removeAttr('disabled');	
								$('#in_indoor_idr_3').removeAttr('disabled');	
								$('#in_outdoor_usd_3').removeAttr('disabled');	
								$('#in_outdoor_idr_3').removeAttr('disabled');	
								$('#in_indoor_usd_4').removeAttr('disabled');	
								$('#in_indoor_idr_4').removeAttr('disabled');	
								$('#in_outdoor_usd_4').removeAttr('disabled');	
								$('#in_outdoor_idr_4').removeAttr('disabled');	
								$('#in_indoor_usd_5').removeAttr('disabled');	
								$('#in_indoor_idr_5').removeAttr('disabled');	
								$('#in_outdoor_usd_5').removeAttr('disabled');	
								$('#in_outdoor_idr_5').removeAttr('disabled');
								$('#in_indoor_usd_6').removeAttr('disabled');	
								$('#in_indoor_idr_6').removeAttr('disabled');	
								$('#in_outdoor_usd_6').removeAttr('disabled');	
								$('#in_outdoor_idr_6').removeAttr('disabled');	
								$('#in_indoor_usd_7').removeAttr('disabled');	
								$('#in_indoor_idr_7').removeAttr('disabled');	
								$('#in_outdoor_usd_7').removeAttr('disabled');	
								$('#in_outdoor_idr_7').removeAttr('disabled');	
								$('#in_indoor_usd_8').removeAttr('disabled');	
								$('#in_indoor_idr_8').removeAttr('disabled');	
								$('#in_outdoor_usd_8').removeAttr('disabled');	
								$('#in_outdoor_idr_8').removeAttr('disabled');
								$('#in_indoor_usd_9').removeAttr('disabled');	
								$('#in_indoor_idr_9').removeAttr('disabled');	
								$('#in_outdoor_usd_9').removeAttr('disabled');	
								$('#in_outdoor_idr_9').removeAttr('disabled');	
								$('#in_indoor_usd_10').removeAttr('disabled');	
								$('#in_indoor_idr_10').removeAttr('disabled');	
								$('#in_outdoor_usd_10').removeAttr('disabled');
								$('#in_outdoor_idr_10').removeAttr('disabled');	
								$('#in_sc_indoor_usd').removeAttr('disabled');	
								$('#in_sc_indoor_idr').removeAttr('disabled');	
								$('#in_sc_outdoor_usd').removeAttr('disabled');	
								$('#in_sc_outdoor_idr').removeAttr('disabled');	
								$('#in_pl_month_usd').removeAttr('disabled');	
								$('#in_pl_month_idr').removeAttr('disabled');
								$('#in_pl_onetine_usd').removeAttr('disabled');	
								$('#in_pl_onetine_idr').removeAttr('disabled');	
								$('#in_singking_usd').removeAttr('disabled');	
								$('#in_singking_idr').removeAttr('disabled');
								$('#in_deposit_sewa').removeAttr('disabled');	
								$('#in_deposit_sc').removeAttr('disabled');	
								$('#in_deposit_tlp').removeAttr('disabled');	
								$('#in_deposit_inet').removeAttr('disabled');	
								$('#in_deposit_listrik').removeAttr('disabled');	
								$('#in_deposit_air').removeAttr('disabled');	
								$('#in_deposit_wallsign').removeAttr('disabled');
								$('#in_deposit_holding').removeAttr('disabled');	
								$('#in_deposit_fitout').removeAttr('disabled');	
								$('#in_total_sewa_usd').removeAttr('disabled');	
								$('#in_total_sewa_idr').removeAttr('disabled');	
								$('#in_total_sc_usd').removeAttr('disabled');	
								$('#in_total_sc_idr').removeAttr('disabled');
								$('#in_total_pl_usd').removeAttr('disabled');	
								$('#in_total_pl_idr').removeAttr('disabled');	
								$('#in_total_singking_usd').removeAttr('disabled');
								$('#in_total_singking_idr').removeAttr('disabled');
								$('#in_grand_total_usd').removeAttr('disabled');	
								$('#in_grand_total_idr').removeAttr('disabled');
								$('#in_sewa_per_bln_usd').removeAttr('disabled');	
								$('#in_sewa_per_bln_idr').removeAttr('disabled');	
								$('#in_sc_per_bln_usd').removeAttr('disabled');	
								$('#in_sc_per_bln_idr').removeAttr('disabled');	
								$('#in_pl_per_bln_usd').removeAttr('disabled');	
								$('#in_pl_per_bln_idr').removeAttr('disabled');	
								$('#in_sf_per_bln_usd').removeAttr('disabled');	
								$('#in_sf_per_bln_idr').removeAttr('disabled');	
								$('#in_total_per_bln_usd').removeAttr('disabled');
								$('#in_total_per_bln_idr').removeAttr('disabled');
								$('#in_gs_thn_sewa').removeAttr('disabled');	
								$('#in_gs_awal_sewa').removeAttr('disabled');	
								$('#in_gs_akhir_sewa').removeAttr('disabled');
								$('#in_gs_luas').removeAttr('disabled');	
								$('#in_gs_tarif_1').removeAttr('disabled');
								$('#in_gs_tarif_2').removeAttr('disabled');	
								$('#in_gs_tarif_3').removeAttr('disabled');	
								$('#in_gs_tarif_4').removeAttr('disabled');
								$('#in_gs_tarif_5').removeAttr('disabled');	
								$('#in_gs_total_biaya').removeAttr('disabled');	
								$('#in_gs_konstruksi').removeAttr('disabled');	
								$('#in_gs_polesign').removeAttr('disabled');
								$('#in_gs_wallsign').removeAttr('disabled');
								$('#in_gs_pylonsign').removeAttr('disabled');	
								$('#in_daya_listrik').removeAttr('disabled');	
								$('#in_tarif_listrik').removeAttr('disabled');
								$('#in_fasilitas').removeAttr('disabled');
								$('#in_keterangan').removeAttr('disabled');	
								$('#in_pic_perusahaan').removeAttr('disabled');	
								$('#in_pic_alamat').removeAttr('disabled');	
								$('#in_pic_tlp').removeAttr('disabled');	
								$('#in_pic_nama').removeAttr('disabled');	
								$('#in_pic_financial').removeAttr('disabled');	
								$('#in_notes').removeAttr('disabled');
							/* END Enable any inputs */
							
								$('#row_id').val(data.sewa_mall[0]['ID']);
								$('#in_outlet').val(data.sewa_mall[0]['SEWA_OUTLET']);
								$('#in_mall').val(data.sewa_mall[0]['SEWA_MALL']);
								$('#in_plan').val(data.sewa_mall[0]['SEWA_PLAN']);
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
							},
							error: function(){						
								alert('Error while request..');
							}
						});				
								
		});	
		
		/*******************  Delete a Row  *******************/
		$('#gridTable tbody').on( 'click', 'img#delete', function () {
			var tr = $(this).closest('tr');
			var id = tr.find('.sorting_1').text();			
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
			var tr = $(this).closest('tr');
			var id = tr.find('.sorting_1').text();			
			$('#id_history').val(id);
			$('#history_title').empty().append('Changes history - ');
			/*$('#outlet_name').html(mall);*/
				$.ajax({
					type: "POST",
					url: 'show_sewa_history',
					data: {outletId : id},
					dataType: "HTML",
					success: function(html){
						$("#history_table_container").empty().append(html);				
						$('#history_table').dataTable( {
							"scrollX": true,
							"bDestroy": true
						});	
					},
					error: function(msg){
						alert(msg.statusText);
						return msg;
					}

				});			
		} );		

		
		$("#in_opening_date").focus(function(){
			$('#in_opening_date').datepick();
		});	
		$("#in_closing_date").focus(function(){
			$('#in_closing_date').datepick();
		});	
		$("#in_summary").focus(function(){
			$('#in_summary').datepick();
		});	
		$("#in_loi").focus(function(){
			$('#in_loi').datepick();
		});	
		$("#in_psm").focus(function(){
			$('#in_psm').datepick();
		});	
		$("#in_mulai_sewa").focus(function(){
			$('#in_mulai_sewa').datepick();
		});			
		$("#in_akhir_sewa").focus(function(){
			$('#in_akhir_sewa').datepick();
		});			
		$("#in_gs_awal_sewa").focus(function(){
			$('#in_gs_awal_sewa').datepick();
		});			
		$("#in_gs_akhir_sewa").focus(function(){
			$('#in_gs_akhir_sewa').datepick();
		});			

		/*******************  Submit Data For Add and Edit  *******************/
		$("#submit").click(function(){
				var add_or_edit	=		$('input#add_or_edit').val();
				
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
	});  
